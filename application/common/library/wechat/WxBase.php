<?php

namespace app\common\library\wechat;

use think\facade\Cache;

/**
 * 微信api基类
 * Class wechat
 * @package app\library
 */
class WxBase
{
    protected $appkey;
    protected $appSecret;

    protected $error;

    /**
     * 构造函数
     * WxBase constructor.
     * @param $appkey
     * @param $appSecret
     */
    public function __construct($appkey, $appSecret)
    {
        $this->appkey = $appkey;
        $this->appSecret = $appSecret; 
		
		
    }

    /**
     * 写入日志记录
     * @param $values
     * @return bool|int
     */
    protected function doLogs($values)
    {
        return write_log($values, __DIR__);
    }

    /**
     * 获取access_token
     * @return string access_token
     */
    protected function getAccessToken()
    {
		//$this->appkey = 'wx1ff41ed2d337fdde';
        $cacheKey = $this->appkey . '@access_token';
        if (!Cache::get($cacheKey)) {
			
            // 请求API获取 access_token
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appkey}&secret={$this->appSecret}";
            $result = $this->get($url);
            $data = json_decode($result, true);
            // 记录日志
            log_write([
                'describe' => '获取access_token',
                'appId' => $this->appkey,
                'result' => $result
            ]);
            // 写入缓存
            Cache::set($cacheKey, $data['access_token'], 6000);    // 7000
        }
        return Cache::get($cacheKey);
    }

    /**
     * 模拟GET请求 HTTPS的页面
     * @param string $url 请求地址
     * @return string $result
     */
    public function get($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    /**
     * 模拟POST请求
     * @param $url
     * @param array $data
     * @return mixed
     */
    public function post($url, $data = [])
    {
        $header = [
            'Content-type: application/json;'
        ];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

    /**
     * 返回错误信息
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

}