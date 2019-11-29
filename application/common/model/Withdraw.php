<?php
namespace app\common\model;

use app\common\exception\BaseException;
use app\common\service\Message;
use think\Db;

/**
 * 提现公共类
 * Class WithdrawByAgent
 * @package app\api\controller
 */
class Withdraw extends BaseModel
{
    protected $name = 'agent_withdraw';
    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'update_time',
    ];
    /**
     * 打款方式
     * @var array
     */
    public $payType = [
        1 => '支付宝',
        2 => '微信',
        3 => '银行卡',
    ];
    /**
     * 申请状态
     * @var array
     */
    public $applyStatus = [
        10 => '待审核',
        20 => '审核通过',
        30 => '驳回',
        40 => '已打款',
        50 => '已收款',
    ];
    /**
     * 提现详情
     * @param $id
     * @return mixed
     */
    public static function detail($id)
    {
        return self::get($id);
    }
    /**
     * 后台获取所有的提现列表
     * @param null $user_id
     * @param int $type             用户类型
     * @param int $apply_status     申请状态
     * @param int $pay_type         打款方式
     * @param string $search        用户昵称
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList($user_id = null, $type = -1, $apply_status = -1, $pay_type = -1, $search = '')
    {
        $where=[];
        $user_id > 0 && $where[]=['withdraw.user_id', '=', $user_id];
        $type > 0 && $where[]=['withdraw.type', '=', $type];
        $apply_status > 0 && $where[]=['withdraw.apply_status', '=', $apply_status];
        $pay_type > 0 && $where[]=['withdraw.pay_type', '=', $pay_type];
        !empty($search) && $where[]=['user.nickName', 'like', "%$search%"];
        // 构建查询规则
        return $this->alias('withdraw')
            //->with(['user'])
            ->field('withdraw.*, user.nickName, user.avatarUrl ,user.phone')
            ->join('user', 'user.user_id = withdraw.user_id')->where($where)
            ->order(['withdraw.create_time' => 'desc'])->paginate(15, false, [
                'query' => \request()->request()
            ]);
    }
    /**
     * 获取提现明细
     * @param $user_id
     * @param int $apply_status
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getLists($user_id, $apply_status = -1)
    {
        $where[]=['user_id','=',$user_id];
        $apply_status > -1 && $where[]=['apply_status','=',$apply_status];
        return $this->order(['create_time' => 'desc'])
            ->where($where)
            ->paginate(15, false, [
                'query' => \request()->request()
            ]);
    }
    /**
     * 提交申请,date[]包含type,pay_type,
     * @param $dealer
     * @param $data
     * @return false|int
     * @throws BaseException
     */
    public function submit($dealer, $data)
    {
    	if ($dealer && $data){
    		// 数据验证
    		$this->validation($dealer, $data);
    		// 新增申请记录
    		$res = $this->allowField(true)->save(array_merge($data, [
    				'user_id' => $dealer,
    				'apply_status' => 10,
    				'app_id' => self::$app_id,
    		]));
    		if ($res){
    			return true;
    		}
    	}
    	return false;
    }

    /**
     * 同意提现申请
     * @param $id
     * @return bool
     */
    public function pass($id)
    {
        $data = [
            'audit_time' => time(),
            'apply_status' => 20
        ];
        return $this->allowField(true)->isUpdate(true)->save($data,['id' => $id]);
    }
    /**
     * 驳回提现申请
     * @param $id
     * @return bool
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function refuse($id)
    {
        $data = [
            'audit_time' => time(),
            'apply_status' => 30
        ];
        return $this->allowField(true)->isUpdate(true)->save($data,['id' => $id]);
    }
    /**
     * 数据验证
     * @param $dealer_id
     * @param $data
     * @throws BaseException
     */
    private function validation($dealer_id, $data)
    {
        $table = '';
        $where = '';
        $field = '';
        switch ($data['type']) {
            case 2:
                $table = 'supplier';
                $where = ['user_id' => $dealer_id];
                $field = 'withdraw_money';
                break;
            case 3:
                $table = 'agent';
                $where = ['agent_id' => $dealer_id];
                $field = 'profit';
                break;
        }
        $withdraw_money = Db::name($table)->where($where)->value($field);

        // 结算设置
        $settlement = Setting::getItem('settlement');
        // 最低提现佣金
        if ($data['money'] <= 0) {
            throw new BaseException(['msg' => '提现金额不正确']);
        }
        if ($withdraw_money <= 0) {
            throw new BaseException(['msg' => '当前用户没有可提现佣金']);
        }
        if ($data['money'] > $withdraw_money) {
            throw new BaseException(['msg' => '提现金额不能大于可提现佣金']);
        }
        if ($data['money'] < $settlement['min_money']) {
            throw new BaseException(['msg' => '最低提现金额为' . $settlement['min_money']]);
        }
        /*if (!in_array($data['pay_type'], $settlement['pay_type'])) {
            throw new BaseException(['msg' => '提现方式不正确']);
        }*/
        if ($data['pay_type'] == '10') {
            if (empty($data['wechat_number'])) {
                throw new BaseException(['msg' => '请补全提现信息']);
            }
        }
        if ($data['pay_type'] == '20') {
            if (empty($data['alipay_name']) || empty($data['alipay_account'])) {
                throw new BaseException(['msg' => '请补全提现信息']);
            }
        } elseif ($data['pay_type'] == '30') {
            if (empty($data['bank_name']) || empty($data['bank_account']) || empty($data['bank_card'])) {
                throw new BaseException(['msg' => '请补全提现信息']);
            }
        }
    }
    /**
     * 确认打款
     * @param $id
     * @return bool
     * @throws \think\exception\PDOException
     */
    public function remit($id)
    {
        $this->startTrans();
        try {
            // 更新申请状态
            $this->allowField(true)->save([
                'apply_status' => 40,
                'audit_time' => time(),
            ],['id' => $id]);

            // 发送模板消息
            //(new Message)->withdraw($this);  //@Todo 模板信息到时统一处理
            // 事务提交
            $this->commit();
            return true;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            $this->rollback();
            return false;
        }
    }
    /**
     * 根据打款类型查出对应数据
     * @param $dealer_id
     * @param $pay_type
     * @return array
     * @throws BaseException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getInfoByPayType($dealer_id, $pay_type)
    {
        $model = new PayInfo;
        $res = $model->where('user_id', $dealer_id)->find();
        if (!$res) {
            throw new BaseException(['msg' => '请补全提现信息']);
        }

        $data = [];
        switch ($pay_type) {
            //支付宝
            case 1:
                $data = [
                    'alipay_name' => $res['alipay_name'],
                    'alipay_account' => $res['alipay_account'],
                ];
                break;
            //微信
            case 2:
                $data = [
                    'wechat_number' => $res['wechat_number'],
                ];
                break;
            //银行卡
            case 3:
                $data = [
                    'bank_name' => $res['bank_name'],
                    'bank_account' => $res['bank_account'],
                    'bank_card' => $res['bank_card'],
                ];
                break;
        }
        return $data;
    }
    
    /**
     * 获取提现记录
     * @param unknown $plat_id
     */
    public function getWithdrawInfo($plat_id){
    	if ($plat_id){
    		$data = $this->where(['user_id'=>$plat_id])->select();
    		if ($data){
    			return $data;
    		}
    	}
    	return false;
    }
}