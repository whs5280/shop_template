<?php


namespace app\api\controller;


use app\common\library\express\KuaidiJuhe;

class Kuaidi
{
    // 测试版本
    public function test()
    {
        $params = array(
            'key' => '26fe9c92ff2f2f57b1b3bc68616e81df', //您申请的快递appkey
            'com' => 'yt', //快递公司编码，可以通过$exp->getComs()获取支持的公司列表
            'no'  => 'YT4243265606592' //快递编号
        );
        $exp = new KuaidiJuhe($params['key']); //初始化类

        $result = $exp->query($params['com'],$params['no']); //执行查询

        if($result['error_code'] == 0){//查询成功
            $list = $result['result']['list'];
            print_r($list);
        }else{
            echo "获取失败，原因：".$result['reason'];
        }
    }

    public function express()
    {
        $params = input('post.');
        $params['key'] = '26fe9c92ff2f2f57b1b3bc68616e81df';   // 一共100次免费的

        $exp = new KuaidiJuhe($params['key']); //初始化类

        $result = $exp->query($params['com'],$params['no']); //执行查询

        if($result['error_code'] == 0){//查询成功
            $list = $result['result']['list'];
            print_r($list);
        }else{
            echo "获取失败，原因：".$result['reason'];
        }
    }
}