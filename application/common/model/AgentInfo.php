<?php
namespace app\common\model;

/**
 * 推广员信息
 * Class AgentInfo
 * @package app\common\model
 */
class AgentInfo extends BaseModel
{
    protected $name = 'agent';
    protected $pk = 'agent_id';

    /**
     * 推广员详情
     * @param $agent_id
     * @return mixed
     */
    public static function detail($agent_id)
    {
        return self::get($agent_id);
    }
    /**
     * 累积邀请人数
     * @param $agent_id
     * @return int|true
     * @throws \think\Exception
     */
    public function cumulateNum1($agent_id)
    {
        return $this->where('agent_id',$agent_id)->setInc('num1', 1);
    }
    /**
     * 累积充值会员人数
     * @param $agent_id
     * @return int|true
     * @throws \think\Exception
     */
    public function cumulateNum2($agent_id)
    {
        return $this->where('agent_id',$agent_id)->setInc('num2', 1);
    }
    /**
     * 累积订单数量
     * @param $agent_id
     * @return int|true
     * @throws \think\Exception
     */
    public function cumulateNum3($agent_id)
    {
        return $this->where('agent_id',$agent_id)->setInc('num3', 1);
    }
    /**
     * 充值会员返利
     * @param $agent_id
     * @return int|true
     * @throws \think\Exception
     */
    public function cumulateProfit4($agent_id)
    {
        // 充值会员返利
        $agent = $this->where('agent_id', $agent_id)->find();
        $num2 = $agent['num2'] + 1;
        $price = invite_leave($num2);  //阶级价格
        $data = [
            'num2' => $num2,
            'profit4' => $price * $num2,
            'profit' => $agent['profit'] + ($price * $num2 - $agent['profit4']), //原先的利润 + 返差的利润
        ];
        return $this->allowField(true)->save($data, ['agent_id' => $agent_id]);
    }
    /**
     * 资金冻结
     * @param $agent_id
     * @param $money
     * @return false|int
     */
    public static function freezeMoney($agent_id, $money)
    {
        $model = self::get($agent_id);
        return $model->save([
            'profit' => $model['profit'] - $money,
            'freeze_money' => $model['freeze_money'] + $money
        ]);
    }
    /**
     * 提现驳回：解冻推广员资金
     * @param $agent_id
     * @param $money
     * @return false|int
     * @throws \think\exception\DbException
     */
    public static function backFreezeMoney($agent_id, $money)
    {
        $model = self::get($agent_id);
        return $model->save([
            'profit' => $model['profit'] + $money,
            'freeze_money' => $model['freeze_money'] - $money
        ]);
    }
    /**
     * 提现打款成功：累积提现佣金
     * @param $agent_id
     * @param $money
     * @return false|int
     * @throws \think\exception\DbException
     */
    public static function totalMoney($agent_id, $money)
    {
        $model = self::get($agent_id);
        return $model->save([
            'freeze_money' => $model['freeze_money'] - $money,
        ]);
    }
    /**
     * 累积人头收益
     * @param $agent_id
     * @param $money
     * @return int|true
     * @throws \think\Exception
     */
    public function cumulateProfit1($agent_id, $money)
    {
        return $this->where('agent_id',$agent_id)->setInc('profit1', $money);
    }
    /**
     * 累积任务奖金
     * @param $agent_id
     * @param $money
     * @return int|true
     * @throws \think\Exception
     */
    public function cumulateProfit2($agent_id, $money)
    {
        return $this->where('agent_id',$agent_id)->setInc('profit2', $money);
    }
    /**
     * 累积订单佣金
     * @param $agent_id
     * @param $order_money
     * @return int|true
     * @throws \think\Exception
     */
    public function cumulateProfit3($agent_id, $order_money)
    {
        $model = new User;
        $is_new = $model->where('user_id', $agent_id)->value('is_new');
        // 推广员提成比率
        $rate = agent_order_rate($is_new);
        // 订单佣金,四舍五入保留2位
        $money = round($order_money * $rate,2);
        return $this->where('agent_id',$agent_id)->setInc('profit3', $money);
    }
    /**
     * 累积总利润
     * 累积总利润
     * @param $agent_id
     * @param $money
     * @return int|true
     * @throws \think\Exception
     */
    public function cumulateProfit($agent_id, $money)
    {
        return $this->where('agent_id',$agent_id)->setInc('profit', $money);
    }
    /**
     * 累积提现金额
     * @param $agent_id
     * @param $money
     * @return int|true
     * @throws \think\Exception
     */
    public function cumulateWithdraw($agent_id, $money)
    {
        return $this->where('agent_id',$agent_id)->setInc('withdraw_money', $money);
    }
}