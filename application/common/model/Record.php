<?php
namespace app\common\model;
/**
 * 图片管理
 * Class Cart
 * @package app\api\model
 */
class Record extends BaseModel
{
	protected $name = 'record';
	protected $pk = 'id';
	
	/**
	 * 添加记录
	 * @param unknown $order_id				订单id
	 * @param unknown $pay_price			订单价格
	 * @param unknown $user_id				用户id
	 * @param unknown $way					0支付，1退款，2返利
	 * @param unknown $exchange_integral	积分
	 */
	public function addRecord($order_id,$pay_price,$user_id,$way,$exchange_integral){
		$record_log_data = [
    			'order_id'=>$order_id,
    			'money'=>$pay_price,
    			'way'=>$way,
    			'is_integral'=>1,
    			'user_id'=>$user_id,
    			'add_time'=>time()
    	];
    	if ($exchange_integral > 0){
    		$record_log_data_integral = $record_log_data;
    		$record_log_data_integral['money'] = $exchange_integral;
    		$record_log_data_integral['is_integral'] = 0;
    		$this->insert($record_log_data_integral);
    	}
    	$res = $this->insert($record_log_data);
    	if ($res){
    		return true;
    	}
    	return false;
	}
}