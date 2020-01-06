<?php


namespace app\user\controller;


use app\common\model\OrderSupplierByPlat;
use app\common\model\User;

class ReturnBuy extends Controller
{
    /**
     * 退款申请列表
     * @return mixed
     */
    public function index()
    {
        $model = new \app\common\model\Returnbuy();
        $list = $model->getLists();
        $page=$list->render();
        return $this->fetch('index', compact('list','page'));
    }

    /**
     * 改变状态
     * @author cjj
     */
    public function changeStatus()
    {
        $param = input();
        $model = new \app\common\model\Returnbuy();
        /*if ($param['status'] == 2) {
            $info = $model->where('id', $param['id'])->find();
            $this->returnUserMoney($param['id'], $info['order_id'], $info['user_id'], $info['status']);
        }*/

        $res = $model->upStatus($param['id'], $param['status']);
        if ($res!==true) {
            return $this->renderError('操作失败');
        }
        return $this->renderSuccess('操作成功');
    }

    public function returnUserMoney($id,$order_id,$user_id,$returnbuy_status){
        $user_model = new User();
        $returbuy_model = new \app\common\model\Returnbuy();
        $OrderPlatModel = new OrderSupplierByPlat();
        // 获取订单信息
        $model = $OrderPlatModel->getDataByWhere(['order_id'=>$order_id]);
        // 关联商品信息
        $itemModel = new \app\common\model\Item();
        $item_info = $itemModel->getDataByWhere(['goods_id'=>$model['item_id']]);
        // 如果是独家商品
        if ($item_info['is_sole'] == 1) {
            $result = $itemModel->cancalSole($model['item_id']); //取消商品独家
            soleLog(2,$user_id,$order_id);
            if ($result == false){
                return false;
            }
        }
        // 关闭订单(有问题)
        $pay_price = $OrderPlatModel->returnbuy($model);
        // 修改状态
        $res1 = $returbuy_model->upStatus($id,$returnbuy_status);
        if ($returnbuy_status == 2){
            // 退钱
            if ($user_id != 0){
                $res = $user_model->upUserMoney($user_id,$pay_price);
            }
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
}