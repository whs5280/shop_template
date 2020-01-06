<?php
namespace app\api\controller;
use app\common\model\App as AppModel;
use app\common\model\AppHelp;
use app\common\model\Sign;
use think\Db;

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
     * 签到
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function signs()
    {
        $data = [
            'integral' => 1
        ];

        $model = new Sign;
        if ($this->request->isPost()) {
            $user = $this->getUser();
            $is_sign = $model->is_sign($user['user_id']);
            if ($is_sign == 1) {
                return $this->renderError('已签到');
            } else {
                $res = $model->sign($user['user_id']);
                if ($res != true){
                    return $this->renderSuccess([], '签到失败');
                }
                $model->add_sign_log($user['user_id']);
                $integral = 1;  // 默认为1
                \app\common\model\User::sign($user['user_id'], $integral);
                return $this->renderSuccess($data, '签到成功');
            }
        }
    }

    /**
     * 7天签到列表
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @author cjj
     */
    public function sign_list()
    {
        $model = new Sign();
        if ($this->request->isPost()) {
            $user = $this->getUser();
            $res = $model->sign_list($user['user_id']);

            $index = (int)date('d', time()) - 7;

            $data['sign'] = $res['total_days'];
            $data['list'] = str_to_array($index, $res['sign_log']);

            return $this->renderSuccess($data, '获取成功');
        }
    }

    /**
     * 历史签到列表
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function record_list()
    {
        if ($this->request->isPost()) {
            $user = $this->getUser();
            $data = Db::name('sign_log')->where('user_id', $user['user_id'])->order('id','desc')->limit(10)->select();

            foreach ($data as &$item) {
                $item['create_time'] = date('Y-m-d h:m:s', $item['create_time']);
            }

            return $this->renderSuccess($data, '获取成功');
        }
    }
}
