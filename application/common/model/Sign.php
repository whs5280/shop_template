<?php
namespace app\common\model;

use think\facade\Cache;
/**
 * 基于Redis bitmap实现签到功能
 * 30天以一个周期
 * Class Sign
 * @package app\common\model
 */
class Sign extends BaseModel
{
    const DAY_ONE   =   1;
    const DAY_TWO   =   2;
    const DAY_THREE =   3;
    const DAY_FOUR  =   4;
    const DAY_FIVE  =   5;
    const DAY_SIX   =   6;
    const DAY_SEVEN =   7;

    private $redis = null;
    private $day;

    public function __construct()
    {
        parent::__construct();
        $this->redis = (Cache::init())->handler();
        $this->redis->select(3);    // 3用户签到库
        $this->day = date('d', time());
    }

    /**
     * 用户签到
     * @param $user_id
     * @return int
     */
    public function setSignLog($user_id)
    {
        $dayKey = 'keySign:'. date('Ym', time()). ':' . $user_id;
        // 签到记录
        $this->setbit($dayKey, $this->day, 1);
        // 连续签到累计
        $this->signDays($user_id);
        // 总签到次数累计
        $this->signTotal($user_id);
        // 签到积分规则
        return $this->signRule($user_id);
    }

    /**
     * 查询签到记录
     * @param $user_id
     * @param $day
     * @return mixed
     */
    public function getSignLog($user_id, $day)
    {
        $dayKey = 'keySign:'. date('Ym', time()). ':' . $user_id;
        return $this->getBit($dayKey, $day);
    }

    /**
     * 连续签到天数
     * @param $user_id
     */
    public function signDays($user_id)
    {
        $dayKey = 'SignDays:'. date('Ym', time()). ':' . $user_id;
        // 查找昨天，没有设置为1，有则累计加1
        $yesterday = $this->getSignLog($user_id, date('d', strtotime("-1 day")));
        if ($yesterday == 0) {
            $this->setVal($dayKey, 1);
        } else {
            $this->incrBy($dayKey);
        }
    }

    /**
     * 总签到天数
     * @param $user_id
     */
    public function signTotal($user_id)
    {
        $dayKeys = 'SignTotal:'. date('Ym', time()). ':' . $user_id;
        $this->incrBy($dayKeys);
    }

    /**
     * 签到规则
     * @param $user_id
     * @return int
     */
    private function signRule($user_id)
    {
        $dayKey = 'SignDays:'. date('Ym', time()). ':' . $user_id;
        // 获取连续签到的天数
        $days = $this->getVal($dayKey);
        // 默认规则,签到积分一致
        if ($days>=0) {
            return self::DAY_ONE;
        }
    }

    /**
     * 同步用户签到记录到Mysql
     * @return int|string
     */
    public function addUserSignLogToMysql(){
        // 1.计算上月的年份、月份
        $data = [];
        $year = date('Y',strtotime('-1 month'));
        $month = date('m',strtotime('-1 month'));
        // 2.取出签到记录的所有key
        $dayKey = 'keySign:'. date('Ym', time()). ':*' ;
        $keys = $this->keys($dayKey);

        foreach ($keys as $key) {
            $bitLog = '';
            $userData = explode(':', $key);
            $userId = $userData[1];
            // 3.循环查询用户是否签到(直接都存31天了)
            for ($i = 1; $i <= 31; $i++) {
                $isSign = $this->getSignLog($userId, $i);
                $bitLog .= $isSign;
            }
            // 4.取出上个月签到连续天数和总天数
            $day = $this->getVal('SignDays:'. $year. $month. ':' . $userId);
            $total_day = $this->getVal('SignTotal:'. $year. $month. ':' . $userId);

            $data[] = [
                'user_id' => $userId,
                'year' => $year,
                'month' => $month,
                'bit_log' => $bitLog,
                'day' => $day,
                'total_day' => $total_day,
                'create_time' => time(),
            ];
        }
        // 5.插入签到日志
        return $this->insertAll($data, '', 100);
    }

    /**
     * Redis获取所有key值
     * @param $key
     * @return mixed
     */
    public function keys($key)
    {
        return $this->redis->keys($key);
    }

    /**
     * 设置位图
     * @param $key
     * @param $offset
     * @param $value
     * @param int $time
     * @return mixed
     */
    public function setBit($key, $offset, $value, $time=-1)
    {
        $result = $this->redis->setbit($key, $offset, $value);
        $time > 0 && $this->redis->expire($key, $time);
        return $result;
    }

    /**
     * 获取位图
     * @param $key
     * @param $offset
     * @return mixed
     */
    public function getBit($key, $offset)
    {
        return $this->redis->getbit($key, $offset);
    }

    /**
     * 统计位图
     * @param $key
     * @return mixed
     */
    public function bitCount($key)
    {
        return $this->redis->bitCount($key);
    }

    /**
     * 位图操作
     * @param $operation
     * @param $retKey
     * @param mixed ...$key 函数参数存储在紧接的可遍历的变量
     * @return mixed
     */
    public function bitOp($operation, $retKey, ...$key)
    {
        return $this->redis->bitOp($operation, $retKey, $key);
    }

    /**
     * 计算在某段位图中 1或0第一次出现的位置
     * @param $key 1/0
     * @param $bit
     * @param $start
     * @param null $end
     * @return mixed
     */
    public function bitPos($key, $bit, $start, $end = null)
    {
        return $this->redis->bitPos($key, $bit, $start, $end);
    }

    /**
     * 删除数据
     * @param $key
     * @return mixed
     */
    public function del($key)
    {
        return $this->redis->del($key);
    }

    /**
     * Redis设置字符串
     * @param $name
     * @param $val
     * @return mixed
     */
    public function setVal($name, $val)
    {
        return $this->redis->set($name, $val);
    }

    /**
     * Redis取字符串
     * @param $name
     * @return mixed
     */
    public function getVal($name)
    {
        return $this->redis->get($name);
    }

    /**
     * 递增
     * @param string $name
     * @param int $step
     * @return mixed
     */
    public function incrBy($name = '', $step = 1){
        return $this->redis->incrBy($name, $step);
    }
}