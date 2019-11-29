<?php
namespace app\user\controller;

use app\common\model\AgentInfo;
use app\common\model\Task;
use app\common\model\User as UserModel;
/**
 * 推广员列表
 * Class Agent
 * @package app\user\controller
 */
class Agent extends Controller
{
    public function index($nickName = '', $gender = null,$pid=null,$is_delete=0,$type=3)
    {
        $model = new UserModel;
        $list = $model->getList(trim($nickName), $gender,$pid,$is_delete,$type);
        $page=$list->render();
        return $this->fetch('index', compact('list','page'));
    }

    /**
     * 待审核任务
     * @param $status
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function task($status=-1)
    {
        $model = new Task;
        $list = $model->getAll($status);
        $page=$list->render();
        return $this->fetch('task', compact('list','page'));
    }

    /**
     * 任务通过
     * @param $id
     * @return array
     * @throws \think\Exception
     */
    public function pass($id)
    {
        $model = new Task;
        $res = $model->pass($id);
        if ($res!==true) {
            return $this->renderError('操作失败');
        }
        return $this->renderSuccess('任务通过');
    }

    /**
     * 推广员注册
     * @return array|bool
     * @throws \think\exception\PDOException
     */
    public function saveAgent()
    {
        if (!$this->request->post()) {
            return $this->fetch('save',compact(''));
        }
        $post = input('post.');
        // 将供应商信息存库
        $User = new UserModel;
        $Agent = new AgentInfo;
        $Task = new Task;

        try {
            $User->startTrans();
            $Agent->startTrans();
            $Task->startTrans();

            $user_id = $User->reg(['phone'=>$post['phone'],'type'=>3]);
            if (!$user_id){
                return $this->renderError('该号码已注册，不可重复使用', url('user/agent/index'));
            }
            $post['password'] = wymall_pass($post['password']);
            $post['type'] = 3;
            $post['create_time'] = time();
            $post['avatarUrl'] = '/assets/user/img/head_img.jpg';     // 默认头像
            $post['nickName'] = random_nickname();     // 随机昵称
            //$post['pass_time'] = time();  // 暂时直接通过

            // 用户信息存库
            $res = $User->isUpdate(true)->save($post, ['user_id' => $user_id]);
            if ($res !== true){
                return false;
            }
            // 生成推广员信息
            $res = $Agent->save([
                'agent_id' => $user_id,
                'app_id' => '10001',
                'create_time' => time()
            ]);
            if ($res !== true){
                return false;
            }
            // 生成任务清单
            $res = $Task->autoCreateTask($user_id);
            if ($res !== true){
                return false;
            }

            $User->commit();
            $Agent->commit();
            $Task->commit();
            return $this->renderSuccess('添加成功', url('user/agent/index'));
        } catch (\Exception $e) {
            $User->rollback();
            $Agent->rollback();
            $Task->rollback();

            return $this->renderError('添加失败', url('user/agent/index'));
        }
    }

    /**
     * 推广员详情
     * @param $agent_id
     * @return mixed
     */
    public function detail($agent_id)
    {
        $detail = AgentInfo::detail($agent_id);
        return $this->fetch('detail',[
            'detail' => $detail,
        ]);
    }
}