<?php
namespace app\common\model;

use think\facade\Request;
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
	public function getNotice($userInfo){
		$data = $this->where(['is_delete'=>0])->select();
		if ($data){
			return $data;
		}
		return false;
	}
	
	/**
	 * 获取用户列表
	 * @param string $nickName
	 * @param null $gender
	 * @return \think\Paginator
	 * @throws \think\exception\DbException
	 */
	public function getList($nickName = '', $listRows = 15)
	{
		if(!empty($nickName))
			$where['is_delete'] = 0;
			$where[]=['title', 'like', "%$nickName%"];
			return $this->where($where)
			->order('create_time desc')
			->paginate($listRows, false, [
					'query' => Request::instance()->request()
			]);
	}
	
	/**
	 * 根据where条件返回数据
	 * @param unknown $where
	 * @return unknown|boolean
	 */
	public function getDataByWhere($where){ 
		if ($where){
			$data = $this->where($where)->find();
			if ($data){
				return $data;
			}
		}
		return false;
	}
}