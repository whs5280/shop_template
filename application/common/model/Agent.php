<?php
namespace app\common\model;

use think\facade\Cache;
/**
 * 推广员模型
 * Class Agent
 * @package app\common\model
 */
class Agent extends BaseModel
{
    private $token;
    protected $name = 'user';
    protected $pk = 'user_id';
    // 性别
    private $gender = ['未知', '男', '女'];
    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = [
        'app_id',
        'create_time',
        'update_time'
    ];

    /*
	 * 网页用户登录
	 * @param array $post
	 * @return string
	 * @throws BaseException
	 */
    public function appLogin($post)
    {
        $user = $this->where([
            'phone' => $post['phone'],
            'password' => wymall_pass($post['password'])
        ])->find();
        if(!$user){
            return false;
        }else{
            // 生成token
            $this->token = $this->token($user['phone']);
            // 记录缓存, 7天
            Cache::set($this->token, $user, 86400 * 7);
            return $user['user_id'];
        }
    }
    /**
     * 生成用户认证的token
     * @param $phone
     * @return string
     */
    private function token($phone)
    {
        return md5($phone . 'token_salt');
    }
    /**
     * 获取token
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }
    /**
     * 获取用户信息
     * @param $token
     * @throws \think\exception\DbException
     */
    public static function getUser($token)
    {
        return self::detail(['user_id' => Cache::get($token)['user_id']]);
    }
    /**
     * 获取用户信息
     * @param $where
     * @return array|\PDOStatement|string|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function detail($where)
    {
        if (is_array($where)) {
            $filter = $where;
        } else {
            $filter = ['user_id','=',(int)$where];
        }
        return self::where($filter)->find();
    }
    /**
     * 人头列表
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function invite_lists($aid)
    {
        $where = ['aid' => $aid];
        return $this->alias('u')
            ->field('u.user_id,u.nickName,u.status,i.site,i.reason')
            ->join('user_info i', 'u.user_id=i.user_id', 'left')
            ->where($where)
            ->select();
    }
    /**
     * 获取人头缓存
     * @return mixed
     */
    private static function inviteCache($pid)
    {
        if (!Cache::get($pid.'_invite')) {
            // 人头个数
            $count = self::where('pid', $pid)->count();
            Cache::set($pid.'_invite', $count - 1);
        }
        return Cache::get($pid.'_invite');
    }
    /**
     * 累积推广员佣金
     * @param $profit
     * @return int|true
     * @throws \think\Exception
     */
    public function cumulateProfit($profit)
    {
        return $this->setInc('profit', $profit);
    }
    /**
     * 同意协议
     * @param $data
     * @return false|int
     */
    public function agree($data)
    {
        // 同意协议
        return $this->allowField(true)->save(['is_agree' => 1],['user_id' => $data['user_id']]);
    }
}