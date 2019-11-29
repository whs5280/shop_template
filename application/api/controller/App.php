<?php
namespace app\api\controller;
use app\common\model\App as AppModel;
use app\common\model\AppHelp;
use app\common\model\Sign;

/**
 * 微信小程序
 * Class App
 * @package app\api\controller
 */
class App extends Controller
{
    /**
     * 小程序基础信息
     * @return array
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function base()
    {
        $app = AppModel::getAppCache();
	
        return $this->renderSuccess(compact('app'));
    }

    /**
     * 帮助中心
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function help()
    {
        $model = new AppHelp;
        $list = $model->getList();
        return $this->renderSuccess(compact('list'));
    }

    /**
     * @method
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function signs()
    {
        $model = new Sign;
        if ($this->request->isPost()) {

            $user = $this->getUser();
            $day = date('d', time());
            // 是否签到
            $is_sign = $model->getSignLog($user['user_id'], $day);

            if ($is_sign == 1){
                return $this->renderError('已签到');
            }

            $integral = $model->setSignLog($user['user_id']);
            // 添加积分
            \app\common\model\User::sign($user['user_id'], $integral);
            return $this->renderSuccess('签到成功');
        }
    }

}
