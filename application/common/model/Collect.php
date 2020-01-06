<?php
namespace app\common\model;

/**
 * 图片管理
 * Class Cart
 * @package app\api\model
 */
class Collect extends BaseModel
{
	protected $name = 'collect';
	protected $pk = 'collect_id';
	
	/**
	 * 获取收藏的商品详情
	 */
	public function getDetailData($user_id){
		if ($user_id){
			$data = $this
						->alias('a')
						->join('bfb_item b', 'a.goods_id = b.goods_id')
						->where(['a.user_id'=>$user_id,'a.status'=>1])
						->select();
			if ($data){
				return $data;
			}
		}
		return false;
	}
	
	/**
	 * 根据where条件返回数据
	 * @param unknown $where
	 * @return unknown|boolean
	 */
	public function getDataByWhereFOS($where, $find = 'find', $order = ''){
		if ($where){
			if ($find == 'find'){
				$data = $this->where($where)->order($order)->find();
			}elseif ($find == 'select'){
				$data = $this->where($where)->order($order)->select();
			}
			if ($data){
				return $data;
			}
		}
		return false;
	}
	
	/**
	 * 添加数据
	 * @param unknown $data
	 * @return unknown|boolean
	 */
	public function addDataByData($data){
		if (is_array($data)){
			$res = $this->allowField(true)->insertGetId($data);
			if ($res){
				return $res;
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