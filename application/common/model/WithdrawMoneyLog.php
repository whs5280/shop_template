<?php
namespace app\common\model;
use think\Db;
/**
 * 分销商提现明细模型
 * Class Apply
 * @package app\common\model\dealer
 */
class WithdrawMoneyLog extends BaseModel
{
	protected $name = 'withdraw_money_log';
	protected $pk = 'id';
	
	/**
	 * 给对应的$table表加可提现金额，加日志
	 * @param string $table
	 * @param number $money
	 * @param number $type 		2=>供应商方用户订单完成.3=>推广员方用户订单完成.4=>推广员方用户充值.5=>推广员方用户注册
	 * @param number $user_id
	 * @param number $order_id
	 * @return boolean
	 */
	public function addWithdrawMoneyLog($table = '', $money = 0, $type = 0, $user_id = 0, $order_id = 0){
		// 验证参数是否正确
		if (($type > 1 && $type < 6) && ($table == 'supplier' || $table == 'agent') && $money > 0 && $user_id > 0){
			// 加可提现余额
			$where = '';
			$field = '';
			switch ($table) {
				case 'supplier':// 供应商
					$where = ['user_id'=>$user_id];
					$field = 'withdraw_money';
					break;
				case 'agent':// 推广员
					$where = ['agent_id'=>$user_id];
					$field = 'profit';
					break;
			}
			if ($where != '' && $field != ''){
				// 加钱
				$res1 = Db::name($table)->where($where)->setInc($field,$money);
				if ($res1){
					switch ($type) {
						case 2:
							$desc = '供应商方用户订单完成';
							break;
						case 3:
							$desc = '推广员方用户订单完成';
							break;
						case 4:
							$desc = '推广员方用户充值';
							break;
						case 5:
							$desc = '推广员方用户注册';
							break;
						
						default:
							return false;
							break;
					}
					$data = [
							'user_id'=>$user_id,
							'order_id'=>$order_id,
							'desc'=>$desc,
							'balance_money'=>$money,
							'type'=>$type,
							'add_time'=>time(),
					];
					$res2 = $this->allowField(true)->insertGetId($data);
					if ($res2){
						return true;
					}
				}
			}
		}
		return false;
	}
}