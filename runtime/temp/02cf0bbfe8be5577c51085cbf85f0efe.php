<?php /*a:2:{s:68:"/var/www/html/www.0766city.com/application/user/view/agent/task.html";i:1574394516;s:64:"/var/www/html/www.0766city.com/application/user/view/layout.html";i:1574238926;}*/ ?>
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
	
        <div class="layui-container">
    <div class="layui-row">
        <div class="layui-col-md12 layui-col-xs12">
            <div class="widget-head">
                <div class="widget-title">任务审核列表</div>
            </div>
        </div>
        <div class="layui-col-md12 layui-col-xs12 widget-body ">
            <form class="layui-form"  method="post" action="<?php echo url("","",true,false);?>">
                <div class="layui-u-sm-12 layui-u-md-12 layui-col-lg12">
                    <div class="layui-form-item ">
                        <div class="layui-col-md4 layui-col-flex">
                        <label class="layui-form-label">任务状态：</label>
                        <?php echo htmlentities($gender = $request->get('gender')); ?>
                        <select class="form-control" name="status"
                                data-layer-selected="{btnSize: 'sm', placeholder: '任务状态'}">
                            <option value="-1">全部</option>
                            <!--<option value="0">待接收</option>-->
                            <option value="1">待完成</option>
                            <option value="2">待审核</option>
                            <option value="3">已完成</option>
                        </select>
                    </div>
                        <div class="layui-col-md3 laui-col-width" >
                            <button class="layui-btn" lay-submit lay-filter="formDemo">搜索</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="layui-col-md12" >
                <table class="layui-table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>推广员ID</th>
                        <th>任务</th>
                        <th>内容</th>
                        <th>奖金</th>
                        <th>状态</th>
                        <th>完成时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if((!$list->isEmpty())): foreach($list as $item): ?>
                    <tr>
                        <td><?php echo htmlentities($item['id']); ?></td>
                        <td><?php echo htmlentities($item['agent_id']); ?></td>
                        <td>任务<?php echo htmlentities($item['task_id']); ?></td>
                        <td><?php echo htmlentities($item['content']); ?></td>
                        <td><?php echo htmlentities($item['bonus']); ?></td>
                        <td>
                            <?php if(($item['status'] == 0)): ?>
                            <p><span>待接收</span></p>
                            <?php elseif(($item['status'] == 1)): ?>
                            <p><span>待完成</span></p>
                            <?php elseif(($item['status'] == 2)): ?>
                            <p><span>待审核</span></p>
                            <?php elseif(($item['status'] == 3)): ?>
                            <p><span>已完成</span></p>
                            <?php else: ?>
                            <p><span>--</span></p>
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlentities($item['update_time']); ?></td>
                        <td>
                            <?php if(($item['status'] == 2)): ?>
                            <div class="tpl-table-black-operation">
                                <a href="javascript:void(0);"
                                   class="item-pass tpl-table-black-operation-primary"
                                   data-id="<?php echo htmlentities($item['id']); ?>">
                                    <i class="mdi menu-icon mdi-pencil-lock"></i> 通过
                                </a>
                            </div>
                            <?php else: ?>
                            <p><span>--</span></p>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="12" class="layer-text-center" >暂无记录</td>
                    </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
                <div class="layui-col-md12 layui-col-xs12">
                    <div class=""><?php echo $page; ?> </div>
                    <div class="pagination-total">
                        <div class="">总记录：<?php echo htmlentities($list->total()); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    /**
     * 审核操作
     */
    $('.item-pass').click(function () {

        var id = $(this).data('id');
        var url = "<?php echo url('user/agent/pass'); ?>";
        layer.confirm('确定审核通过吗？', function (index) {
            $.post(url, {id: id}, function (result) {
                result.code === 1 ? $.show_success(result.msg, result.url)
                    : $.show_error(result.msg);
            });
            layer.close(index);
        });
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
