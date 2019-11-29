<?php
namespace app\common\model;

use think\facade\Request;
/**
 * 退款管理
 * Class Returnbuy
 * @package app\api\model
 */
class Returnbuy extends BaseModel
{
	protected $name = 'returnbuy';
	protected $pk = 'id';
	
	/**
	 * 获取发出退款申请的用户
	 */
	public function getLists(){
		$data = $this->where(['is_delete'=>0])
					->order(['status'=>'asc','create_time' => 'desc'])
					->paginate(10, false, [
							'query' => Request::instance()->request()
					]);
		return $data;
	}
	
	/**
	 * 修改申请单的状态
	 * @param unknown $id
	 * @param unknown $status
	 */
	public function upStatus($id,$status){
		if ($id && $status){
			$res = $this->where(['id'=>$id])->update(['status'=>$status]);
			if ($res){
				return true;
			}
		}
		return false;
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