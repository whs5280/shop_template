<?php /*a:2:{s:67:"/var/www/html/www.0766city.com/application/user/view/user/lock.html";i:1577669506;s:64:"/var/www/html/www.0766city.com/application/user/view/layout.html";i:1577669503;}*/ ?>
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
                    <div class="widget-title">冻结列表</div>
                </div>
                    <!-- 工具栏 -->
					<div class="layui-col-md12 layui-col-xs12 widget-body ">			
                        <form class="layui-form"  method="post" action="<?php echo url("","",true,false);?>">
                            <input type="hidden" nlayere="s" value="/<?php echo htmlentities($request->pathinfo()); ?>">
                            <div class="layui-u-sm-12 layui-u-md-12 layui-col-lg12"> 
								<div class="layui-form-item">
                                    <div class="layui-col-md4 layui-col-flex">
                                        <label class="layui-form-label">行业：</label>
                                        <?php echo htmlentities($industry = $request->get('industry')); ?>
                                        <select class="form-control" name="industry"
                                                data-layer-selected="{btnSize: 'sm', placeholder: '行业'}">
                                            <?php foreach($industry_list as $item): ?>
                                            <option value="<?php echo htmlentities($item['id']); ?>"><?php echo htmlentities($item['name']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
									<div class="layui-col-md3">
										<label class="layui-form-label">昵称：</label>
										<div class="layui-input-inline">
											<input name="nickName" type="text"  class="layui-input" placeholder="请输入昵称" value="<?php echo htmlentities($request->get('nickName')); ?>">
										</div>
									</div>
									<div class="layui-col-md4 laui-col-width" >
										<button class="layui-btn" lay-submit lay-filter="formDemo">搜索</button>
									</div>  
								</div>	
                            </div>
                        </form>
                   
                <div class="layui-col-md12" >
                        <table width="100%" class="layui-table">
                            <thead>
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>头像</th>
                                <th>昵称</th>
                                <th>性别</th>
                                <th>经营行业</th>
                                <!--<th>上级</th>-->
                                <th>消费</th>
                                <!--<th>余额</th>-->
                                <th>积分</th>
                                <th>VIP</th>
                                <th>注册时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            </thead>
                            <tbody>
                            <?php if((!$list->isEmpty())): foreach($list as $item): ?>
                                <tr>
                                    <td><?php echo htmlentities($item['user_id']); ?></td>
                                    <td>
                                        <a href="/uploads/<?php echo htmlentities($item['avatarUrl']); ?>" title="点击查看大图" target="_blank">
                                            <img src="/uploads/<?php echo htmlentities($item['avatarUrl']); ?>" width="50" height="50" alt="">
                                        </a>
                                    </td>
                                    <td><?php echo htmlentities($item['nickName']); ?></td>
                                    <td><?php echo htmlentities($item['gender']); ?></td>
                                    <td><?php echo htmlentities(industry($item['industry'])); ?></td>
                                    <!--<td><?php echo !empty($item['users']['nickName']) ? htmlentities($item['users']['nickName']) : '无'; ?></td>-->
                                    <td><?php echo htmlentities($item['shop_money']); ?></td>
                                    <!--<td><?php echo htmlentities($item['money']); ?></td>-->
                                    <td><?php echo htmlentities($item['integral']); ?></td>
                                    <td><?php echo htmlentities(is_vip($item['is_vip'])); ?></td>
                                    <td><?php echo htmlentities($item['create_time']); ?></td>
                                    <td>
                                        <div class="tpl-table-black-operation">
											<a class="tpl-table-black-operation-primary uefreezing" href="javascript:void(0);"
                                               class="tpl-table-black-operation-del"
                                               data-id="<?php echo htmlentities($item['user_id']); ?>">
                                                <i class="mdi menu-icon mdi-pencil-lock"></i> 解除冻结
                                            </a>
											<!-- <a href="javascript:void(0);"
                                               class="item-delete tpl-table-black-operation-del"
                                               data-id="<?php echo htmlentities($item['user_id']); ?>">
                                                <i class="mdi menu-icon mdi-delete-forever"></i> 删除
                                            </a>-->
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="10" class="layer-text-center">暂无记录</td>
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
</div>
<script>
    $(function () {
        // 删除元素
        /*var url = "index.php?s=/user/user/remove";
        $('.item-delete').delete('user_id', url, '删除后不可恢复，确定要删除吗？');*/

		var url="index.php?s=/user/user/uefreezing";
		$(".uefreezing").delete('user_id', url, '确定要解冻吗？');
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
