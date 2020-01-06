<?php
namespace app\common\model;

use think\Db;
use think\facade\Cache;
/**
 * 基于Redis bitmap实现签到功能
 * 30天以一个周期
 * Class Sign
 * @package app\common\model
 */
class Sign extends BaseModel
{
    protected $name = 'sign';
    protected $pk = 'id';

    /**
     * 查找出记录
     * @param $user_id
     * @return array|\PDOStatement|string|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function sign_list($user_id)
    {
        $year = date('Y', time());
        $month = date('m', time());
        $day = date('d', time());

        $res = $this->where('user_id', $user_id)
            ->where('year', $year)
            ->where('month', $month)
            ->find();

        $day < 7 && $sign_log = str_pad($res['bit_log'], 7 , 0);

        $day >=7 && $sign_log = substr($res['bit_log'], $day-7, 7);  //0110111

        $res['sign_log'] = $sign_log;
        return $res;
    }

    /**
     * 每日签到
     * @param $user_id
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function sign($user_id)
    {
        $year = date('Y', time());
        $month = date('m', time());
        $day = date('d', time());

        $res = $this->where('user_id', $user_id)
            ->where('year', $year)
            ->where('month', $month)
            ->find();

        if ($day < 10) {$day = substr($day,1,1);}

        // 先转成数组
        $sign_log = str_to_array(1, $res['bit_log']);
        $sign_log[$day]['is_sign'] = '1';

        // 数组转成字符串
        $is_signs = array_column($sign_log,'is_sign');
        $bit_log = implode('', $is_signs);

        $update_data = [
            'bit_log' => $bit_log,
        ];
        return $this->isUpdate(true)->save($update_data, ['id' => $res['id']]);
    }

    /**
     * 是否签到
     * @param $user_id
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function is_sign($user_id)
    {
        $year = date('Y', time());
        $month = date('m', time());
        $day = date('d', time());

        $res = $this->where('user_id', $user_id)
            ->where('year', $year)
            ->where('month', $month)
            ->find();

        if ($day < 10) {$day = substr($day,1,1);}

        $sign_log = str_to_array(1, $res['bit_log']);
        return $sign_log[$day]['is_sign'];
    }

    /**
     * 新增日志
     * @param $user_id
     * @return mixed
     */
    public function add_sign_log($user_id)
    {
        $data = [
            'user_id' =>   $user_id,
            'remark'  =>  '签到成功，获取1积分',
            'create_time' => time()
        ];
        return Db::name('sign_log')->insert($data);
    }
}