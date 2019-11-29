<?php /*a:2:{s:70:"/var/www/html/www.0766city.com/application/user/view/tpl/category.html";i:1556090954;s:64:"/var/www/html/www.0766city.com/application/user/view/layout.html";i:1574238926;}*/ ?>
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
	
        <style>
    .img__category_style {
        width: 100%;
        box-shadow: 0 3px 10px #dcdcdc;
    }
</style>
<div class="layui-container">
    <div class="layui-row">
        <div class="layui-col-sm12 layui-col-md12 layui-col-lg12">
			<form id="my-form" class="layui-form tpl-form-line-form"  method="post">
				<div class="widget-head">
					<div class="widget-title">分类页模板</div>
				</div>
				<div class="widget-body layui-col-sm12 layui-col-md12 layui-col-lg12">
						<div class="wrapper layui-container">
							<div class="left-style layui-col-sm12 layui-col-md12 layui-col-lg4">
								<img class="img__category_style"
									 src="assets/user/img/categoryTpl_<?php echo htmlentities($model['category_style']); ?>.png">
							</div>
							<div class="right-form layui-col-sm12 layui-col-md12 layui-col-lg7">
								<div class="layui-form-item">
									<label class="layui-form-label form-require"> 分类页样式 </label>
									<div class="layui-col-sm10" style="margin-top:20px;">
										<label class="layui-col-sm3">
											<input type="radio" name="category[category_style]" value="10" <?php if(!(empty($model['category_style']) || (($model['category_style'] instanceof \think\Collection || $model['category_style'] instanceof \think\Paginator ) && $model['category_style']->isEmpty()))): ?><?php echo $model['category_style']=='10' ? 'checked'  :  ''; ?> <?php endif; ?>>一级分类 (大图)
										</label>
										<label class="layui-col-sm3">
											<input type="radio" name="category[category_style]" value="11" <?php if(!(empty($model['category_style']) || (($model['category_style'] instanceof \think\Collection || $model['category_style'] instanceof \think\Paginator ) && $model['category_style']->isEmpty()))): ?><?php echo $model['category_style']=='11' ? 'checked' :  ''; ?><?php endif; ?>>一级分类 (小图)
										</label>
										<label class="layui-col-sm2">
											<input type="radio" name="category[category_style]" value="20" <?php if(!(empty($model['category_style']) || (($model['category_style'] instanceof \think\Collection || $model['category_style'] instanceof \think\Paginator ) && $model['category_style']->isEmpty()))): ?><?php echo $model['category_style']=='20' ? 'checked'  :  ''; ?><?php endif; ?>>二级分类
										</label>
										<label class="layui-col-sm4">
											<input type="radio" name="category[category_style]" value="30" <?php if(!(empty($model['category_style']) || (($model['category_style'] instanceof \think\Collection || $model['category_style'] instanceof \think\Paginator ) && $model['category_style']->isEmpty()))): ?><?php echo $model['category_style']=='30' ? 'checked'  :  ''; ?><?php endif; ?>>三级分类
										</label>
										<div class="help__style help-block layer-margin-top-xs">
											<small class="<?php echo $model['category_style']===10 ? ''  :  'hide'; ?>" data-value="10">分类图尺寸：宽750像素 高度不限
											</small>
											<small class="<?php echo $model['category_style']===11 ? ''  :  'hide'; ?>"  data-value="11">分类图尺寸：宽188像素 高度不限
											</small>
											<small class="<?php echo $model['category_style']===20 ? ''  :  'hide'; ?>"  data-value="20">分类图尺寸：宽150像素 高150像素
											</small>
											 <small class="<?php echo $model['category_style']===30 ? ''  :  'hide'; ?>"  data-value="30">分类图尺寸：宽150像素 高150像素
											</small>
										</div>
									</div>
								</div>
								<div class="layui-form-item">
									<label class="layui-form-label form-require"> 分享标题: </label>
									<div class="layui-col-sm9">
										<input type="text" class="layui-input" name="category[share_title]"
											   value="<?php echo htmlentities($model['share_title']); ?>">
									</div>
								</div>
								<div class="layui-input-block">
									<div class="layui-col-sm9 layui-col-smpush-3">
										<button type="submit" class="j-submit layui-btn ">提交
										</button>
									</div>
								</div>
							</div>
						</div>
				</div>
			</form>
        </div>
    </div>
</div>
<script>
    $(function () {

        // 切换分类样式图
        var $imgCategorystyle = $('.img__category_style');
        var $helpStyleSmall = $('.help__style').find('small');
		
        $("input[name='category[category_style]']").click(function (e) {
		
            var styleValue = e.currentTarget.value;
            $helpStyleSmall.hide().filter('[data-value=' + styleValue + ']').show();
            $imgCategorystyle.attr('src', 'assets/user/img/categoryTpl_' + styleValue + '.png');
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
