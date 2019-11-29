<?php

namespace app\common\model;

/**
 * 订单模型
 * Class Order
 * @package app\api\model
 */
class OrderDelivery extends BaseModel
{
    protected $name = 'order_delivery';
	
	
	public static function getAll($order_no){	
	
		$a=self::where('order_no',$order_no)->all();

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
