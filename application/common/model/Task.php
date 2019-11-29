<?php
namespace app\common\model;

use think\Db;
use think\facade\Request;
/**
 * 推广员任务模型
 * Class TaskModel
 * @package app\common\model
 */
class Task extends BaseModel
{
    protected $name = 'agent_task';
    protected $pk = 'task_id';

    /***********************任务机制start**************************/
    /**
     * 推广员的任务奖励
     * @method
     * @return bool
     * @throws \think\Exception
     */
    public function after_update($obj)
    {
        // 推广员的任务奖励
        if ($obj['status'] == 3) {
            try {
                $model = new AgentRecord();
                $model2 = new AgentInfo();
                $model->startTrans();
                $model2->startTrans();

                $res = $model->addRecord($obj['agent_id'], [
                    'award_type' => 300,
                    'money' => $obj['bonus'],
                    'describe' => '成功完成了任务' . $obj['task_id'] . ',获得奖励' . $obj['bonus'] . '元',
                    'app_id' => self::$app_id,
                ]);
                if (!$res) {
                    return false;
                }
                $res = $model2->cumulateProfit2($obj['agent_id'], $obj['bonus']);
                if (!$res) {
                    return false;
                }
                $res = $model2->cumulateProfit($obj['agent_id'], $obj['bonus']);
                if (!$res) {
                    return false;
                }

                $model->commit();
                $model2->commit();
                return true;
            } catch (\Exception $e) {
                $model->rollback();
                $model2->rollback();
                return false;
            }
        }
    }
    /**
     * 人头任务机制
     * @param $invite_total
     * @return mixed
     */
    public function invite_task($agent_id, $invite_total)
    {
        if ($invite_total >= 1) {
            return $this->updateTask($agent_id, 1);
        }
        if ($invite_total >= 3) {
            return $this->updateTask($agent_id, 2);
        }
    }
    /**
     * 下单任务机制
     * @param $order_total
     * @return mixed
     */
    public function order_task($agent_id, $order_total)
    {
        if ($order_total >= 1) {
            return $this->updateTask($agent_id, 3);
        }
        if ($order_total >= 3) {
            return $this->updateTask($agent_id, 4);
        }
    }
    /**
     * 更改任务状态
     * @param $agent_id
     * @param $task_id
     * @return mixed
     */
    private function updateTask($agent_id, $task_id)
    {
        $filter = [
            'agent_id' => $agent_id,
            'task_id' => $task_id
        ];
        // 写入日志
        $this->dologs('task', [
            'agent_id' => $agent_id,
            'task_id' => $task_id
        ]);
        return $this->isUpdate(true)->save(['status' => 2], $filter);
    }
    /**
     * 记录日志
     * @param $method
     * @param array $params
     * @return bool|int
     */
    private function dologs($method, $params = [])
    {
        $value = 'Task --' . $method;
        foreach ($params as $key => $val)
            $value .= ' --' . $key . ' ' . $val;
        return write_log($value, __DIR__);
    }
    /***********************任务机制end**************************/


    /**
     * 任务列表
     * @param $user_id
     * @return false|static[]
     * @throws \think\exception\DbException
     */
    public function getList($agent_id)
    {
        return $this->alias('a')
            ->field('a.*,t.*')
            ->join('task t', 'a.task_id=t.task_id', 'left')
            ->where('agent_id', $agent_id)
            ->order('id', 'asc')
            ->select();
    }
    /**
     * 接收任务
     * @param $data
     * @return false|int
     */
    public function add($data)
    {
        // 接收任务
        return $this->allowField(true)->save(['status' => 1],['id' => $data['id']]);
    }
    /**
     * 放弃任务
     * @param $data
     * @return false|int
     */
    public function del($data)
    {
        // 放弃任务
        return $this->allowField(true)->save(['status' => 4],['id' => $data['id']]);
    }
    /**
     * 审核任务
     * @param $data
     * @return false|int
     */
    public function check($data)
    {
        // 审核任务
        return $this->allowField(true)->save(['status' => 2],['id' => $data['id']]);
    }
    /**
     * 完成任务
     * @param $id
     * @return bool
     * @throws \think\Exception
     */
    public function pass($id){
        // 完成任务
        $this->allowField(true)->save(['status' => 3],['id' => $id]);
        $obj = self::get($id);
        return $this->after_update($obj);
    }
    /**
     * 注册时自动创建任务列表
     * @param $agent_id
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function autoCreateTask($agent_id)
    {
        // 注册时自动创建任务列表
        $info = Db::name('task')->select();
        foreach ($info as $item) {
            $this->isUpdate(false)->save([
                'agent_id' => $agent_id,
                'task_id' => $item['task_id'],
                'bonus' => $item['bonus'],
                'create_time' => time()
            ]);
        }
        return true;
    }

    /**
     * 后台任务列表
     * @param string $status
     * @param int $listRows
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getAll($status=-1,$listRows = 15)
    {
        $status >0 ? $where[]=['status','=',$status] : $where[]=['status','<>',0];
        $where[]=['status','<>',4];
        return $this->alias('a')
            ->field('a.*,t.*')
            ->join('task t','a.task_id=t.task_id', 'left')
            ->where($where)
            ->order('a.create_time', 'desc')
            ->paginate($listRows, false, [
                'query' => Request::instance()->request()
            ]);
    }
}