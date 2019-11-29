<?php
namespace app\common\model;
use think\Db;
use think\Exception;
use think\facade\Request;
/**
 * 平台订单，平台下订
 * Class Cart
 * @package app\api\model
 */
class OrderSupplierByPlat extends BaseModel
{
	protected $name = 'order_supplier_by_plat';
	protected $pk = 'order_id';
	
	/**
	 * 获取订单总数（供应商）
	 * @param $user_id
	 * @param string $type
	 * @return int|string
	 */
	public function getSupplierCount($user_id, $type = 'all')
	{
		// 筛选条件
		$filter = [];
		// 订单数据类型
		switch ($type) {
			case 'all':
				break;
			case 'payment';
			$filter['pay_status'] = 10;
			break;
			case 'uncollected';
			$filter['delivery_status'] = 10;// 未发货
			break;
			case 'received';
			$filter['delivery_status'] = 20;
			$filter['receipt_status'] = 10;// 未收货
			break;
			case 'comment';
			$filter['order_status'] = 30;
			$filter['is_comment'] = 0;
			break;
			case 'refund';
			$filter['order_status'] = 40;// 退款
			break;
		}
		return $this->where('plat_id', '=', $user_id)
		->where('order_status', '<>', 20)
		->where($filter)
		->count();
	}
	
	/**
	 * 获取订单详情（供应商）
	 * @param $user_id
	 * @param string $type
	 * @return int|string
	 */
	public function getSupplierOrderDetail($user_id, $type = 'all')
	{
		// 筛选条件
		$filter = [];
		// 订单数据类型
		switch ($type) {
			// 全部订单
			case 'all':
				break;
				// 待付款（一般用不上）
			case 'payment';
			$filter['pay_status'] = 10;
			break;
			// 待发货
			case 'uncollected';
			$filter['delivery_status'] = 10;// 未发货
			break;
			// 待收货
			case 'received';
			$filter['delivery_status'] = 20;
			$filter['receipt_status'] = 10;// 未收货
			break;
			// 待评论
			case 'comment';
			$filter['order_status'] = 30;
			$filter['is_comment'] = 0;
			break;
			// 退款
			case 'refund';
			$filter['order_status'] = 40;// 退款
			break;
		}
		return $this->where('plat_id', '=', $user_id)
		->where('order_status', '<>', 20)
		->where($filter)
		->select();
	}
	
	/**
	 * 订单确认-立即购买
	 * @param $item_id
	 * @param $goods_num
	 * @param $item_sku_id
	 * @return array
	 * @throws \think\exception\DbException
	 * @throws \app\common\exception\BaseException
	 */
	public function getBuyNow($item_id, $goods_num, $item_sku_id,$prom,$other)
	{
		// 商品信息
		/* @var Item $Item */
		$Item = Item::detail($item_id);
		$agio=10;
		// 判断商品是否下架
		if (!$Item || $Item['is_on_sale'] !== 1) {
			throw new BaseException(['msg' => '很抱歉，商品信息不存在或已下架']);
		}
		// 商品sku信息
		$Item['goods_sku'] = $Item->getGoodsSku($item_sku_id);
		// 判断商品库存
		if ($goods_num > $Item['goods_sku']['store_count'] || $goods_num > $Item['goods_sku']['store_count']) {
			throw new Exception('很抱歉，商品库存不足');
		}
		// 商品单价
		$Item['goods_price'] = $Item['goods_sku'] ? $Item['goods_sku']['shop_price'] :'';
		// 商品总价
		$Item['agio'] = $agio;
		$Item['level'] = 0;
		$Item['total_num'] = $goods_num;
		//是拼团商品修改折扣价格
		if($prom == 1){
			$assemble=(new Assemble)->where(array('item_id'=>$Item['goods_id']))->find();
			$Item['goods_price']= $Item['goods_price']*$assemble['rebate']/10;
			$Item['shop_price']= $Item['goods_sku']['shop_price']*$assemble['rebate']/10;
		}elseif($prom==2){
			$assemble=(new Spike)->where(array('item_id'=>$Item['goods_id']))->find();
			$Item['goods_price']= $Item['goods_price']*$assemble['discount']/10;
			$Item['shop_price']= $Item['goods_sku']['shop_price']*$assemble['discount']/10;
		}
		$Item['total_price'] = $totalPrice = sprintf("%1\$.2f",bcmul($Item['goods_price'], $goods_num, 2)*$agio/10);
		$agio_count =sprintf("%1\$.2f",bcmul($Item['goods_price'], $goods_num, 2)-bcmul($Item['goods_price'], $goods_num, 2)*$agio/10);
		// 商品总重量
		$goods_total_weight = bcmul($Item['weight'], $goods_num, 2);
	
		// 计算配送费用
		// $expressPrice = $intraRegion ? $Item['delivery']->calcTotalFee($goods_num, $goods_total_weight, $cityId) : 0;
		$expressPrice = 0;
		// 订单总金额 (含运费)
		$orderPayPrice = bcadd($totalPrice,$expressPrice, 2);
		// 当前商品是否参与优惠券
		$couponprice=$Item['coupon']>0?bcmul($Item['goods_price'], $goods_num, 2):0;
		// 可用优惠券列表
		// $couponList = UserCoupon::getUserCouponList($user['user_id'], $couponprice);
		return [
				'goods_list' => [$Item],               // 商品详情
				'order_total_num' => $goods_num,        // 商品总数量
				'order_total_price' => $totalPrice,     // 商品总金额 (不含运费)
				'order_pay_price' => $orderPayPrice,    // 订单总金额 (含运费)
				'coupon_list' => 0,   // 优惠券列表
				'agio_count'=>$agio_count,
				'exist_address' => 0,      // 是否存在收货地址
				'express_price' => $expressPrice,       // 配送费用
				'item_id'=>$item_id,
				// 'intra_region' => $intraRegion,         // 当前用户收货城市是否存在配送规则中
				// 'has_error' => $this->hasError(),
				// 'error_msg' => $this->getError(),
				'prom' => $prom,
				'other' => $other,
				'spec_id'=>$item_sku_id,
				'spec_num'=>$goods_num,
		];
	}
	
	/**
	 * 创建新订单
	 * @param $user_id
	 * @param $order
	 * @param $coupon_id
	 * @param string $remark
	 * @return bool
	 * @throws \Exception
	 */
	public function createOrder($user_id, $order)
	{
		// 设置订单优惠券信息
		// $this->setCouponPrice($order, $coupon_id);
		Db::startTrans();
		try {
			// 记录订单信息
			$this->add($user_id, $order);
			// 保存订单商品信息
			// $this->saveOrderGoods($user_id, $order);
			// 更新商品库存 (针对下单减库存的商品)
			$this->updateGoodsStockNum($order['goods_list']);
			// 事务提交
			Db::commit();
			return true;
		} catch (\Exception $e) {
			Db::rollback();
			throw new Exception($e->getMessage());
			return false;
		}
	}
	
	/**
	 * 生成订单号
	 * @return string
	 */
	protected function orderNo()
	{
		return date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
	}
	
	/**
	 * 新增订单记录
	 * @param $user_id
	 * @param $order
	 * @param string $remark
	 * @return false|int
	 */
	private function add($user_id, &$order)
	{
		return $this->insert([
				'user_id' => $user_id,
				'app_id' => self::$app_id,
				'order_no' => $this->orderNo(),
				'spec_id'=>$order['spec_id'],
				'spec_num'=>$order['spec_num'],
				'total_price' => $order['order_total_price'],
				'plat_id'=>$order['goods_list'][0]['plat_id'],
				// 'coupon_id' => $order['coupon_id'],
				// 'coupon_price' => $order['coupon_price'],
				'pay_price' => $order['order_pay_price'],
				'express_price' => $order['express_price'],
				// 'vip_price'=>$order['agio_count'],
				// 'buyer_remark' => trim($remark),
				// 'prom_type' => $prom,
				'prom_statis' => 1,
				'item_id' => $order['item_id'],
				'prom_num' =>isset($otherorder['prom_num'])?$otherorder['prom_num']+1:1,
				'prom_time' =>isset($assemble['start_time'])?$assemble['start_time']:'',
				'give_integral' =>isset($order['goods_list'][0]["give_integral"])?$order['goods_list'][0]["give_integral"]:0,
				'rebate' =>isset($assemble['rebate'])?$assemble['rebate']:'',
				'end_time' =>isset($endtime)?$endtime:'',
		]);
	}
	
	/**
	 * 保存订单商品信息
	 * @param $user_id
	 * @param $order
	 * @return int
	 */
	private function saveOrderGoods($user_id, &$order)
	{
		// 订单商品列表
		$goodsList = [];
		// 订单商品实付款金额 (不包含运费)
		$realTotalPrice = bcsub($order['order_pay_price'], $order['express_price'], 2);
		foreach ($order['goods_list'] as $Item) {
			/* @var Item $Item */
			// 计算商品实际付款价
			$total_pay_price = $realTotalPrice * $Item['total_price'] / $order['order_total_price'];
			$goodsList[] = [
					'user_id' => $user_id,
					'app_id' => self::$app_id,
					'item_id' => $Item['goods_id'],
					'name' => $Item['goods_name'],
					'image' => $Item  ["image"][0]['file_path'],
					'spec_type' => $Item['spec_type'],
					'type' => 20,
					'spec_sku_id' => $Item['goods_sku'] ? $Item['goods_sku']['key'] : $Item['goods_id']+'_1',
					'item_sku_id' => $Item['spec_type'],
					'goods_attr' => $Item['goods_sku'] ? $Item['goods_sku']['goods_attr'] : $Item['goods_remark'],
					'content' => $Item['goods_content'],
					'goods_no' => time(),
					'goods_price' =>$Item['goods_sku']['shop_price'],
					'line_price' => $Item['goods_sku'] ? $Item['goods_sku']['price'] : $Item['market_price'],
					'goods_weight' => $Item['weight'],
					'total_num' => $Item['total_num'],
					'total_price' => $Item['total_price'],
					'total_pay_price' => sprintf('%.2f', $total_pay_price),
			];
		}
		return $this->goods()->saveAll($goodsList);
	}
	
	/**
	 * 更新商品库存 (针对下单减库存的商品)
	 * @param $goods_list
	 * @throws \Exception
	 */
	private function updateGoodsStockNum($goods_list)
	{
		$Item = $goods_list[0];
		// 下单减库存
		//$Item['type'] === 10 && $deductStockData[] = [
		$deductStockData = [
				'store_count' => ['dec', $Item['total_num']],
		];
		$where = [
				'goods_id'=>$Item['goods_id'],
				'key' => $Item['goods_sku']['key'],
				'key_name' => $Item['goods_sku']['key_name'],
				'price' => $Item['goods_sku']['price'],
		];
		(new SpecItemPrice)->where($where)->update($deductStockData);
	}
	
	/**
	 * 根据where条件返回数据
	 * @param unknown $where
	 * @return unknown|boolean
	 */
	public function getAllDataByWhere($where){
		if ($where){
			$data = $this->alias('a')
						->join('bfb_item b','a.item_id = b.goods_id')
						->where('order_status <> 20')
						->paginate(10, false, [
			                'query' => Request::instance()->request()
			            ]);
			if ($data){
				return $data;
			}
		}
		return false;
	}
	
	/**
	 * 退款，将钱返回到用户账户上（后台通过退款申请后）
	 * @param unknown $order_id
	 * @param unknown $user
	 * @return float $pay_price 该笔订单的成交价
	 */
	public function returnbuy($Item){
		// $model = self::getUserOrderDetail($order_id, $user_id);
		// 返回销量
		$this->cancel($Item);
		//将钱返回
		return $Item['pay_price'];
	}
	
	/**
	 * 取消订单
	 * @return bool|false|int
	 * @throws \Exception
	 */
	public function cancel($Item)
	{
		// 回退商品库存
		$this->backGoodsStock($Item);
		return $this->save(['order_status' => 20]);
	}
	
    /**
     * 回退商品库存
     * @param $goodsList
     * @return array|false
     * @throws \Exception
     */
    private function backGoodsStock(&$Item)
    {
        $goodsSpecSave = [];
        // 下单减库存
        if ($Item['type'] === 10) {
            $goodsSpecSave[] = [
                'item_sku_id' => $Item['item_sku_id'],
                'stock_num' => ['inc', $Item['total_num']]
            ];
        }
        // 更新商品规格库存
        return !empty($goodsSpecSave) && (new ItemSku)->isUpdate()->saveAll($goodsSpecSave);
    }
	
	/**
	 * 根据where条件返回数据
	 * @param unknown $where
	 * @return unknown|boolean
	 */
	public function getDataByWhere($where){
		if ($where){
			$data = $this->where($where)->find();
			if ($data){
				return $data;
			}
		}
		return false;
	}
	
	/**
	 * 根据where条件修改数据
	 * @param unknown $where
	 * @return unknown|boolean
	 */
	public function upFieldByWhere($where,$data){
		if (is_array($where) && is_array($data)){
			$res = $this->where($where)->update($data);
			if ($res){
				return $res;
			}
		}
		return false;
	}
}