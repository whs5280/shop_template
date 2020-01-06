<?php
namespace app\api\controller;

use think\Controller;
use think\Db;

class Hst extends Controller{
	
	/**
	 * 添加版本，一般不用
	 */
	public function addVersion(){
		$post = input('post.');
		if ($_FILES['file']['error'] == 0){
			// 删除上一条数据
			if ($info = Db::name('version')->order('id desc')->find()){
				if (unlink($info['path'])){
					Db::name('version')->where(['id'=>$info['id']])->delete();
				}
			}
			$post['path'] = "uploads/version/" . $post['version'] . ".apk";
			move_uploaded_file($_FILES["file"]["tmp_name"], $post['path']);
		}
		$res = Db::name('version')->insertGetId($post);
		return ['path'=>$post['path'],'id'=>$res];
	}
	
	/**
	 * 获取版本信息
	 */
	public function getVersion(){
		$res = Db::name('version')->order('id desc')->find();
		if ($res){
			return $res;
		}
		return false;
	}
}