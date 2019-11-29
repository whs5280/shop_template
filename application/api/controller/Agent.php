<?php

namespace app\api\controller;

use app\common\model\AgentInfo;
use app\common\model\AgentRecord;
use app\common\model\PayInfo;
use app\common\model\Setting;
use app\common\model\Task;
use app\common\model\Agent as AgentModel;
use app\common\model\User as DealerUserModel;
use app\common\model\Order as OrderModel;
use app\common\model\Withdraw as WithdrawModel;

/**
 * 推广员接口
 * Class Order
 * @package app\api\controller\user\dealer
 */
class Agent extends Controller
{
    private $user;

    private $dealer;
    private $setting;

    /**
     * 构造方法
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function initialize()
    {
        parent::initialize();
        // 用户信息
        $this->user = $this->getAgent();
        // 分销商用户信息
        $this->dealer = DealerUserModel::detail($this->user['user_id']);
        // 分销商设置
        //$this->setting = Setting::getAll();
    }

    /**
     * 分销商订单列表
     * @param int $settled
     * @return array
     * @throws \think\exception\DbException
     */
    public function lists($settled = -1)
    {
		
        $model = new OrderModel;
        return $this->renderSuccess([
            // 提现明细列表
            'list' => $model->getList($this->user['user_id'], (int)$settled),
            // 页面文字
            //'words' => $this->setting['words']['values'],
        ]);
    }

    /**
     * 获取当前用户信息
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function detail()
    {
        // 当前用户信息
        $token = input('post.token');
        $model = new AgentModel;
        $userInfo = $model->getUser($token);
        if($userInfo){
            return $this->renderSuccess([
                'userInfo' => $userInfo,
            ]);
        } else{
            return $this->renderError('没有找到用户信息');
        }
    }

    /**
     * 任务列表
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function tasks()
    {
        $user = $this->getAgent();
        $model = new Task();
        $list = $model->getList($user['user_id']);
        return $this->renderSuccess([
            'list' => $list
        ]);
    }

    /**
     * 接收任务
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function add()
    {
        $model = new Task();
        if ($model->add($this->request->post())) {
            return $this->renderSuccess([], '接收任务成功');
        }
        return $this->renderError('接收任务失败');
    }

    /**
     * 移除任务
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function del()
    {
        $model = new Task();
        if ($model->del($this->request->post())) {
            return $this->renderSuccess([], '移除任务成功');
        }
        return $this->renderError('移除任务失败');
    }

    /**
     * 人头列表
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function invite_list()
    {
        $user = $this->getAgent();
        $model = new AgentModel;
        $list = $model->invite_lists($user['user_id']);
        return $this->renderSuccess([
            'list' => $list
        ]);
    }

    /**
     * 佣金记录列表
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function award_list()
    {
        $user = $this->getAgent();
        $model = new AgentRecord();
        $list = $model->getAll($user['user_id']);
        return $this->renderSuccess([
            'list' => $list
        ]);
    }

    /**
     * 生成专属链接,二维码前端生成
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function qrcode()
    {
        $user = $this->getAgent();
        $url = 'http://mbh.laoma-app.com/web/login?aid=' . $user['user_id'];
        return $this->renderSuccess([
            'url' => $url
        ]);
    }

    /**
     * 同意协议
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function agree()
    {
        $user = $this->getAgent();
        $model = new AgentModel;
        if ($model->agree($user)) {
            return $this->renderSuccess([], '同意协议成功');
        }
        return $this->renderError('同意协议失败');
    }

    /**
     * 提交提现申请
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function submit()
    {
        $post = input('post.');
        $post['type'] = 3;    //供应商类型
        $model = new WithdrawModel;
        $info = $model->getInfoByPayType($this->user['user_id'], $post['pay_type']);
        $data = array_merge($post,$info);

        $res = $model->submit($this->user['user_id'], $data);
        if ($res === true) {
            AgentInfo::freezeMoney($this->user['user_id'], $data['money']);
            return $this->renderSuccess([], '申请提现成功');
        }
        return $this->renderError($model->getError() ?: '提交失败');
    }

    /**
     * 推广员提现明细
     * @param int $status
     * @return array
     * @throws \think\exception\DbException
     */
    public function withdraw_list($status = -1)
    {
        $model = new WithdrawModel;
        return $this->renderSuccess([
            // 提现明细列表
            'list' => $model->getLists($this->user['user_id'], (int)$status),
            // 页面文字
            //'words' => $this->setting['words']['values'],
        ]);
    }

    /**
     * 推广员业绩统计
     * @param int $status
     * @return array
     * @throws \think\exception\DbException
     */
    public function performance()
    {
        $model2 = new AgentInfo;
        $agent = $model2->where('agent_id', $this->user['user_id'])->find();
        return $this->renderSuccess([
            // 收益总额
            'money_total' => $agent['profit'],
            // 提现总额
            'withdraw_total' => $agent['withdraw_money'],
            // 邀请人数
            'invite_total' => $agent['num1'],
            // 升级VIP人数
            'vip_total' => $agent['num2'],
            // 成功订单数
            'order_total' => $agent['num3'],
        ]);
    }

    /**
     * 绑定收款信息
     * @param int    $type  1=>绑定支付宝,       2=>绑定微信,          3=>绑定银行卡
     * @param string        alipay_name         wechat_number       bank_name
     * @param string        alipay_account      null                bank_account
     * @param string        null                null                bank_card
     * @return array
     */
    public function bandReceivablesInfo()
    {
        $PayInfoModel = new PayInfo;
        $post = input('post.');
        $type = $post['type'];
        $user_id = $this->user['user_id'];
        $data = '';
        // 绑定支付宝
        if ($type == 1) {
            if (isset($post['alipay_name']) && isset($post['alipay_account'])) {
                // 整理修改的数据
                $data = [
                    'alipay_name' => $post['alipay_name'],
                    'alipay_account' => $post['alipay_account']
                ];
            }
            // 绑定微信
        } elseif ($type == 2) {
            if (isset($post['wechat_number'])) {
                // 整理修改的数据
                $data = [
                    'wechat_number' => $post['wechat_number'],
                ];
            }
            // 绑定银行卡
        } elseif ($type == 3) {
            if (isset($post['bank_name']) && isset($post['bank_account']) && isset($post['bank_card'])) {
                // 整理修改的数据
                $data = [
                    'bank_name' => $post['bank_name'],
                    'bank_account' => $post['bank_account'],
                    'bank_card' => $post['bank_card'],
                ];
            }
        }
        if ($data != '') {
            $where = ['user_id' => $user_id];
            // 检查这个用户有没有数据
            $check = $PayInfoModel->getDataByWhere($where);
            $time = time();
            // 有就修改
            if ($check) {
                $data['update_time'] = $time;
                $res = $PayInfoModel->upFieldByWhere($where, $data);
                // 没有就添加
            } else {
                $data['user_id'] = $user_id;
                $data['create_time'] = $time;
                $data['update_time'] = $time;
                $res = $PayInfoModel->addData($data);
            }
            if ($res) {
                return $this->renderSuccess('修改成功');
            }
        }
        return $this->renderError('非法请求');
    }
}