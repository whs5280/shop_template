<?php /*a:2:{s:70:"/var/www/html/www.0766city.com/application/user/view/order/detail.html";i:1574928983;s:64:"/var/www/html/www.0766city.com/application/user/view/layout.html";i:1574911218;}*/ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title>兴发美博汇商城系统</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="renderer" content="webkit"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <meta name="apple-mobile-web-app-title" content="兴发美博汇商城系统"/>
    <link rel="icon" type="image/png" href="assets/user/i/favicon.ico"/>
    <link rel="stylesheet" href="assets/user/css/wy_modality.css"/>
    <link rel="stylesheet" href="/assets/user/vendors/iconfonts/mdi/css/materialdesignicons.min.css"/>
    <link rel="stylesheet" href="/assets/user/vendors/css/vendor.bundle.base.css"/>
	<link rel="stylesheet" href="assets/layui/css/layui.css"  media="all">
    <script src="assets/user/js/jquery.min.js"></script>
    <script src="assets/user/js/global.js"></script>
    <script>
        BASE_URL = '<?php echo htmlentities($base_url); ?>';
        STORE_URL =  '/index.php?s=/user';
		
    </script>
</head>

<body data-type="">
<div class="layer-g tpl-g">
    <!-- 头部 -->
    <header class="tpl-header">
        <!-- 右侧内容 -->
        <div class="tpl-header-fluid">
            <!-- 侧边切换 -->
            <div class="layer-fl tpl-header-button switch-button">
                <i class="iconfont icon-menufold"></i>
            </div>
            <!-- 刷新页面 -->
            <div class="layer-fl tpl-header-button refresh-button">
                <i class="iconfont icon-refresh"></i>
				<div class="tpl-header-text-gl"><a href="#">功能列表</a></div>
            </div>
            <!-- 其它功能-->
            <div class="layer-fr tpl-header-navbar">
                <ul>
                    <!-- 欢迎语 -->
                    <li class="layer-text-sm tpl-header-navbar-welcome">
                        <a href="<?php echo url("","",true,false);?>">欢迎你，<span><?php echo htmlentities($store['user_name']); ?></span>
                        </a>
                    </li>

                    <!-- 退出 -->
                    <li class="layer-text-sm">
                        <a href="<?php echo url('user/login/logout'); ?>">
                            <i class="iconfont icon-tuichu"></i> 退出
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <!-- 侧边导航栏 -->
    <div class="left-sidebar dis-flex">
        <!-- 一级菜单 -->
        <ul class="sidebar-nav">
            <li class="sidebar-nav-heading"><img class="logo" src="/assets/user/img/logo.png" width="60" /></li>
           <?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>
				<li class="sidebar-nav-link">
                    <a href="<?= isset($item['url']) ? url($item['url']) : 'javascript:void(0);' ?>"
                       class="<?php if($item['model'] == $group): ?> active <?php endif; ?>">
                            <i class="mdi sidebar-nav-link-logo menu-icon <?php echo htmlentities($item['icon']); ?>"></i>
                        <?php echo htmlentities($item['name']); ?>
                    </a>
                </li>
			<?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <!-- 子级菜单-->
		<?php $second = $menu[$group]; if(isset($second['list'])): ?>
            <ul class="left-sidebar-second">
                <!-- <li class="sidebar-second-title"><?php echo htmlentities($menu[$group]['name']); ?></li> -->
                <li class="sidebar-second-item">
                   
					<?php if(is_array($second['list']) || $second['list'] instanceof \think\Collection || $second['list'] instanceof \think\Paginator): $i = 0; $__LIST__ = $second['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>
						
                            <!-- 二级菜单-->
                            <a href="<?php echo url($item['url']); ?>" class="two-active" style="">
                                <?php echo htmlentities($item['name']); ?>
                            </a>
                       
                            <!-- 三级菜单-->
                            <div class="sidebar-third-item">
                               <!--  <a href="javascript:void(0);"
                                   class="sidebar-nav-sub-title <?php echo !empty($item['active']) ? 'active'  :  ''; ?>">
                                    <i class="iconfont icon-caret"></i>
                                    <?php echo htmlentities($item['name']); ?>
                                </a>  -->
								<?php if(isset($item['list'])): ?>
								
                                <ul class="sidebar-third-nav-sub">
								
									<?php if(is_array($item['list']) || $item['list'] instanceof \think\Collection || $item['list'] instanceof \think\Paginator): $i = 0; $__LIST__ = $item['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$third): $mod = ($i % 2 );++$i;?>
                                        <li>
                                            <a class="<?php echo $third['url']==$url ? 'active'  :  ''; ?>"
                                               href="<?php echo url($third['url']); ?>">
                                                <?php echo htmlentities($third['name']); ?></a>
                                        </li>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
									
                                </ul>
								<?php endif; ?>
                            </div>
                      
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </li>
            </ul>
        <?php endif; ?>
    </div>

    <!-- 内容区域 start -->
    <div class="tpl-content-wrapper <?php if(isset($second['list']) == null): ?>no-sidebar-second<?php endif; ?>">
	
        <div class="row-content ">
	<div class="row">
		<div class="layui-col-sm12 layui-col-md12 layui-col-lg12">
			<div class="widget-head ">
				<div class="widget-title ">
					订单详情
				</div>
			</div>
			<div class="widget__order-detail widget-body layui-col-sm12 layui-col-md12 layui-col-lg12">
				<div class="layui-col-sm12">
					<?php
                        // 计算当前步骤位置
                        $progress = 1;
                        $detail['pay_status']['value'] === 20 && $progress += 1;
                        $detail['delivery_status']['value'] === 20 && $progress += 1;
                        $detail['receipt_status']['value'] === 20 && $progress += 1;
                        $detail['order_status']['value'] === 30 && $progress += 1;
                    ?>
					<ul class="order-detail-progress progress-<?php echo htmlentities($progress); ?> ">
						<li>
							<span>下单时间</span>
							<div class="tip">
								<?php echo htmlentities($detail['create_time']); ?>
							</div>
						</li>
						<li>
							<span>付款</span>
							<?php if($detail['pay_status']['value'] === 20): ?>
							<div class="tip">
								<?php echo htmlentities(date('Y-m-d H:i:s',!is_numeric($detail['pay_time'])? strtotime($detail['pay_time']) : $detail['pay_time'])); ?>
							</div>
							<?php endif; ?>
						</li>
						<li>
							<span>发货</span>
							<?php if($detail['delivery_status']['value'] === 20): ?>
							<div class="tip">
								<?php echo htmlentities($detail['order_delivery'][count($detail['order_delivery'])-1]['create_time']); ?>
							</div>
							<?php endif; ?>
						</li>
						<li>
							<span>收货</span>
							<?php if($detail['receipt_status']['value'] === 20): ?>
							<div class="tip">
								<?php echo htmlentities(date('Y-m-d H:i',!is_numeric($detail['order_delivery'][0]['receipt_time'])? strtotime($detail['order_delivery'][0]['receipt_time']) : $detail['order_delivery'][0]['receipt_time'])); ?>
							</div>
							<?php endif; ?>
						</li>
						<li>
							<span>完成</span>
							<?php if($detail['order_status']['value'] === 30): ?>
							<div class="tip">
								<?php echo htmlentities(date('Y-m-d H:i',!is_numeric($detail['end_time'])? strtotime($detail['end_time']) : $detail['end_time'])); ?>
							</div>
							<?php endif; ?>
						</li>
					</ul>
				</div>
				<div class="widget-head layui-col-sm12 layui-col-md12 layui-col-lg12">
					<div class="widget-title">
						基本信息
					</div>
				</div>
				<div class="layui-col-md12">
					<table width="100%" class="layui-table">
						<thead>
						<tr>
							<th>
								订单号
							</th>
							<th>
								买家
							</th>
							<th>
								订单金额
							</th>
							<th>
								交易状态
							</th>
							<?php if(($detail['pay_status']['value'] === 10 && $detail['order_status']['value'] === 10)): ?>
							<th>
								操作
							</th>
							<?php endif; ?>
						</tr>
						<tr>
							<td>
								<?php echo htmlentities($detail['order_no']); ?>
							</td>
							<td>
								<p>
									<?php echo htmlentities($detail['user']['nickName']); ?>
								</p>
								<p class="layer-link-muted">
									(用户id：<?php echo htmlentities($detail['user']['user_id']); ?>)
								</p>
							</td>
							<td class="">
								<div class="td__order-price layer-text-left">
									<ul class="layer-avg-sm-2">
										<li class="layer-text-right">订单总额：</li>
										<li class="layer-text-right">￥<?php echo htmlentities($detail['total_price']); ?> </li>
									</ul>
									<?php if(($detail['coupon_id'] > 0)): ?>
									<ul class="layer-avg-sm-2">
										<li class="layer-text-right">优惠券抵扣：</li>
										<li class="layer-text-right">- ￥<?php echo htmlentities($detail['coupon_price']); ?></li>
									</ul>
									<?php endif; ?>
									<ul class="layer-avg-sm-2">
										<li class="layer-text-right">运费金额：</li>
										<li class="layer-text-right">+ ￥<?php echo htmlentities($detail['express_price']); ?></li>
									</ul>
									<?php if($detail['update_price']['value'] !== '0.00'): ?>
									<ul class="layer-avg-sm-2">
										<li class="layer-text-right">后台改价：</li>
										<li class="layer-text-right"><?php echo htmlentities($detail['update_price']['symbol']); ?>
											￥<?php echo htmlentities($detail['update_price']['value']); ?>
										</li>
									</ul>
									<?php endif; ?>
									<ul class="layer-avg-sm-2">
										<li class="layer-text-right">实付款金额：</li>
										<li class="x-color-red layer-text-right">
											￥<?php echo htmlentities($detail['pay_price']); ?>
										</li>
									</ul>
								</div>
							</td>
							<td>
								<p>
									付款状态：
									<span class="layer-badge <?php echo $detail['pay_status']['value']===20 ? 'layer-badge-success'  :  ''; ?>">
											<?php echo htmlentities($detail['pay_status']['text']); ?>
								</span>
								</p>
								<p>
									发货状态：
									<span class="layer-badge <?php echo $detail['delivery_status']['value']===20 ? 'layer-badge-success'  :  ''; ?>">
											<?php echo htmlentities($detail['delivery_status']['text']); ?>
								</span>
								</p>
								<p>
									收货状态：
									<span class="layer-badge <?php echo $detail['receipt_status']['value']===20 ? 'layer-badge-success'  :  ''; ?>">
											<?php echo htmlentities($detail['receipt_status']['text']); ?>
								</span>
								</p>
							</td>
							<?php if(($detail['pay_status']['value'] === 10 && $detail['order_status']['value'] === 10)): ?>
							<td>
								<p class="layer-text-center">
									<a class="j-update-price" href="javascript:void(0);" data-order_id="<?php echo htmlentities($detail['order_id']); ?>" data-order_price="<?php echo htmlentities($detail['total_price'] - $detail['coupon_price'] + $detail['update_price']['value']); ?>" data-express_price="<?php echo htmlentities($detail['express_price']); ?>">修改价格</a>
								</p>
							</td>
							<?php endif; ?>
						</tr>
						</tbody>
					</table>
				</div>
				<div class="widget-head layui-col-sm12 layui-col-md12 layui-col-lg12">
					<div class="widget-title ">
						商品信息
					</div>
				</div>
				<div class="layui-col-md12">
					<table width="100%" class="layui-table">
						<thead>
						<tr>
							<th>
								商品名称
							</th>
							<th>
								商品编码
							</th>
							<th>
								重量(Kg)
							</th>
							<th>
								单价
							</th>
							<th>
								购买数量
							</th>
							<th>
								商品总价
							</th>
						</tr>
						<?php foreach($detail['goods'] as $Item): ?>
						<tr>
							<td class="goods-detail layer-text-middle">
								<div class="goods-image">
									<img src="<?php echo htmlentities($Item['image']); ?>" alt="">
								</div>
								<div class="goods-info">
									<p class="goods-title">
										<?php echo htmlentities($Item['name']); ?>
									</p>
									<p class="goods-spec layer-link-muted">
										<?php echo htmlentities($Item['goods_attr']); ?>
									</p>
								</div>
							</td>
							<td>
								<?php echo !empty($Item['goods_no']) ? htmlentities($Item['goods_no']) : '--'; ?>
							</td>
							<td>
								<?php echo !empty($Item['goods_weight']) ? htmlentities($Item['goods_weight']) : '--'; ?>
							</td>
							<td>
								￥<?php echo htmlentities($Item['goods_price']); ?>
							</td>
							<td>
								×<?php echo htmlentities($Item['total_num']); ?>
							</td>
							<td>
								￥<?php echo htmlentities($Item['total_price']); ?>
							</td>
						</tr>
						<?php endforeach; ?>
						<tr>
							<td colspan="6" class="layer-text-right ">
								<span class="">买家留言：<?php echo !empty($detail['buyer_remark']) ? htmlentities($detail['buyer_remark']) : '无'; ?></span>
								<span class="layer-fr">总计金额：￥<?php echo htmlentities($detail['total_price']); ?></span>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
				<div class="widget-head layui-col-sm12 layui-col-md12 layui-col-lg12">
					<div class="widget-title ">
						收货信息
					</div>
				</div>
				<div class="layui-col-md12">
					<table width="100%" class="layui-table">
						<thead>
						<tr>
							<th>
								收货人
							</th>
							<th>
								收货电话
							</th>
							<th>
								收货地址
							</th>
						</tr>
						<tr>
							<td>
								<?php echo htmlentities($detail['address']['name']); ?>
							</td>
							<td>
								<?php echo htmlentities($detail['address']['phone']); ?>
							</td>
							<td>
								<?php echo htmlentities($detail['address']['region']['province']); ?>
								<?php echo htmlentities($detail['address']['region']['city']); ?>
								<?php echo htmlentities($detail['address']['region']['region']); ?>
								<?php echo htmlentities($detail['address']['detail']); ?>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
				<?php if($detail['pay_status']['value'] === 20): ?>
				<div class="widget-head layui-col-sm12 layui-col-md12 layui-col-lg12">
					<div class="widget-title ">
						付款信息
					</div>
				</div>
				<div class="layui-col-md12">
					<table width="100%" class="layui-table">
						<thead>
						<tr>
							<th>
								应付款金额
							</th>
							<th>
								支付方式
							</th>
							<th>
								支付流水号
							</th>
							<th>
								付款状态
							</th>
							<th>
								付款时间
							</th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td>
								￥<?php echo htmlentities($detail['pay_price']); ?>
							</td>
							<td>
								微信支付
							</td>
							<td>
								<?php echo !empty($detail['transaction_id']) ? htmlentities($detail['transaction_id']) : '--'; ?>
							</td>
							<td>
							<span class="layer-badge <?php echo $detail['pay_status']['value']===20 ? 'layer-badge-success'  :  ''; ?>">
												<?php echo htmlentities($detail['pay_status']['text']); ?>
							</span>
							</td>
							<td>
								<?php echo !empty($detail['pay_time']) ? date('Y-m-d H : i:s', $detail['pay_time']) : '--'; ?>
							</td>
						</tr>
						</tbody>
					</table>
				</div>
				<?php endif; if($detail['pay_status']['value'] === 20 || $detail['pay_status']['value'] === 40): ?>
				<div class="widget-head layui-col-sm12 layui-col-md12 layui-col-lg12">
					<div class="widget-title">
						物流信息
					</div>
				</div>
				<div class="layui-col-md12">
					<table class="layui-table">
						<thead>
						<tr>
							<th>
								物流公司
							</th>
							<th>
								物流单号
							</th>
							<th>
								类型
							</th>
							<th>
								发货时间
							</th>
							<th>
								收货时间
							</th>
						</tr>
						<tbody>
						<?php if(is_array($detail['order_delivery']) || $detail['order_delivery'] instanceof \think\Collection || $detail['order_delivery'] instanceof \think\Paginator): $i = 0; $__LIST__ = $detail['order_delivery'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
						<tr>
							<td>
								<?php echo htmlentities($vo['company']); ?>
							</td>
							<td>
								<?php echo htmlentities($vo['express_no']); ?>
							</td>
							<td>
								<?php if($vo['type'] ==1): ?>卖家发货<?php else: ?>买家退货<?php endif; ?>
							</td>
							<td>
								<?php echo htmlentities($vo['create_time']); ?>
							</td>
							<td>
								<?php if($vo['receipt_time']): ?> <?php echo htmlentities(date('Y-m-d H:i',!is_numeric($vo['receipt_time'])? strtotime($vo['receipt_time']) : $vo['receipt_time'])); ?><?php endif; ?>
							</td>
						</tr>
						<?php endforeach; endif; else: echo "" ;endif; ?>
						</tbody>
					</table>
				</div>
				<?php endif; ?>
				<!-- 去发货 -->
				<?php if($detail['delivery_status']['value'] === 10): ?>
				<form id="my-form" class="layui-form" method="post" action="<?php echo url('order/delivery', ['order_id' =>
					 $detail['order_id']]); ?>">
					<div class="layui-form-item">
						<label class="layui-form-label form-require">物流公司 </label>
						<div class="layui-col-sm9 layer-u-end layer-padding-top-xs">
							<select name="order[express_id]" data-am-selected="{btnSize: 'sm', maxHeight: 240}" required>
								<option value=""></option>
								<?php if((isset($express_list))): foreach($express_list as $expres): ?>
								<option value="<?php echo htmlentities($expres['express_id']); ?>">
									<?php echo htmlentities($expres['express_name']); ?>
								</option>
								<?php endforeach; ?> <?php endif; ?>
							</select>
							<div class="help-block layer-margin-top-xs">
								<small>可在 <a href="<?php echo url('setting/express'); ?>" target="_blank">物流公司列表</a>
									中设置
								</small>
							</div>
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label form-require">物流单号 </label>
						<div class="layui-col-sm9 layer-u-end">
							<input type="text" class="layui-input" name="order[express_no]" required>
						</div>
					</div>
					<div class="layui-form-item">
						<button type="submit" class="j-submit layui-btn">
							确认发货
						</button>
					</div>
				</form>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<script id="tpl-update-price" type="text/template">
	<div class="layer-padding-top-sm">
		<form id="money-form" class="form-update-price layer-form tpl-form-line-form" method="post"
			  action="<?php echo url('order/updatePrice', ['order_id' => $detail['order_id']]); ?>">
			<div class="layui-form-item">
				<label class="layui-col-sm3 layer-form-label"> 订单金额 </label>
				<div class="layui-col-sm9">
					<input type="number" min="0.00" class="tpl-form-input" name="order[update_price]"
						   value="{{ order_price }}">
					<small>最终付款价 = 订单金额 + 运费金额</small>
				</div>
			</div>
			<div class="layui-form-item">
				<label class="layui-col-sm3 layer-form-label"> 运费金额 </label>
				<div class="layui-col-sm9">
					<input type="number" min="0.00" class="tpl-form-input" name="order[update_express_price]"
						   value="{{ express_price }}">
				</div>
			</div>
		</form>
	</div>
</script>
<script>
    $(function () {
        /**
         * 修改价格
         */
        $('.j-update-price').click(function () {
            var $this = $(this);
            var data = $this.data();
            // var orderId = $(this).data('order_id');
            layer.open({
                type: 1
                , title: '订单价格修改'
                , area: '340px'
                , offset: 'auto'
                , anim: 1
                , closeBtn: 1
                , shade: 0.3
                , btn: ['确定', '取消']
                , content: template('tpl-update-price', data)
                , success: function (layero) {
                }
                , yes: function (index) {
                    // console.log('asdasd');
                    // 表单提交
                    $('.form-update-price').ajaxSubmit({
                        type: "post",
                        dataType: "json",
                        success: function (result) {
                            result.code === 1 ? $.show_success(result.msg, result.url)
                                : $.show_error(result.msg);
                        }
                    });
                    layer.close(index);
                }
            });
        });
        /**
         * 表单验证提交
         * @type {*}
         */
        $('#my-form').superForm();
        $('#money-form').superForm();
    });
</script>
    </div>
    <!-- 内容区域 end -->

</div>
    <script src="assets/user/js/validform.min.js"></script> <!-- 提交 -->
    <script src="assets/user/js/jquery.form.min.js"></script>
    <script src="assets/user/js/webuploader.html5only.js"></script>
	<script src="assets/user/js/art-template.js"></script>
	<script src="assets/user/js/app.js"></script>
	<script src="assets/user/js/file.library.js"></script>
	<script src="/assets/layui/layui.all.js" charset="utf-8"></script>
</body>
</html>
