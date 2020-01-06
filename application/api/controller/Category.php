<?php
namespace app\api\controller;
use app\common\model\Industry as IndustryModel;
use think\facade\Cache;
use app\common\model\Category as CategoryModel;
use app\common\model\App as AppCategoryModel;
/**
 * 商品分类控制器
 * Class Item
 * @package app\api\controller
 */
class Category extends Controller
{
    /**
     * 分类页面
     * @return array
     * @throws \think\exception\DbException
     */
    /*public function index()
    {
        // 分类模板
		$app_id = $this->app_id;
        $templet = AppCategoryModel::getAppCache($app_id);
        // 商品分类列表
		if(true){// !$list = Cache::get('category_'.$app_id)
			$list = array_values(CategoryModel::getCacheTree());
			foreach ($list as $key=>$value){
				$list[$key]['data'] = CategoryModel::getCategorySe($value['id']);
			}
			Cache::set('category_'.$app_id,$list);
		}
        return $this->renderSuccess(compact('templet', 'list'));
    }*/

    public function index()
    {
        // 分类模板
        $user = $this->getUser();
        $industryIds = explode(',', $user['industry_id']);

        $app_id = $this->app_id;
        $templet = AppCategoryModel::getAppCache($app_id);
        // 商品行业列表
        if(true){
            $list = (new IndustryModel())->getALL();
            foreach ($list as $key=>$value){
                if (in_array($list[$key]['id'], $industryIds)) {
                    $list[$key]['data'] = CategoryModel::getCategory();
                } else {
                    $list[$key]['data'] = [];
                }
            }
        }
        return $this->renderSuccess(compact('templet', 'list'));
    }
}