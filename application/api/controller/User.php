<?php

namespace app\api\controller;

use app\common\model\Agent as AgentModel;
use app\common\model\User as UserModel;
use app\common\model\UserInfo;

class User extends Controller
{
	/**
     * app/web/等手机号登录
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
	public function app_login()
    {
		
        $model = new UserModel;
		$user=$model->app_login($this->request->post());
		
		if($user){
			return $this->renderSuccess([
				'user_id' => $user,
				'token' => $model->getToken()
			]);
		}
		return $this->renderError('登录失败');
    }
	/**
	*app/web/等手机号注册
	* @return array
	*/
	public function app_reg(){
		$model = new UserModel;
        return $this->renderSuccess([
            // 'user_id' => $model->reg($this->request->post()),
            // 'token' => $model->getToken()
        ]);
	
	}
	
	/**
	 * 申请商户
	 *  id              商户信息表
		user_id         商户ID
		license_pic     营业执照
		store_pic       店面门头照片
		principal_pic   负责人照片
		status          (0为审核中，1为通过，2为未通过)
		category        用户选择的经营项目
		reason          审核失败原因
		store_address   门面地址
		contact_name    收货人
		contact_address 收货地址
		contact_phone   收货电话
		latitude        坐标
		longitude       坐标
		site            维度确定的位置
		province_id     所属省份
		review_time     审核时间（提交）
		pass_time       审核结果时间
	 */
	public function registerInfo(){
		$data = input('post.');
		$model = new UserModel;
		$reg_data['phone'] = $data['contact_phone'];
		$data['user_id'] = $model->reg($reg_data);
		$UserInfoModel = new UserInfo();
		$data['status'] = 0;
		$data['review_time'] = time();
		$res = $UserInfoModel->Verify($data);
		if ($res){
			return $this->renderSuccess('提交审核成功，请耐心等待');
		}
		return $this->renderError('提交审核失败，请稍后再试');
	}
	
	/**
	 * 返回图片路径
	 */
	public function getImagePath(){
		// 图片上传
		// 允许上传的图片后缀
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);        // 获取文件后缀名
		if ((($_FILES["file"]["type"] == "image/gif")
				|| ($_FILES["file"]["type"] == "image/jpeg")
				|| ($_FILES["file"]["type"] == "image/jpg")
				|| ($_FILES["file"]["type"] == "image/pjpeg")
				|| ($_FILES["file"]["type"] == "image/x-png")
				|| ($_FILES["file"]["type"] == "image/png"))
				&& ($_FILES["file"]["size"] < 204800)    // 小于 200 kb
				&& in_array($extension, $allowedExts))
		{
			if ($_FILES["file"]["error"] > 0){
				return $this->renderError("错误：: " . $_FILES["file"]["error"] . "<br>");
			}else{
				// 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
				move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/" . $_FILES["file"]["name"]);
				return $this->renderSuccess($_FILES["file"]["name"]);
			}
		}else{
			return $this->renderError("非法的文件格式");
		}
	}
	
	/**
	 * 删除图片
	 */
	public function delImagePath(){
		$path = input('post.path');
		unlink("uploads/" . $path);
		return $this->success('已完成');
	}
	
    /**
     * 用户自动登录
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function login()
    {
		
        $model = new UserModel;
		
        return $this->renderSuccess([
            'user_id' => $model->login($this->request->post()),
            'token' => $model->getToken()
        ]);
    }

    /**
     * 推广员登录
     * @return array
     */
    public function agent_login()
    {
        $post = input('post.');
        $model = new AgentModel;
        $user = $model->appLogin($post);
        if ($user) {
            return $this->renderSuccess([
                'user_id' => $user,
                'token' => $model->getToken()
            ]);
        } else{
            return $this->renderError('账号密码错误');
        }
    }
    /**
     * 验证码登录
     */
    // @todo

}
