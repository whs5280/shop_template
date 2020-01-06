<?php

namespace app\api\controller;

use app\common\model\Item as ItemModel;
use app\common\model\Cart as CartModel;
use app\common\service\qrcode\Item as ItemPoster;

/**
 * 商品控制器
 * Class Item
 * @package app\api\controller
 */
class Item extends Controller
{
    /**
     * 商品列表
     * @param $category_id
     * @param $search
     * @param $sortType
     * @param $sortPrice
     * @return array
     * @throws \think\exception\DbException
     */
    public function lists($category_id, $search, $sortType, $sortPrice)
    {
        $model = new ItemModel;
        $list = $model->getList(1, $category_id, $search, '','',$sortType, $sortPrice);
        return $this->renderSuccess(compact('list'));
    }
    
    /**
     * 返回积分商城商品
     */
    public function IntegralGoods(){
    	$user = $this->getUser();
    	$model = new ItemModel;
    	$list = $model->getIntegralList();
    	return $this->renderSuccess(compact('list','user'));
    }
    
    /**
     * 返回积分商城商品
     */
    public function SoleGoods(){
    	$user = $this->getUser();
    	$model = new ItemModel;
    	$list = $model->getSoleList();
    	return $this->renderSuccess(compact('list','user'));
    }

    /**
     * 获取商品详情
     * @param $item_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function detail($item_id,$user_id)
    {
        // 商品详情
		$data=[];
        $detail = ItemModel::detail($item_id);
	    if (!$detail) {
            return $this->renderError('很抱歉，商品信息不存在或已下架');
        }
		foreach($detail['spec_rel'] as $k=>$v){
			if(count($v['spec_item'])>0){
				$data[]=$v;
				
			}
		}
		unset($detail['spec_rel']);
		
		$detail['spec_rel']=$data;
		$detail['salesinitial']=$detail['sales_initial'];
        
        // 购物车商品总数量
        if ($user = $this->getUser(false)) {
            $cart_total_num = (new CartModel($user['user_id']))->getTotalNum();
        }
		//判断是否为参团产品
		$order='';
		
		//判断为秒杀
		if($detail['prom_type']>0){
			//查看代拼团订单
			$where[]=['item_id','=',$item_id];
			$where[]=['prom_statis','=',1];
			$order=db('order')->alias('order')->join('user user','order.user_id=user.user_id')->where($where)->whereTime('order.end_time', '>', date('Y-m-d H:i:s',time()))->select();
			$count=count($order);
		
		}
		$comment = db('comment')->field('a.*,b.nickName,b.avatarUrl')->alias('a')->join('bfb_user b','a.user_id = b.user_id')->where(['a.item_id'=>$item_id,'a.is_delete'=>0,'a.status'=>1])->select();
		$brand = db('brand')->where(['id'=>$detail['brand_id']])->find();
		$is_collect = db('collect')->where(['goods_id'=>$item_id,'user_id'=>$user_id])->value('status');
		$is_collect = $is_collect ? $is_collect : 0;
        return $this->renderSuccess(compact('detail', 'cart_total_num','order','count','endtime','comment','brand','is_collect'));
    }

    /**
     * 获取推广二维码
     * @param $item_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     * @throws \Exception
     */
    public function poster($item_id)
    {
        // 商品详情
        $detail = ItemModel::detail($item_id);
        $Qrcode = new ItemPoster($detail, $this->getUser(false));
        return $this->renderSuccess([
            'qrcode' => $Qrcode->getImage(),
        ]);
    }

}
