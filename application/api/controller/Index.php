<?php
namespace app\api\controller;
use app\common\model\Order as OrderModel;
use app\common\model\Coupon as CouponModel;
use app\common\model\Mbhmd;
use app\common\model\Images;
use app\common\model\Item;
use app\common\model\Ad;
use app\common\model\Collect;
use app\common\model\User;
/**
 * 个人中心主页
 * Class Index
 * @package app\api\controller
 */
class Index extends Controller
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
        $userInfo = $this->getUser();
        // 订单总数
        $model = new OrderModel;
        $CouponModel = new CouponModel;
		if($userInfo)
			return $this->renderSuccess([
				'userInfo' => $userInfo,
				'orderCount' => [
					'payment' => $model->getCount($userInfo['user_id'], 'payment'),// 待付款
					'uncollected' => $model->getCount($userInfo['user_id'], 'uncollected'),// 待发货
					'received' => $model->getCount($userInfo['user_id'], 'received'),// 待收货
					'comment' => $model->getCount($userInfo['user_id'], 'comment'),// 待评论
					'refund' => $model->getCount($userInfo['user_id'], 'refund'),// 退款/售后
				],
				'coupon'=>count($CouponModel->getList($userInfo)),
			]);
		return $this->renderJson(-1,'没有找到用户信息');
    }
    
    /**
     * 获取所有类型的订单详情信息
     * @param $type		string		类型		all（全部）uncollected（待发货）received（待收货）comment（待评论）refund（退款）
     * @return json|array
     */
    public function getAllOrder(){
    	// 当前用户信息
    	$userInfo = $this->getUser();
    	$type = input('post.type');
    	$search_order_no = input('post.search_order_no');
    	// 获取的是什么类型的订单
    	$model = new OrderModel;
    	if($userInfo){
    		if ($type != ''){
	    		$user_id = $userInfo['user_id'];
	    		$data = $model->getOrderDetaile($user_id,$type,$search_order_no);
	    		return $this->renderSuccess($data);
    		}
    		return $this->renderJson(-1,'非法请求');
    	}
    	return $this->renderJson(-1,'没有找到用户信息');
    }
    
    /**
     * 首页商品展示
     * @return array|json
     */
    public function Index(){
    	// 当前用户信息
    	$userInfo = $this->getUser();
    	if ($userInfo){
    		$ImagesModel = new Images();
    		$ItemModel = new Item();
    		$AdModel = new Ad();
    		// banner
    		$banner = $ImagesModel->getBanner();
    		// 公告
    		$notice = $AdModel->getNotice($userInfo);
    		// 积分商城1-----暂时不做
    		$data = [
    				'banner'=>$banner,
    				'notice'=>$notice,
    				'hot_goods'=>$ItemModel->getIndexGoods('hot',6),// 热门商品6
    				'new_goods'=>$ItemModel->getIndexGoods('new',5),// 最新商品3
    				'more_goods'=>$ItemModel->getIndexGoods('more',4),// 更多商品4
    		];
    		return $this->renderSuccess($data);
    	}
    	return $this->renderJson(-1,'没有找到用户信息');
    }
    
    /**
     * 每次登陆的时候都需要先调这个接口用户更新过了指定日期保护期的已收货商品
     */
    public function upOrderStatus(){
    	// 当前用户信息
    	$userInfo = $this->getUser();
    	// 更新订单状态
    	$model = new OrderModel;
    	// 查出指定日期是多少天
    	$day = 15;
    	// 查出所有已发货的订单
    	$orderIds = $model->getAllReceivedOrderId($userInfo['user_id'],$day);
    	$orderController = new \app\api\controller\Order();
    	for($i = 0; $i < count($orderIds); $i++){
    		$res[] = $orderController->receipt($orderIds[$i]);
    	}
    	if (!in_array(false, $res)){
    		return $this->renderSuccess('修改成功');
    	}
    }
    
    /**
     * 根据type值返回对应的商品信息【hot=>热门商品，new=>最新商品，more=>更多商品】
     */
    public function getGoodsForType(){
    	$ItemModel = new Item();
    	$type = input('post.type');
    	$data = $ItemModel->getIndexGoods($type);
    	return $this->renderSuccess($data);
    }
    
    /**
     * 获取当前用户的美豆明细
     */
    public function getMDdetail(){
    	// 当前用户信息
    	$userInfo = $this->getUser();
    	$model = new Mbhmd();
    	if ($userInfo){
    		$data = $model->getMdDatail($userInfo);
    		return $this->renderSuccess($data);
    	}
    	return $this->renderJson(-1,'没有找到用户信息');
    }
    
    /**
     * 获取收藏列表
     */
    public function getCollect(){
    	// 当前用户信息
    	$userInfo = $this->getUser();
    	$model = new Collect();
    	if ($userInfo){
    		$data = $model->getDetailData($userInfo['user_id']);
    		return $this->renderSuccess($data);
    	}
    	return $this->renderJson(-1,'没有找到用户信息');
    }
    
    /**
     * 添加收藏|取消收藏
     */
    public function addCollect(){
    	// 当前用户信息
    	$userInfo = $this->getUser();
    	$model = new Collect();
    	$goods_id = input('post.goods_id');
    	$status = input('post.status');
    	$data = [
    			'goods_id'=>$goods_id,
    			'user_id'=>$userInfo['user_id'],
    	];
    	// 查看有没有这个收藏记录，有则修改，无则添加
    	$check = $model->getDataByWhereFOS($data);
    	if ($check){
    		// 修改
    		$res = $model->upFieldByWhere($data,['status'=>$status]);
    	}else {
    		// 添加
    		$data['add_time'] = time();
    		$data['status'] = $status;
    		$res = $model->addDataByData($data);
    	}
    	if ($res){
    		if ($status == 1){
    			return $this->renderSuccess($data, '收藏成功');
    		}elseif ($status == 0){
    			return $this->renderSuccess($data, '取消收藏成功');
    		}
    	}
    	return $this->renderJson(-1,'收藏失败');
    }
    
    /**
     * 添加足迹
     */
    public function addFootprint(){
    	// 当前用户信息
    	$userInfo = $this->getUser();
    	$model = new User();
    	$goods_id = input('post.goods_id');
    	$where = ['user_id'=>$userInfo['user_id']];
    	$footpinrt = $model->getValueByWhere($where,'footprint');
    	if ($footpinrt == null){
    		$fp_arr = [];
    	}else {
    		$fp_arr = explode(',', $footpinrt);
    	}
    	// 如果这个商品id已经存在了就不加入了
    	if (!in_array($goods_id, $fp_arr)){
	    	$c_fp = count($fp_arr);
	    	// 只有一个就直接加
	    	if ($c_fp <= 0){
	    		$fp_arr[0] = $goods_id;
	    	// 少于10个在第N个加1加数据
	    	}elseif ($c_fp > 0 && $c_fp < 10){
	    		$fp_arr[$c_fp+1] = $goods_id;
	    	// 有了10个删除掉第一个，在第10+1加数据
	    	}elseif ($c_fp >= 10){
		    	$num = $c_fp - 10;
				for ($i=0; $i <= $num; $i++) { 
					unset($fp_arr[$i]);
				}
	    		$fp_arr[$c_fp+1] = $goods_id;
	    	}
	    	$data['footprint'] = implode(',', $fp_arr);
	    	$res = $model->upFieldByWhere($where, $data);
    	}
    	return $this->renderSuccess(true, '添加成功');
    }
    
    /**
     * 返回足迹的商品信息
     */
    public function getFootprintInfo(){
    	// 当前用户信息
    	$userInfo = $this->getUser();
    	$model = new User();
    	$where = ['user_id'=>$userInfo['user_id']];
    	$footpinrt = $model->getValueByWhere($where,'footprint');
    	$footpinrt = explode(',', $footpinrt);
    	$info = db('item')->where('goods_id','in',$footpinrt)->select();
    	return $this->renderSuccess($info);
    }
}