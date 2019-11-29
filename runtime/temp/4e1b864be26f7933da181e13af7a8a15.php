<?php /*a:2:{s:79:"/var/www/html/www.0766city.com/application/user/view/setting/delivery/edit.html";i:1556090954;s:64:"/var/www/html/www.0766city.com/application/user/view/layout.html";i:1556090954;}*/ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title>小程序商城</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="renderer" content="webkit"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <meta name="apple-mobile-web-app-title" content="小程序商城"/>
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
	
        <div class="layui-container">
    <div class="layui-row">
        <div class="layui-col-sm12 layui-col-md12 layui-col-lg12">
			<div class="widget-head">
				<div class="widget-title">新建运费模版</div>
			</div>
			<form id="my-form" class="layui-form" method="post">
				<div class="widget-body layui-col-sm12 layui-col-md12 layui-col-lg12">
						<div class="layui-form-item">
							<label class="layui-form-label">模版名称 </label>
							<div class="layui-col-sm9 layer-midd-left">
								<input type="text" class="layui-input" name="delivery[name]"
									   value="<?php echo isset($model['name']) ? htmlentities($model['name']) : ''; ?>" required>
							</div>
						</div>
						<div class="layui-form-item">
							<label class="layui-form-label form-require">排序 </label>
							<div class="layui-col-sm9 layer-midd-left">
								<input type="number" class="layui-input" name="delivery[sort]"
									   value="100" required>
								<small>数字越小越靠前</small>
							</div>
						</div>
						<div class="layui-form-item">
							<label class="layui-form-label form-require">计费方式 </label>
							<div class="layui-col-sm9 layer-midd-left">
								<label class="layui-input-inline">
									<input type="radio" name="delivery[method]" value="10" data-am-ucheck <?php echo $model['method']['value']==10 ? 'checked'  :  ''; ?>> 按件数

								</label>
								<label class="layui-input-inline">
									<input type="radio" name="delivery[method]" value="20"  data-am-ucheck <?php echo $model['method']['value']==20 ? 'checked'  :  ''; ?>>
									按重量
								</label>
							</div>
						</div>
                         
						<div class="layui-form-item">
							<label class="layui-form-label form-require">
								配送区域及运费
							</label>
							<div class="layui-col-md12" >
								<div class=" layer-scrollable-horizontal">   
									<table width="100%" class="layui-table regional-table">
										<thead>
										<tr>
											<th width="42%">可配送区域</th>
											<th>
												<span class="first"> <?php echo $model['method']===10 ? '首件 (个)'  :  '首重 (Kg)'; ?></span>
											</th>
											<th>运费 (元)</th>
											<th>
												<span class="additional"> <?php echo $model['method']===10 ? '续件 (个)'  :  '续重 (Kg)'; ?></span>
											</th>
											<th>续费 (元)</th>
										</tr>
										<?php if(!(empty($model) || (($model instanceof \think\Collection || $model instanceof \think\Paginator ) && $model->isEmpty()))): foreach($model['rule'] as $item): ?>
											<tr>
												<td class="am-text-left">
													<p class="selected-content am-margin-bottom-xs">
															<?php echo htmlentities($item['region_content']); ?>
													</p>
													<p class="operation am-margin-bottom-xs">
														<a class="edit" href="javascript:;">编辑</a>
														<a class="delete" href="javascript:;">删除</a>
													</p>
													<input type="hidden" name="delivery[rule][region][]"
														   value="<?php echo isset($item['region']) ? htmlentities($item['region']) : ''; ?>">
												</td>
												<td>
													<input type="number" class="layui-input" name="delivery[rule][first][]"
														   value="<?php echo isset($item['first']) ? htmlentities($item['first']) : ''; ?>" required>
												</td>
												<td>
													<input type="number" name="delivery[rule][first_fee][]" class="layui-input"
														   value="<?php echo isset($item['first_fee']) ? htmlentities($item['first_fee']) : ''; ?>" required>
												</td>
												<td>
													<input type="number" name="delivery[rule][additional][]" class="layui-input"
														   value="<?php echo isset($item['additional']) ? htmlentities($item['additional']) : ''; ?>">
												</td>
												<td>
													<input type="number" name="delivery[rule][additional_fee][]" class="layui-input"
														   value="<?php echo isset($item['additional_fee']) ? htmlentities($item['additional_fee']) : ''; ?>">
												</td>
											</tr>
									  <?php endforeach; ?>
									  <?php endif; ?>
										<tr>
											<td colspan="5" class="">
												<a class="add-region layui-btn"
												   href="javascript:;">
													<i class="iconfont icon-dingwei"></i>
													点击添加可配送区域和运费
												</a>
											</td>
										</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div>
							<input type="hidden" name="delivery[delivery_id]" value="<?php echo isset($model['delivery_id']) ? htmlentities($model['delivery_id']) : ''; ?>">
						</div>
						<div class="layui-form-item">
								<button type="submit" class="j-submit layui-btn">提交
								</button>
						</div>
				</div>
			</form>
        </div>
    </div>
</div>
<div class="regional-choice"></div>
<script src="assets/user/js/delivery.js"></script>
<script>
    $(function () {

        // 初始化区域选择界面
        var datas = JSON.parse('<?= $regionData ?>');

        // 配送区域表格
        new Delivery({
            table: '.regional-table',
            regional: '.regional-choice',
            datas: datas
        });

        /**
         * 表单验证提交
         * @type {*}
         */
        $('#my-form').superForm();

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
