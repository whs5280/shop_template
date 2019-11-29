<?php
namespace app\common\model;
/**
 * 平台代发
 * Class Cart
 * @package app\api\model
 */
class OrderSupplierByUser extends BaseModel
{
	protected $name = 'order_supplier_by_user';
	protected $pk = 'order_id';
	
	/**
	 * 获取订单总数（供应商）
	 * @param $user_id
	 * @param string $type
	 * @return int|string
	 */
	public function getSupplierCount($user_id, $type = 'all')
	{
		// 筛选条件
		$filter = [];
		// 订单数据类型
		switch ($type) {
			case 'all':
				break;
			case 'payment';
				$filter['pay_status'] = 10;
				break;
			case 'uncollected';
				$filter['delivery_status'] = 10;// 未发货
				break;
			case 'received';
				$filter['delivery_status'] = 20;
				$filter['receipt_status'] = 10;// 未收货
				break;
			case 'comment';
				$filter['order_status'] = 30;
				$filter['is_comment'] = 0;
				break;
			case 'refund';
				$filter['order_status'] = 40;// 退款
				break;
		}
		return $this->where('plat_id', '=', $user_id)
		->where('order_status', '<>', 20)
		->where($filter)
		->count();
	}
	
	/**
	 * 获取订单详情（供应商）
	 * @param $user_id
	 * @param string $type
	 * @return int|string
	 */
	public function getSupplierOrderDetail($user_id, $type = 'all')
	{
		// 筛选条件
		$filter = [];
		// 订单数据类型
		switch ($type) {
			// 全部订单
			case 'all':
				break;
				// 待付款（一般用不上）
			case 'payment';
				$filter['pay_status'] = 10;
				break;
			// 待发货
			case 'uncollected';
				$filter['delivery_status'] = 10;// 未发货
				break;
			// 待收货
			case 'received';
				$filter['delivery_status'] = 20;
				$filter['receipt_status'] = 10;// 未收货
				break;
			// 待评论
			case 'comment';
				$filter['order_status'] = 30;
				$filter['is_comment'] = 0;
				break;
			// 退款
			case 'refund';
				$filter['order_status'] = 40;// 退款
				break;
		}
		return $this->where('plat_id', '=', $user_id)
		->where('order_status', '<>', 20)
		->where($filter)
		->select();
	}
}