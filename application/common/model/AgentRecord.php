<?php
namespace app\common\model;

/**
 * 佣金记录模型
 * Class AgentRecord
 * @package app\common\model
 */
class AgentRecord extends BaseModel
{
    protected $name = 'agent_record';
    protected $pk = 'id';

    /**
     * 佣金记录列表
     * @param $user_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function getAll($agent_id)
    {
        return $this->where('agent_id', $agent_id)
            ->order('create_time','desc')
            ->select();
    }
    /**
     * 生成佣金记录
     * @param null|static $user
     * @param $data
     * @return false|int
     */
    public function addRecord($agent_id, $data)
    {
        // 生成佣金记录
        return $this->allowField(true)->save(array_merge([
            'agent_id' => $agent_id,
            'create_time' => time()
        ], $data));
    }
    /**
     * 累计佣金
     * @param $agent_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function money_total($agent_id)
    {
        // 累计佣金
        return $this->field('agent_id,sum(money) as money_total')
            ->where('agent_id', $agent_id)
            ->where('award_type', '<>' ,400)
            ->select();
    }
    /**
     * 累计提现
     * @param $agent_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function withdraw_total($agent_id)
    {
        // 累计提现
        return $this->field('agent_id,sum(money) as withdraw_total')
            ->where('agent_id', $agent_id)
            ->where('award_type', '=', 400)
            ->select();
    }
}