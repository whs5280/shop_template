<?php
use think\Db;
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
\think\facade\Url::root('/index.php?s=');

/**
 * 获取当前域名及根路径
 * @return string
 */
function base_url()
{
    $request = Request::instance();
    $subDir = str_replace('\\', '/', dirname($request->server('PHP_SELF')));
    return $request->scheme() . '://' . $request->host() . $subDir . ($subDir === '/' ? '' : '/');
}
/**
 * 生成密码hash值
 * @param $password
 * @return string
 */
function wymall_pass($password)
{
    return md5(md5($password) . 'wymall_ok');
}
/**
 * 驼峰命名转下划线命名
 * @param $str
 * @return string
 */
function toUnderScore($str)
{
    $dstr = preg_replace_callback('/([A-Z]+)/', function ($matchs) {
        return '_' . strtolower($matchs[0]);
    }, $str);
    return trim(preg_replace('/_{2,}/', '_', $dstr), '_');
}
/**
 * curl请求指定url (get)
 * @param $url
 * @param array $data
 * @return mixed
 */
function curl($url, $data = [])
{
    // 处理get数据
    if (!empty($data)) {
        $url = $url . '?' . http_build_query($data);
    }

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//这个是重点。
    $result = curl_exec($curl);
    curl_close($curl);
    return $result;
}

/**
 * curl请求指定url (post)
 * @param $url
 * @param array $data
 * @return mixed
 */
function curlPost($url, $data = [])
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
	/**
 * 数据导出到excel(csv文件)
 * @param $fileName
 * @param array $tileArray
 * @param array $dataArray
 */
 function export_excel($fileName,$tileArray = [],$dataArray = [])
    {
        $file_name = "order-".(date('Ymdhis',time())).".csv";
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='.$file_name );
        header('Cache-Control: max-age=0');
        $file = fopen('php://output',"a");
        $limit = 1000;
        $calc = 0;
        foreach ($tileArray as $v){
            $tit[] = iconv('UTF-8', 'GB2312//IGNORE',$v);
        }
        fputcsv($file,$tit);
        foreach ($dataArray as $v){
            $calc++;
            if($limit == $calc){
                ob_flush();
                flush();
                $calc = 0;
            }
            foreach($v as $t){
                $tarr[] = iconv('UTF-8', 'GB2312//IGNORE',$t);
            }
            fputcsv($file,$tarr);
            unset($tarr);
        }
        unset($list);
        fclose($file);
        exit();
    }

		function tab1ss($tab1s){
			$tab=explode('-',$tab1s);
			return "充值满".$tab[0].',减'.$tab[1];
		}
		
	function coupon($coupon){
			$str='<select name="prom[expression]">';
		foreach($coupon as $k=>$v){
			$str.='<option value="'.$v['coupon_id'].'">'.$v['name'].'</option>';
		}
		$str.='</select>';

		return $str;
		
	}
	
	function catname($cat_id){
		return db('category')->where(array('id'=>$cat_id))->value('name');
	}
	
	/**
 * 多维数组合并
 * @param $array1
 * @param $array2
 * @return array
 */
function array_merge_multiple($array1, $array2)
{
	
    $merge = $array1 + $array2;
    $data = [];
    foreach ($merge as $key => $val) {
        if (
            isset($array1[$key])
            && is_array($array1[$key])
            && isset($array2[$key])
            && is_array($array2[$key])
        ) {
            $data[$key] = array_merge_multiple($array1[$key], $array2[$key]);
        } else {
            $data[$key] = isset($array2[$key]) ? $array2[$key] : $array1[$key];
        }
    }
    return $data;
}

/**
 * 写入日志
 * @param string|array $values
 * @param string $dir
 * @return bool|int
 */
function write_log($values, $dir)
{
    if (is_array($values))
        $values = print_r($values, true);
    // 日志内容
    $content = '[' . date('Y-m-d H:i:s') . ']' . PHP_EOL . $values . PHP_EOL . PHP_EOL;
    try {
        // 文件路径
        $filePath = $dir . '/logs/';
        // 路径不存在则创建
        !is_dir($filePath) && mkdir($filePath, 0755, true);
        // 写入文件
        return file_put_contents($filePath . date('Ymd') . '.log', $content, FILE_APPEND);
    } catch (\Exception $e) {
        return false;
    }
}

/**
 * 写入日志 (使用tp自带驱动记录到runtime目录中)
 * @param $value
 * @param string $type
 * @return bool
 */
function log_write($value, $type = 'wymall-info')
{
    $msg = is_string($value) ? $value : print_r($value, true);
    return Log::write($msg, $type);
}

/**
 * 二维数组排序
 * @param $arr
 * @param $keys
 * @param bool $desc
 * @return mixed
 */
function array_sort($arr, $keys, $desc = false)
{
    $key_value = $new_array = array();
    foreach ($arr as $k => $v) {
        $key_value[$k] = $v[$keys];
    }
    if ($desc) {
        arsort($key_value);
    } else {
        asort($key_value);
    }
    reset($key_value);
    foreach ($key_value as $k => $v) {
        $new_array[$k] = $arr[$k];
    }
    return $new_array;
}

/**
 * 会员返利等级
 * @method
 * @param $value
 * @return int
 */
function invite_leave($value)
{
    if ($value > 1 && $value <= 5) {return 20;}
    if ($value > 5 && $value <= 10) {return 25;}
    if ($value > 10 && $value <= 15) {return 30;}
    if ($value > 15 && $value <= 20) {return 35;}
    if ($value > 20 && $value <= 25) {return 40;}
    if ($value > 25 && $value <= 30) {return 45;}
    if ($value > 30) {return 50;}
}

/**
 * 推广员提成比例,新的0.02，老的0.01
 * @param $status
 * @return float
 */
function agent_order_rate($status)
{
    return $status == 1 ? 0.02:0.01;
}

function category($str=''){
	if ($str != ''){
		$id = explode(',', $str);
		$data = Db::name('category')->where(['is_show'=>1])->where('id','in',$id)->column('name');
		if ($data){
			$category = implode('|', $data);
			return $category;
		}
	}
	return '';
}

/**
 * 随机昵称
 */
function random_nickname()
{
    $nickname_tou = array('快乐的','冷静的','醉熏的','潇洒的','糊涂的','积极的','冷酷的','深情的','粗暴的','温柔的','可爱的','愉快的','义气的','认真的','威武的','帅气的','传统的','潇洒的','漂亮的','自然的','专一的','听话的','昏睡的','狂野的','等待的','搞怪的','幽默的','魁梧的','活泼的','开心的','高兴的','超帅的','留胡子的'); //32
    $nickname_wei = array('嚓茶','凉面','便当','毛豆','花生','可乐','灯泡','哈密瓜','野狼','背包','眼神','缘分','雪碧','人生','牛排','蚂蚁','飞鸟','灰狼','斑马','汉堡','悟空','巨人','绿茶','自行车','保温杯','大碗','墨镜','魔镜','煎饼','月饼','月亮','星星','芝麻','啤酒','玫瑰','大叔','小伙','哈密瓜，数据线','太阳','树叶','芹菜','黄蜂','蜜粉','蜜蜂','信封','西装','外套','裙子','大象','猫咪'); //50
    $tou = rand(0,32);
    $wei = rand(0,50);
    return $nickname_tou[$tou] . $nickname_wei[$wei];
}

function is_delete($is_delete){
	if ($is_delete == 0){
		return '显示';
	}
	return '已删除';
}

/**
 * 生成签到数组
 */
function str_to_array($index, $str)
{
    $len = strlen($str);
    $arr = [];
    for($i=0; $i<$len; $i++) {
        $arr[$index+$i]['data'] = $index+$i+1;
        $arr[$index+$i]['is_sign'] = substr($str, $i, 1);
    }
    return $arr;
}

// 行业字段多选显示
function industry($str='')
{
    if ($str != ''){
        $id = explode(',', $str);
        $data = Db::name('industry')->where(['is_show'=>1])->where('id','in',$id)->column('name');
        if ($data){
            $industry = implode('、', $data);
            return $industry;
        }
    }
    return '';
}

// 是否为VIP
function is_vip($is_vip)
{
    if ($is_vip == 1){
        return '是';
    }
    return '否';
}
/**
 * 计算出两个经纬度之间的距离（单位：米）
 */
function getdistanceAction($arr1,$arr2)
{
	$lng1=$arr1['lng'];  //经度1
	$lat1=$arr1['lat'];   //纬度1
	$lng2=$arr2['lng'];  //经度2
	$lat2=$arr2['lat'];   //纬度2

	$EARTH_RADIUS = 6378137;   //地球半径
	$RAD = pi() / 180.0;

	$radLat1 = $lat1 * $RAD;
	$radLat2 = $lat2 * $RAD;
	$a = $radLat1 - $radLat2;    // 两点纬度差
	$b = ($lng1 - $lng2) * $RAD;  // 两点经度差
	$s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2)));
	$s = $s * $EARTH_RADIUS;
	$s = round($s * 10000) / 10000;
	return $s;
	// print_r($s);   //正确答案：330518.674
}
// 根据地址获取经纬度
function get_lat_and_log($address)
{
    //$address = '北京市海淀区上地十街10号';
    $url = 'http://api.map.baidu.com/geocoding/v3/?address='. $address. '&output=json&ak=uT6skjzHGvh2q9xFKCAajAxquvkzjG0d&callback=showLocation'; // 配额(0.6w次/日)
    $rs = file_get_contents($url);

    $rs2 = str_replace('showLocation&&showLocation(','',$rs);
    $rs2 = str_replace(')','',$rs2);

    $json_data = json_decode($rs2,true);

    $lng = $json_data['result']['location']['lng'];
    $lat = $json_data['result']['location']['lat'];
    $data['lat'] =$lat;
    $data['log'] =$lng;

    return $data;
}

/**
 * 独家商品日志
 * @param unknown $type
 * @param unknown $user_id
 * @param unknown $order_id
 * @return number|string|boolean
 */
function soleLog($type,$user_id,$order_id,$order_no = ''){
	// 新增独家商品
	if ($type == 1){
		$desc = '购买独家商品';
	// 独家商品退款
	}elseif ($type == 2){
		$desc = '独家商品退款';
	// 自动取消独家
	}elseif ($type == 3){
		$desc = '自动取消独家';
	}
	$data = [
			'user_id'=>$user_id,
			'order_id'=>$order_id,
			'order_no'=>$order_no,
			'desc'=>$desc,
			'type'=>$type,
			'add_time'=>time(),
	];
	$res = Db::name('sloe_log')->insertGetId($data);
	if ($res){
		return $res;
	}
	return false;
}

/*
 * 数组的最小值和最大值
 */
function array_min_max($arr)
{
    $min_pos = array_search(min($arr), $arr);
    $max_pos = array_search(max($arr), $arr);
    $res['min_value'] = $arr[$min_pos];
    $res['max_value'] = $arr[$max_pos];
    return $res;
}