<?php
namespace app\user\controller;
use app\common\model\Order as OrderModel;
use app\common\model\Express as ExpressModel;
use app\common\model\OrderDelivery;
use app\common\model\Setting;
use app\common\model\Returnbuy;
use app\common\model\User;
use PhpOffice\PhpWord\PhpWord;

/**
 * 订单管理
 * Class Order
 * @package app\user\controller
 */
class Order extends Controller
{
    /**
     * 待发货订单列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function deliveryList()
    {

        return $this->getList('待发货订单列表', 'delivery','');
    }
    /**
     * 待收货订单列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function receiptList()
    {

        return $this->getList('待收货订单列表', 'receipt','');
    }
    /**
     * 待处理售后列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function etcSaleList($dataType='etcsalelist',$user_id='')
    {
        $model = new OrderModel;
        $list = $model->getLists('etcsalelist', $this->request->get(),$user_id);
        return $this->fetch('etcsale', compact('title', 'dataType', 'list'));
    }

    /**
     * 已处理售后列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function inSaleList($dataType='inSaleList',$user_id='')
    {
        $model = new OrderModel;
        $list = $model->getLists($dataType, $this->request->get(),$user_id);
        return $this->fetch('insale', compact('title', 'dataType', 'list'));
    }
    /**
     * 售后详情
     * @param $order_id
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function saleDetail($order_id)
    {
        return $this->fetch('saledetail', [
            'detail' => OrderModel::detail($order_id),
            'express_list' => ExpressModel::getAll()
        ]);
    }
    
    /**
     * 退款申请列表
     */
    public function returnbuy(){
    	$model = new Returnbuy();
    	$list = $model->getLists();
    	return $this->fetch('returnbuy_index',compact('list'));
    }
    
    /**
     * 后台退款给用户，通过|拒绝
     * @param unknown $id
     * @param unknown $order_id
     * @param unknown $user_id
     * @param unknown $status
     */
    public function returnUserMoney($id,$order_id,$user_id,$returnbuy_status){
    	$user_model = new User();
    	$returbuy_model = new Returnbuy();
    	// 获取订单信息
    	$model = OrderModel::getUserOrderDetail($order_id, $user_id);
    	// 关闭订单
    	$pay_price = $model->returnbuy($order_id, $user_id);
    	// 修改状态
    	$res1 = $returbuy_model->upStatus($id,$returnbuy_status);
    	if ($returnbuy_status == 2){
    		// 退钱
	    	// $res = $user_model->upUserMoney($user_id,$pay_price);
	    	// 下面是退款的，暂时还没有测试
	    	$wxConfig = AppModel::getAppCache();
	    	$WxPay = new WxPay($wxConfig);
	    	$payment = $WxPay->refund($transaction_id, $openid, $total_fee);
	    	dump($payment);
	    	if ($res){
	    		return $this->Success('退款成功');
	    	}
	    	return $this->Error('退款失败');
    	}
    	if ($res1){
    		return $this->Success('审核成功');
    	}
    	return $this->Error('请稍后再试');
    }

    /**
     * 分佣佣金
     * @param $order_id
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function gold($dataType='gold',$user_id='')
    {
        $model = new OrderModel;
        $list = $model->getGold($dataType);
        $values = Setting::detail('basic')['values'];
        $setting = unserialize($values);
        if($setting['is_open']==2){
            return $this->Error('分销功能已关闭');
        }
        return $this->fetch('gold', compact('dataType', 'list','setting'));
    }

    /**
     * 分佣
     * @param $order_id
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function Sub($order_id='')
    {
        $model =OrderModel::detail($order_id);

        if ($model->path($model['item_id'],$model['pay_price'],$model['user']['path'],1)){
            $model->save([
                'end_time'=>time(),
                'order_status'=>30,
            ]);
            return $this->renderSuccess('操作成功');
        }
        return $this->renderError('操作失败');
    }

    /**
     * 一键分佣
     * @param $order_id
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function SubAll()
    {
        $model = new OrderModel;
        $list = $model->getGold('gold');
        if($list){
            return $this->renderError('分佣列表为空');
        }
        foreach($model as $key =>$val)
        {
            if($data=$model->path($val['item_id'],$val['pay_price'],$val['user']['path'],1)){
                $data->save([
                    'end_time'=>time(),
                    'order_status'=>30,
                ]);
            }

        }
        return $this->renderSuccess('操作成功');
    }

    /**
     * 待付款订单列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function payList()
    {
        return $this->getList('待付款订单列表', 'pay','');
    }
    /**
     * 已完成订单列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function completeList()
    {
        return $this->getList('已完成订单列表', 'complete','');
    }
    /**
     * 已取消订单列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function cancelList($user_id = null)
    {
        return $this->getList('已取消订单列表', 'cancel',$user_id);
    }
    /**
     * 全部订单列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function allList($user_id = null,$type='user')
    {
        return $this->getList('全部订单列表', 'All',$user_id,$type);
    }
    /**
     * 订单详情
     * @param $order_id
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function detail($order_id)
    {
        $detail=OrderModel::detail($order_id);
        return $this->fetch('detail',[
            'detail' => $detail,
            'express_list' => ExpressModel::getAll(),
            'orderdelivery' => OrderDelivery::getAll($detail['order_no'])
        ]);

    }
    /**
     * 确认发货
     * @param $order_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function delivery($order_id)
    {

        $model = OrderModel::detail($order_id);
        if ($model->delivery($this->postData('order'))) {
            return $this->renderSuccess('发货成功');
        }
        return $this->renderError($model->getError() ?: '发货失败');
    }
    /**
     * 修改订单价格
     * @param $order_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function updatePrice($order_id)
    {
        $model = OrderModel::detail($order_id);
        if ($model->updatePrice($this->postData('order'))) {
            return $this->renderSuccess('修改成功');
        }
        return $this->renderError($model->getError() ?: '修改失败');
    }
    /**
     * 订单列表
     * @param string $title
     * @param string $dataType
     * @return mixed
     * @throws \think\exception\DbException
     */
    private function getList($title, $dataType,$user_id,$type='user')
    {
        $model = new OrderModel;
        if ($type == 'user'){
        	$list = $model->getLists($dataType, $this->request->post(),$user_id);
        }elseif($type == 'supplier') {
        	$list = $model->getListsSupplier($dataType, $this->request->post(),$user_id);
        }
        return $this->fetch('index', compact('title', 'dataType', 'list'));
    }
    /**
     * 批量发货
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function give()
    {

        if (!$this->request->isAjax()) {

            return $this->fetch('give', [
                'express' => ExpressModel::getAll()
            ]);
        }
        if ($this->model->batchDelivery($this->postData('order'))) {
            //dump(8888);die;
            return $this->renderSuccess('发货成功');
        }
        return $this->renderError($this->model->getError() ?: '发货失败');
    }
    /**
     * 批量发货
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function batchDelivery()
    {
        if (!$this->request->isAjax()) {
            return $this->fetch('batchDelivery', [
                'express' => ExpressModel::getAll()
            ]);
        }
        if ($this->model->batchDelivery($this->postData('order'))) {
            return $this->renderSuccess('发货成功');
        }
        return $this->renderError($this->model->getError() ?: '发货失败');
    }
    /**
     * 清单打印
     * @method
     */
    public function export($order_id)
    {
        // 获取订单详情
        $detail=OrderModel::detail($order_id);
        //dump($detail);die;
        //dump($orderdelivery);die;

        // Word生成
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();  // 添加新的一夜

        $fontStyle = [
            'name' => 'Microsoft Yahei UI',
            'size' => 20,
            'bold' => true,
            'valign' => 'center',
            'align'  => 'center'
        ];
        $textrun = $section->addTextRun();
        $textrun->addText('出库清单', $fontStyle);

        $header = array('size' => 14, 'bold' => true);

        // 订单详情表格
        $section->addTextBreak(2); //换行
        $section->addText('订单详情', $header);
        $table = $section->addTable();

        $table->addRow();
        $table->addCell(2000)->addText("订单号码");
        $table->addCell(2000)->addText("买家");
        $table->addCell(2000)->addText("订单金额");
        $table->addCell(1000)->addText("状态");
        $table->addCell(3000)->addText("发货时间");

        $table->addRow();
        $table->addCell(2000)->addText($detail['order_no']);
        $table->addCell(2000)->addText($detail['user']['nickName']);
        $table->addCell(2000)->addText($detail['pay_price']);
        $table->addCell(1000)->addText($detail['delivery_status']['text']);
        $table->addCell(3000)->addText(date('Y-m-d h:m:s', $detail['delivery_time']));

        // 商品详情表
        $section->addTextBreak(2); //换行
        $section->addText('商品信息', $header);
        $table = $section->addTable();

        $table->addRow();
        $table->addCell(2000)->addText("商品名称");
        $table->addCell(2000)->addText("商品编号");
        $table->addCell(2000)->addText("单价");
        $table->addCell(2000)->addText("数量");
        $table->addCell(2000)->addText("总价");

        $table->addRow();
        foreach ($detail['goods'] as $item){
            $table->addCell(2000)->addText($item['name']);
            $table->addCell(2000)->addText($item['goods_no']);
            $table->addCell(2000)->addText($item['goods_price']);
            $table->addCell(2000)->addText($item['total_num']);
            $table->addCell(2000)->addText($item['total_pay_price']);
        }

        // 收货地址表
        $section->addTextBreak(2); //换行
        $section->addText('收货地址', $header);
        $table = $section->addTable();

        $table->addRow();
        $table->addCell(2000)->addText("收货人");
        $table->addCell(2000)->addText("联系方式");
        $table->addCell(2000)->addText("地址");
        $table->addCell(4000)->addText("详细地址");

        $table->addRow();
        $table->addCell(2000)->addText($detail['address']['name']);
        $table->addCell(2000)->addText($detail['address']['phone']);
        $table->addCell(2000)->addText($detail['address']['detail']);
        $table->addCell(4000)->addText($detail['address']['region']['province'] . $detail['address']['region']['city'] . $detail['address']['region']['region']);

        // 物流信息表
        $section->addTextBreak(2); //换行
        $section->addText('物流信息', $header);
        $table = $section->addTable();

        $table->addRow();
        $table->addCell(3000)->addText("物流单号");
        $table->addCell(2000)->addText("物流公司");
        $table->addCell(3000)->addText("发货时间");

        $table->addRow();
        foreach ($detail['order_delivery'] as $item) {
            $table->addCell(3000)->addText($item['express_no']);
            $table->addCell(2000)->addText($item['company']);
            $table->addCell(3000)->addText($item['create_time']);
        }

        // 导出
        $file = '清单'. time(). '.docx';
        header("Content-Description: File Transfer");
        header('Content-Disposition: attachment; filename="' . $file . '"');
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Expires: 0');
        $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $xmlWriter->save("php://output");
    }
}