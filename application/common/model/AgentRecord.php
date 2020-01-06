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
    public function getAll($agent_id, $award_type = -1, $start = '', $end = '')
    {
        $where[] = ['agent_id', '=', $agent_id];
        $award_type == -1 && $where[] = ['award_type', '<>', 400];
        $award_type > 0 && $where[] = ['award_type', '=', $award_type];

        if (isset($start) && trim($start) != '' ) {
            $where[] = ['create_time', '>=', $start];
        }
        if (isset($end) && trim($end) != '' ) {
            $where[] = ['create_time', '<=', $end];
        }
        if (isset($start) && trim($start) != '' && isset($end) && trim($end) != '') {
            $where[] = ['create_time', 'between', [$start,$end]];
        }
        return $this->where('agent_id', $agent_id)
            ->where($where)
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
    /**
     * 佣金分类统计
     * @param $agent_id
     * @param $award_type
     * @return float|string
     */
    public function CountByProfit($agent_id, $award_type)
    {
        $where[] = ['agent_id', '=', $agent_id];
        $where[] = ['award_type', '=', $award_type];

        return $this->where($where)
            ->order('create_time','desc')
            ->count();
    }
}