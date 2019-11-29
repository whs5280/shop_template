<?php
namespace app\user\controller;

use app\common\model\AgentInfo;
use app\common\model\AgentRecord;
use app\common\model\Withdraw as WithdrawModel;
/**
 * 提现管理
 * Class Withdraw
 * @package app\user\controller
 */
class Withdraw extends Controller
{
    /**
     * @param null $user_id
     * @param int $apply_status
     * @param int $pay_type
     * @param string $search
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index($user_id = null, $apply_status = -1, $pay_type = -1, $search = '')
    {
        $model = new WithdrawModel;
        $list = $model->getList($user_id, $type = 3, $apply_status, $pay_type, $search);  //type=3 供应商
        $page=$list->render();
        return $this->fetch('index', compact('list','page'));
    }

    /**
     * 同意提现申请
     * @param $id
     * @return array
     */
    public function pass($id)
    {
        $model = new WithdrawModel;
        $res = $model->pass($id);
        if ($res!==true) {
            return $this->renderError('操作失败');
        }
        return $this->renderSuccess('操作成功');
    }

    /**
     * 驳回提现申请
     * @param $id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function refuse($id)
    {
        $model = new WithdrawModel;
        $res = $model->refuse($id);
        if ($res!==true) {
            return $this->renderError('操作失败');
        }

        $withdraw = $model->where('id', $id)->find();
        // 提现驳回：解冻推广员资金
        AgentInfo::backFreezeMoney($withdraw['user_id'], $withdraw['money']);
        return $this->renderSuccess('操作成功');
    }

    /**
     * 确定打款
     * @param $id
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function remit($id)
    {
        $model = new WithdrawModel;
        $withdraw = $model->where('id', $id)->find();
        $res = $model->remit($id);
        if ($res!==true) {
            return $this->renderError('操作失败');
        }

        // 更新推广员累积提现佣金
        $model = new AgentInfo;
        AgentInfo::totalMoney($withdraw['user_id'], $withdraw['money']);
        $model->cumulateWithdraw($withdraw['user_id'], $withdraw['money']);
        // 记录推广员资金明细
        $data = [
            'award_type' => 400,
            'money' => -$withdraw['money'],
            'describe' => '成功提现了' . $withdraw['money'] . '元',
        ];
        $model2 = new AgentRecord;
        $res = $model2->addRecord($withdraw['user_id'], $data);
        return $this->renderSuccess('操作成功');
    }


    /**************************供应商****************************/


    /**
     * @param null $user_id
     * @param int $apply_status
     * @param int $pay_type
     * @param string $search
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function supplier($user_id = null, $apply_status = -1, $pay_type = -1, $search = '')
    {
        $model = new WithdrawModel;
        $list = $model->getList($user_id, $type = 2, $apply_status, $pay_type, $search);  //type=2 代表供应商
        $page=$list->render();
        return $this->fetch('index', compact('list','page'));
    }

    /**
     * 驳回提现申请
     * @param $id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function refuse_supplier($id)
    {
        $model = new WithdrawModel;
        $res = $model->refuse($id);
        if ($res!==true) {
            return $this->renderError('操作失败');
        }
        return $this->renderSuccess('操作成功');
    }

    /**
     * 确定打款
     * @param $id
     * @return array
     * @throws \think\Exception
     */
    public function remit_supplier($id)
    {
        $model = new WithdrawModel;
        $withdraw = $model->where('id', $id)->find();
        $res = $model->remit($id);
        if ($res!==true) {
            return $this->renderError('操作失败');
        }

        // 其他操作
        return $this->renderSuccess('操作成功');
    }
}