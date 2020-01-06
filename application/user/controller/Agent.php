<?php
namespace app\user\controller;

use app\common\model\AgentInfo;
use app\common\model\Task;
use app\common\model\User as UserModel;
use think\Db;
use think\facade\Request;

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

    /*
     * 冻结列表
     */
    public function freezelist($nickName = '', $gender = null,$pid=null,$is_delete=1,$type=3)
    {
        $model = new UserModel;
        $list = $model->getList(trim($nickName), $gender,$pid,$is_delete,$type);
        $page=$list->render();
        return $this->fetch('freezelist', compact('list','page'));
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
        return $this->renderSuccess('操作成功');
    }

    /**
     * 任务失败
     * @return array
     */
    public function refuse()
    {
        $param = input();
        $model = new Task;
        $res = $model->refuse($param['id'], $param['reason']);
        if ($res!==true) {
            return $this->renderError('操作失败');
        }
        return $this->renderSuccess('操作成功');
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
            $post['avatarUrl'] = 'user/head_img.jpg';     // 默认头像
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
        $info = Db::name('user')->where('user_id', $agent_id)->find();
        $detail['agent_name'] = $info['nickName'];
        $detail['phone'] = $info['phone'];

        return $this->fetch('detail',[
            'detail' => $detail,
        ]);
    }

    /**
     * 发布任务
     * @return array|mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function addTask()
    {
        if (!$this->request->post()) {
            return $this->fetch('add_task');
        }
        $post = input('post.');
        $post['create_time'] = time();
        $task_id = Db::name('task')->insertGetId($post);

        // 更新所有推广员的任务
        $Task = new Task;
        $res = $Task->updateTaskByInsert($task_id);
        if ($res!==true) {
            return $this->renderError('操作失败',url('user/agent/tasklist'));
        }
        return $this->renderSuccess('操作成功',url('user/agent/tasklist'));
    }

    /**
     * 修改任务
     * @return array|mixed
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function editTask(){
        $post = input();
        $list = Db::name('task')->where('task_id',$post['task_id'])->find();

        if (!$this->request->post()) {
            return $this->fetch('edit_task',compact('list'));
        }
        $result = Db::name('task')->where('task_id',$post['task_id'])->update($post);

        // 更新所有推广员的任务
        $Task = new Task;
        $res = $Task->updateTaskByUpdate($post['task_id']);
        if ($res!==true) {
            return $this->renderError('操作失败',url('user/agent/tasklist'));
        }
        return $this->renderSuccess('操作成功',url('user/agent/tasklist'));
    }

    /**
     * 删除任务
     * @return array
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function delTask()
    {
        $task_id = input('id');
        // 删除所有推广员的任务
        $Task = new Task;
        $res = $Task->deleteTaskByDelete($task_id);

        if ($res!==true) {
            return $this->renderError('操作失败',url('user/agent/tasklist'));
        } else {
            $result = Db::name('task')->where('task_id', $task_id)->delete();
            return $this->renderSuccess('操作成功',url('user/agent/tasklist'));
        }
    }

    /**
     * 任务清单
     * @param int $listRows
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function tasklist($content = '',$listRows = 15)
    {
        if(!empty($content)){
            $where[]=['content', 'like', "%$content%"];
            $list = Db::name('task')->where($where)->paginate($listRows, false, [
                'query' => Request::instance()->request()
            ]);

        } else{
            $list = Db::name('task')->paginate($listRows, false, [
                'query' => Request::instance()->request()
            ]);
        }

        $page=$list->render();
        return $this->fetch('tasklist', compact('list','page'));
    }
}