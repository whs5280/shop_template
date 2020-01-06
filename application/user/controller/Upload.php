<?php
namespace app\user\controller;
use app\common\model\UploadFile;
use app\common\library\storage\Driver as StorageDriver;
use app\common\model\Setting as SettingModel;

/**
 * 文件库管理
 * Class Upload
 * @package app\user\controller
 */
class Upload extends Controller
{
    private $config;

    /**
     * 构造方法
     */
    public function initialize()
    {
        parent::initialize();
        // 存储配置信息
   
        $this->config = SettingModel::getItem('storage');
	
    }

    /**
     * 图片上传接口
     * @param int $group_id
     * @return array
     * @throws \think\Exception
     */
    public function image($group_id = -1)
    {
		
        // 实例化存储驱动
	
        $StorageDriver = new StorageDriver($this->config);
		
        // 上传图片
        if (!$StorageDriver->upload())
            return json(['code' => 0, 'msg' => '图片上传失败' . $StorageDriver->getError()]);
        // 图片上传路径
        $fileName = $StorageDriver->getFileName();
        // 图片信息
        $fileInfo = $StorageDriver->getFileInfo();
        // 添加文件库记录
        $uploadFile = $this->addUploadFile($group_id, $fileName, $fileInfo, 'image');
        // 图片上传成功
        return json(['code' => 1, 'msg' => '图片上传成功', 'data' => $uploadFile]);
    }

    /**
     * 添加文件库上传记录
     * @param $group_id
     * @param $fileName
     * @param $fileInfo
     * @param $fileType
     * @return UploadFile
     */
    private function addUploadFile($group_id, $fileName, $fileInfo, $fileType)
    {
        // 存储引擎
        $storage = $this->config['default'];
        // 存储域名
        $fileUrl = isset($this->config['engine'][$storage]) ? $this->config['engine'][$storage]['domain'] : '';
        // 添加文件库记录
        $model = new UploadFile;
		
        $model->add([
            'group_id' => $group_id > 0 ? (int)$group_id : 0,
            'storage' => $storage,
            'file_url' => $fileUrl,
            'file_name' => $fileName,
            'file_size' => $fileInfo['size'],
            'file_type' => $fileType,
			'user_id'   => $this->store['user_id'],
            'extension' => pathinfo($fileInfo['name'], PATHINFO_EXTENSION),
        ]);
        return $model;
    }
	
	
	public function upload(){
    // 获取表单上传文件 例如上传了001.jpg
    $file = request()->file('file');

    // 移动到框架应用根目录/uploads/ 目录下
    $info = $file->move( './uploads/');
	
		if($info){
		
			$data['src']="http://".$_SERVER['SERVER_NAME'].'/uploads/'.$info->getSaveName();
            $data['src'] = str_replace('\\','/', $data['src']);    // window系统
			$data['title']='';
			return json(['code' => 0, 'msg' => '图片上传成功', 'data' => $data]);
		}else{
			// 上传失败获取错误信息
			return json(['code' => 1, 'msg' => '图片上传失败', 'data' => $info->getSaveName()]);
		}
	}


	// 单图多图上传
	public function uploadMany()
    {
        $files = request()->file('file');
        $images = [];
        $errors = [];
        foreach($files as $file){
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move( './uploads/', time().rand(100000, 999999));
            if($info){
                $path = "http://".$_SERVER['SERVER_NAME'].'/uploads/'.$info->getSaveName();
                //$path = "http://".$_SERVER['SERVER_NAME'].':200'.'/uploads/'.$info->getSaveName();
                array_push($images,$path);
            }else{
                array_push($errors,$file->getError());
            }
        }
        if(!$errors){
            $msg['errno'] = 0;
            $msg['data'] = $images;
            return json($msg);
        }else{
            $msg['errno'] = 1;
            $msg['data'] = $images;
            $msg['msg'] = "上传出错";
            return json($msg);
        }
    }


    public function getImagePathAll(){
        $src = [];
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
                    move_uploaded_file($_FILES["file"]["tmp_name"][$i], "uploads/" . time(). $i .'.jpg');
                    $src[$i] = 'http://'.$_SERVER['SERVER_NAME'].'/uploads/'. time(). $i . '.jpg';
                    db('upload_file')->insert(['storage'=>'local','file_name'=>$src[$i],'file_size'=>$_FILES["file"]["size"][$i],'file_type'=>$_FILES["file"]["type"][$i],'extension'=>$extension]);
                }
            }else{
                return $this->renderError("非法的文件格式".$_FILES["file"]["type"][$i]);
            }
        }
        return json(['errno' => 0, 'msg' => '图片上传成功', 'data' => $src]);
    }

}
