<?php
namespace app\api\controller;
use app\common\model\Order as OrderModel;
use app\common\model\App as AppModel;
use app\common\model\Cart as CartModel;
use app\common\model\AppPrepayId as AppPrepayIdModel;
use app\common\library\wechat\WxPay;
use think\Exception;
use app\common\model\User;
use app\common\model\Returnbuy;
use think\Db;
use app\common\model\Record;
use app\common\model\WithdrawMoneyLog;
/**
 * 订单控制器
 * Class Order
 * @package app\api\controller
 */
class Order extends Controller
{
    /* @var \app\api\model\User $user */
    private $user;
    /**
     * 构造方法
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function initialize()
    {	
        parent::initialize();
        $this->user = $this->getUser();   // 用户信息
    }
    /**
     * 订单确认-立即购买
     * @param $item_id
     * @param $goods_num
     * @param $item_sku_id
     * @param $coupon_id
     * @param string $remark
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     * @throws \Exception
     */
    public function buyNow($item_id, $goods_num, $item_sku_id, $coupon_id = null, $remark = '', $prom = '', $other = '')
    {	
        // 商品结算信息
        $model = new OrderModel;
        $order = $model->getBuyNow($this->user, $item_id, $goods_num, $item_sku_id ,$prom,$other);
        if (!$this->request->isPost()) {
            return $this->renderSuccess($order);
        }
        if ($model->hasError()) {
            return $this->renderError($model->getError());
        }
        // 创建订单
        if ($model->createOrder($this->user['user_id'], $order, $coupon_id, $remark,$prom,$item_id,$other)) {
            // 发起微信支付
            return $this->renderSuccess([
                'payment' => $this->unifiedorder($model, $this->user),// 微信支付
                'order_id' => $model['order_id']
            ]);
        }
        $error = $model->getError() ?: '订单创建失败';
        return $this->renderError($error);
    }
    /**
     * 订单确认-购物车结算
     * @param string $cart_ids (支持字符串ID集)
     * @param $coupon_id
     * @param string $remark
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \Exception
     */
    public function cart($cart_ids, $coupon_id = null, $remark = '')
    {	
        // 商品结算信息
        $Card = new CartModel($this->user['user_id']);
        $order = $Card->getList($this->user, $cart_ids);
        if (!$this->request->isPost()){
            return $this->renderSuccess($order);
        }
        // 创建订单
        $model = new OrderModel;
        if ($model->createOrder($this->user['user_id'], $order, $coupon_id, $remark)) {
            // 移出购物车中已下单的商品
            $Card->clearAll($cart_ids);
            // 发起微信支付
            return $this->renderSuccess([
                'payment' => $this->unifiedorder($model, $this->user),
                'order_id' => $model['order_id']
            ]);
        }
        return $this->renderError($model->getError() ?: '订单创建失败');
    }
    
    /**
     * 购买vip
     */
    public function buyVip(){
    	// 先判断这个用户是不是vip
    	$user = $this->user;
    	if ($user['is_vip'] == 1){
    		return $this->renderError('该用户已经是vip了');
    	}
    	$model = new OrderModel;
    	$order = $model->getBuyNow($user, 10, 1, 6 ,'','');// 10是商品id，6是规格id，1是商品数量
    	if($model->createOrder($user['user_id'], $order, null, '','',10,'')){// 10是商品id
    		// 发起微信支付
    		return $this->renderSuccess([
    				'payment' => $this->unifiedorder($model, $user),
    				'order_id' => $model['order_id']
    		]);
    	}
    }
    
    /**
     * 美豆支付
     * @param string $pay_password  支付密码
     * @param number $order_id 		订单ID
     */
    public function payNow(){
    	$pay_pwd = input('post.pay_pwd');
    	$order_id = input('post.order_id');
    	// 判断传过来的数据是否正确
    	if (empty($pay_pwd) || empty($order_id)){
    		throw new Exception('非法请求');
    	}
    	// 判断这笔订单的支付状态
    	$order_model = new OrderModel;
    	$where = ['order_id'=>$order_id];
    	$order_data = $order_model->getDataByWhere($where);
    	if ($order_data){
    		$pay_status = $order_data['pay_status'];
    		if ($pay_status == 20){
    			return $this->renderError('错误请求');
    		}
    	}else {
    		return $this->renderError('改笔订单不存在');
    	}
    	$order_no = $order_data['order_no'];// 订单号
    	$pay_price = $order_data['pay_price'];// 订单价格，包含运费
    	$exchange_integral = $order_data['exchange_integral'];// 积分
    	// 判断支付密码是否正确
    	if ($this->user['pay_pwd'] !== wymall_pass($pay_pwd)){
    		return $this->renderError('支付密码错误');
    	}
    	// 判断是否是积分支付
    	if ($exchange_integral > 0){
    		// 判断用户的积分是否足够
    		if ($this->user['integral'] < $exchange_integral){
    			return $this->renderError('您的积分不足，请充值');
    		}
    	}
    	// 判断用户的美豆是否足够
    	if ($this->user['money'] < $pay_price){
    		return $this->renderError('您的余额不足，请充值');
    	}
    	// 修改该笔订单的支付状态
    	$res = $order_model->paySuccess($order_no);
    	// 减少美豆
    	$user_model = new User();
    	$new_money = $this->user['money'] - $pay_price;
    	$user_model->upFieldByWhere(['user_id'=>$this->user['user_id']], ['money'=>$new_money]);
    	// 写log
    	$record_model = new Record();
    	$record_model->addRecord($order_id,$pay_price,$this->user['user_id'],0,$exchange_integral);
    	return $this->renderSuccess('支付成功');
    }
    
    /**
     * 构建微信支付
     * @param $order
     * @param $user
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    private function unifiedorder($order, $user)
    {
        // 统一下单API
        $wxConfig = AppModel::getAppCache();
        $WxPay = new WxPay($wxConfig);
        $payment = $WxPay->unifiedorder($order['order_no'], $user['open_id'], $order['pay_price']);
        // 记录prepay_id
        $model = new AppPrepayIdModel;
        $model->add($payment['prepay_id'], $order['order_id'], $user['user_id']);
        return $payment;
    }
	/**
     * 我的订单列表
     * @param $dataType
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function lists($dataType)
    {
        $model = new OrderModel;
        $list = $model->getList($this->user['user_id'], $dataType);
        return $this->renderSuccess(compact('list'));
    }
    /**
     * 订单详情信息
     * @param $order_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function detail($order_id)
    {
        $order = OrderModel::getUserOrderDetail($order_id, $this->user['user_id']);
        return $this->renderSuccess(compact('order'));
    }
    /**
     * 获取物流信息
     * @param $order_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function express($order_id)
    {
        // 订单信息
        $order = OrderModel::getUserOrderDetail($order_id, $this->user['user_id']);
        if (!$order['express_no']) {
            return $this->renderError('没有物流信息');
        }
        // 获取物流信息
        /* @var \app\store\model\Express $model */
        $model = $order['express'];
        $express = $model->dynamic($model['express_name'], $model['express_code'], $order['express_no']);
        if ($express === false) {
            return $this->renderError($model->getError());
        }
        return $this->renderSuccess(compact('express'));
    }
    /**
     * 取消订单
     * @param $order_id
     * @return array
     * @throws \Exception
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function cancel($order_id)
    {
        $model = OrderModel::getUserOrderDetail($order_id, $this->user['user_id']);
        if ($model->cancel()) {
            return $this->renderSuccess('收货成功');
        }
        return $this->renderError($model->getError());
    }
    
    /**
     * 申请退款
     */
    public function refund($order_id,$content){
    	$model = OrderModel::getUserOrderDetail($order_id, $this->user['user_id']);
    	// 修改状态
    	$model->upFieldByWhere(['order_id'=>$order_id],['order_status'=>40,'sub_status'=>10,'sub_type'=>1]);
    	// 将退款信息存入表中
    	$data = [
    			'content'=>$content,
    			'order_id'=>$order_id,
    			'order_no'=>$model['order_no'],
    			'status'=>1,// 审核中
    			'user_id'=>$this->user['user_id'],
    			'is_delete'=>0,
    			'create_time'=>time(),
    			'update_time'=>time(),
    	];
    	$returnbuy_model = new Returnbuy();
    	$res = $returnbuy_model->insert($data);
    	return $this->renderSuccess('申请退款成功，请耐心等待');    	
    }
    
    /**
     * 确认收货
     * @param $order_id 
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function receipt($order_id)
    {
        $model = OrderModel::getUserOrderDetail($order_id, $this->user['user_id']);
        if ($model->receipt($this->user)) {
        	// 根据用户的消费金额修改用户的等级同时增加用户的积分（如果用户的消费金额达到了升级标准，则在这里也会给用户赠送对应的东西）
        	$UserModel = new User();
        	$UserModel->upUserShopMoney($this->user, $model['pay_price']);
        	// 给供应商加可提现余额加日志
        	$WithdrawLog = new WithdrawMoneyLog();
        	$WithdrawLog->addWithdrawMoneyLog('supplier',$model['pay_price'],2,$model['plat_id'],$order_id);
            return $this->renderSuccess();
        }
        return $this->renderError($model->getError());
    }
    /**
     * 立即支付
     * @param $order_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function pay($order_id)
    {
        // 订单详情
        $order = OrderModel::getUserOrderDetail($order_id, $this->user['user_id']);
		// 判断商品状态、库存
        if (!$order->checkStatusFromOrder($order['goods'])) {
            return $this->renderError($order->getError());
        }
        // 统一下单API
        $wxConfig = AppModel::getAppCache();
        $WxPay = new WxPay($wxConfig);
        $payment = $WxPay->unifiedorder($order['order_no'], $this->user['open_id'], $order['pay_price']);
        // 记录prepay_id
        $model = new AppPrepayIdModel;
        $model->add($payment['prepay_id'], $order['order_id'], $this->user['user_id']);
        return $this->renderSuccess($payment);
    }
}