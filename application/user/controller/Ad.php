<?php
namespace app\user\controller;

use app\common\model\Ad as AdModel;
use app\common\model\Images as ImagesModel;
use app\common\model\UploadFile;
use think\Db;

/**
 * 公告列表
 * Class Agent
 * @package app\user\controller
 */
class Ad extends Controller
{
	/**
	 * 公告列表
	 * @param string $nickName
	 * @param unknown $gender
	 * @param unknown $pid
	 * @param string $type
	 */
    public function index($nickName = '', $gender = null,$pid=null)
    {
        $model = new AdModel;
        $list = $model->getList(trim($nickName));
        $page=$list->render();
        return $this->fetch('index', compact('list','page'));
    }
    
    /**
     * 海报列表
     * @param string $nickName
     * @param unknown $gender
     * @param unknown $pid
     * @param string $type
     */
    public function banner()
    {
    	$model = new ImagesModel;
    	$list = $model->getList();
    	$page=$list->render();
    	return $this->fetch('banner', compact('list','page'));
    }
    
    /**
     * 添加海报图
     */
    public function bannerAdd(){
        // 商品列表
        $itemList = Db::name('item')->where('is_on_sale',1)->select();

    	if (!$this->request->post()) {
    		return $this->fetch('banner_save', compact('itemList'));
    	}
    	$post = input('post.');
    	$UploadModel = new UploadFile();
    	$post['image_url'] = $UploadModel->getDataByWhere(['id'=>$post['image_id']]);
    	// 将用户信息存库
    	$model = new ImagesModel;
    	$post['update_time'] = time();
    	$post['create_time'] = time();
    	$post['is_delete'] = 0;
    	$post['type'] = 'banner';
    	$post['app_id'] = 10001;
    	$res = $model->save($post);
    	if ($res){
    		return $this->success('操作成功', url('ad/banner'));
    	}else {
    		return $this->error('操作失败', url('ad/banner'));
    	}
    }
    
    /**
     * 修改海报图
     */
    public function bannerEdit($id){
        // 商品列表
        $itemList = Db::name('item')->where('is_on_sale',1)->select();

    	$model = new ImagesModel;
    	$where = ['id'=>$id];
    	if (!$this->request->post()) {
	    	if ($id){
	    		$list = $model->getDataByWhere($where);
	    		return $this->fetch('banner_save', compact('list','itemList'));
	    	}
    	}
    	$UploadModel = new UploadFile();
    	$post = input('post.');
    	$post['image_url'] = $UploadModel->getDataByWhere(['id'=>$post['image_id']]);
    	$data = [
            'image_id'=>$post['image_id'],
            'image_url'=>$post['image_url'],
            'url'=>$post['url']
        ];
    	$res = $model->upFieldByWhere($where, $data);

        return $this->success('操作成功', url('ad/banner'));
   /* 	if ($res){
    		return $this->success('操作成功', url('ad/banner'));
    	}else {
    		return $this->error('操作失败', url('ad/banner'));
    	}*/
    }
    
    /**
     * 添加公告
     */
    public function add(){
    	if (!$this->request->post()) {
    		return $this->fetch('save');
    	}
    	$post = input('post.');
    	// 将用户信息存库
    	$model = new AdModel;
    	$post['update_time'] = time();
    	$post['create_time'] = time();
    	$post['is_delete'] = 0;
    	$post['app_id'] = 10001;
    	$res = $model->save($post);
    	if ($res){
    		return $this->success('操作成功', url('ad/index'));
    	}else {
    		return $this->error('操作失败', url('ad/index'));
    	}
    }
    
    /**
     * 修改公告
     */
    public function edit($id){
    	$model = new AdModel;
    	$where = ['id'=>$id];
    	if (!$this->request->post()) {
	    	if ($id){
	    		$list = $model->getDataByWhere($where);
	    		return $this->fetch('save', compact('list'));
	    	}
    	}
    	$post = input('post.');
    	$res = $model->upFieldByWhere($where, ['content'=>$post['content'],'title'=>$post['title']]);
    	if ($res){
    		return $this->success('操作成功', url('ad/index'));
    	}else {
    		return $this->error('操作失败', url('ad/index'));
    	}
    }
}