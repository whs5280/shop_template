<?php /*a:5:{s:67:"/var/www/html/www.0766city.com/application/user/view/item/edit.html";i:1577692310;s:64:"/var/www/html/www.0766city.com/application/user/view/layout.html";i:1577669503;s:88:"/var/www/html/www.0766city.com/application/user/view/layouts/_template/file_library.html";i:1577669504;s:82:"/var/www/html/www.0766city.com/application/user/view/item/_template/spec_many.html";i:1577669504;s:89:"/var/www/html/www.0766city.com/application/user/view/layouts/_template/tpl_file_item.html";i:1577669504;}*/ ?>
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
	
        <link rel="stylesheet" href="assets/user/css/goods.css">
<div class="layui-container">
    <div class="layui-row">
        <div class="layui-col-sm12 layui-col-md12 layui-col-lg12">
			<div class="widget-head">
				<div class="widget-title layer-cf">添加商品</div>
			</div>
			<form id="my-form" class="layer-form tpl-form-line-form" method="post">
				<div class="widget-body layui-col-lg12">
					<div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
						<ul class="layui-tab-title">
							<li class="layui-this">基础设置</li>
							<li>商品相册</li>
							<li>商品详情</li>
							<li>商品规格</li>
							<!--<li>商品属性</li>-->
						</ul>
						<div class="layui-tab-content">
							<div class="layui-tab-item layui-show">
								<div class="layer-form-group">
									<label class="layui-form-label form-require">商品名称：</label>
									<div class="layui-col-sm7  layer-midd-left">
										<input type="text" class="tpl-form-input" name="goods[goods_name]" value="<?php echo isset($goodsInfo['goods_name']) ? htmlentities($goodsInfo['goods_name']) : ''; ?>" required>
									</div>
								</div>
								<div class="layer-form-group">
									<label class="layui-form-label form-require">商品简介：</label>
									<div class="layui-col-sm7  layer-midd-left">
										  <textarea rows="3" cols="50" name="goods[goods_remark]"><?php echo isset($goodsInfo['goods_remark']) ? htmlentities($goodsInfo['goods_remark']) : ''; ?></textarea>
									</div>
								</div>
								<div class="layer-form-group">
									<label class="layui-form-label form-require">商品分类： </label>
									<div class="layui-col-sm2 layer-midd-left" style="margin-right:15px;">
										 <input type="text" id="tree"  name="goods[cat_id]" value=""  lay-filter="tree" class="layui-input">
									</div>
									<div class="layui-col-sm2 layer-midd-left">
										<a href="<?php echo url('user/item/editcategory'); ?>" class="layui-btn layui-btn-sm">去添加</a>
									</div>
								</div>
								<!--<div class="layer-form-group">
									<label class="layui-form-label form-require">商品品牌： </label>
									<div class="layui-col-sm2  layer-midd-left">
										<select  id="parent_id_1"  name="goods[brand_id]"
												data-am-selected="{searchBox: 1, btnSize: 'sm'}">
											<option value="0">顶级分类</option>
											<?php if(is_array($brandList) || $brandList instanceof \think\Collection || $brandList instanceof \think\Paginator): $i = 0; $__LIST__ = $brandList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$brand): $mod = ($i % 2 );++$i;?>
												<option <?php if($brand['id'] == $goodsInfo['brand_id']): ?>selected="selected" <?php endif; ?> value="<?php echo isset($brand['id']) ? htmlentities($brand['id']) : ''; ?>">
													<?php echo isset($brand['name']) ? htmlentities($brand['name']) : ''; ?></option>
												<?php endforeach; endif; else: echo "" ;endif; ?>
										</select>										
									</div>
										<div class="layui-col-sm2 layer-midd-left">
											<a href="<?php echo url('user/item/savebrand'); ?>" class="layui-btn layui-btn-sm">去添加</a>
										</div>
								</div>-->
								<!-- 行业列表 -->
								<div class="layer-form-group">
									<label class="layui-form-label form-require">商品行业：</label>
									<div class="layui-col-sm2 layer-midd-left">
										<?php if(is_array($industryList) || $industryList instanceof \think\Collection || $industryList instanceof \think\Paginator): $i = 0; $__LIST__ = $industryList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>
										<input type="checkbox" class="layui-form-checkbox" name="goods[industry_ids][]" <?php if(in_array($item['id'], $industryIds)): ?>checked<?php endif; ?> value="<?php echo htmlentities($item['id']); ?>"><?php echo htmlentities($item['name']); ?>
										<?php endforeach; endif; else: echo "" ;endif; ?>
									</div>
								</div>

								<div class="layer-form-group">
									<label class="layui-form-label form-require">商品重量：</label>
									<div class="layui-col-sm7  layer-midd-left">
										<input type="number" class="tpl-form-input" name="goods[weight]" value="<?php echo isset($goodsInfo['weight']) ? htmlentities($goodsInfo['weight']) : ''; ?>" required>
										<div class="help-block">
											<small>以g为单位</small>
										</div>
									</div>
								</div>

								<div class="layer-form-group">
									<label class="layui-form-label form-require">发货地：</label>
									<div class="layui-col-sm7  layer-midd-left">
										<input type="text" class="tpl-form-input" name="goods[ship_address]" value="<?php echo isset($goodsInfo['ship_address']) ? htmlentities($goodsInfo['ship_address']) : ''; ?>" required>
									</div>
								</div>

								<div class="layer-form-group">
									<label class="layui-form-label form-require">运费模板： </label>
									<div class="layui-col-sm2  layer-midd-left">
										<select name="goods[delivery_id]" required
												data-layer-selected="{searchBox: 1, btnSize: 'sm',  placeholder:'请选择运费模板'}">
											<option value="">请选择运费模板</option>
											<?php if(is_array($delivery) || $delivery instanceof \think\Collection || $delivery instanceof \think\Paginator): $i = 0; $__LIST__ = $delivery;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>
												<option <?php if($item['delivery_id'] == $goodsInfo['delivery_id']): ?>selected="selected"<?php endif; ?> value="<?php echo isset($item['delivery_id']) ? htmlentities($item['delivery_id']) : ''; ?>">
													<?php echo htmlentities($item['name']); ?> (<?php echo htmlentities($item['method']['text']); ?>)
												</option>
											<?php endforeach; endif; else: echo "" ;endif; ?>
										</select>
									</div>
										<div class="layui-col-sm2 layer-midd-left">
											<a href="<?php echo url('user/setting/edit'); ?>" class="layui-btn layui-btn-sm">去添加</a>
										</div>
								</div>
								<div class="layer-form-group">
									<label class="layui-form-label form-require">赠送积分：</label>
									<div class="layui-col-sm7  layer-midd-left">
										<input type="text" class="tpl-form-input"  name="goods[give_integral]"
											   value="<?php echo isset($goodsInfo['give_integral']) ? htmlentities($goodsInfo['give_integral']) : 0; ?>" required>
									</div>
								</div>
								<div class="layer-form-group">
									<label class="layui-form-label form-require">初始销量：</label>
									<div class="layui-col-sm7  layer-midd-left">
										<input type="text" class="tpl-form-input" name="goods[sales_initial]"
											   value="<?php echo isset($goodsInfo['sales_initial']) ? htmlentities($goodsInfo['sales_initial']) : ''; ?>" required>
									</div>
								</div>
								<div class="layer-form-group">
									<label class="layui-form-label form-require">特价折扣：</label>
									<div class="layui-col-sm7  layer-midd-left">
										<input style="width: 100px;" type="text" class="tpl-form-input" name="goods[discount]"
											   value="<?php echo isset($goodsInfo['discount']) ? htmlentities($goodsInfo['discount']) : 0; ?>">
										<div class="help-block">
											<small>无折扣直接不填就好</small>
										</div>
									</div>
								</div>
								<div class="layer-form-group">
									<label class="layui-form-label form-require">积分商品结束时间：</label>
									<div class="layui-col-sm7  layer-midd-left">
										<input style="width: 100px;" type="text" class="tpl-form-input" name="goods[end_time]"
											   value="<?php echo isset($goodsInfo['end_time']) ? htmlentities($goodsInfo['end_time']) : ''; ?>">
										<div class="help-block">
											<small>不是积分商品直接不填就好（样式：年-月-日【9999-12-30】）</small>
										</div>
									</div>
								</div>
								<div class="layer-form-group">
									<label class="layui-form-label form-require">商品独家所需购买数量：</label>
									<div class="layui-col-sm7  layer-midd-left">
										<input style="width: 100px;" type="number" class="tpl-form-input" name="goods[sole_must_num]"
											   value="<?php echo isset($goodsInfo['sole_must_num']) ? htmlentities($goodsInfo['sole_must_num']) : 0; ?>">
										<div class="help-block">
											<small>不是独家商品直接不填就好</small>
										</div>
									</div>
								</div>
								<div class="layer-form-group">
									<label class="layui-form-label form-require">商品独家范围：</label>
									<div class="layui-col-sm7  layer-midd-left">
										<input style="width: 100px;" type="number" class="tpl-form-input" name="goods[sole_range]"
											   value="<?php echo isset($goodsInfo['sole_range']) ? htmlentities($goodsInfo['sole_range']) : 0; ?>">
										<div class="help-block">
											<small>不是独家商品直接不填就好（单位：米）</small>
										</div>
									</div>
								</div>
								<div class="layer-form-group">
									<label class="layui-form-label form-require">商品排序：</label>
									<div class="layui-col-sm7  layer-midd-left">
										<input type="number" class="tpl-form-input" name="goods[sort]" value="<?php echo isset($goodsInfo['sort']) ? htmlentities($goodsInfo['sort']) : 50; ?>" required>
										<div class="help-block">
											<small>数字越小排序越前</small>
										</div>
									</div>
								</div>
								<!--<div class="layer-form-group">
									<label class="layui-form-label form-require">分佣方式：</label>
									 <div class="layer-u-sm-2 layer-midd-left">
									  <select name="goods['agent_type']" lay-verify="required">
										<option value="1" <?php if($goodsInfo['agent_type']==1): ?>checked <?php endif; ?>>百分比</option>
										<option value="2" <?php if($goodsInfo['agent_type']==2): ?>checked <?php endif; ?> >固定</option>
									  </select>
									</div>
									<div class="layer-u-sm-6 layer-midd-left">
										<input type="text" class="tpl-form-input"  name="goods[agent_price]"
											   value="<?php echo isset($goodsInfo['agent_price']) ? htmlentities($goodsInfo['agent_price']) : 0; ?>" placeholder="请输入分佣比例" required>
									</div>
								</div>-->
								<div class="layer-form-group">
									<label class="layui-form-label form-require">商品归属：</label>
									 <div class="layer-u-sm-2 layer-midd-left">
									  <select name="goods[plat_type]" lay-verify="required">
										<option value="1" <?php if($goodsInfo['plat_type']==1): ?>selected <?php endif; ?>>平台订单</option>
										<option value="2" <?php if($goodsInfo['plat_type']==2): ?>selected <?php endif; ?> >平台代发</option>
										<option value="3" <?php if($goodsInfo['plat_type']==3): ?>selected <?php endif; ?> >客户订单</option>
									  </select>
									</div>
									<div class="layer-u-sm-6 layer-midd-left">
										<input style="width: 100px;" type="number" class="tpl-form-input"  name="goods[plat_id]"
											   value="<?php echo isset($goodsInfo['plat_id']) ? htmlentities($goodsInfo['plat_id']) : ''; ?>" placeholder="当选择平台代发、客户订单的时候请输入供应商user_id" oninput="showName(this)">
										<span id="supplierName" style="color: red;"></span>
											<div class="help-block">
												当选择平台代发、客户订单的时候请输入供应商user_id
											</div>
									</div>
								</div>
							</div> 
							<div class="layui-tab-item">    
								<div class="layer-form-group">
									<label class="layui-form-label form-require">商品图片： </label>
									<div class="layui-col-sm7  layer-midd-left">
										<div class="layer-form-file">
											<div class="layer-form-file">
												<button type="button"
														class="j-withdraw_apply  layui-btn layer-btn-secondary layer-radius">
													<i class="layer-icon-cloud-upload"></i> 选择图片
												</button>
												<div class="uploader-list layer-cf">
													<?php if(isset($goodsInfo['image'])): foreach($goodsInfo['image'] as $image): ?>
														<div class="file-item">
															<a href="<?php echo htmlentities($image['file_path']); ?>"
															   title="点击查看大图"
															   target="_blank">
																<img src="<?php echo htmlentities($image['file_path']); ?>">
															</a>
															<input type="hidden"
																   name="goods[goods_images][]"
																   value="<?php echo isset($image['image_id']) ? htmlentities($image['image_id']) : ''; ?>">
															<i class="mdi menu-icon mdi-window-close file-item-delete"></i>
														</div>
												<?php endforeach; ?>
												<?php endif; ?>
												</div>
											</div>
											<div class="help-block">
												<small>尺寸：宽800像素 高度不限</small>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="layui-tab-item">
								<div class="layer-form-group">
									<label class="layui-form-label form-require">商品详情： </label>
									<div class="layui-col-sm7  layer-midd-left">
										<!--<textarea id="container" name="goods[goods_content]" type="text/plain">
										<?php echo htmlentities($goodsInfo['goods_content']); ?>
										</textarea>-->
										<div id="editor">

										</div>
										<textarea id="text1" name="goods[goods_content]" type="text/plain" style="display: none;">
										<?php echo htmlentities($goodsInfo['goods_content']); ?>
										</textarea>
									</div>
								</div>
							</div>
							<div class="layui-tab-item">
								<div class="layer-form-group">
									<label class="layui-form-label form-require">商品类型： </label>
									<div class="layer-u-sm-7 layer-midd-left">
										<select name="goods[spec_type]" id="spec_type">
										<option value="0">顶级分类</option>
										<?php if(isset($itemType)): foreach($itemType as $type): ?>
											<option <?php if($goodsInfo['spec_type'] == $type['id']): ?> selected="selected" <?php endif; ?> value="<?php echo isset($type['id']) ? htmlentities($type['id']) : ''; ?>">
												<?php echo htmlentities($type['name']); ?></option>
											<?php endforeach; ?><?php endif; ?>
										</select>
									</div>
								</div>
								<div id="ajax_spec_data">
								<!-- ajax 返回规格--></div>
							</div>
							<div class="layui-tab-item">
								<table class="table table-bordered attr" id="goods_attr_table" style="width:80%;">
								</table>
							</div>
						</div>
					</div>
					<div class="layer-form-group">
						<div class="layui-col-sm7  layer-u-sm-push-3 layer-margin-top-lg">
							 <input type="hidden"  class="goodsid" name="goods[goods_id]" value="<?php echo htmlentities($goodsInfo['goods_id']); ?>">
							 <input type="hidden"  value="<?php echo isset($goodsInfo['cat_id']) ? htmlentities($goodsInfo['cat_id']) : ''; ?>"  lay-filter="tree" class="layui-input catid">
							<button type="submit" class="j-submit layui-btn layer-btn-secondary">提交
							</button>
						</div>
					</div>
				</div>
            </form>
        </div>
    </div>
</div>
<style type="text/css">
	 /*富文本框高度*/
	.w-e-text-container{
		height: 500px !important;
	}
</style>
<!-- 图片文件列表模板 -->
<!-- 文件库弹窗 -->
<!-- 文件库模板 -->
<script id="tpl-file-library" type="text/template">
    <div class="row">
        <div class="file-group">
            <ul class="nav-new">
                <li class="ng-scope {{ is_default ? 'active' : '' }}" data-group-id="-1">
                    <a class="group-name layui-text-truncate" href="javascript:void(0);" title="全部">全部</a>
                </li>
                <li class="ng-scope" data-group-id="0">
                    <a class="group-name" href="javascript:void(0);" title="未分组">未分组</a>
                </li>
                {{ each group_list }}
                <li class="ng-scope"  data-group-id="{{ $value.group_id }}" title="{{ $value.group_name }}">
                    <a class="group-edit" href="javascript:void(0);" title="编辑分组">
                        <i class="iconfont icon-bianji"></i>
                    </a>
                    <a class="group-name" href="javascript:void(0);">
                        {{ $value.group_name }}
                    </a>
                    <a class="group-delete" href="javascript:void(0);" title="删除分组">
                        <i class="iconfont icon-shanchu1"></i>
                    </a>
                </li>
                {{ /each }}
            </ul>
            <a class="group-add" href="javascript:void(0);">新增分组</a>
        </div>
        <div class="file-list">
            <div class="v-box-header">
                <div class="h-left layui-col-flex">
					<div class="group-select">
						<button type="button" class="group-select layui-btn layer-dropdown">
							移动至 <span class="layer-icon-caret-down"></span>
						</button>
						
					  <!--   <ul class="group-list ">
							<li>请选择分组</li>
							{{ each group_list }}
							<li>
								<a class="move-file-group" data-group-id="{{ $value.group_id }}"
								   href="javascript:void(0);">{{ $value.group_name }}</a>
							</li>
							{{ /each }}
						</ul> -->
						
						<div class="layui-form-item">
							<label class="layui-form-label">请选择分组</label>
							<div class="layui-input-block">
							 
							  <select class="form-control" name="city" lay-verify="required"> 
							  {{ each group_list }}
								<option value="{{ $value.group_id }}" data-group-id="{{ $value.group_id }}">{{ $value.group_name }}</option>
							 {{ /each }}
							  </select>
							 
							</div>
						</div>
					</div>
						
						
					<div class="h-rigth layer-fl layui-input-block">
						<div class="j-upload upload-image">
							<i class="iconfont icon-add1"></i>
							上传图片
						</div>
						
					</div>
					<div class="tpl-table-black-operation layer-fl">
							<a href="javascript:void(0);" class="layui-btn-warm file-delete tpl-table-black-operation-del" data-group-id="2">
								<i class="mdi menu-icon mdi-delete-forever"></i> 删除
							</a>
						</div>
                </div>	
            </div>
            <div id="file-list-body" class="v-box-body">
                {{ include 'tpl-file-list' file_list }}
            </div>
            <div class="v-box-footer"></div>
        </div>
    </div>

</script>

<!-- 文件列表模板 -->
<script id="tpl-file-list" type="text/template">
    <ul class="file-list-item">
        {{ include 'tpl-file-list-item' data }}
    </ul>
    {{ if last_page > 1 }}
    <div class="file-page-box">
        <ul class="pagination">
            {{ if current_page > 1 }}
            <li>
                <a class="switch-page" href="javascript:void(0);" title="上一页" data-page="{{ current_page - 1 }}">«</a>
            </li>
            {{ /if }}
            {{ if current_page < last_page }}
            <li>
                <a class="switch-page" href="javascript:void(0);" title="下一页" data-page="{{ current_page + 1 }}">»</a>
            </li>
            {{ /if }}
        </ul>
    </div>
    {{ /if }}
</script>

<!-- 文件列表模板 -->
<script id="tpl-file-list-item" type="text/template">
    {{ each $data }}
    <li class="ng-scope" title="{{ $value.file_name }}" data-file-id="{{ $value.id }}"
        data-file-path="{{ $value.file_path }}">
        <div class="img-cover"
             style="background-image: url('{{ $value.file_path }}')">
        </div>
        <p class="layui-word-aux">{{ $value.file_name }}</p>
        <div class="select-mask">
            <img src="assets/user/img/chose.png">
        </div>
    </li>
    {{ /each }}
</script>

<!-- 分组元素-->
<script id="tpl-group-item" type="text/template">
    <li class="ng-scope" data-group-id="{{ group_id }}" title="{{ group_name }}">
        <a class="group-edit" href="javascript:void(0);" title="编辑分组">
            <i class="iconfont icon-bianji"></i>
        </a>
        <a class="group-name layer-text-truncate" href="javascript:void(0);">
            {{ group_name }}
        </a>
        <a class="group-delete" href="javascript:void(0);" title="删除分组">
            <i class="iconfont icon-shanchu1"></i>
        </a>
    </li>
</script>
<script id="tpl-file-item" type="text/template">
    {{ each list }}
	
    <div class="file-item">
        <a href="{{ $value.file_path }}" title="点击查看大图" target="_blank">
            <img src="{{ $value.file_path }}">
        </a>
        <input type="hidden" name="{{ name }}" value="{{ $value.file_id}}">
        <i class="iconfont icon-shanchu file-item-delete"></i>
    </div>
    {{ /each }}
</script>

<!-- 商品属性模板 -->
<script id="tpl_attr_attrbute" type="text/template">
    {{ each data }}
		<tr class='attr_{{ $value['attr_id'] }} layer-form-group' style='height:50px'>
		<td class='layui-col-sm4 layui-col-lg2 layer-form-label'> {{ $value['name'] }}</td>
		<td class='layui-col-sm8 layer-u-end'>
		{{ if $value['values'].length <= 1 }}
			<input type='text' size='40' value="{{ if $value.item_attr.length>0 }}{{ $value.item_attr[0]['attr_value'] }}{{ else }}{{ $value.values[0] }}{{ /if }}" name='goods[attr][{{ $value["attr_id"] }}]' />
		{{ else }}
			
			<select class="form-control" name="goods[attr][{{ $value['attr_id'] }}]">
				{{ each $value['values'] as $val }}
					{{ if $value['item_attr'].length>1 }}
						<option {{ if $value['item_attr'][0]['attr_value'] == $val }} selected='selected' {{ /if }} value=" {{ $val }} ">{{ $val }}</option>
					{{ else }}
					<option value='{{ $val }}'>{{ $val }}</option>
					{{ /if }}
					
				{{ /each }}
			</select>
			
		{{ /if }}
		</td>
		</tr>
    {{ /each }}
</script>
<!-- 商品规格模板 -->
<script id="tpl_spec_attr" type="text/template">
		<div class="layer-tab-panel layer-margin-top-lg layer-active layer-in" id="goods_spec_table1">                                
			<div class="layer-form-group">
				<div class="layui-col-sm3 layui-col-lg2 layer-form-label" colspan="2"><b>商品规格:</b></div>
			</div>
			{{ each data.list }}
				<div class="layer-form-group">
					<div class="layui-col-sm3 layui-col-lg2 layer-form-label">{{ $value['name'] }}:</div>
					<div class="layui-col-sm7 layer-u-end"> 
						{{ each $value.spec_item as $val  }}
							<button type="button" data-spec_id="{{ $value.id }}" data-item_id="{{ $val['id'] }}" onclick="layerbtn(this)" class="spec_list layui-btn layui-btn-sm">
							{{ $val['item'] }}
							</button>
						{{ /each }}
					</div>
				</div>                                    
			{{ /each }} 
		</div>
		<div id="goods_spec_table2"> 
    
</script>
<!-- 商品规格table模板 -->
<script id="tpl_spec_table" type="text/template">
    <tbody id='spec_input_tab'>
    <tr>
        {{ each data.title }}
        <th>{{ $value}}</th>
        {{ /each }}
		  <th>市场价</th>
		 <th>成本价</th>
        <th>库存</th>
        <th>商品编码</th>
		<th>商品图片</th>
    </tr>
    {{ each data.list }}
		<tr>
		{{ each $value.name as $vo $key }}
		<td>
			{{ $vo }}
		</td>{{ /each }}
		<td> 
			<input type="text" placeholder="请输入上限"  onkeyup="this.value=this.value.replace(/[^\d\.\d{0,2}]/g,'')" name="goods[sku][{{ $value.id }}][shop_price]"  value="{{ $value['form']['shop_price'] ? $value['form']['shop_price'] : 0 }}" required/>
		</td>
		<td>  
			<input type="text" placeholder="请输入上限"  onkeyup="this.value=this.value.replace(/[^\d\.\d{0,2}]/g,'')" name="goods[sku][{{ $value.id }}][price]"  value="{{ $value['form']['price'] ? $value['form']['price'] : 0 }}" required/>
		</td>
		<td> 
			<input type="text" placeholder="请输入上限"  onkeyup="this.value=this.value.replace(/[^\d\.\d{0,2}]/g,'')" name="goods[sku][{{ $value.id }}][store_count]"  value="{{ $value['form']['store_count'] ? $value['form']['store_count'] : 0 }}" >
		</td>
		<td>  
			<input type="number" name="goods[sku][{{ $value.id }}][sku]" min="1" placeholder="0" value="{{ $value['form']['sku'] ? $value['form']['sku'] : 0 }}" /> 
		</td>
		<td>  
					<div class="layui-form-item">    
						<div class="layer-form-group">
							<div class="layui-col-sm7 layer-midd-left">
								<div class="layer-form-file">
									<button onclick="but_img('{{ $value.id }}')" type="button"
											class="upload-file{{ $value.id }} layer-btn-secondary layer-radius layui-btn">
										<i class="layer-icon-cloud-upload "></i> 选择图片
									</button>
									<div class="uploader-list layer-cf">
										<input type="hidden" name="goods[sku][{{ $value.id }}][item_pic]" value="{{ $value['form']['item_pic_id'] ? $value['form']['item_pic_id'] : '0' }}" />
									</div>
								</div>
							</div>
						</div>
					</div>
		</td>
		</tr>
    {{ /each }}
    </tbody>
</script>
<!-- 图片文件列表模板 -->
<script id="tpl-file-item" type="text/template">
    {{ each list }}
	
    <div class="file-item">
        <a href="{{ $value.file_path }}" title="点击查看大图" target="_blank">
            <img src="{{ $value.file_path }}">
        </a>
        <input type="hidden" name="{{ name }}" value="{{ $value.file_id}}">
        <i class="iconfont icon-shanchu file-item-delete"></i>
    </div>
    {{ /each }}
</script>




<!-- 文件库弹窗 -->
<!-- 文件库模板 -->
<script id="tpl-file-library" type="text/template">
    <div class="row">
        <div class="file-group">
            <ul class="nav-new">
                <li class="ng-scope {{ is_default ? 'active' : '' }}" data-group-id="-1">
                    <a class="group-name layui-text-truncate" href="javascript:void(0);" title="全部">全部</a>
                </li>
                <li class="ng-scope" data-group-id="0">
                    <a class="group-name" href="javascript:void(0);" title="未分组">未分组</a>
                </li>
                {{ each group_list }}
                <li class="ng-scope"  data-group-id="{{ $value.group_id }}" title="{{ $value.group_name }}">
                    <a class="group-edit" href="javascript:void(0);" title="编辑分组">
                        <i class="iconfont icon-bianji"></i>
                    </a>
                    <a class="group-name" href="javascript:void(0);">
                        {{ $value.group_name }}
                    </a>
                    <a class="group-delete" href="javascript:void(0);" title="删除分组">
                        <i class="iconfont icon-shanchu1"></i>
                    </a>
                </li>
                {{ /each }}
            </ul>
            <a class="group-add" href="javascript:void(0);">新增分组</a>
        </div>
        <div class="file-list">
            <div class="v-box-header">
                <div class="h-left layui-col-flex">
					<div class="group-select">
						<button type="button" class="group-select layui-btn layer-dropdown">
							移动至 <span class="layer-icon-caret-down"></span>
						</button>
						
					  <!--   <ul class="group-list ">
							<li>请选择分组</li>
							{{ each group_list }}
							<li>
								<a class="move-file-group" data-group-id="{{ $value.group_id }}"
								   href="javascript:void(0);">{{ $value.group_name }}</a>
							</li>
							{{ /each }}
						</ul> -->
						
						<div class="layui-form-item">
							<label class="layui-form-label">请选择分组</label>
							<div class="layui-input-block">
							 
							  <select class="form-control" name="city" lay-verify="required"> 
							  {{ each group_list }}
								<option value="{{ $value.group_id }}" data-group-id="{{ $value.group_id }}">{{ $value.group_name }}</option>
							 {{ /each }}
							  </select>
							 
							</div>
						</div>
					</div>
						
						
					<div class="h-rigth layer-fl layui-input-block">
						<div class="j-upload upload-image">
							<i class="iconfont icon-add1"></i>
							上传图片
						</div>
						
					</div>
					<div class="tpl-table-black-operation layer-fl">
							<a href="javascript:void(0);" class="layui-btn-warm file-delete tpl-table-black-operation-del" data-group-id="2">
								<i class="mdi menu-icon mdi-delete-forever"></i> 删除
							</a>
						</div>
                </div>	
            </div>
            <div id="file-list-body" class="v-box-body">
                {{ include 'tpl-file-list' file_list }}
            </div>
            <div class="v-box-footer"></div>
        </div>
    </div>

</script>

<!-- 文件列表模板 -->
<script id="tpl-file-list" type="text/template">
    <ul class="file-list-item">
        {{ include 'tpl-file-list-item' data }}
    </ul>
    {{ if last_page > 1 }}
    <div class="file-page-box">
        <ul class="pagination">
            {{ if current_page > 1 }}
            <li>
                <a class="switch-page" href="javascript:void(0);" title="上一页" data-page="{{ current_page - 1 }}">«</a>
            </li>
            {{ /if }}
            {{ if current_page < last_page }}
            <li>
                <a class="switch-page" href="javascript:void(0);" title="下一页" data-page="{{ current_page + 1 }}">»</a>
            </li>
            {{ /if }}
        </ul>
    </div>
    {{ /if }}
</script>

<!-- 文件列表模板 -->
<script id="tpl-file-list-item" type="text/template">
    {{ each $data }}
    <li class="ng-scope" title="{{ $value.file_name }}" data-file-id="{{ $value.id }}"
        data-file-path="{{ $value.file_path }}">
        <div class="img-cover"
             style="background-image: url('{{ $value.file_path }}')">
        </div>
        <p class="layui-word-aux">{{ $value.file_name }}</p>
        <div class="select-mask">
            <img src="assets/user/img/chose.png">
        </div>
    </li>
    {{ /each }}
</script>

<!-- 分组元素-->
<script id="tpl-group-item" type="text/template">
    <li class="ng-scope" data-group-id="{{ group_id }}" title="{{ group_name }}">
        <a class="group-edit" href="javascript:void(0);" title="编辑分组">
            <i class="iconfont icon-bianji"></i>
        </a>
        <a class="group-name layer-text-truncate" href="javascript:void(0);">
            {{ group_name }}
        </a>
        <a class="group-delete" href="javascript:void(0);" title="删除分组">
            <i class="iconfont icon-shanchu1"></i>
        </a>
    </li>
</script>
<script id="tpl-file-item" type="text/template">
    {{ each list }}
	
    <div class="file-item">
        <a href="{{ $value.file_path }}" title="点击查看大图" target="_blank">
            <img src="{{ $value.file_path }}">
        </a>
        <input type="hidden" name="{{ name }}" value="{{ $value.file_id}}">
        <i class="iconfont icon-shanchu file-item-delete"></i>
    </div>
    {{ /each }}
</script>

<script>
function but_img(id){
	//选择图片
	$('.upload-file'+id).selectImages({
	    name: 'goods[sku]['+id+'][item_pic]'
	    // , multiple: true
	});   
}
</script>
<script src="assets/user/js/goods.spec.js"></script>
<script>
var cat_id="<?php echo isset($goodsInfo['cat_id']) ? htmlentities($goodsInfo['cat_id']) : ''; ?>";
</script>
<script src="assets/user/js/goods.category.js"></script>
<!--<script src="assets/user/js/wangEditor.min.js"></script>-->
<script src="https://unpkg.com/wangeditor@3.1.1/release/wangEditor.min.js"></script>
<script type="text/javascript">
	$(function () {
		var E = window.wangEditor;
		var editor = new E('#editor');
		var $content = $('#text1').text();

		editor.customConfig.menus = [
			'head',  // 标题
			'bold',  // 粗体
			'fontSize',  // 字号
			'fontName',  // 字体
			'italic',  // 斜体
			'underline',  // 下划线
			'strikeThrough',  // 删除线
			'link',  // 插入链接
			'justify',  // 对齐方式
			'image',  // 插入图片
			'undo',  // 撤销
			'redo'  // 重复
		];

		editor.customConfig.uploadImgServer = '/index.php?s=/user/upload/uploadMany';  // 上传图片到服务器*/
		editor.customConfig.uploadFileName = "file[]";
		editor.customConfig.uploadImgHooks = {
			before: function (xhr, editor, files) {
				// 图片上传之前触发
				// xhr 是 XMLHttpRequst 对象，editor 是编辑器对象，files 是选择的图片文件

				// 如果返回的结果是 {prevent: true, msg: 'xxxx'} 则表示用户放弃上传
				// return {
				//     prevent: true,
				//     msg: '放弃上传'
				// }
				// alert("前奏");
			},
			success: function (xhr, editor, result) {
				// 图片上传并返回结果，图片插入成功之后触发
				// xhr 是 XMLHttpRequst 对象，editor 是编辑器对象，result 是服务器端返回的结果
				// var url = result.data.url;
				// alert(JSON.stringify(url));
				// editor.txt.append(url);
				// alert("成功");
			},
			fail: function (xhr, editor, result) {
				// 图片上传并返回结果，但图片插入错误时触发
				// xhr 是 XMLHttpRequst 对象，editor 是编辑器对象，result 是服务器端返回的结果
				alert("失败");
			},
			error: function (xhr, editor) {
				// 图片上传出错时触发
				// xhr 是 XMLHttpRequst 对象，editor 是编辑器对象
				// alert("错误");
			},
			// 如果服务器端返回的不是 {errno:0, data: [...]} 这种格式，可使用该配置
			// （但是，服务器端返回的必须是一个 JSON 格式字符串！！！否则会报错）
			customInsert: function (insertImg, result, editor) {
				// 图片上传并返回结果，自定义插入图片的事件（而不是编辑器自动插入图片！！！）
				// insertImg 是插入图片的函数，editor 是编辑器对象，result 是服务器端返回的结果
				// 举例：假如上传图片成功后，服务器端返回的是 <?php echo url("","",true,false);?> 这种格式，即可这样插入图片：
				/*var url = result.data.src;
				insertImg(url);*/
				for(var j=0;j<result.data.length;j++){
					insertImg(result.data[j]);
				}

				// result 必须是一个 JSON 格式字符串！！！否则报错
			}
		}

		editor.customConfig.onchange = function (html) {
            // 监控变化，同步更新到 textarea
			$('#text1').val(html)
        };
		editor.create();
		// 初始化 文本框的值
		console.log($content);
		editor.txt.html($content);
	});

</script>
<script>
		$(function () {
			  // 富文本编辑器
		/*layui.use('layedit', function(){
		var layedit = layui.layedit;
		layedit.build('container', {
		height: 600, //设置编辑器高度
		uploadImage: {
                    url: '/index.php?s=/user/upload/upload' //接口url
                  , type: 'post' //默认post
                }
		});	
		});*/
        // 选择图片
        $('.j-withdraw_apply').selectImages({
            name: 'goods[goods_images][]'
            , multiple: true
        });
		 //地址的定位
		layui.use('element', function(){
			var $ = layui.jquery
			,element = layui.element; //Tab的切换功能，切换事件监听等，需要依赖element模块
		});
        /**
         * 表单验证提交
         * @type {*}
         */
        $('#my-form').superForm();
    });
</script>
<script>
//先执行规格
	var goods_id = '<?php echo htmlentities($goodsInfo['goods_id']); ?>';
	var spec_type  = '<?php echo htmlentities($goodsInfo['spec_type']); ?>';
	if(goods_id){
		spec(spec_type);
		goodstype(goods_id,spec_type);
	}
</script>

<script>
	$(function () {
		showName();
	});

	function showName(obj) {
		let plat_id = $(obj).val();
		console.log(plat_id);

		var url = "<?php echo url('user/supplier/getSUpplierName'); ?>";
		$.post(url, {plat_id: plat_id}, function (result) {
			$('#supplierName').html('供应商名称:' + result);
		});
	}
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
