<?php
namespace app\common\model;
/**
 * 图片管理
 * Class Cart
 * @package app\api\model
 */
class Images extends BaseModel
{
	protected $name = 'images';
	protected $pk = 'id';
	
	/**
	 * 返回首页banner
	 */
	public function getBanner(){
		$data = $this->where(['type'=>'banner'])->select();
		if ($data){
			return $data;
		}
		return false;
	}
}