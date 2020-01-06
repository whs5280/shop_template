<?php


namespace app\api\controller;


class Test extends Controller
{
    public function shishi()
    {
        $str = '1,2,3';
        $arr = explode(',', $str);
    }

    public function get()
    {
        $address = '广东警官学院嘉禾校区';
        $data = get_lat_and_log($address);
        dump($data);
    }
}