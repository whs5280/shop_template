<?php
namespace app\common\model;
/**
 * 付款信息管理
 * Class Cart
 * @package app\api\model
 */
class PayInfo extends BaseModel
{
	protected $name = 'pay_info';
	protected $pk = 'id';

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
	
	/**
	 * 添加数据
	 * @param unknown $data
	 */
	public function addData($data){
		if (is_array($data)){
			$res = $this->allowField(true)->insertGetId($data);
			if ($res){
				return $res;
			}
		}
		return false;
	}
}