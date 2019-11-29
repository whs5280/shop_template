<?php
namespace app\common\model;
/**
 * 公告管理
 * Class Cart
 * @package app\api\model
 */
class Ad extends BaseModel
{
	protected $name = 'ad';
	protected $pk = 'id';
	
	protected $hidden = [
			'app_id',
	];
	
	/**
	 * 获取公告
	 */
	public function getNotice(){
		$data = $this->where(['is_delete'=>0])->select();
		if ($data){
			return $data;
		}
		return false;
	}
}