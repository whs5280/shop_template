<?php
namespace app\user\controller;

use app\common\model\OrderSupplierByUser;
use app\common\model\Supplier as SupplierModel;
use app\common\model\Category as CategoryModel;
use app\common\model\UploadFile;
use app\common\model\User as UserModel;
use app\common\model\Item as ItemModel;
use app\common\model\OrderSupplierByPlat;
use app\common\model\Returnbuy;
use think\Db;
use think\facade\Cache;

/**
 * 供应商列表
 * Class Agent
 * @package app\user\controller
 */
class Supplier extends Controller
{
	/**
	 * 供应商列表
	 * @param string $nickName
	 * @param unknown $gender
	 * @param unknown $pid
	 * @param string $type
	 */
    public function index($nickName = '', $gender = null,$pid=null,$type='')
    {
        $model = new SupplierModel;
        $list = $model->getList(trim($nickName),$type);
        $page=$list->render();
        return $this->fetch('index', compact('list','page'));
    }
    
    /**
     * 供应商商品（仅供平台下单）
     * @param number $plat_id
     * @param number $status
     * @param unknown $category_id
     * @param string $name
     * @param string $market
     * @return mixed
     */
    public function supplierGoods($plat_id = 0,$status = 1, $category_id = null, $name = '', $market = '')
    {
        // 商品分类
        $catgory = (new CategoryModel)->getSortCategory();
        // 商品列表
        $model = new ItemModel;
        $list = $model->getList($status, $category_id, $name,$market);
        if(empty($market)){
			return $this->fetch('supplier_goods', compact('list','catgory'));
		}
		return $this->fetch('supplier_goods', compact('list','catgory'));
    }
    
    /**
     * 商品规格
     */
    public function goodsSku(){
    	if (!$this->request->post) {
    		$goods_id = input('goods_id');
    		$data = ItemModel::detail($goods_id)['sku'];
    		return $this->fetch('goods_buy', compact('data'));
    	}
    	return $this->error('请求错误');
    }
    
    /**
     * 平台下订
     */
    public function goodsBuy(){
    	$post = input('post.sku');
    	$model = new OrderSupplierByPlat();
    	// 获取商品库存，对比库存是否足够
    	foreach ($post as $key=>$value){
            if ($value['number'] == "" || $value['number'] == 0) {
                unset($post[$key]);
            } else {
                if ($value['store_count'] < $value['number']){
                    return $this->error('您选购的商品库存不足', url('supplier/suppliergoods'));
                }
                $order = $model->getBuyNow($value['goods_id'], $value['number'], $value['key'], '', '');
                if (!$model->createOrder(0, $order)){
                    return $this->error('订单创建失败', url('supplier/suppliergoods'));
                }
            }
    	}
    	return $this->success('下单成功', url('supplier/suppliergoods'));
    }
    
    /**
     * 查看平台向供应商购买的订单
     */
    public function platOrder(){
    	$model = new OrderSupplierByPlat();
    	$list = $model->getAllDataByWhere(['a.pay_status'=>10], ['a.order_id'=>'desc']);
    	foreach ($list as &$item) {
    	    $item['supplier_name'] = Db::name('user')->where('user_id', $item['plat_id'])->value('nickName');
        }

    	$page=$list->render();
    	return $this->fetch('plat_order', compact( 'list','page'));
    }
    
    /**
     * 平台退订
     */
    public function returnGoods($order_id){
    	$OrderModel = new OrderSupplierByPlat;
    	$model = $OrderModel->getDataByWhere(['order_id'=>$order_id]);
    	// 修改状态
    	$OrderModel->upFieldByWhere(['order_id'=>$order_id],['order_status'=>40,'sub_status'=>10,'sub_type'=>1]);
    	// 将退款信息存入表中
    	$data = [
    			'type'=>2,
    			'content'=>'平台下订，不要了',
    			'order_id'=>$order_id,
    			'order_no'=>$model['order_no'],
    			'status'=>1,// 审核中
    			'user_id'=>0,
    			'is_delete'=>0,
    			'create_time'=>time(),
    			'update_time'=>time(),
    	];
    	$returnbuy_model = new Returnbuy();
    	$res = $returnbuy_model->insert($data);
    	return $this->success('申请退款成功，请耐心等待');
    }
    
    /**
     * 添加供应商
     */
    public function addSupplier(){
    	$CategoryModel = new CategoryModel;
    	$category = $CategoryModel->getALLByWhere();
    	if (!$this->request->post()) {
    		return $this->fetch('save',compact('category'));
    	}
    	$post = input('post.');
    	// 将用户信息存库
    	$User = new UserModel;
    	// 处理密码
    	$post['password'] = wymall_pass($post['password']);
    	$user_id = $User->reg(['phone'=>$post['phone'],'type'=>2,'password'=>$post['password']]);
    	if (!$user_id){
    		return $this->error('该号码已注册，不可重复使用', url('supplier/index'));
    	}
    	$post['user_id'] = $user_id;
    	// 找到图片，根据id查出图片路径
    	$UploadFile = new UploadFile();
    	$post['store_pic'] = $UploadFile->getFileName($post['brand']['logo']);
    	unset($post['brand']);
    	// 处理分类
    	$post['category'] = implode(',', $post['category']);
    	$post['create_time'] = time();
    	$post['pass_time'] = time();// 暂时直接通过
    	$Supplier = new SupplierModel;
    	$res = $Supplier->save($post);
    	if ($res){
    		return $this->success('操作成功', url('supplier/index'));
    	}else {
    		return $this->error('操作失败', url('supplier/index'));
    	}
    }

    // 查看周边供应商
    public function getNeighbor($distance = 5000)
    {
        $user_id = input('user_id');
        $model = new \app\common\model\Supplier();
        $supplier = $model->where('user_id', $user_id)->find();
        $latitude = $supplier['latitude'];
        $longitude = $supplier['longitude'];

        /*if (!$data = Cache::get($latitude. '_' . $longitude)) {
            $data = $model->getNeighbor($latitude, $longitude, $distance);
            Cache::set($latitude. '_' . $longitude, json_encode($data));
        }*/
        $data = $model->getNeighbor($latitude, $longitude, $distance);
        return json($data);
    }

    /**
     * 查看平台帮供应商代发的订单
     */
    public function subOrder(){
        $model = new OrderSupplierByUser();
        $where = [
            'order_id' => ['>', 0],
        ];
        $list = $model->getAllDataByWhere(['pay_status'=>10]);
        $page=$list->render();
        return $this->fetch('sub_order', compact( 'list','page'));
    }

    public function getSUpplierName($plat_id)
    {
        return Db::name('user')->where('user_id', $plat_id)->value('nickName');
    }
}