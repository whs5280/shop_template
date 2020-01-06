<?php

namespace app\api\controller;

use app\common\model\Agent as AgentModel;
use app\common\model\User as UserModel;
use app\common\model\UserInfo;
use app\common\model\Supplier;
use app\common\model\Region;
use app\common\model\Category;
use app\common\model\Industry;
use app\common\library\sms\Driver as SmsDriver;
use app\common\model\Setting as SettingModel;
use think\Db;

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
			$token = $model->getToken();
			if ($user['type'] == 2){// 自动供应商登录
				$Supplier = new Supplier();
				$token = $Supplier->appLogin($this->request->post());
			}
            if ($user['type'] == 3) {
                $model = new AgentModel;
                $user = $model->appLogin($this->request->post());
                $token = $model->getToken();
            }
			return $this->renderSuccess([
				'user_id' => $user['user_id'],
				'type' => $user['type'],
				'token' => $token
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
        organization_code组织机构代码
		license_pic     营业执照
		store_pic       店面门头照片
		store_info_pic	店内照片
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
		$Region = new Region();
        $data['organization_code'] = strtoupper($data['organization_code']);
		$reg_data['province_id'] = $data['province_id'] = $Region->getIdByName($data['province_id'],1);
		$reg_data['city_id'] = $data['city_id'] = $Region->getIdByName($data['city_id'],2,$data['province_id']);
		$reg_data['region_id'] = $data['region_id'] = $Region->getIdByName($data['region_id'],3,$data['city_id']);
		$reg_data['phone'] = $data['contact_phone'];
		$reg_data['password'] = $data['password'];
		$reg_data['industry_id'] = $data['industry'];
        $reg_data['organization_code'] = $data['organization_code'];
		$data['user_id'] = $model->reg($reg_data);
		if (!$data['user_id']){
			return $this->renderError('提交审核失败，该手机号已注册');
		}
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
	 * 获取所有的分类
	 */
	public function getCategory(){
		$model = new Industry();
		$data = $model->getALLByWhere();
		return $this->renderSuccess($data);
	}
	
	/**
	 * 获取详细的地址信息，一般不用
	 */
	public function getRegionTree(){
		die;
		$model = new Region();
		$data = $model->getCacheTree1();
		return $this->renderSuccess($data);
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
		if (!($_FILES["file"]["size"] < 10485760))return $this->renderError("非法的文件大小");
		if (!in_array($extension, $allowedExts)){
			return $this->renderError("非法的文件格式1".$_FILES["file"]["type"]);
		}
		if (	   ($_FILES["file"]["type"] == "image/gif")
				|| ($_FILES["file"]["type"] == "image/jpeg")
				|| ($_FILES["file"]["type"] == "image/jpg")
				|| ($_FILES["file"]["type"] == "image/pjpeg")
				|| ($_FILES["file"]["type"] == "image/x-png")
				|| ($_FILES["file"]["type"] == "image/png")
				|| ($_FILES["file"]["type"] == "application/octet-stream")
		)
		{
			if ($_FILES["file"]["error"] > 0){
				return $this->renderError("错误：: " . $_FILES["file"]["error"] . "<br>");
			}else{
				// 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
				move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/" . $_FILES["file"]["name"]);
				db('upload_file')->insert(['storage'=>'local','file_name'=>$_FILES["file"]["name"],'file_size'=>$_FILES["file"]["size"],'file_type'=>$_FILES["file"]["type"],'extension'=>$extension]);
				return $this->renderSuccess($_FILES["file"]["name"]);
			}
		}else{
			return $this->renderError("非法的文件格式".$_FILES["file"]["type"]);
		}
	}
	
	/**
	 * 返回图片路径
	 */
	public function getImagePathAll(){
		$name = [];
		// 图片上传
		// 允许上传的图片后缀
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		$image=$_FILES["file"]["name"];
		for ($i=0,$len=count($image);$i<$len;$i++){
			$temp = explode(".", $_FILES["file"]["name"][$i]);
			$extension = end($temp);        // 获取文件后缀名
			if (!($_FILES["file"]["size"][$i] < 10485760))return $this->renderError("非法的文件大小");
			if (!in_array($extension, $allowedExts))return $this->renderError("非法的文件格式1".$_FILES["file"]["type"][$i]);
			if (	   ($_FILES["file"]["type"][$i] == "image/gif")
					|| ($_FILES["file"]["type"][$i] == "image/jpeg")
					|| ($_FILES["file"]["type"][$i] == "image/jpg")
					|| ($_FILES["file"]["type"][$i] == "image/pjpeg")
					|| ($_FILES["file"]["type"][$i] == "image/x-png")
					|| ($_FILES["file"]["type"][$i] == "image/png")
					|| ($_FILES["file"]["type"][$i] == "application/octet-stream")
				)
			{
				if ($_FILES["file"]["error"][$i] > 0){
					return $this->renderError("错误：: " . $_FILES["file"]["error"][$i] . "<br>");
				}else{
					// 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
					move_uploaded_file($_FILES["file"]["tmp_name"][$i], "uploads/" . $_FILES["file"]["name"][$i]);
					$name[$i] = $_FILES["file"]["name"][$i];
					db('upload_file')->insert(['storage'=>'local','file_name'=>$name[$i],'file_size'=>$_FILES["file"]["size"][$i],'file_type'=>$_FILES["file"]["type"][$i],'extension'=>$extension]);
				}
			}else{
				return $this->renderError("非法的文件格式".$_FILES["file"]["type"][$i]);
			}
		}
		return $this->renderSuccess($name);
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
	public function validatePhoneCode(){
		$post = input('post.');
		// 根据验证码id进行查询出数据
		$info = Db::name('sms_log')->where(['id'=>$post['p_id']])->find();
		// 判断手机号码和验证码是否一致
		if ($info['mobile'] == $post['phone'] && $info['code'] == $post['code']){
			if ($info['status'] == 1){
				Db::name('sms_log')->where(['id'=>$post['p_id']])->update(['status'=>2]);
				return $this->renderSuccess(['code'=>$info['status'],'message'=>$info['message']]);
			}elseif ($info['status'] == 2) {
				return $this->renderError('该验证码已失效');
			}else {
				return $this->renderError($info['message']);
			}
		}else {
			return $this->renderError('验证码错误');
		}
	}

	/**
	 * 短信验证码
	 */
	public function sendPhoneCode(){
		$phone = input('post.phone');
		$smsConfig = SettingModel::getItem('sms', '10001');
		$SmsDriver = new SmsDriver($smsConfig);
		$templateParams = 'SMS_179280045';
		// code
		$code = mt_rand(100000,999999);
		$res = $SmsDriver->sendSmsCode($phone, $templateParams, $code);
		$data = [
				'mobile'=>$phone,
				'session_id'=>$res->RequestId,
				'add_time'=>time(),
				'code'=>$code,
				'scene'=>1,
				'message'=>$res->Message,
				'error_msg'=>$res->Code,
		];
		if ($res->Code == 'OK'){
			$data['status'] = 1;
			$data['bizid']=$res->BizId;
		}else {
			$data['status'] = 0;
		}
		$id = Db::name('sms_log')->insertGetId($data);
		if ($id){
			if ($data['status'] == 0){
				return $this->renderError($res->Message);
			}
			return $this->renderSuccess(['id'=>$id]);
		}else {
			return $this->renderError('验证码发送失败');
		}
	}

    /**
     * 修改用户信息
     */
	public function changeInfo()
    {
        $param = input();
        $model = new \app\common\model\User();
        $res = $model->changeInfo($param,$param['user_id']);
        if ($res == true) {
            return $this->renderSuccess([],'修改成功');
        } else{
            return $this->renderError('修改失败');
        }
    }

    /**
     * 修改密码
     * @return array
     */
    public function changePassword()
    {
        $param = input();
        $model = new \app\common\model\User();
        $res = $model->changePassword($param,$param['user_id']);
        if ($res == true) {
            return $this->renderSuccess([],'修改密码成功');
        } else{
            return $this->renderError('修改密码失败');
        }
    }

    /**
     * 修改头像
     * @return array|\think\response\Json
     */
    public function changePic(){
        $post = input();
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');

        // 移动到框架应用根目录/uploads/ 目录下
        $info = $file->move( './uploads');

        if($info){
            $src = $info->getSaveName();
            $src = str_replace('\\','/', $src);
            $post['avatarUrl'] = $src;
            $model = new \app\common\model\User();
            $res = $model->changeInfo($post,$post['user_id']);

            if ($res == true) {
                return $this->renderSuccess([],'图片上传成功');
            } else{
                return $this->renderError('修改失败');
            }
        }else{
            // 上传失败获取错误信息
            return json(['code' => 0, 'msg' => '图片上传失败', 'data' => $info->getSaveName()]);
        }
    }
}
