<?php /*a:2:{s:72:"/var/www/html/www.0766city.com/application/user/view/withdraw/index.html";i:1576657112;s:64:"/var/www/html/www.0766city.com/application/user/view/layout.html";i:1576657110;}*/ ?>
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
        <div class="layui-col-sm12 layui-col-md12 layui-col-lg12">
            <div class="widget-head">
                <div class="widget-title">推广员提现申请</div>
            </div>
            <div class="layui-col-md12 layui-col-xs12 widget-body ">
                <!-- 工具栏 -->
                <div class="page_toolbar ">
                    <form class="layui-form" method="post" action="<?php echo url("","",true,false);?>">
                        <input type="hidden" name="s" value="/<?php echo htmlentities($request->pathinfo()); ?>">
                        <input type="hidden" name="user_id" value="<?php echo htmlentities($request->get('user_id')); ?>">
                        <div class="layui-col-sm12 layui-col-md12">
                            <div class="layui">
                                <div class="layui-col-md3 layui-col-flex layui-col-one">
                                    <label class="layui-form-label">审核状态：</label>
                                    <select class="form-control" name="apply_status" data-layer-selected="{btnSize: 'sm', placeholder: '审核状态'}">
                                        <option value="-1" <?php echo $request->get('apply_status')==='-1'?'selected' : ''; ?>>全部</option>
                                        <option value="10" <?php echo $request->get('apply_status')==='10'?'selected' : ''; ?>>待审核</option>
                                        <option value="20" <?php echo $request->get('apply_status')==='20'?'selected' : ''; ?>>审核通过</option>
                                        <option value="40" <?php echo $request->get('apply_status')==='40'?'selected' : ''; ?>>已打款</option>
                                        <option value="30" <?php echo $request->get('apply_status')==='30'?'selected' : ''; ?>>驳回</option>
                                    </select>
                                </div>
                                <div class="layui-col-md3 layui-col-flex layui-col-one">
                                    <label class="layui-form-label">体现方式：</label>
                                    <select class="form-control" name="pay_type" data-layer-selected="{btnSize: 'sm', placeholder: '提现方式'}">
                                        <option value="-1" <?php echo $request->get('pay_type')=='-1'?'selected' : ''; ?>>全部</option>
                                        <option value="1" <?php echo $request->get('pay_type')=='1'?'selected' : ''; ?>>支付宝</option>
                                        <option value="2" <?php echo $request->get('pay_type')=='2'?'selected' : ''; ?>>微信</option>
                                        <option value="3" <?php echo $request->get('pay_type')=='3'?'selected' : ''; ?>>银行卡</option>
                                    </select>
                                </div>
                                <div class="layui-col-md2 layui-col-flex layui-col-one">
                                    <label class="layui-form-label">关键词：</label>
                                    <div class="layui-input-inline">
                                        <input type="text" class="layui-input" name="search" placeholder="请输入昵称" value="<?php echo htmlentities($request->get('search')); ?>">
                                    </div>
                                </div>
                                <div class=" layui-col-md2">
                                    <button class="layui-btn" lay-submit lay-filter="formDemo">搜索</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="layui-col-md12" >
                    <table width="100%" class="layui-table tpl-table-black">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>用户ID</th>
                            <th>角色</th>
                            <th>昵称</th>
                            <th>
                                <p>姓名</p>
                                <p>手机号</p>
                            </th>
                            <th>提现金额</th>
                            <th>提现方式</th>
                            <th>提现信息</th>
                            <th class="">审核状态</th>
                            <th>申请时间</th>
                            <th>审核时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(!$list->isEmpty()): foreach($list as $item): ?>
                        <tr>
                            <td><?php echo htmlentities($item['id']); ?></td>
                            <td><?php echo htmlentities($item['user_id']); ?></td>
                            <td>
                                <?php if(($item['type'] == 2)): ?>
                                <p><span>供应商</span></p>
                                <?php elseif(($item['type'] == 3)): ?>
                                <p><span>推广员</span></p>
                                <?php else: ?>
                                <p><span>--</span></p>
                                <?php endif; ?>
                            </td>
                            <td>
                                <p><span><?php echo htmlentities($item['nickName']); ?></span></p>
                            </td>
                            <td>
                                <?php if((!empty($item['real_name']) or !empty($item['phone']))): ?>
                                <p><?php echo !empty($item['real_name']) ? htmlentities($item['real_name']) : '--'; ?></p>
                                <p><?php echo !empty($item['phone']) ? htmlentities($item['phone']) : '--'; ?></p>
                                <?php else: ?>
                                <p>--</p>
                                <?php endif; ?>
                            </td>
                            <td>
                                <p><span><?php echo htmlentities($item['money']); ?></span></p>
                            </td>
                            <td>
                                <?php if(($item['pay_type'] == 1)): ?>
                                <p><span>支付宝</span></p>
                                <?php elseif(($item['pay_type'] == 2)): ?>
                                <p><span>微信</span></p>
                                <?php elseif(($item['pay_type'] == 3)): ?>
                                <p><span>银行卡</span></p>
                                <?php else: ?>
                                <p><span>--</span></p>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if(($item['pay_type'] == 1)): ?>
                                <p><span><?php echo htmlentities($item['alipay_name']); ?></span></p>
                                <p><span><?php echo htmlentities($item['alipay_account']); ?></span></p>

                                <?php elseif(($item['pay_type'] == 2)): ?>
                                <p><span><?php echo htmlentities($item['wechat_number']); ?></span></p>

                                <?php elseif(($item['pay_type'] == 3)): ?>
                                <p><span><?php echo htmlentities($item['bank_name']); ?></span></p>
                                <p><span><?php echo htmlentities($item['bank_account']); ?></span></p>
                                <p><span><?php echo htmlentities($item['bank_card']); ?></span></p>
                                <?php else: ?>
                                <p><span>--</span></p>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($item['apply_status'] == 10): ?>
                                <span class="layer-badge">待审核</span>
                                <?php elseif(($item['apply_status'] == 20)): ?>
                                <span class="layer-badge layer-badge-secondary">审核通过</span>
                                <?php elseif(($item['apply_status'] == 30)): ?>
                                <p><span class="layer-badge layer-badge-warning">已驳回</span></p>
                                <!--<span class="f-12">
											<a class="j-show-reason" href="javascript:void(0);"
                                               data-reason="<?php echo htmlentities($item['reject_reason']); ?>">
												查看原因</a>
										</span>-->
                                <?php elseif(($item['apply_status'] == 40)): ?>
                                <span class="layer-badge layer-badge-success">已打款</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlentities($item['create_time']); ?></td>
                            <?php if($item['audit_time']=="0"): ?>
                                <td class="audit_time">--</td>
                            <?php else: ?>
                                <td class="audit_time"><?php echo htmlentities(date("Y-m-d H:m:s",!is_numeric($item['audit_time'])? strtotime($item['audit_time']) : $item['audit_time'])); ?></td>
                            <?php endif; ?>
                            <td>
                                <div class="tpl-table-black-operation">
                                    <?php if(($item['apply_status'] == 10)): ?>
                                    <a class="j-money tpl-table-black-operation-green item-pass"
                                       data-id="<?php echo htmlentities($item['id']); ?>" href="javascript:void(0);">通过
                                    </a>
                                    <a class="j-money tpl-table-black-operation-del item-refuse"
                                       data-id="<?php echo htmlentities($item['id']); ?>" href="javascript:void(0);">驳回
                                    </a>
                                    <?php endif; if(($item['apply_status'] == 20)): ?>
                                    <a class="j-money tpl-table-black-operation-del item-remit"
                                       data-id="<?php echo htmlentities($item['id']); ?>" href="javascript:void(0);">确认打款
                                    </a>
                                    <?php endif; if((in_array($item['apply_status'], [30, 40]))): ?>
                                    <span>---</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr>
                            <td colspan="12" class="layer-text-center">暂无记录</td>
                        </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                    <div class="layui-col-lg12">
                        <div class=""><?php echo $list->render(); ?> </div>
                        <div class="pagination-total">
                            <div class="">总记录：<?php echo htmlentities($list->total()); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 提现审核 -->
<!--<script id="tpl-dealer-withdraw" type="text/template">
    <div class="layer-padding-top-sm">
        <form class="form-dealer-withdraw layer-form tpl-form-line-form" method="post"
              action="<?php echo url('user/withdraw'); ?>">
            <input type="hidden" name="id" value="{{ id }}">
            <div class="layer-form-group">
                <label class="layui-col-sm3 layer-form-label"> 审核状态： </label>
                <div class="layui-col-sm8">
                    <label class="layui-input-block">
                        <input type="radio" name="withdraw[apply_status]" value="20" data-layer-ucheck
                               checked> 审核通过
                    </label>
                    <label class="layui-input-block">
                        <input type="radio" name="withdraw[apply_status]" value="30" data-layer-ucheck> 驳回
                    </label>
                </div>
            </div>
            <div class="layer-form-group">
                <label class="layui-col-sm3 layer-form-label"> 驳回原因： </label>
                <div class="layui-col-sm8" style="margin-right:10px;">
                    <input type="text" class="tpl-form-input" name="withdraw[reject_reason]" placeholder="仅在驳回时填写"   value="">
                </div>
            </div>
        </form>
    </div>
</script>-->

<script>
    $(function () {
        /**
         * 审核操作
         */
        $('.item-pass').click(function () {
            var id = $(this).data('id');
            var url = "<?php echo url('user/withdraw/pass'); ?>";
            layer.confirm('确定审核通过吗？', function (index) {
                $.post(url, {id: id}, function (result) {
                    result.code === 1 ? $.show_success(result.msg, result.url)
                        : $.show_error(result.msg);
                });
                layer.close(index);
            });
        });

        /**
         * 驳回申请
         */
        $('.item-refuse').click(function () {
            var id = $(this).data('id');
            var url = "<?php echo url('user/withdraw/refuse_supplier'); ?>";
            layer.confirm('确定已打款吗？', function (index) {
                $.post(url, {id: id}, function (result) {
                    result.code === 1 ? $.show_success(result.msg, result.url)
                        : $.show_error(result.msg);
                });
                layer.close(index);
            });
        });

        /**
         * 确认打款
         */
        $('.item-remit').click(function () {
            var id = $(this).data('id');
            var url = "<?php echo url('user/withdraw/remit_supplier'); ?>";
            layer.confirm('确定已打款吗？', function (index) {
                $.post(url, {id: id}, function (result) {
                    result.code === 1 ? $.show_success(result.msg, result.url)
                        : $.show_error(result.msg);
                });
                layer.close(index);
            });
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
