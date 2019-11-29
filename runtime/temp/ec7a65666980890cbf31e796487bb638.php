<?php /*a:5:{s:66:"/var/www/html/www.0766city.com/application/user/view/tpl/edit.html";i:1556090954;s:64:"/var/www/html/www.0766city.com/application/user/view/layout.html";i:1556090954;s:88:"/var/www/html/www.0766city.com/application/user/view/layouts/_template/file_library.html";i:1556090954;s:74:"/var/www/html/www.0766city.com/application/user/view/app/page/tpl/diy.html";i:1555411922;s:77:"/var/www/html/www.0766city.com/application/user/view/app/page/tpl/editor.html";i:1556092146;}*/ ?>
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
	
        <link rel="stylesheet" href="assets/user/css/diy.css">
<link rel="stylesheet" href="assets/user/css/ystep.css">
<link rel="stylesheet" href="assets/user/css/member.css">
	<link rel="stylesheet" href="assets/user/css/tpl.css"/>
<div class="layui-container ">
    <div class="layui-row">
        <div class="layui-col-sm12 layui-col-md12 layui-col-lg12">
			<div class="widget-head">
				<div class="widget-title">编辑页面设计</div>
			</div>
			<div class="widget-body layui-col-sm12 layui-col-md12 layui-col-lg12">
				<!-- diy 工作区 -->
				<div class="work-diy dis-flex flex-x-between">
					<!-- 工具栏 -->
					<div id="diy-menu" class="diy-menu">
						<div class="menu-title"><span>组件库</span></div>
						<div class="navs">
							<div class="navs-group">
								<div class="title">媒体组件</div>
								<div class="navs-components">
									<nav class="special" data-type="banner">
										<p class="item-icon"><i class="mdi menu-icon mdi-size mdi-image-multiple"></i></p>
										<p>图片轮播</p>
									</nav>
									<nav class="special" data-type="imageSingle">
										<p class="item-icon"><i class="mdi menu-icon mdi-size mdi-image"></i></p>
										<p>单图组</p>
									</nav>
									<nav class="special" data-type="window">
										<p class="item-icon"><i class="mdi menu-icon mdi-size mdi-newspaper"></i></p>
										<p>图片橱窗</p>
									</nav>
									<nav class="special" data-type="video">
										<p class="item-icon"><i class="mdi menu-icon mdi-size mdi-video"></i></p>
										<p>视频组</p>
									</nav>
								</div>
								<div class="title">商城组件</div>
								<div class="navs-components">
									<nav class="special" data-type="search">
										<p class="item-icon"><i class="mdi menu-icon mdi-size mdi-search-web"></i></p>
										<p>搜索框</p>
									</nav>
									<nav class="special" data-type="notice">
										<p class="item-icon"><i class="mdi menu-icon mdi-size mdi-volume-high"></i></p>
										<p>公告组</p>
									</nav>
									<nav class="special" data-type="navBar">
										<p class="item-icon"><i class="mdi menu-icon mdi-size mdi-apps"></i></p>
										<p>导航组</p>
									</nav>
									<nav class="special" data-type="goods">
										<p class="item-icon"><i class="mdi menu-icon mdi-size mdi-shopping"></i></p>
										<p>商品组</p>
									</nav>
									<nav class="special" data-type="coupon">
										<p class="item-icon"><i class="mdi menu-icon mdi-size mdi-ticket-percent"></i></p>
										<p>优惠券组</p>
									</nav>
								  
								</div>
								<div class="title">工具组件</div>
								<div class="navs-components">
									<nav class="special" data-type="blank">
										<p class="item-icon"><i class="mdi menu-icon mdi-size mdi-selection"></i></p>
										<p>辅助空白</p>
									</nav>
									<nav class="special" data-type="guide">
										<p class="item-icon"><i class="mdi menu-icon mdi-size mdi-minus"></i></p>
										<p>辅助线</p>
									</nav>
									<nav class="special" data-type="richText">
										<p class="item-icon"><i class="mdi menu-icon mdi-size mdi-clipboard-text"></i></p>
										<p>富文本</p>
									</nav>
								</div>
								
							</div>
						</div>
						<div class="action">
							<button id="submit" type="button" class="layui-btn">
								保存页面
							</button>
						</div>
					</div>
					<!--手机diy容器-->
					<div class="diy-phone">
						<!-- 手机顶部标题 -->
						<div id="diy-page" class="phone-top optional __no-move" data-type="page"></div>
						<!-- 小程序内容区域 -->
						<div id="phone-main" class="phone-main layer-scrollable-vertical"></div>
					</div>
					<!-- 编辑器容器 -->
					<div id="diy-editor" class="diy-editor form-horizontal">
						<div class="inner"></div>
					</div>
				</div>
				<!-- 提示 -->
				<div class="tips">
					<div class="pre">
						<p>1. 设计完成后点击"保存页面"，在小程序端页面下拉刷新即可看到效果。</p>
						<p>2. 如需填写链接地址请参考<a href="<?php echo url('tpl/links'); ?>" target="_blank">页面链接</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

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


<!--diy元素-->
<!-- diy元素: page -->
<script id="tpl_diy_page" type="text/template">
    <div id="diy-{{ id }}" class="phone-top optional __no-move" data-itemid="page"
         style="background: {{ style.titleBackgroundColor }} url('assets/user/img/diy/phone-top-{{ style.titleTextColor }}.png') no-repeat center / contain;">
        <h4 style="color: {{ style.titleTextColor }};">{{ params.title }}</h4>
    </div>
</script>

<!-- diy元素: 搜索栏 -->
<script id="tpl_diy_search" type="text/template">
    <div class="drag optional" id="diy-{{ id }}" data-itemid="{{ id }}">
        <div class="diy-search">
            <div class="inner left {{ style.searchStyle }}" style="background: {{ style.inputBackground }};">
                <div class="search-input" style="text-align: {{ style.textAlign }}; color: {{ style.inputColor }};">
                    <i class="search-icon iconfont icon-ss-search"></i>
                    <span>{{ params.placeholder }}</span>
                </div>
            </div>
        </div>
        <div class="btn-edit-del">
            <div class="btn-del">删除</div>
        </div>
    </div>
</script>

<!-- diy元素: banner -->
<script id="tpl_diy_banner" type="text/template">
    <div class="drag optional" id="diy-{{ id }}" data-itemid="{{ id }}">
        <div class="diy-banner">
            {{each data}}
            <img src="{{ $value.imgUrl }}">
            {{/each}}
            <div class="dots center {{ style.btnShape }}">
                {{each data}}
                <span style="background: {{ style.btnColor }};"></span>
                {{/each}}
            </div>
        </div>
        <div class="btn-edit-del">
            <div class="btn-del">删除</div>
        </div>
    </div>
</script>

<!-- diy元素: 单图组 -->
<script id="tpl_diy_imageSingle" type="text/template">
    <div class="drag optional" id="diy-{{ id }}" data-itemid="{{ id }}">
        <div class="diy-imageSingle"
             style="padding-bottom: {{ style.paddingTop }}px; background: {{ style.background }};">
            {{each data}}
            <div class="item-image" style="padding: {{ style.paddingTop }}px {{ style.paddingLeft }}px 0;">
                <img src="{{ $value.imgUrl }}">
            </div>
            {{/each}}
        </div>
        <div class="btn-edit-del">
            <div class="btn-del">删除</div>
        </div>
    </div>
</script>

<!-- diy元素: 导航组 -->
<script id="tpl_diy_navBar" type="text/template">
    <div class="drag optional" id="diy-{{ id }}" data-itemid="{{ id }}">
        <div class="diy-navBar" style="background: {{ style.background }};">
            <ul class="layer-avg-sm-{{ style.rowsNum }}">
                {{each data}}
                <li class="">
                    <div class="item-image">
                        <img src="{{ $value.imgUrl }}">
                    </div>
                    <p class="item-text layer-text-truncate" style="color: {{ $value.color }};">{{ $value.text }}</p>
                </li>
                {{/each}}
            </ul>
        </div>
        <div class="btn-edit-del">
            <div class="btn-del">删除</div>
        </div>
    </div>
</script>

<!-- diy元素: 辅助空白 -->
<script id="tpl_diy_blank" type="text/template">
    <div class="drag optional" id="diy-{{ id }}" data-itemid="{{ id }}">
        <div class="diy-blank" style="height: {{ style.height }}px; background: {{ style.background }};">
        </div>
        <div class="btn-edit-del">
            <div class="btn-del">删除</div>
        </div>
    </div>
</script>

<!-- diy元素: 辅助线 -->
<script id="tpl_diy_guide" type="text/template">
    <div class="drag optional" id="diy-{{ id }}" data-itemid="{{ id }}">
        <div class="diy-guide" style="padding: {{ style.paddingTop }}px 0; background: {{ style.background }};">
            <p class="line" style="border-top: {{ style.lineHeight }}px {{ style.lineStyle }} {{ style.lineColor }};">
            </p>
        </div>
        <div class="btn-edit-del">
            <div class="btn-del">删除</div>
        </div>
    </div>
</script>

<!-- diy元素: 视频组 -->
<script id="tpl_diy_video" type="text/template">
    <div class="drag optional" id="diy-{{ id }}" data-itemid="{{ id }}">
        <div class="diy-video" style="padding: {{ style.paddingTop }}px 0;">
            <video style="height: {{ style.height }}px;" src="{{ params.videoUrl }}" poster="{{ params.poster }}"
                   controls>
                您的浏览器不支持 video 标签
            </video>
        </div>
        <div class="btn-edit-del">
            <div class="btn-del">删除</div>
        </div>
    </div>
</script>

<!-- diy元素: 图片橱窗 -->
<script id="tpl_diy_window" type="text/template">
    <div class="drag optional __z10" id="diy-{{ id }}" data-itemid="{{ id }}">
        <div class="diy-window"
             style="background: {{ style.background }}; padding: {{ style.paddingTop }}px {{ style.paddingLeft }}px;">
            {{ if style.layout > -1 }}
            <ul class="data-list layer-avg-sm-{{ style.layout }}">
                {{ each data }}
                <li style="padding: {{ style.paddingTop }}px {{ style.paddingLeft }}px;">
                    <div class="item-image">
                        <img src="{{ $value.imgUrl }}">
                    </div>
                </li>
                {{ /each }}
            </ul>
            {{ else }}
            {{ set keys = objectKeys(data) }}
            <div class="display">
                <div class="display-left" style="padding: {{ style.paddingTop }}px {{ style.paddingLeft }}px;">
                    <img src="{{ data[keys[0]].imgUrl }}">
                </div>
                {{ if dataNum == 2 }}
                <div class="display-right" style="padding: {{ style.paddingTop }}px {{ style.paddingLeft }}px;">
                    <img src="{{ data[keys[1]].imgUrl }}">
                </div>
                {{ /if }}
                {{ if dataNum == 3 }}
                <div class="display-right">
                    <div class="display-right1" style="padding: {{ style.paddingTop }}px {{ style.paddingLeft }}px;">
                        <img src="{{ data[keys[1]].imgUrl }}">
                    </div>
                    <div class="display-right2" style="padding: {{ style.paddingTop }}px {{ style.paddingLeft }}px;">
                        <img src="{{ data[keys[2]].imgUrl }}">
                    </div>
                </div>
                {{ /if }}
                {{ if dataNum == 4 }}
                <div class="display-right">
                    <div class="display-right1" style="padding: {{ style.paddingTop }}px {{ style.paddingLeft }}px;">
                        <img src="{{ data[keys[1]].imgUrl }}">
                    </div>
                    <div class="display-right2">
                        <div class="left" style="padding: {{ style.paddingTop }}px {{ style.paddingLeft }}px;">
                            <img src="{{ data[keys[2]].imgUrl }}">
                        </div>
                        <div class="right" style="padding: {{ style.paddingTop }}px {{ style.paddingLeft }}px;">
                            <img src="{{ data[keys[3]].imgUrl }}">
                        </div>
                    </div>
                </div>
                {{ /if }}
            </div>
            {{ /if }}
        </div>
        <div class="btn-edit-del">
            <div class="btn-del">删除</div>
        </div>
    </div>
</script>

<!-- diy元素: 商品组 -->
<script id="tpl_diy_goods" type="text/template">
    <div class="drag optional" id="diy-{{ id }}" data-itemid="{{ id }}">
        <div class="diy-goods" style="background: {{ style.background }};">
            <ul class="goods-list display__{{ style.display }} column__{{ style.column }} layer-cf">
                {{ each params.source === 'choice' ? data : defaultData }}
				
				     {{ if  style.display === 'list' }}
                       <li class="goods-item" style="width:100%">
					   {{ else }}
					   <li class="goods-item" >
                        {{ /if }}
               
                    <div class="goods-image">
                        <img src="{{ $value.image }}">
                    </div>
                    <div class="detail">
                        {{ if style.show.goodsName === '1' }}
                        <p class="goods-name">
                            {{ $value.name }}
                        </p>
                        {{ /if }}
                        {{ if style.show.goodsPrice === '1' }}
                        <p class="goods-price x-color-red">
                            ￥{{ $value.goods_price }}
                        </p>
                        {{ /if }}
                    </div>
                </li>
                {{ /each }}
            </ul>
        </div>
        <div class="btn-edit-del">
            <div class="btn-del">删除</div>
        </div>
    </div>
</script>

<!-- diy元素: 拼团 -->
<script id="tpl_diy_assemble" type="text/template">
  <div class="drag optional" id="diy-{{ id }}" data-itemid="{{ id }}">
        <div class="diy-goods" style="background: {{ style.background }};">
			<div class="diy-imageSingle"
					style="padding-bottom: {{ style.paddingTop }}px; background: {{ style.background }};">
				{{each defaulta}}
					<div class="item-image" style="padding: {{ style.paddingTop }}px {{ style.paddingLeft }}px 0;">
						<img src="{{ $value.imgUrl }}">
					</div>
				{{/each}}
			 </div>
            <ul class="goods-list display__{{ style.display }} column__{{ style.column }} layer-cf shell-group">
                {{ each params.source === 'choice' ? data : defaultData }}
					<li class="goods-items">
						<div class="goods-image">
							<img src="{{ $value.image }}">
						</div>
						<div class="detail">
							<div class="goods-name">
								{{ $value.name }}
							</div>
							<div class="good-shell">
								<div class="good-shell-le">
									<div class="good-shell-le-s">￥<strong>{{ $value.discount }}</strong><span>2人团</span></div>
									<div class="good-shell-le-o">单买价￥<span>{{ $value.goods_price }}</span></div>
								</div>
								<div class="good-shell-ri">
									<span>去拼团</span>
								</div>
							</div>
						</div>
					</li>
                {{ /each }}
            </ul>
        </div>
        <div class="btn-edit-del">
            <div class="btn-del">删除</div>
        </div>
    </div>

</script>

<!-- diy元素: 秒杀 -->
<script id="tpl_diy_spike" type="text/template">
   <div class="drag optional" id="diy-{{ id }}" data-itemid="{{ id }}">
        <div class="diy-goods" style="background: {{ style.background }};">
			<div class="diy-imageSingle"
					style="padding-bottom: {{ style.paddingTop }}px; background: {{ style.background }};">
				{{each defaulta}}
					<div class="item-image" style="padding: {{ style.paddingTop }}px {{ style.paddingLeft }}px 0;">
						<img src="{{ $value.imgUrl }}">
					</div>
				{{/each}}
			 </div>
            <ul class="goods-list display__{{ style.display }} column__{{ style.column }} layer-cf shell-group">
                {{ each params.source === 'choice' ? data : defaultData }}
                <li class="goods-items">
                    <div class="goods-image">
                        <img src="{{ $value.image }}">
                    </div>
						<div class="detail">
							<div class="goods-name">
								{{ $value.name }}
							</div>
							<div class="good-shell">
								<div class="good-shell-le ms-le">
									<div class="good-shell-le-s">￥<strong>{{ $value.discount }}</strong></div>
									<div class="good-shell-le-o"><s>￥{{ $value.goods_price}}</s></div>
								</div>
								<div class="good-shell-ri ms-ri">
									<span>立即秒杀</span>
								</div>
							</div>
						</div>
                </li>
                {{ /each }}
            </ul>
        </div>
        <div class="btn-edit-del">
            <div class="btn-del">删除</div>
        </div>
    </div>

</script>

<!-- diy元素: 抢购 -->
<script id="tpl_diy_robbuy" type="text/template">
  <div class="drag optional" id="diy-{{ id }}" data-itemid="{{ id }}">
        <div class="diy-goods" style="background: {{ style.background }};">
			<div class="diy-imageSingle"
					style="padding-bottom: {{ style.paddingTop }}px; background: {{ style.background }};">
				{{each defaulta}}
					<div class="item-image" style="padding: {{ style.paddingTop }}px {{ style.paddingLeft }}px 0;">
						<img src="{{ $value.imgUrl }}">
					</div>
				{{/each}}
			 </div>
            <ul class="goods-list display__{{ style.display }} column__{{ style.column }} layer-cf">
                {{ each params.source === 'choice' ? data : defaultData }}
                <li class="goods-item">
                    <div class="goods-image">
                        <img src="{{ $value.image }}">
						<div
						{{ if params.backtype === 'image' }}
							 class="yh-buy-hi" style="background:url({{params.backgroundimg}}); background-size:100% 100%;"
						{{ else }}
							{{ if params.textAlign === 'radius' }}
								class="yh-p-goods-ct" 
							{{ else if params.textAlign === 'eight' }}
							class="yh-p-goods-ms yh-p-goods-8" style="background: {{ params.background }}"
							{{ else if params.textAlign === 'twelve' }}
							class="yh-p-goods-ms yh-p-goods-12" style="background: {{ params.background }}"
							{{ else if params.textAlign === 'love' }}
							class="yh-p-goods-ms yh-p-goods-love" 
							{{ /if }}
						{{ /if }}
						>
							<i class="before" style="background: {{ params.background }}"></i>
							<span>{{ params.title }}</span>
							<i class="after" style="background: {{ params.background }}"></i>
						</div>
                    </div>
                    <div class="detail">
                        <p class="goods-name">
                            {{ $value.name }}
                        </p>
                    </div>
                </li>
                {{ /each }}
            </ul>
        </div>
        <div class="btn-edit-del">
            <div class="btn-del">删除</div>
        </div>
    </div>

</script>
<!-- diy元素: 商品促销 -->
<script id="tpl_diy_promgoods" type="text/template">
	<div class="drag optional" id="diy-{{ id }}" data-itemid="{{ id }}">
        <div class="diy-goods" style="background: {{ style.background }};">
			<div class="diy-imageSingle"
					style="padding-bottom: {{ style.paddingTop }}px; background: {{ style.background }};">
				{{each defaulta}}
					<div class="item-image" style="padding: {{ style.paddingTop }}px {{ style.paddingLeft }}px 0;">
						<img src="{{ $value.imgUrl }}">
					</div>
				{{/each}}
			 </div>
            <ul class="goods-list display__{{ style.display }} column__{{ style.column }} layer-cf">
                {{ each params.source === 'choice' ? data : defaultData }}
                <li class="goods-item">
                    <div class="goods-image">
                        <img src="{{ $value.image }}">
						<div
						{{ if params.backtype === 'image' }}
							 class="yh-buy-hi" style="background:url({{params.backgroundimg}}); background-size:100% 100%;"
						{{ else }}
							{{ if params.textAlign === 'radius' }}
								class="yh-p-goods-ct" 
							{{ else if params.textAlign === 'eight' }}
							class="yh-p-goods-ms yh-p-goods-8" style="background: {{ params.background }}"
							{{ else if params.textAlign === 'twelve' }}
							class="yh-p-goods-ms yh-p-goods-12" style="background: {{ params.background }}"
							{{ else if params.textAlign === 'love' }}
							class="yh-p-goods-ms yh-p-goods-love" 
							{{ /if }}
						{{ /if }}
						>
							<i class="before" style="background: {{ params.background }}"></i>
							<span>{{ params.title }}</span>
							<i class="after" style="background: {{ params.background }}"></i>
						</div>
                    </div>
                    <div class="detail">
                        <p class="goods-name">
                            {{ $value.name }}
                        </p>
                    </div>
                </li>
                {{ /each }}
            </ul>
        </div>
        <div class="btn-edit-del">
            <div class="btn-del">删除</div>
        </div>
    </div>
</script>
<!-- diy元素: 签到 -->
<script id="tpl_diy_signin" type="text/template">
  <div class="drag optional" id="diy-{{ id }}" data-itemid="{{ id }}">
        <div class="diy-signin" style="
			{{ if params.source == 'auto' }}
				background:{{ style.background }}
			{{ else }} 
				background-image:url({{ style.backgroundimage}})
			{{ /if }}">
			<div class="diy-imageSingle"style="padding-bottom: {{ style.paddingTop }}px;">
				<div class="ystep-container ystep-lg ystep-blue">
						<ul class="ystep-container-steps">
						{{each defaulta}}
							<li class="{{ $value.class }}" style="color:{{ $value.color}}">{{ $value.title }} <i class="ystep-step-done" style="background:{{ $value.color}}"></i></li>
						{{/each}}
						</ul>
						<div class="ystep-progress">
							<p class="ystep-progress-bar" style="width:261px;">
								<span class="ystep-progress-highlight"></span>
							</p>
						</div>
				</div>
									
			</div>
			<div>
				<div class="diy-sig" style="background:{{ params.background }};">
			
					<span style="color: {{ params.color }};">{{ params.title }}</span>
				
				</div>
			</div>
        </div>
        <div class="btn-edit-del">
            <div class="btn-del">删除</div>
        </div>
    </div> 
</script>
<!-- diy元素: 优惠券组 -->
<script id="tpl_diy_coupon" type="text/template">
    <div class="drag optional __z10" id="diy-{{ id }}" data-itemid="{{ id }}">
        <div class="diy-coupon dis-flex flex-x-around"
             style="background: {{ style.background }}; padding: {{ style.paddingTop }}px 0;">
            {{each data}}
            <div class="coupon-wrapper">
                <div class="coupon-item">
                    <i class="before" style="background: {{ style.background }};"></i>
                    <div class="left-content color__{{ $value.color }} dis-flex flex-dir-column flex-x-center flex-y-center">
                        <div class="content-top">
                            <span class="unit">￥</span>
                            <span class="price">{{ $value.reduce_price }}</span>
                        </div>
                        <div class="content-bottom">
                            <span>满{{ $value.min_price }}元可用</span>
                        </div>
                    </div>
                    <div class="right-receive dis-flex flex-dir-column flex-x-center flex-y-center">
                        <span>立即</span>
                        <span>领取</span>
                    </div>
                </div>
            </div>
            {{/each}}
        </div>
        <div class="btn-edit-del">
            <div class="btn-del">删除</div>
        </div>
    </div>
</script>

<!-- diy元素: 公告组 -->
<script id="tpl_diy_notice" type="text/template">
    <div class="drag optional" id="diy-{{ id }}" data-itemid="{{ id }}">
        <div class="diy-notice dis-flex"
             style="background: {{ style.background }}; padding: {{ style.paddingTop }}px 10px;">
            <div class="notice__icon">
                <img src="{{ params.icon }}">
            </div>
            <div class="notice__text flex-box layer-text-truncate">
                <span style="color: {{ style.textColor }};">{{ params.text }}</span>
            </div>
        </div>
        <div class="btn-edit-del">
            <div class="btn-del">删除</div>
        </div>
    </div>
</script>

<!-- diy元素: 富文本 -->
<script id="tpl_diy_richText" type="text/template">
    <div class="drag optional" id="diy-{{ id }}" data-itemid="{{ id }}">
        <div class="diy-richText"
             style="background: {{ style.background }}; padding: {{ style.paddingTop }}px {{ style.paddingLeft }}px;">
            {{ params.content }}
        </div>
        <div class="btn-edit-del">
            <div class="btn-del">删除</div>
        </div>
    </div>
</script>

<!--编辑器: 搜索栏-->
<!--编辑器: page-->
<script id="tpl_editor_page" type="text/template">
    <div class="editor-title"><span>{{ name }}</span></div>
    <form class="layer-form tpl-form-line-form" data-itemid="{{ id }}">
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">页面名称 </label>
            <div class="layui-col-sm9 layer-u-end">
                <input class="tpl-form-input" type="text" name="name"
                       data-bind="params.name" value="{{ params.name }}">
                <div class="help-block layer-margin-top-xs">
                    <small>页面名称仅用于后台查找</small>
                </div>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">页面标题 </label>
            <div class="layui-col-sm9 layer-u-end">
                <input class="tpl-form-input" type="text" name="title"
                       data-bind="params.title" value="{{ params.title }}">
                <div class="help-block layer-margin-top-xs">
                    <small>小程序端顶部显示的标题</small>
                </div>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">分享标题 </label>
            <div class="layui-col-sm9 layer-u-end">
                <input class="tpl-form-input" type="text" name="share_title"
                       data-bind="params.share_title" value="{{ params.share_title }}">
                <div class="help-block layer-margin-top-xs">
                    <small>小程序端转发时显示的标题</small>
                </div>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">标题栏文字 </label>
            <div class="layui-col-sm9 layer-u-end">
                <label class="layer-radio-inline">
                    <input data-bind="style.titleTextColor" type="radio" name="titleTextColor"
                           value="black" {{ style.titleTextColor=== 'black' ? 'checked' : '' }}> 黑色
                </label>
                <label class="layer-radio-inline">
                    <input data-bind="style.titleTextColor" type="radio" name="titleTextColor"
                           value="white" {{ style.titleTextColor=== 'white' ? 'checked' : '' }}> 白色
                </label>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">标题栏背景 </label>
            <div class="layui-col-sm9 layer-u-end">
                <input class="" type="color" name="titleBackgroundColor"
                       data-bind="style.titleBackgroundColor" value="{{ style.titleBackgroundColor }}">
                <button type="button" class="btn-resetColor layui-btn layui-btn-xs" data-color="#ffffff">
                    重置
                </button>
            </div>
        </div>
    </form>
</script>

<!--编辑器: 搜索-->
<script id="tpl_editor_search" type="text/template">
    {{ if name }}
    <div class="editor-title"><span>{{ name }}</span></div>
    {{ /if }}
    <form class="layer-form tpl-form-line-form" data-itemid="{{ id }}">
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">提示文字 </label>
            <div class="layui-col-sm9 layer-u-end">
                <input class="tpl-form-input" type="text" name="searchStyle"
                       data-bind="params.placeholder" value="{{ params.placeholder }}">
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">搜索框样式 </label>
            <div class="layui-col-sm9 layer-u-end">
                <label class="layer-radio-inline">
                    <input data-bind="style.searchStyle" type="radio" name="searchStyle"
                           value="" {{ style.searchStyle=== '' ? 'checked' : '' }}> 方形
                </label>
                <label class="layer-radio-inline">
                    <input data-bind="style.searchStyle" type="radio" name="searchStyle"
                           value="radius" {{ style.searchStyle=== 'radius' ? 'checked' : '' }}> 圆角
                </label>
                <label class="layer-radio-inline">
                    <input data-bind="style.searchStyle" type="radio" name="searchStyle"
                           value="round" {{ style.searchStyle=== 'round' ? 'checked' : '' }}> 圆弧
                </label>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">文字对齐 </label>
            <div class="layui-col-sm9 layer-u-end">
                <label class="layer-radio-inline">
                    <input data-bind="style.textAlign" type="radio" name="textAlign"
                           value="left" {{ style.textAlign=== 'left' ? 'checked' : '' }}>
                    居左
                </label>
                <label class="layer-radio-inline">
                    <input data-bind="style.textAlign" type="radio" name="textAlign"
                           value="center" {{ style.textAlign=== 'center' ? 'checked' : '' }}>
                    居中
                </label>
                <label class="layer-radio-inline">
                    <input data-bind="style.textAlign" type="radio" name="textAlign"
                           value="right" {{ style.textAlign=== 'right' ? 'checked' : '' }}>
                    居右
                </label>
            </div>
        </div>
    </form>
</script>

<!--编辑器: banner-->
<script id="tpl_editor_banner" type="text/template">
    {{ if name }}
    <div class="editor-title"><span>{{ name }}</span></div>
    {{ /if }}
    <form class="layer-form tpl-form-line-form" data-itemid="{{ id }}">
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">指示点形状 </label>
            <div class="layui-col-sm9 layer-u-end">
                <label class="layer-radio-inline">
                    <input data-bind="style.btnShape" type="radio" name="searchStyle"
                           value="rectangle" {{ style.btnShape=== 'rectangle' ? 'checked' : '' }}> 长方形
                </label>
                <label class="layer-radio-inline">
                    <input data-bind="style.btnShape" type="radio" name="searchStyle"
                           value="square" {{ style.btnShape=== 'square' ? 'checked' : '' }}> 正方形
                </label>
                <label class="layer-radio-inline">
                    <input data-bind="style.btnShape" type="radio" name="searchStyle"
                           value="round" {{ style.btnShape=== 'round' ? 'checked' : '' }}> 圆形
                </label>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">指示点颜色 </label>
            <div class="layui-col-sm9 layer-u-end">
                <input class="" type="color" name="btnColor"
                       data-bind="style.btnColor" value="{{ style.btnColor }}">
                <button type="button" class="btn-resetColor layui-btn layui-btn-xs" data-color="#ffffff">
                    重置
                </button>
            </div>
        </div>
        <div class="form-items">
            {{ include 'tpl_editor_data_item_image' data }}
        </div>
        <div class="j-data-add form-item-add">
            <i class="fa fa-plus"></i> 添加一个
        </div>
    </form>
</script>

<!--编辑器: 单图组-->
<script id="tpl_editor_imageSingle" type="text/template">
    <div class="editor-title"><span>{{ name }}</span></div>
    <form class="layer-form tpl-form-line-form" data-itemid="{{ id }}">
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">上下边距 </label>
            <div class="layui-col-sm9 layer-u-end">
                <input class="tpl-form-input" type="range" name="paddingTop" data-bind="style.paddingTop"
                       value="{{ style.paddingTop }}" min="0" max="50">
                <div class="display-value">
                    <span class="value">{{ style.paddingTop }}</span>px (像素)
                </div>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">左右边距 </label>
            <div class="layui-col-sm9 layer-u-end">
                <input class="tpl-form-input" type="range" name="paddingLeft" data-bind="style.paddingLeft"
                       value="{{ style.paddingTop }}" min="0" max="50">
                <div class="display-value">
                    <span class="value">{{ style.paddingLeft }}</span>px (像素)
                </div>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">背景颜色 </label>
            <div class="layui-col-sm9 layer-u-end">
                <input class="" type="color" name="background"
                       data-bind="style.background" value="{{ style.background }}">
                <button type="button" class="btn-resetColor layui-btn layui-btn-xs" data-color="#ffffff">
                    重置
                </button>
            </div>
        </div>
        <div class="form-items">
            {{ include 'tpl_editor_data_item_image' data }}
        </div>
        <div class="j-data-add form-item-add">
            <i class="fa fa-plus"></i> 添加一个
        </div>
    </form>
</script>

<!--编辑器: 导航组-->
<script id="tpl_editor_navBar" type="text/template">
    <div class="editor-title"><span>{{ name }}</span></div>
    <form class="layer-form tpl-form-line-form" data-itemid="{{ id }}">
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">背景颜色 </label>
            <div class="layui-col-sm9 layer-u-end">
                <input class="" type="color" name="background"
                       data-bind="style.background" value="{{ style.background }}">
                <button type="button" class="btn-resetColor layui-btn layui-btn-xs" data-color="#ffffff">
                    重置
                </button>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">每行数量 </label>
            <div class="layui-col-sm9 layer-u-end">
                <label class="layer-radio-inline">
                    <input data-bind="style.rowsNum" type="radio" name="rowsNum"
                           value="3" {{ style.rowsNum=== '3' ? 'checked' : '' }}> 3个
                </label>
                <label class="layer-radio-inline">
                    <input data-bind="style.rowsNum" type="radio" name="rowsNum"
                           value="4" {{ style.rowsNum=== '4' ? 'checked' : '' }}> 4个
                </label>
                <label class="layer-radio-inline">
                    <input data-bind="style.rowsNum" type="radio" name="rowsNum"
                           value="5" {{ style.rowsNum=== '5' ? 'checked' : '' }}> 5个
                </label>
            </div>
        </div>
        <div class="form-items">
            {{ include 'tpl_editor_data_item_navBar' data }}
        </div>
        <div class="j-data-add form-item-add">
            <i class="fa fa-plus"></i> 添加一个
        </div>
    </form>
</script>

<!--编辑器: 辅助空白-->
<script id="tpl_editor_blank" type="text/template">
    <div class="editor-title"><span>{{ name }}</span></div>
    <form class="layer-form tpl-form-line-form" data-itemid="{{ id }}">
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">背景颜色 </label>
            <div class="layui-col-sm9 layer-u-end">
                <input class="" type="color" name="background"
                       data-bind="style.background" value="{{ style.background }}">
                <button type="button" class="btn-resetColor layui-btn layui-btn-xs" data-color="#ffffff">
                    重置
                </button>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">组件高度 </label>
            <div class="layui-col-sm9 layer-u-end">
                <input class="tpl-form-input" type="range" name="height" data-bind="style.height"
                       value="{{ style.height }}" min="1" max="200">
                <div class="display-value">
                    <span class="value">{{ style.height }}</span>px (像素)
                </div>
            </div>
        </div>
    </form>
</script>

<!--编辑器: 辅助线-->
<script id="tpl_editor_guide" type="text/template">
    <div class="editor-title"><span>{{ name }}</span></div>
    <form class="layer-form tpl-form-line-form" data-itemid="{{ id }}">
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">背景颜色 </label>
            <div class="layui-col-sm9 layer-u-end">
                <input class="" type="color" name="background"
                       data-bind="style.background" value="{{ style.background }}">
                <button type="button" class="btn-resetColor layui-btn layui-btn-xs" data-color="#ffffff">
                    重置
                </button>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">线条样式 </label>
            <div class="layui-col-sm9 layer-u-end">
                <label class="layer-radio-inline">
                    <input data-bind="style.lineStyle" type="radio" name="lineStyle"
                           value="solid" {{ style.lineStyle=== 'solid' ? 'checked' : '' }}> 实线
                </label>
                <label class="layer-radio-inline">
                    <input data-bind="style.lineStyle" type="radio" name="lineStyle"
                           value="dashed" {{ style.lineStyle=== 'dashed' ? 'checked' : '' }}> 虚线
                </label>
                <label class="layer-radio-inline">
                    <input data-bind="style.lineStyle" type="radio" name="lineStyle"
                           value="dotted" {{ style.lineStyle=== 'dotted' ? 'checked' : '' }}> 点状
                </label>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">线条颜色 </label>
            <div class="layui-col-sm9 layer-u-end">
                <input class="" type="color" name="lineColor"
                       data-bind="style.lineColor" value="{{ style.lineColor }}">
                <button type="button" class="btn-resetColor layui-btn layui-btn-xs" data-color="#000000">
                    重置
                </button>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">线条高度 </label>
            <div class="layui-col-sm9 layer-u-end">
                <input class="tpl-form-input" type="range" name="lineHeight" data-bind="style.lineHeight"
                       value="{{ style.lineHeight }}" min="1" max="20">
                <div class="display-value">
                    <span class="value">{{ style.lineHeight }}</span>px (像素)
                </div>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">上下边距 </label>
            <div class="layui-col-sm9 layer-u-end">
                <input class="tpl-form-input" type="range" name="paddingTop" data-bind="style.paddingTop"
                       value="{{ style.paddingTop }}" min="0" max="50">
                <div class="display-value">
                    <span class="value">{{ style.paddingTop }}</span>px (像素)
                </div>
            </div>
        </div>
    </form>
</script>

<!--编辑器: 视频组-->
<script id="tpl_editor_video" type="text/template">
    <div class="editor-title"><span>{{ name }}</span></div>
    <form class="layer-form tpl-form-line-form" data-itemid="{{ id }}">
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">上下边距 </label>
            <div class="layui-col-sm9 layer-u-end">
                <input class="tpl-form-input" type="range" name="paddingTop" data-bind="style.paddingTop"
                       value="{{ style.paddingTop }}" min="0" max="50">
                <div class="display-value">
                    <span class="value">{{ style.paddingTop }}</span>px (像素)
                </div>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">视频高度 </label>
            <div class="layui-col-sm9 layer-u-end">
                <input class="tpl-form-input" type="range" name="height" data-bind="style.height"
                       value="{{ style.height }}" min="50" max="500">
                <div class="display-value">
                    <span class="value">{{ style.height }}</span>px (像素)
                </div>
                <div class="help-block layer-margin-top-xs">
                    <small>滑块可用左右方向键精确调整</small>
                </div>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">视频封面 </label>
            <div class="layui-col-sm9 layer-u-end">
                <div class="data-image j-selectImg">
                    <img src="{{ params.poster }}" alt="">
                    <input type="hidden" name="poster" data-bind="params.poster" value="{{ params.poster }}">
                </div>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">视频地址 </label>
            <div class="layui-col-sm9 layer-u-end">
                <input class="tpl-form-input" type="url" name="videoUrl"
                       data-bind="params.videoUrl" value="{{ params.videoUrl }}">
            </div>
        </div>
    </form>
</script>

<!--编辑器: 公告组-->
<script id="tpl_editor_notice" type="text/template">
    <div class="editor-title"><span>{{ name }}</span></div>
    <form class="layer-form tpl-form-line-form" data-itemid="{{ id }}">
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">上下边距 </label>
            <div class="layui-col-sm9 layer-u-end">
                <input class="tpl-form-input" type="range" name="paddingTop" data-bind="style.paddingTop"
                       value="{{ style.paddingTop }}" min="0" max="50">
                <div class="display-value">
                    <span class="value">{{ style.paddingTop }}</span>px (像素)
                </div>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">背景颜色 </label>
            <div class="layui-col-sm9 layer-u-end">
                <input class="" type="color" name="background" data-bind="style.background"
                       value="{{ style.background }}">
                <button type="button" class="btn-resetColor layui-btn layui-btn-xs" data-color="{{ style.background }}">
                    重置
                </button>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">文字颜色 </label>
            <div class="layui-col-sm9 layer-u-end">
                <input class="" type="color" name="textColor" data-bind="style.textColor" value="{{ style.textColor }}">
                <button type="button" class="btn-resetColor layui-btn layui-btn-xs" data-color="{{ style.textColor }}">
                    重置
                </button>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">公告图标 </label>
            <div class="layui-col-sm9 layer-u-end">
                <div class="data-image j-selectImg">
                    <img src="{{ params.icon }}" style="height: 30px;" alt="">
                    <input type="hidden" name="poster" data-bind="params.icon" value="{{ params.icon }}">
                </div>
                <div class="help-block">
                    <small>建议尺寸：32×32</small>
                </div>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">公告内容 </label>
            <div class="layui-col-sm9 layer-u-end">
                <input class="tpl-form-input" type="text" name="text"
                       data-bind="params.text" value="{{ params.text }}">
            </div>
        </div>
    </form>
</script>

<!--编辑器: 富文本-->
<script id="tpl_editor_richText" type="text/template">
    <div class="editor-title"><span>{{ name }}</span></div>
    <form class="layer-form tpl-form-line-form" data-itemid="{{ id }}">
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">上下边距 </label>
            <div class="layui-col-sm9 layer-u-end">
                <input class="tpl-form-input" type="range" name="paddingTop" data-bind="style.paddingTop"
                       value="{{ style.paddingTop }}" min="0" max="50">
                <div class="display-value">
                    <span class="value">{{ style.paddingTop }}</span>px (像素)
                </div>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">左右边距 </label>
            <div class="layui-col-sm9 layer-u-end">
                <input class="tpl-form-input" type="range" name="paddingLeft" data-bind="style.paddingLeft"
                       value="{{ style.paddingLeft }}" min="0" max="50">
                <div class="display-value">
                    <span class="value">{{ style.paddingLeft }}</span>px (像素)
                </div>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">背景颜色 </label>
            <div class="layui-col-sm9 layer-u-end">
                <input class="" type="color" name="background" data-bind="style.background"
                       value="{{ style.background }}">
                <button type="button" class="btn-resetColor layui-btn layui-btn-xs" data-color="{{ style.background }}">
                    重置
                </button>
            </div>
        </div>
        <div class="layer-form-group layer-padding-top-sm">
            <!-- 加载编辑器的容器 -->
			<input class="" type="text" name="{{ params.content }}" data-bind="params.content" id="{{ params.content }}" value="{{ params.content }}">
        </div>
    </form>
</script>

<!--编辑器: 图片橱窗-->
<script id="tpl_editor_window" type="text/template">
    <div class="editor-title"><span>{{ name }}</span></div>
    <form class="layer-form tpl-form-line-form" data-itemid="{{ id }}">
        <div class="layer-form-group">
            <label class="layer-u-sm-3 layer-form-label layer-text-xs">上下边距 </label>
            <div class="layer-u-sm-8 layer-u-end">
                <input class="tpl-form-input" type="range" name="paddingTop" data-bind="style.paddingTop"
                       value="{{ style.paddingTop }}" min="0" max="50">
                <div class="display-value">
                    <span class="value">{{ style.paddingTop }}</span>px (像素)
                </div>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layer-u-sm-3 layer-form-label layer-text-xs">左右边距 </label>
            <div class="layer-u-sm-8 layer-u-end">
                <input class="tpl-form-input" type="range" name="paddingLeft" data-bind="style.paddingLeft"
                       value="{{ style.paddingLeft }}" min="0" max="50">
                <div class="display-value">
                    <span class="value">{{ style.paddingLeft }}</span>px (像素)
                </div>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layer-u-sm-3 layer-form-label layer-text-xs">背景颜色 </label>
            <div class="layer-u-sm-8 layer-u-end">
                <input class="" type="color" name="background"
                       data-bind="style.background" value="{{ style.background }}">
                <button type="button" class="btn-resetColor layer-btn layer-btn-xs" data-color="#ffffff">
                    重置
                </button>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layer-u-sm-3 layer-form-label layer-text-xs">布局方式 </label>
            <div class="j-switch-help layer-u-sm-8 layer-u-end">
                <label class="layer-radio-inline">
                    <input data-bind="style.layout" type="radio" name="layout"
                           value="2" {{ style.layout=== '2' ? 'checked' : '' }}> 堆积两列
                </label>
                <label class="layer-radio-inline">
                    <input data-bind="style.layout" type="radio" name="layout"
                           value="3" {{ style.layout=== '3' ? 'checked' : '' }}> 堆积三列
                </label>
                <label class="layer-radio-inline">
                    <input data-bind="style.layout" type="radio" name="layout"
                           value="4" {{ style.layout=== '4' ? 'checked' : '' }}> 堆积四列
                </label>
                <label class="layer-radio-inline">
                    <input data-bind="style.layout" type="radio" name="layout"
                           value="-1"
                           {{ style.layout=== '-1' ? 'checked' : '' }} > 橱窗样式
                    <small class="help layer-hide">
                        最多显示四张图片，超出隐藏
                    </small>
                </label>
                <div class="help-block layer-margin-top-xs" data-default="请确保所有图片的尺寸/比例相同。">
                    <small>{{ style.layout=== '-1' ? '最多显示四张图片，超出隐藏' : '请确保所有图片的尺寸/比例相同。' }}</small>
                </div>
            </div>
        </div>
        <div class="form-items">
            {{ include 'tpl_editor_data_item_image' data }}
        </div>
        <div class="j-data-add form-item-add">
            <i class="fa fa-plus"></i> 添加一个
        </div>
    </form>
</script>
<!--编辑器: 商品组-->
<script id="tpl_editor_goods" type="text/template">
    <div class="editor-title"><span>{{ name }}</span></div>
    <form class="layer-form tpl-form-line-form" data-itemid="{{ id }}">
        <!--商品数据-->
        <div class="j-switch-box" data-item-class="switch-source">
            <div class="layer-form-group">
                <label class="layui-col-sm3 layer-form-label layer-text-xs">商品来源 </label>
				<div class="layui-col-sm9 layer-u-end">
					<label class="layer-radio-inline">
						<input data-switch="__choice" data-bind="params.source" type="radio" name="source"
							   value="choice" {{ params.source=== 'auto' ? 'checked' : '' }}> 手动选择
					</label>
					<label class="layer-radio-inline">
						<input data-switch="__auto" data-bind="params.source" type="radio" name="source"
							   value="auto" {{ params.source=== 'choice' ? 'checked' : '' }}> 自动获取
					</label>
				</div>
            </div>
            <!--手动选择-->
            <div class="layer-form-group">
				<div class="switch-source __choice {{ params.source=== 'choice' ? '' : 'layer-hide' }}">
					<div class="form-items __goods layer-cf">
						{{ include 'tpl_editor_data_item_goods' data }}
					</div>
					<div class="j-selectGoods form-item-add">
						<i class="fa fa-plus"></i> 选择商品
					</div>
				</div>
            </div>
            <!--自动获取-->
            <div class="switch-source __auto {{ params.source=== 'auto' ? '' : 'layer-hide' }}">
                <div class="layer-form-group">
                    <label class="layui-col-sm3 layer-form-label layer-text-xs">商品分类 </label>
                    <div class="layui-col-sm9 layer-u-end">
                        <select data-bind="params.auto.category" name="category"
                                data-layer-selected="{searchBox: 1, btnSize: 'sm',  placeholder:'全部分类', maxHeight: 400}">
                            <option value=""></option>
                            <?php if((isset($catgory))): foreach($catgory as $first): ?>
                                <option value="<?php echo htmlentities($first['id']); ?>"><?php echo htmlentities($first['name']); ?></option>
                            <?php endforeach; ?> <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="layer-form-group">
                    <label class="layui-col-sm3 layer-form-label layer-text-xs">商品排序 </label>
                    <div class="layui-col-sm9 layer-u-end">
                        <label class="layer-radio-inline">
                            <input data-bind="params.auto.goodsSort" type="radio" name="goodsSort"
                                   value="all" {{ params.auto.goodsSort=== 'all' ? 'checked' : '' }}> 综合
                        </label>
                        <label class="layer-radio-inline">
                            <input data-bind="params.auto.goodsSort" type="radio" name="goodsSort"
                                   value="sales" {{ params.auto.goodsSort=== 'sales' ? 'checked' : '' }}> 销量
                        </label>
                        <label class="layer-radio-inline">
                            <input data-bind="params.auto.goodsSort" type="radio" name="goodsSort"
                                   value="price" {{ params.auto.goodsSort=== 'price' ? 'checked' : '' }}> 价格
                        </label>
                    </div>
                </div>
                <div class="layer-form-group">
                    <label class="layui-col-sm3 layer-form-label layer-text-xs">显示数量 </label>
                    <div class="layui-col-sm9 layer-u-end">
                        <input class="tpl-form-input" type="number" min="1" name="showNum"
                               data-bind="params.auto.showNum" value="{{ params.auto.showNum }}">
                    </div>
                </div>
            </div>
        </div>
        <!--分割线-->
        <hr data-layer-widget="divider" style="" class="layer-divider layer-divider-dashed"/>
        <!--组件样式-->
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">背景颜色 </label>
            <div class="layui-col-sm9 layer-u-end">
                <input class="" type="color" name="background"
                       data-bind="style.background" value="{{ style.background }}">
                <button type="button" class="btn-resetColor layui-btn layui-btn-xs" data-color="#f3f3f3">
                    重置
                </button>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">显示类型 </label>
            <div class="layui-col-sm9 layer-u-end">
                <label class="layer-radio-inline">
                    <input data-bind="style.display" type="radio" name="display"
                           value="list" {{ style.display=== 'list' ? 'checked' : '' }}> 列表平铺
                </label>
                <label class="layer-radio-inline">
                    <input data-bind="style.display" type="radio" name="display"
                           value="slide" {{ style.display=== 'slide' ? 'checked' : '' }}> 横向滑动
                </label>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">分列数量 </label>
            <div class="layui-col-sm9 layer-u-end">
                <label class="layer-radio-inline">
                    <input data-bind="style.column" type="radio" name="column"
                           value="2" {{ style.column=== '2' ? 'checked' : '' }}> 两列
                </label>
                <label class="layer-radio-inline">
                    <input data-bind="style.column" type="radio" name="column"
                           value="3" {{ style.column=== '3' ? 'checked' : '' }}> 三列
                </label>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">显示内容 </label>
            <div class="layui-col-sm9 layer-u-end">
                <label class="layer-checkbox-inline">
                    <input data-bind="style.show.goodsName" type="checkbox" name="goodsName"
                           value="" {{ style.show.goodsName=== '1' ? 'checked' : '' }}> 商品名称
                </label>
                <label class="layer-checkbox-inline">
                    <input data-bind="style.show.goodsPrice" type="checkbox" name="goodsPrice"
                           value="1" {{ style.show.goodsPrice=== '1' ? 'checked' : '' }}> 商品价格
                </label>
            </div>
        </div>
    </form>
</script>

<!--编辑器: 拼团-->
<script id="tpl_editor_assemble" type="text/template">
    <div class="editor-title"><span>{{ name }}</span></div>
    <form class="layer-form tpl-form-line-form" data-itemid="{{ id }}">

        <div class="form-items">
            {{ include 'tpl_editor_data_item_Marketingimage'  defaulta}}
        </div>
        <!--商品数据-->
        <div class="j-switch-box" data-item-class="switch-source">
            <div class="layer-form-group">
                <label class="layui-col-sm3 layer-form-label layer-text-xs">商品 </label>

            </div>
            <!--手动选择-->
            <div class="layer-form-group">
				<div class="switch-source __choice {{ params.source=== 'choice' ? '' : 'layer-hide' }}">
					<div class="form-items __goods layer-cf">
						{{ include 'tpl_editor_data_item_goods' data }}
					</div>
					<div class="j-selectGoods form-item-add">
						<i class="fa fa-plus"></i> 选择商品
					</div>
				</div>
            </div>

        </div>
		  <!--分割线-->
        <hr data-layer-widget="divider" style="" class="layer-divider layer-divider-dashed"/>
        <!--组件样式-->
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">背景颜色 </label>
            <div class="layui-col-sm9 layer-u-end">
                <input class="" type="color" name="background"
                       data-bind="style.background" value="{{ style.background }}">
                <button type="button" class="btn-resetColor layui-btn layui-btn-xs" data-color="#f3f3f3">
                    重置
                </button>
            </div>
        </div>

    </form>
</script>


<!--编辑器: 秒杀-->
<script id="tpl_editor_spike" type="text/template">
    <div class="editor-title"><span>{{ name }}</span></div>
    <form class="layer-form tpl-form-line-form" data-itemid="{{ id }}">

        <div class="form-items">
            {{ include 'tpl_editor_data_item_Marketingimage'  defaulta}}
        </div>
        <!--商品数据-->
        <div class="j-switch-box" data-item-class="switch-source">
            <div class="layer-form-group">
                <label class="layui-col-sm3 layer-form-label layer-text-xs">商品 </label>

            </div>
            <!--手动选择-->
            <div class="layer-form-group">
				<div class="switch-source __choice {{ params.source=== 'choice' ? '' : 'layer-hide' }}">
					<div class="form-items __goods layer-cf">
						{{ include 'tpl_editor_data_item_goods' data }}
					</div>
					<div class="j-selectGoods form-item-add">
						<i class="fa fa-plus"></i> 选择商品
					</div>
				</div>
            </div>

        </div>

        <!--组件样式-->
        <!--分割线-->
        <hr data-layer-widget="divider" style="" class="layer-divider layer-divider-dashed"/>
        <!--组件样式-->
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">背景颜色 </label>
            <div class="layui-col-sm9 layer-u-end">
                <input class="" type="color" name="background"
                       data-bind="style.background" value="{{ style.background }}">
                <button type="button" class="btn-resetColor layui-btn layui-btn-xs" data-color="#f3f3f3">
                    重置
                </button>
            </div>
        </div>


    </form>
</script>

<!--编辑器: 抢购-->
<script id="tpl_editor_robbuy" type="text/template">
   <div class="editor-title"><span>{{ name }}</span></div>
    <form class="layer-form tpl-form-line-form" data-itemid="{{ id }}">

        <div class="form-items">
            {{ include 'tpl_editor_data_item_Marketingimage'  defaulta}}
        </div>
        <!--商品数据-->
        <div class="j-switch-box" data-item-class="switch-source">
            <div class="layer-form-group">
                <label class="layui-col-sm3 layer-form-label layer-text-xs">商品 </label>

            </div>
            <!--手动选择-->
            <div class="layer-form-group">
				<div class="switch-source __choice {{ params.source=== 'choice' ? '' : 'layer-hide' }}">
					<div class="form-items __goods layer-cf">
						{{ include 'tpl_editor_data_item_goods' data }}
					</div>
					<div class="j-selectGoods form-item-add">
						<i class="fa fa-plus"></i> 选择商品
					</div>
				</div>
            </div>

        </div>
		  <!--分割线-->
        <hr data-layer-widget="divider" style="" class="layer-divider layer-divider-dashed"/>
		<!--分割线-->
        <!--组件样式-->
		<div >
			<div class="layer-form-group">
				<label class="layui-col-sm3 layer-form-label layer-text-xs">小标题</label>
				<div class="layui-col-sm9 layer-u-end">
					<input class="tpl-form-input" type="text" name="title"
						   data-bind="params.title" value="{{ params.title}}">
				</div>
			</div>
			<div class="layer-form-group j-switch-box"  data-item-class="switch-source">
				<label class="layui-col-sm3 layer-form-label layer-text-xs">小标题背景</label>
				<div class="layui-col-sm9 layer-u-end">
					<label class="layer-radio-inline">
						<input data-switch="__image" data-bind="params.backtype" type="radio" name="backtype"
							   value="image" {{ params.backtype=== 'image' ? 'checked' : '' }}> 图片
					</label>

					<label class="layer-radio-inline">
						<input data-switch="__shape" data-bind="params.backtype" type="radio" name="backtype"
							   value="shape" {{ params.backtype=== 'shape' ? 'checked' : '' }}> 形状
					</label>
				</div>
			</div>

			 <div  class=" switch-source __image layer-form-group {{ params.backtype=== 'image' ? '' : 'layer-hide' }}">
				<label class="layui-col-sm3 layer-form-label layer-text-xs">背景图片 </label>
				<div class="layui-col-sm9 layer-u-end">
					<div class="data-image j-selectImg">
						<img src="{{ params.backgroundimg  }}" style="height: 30px;" alt="">
						<input type="hidden" name="background" data-bind="params.backgroundimg" value="{{ params.backgroundimg }}">
					</div>
					<div class="help-block">
						<small>建议尺寸：32×32</small>
					</div>
				</div>
			</div>


			<div class="switch-source __shape layer-form-group {{ params.backtype=== 'shape' ? '' : 'layer-hide' }}">
				<label class="layui-col-sm3 layer-form-label layer-text-xs">形状 </label>
				<div class="layui-col-sm9 layer-u-end">
					<label class="layer-radio-inline">
						<input data-bind="params.textAlign" type="radio" name="textAlign"
							   value="radius" {{ params.textAlign=== 'radius' ? 'checked' : '' }}>
						圆形
					</label>
					<label class="layer-radio-inline">
						<input data-bind="params.textAlign" type="radio" name="textAlign"
							   value="eight" {{ params.textAlign=== 'eight' ? 'checked' : '' }}>
						八角形
					</label>
					<label class="layer-radio-inline">
						<input data-bind="params.textAlign" type="radio" name="textAlign"
							   value="twelve" {{ params.textAlign=== 'twelve' ? 'checked' : '' }}>
						十二角形
					</label>
					<label class="layer-radio-inline">
						<input data-bind="params.textAlign" type="radio" name="textAlign"
							   value="love" {{ params.textAlign=== 'love' ? 'checked' : '' }}>
						爱心
					</label>

				</div>

				<label class="layui-col-sm3 layer-form-label layer-text-xs">形状背景色 </label>
				<div class="layui-col-sm9 layer-u-end">
					<input class="" type="color" name="background"
						   data-bind="params.background" value="{{ params.background }}">
					<button type="button" class="btn-resetColor layui-btn layui-btn-xs" data-color="#f3f3f3">
						重置
					</button>
				</div>

			</div>
		</div>
        <!--组件样式-->
        <!--分割线-->
        <hr data-layer-widget="divider" style="" class="layer-divider layer-divider-dashed"/>
        <!--组件样式-->
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">背景颜色 </label>
            <div class="layui-col-sm9 layer-u-end">
                <input class="" type="color" name="background"
                       data-bind="style.background" value="{{ style.background }}">
                <button type="button" class="btn-resetColor layui-btn layui-btn-xs" data-color="#f3f3f3">
                    重置
                </button>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">显示类型 </label>
            <div class="layui-col-sm9 layer-u-end">
                <label class="layer-radio-inline">
                    <input data-bind="style.display" type="radio" name="display"
                           value="list" {{ style.display=== 'list' ? 'checked' : '' }}> 列表平铺
                </label>
                <label class="layer-radio-inline">
                    <input data-bind="style.display" type="radio" name="display"
                           value="slide" {{ style.display=== 'slide' ? 'checked' : '' }}> 横向滑动
                </label>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">分列数量 </label>
            <div class="layui-col-sm9 layer-u-end">
                <label class="layer-radio-inline">
                    <input data-bind="style.column" type="radio" name="column"
                           value="2" {{ style.column=== '2' ? 'checked' : '' }}> 两列
                </label>
                <label class="layer-radio-inline">
                    <input data-bind="style.column" type="radio" name="column"
                           value="3" {{ style.column=== '3' ? 'checked' : '' }}> 三列
                </label>
            </div>
        </div>

    </form>
</script>
<!--编辑器: 商品促销-->
<script id="tpl_editor_promgoods" type="text/template">
      <div class="editor-title"><span>{{ name }}</span></div>
    <form class="layer-form tpl-form-line-form" data-itemid="{{ id }}">

        <div class="form-items">
            {{ include 'tpl_editor_data_item_Marketingimage'  defaulta}}
        </div>
        <!--商品数据-->
        <div class="j-switch-box" data-item-class="switch-source">
            <div class="layer-form-group">
                <label class="layui-col-sm3 layer-form-label layer-text-xs">商品 </label>

            </div>
            <!--手动选择-->
			<div class="layer-form-group">
				<div class="switch-source __choice {{ params.source=== 'choice' ? '' : 'layer-hide' }}">
					<div class="form-items __goods layer-cf">
						{{ include 'tpl_editor_data_item_goods' data }}
					</div>
					<div class="j-selectGoods form-item-add">
						<i class="fa fa-plus"></i> 选择商品
					</div>
				</div>
            </div>

        </div>
		  <!--分割线-->
        <hr data-layer-widget="divider" style="" class="layer-divider layer-divider-dashed"/>
		<!--分割线-->
        <!--组件样式-->
		<div >
			<div class="layer-form-group">
				<label class="layui-col-sm3 layer-form-label layer-text-xs">小标题</label>
				<div class="layui-col-sm9 layer-u-end">
					<input class="tpl-form-input" type="text" name="title"
						   data-bind="params.title" value="{{ params.title}}">
				</div>
			</div>
			<div class="layer-form-group j-switch-box"  data-item-class="switch-source">
				<label class="layui-col-sm3 layer-form-label layer-text-xs">小标题背景</label>
				<div class="layui-col-sm9 layer-u-end">
					<label class="layer-radio-inline">
						<input data-switch="__image" data-bind="params.backtype" type="radio" name="backtype"
							   value="image" {{ params.backtype=== 'image' ? 'checked' : '' }}> 图片
					</label>

					<label class="layer-radio-inline">
						<input data-switch="__shape" data-bind="params.backtype" type="radio" name="backtype"
							   value="shape" {{ params.backtype=== 'shape' ? 'checked' : '' }}> 形状
					</label>
				</div>
			</div>

			 <div  class=" switch-source __image layer-form-group {{ params.backtype=== 'image' ? '' : 'layer-hide' }}">
				<label class="layui-col-sm3 layer-form-label layer-text-xs">背景图片 </label>
				<div class="layui-col-sm9 layer-u-end">
					<div class="data-image j-selectImg">
						<img src="{{ params.backgroundimg  }}" style="height: 30px;" alt="">
						<input type="hidden" name="background" data-bind="params.backgroundimg" value="{{ params.backgroundimg }}">
					</div>
					<div class="help-block">
						<small>建议尺寸：32×32</small>
					</div>
				</div>
			</div>


			<div class="switch-source __shape layer-form-group {{ params.backtype=== 'shape' ? '' : 'layer-hide' }}">
				<label class="layui-col-sm3 layer-form-label layer-text-xs">形状 </label>
				<div class="layui-col-sm9 layer-u-end">
					<label class="layer-radio-inline">
						<input data-bind="params.textAlign" type="radio" name="textAlign"
							   value="radius" {{ params.textAlign=== 'radius' ? 'checked' : '' }}>
						圆形
					</label>
					<label class="layer-radio-inline">
						<input data-bind="params.textAlign" type="radio" name="textAlign"
							   value="eight" {{ params.textAlign=== 'eight' ? 'checked' : '' }}>
						八角形
					</label>
					<label class="layer-radio-inline">
						<input data-bind="params.textAlign" type="radio" name="textAlign"
							   value="twelve" {{ params.textAlign=== 'twelve' ? 'checked' : '' }}>
						十二角形
					</label>
					<label class="layer-radio-inline">
						<input data-bind="params.textAlign" type="radio" name="textAlign"
							   value="love" {{ params.textAlign=== 'love' ? 'checked' : '' }}>
						爱心
					</label>

				</div>

				<label class="layui-col-sm3 layer-form-label layer-text-xs">形状背景色 </label>
				<div class="layui-col-sm9 layer-u-end">
					<input class="" type="color" name="background"
						   data-bind="params.background" value="{{ params.background }}">
					<button type="button" class="btn-resetColor layui-btn layui-btn-xs" data-color="#f3f3f3">
						重置
					</button>
				</div>

			</div>
		</div>
        <!--组件样式-->
        <!--分割线-->
        <hr data-layer-widget="divider" style="" class="layer-divider layer-divider-dashed"/>
        <!--组件样式-->
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">背景颜色 </label>
            <div class="layui-col-sm9 layer-u-end">
                <input class="" type="color" name="background"
                       data-bind="style.background" value="{{ style.background }}">
                <button type="button" class="btn-resetColor layui-btn layui-btn-xs" data-color="#f3f3f3">
                    重置
                </button>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">显示类型 </label>
            <div class="layui-col-sm9 layer-u-end">
                <label class="layer-radio-inline">
                    <input data-bind="style.display" type="radio" name="display"
                           value="list" {{ style.display=== 'list' ? 'checked' : '' }}> 列表平铺
                </label>
                <label class="layer-radio-inline">
                    <input data-bind="style.display" type="radio" name="display"
                           value="slide" {{ style.display=== 'slide' ? 'checked' : '' }}> 横向滑动
                </label>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">分列数量 </label>
            <div class="layui-col-sm9 layer-u-end">
                <label class="layer-radio-inline">
                    <input data-bind="style.column" type="radio" name="column"
                           value="2" {{ style.column=== '2' ? 'checked' : '' }}> 两列
                </label>
                <label class="layer-radio-inline">
                    <input data-bind="style.column" type="radio" name="column"
                           value="3" {{ style.column=== '3' ? 'checked' : '' }}> 三列
                </label>
            </div>
        </div>

    </form>
</script>


<!--编辑器: 签到-->
<script id="tpl_editor_signin" type="text/template">
    <div class="editor-title"><span>{{ name }}</span></div>
    <form class="layer-form tpl-form-line-form" data-itemid="{{ id }}">

        <div class="form-items">
			{{ include 'tpl_editor_data_item_signin' defaulta }}
        </div>
		 <!--分割线-->
          <hr data-layer-widget="divider" style="" class="layer-divider layer-divider-dashed"/>

		   <div class="layer-form-group">
                <label class="layui-col-sm3 layer-form-label layer-text-xs">button内容 </label>
                <div class="layui-col-sm9 layer-u-end">
                    <input type="text" name="text" data-bind="params.title" value="{{ params.title }}">
                </div>
            </div>
		   <div class="layer-form-group">
                <label class="layui-col-sm3 layer-form-label layer-text-xs">button颜色 </label>
                <div class="layui-col-sm9 layer-u-end">
                    <input type="color" name="color" data-bind="params.color" value="{{ params.color }}">
                    <button type="button" class="btn-resetColor layui-btn layui-btn-xs" data-color="#666666">
                        重置
                    </button>
                </div>
            </div>
			<div class="layer-form-group ">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">button背景颜色 </label>
				<div class="layui-col-sm9 layer-u-end">
					<input class="" type="color" name="background"
                       data-bind="params.background" value="{{ params.background }}">
					<button type="button" class="btn-resetColor layui-btn layui-btn-xs" data-background="#666666">
						重置
					</button>
				</div>
			</div>

        <!--分割线-->
        <hr data-layer-widget="divider" style="" class="layer-divider layer-divider-dashed"/>
		<!--分割线-->
        <!--组件样式-->
		<div >
			<div class="layer-form-group j-switch-box"  data-item-class="switch-source">
				<label class="layui-col-sm3 layer-form-label layer-text-xs">背景选择</label>
				<div class="layui-col-sm9 layer-u-end">
					<label class="layer-radio-inline">
						<input data-switch="__choice" data-bind="params.source" type="radio" name="source"
							   value="choice" {{ params.source=== 'choice' ? 'checked' : '' }}> 图片
					</label>
					<label class="layer-radio-inline">
						<input data-switch="__auto" data-bind="params.source" type="radio" name="source"
							   value="auto" {{ params.source=== 'auto' ? 'checked' : '' }}> 颜色
					</label>
				</div>
			</div>
			<div  class=" switch-source __choice layer-form-group {{ params.source=== 'choice' ? '' : 'layer-hide' }}">
				<div class="layer-form-group layui-col-sm12">
					<label class="layui-col-sm3 layer-form-label layer-text-xs">背景图片 </label>
					<div class="layui-col-sm9 layer-u-end">
						<div class="data-image j-selectImg">
							<img src="{{ style.backgroundimage  }}" style="height: 30px;" alt="">
							<input type="hidden" name="background" data-bind="style.backgroundimage" value="{{ style.backgroundimage }}">
						</div>
						<div class="help-block">
							<small>建议尺寸：32×32</small>
						</div>
					</div>
				</div>
			</div>

			 <div class="switch-source __auto layer-form-group {{ params.source=== 'auto' ? '' : 'layer-hide' }}">
				<label class="layui-col-sm3 layer-form-label layer-text-xs">背景颜色 </label>
				<div class="layui-col-sm9 layer-u-end">
					<input class="" type="color" name="background"
						   data-bind="style.background" value="{{ style.background }}">
					<button type="button" class="btn-resetColor layui-btn layui-btn-xs" data-color="#f3f3f3">
						重置
					</button>
				</div>
			</div>
		</div>
        <!--组件样式-->



    </form>
</script>
<!--编辑器: 优惠券组-->
<script id="tpl_editor_coupon" type="text/template">
    <div class="editor-title"><span>{{ name }}</span></div>
    <form class="layer-form tpl-form-line-form" data-itemid="{{ id }}">
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">上下边距 </label>
            <div class="layui-col-sm9 layer-u-end">
                <input class="tpl-form-input" type="range" name="paddingTop" data-bind="style.paddingTop"
                       value="{{ style.paddingTop }}" min="0" max="50">
                <div class="display-value">
                    <span class="value">{{ style.paddingTop }}</span>px (像素)
                </div>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">背景颜色 </label>
            <div class="layui-col-sm9 layer-u-end">
                <input class="" type="color" name="background"
                       data-bind="style.background" value="{{ style.background }}">
                <button type="button" class="btn-resetColor layui-btn layui-btn-xs" data-color="#ffffff">
                    重置
                </button>
            </div>
        </div>
        <div class="layer-form-group">
            <label class="layui-col-sm3 layer-form-label layer-text-xs">显示数量 </label>
            <div class="layui-col-sm9 layer-u-end">
                <input class="tpl-form-input" type="range" name="limit" data-bind="params.limit"
                       value="{{ params.limit }}" min="1" max="15">
                <div class="display-value">
                    最多<span class="value">{{ params.limit }}</span>个
                </div>
            </div>
        </div>
    </form>
</script>

<!-- ////// -->
<!-- data-item: start -->

<!-- banner & imageSingle: data-item -->
<script id="tpl_editor_data_item_image" type="text/template">
    {{each $data}}
    <div class="form-item drag" data-key="{{ $index }}">
        <i class="mdi menu-icon mdi-window-close item-delete"></i>
        <div class="item-inner">
            <div class="layer-form-group">
                <label class="layui-col-sm3 layer-form-label layer-text-xs">图片 </label>
                <div class="layui-col-sm9 layer-u-end">
                    <div class="data-image j-selectImg">
                        <img src="{{ $value.imgUrl }}" alt="">
                        <input type="hidden" name="imgUrl" data-bind="data.{{ $index }}.imgUrl"
                               value="{{ $value.imgUrl }}">
                    </div>
                    {{ if $value.advise }}
                    <div class="help-block">
                        <small>{{ $value.advise }}</small>
                    </div>
                    {{ /if }}
                </div>
            </div>
            <div class="layer-form-group">
                <label class="layui-col-sm3 layer-form-label layer-text-xs">链接地址 </label>
                <div class="layui-col-sm9 layer-u-end">
                    <input type="text" name="linkUrl" data-bind="data.{{ $index }}.linkUrl"
                           value="{{ $value.linkUrl }}">
                </div>
            </div>
        </div>
    </div>
    {{/each}}
</script>
<!-- banner & 分类图片: data-item -->
<script id="tpl_editor_data_item_Marketingimage" type="text/template">
    {{each $data}}
    <div class="form-item drag" data-key="{{ $index }}">
        <i class="mdi menu-icon mdi-window-close item-delete"></i>
        <div class="item-inner">
            <div class="layer-form-group">
                <label class="layui-col-sm3 layer-form-label layer-text-xs">图片 </label>
                <div class="layui-col-sm9 layer-u-end">
                    <div class="data-image j-selectImg">
                        <img src="{{ $value.imgUrl }}" alt="">
                        <input type="hidden" name="imgUrl" data-bind="defaulta.{{ $index }}.imgUrl"
                               value="{{ $value.imgUrl }}">
                    </div>
                    {{ if $value.advise }}
                    <div class="help-block">
                        <small>{{ $value.advise }}</small>
                    </div>
                    {{ /if }}
                </div>
            </div>
            <div class="layer-form-group">
                <label class="layui-col-sm3 layer-form-label layer-text-xs">链接地址 </label>
                <div class="layui-col-sm9 layer-u-end">
                    <input type="text" name="linkUrl" data-bind="data.{{ $index }}.linkUrl"
                           value="{{ $value.linkUrl }}">
                </div>
            </div>
        </div>
    </div>
    {{/each}}
</script>

<!-- navBar: data-item -->
<script id="tpl_editor_data_item_navBar" type="text/template">
    {{each $data}}
    <div class="form-item drag" data-key="{{ $index }}">
        <i class="mdi menu-icon mdi-window-close item-delete"></i>
        <div class="item-inner">
            <div class="layer-form-group">
                <label class="layui-col-sm3 layer-form-label layer-text-xs">图片 </label>
                <div class="layui-col-sm9 layer-u-end">
                    <div class="data-image j-selectImg">
                        <img src="{{ $value.imgUrl }}" alt="">
                        <input type="hidden" name="imgUrl" data-bind="data.{{ $index }}.imgUrl"
                               value="{{ $value.imgUrl }}">
                    </div>
                    {{ if $value.advise }}
                    <div class="help-block">
                        <small>{{ $value.advise }}</small>
                    </div>
                    {{ /if }}
                </div>
            </div>
            <div class="layer-form-group">
                <label class="layui-col-sm3 layer-form-label layer-text-xs">文字内容 </label>
                <div class="layui-col-sm9 layer-u-end">
                    <input type="text" name="text" data-bind="data.{{ $index }}.text" value="{{ $value.text }}">
                </div>
            </div>
            <div class="layer-form-group">
                <label class="layui-col-sm3 layer-form-label layer-text-xs">文字颜色 </label>
                <div class="layui-col-sm9 layer-u-end">
                    <input type="color" name="color" data-bind="data.{{ $index }}.color" value="{{ $value.color }}">
                    <button type="button" class="btn-resetColor layui-btn layui-btn-xs" data-color="#666666">
                        重置
                    </button>
                </div>
            </div>
            <div class="layer-form-group">
                <label class="layui-col-sm3 layer-form-label layer-text-xs">链接地址 </label>
                <div class="layui-col-sm9 layer-u-end">
                    <input type="text" name="linkUrl" data-bind="data.{{ $index }}.linkUrl"
                           value="{{ $value.linkUrl }}">
                </div>
            </div>
        </div>
    </div>
    {{/each}}
</script>
<!-- 签到: tpl_editor_data_item_signin -->
<script id="tpl_editor_data_item_signin" type="text/template">
    {{each $data}}
    <div class="form-item drag" data-key="{{ $index }}">
        <i class="mdi menu-icon mdi-window-close item-delete"></i>
        <div class="item-inner">
			 <div class="layer-form-group layui-form-group-bf">
                <label class="layui-col-sm3 layer-form-label layer-text-xs">{{ $value.title }}颜色</label>
                <div class="layui-col-sm9 layer-u-end">
                    <input type="color" name="color" data-bind="defaulta.{{ $index }}.color" value="{{ $value.color }}">
                    <button type="button" class="btn-resetColor layui-btn layui-btn-xs" data-color="#666666">
                        重置
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{/each}}
</script>

<!-- goods: data-item -->
<script id="tpl_editor_data_item_goods" type="text/template">
    {{each $data}}
    <div class="form-item drag" data-key="{{ $index }}">
        <i class="mdi menu-icon mdi-window-close item-delete" data-no-confirm="{{ $value.is_default }}"></i>
        <div class="item-inner">
            <div class="data-image">
                <img src="{{ $value.image }}" alt="">
                <input type="hidden" name="goods_id" data-bind="data.{{ $index }}.goods_id"
                       value="{{ $value.goods_id }}">
            </div>
        </div>
    </div>
    {{/each}}
</script>

<!-- ////// -->
<!-- data-item: end -->


<script src="assets/user/js/select.data.js"></script>
<script src="assets/user/js/ddsort.js"></script>
<script src="assets/user/js/diy.js"></script>
<script>
    $(function () {
		
        // 渲染diy页面
         new diyPhone(<?= $jsonData ?: '{}' ?>);

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
