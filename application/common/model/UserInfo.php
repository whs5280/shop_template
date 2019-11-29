<?php
namespace app\common\model;
/**
 * 商户管理
 * Class Cart
 * @package app\api\model
 */
class UserInfo extends BaseModel
{
	protected $name = 'user_info';
	protected $pk = 'id';
	
	public function Verify($data){
		if (is_array($data)){
			$res = $this->allowField(true)->save($data);
			if ($res){
				return true;
			}
		}
		return false;
	}
}