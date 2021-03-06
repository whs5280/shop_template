<?php

namespace app\common\model;

/**
 * 分销商推荐关系模型
 * Class Apply
 * @package app\api\model\dealer
 */
class Referee
{
	
	 protected $name = 'dealer_referee';
    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [];

    /**
     * 获取我的团队列表
     * @param $user_id
     * @param int $level
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList($user_id, $level = -1)
    {
        $this->with(['user', 'dealer'])
            ->where('dealer_id', '=', $user_id);
        $level > -1 && $this->where('level', '=', $level);
        return $this->order(['create_time' => 'desc'])
            ->paginate(15, false, [
                'query' => \request()->request()
            ]);
    }

    /**
     * 创建推荐关系
     * @param $user_id
     * @param $referee_id
     * @return bool
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public static function createRelation($user_id, $referee_id)
    {
        // 分销商基本设置
        $setting = Setting::getItem('basic');
        // 是否开启分销功能
        if (!$setting['is_open']) {
            return false;
        }
        // 自分享
        if ($user_id == $referee_id) {
            return false;
        }
        // # 记录一级推荐关系
        // 判断当前用户是否已存在推荐关系
        if (self::isExistReferee($user_id)) {
            return false;
        }
        // 判断推荐人是否为分销商
        if (!User::isDealerUser($referee_id)) {
            return false;
        }
        // 新增关系记录
        $model = new self;
        $model->add($referee_id, $user_id, 1);
        // # 记录二级推荐关系
        if ($setting['level'] >= 2) {
            // 二级分销商id
            $referee_2_id = self::getRefereeUserId($referee_id, 1, true);
            // 新增关系记录
            $referee_2_id > 0 && $model->add($referee_2_id, $user_id, 2);
        }
        // # 记录三级推荐关系
        if ($setting['level'] == 3) {
            // 三级分销商id
            $referee_3_id = self::getRefereeUserId($referee_id, 2, true);
            // 新增关系记录
            $referee_3_id > 0 && $model->add($referee_3_id, $user_id, 3);
        }
        return true;
    }

    /**
     * 新增关系记录
     * @param $dealer_id
     * @param $user_id
     * @param int $level
     * @return bool
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    private function add($dealer_id, $user_id, $level = 1)
    {
        // 新增推荐关系
        $app_id = self::$app_id;
        $create_time = time();
        $this->insert(compact('dealer_id', 'user_id', 'level', 'app_id', 'create_time'));
        // 记录分销商成员数量
        User::setMemberInc($dealer_id, $level);
        return true;
    }

    /**
     * 获取上级用户id
     * @param $user_id
     * @param $level
     * @param bool $is_dealer 必须是分销商
     * @return bool|mixed
     * @throws \think\exception\DbException
     */
    public static function getRefereeUserId($user_id, $level, $is_dealer = false)
    {
        $dealer_id = (new self)->where(compact('user_id', 'level'))
            ->value('dealer_id');
        if (!$dealer_id) return 0;
        return $is_dealer ? (User::isDealerUser($dealer_id) ? $dealer_id : 0) : $dealer_id;
    }

    /**
     * 是否已存在推荐关系
     * @param $user_id
     * @return bool
     * @throws \think\exception\DbException
     */
    private static function isExistReferee($user_id)
    {
        return !!self::get(['user_id' => $user_id]);
    }
	 /**
     * 关联用户表
     * @return \think\model\relation\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('app\api\model\User');
    }

    /**
     * 关联分销商用户表
     * @return \think\model\relation\BelongsTo
     */
    public function dealer()
    {
        return $this->belongsTo('User');
    }

}