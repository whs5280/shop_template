<?php /*a:2:{s:53:"F:\0766city\application\user\view\auth\user\edit.html";i:1556090954;s:45:"F:\0766city\application\user\view\layout.html";i:1556090954;}*/ ?>
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
				<div class="widget-title"><?php if(isset($detail['user_id'])): ?>编辑 <?php else: ?>新增<?php endif; ?>管理员</div>
			</div>
			<form id="my-form" class="layui-form" method="post">
				<div class="widget-body layui-col-lg12"> 
					<div class="layui-form-item">
						<label class="layui-form-label form-require">用户名 </label>
						<div class="layui-col-sm6 layer-midd-left">
							<input type="text" class="layui-input" name="user[user_name]"  value="<?php echo isset($detail['user_name']) ? htmlentities($detail['user_name']) : ''; ?>" <?php if($detail['user_id']): ?> readonly="readonly"  <?php endif; ?> placeholder="子账号登录名为 主账号:子账号" required>
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label form-require">所属角色  </label>
						<div class="layui-col-sm6 layer-midd-left">
							<select name="user[role_id]" >
								{ if (isset($roleList))}
								<?php if(is_array($roleList) || $roleList instanceof \think\Collection || $roleList instanceof \think\Paginator): $i = 0; $__LIST__ = $roleList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$role): $mod = ($i % 2 );++$i;?>
									<option  <?php if($role['role_id']== $detail['role_id']): ?>  selected <?php endif; ?> value="<?php echo htmlentities($role['role_id']); ?>"><?php echo htmlentities($role['role_name']); ?>
									   </option>
								<?php endforeach; endif; else: echo "" ;endif; ?>
								{/if}
							</select>
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label form-require">登录密码 </label>
						<div class="layui-col-sm6 layer-midd-left">
							<input type="password" class="layui-input" name="user[password]" value="" placeholder="请输入登录密码">
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label form-require">确认密码 </label>
						<div class="layui-col-sm6 layer-midd-left">
							<input type="password" class="layui-input" name="user[password_confirm]"  value="" placeholder="请输入确认密码">
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label form-require">昵称 </label>
						<div class="layui-col-sm6 layer-midd-left">
							<input type="text" class="layui-input" name="user[real_name]"  value="<?php echo isset($detail['real_name']) ? htmlentities($detail['real_name']) : ''; ?>" placeholder="请输入确认昵称">
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label form-require">手机号 </label>
						<div class="layui-col-sm6 layer-midd-left">
							<input type="text" class="layui-input" name="user[phone]"  value="<?php echo isset($detail['phone']) ? htmlentities($detail['phone']) : ''; ?>" placeholder="请输入你的手机号">
						</div>
					</div>
					<div class="layui-form-item">
						<label class="layui-form-label form-require">备注 </label>
						<div class="layui-col-sm6 layer-midd-left">
							<input type="text" class="layui-input" name="user[note]" value="<?php echo isset($detail['note']) ? htmlentities($detail['note']) : ''; ?>" placeholder="">
						</div>
					</div>
					<div>
						<input type="hidden" name="user[user_id]" value="<?php echo isset($detail['user_id']) ? htmlentities($detail['user_id']) : ''; ?>">
					</div>
					<div class="layui-form-item">
						<button type="submit" class="j-submit layui-btn">提交</button>
					</div>
				</div>
			</form>
		</div>
    </div>
</div>
<script>
    $(function () {
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
