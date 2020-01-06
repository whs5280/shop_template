<?php
namespace app\common\model;
use think\facade\Cache;

/**
 * 行业分类模型
 * Class Category
 * @package app\common\model
 */
class Industry extends BaseModel
{
    protected $name = 'industry';
    protected $pk = 'id';
    /**
     * 隐藏字段
     * @var array
     */
    protected $hidden = ['app_id', 'update_time'];

    /**
     * 分类图片
     * @return \think\model\relation\HasOne
     */
    public function images()
    {
        return $this->hasOne('uploadFile', 'id', 'image');
    }
    /**
     * 所有行业
     * @return mixed
     */
    public function getALL()
    {
        $model=new static;
        if (!$data = Cache::get('industry_')) {
            $data = $model->order(['sort' => 'asc'])->field("id,name,sort,create_time")->select();
        }
        return $data;
    }
    /**
     * 所有分类(暂时不要缓存)
     * @return mixed
     */
    public  function getALLByWhere()
    {
    	$model=new static;
    	//if (!$data=Cache::get('category_' . self::$app_id)) {
    	$data = $model->where(['is_show'=>1])->order(['sort' => 'asc'])->field("id,name,sort,create_time")->select();
    	//Cache::set('category_' . self::$app_id,$data);
    	//}
    	return $data;
    }
    /**
     *清除缓存
     */
    public function cache(){
        Cache::set('industry_',null);
    }
    /**
     * 添加新记录
     * @param $data
     * @return false|int
     */
    public function add($data)
    {
        $this->deleteCache();
        return $this->allowField(true)->save($data);
    }
    /**
     * 编辑记录
     * @param $data
     * @return bool|int
     */
    public function edit($data)
    {
        $where=['id','=',$data['id']];
        $this->deleteCache();
        return $this->isUpdate(true)->allowField(true)->save($data,$where);
    }
    /**
     * 删除记录
     * @param $industry_id
     * @return bool
     * @throws \Exception
     */
    public function remove($industry_id)
    {
        // 判断是否存在商品
        if ($goodsCount = (new Item)->getGoodsTotal(['industry_id' => $industry_id])) {
            $this->error = '该行业下存在' . $goodsCount . '个商品，不允许删除';
            return false;
        }
        $this->deleteCache();
        return $this->delete();
    }
    /**
     * 删除缓存
     * @return bool
     */
    private function deleteCache()
    {
        return Cache::rm('industry_');
    }
    /**
     * 获取分类详情
     * @param $id
     */
    public static function detail($id)
    {
        $model = new static;
        return $model->where('id', '=', $id)->with(['images'])->find();
    }
}