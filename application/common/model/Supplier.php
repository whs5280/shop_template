<?php
namespace app\common\model;

use think\Db;
use think\facade\Request;
use think\facade\Cache;
/**
 * 图片管理
 * Class Cart
 * @package app\api\model
 */
class Supplier extends BaseModel
{
	protected $name = 'supplier';
	protected $pk = 'id';
	
	/*
	 * 网页用户登录
	 * @param array $post
	 * @return string
	 * @throws BaseException
	 */
	public function appLogin($post){
		$user = $this->where([
				'phone' => $post['phone'],
				'password' => wymall_pass($post['password'])
		])->find();
		if(!$user){
			return false;
		}else{
			// 生成token (session3rd)
			$this->token = $this->token($user['phone']);
			// 记录缓存, 7天
			Cache::set($this->token, $user, 86400 * 7);
			return $this->token;
		}
	}
	
	/**
	 * 生成用户认证的token
	 * @param $openid
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
	 * 根据where条件获取field字段
	 * @param unknown $where
	 * @param unknown $field
	 * @return unknown|boolean
	 */
	public function getFidleByWhere($where, $field){
		if (is_array($where) && $field){
			$data = $this->where($where)->value($field);
			if ($data){
				return $data;
			}
		}
		return false;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/**
	 * 获取用户列表
	 * @param string $nickName
	 * @param null $gender
	 * @return \think\Paginator
	 * @throws \think\exception\DbException
	 */
	public function getList($nickName = '', $type = '',$listRows = 15)
	{
		if(!empty($nickName))
			$where[]=['name', 'like', "%$nickName%"];
			$where[]=['category','like',"%$type%"];
			return $this->where($where)
				->order('create_time desc')
				->paginate($listRows, false, [
					'query' => Request::instance()->request()
				]);
	}
	
	/**
	 * 获取当前用户信息
	 * @param bool $is_force
	 * @return UserModel|bool|null
	 * @throws BaseException
	 * @throws \think\exception\DbException
	 */
	public function getUser($token, $is_force = true)
	{
		if (!$token) {
			// $is_force && $this->throwError('缺少必要的参数：token', -1);
			return false;
		}
		if (!$user = self::detail(['user_id' => Cache::get($token)['user_id']])) {
			$is_force && $this->throwError('没有找到用户信息', -1);
			return false;
		}
		if ($user){
			return $user[0];
		}
		$this->throwError('请重新登录', -1);
		return false;
	}
	
	/**
	 * 获取用户信息
	 * @param $where
	 * @return null|static
	 * @throws \think\exception\DbException
	 */
	public static function detail($where)
	{
		if (is_array($where)) {
			$filter = $where;
		} else {
			$filter = ['user_id','=',(int)$where];
		}
		return self::where($filter)->select();
	}

    /**
     * 获取周边供应商
     * @param $latitude
     * @param $longitude
     * @param int $distance
     * @return int
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     */
    public function getNeighbor($latitude, $longitude, $distance = 5000)
    {
        $sql = "select * from (select user_id,name,address,category,
            ROUND(6378.138*2*ASIN(SQRT(POW(SIN(($latitude*PI()/180-`latitude`*PI()/180)/2),2)+COS($latitude*PI()/180)*COS(`latitude`*PI()/180)*POW(SIN(($longitude*PI()/180-`longitude`*PI()/180)/2),2)))*1000) AS distance from bfb_supplier order by distance ) as a where a.distance<=$distance";

        return Db::name('supplier')->query($sql);
    }
}