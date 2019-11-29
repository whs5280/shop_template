<?php
namespace app\common\model;
/**
 * 会员卡管理
 * Class Cart
 * @package app\api\model
 */
class Mbhmd extends BaseModel
{
	protected $name = 'mbhmd';
	protected $pk = 'id';
	
	/**
	 * 获取当前用户的美豆明细
	 * @param unknown $user
	 * @return array|mixed
	 */
	public function getMdDatail($user){
		if ($user){
			$data = $this->where(['user_id'=>$user['user_id']])->order('add_time desc')->select();
			if ($data){
				return $data;
			}
		}
		return false;
	}
}