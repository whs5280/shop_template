<?php

namespace app\api\controller;

use app\common\model\AppPage;

/**
 * 页面控制器
 * Class Index
 * @package app\api\controller
 */
class Page extends Controller
{
    /**
     * 首页diy数据
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function home()
    {
        // 页面元素
        $items = AppPage::getPageItems($this->getUser(false));
		return $this->renderSuccess(compact('items'));
    }

    /**
     * 自定义页数据
     * @param $page_id
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function custom($page_id)
    {
        // 页面元素
        $items = AppPage::getPageItems($this->getUser(false), $page_id);
        return $this->renderSuccess(compact('items'));
    }

}
