<?php
namespace app\common\model;

use think\facade\Request;
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
	
	/**
	 * 获取用户列表
	 * @param string $nickName
	 * @param null $gender
	 * @return \think\Paginator
	 * @throws \think\exception\DbException
	 */
	public function getList($listRows = 15)
	{
		$where['type'] = 'banner';
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

	/**
	 * 根据where条件修改数据
	 * @param unknown $where
	 * @return unknown|boolean
	 */
	public function upFieldByWhere($where,$data){
		if (is_array($where) && is_array($data)){
			$res = $this->where($where)->update($data);
			if ($res){
				return $res;
			}
		}
		return false;
	}
}