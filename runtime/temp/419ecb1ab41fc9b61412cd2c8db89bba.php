<?php /*a:2:{s:72:"/var/www/html/www.0766city.com/application/user/view/login/register.html";i:1575969815;s:64:"/var/www/html/www.0766city.com/application/user/view/layout.html";i:1574911218;}*/ ?>
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
	
        <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <title>兴发美博汇商城系统|注册</title>
    <link rel="icon" type="image/png" href="assets/user/i/favicon.ico"/>
    <link rel="stylesheet" href="assets/user/css/login/style.css"/>
    <link rel="stylesheet" href="assets/user/css/swiper.min.css"/>
</head>
<body class="page-login-v3">
<div class="container">
    <div id="wrapper" class="login-body">
        <div class="swep-left">
            <div>
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide"><img  src="/assets/user/img/login_bg.jpg"></div>
                        <div class="swiper-slide"><img  src="/assets/user/img/login_bg1.jpg"></div>
                        <div class="swiper-slide"><img  src="/assets/user/img/login_bg2.jpg"></div>
                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <div class="denl">
                <!--<p class="denl-p">登录方式</p>
                <ul>
                    <li>
                        <img src="/assets/user/img/alipay.png"/>
                        <p>	支付宝</p>
                    </li>
                    <li>
                        <img src="/assets/user/img/wxpay.png"/>
                        <p>	微信</p>
                    </li>
                    <li>
                        <img src="/assets/user/img/QQ.png"/>
                        <p>	QQ</p>
                    </li>
                </ul>-->
            </div>
        </div>
        <div class="login-content" id="login">
            <div class="brand">
                <img alt="logo" class="brand-img" src="/assets/user/img/logo.png">
                <h2 class="brand-text">兴发美博汇商城系统</h2>
            </div>
            <form id="login-form" class="login-form">
                <div class="form-group">
                    <input  name="login[user_name]" placeholder="请输入用户名" type="text" required>
                </div>
                <div class="form-group">
                    <input name="login[password]" placeholder="请输入密码" type="password" required>
                </div>
                <input type="hidden" name="login[type]" id="type" value="login"/>
                <div class="form-group" style="margin-bottom:-21px;">
                    <button id="login-submit" type="submit">
                        登录
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
<script src="assets/user/js/jquery.min.js"></script>
<script src="assets/user/js/swiper.min.js"></script>
<script src="assets/layer/layer.js"></script>
<script src="assets/user/js/jquery.form.min.js"></script>
<script>

    // 表单提交
    var $form = $('#login-form');
    $form.submit(function () {
        var $btn_submit = $('#login-submit');
        //$btn_submit.attr("disabled", true);
        $form.ajaxSubmit({
            type: "post",
            dataType: "json",
            // url: '',
            success: function (result) {
                $btn_submit.attr('disabled', false);
                if (result.code === 1) {
                    layer.msg(result.msg, {time: 1500, anim: 1}, function () {
                        window.location = result.url;
                    });
                    return true;
                }
                layer.msg(result.msg, {time: 1500, anim: 6});
            }
        });
        return false;
    });

    var swiper = new Swiper('.swiper-container', {
        loop : true,
        autoplay: {
            delay: 3000,
        },
        pagination: {
            el: '.swiper-pagination',
        },
    });



</script>
</html>

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
