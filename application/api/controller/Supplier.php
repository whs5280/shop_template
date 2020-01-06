<?php
namespace app\api\controller;

use app\common\model\Ad;
use app\common\model\User;
use app\common\model\Order as OrderModel;
use app\common\model\Supplier as SupplierModel;
use app\common\model\Withdraw;
use app\common\model\UserAddress as UserAddressModel;
use app\common\model\OrderGoods as OrderGoodsModel;
use app\common\model\OrderDelivery as OrderDeliveryModel;
use app\common\model\Returnbuy as ReturnbuyModel;
use app\common\model\PayInfo as PayInfoModel;
use app\common\model\WithdrawMoneyLog as WithdrawMoneyLogModel;
use app\common\model\Category as CategoryModel;
use app\common\model\OrderSupplierByPlat;
use app\common\model\OrderSupplierByUser;
use app\common\model\Returnbuy;
use app\common\library\wechat\WxPay;
use app\common\model\App as AppModel;
use app\common\model\Industry;
/**
 * 供应商主页
 * Class Index
 * @package app\api\controller
 */
class Supplier extends Controller
{
    /**
     * 获取当前用户信息
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function detail()
    {
        // 当前用户信息
    	$token = input('post.token');
    	$model = new SupplierModel;
        $userInfo = $model->getUser($token);
		if($userInfo)
			return $this->renderSuccess([
				'userInfo' => $userInfo,
			]);
		return $this->renderJson(-1,'没有找到用户信息');
    }
    
    /**
     * 首页
     * @return array|json
     */
    public function Index(){
    	// 当前用户信息
    	$model = new SupplierModel;
    	$token = input('post.token');
    	$userInfo = $model->getUser($token);
    	if ($userInfo){
    		$AdModel = new Ad();
    		// 公告
    		$notice = $AdModel->getNotice();
    		return $this->renderSuccess($notice);
    	}
    	return $this->renderJson(-1,'没有找到用户信息');
    }
    
    /**
     * 供应商登录
     */
    public function login($post){
    	// $post = input('post.');
    	$model = new SupplierModel;
    	$user = $model->appLogin($post);
    	if($user){
    		return $user;
    		return $this->renderSuccess([
    				'user_id' => $user,
    				'token' => $model->getToken()
    		]);
    	}
    }
    
    /**
     * 获取供应商钱包数据（可提现金额、提现记录）
     * @param num $plat_id
     */
    public function SupplierMoney(){
    	// 获取可提现金额
    	$model = new SupplierModel;
    	$token = input('post.token');
    	$userInfo = $model->getUser($token);
    	$user_id = $userInfo['user_id'];
    	$withdraw_money = $userInfo['withdraw_money'];
    	// $withdraw_money = $model->getFidleByWhere(['user_id'=>$user_id], 'withdraw_money');
    	// 获取提现记录
    	$withdraw_model = new Withdraw();
    	$data = $withdraw_model->getWithdrawInfo($plat_id);
    	return $this->renderSuccess([
    			'withdraw_money'=>$withdraw_money,
    			'withdraw_info'=>$data
    	]);
    }
    
    /**
     * 提现（提交申请，然后线下打款）
     */
    public function CashWithdrawal(){
    	$model = new SupplierModel;
    	$token = input('post.token');
    	$userInfo = $model->getUser($token);
    	$user_id = $userInfo['user_id'];
    	
    	$post = input('post.');
    	$WithdrawModel = new Withdraw();
    	// 提交申请状态
    	$res = $WithdrawModel->submit($user_id, $post);
    	if ($res){
    		// 减少可提现金额
    		$model->where(['user_id'=>$user_id])->setDec('withdraw_money', $post['money']);
    		return $this->renderSuccess($res);
    	}
    	return $this->renderError('网络错误，请稍后再试');
    }
    
    /**
     * 将供应商的可提款项显示出来（收货时间过了指定日期）
     */
    public function upReceivedStatus(){
    	$model = new SupplierModel;
    	$token = input('post.token');
    	$userInfo = $model->getUser($token);
    	$user_id = $userInfo['user_id'];
    	$OrderModel = new Order();
    	$WithdrawLog = new WithdrawMoneyLogModel;
    	$day = 15;
    	// 截止时间
    	$deadlineTime = time() - ((int)$day * 86400);
    	// 条件
    	$filter = [
    			'plat_id'=>$user_id,
    			'pay_status' => 20,
    			'delivery_status' => 20,
    			'receipt_status' => 10,
    			'receive_time' => ['<', $deadlineTime],
    	];
    	$orderIds = $OrderModel->where($filter)->column('order_id');
    	$orderController = new \app\api\controller\Order();
    	// 修改状态
    	$res = $OrderModel->isUpdate(true)->save([
    			'receipt_status' => 20,
    			'receipt_time' => time(),
    			'order_status' => 30
    	], ['order_id' => ['in', $orderIds]]);
    	// 根据用户消费情况加积分和升级+给供应商加可提现余额加日志
    	$UserModel = new User();
    	for($i = 0; $i < count($orderIds); $i++){
    		$pay_price = 0;
    		$pay_price = $OrderModel->getFieldByWhere(['order_id'=>$orderIds[$i]], 'pay_price');
    		// 加积分升级
    		$UserModel->upUserShopMoney($this->user, $pay_price);
    		// 给供应商加可提现余额加日志
    		$WithdrawLog->addWithdrawMoneyLog('supplier',$pay_price,2,$user_id,$orderIds[$i]);
    	}
    	return true;
    }
    
    /**
     * 获取对应的供应商数据(平台订单、平台代发、客户订单)
     * @param num $type  1=>平台订单(暂时做不了，表没出)    2=>平台代发(暂时做不了，表没出)    3=>客户订单
     * @param string $order_type  uncollected（待发货）received（已收货）refund（已退款）
     * @return array|json
     */
    public function getOrderData(){
    	$type = input('post.type');
    	$order_type = input('post.order_type')?input('post.order_type'):'uncollected';
    	// 当前用户信息
    	$SupplierModel = new SupplierModel;
    	$token = input('post.token');
    	$userInfo = $SupplierModel->getUser($token);
    	// 订单总数
    	if ($type == 1){
    		// 平台订单
    		$model = new OrderSupplierByPlat();
    	}elseif ($type == 2){
    		// 平台代发
    		$model = new OrderSupplierByUser();
    	}elseif ($type == 3){
    		// 客户订单
    		$model = new OrderModel;
    	}
    	if($userInfo)
    		return $this->renderSuccess([
    				'orderCount' => [// 总数
    						// 'payment' => $model->getSupplierCount($userInfo['user_id'], 'payment'),// 待付款
    						'uncollected' => $model->getSupplierCount($userInfo['user_id'], 'uncollected'),// 待发货
    						'received' => $model->getSupplierCount($userInfo['user_id'], 'received'),// 已收货
    						// 'comment' => $model->getSupplierCount($userInfo['user_id'], 'comment'),// 待评论
    						'refund' => $model->getSupplierCount($userInfo['user_id'], 'refund'),// 退款/售后
    				],
    				$order_type => $model->getSupplierOrderDetail($userInfo['user_id'], $order_type),
    		]);
    }
    
    /**
     * 统计（按分类统计，按时间统计）（销量总数、销量总额）
     * @param $token
     * @param $type
     * @param $category_id
     * @param $start_time
     * @param $end_time
     */
    public function countData(){
    	$model = new SupplierModel;
    	$CategoryModel = new CategoryModel;
    	$OrderModel = new OrderModel;
    	$Industry = new Industry();
    	
    	// 获取用户信息
    	$token = input('post.token');
    	$userInfo = $model->getUser($token);
    	$user_id = $userInfo['user_id'];
    	
    	// 获取分类id
    	$post = input('post.');
    	
    	// 获取所有的分类数据
    	$category_data = $CategoryModel->getALL();
    	$industry_data = $Industry->getALLByWhere();
    	
    	// 获取订单数据
    	// 未选择分类
    	$where = ['plat_id'=>$user_id];
    	if ($post['type'] == 0){
    		$order_data = $OrderModel->getAllDataByWhere($where);
    	// 根据已选择的分类id来进行查询
    	}else {
    		// 如果有分类id
    		if ((isset($post['industry_id']) && isset($post['category_id'])) && !(isset($post['start_time']) || isset($post['end_time']))){
    			$OrderGoodsModel = new OrderGoodsModel;
    			$order_data = $OrderGoodsModel->getAllDataByCategoryAndUser($post['industry_id'],$post['category_id'],$user_id);
    			$order_id = [];
    			foreach ($order_data as $key=>$value){
    				$order_id[] = $value['order_id'];
    			}
    			$where = [
    					'plat_id'=>$user_id,
    					'order_id' => ['in', implode(',', $order_id)],
    			];
    		// 如果有时间
    		}elseif ((isset($post['start_time']) && isset($post['end_time'])) && !(isset($post['industry_id']) && isset($post['category_id']))){
    			$where = [
    					'plat_id'=>$user_id,
    					'create_time' => ['>', $post['start_time']],
    					'create_time' => ['<', $post['end_time']],
    			];
    			$order_data = $OrderModel->getAllDataByWhere($where);
    		}
    	}
    	return $this->renderSuccess([
    			'industry_data'=>$industry_data,// 行业信息
    			'category_data'=>$category_data,// 分类信息
    			'order_data'=>$order_data,// 订单信息
    			'countPrice'=>$OrderModel->countReceiveData($where),// 成交总额
    			'countSuccessCount'=>$OrderModel->countData($where,'success'),// 成交总数
    			'countReturnCount'=>$OrderModel->countData($where,'fail'),// 退货总数
    	]);
    }
    
    /**
     * 退款详情
     */
    public function ReturnbuyDetail(){
    	$order_id = input('post.order_id');
    	$AddressModel = new UserAddressModel;
    	$OrderModel = new OrderModel;
    	$OrderGoods = new OrderGoodsModel;
    	$OrderDelivery = new OrderDeliveryModel;
    	$ReturnBuy = new ReturnbuyModel;
    	// 订单信息
    	$order_info = $OrderModel->getDataByWhere(['order_id'=>$order_id]);
    	// 快递信息
    	$delivery = $OrderDelivery->getDataByWhere(['order_no'=>$order_info['order_no']]);
    	// 地址信息
    	$address_info = $AddressModel->getDataByWhere(['user_id'=>$order_info['user_id']]);
    	// 获取商品信息
    	$all_order_info = $OrderGoods->getAllDataByWhere($order_id);
    	// 退款原因
    	$returnbuy_info = $ReturnBuy->getDataByWhere(['order_id'=>$order_id]);
    	return $this->renderSuccess([
    			'order_info'=>$order_info,
    			'delivery'=>$delivery,
    			'address_info'=>$address_info,
    			'all_order_info'=>$all_order_info,
    			'returnbuy_info'=>$returnbuy_info
    	]);
    }

    /**
     * 发货
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function deliverGoods(){
        // 先获取订单详情
        $param = input('');
        $orderModel = new OrderModel();
        $order_info = $orderModel->where('order_id', $param['order_id'])->find();
        if ($order_info['pay_status']['value'] == 20 && $order_info['pay_time'] != 0) {
            $model = OrderModel::detail($param['order_id']);

            // 前端没做，先写死
            $param['express_id'] = '10005';
            $param['order_no'] = $order_info['order_no'];
            $param['company'] = '京东1快递';
            $param['express_no'] = rand(1000000000, 9999999999);

            if ($model->delivery($param)) {
                return $this->renderSuccess([],'发货成功');
            }
            return $this->renderError($model->getError() ?: '发货失败');
        } else {
            return $this->renderError('订单未支付');
        }
        // ...
        /*$wxConfig = AppModel::getAppCache();
        $WxPay = new WxPay($wxConfig);
        $payment = $WxPay->refund($transaction_id, $openid, $total_fee);
        dump($payment);
        die;*/
    }
    
    /**
     * 退款
     * @param unknown $id
     * @param unknown $order_id
     * @param unknown $user_id
     * @param unknown $returnbuy_status
     */
    public function returnUserMoney(){
    	$id = input('post.id');
    	$order_id = input('post.order_id');
    	$user_id = input('post.user_id');
    	$returnbuy_status = input('post.returnbuy_status');
    	
    	$user_model = new User();
    	$returbuy_model = new Returnbuy();
    	$OrderPlatModel = new OrderSupplierByPlat();
    	// 获取订单信息
    	$model = $OrderPlatModel->getDataByWhere(['order_id'=>$order_id]);
    	// 关闭订单
    	$pay_price = $OrderPlatModel->returnbuy($model);
    	// 修改状态
    	$res1 = $returbuy_model->upStatus($id,$returnbuy_status);
    	if ($returnbuy_status == 2){
    		// 退钱
	    	if ($user_id != 0){
	    		$res = $user_model->upUserMoney($user_id,$pay_price);
	    	}
	    	return $this->renderSuccess('退款成功','退款成功');
    	}
    	if ($res1){
    		return $this->renderSuccess('审核成功','审核成功');
    	}
    	return $this->renderError('请稍后再试','请稍后再试');
    }
    
    /**
     * 发货详情
     */
    public function deliverDetail(){
    	$order_id = input('post.order_id');
    	$AddressModel = new UserAddressModel;
    	$OrderModel = new OrderModel;
    	$OrderGoods = new OrderGoodsModel;
    	$OrderDelivery = new OrderDeliveryModel;
    	// 订单信息
    	$order_info = $OrderModel->getDataByWhere(['order_id'=>$order_id]);
    	// 快递信息
    	$delivery = $OrderDelivery->getDataByWhere(['order_no'=>$order_info['order_no']]);
    	// 地址信息
    	$address_info = $AddressModel->getDataByWhere(['user_id'=>$order_info['user_id']]);
    	// 获取商品信息
    	$all_order_info = $OrderGoods->getAllDataByWhere($order_id);
    	return $this->renderSuccess([
    			'order_info'=>$order_info,
    			'delivery'=>$delivery,
    			'address_info'=>$address_info,
    			'all_order_info'=>$all_order_info,
    	]);
    }
    
    /**
     * 绑定收款信息
     * @param string $token
     * @param num    $type 	1=>绑定支付宝,2=>绑定微信,3=>绑定银行卡
     * @param string alipay_name		wechat_number		bank_name
     * @param string alipay_account		null				bank_account
     * @param string null				null				bank_card
     * @return array|json
     */
    public function BandReceivablesInfo(){
    	$model = new SupplierModel;
    	$PayInfoModel = new PayInfoModel;
    	$post = input('post.');
    	$token = $post['token'];
    	$type = $post['type'];
    	$userInfo = $model->getUser($token);
    	$user_id = $userInfo['user_id'];
    	$data = '';
    	// 绑定支付宝
		if ($type == 1){
    		if (isset($post['alipay_name']) && isset($post['alipay_account'])){
    			// 整理修改的数据
    			$data = [
    					'alipay_name'=>$post['alipay_name'],
    					'alipay_account'=>$post['alipay_account']
    			];
    		}
		// 绑定微信
		}elseif ($type == 2){
			if (isset($post['wechat_number'])){
				// 整理修改的数据
				$data = [
						'wechat_number'=>$post['wechat_number'],
				];
			}
		// 绑定银行卡
		}elseif ($type == 3){
			if (isset($post['bank_name']) && isset($post['bank_account']) && isset($post['bank_card'])){
				// 整理修改的数据
				$data = [
						'bank_name'=>$post['bank_name'],
						'bank_account'=>$post['bank_account'],
						'bank_card'=>$post['bank_card'],
				];
			}
		}
		if ($data != ''){
			$where = ['user_id'=>$user_id];
			// 检查这个用户有没有数据
			$check = $PayInfoModel->getDataByWhere($where);
			$time = time();
			// 有就修改
			if ($check){
				$data['update_time'] = $time;
		    	$res = $PayInfoModel->upFieldByWhere($where,$data);
		    // 没有就添加
			}else {
				$data['user_id'] = $user_id;
				$data['create_time'] = $time;
				$data['update_time'] = $time;
				$res = $PayInfoModel->addData($data);
			}
			if ($res){
				return $this->renderSuccess('修改成功');
			}
		}
		return $this->renderError('非法请求');
    }
}