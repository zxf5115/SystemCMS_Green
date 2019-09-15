<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="<?php echo C('WEB_SITE_TITLE');?>">
<meta name="author" content="">

<!-- 网站标题 -->
<title><?php echo ($meta_title); ?>|<?php echo C('WEB_SITE_TITLE');?></title>

<!-- 网站标志 -->
<link rel="shortcut icon" href="/Public/favicon.ico">


<link rel="stylesheet" href="/Public/Admin/css/fonts/linecons/css/linecons.css">
<link rel="stylesheet" href="/Public/Static/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="/Public/Admin/css/bootstrap.css">
<link rel="stylesheet" href="/Public/Admin/css/xenon-core.css">
<link rel="stylesheet" href="/Public/Admin/css/xenon-forms.css">
<link rel="stylesheet" href="/Public/Admin/css/xenon-components.css">
<!-- <link rel="stylesheet" href="/Public/Admin/css/xenon-skins.css"> -->
<link rel="stylesheet" href="/Public/Admin/css/custom.css">

<!-- 弹出提示框，ajax用 css -->
<link rel="stylesheet" href="/Public/Static/messenger/messenger.css">
<link rel="stylesheet" href="/Public/Static/messenger/messenger-theme-block.css">
<!-- <link rel="stylesheet" href="/Public/Admin/css/custom/alert_confirm_prompt.css"> -->


<link href="/Public/Static/datetimepicker/css/datetimepicker.css" rel="stylesheet" type="text/css">
<link href="/Public/Static/datetimepicker/css/dropdown.css" rel="stylesheet" type="text/css">

<script src="/Public/Static/jquery-1.11.1.min.js"></script>

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->



  <!-- 用于加载 css 代码 -->
  <style>
    .sidebar-menu{
      width: 240px;
    }

    .px25{
      width: 30px;
    }

    .float_left{
      float: left;
    }

    .float_right{
      float: right;
    }
  </style>


<!-- 页面header钩子，一般用于加载插件CSS文件和代码 -->
<?php echo hook('pageHeader');?>

</head>
<body class="page-body">
  <!-- 头部文件 -->
    <!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
  <div class="page-container">

    <!-- Add "fixed" class to make the sidebar fixed always to the browser viewport. -->
    <!-- Adding class "toggle-others" will keep only one menu item open at a time. -->
    <!-- Adding class "collapsed" collapse sidebar root elements and show only icons. -->
    <div class="sidebar-menu toggle-others fixed">

      <div class="sidebar-menu-inner">

        <header class="logo-env">

          <!-- logo -->
          <div class="logo">
            <a href="<?php echo U('Index/index');?>" class="logo-expanded">
              <!-- <img src="/Public/Admin/images/logo@2x.png" width="80" alt="" /> -->
              <span style="color:#fff;font-size:1.5em"><?php echo C('WEB_SITE_TITLE');?></span>
            </a>

            <a href="<?php echo U('Index/index');?>" class="logo-collapsed">
              <!-- <img src="/Public/Admin/images/logo-collapsed@2x.png" width="40" alt="" /> -->
              <span style="color:#fff;font-size:1.5em"><?php echo C('WEB_SITE_TITLE_ABBR');?></span>
            </a>
          </div>

          <!-- This will toggle the mobile menu and will be visible only on mobile devices -->
          <div class="mobile-menu-toggle visible-xs">
            <a href="#" data-toggle="user-info-menu">
              <i class="fa-bell-o"></i>
              <span class="badge badge-success">7</span>
            </a>

            <a href="#" data-toggle="mobile-menu">
              <i class="fa-bars"></i>
            </a>
          </div>

        </header>

        <ul id="main-menu" class="main-menu">
          <!-- add class "multiple-expanded" to allow multiple submenus to open -->
          <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->

          <?php if(is_array($__MENU__["main"])): $i = 0; $__LIST__ = $__MENU__["main"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="<?php echo ($vo["class"]); ?>">
              <a href="<?php echo (U($vo["url"])); ?>">
                <i class="glyphicon glyphicon-cog"></i>
                <span class="title"><?php echo ($vo["title"]); ?></span>
              </a>
              <?php if(!empty($vo["child"])): ?><ul>
                  <?php if(is_array($vo["child"])): $k = 0; $__LIST__ = $vo["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$xo): $mod = ($k % 2 );++$k; if(!empty($xo)): ?><li class="">
                        <a href="javascript:;">
                          <i class="glyphicon glyphicon-plus"></i>
                          <span class="title"><?php echo ($xo["title"]); ?></span>
                        </a>
                        <ul style="<?php echo ($xo['ul-class'] ? 'display:block' : ''); ?>">
                          <?php if(is_array($xo["info"])): $i = 0; $__LIST__ = $xo["info"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$zo): $mod = ($i % 2 );++$i; if(!empty($zo['title'])): ?><li class="<?php echo ($zo["li-class"]); ?>">
                                <a href="<?php echo (U($zo["url"])); ?>">
                                  <span class="title"><?php echo ($zo["title"]); ?></span>
                                </a>
                              </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                      </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </ul><?php endif; ?>
            </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
      </div>
    </div>

    <div class="main-content">

      <!-- User Info, Notifications and Menu Bar -->
      <nav class="navbar user-info-navbar" role="navigation">

        <!-- Left links for user info navbar -->
        <ul class="user-info-menu left-links list-inline list-unstyled">

          <li class="hidden-sm hidden-xs">
            <a href="#" data-toggle="sidebar">
              <i class="fa-bars"></i>
            </a>
          </li>
        </ul>


        <!-- Right links for user info navbar -->
        <ul class="user-info-menu right-links list-inline list-unstyled">

          <li class="search-form"><!-- You can add "always-visible" to show make the search input visible -->

           <!-- <form method="get" action="extra-search.html">
              <input type="text" name="s" class="form-control search-field" placeholder="搜索"/>

              <button type="submit" class="btn btn-link">
                <i class="glyphicon glyphicon-search"></i>
              </button>
            </form>-->

          </li>

          <li class="dropdown user-profile">
            <a href="#" data-toggle="dropdown">
              <img src="<?php echo session('user_auth.picture');?>" alt="" class="img-circle img-inline userpic-32" width="30" height="30"/>
              <span>
                <?php echo get_nickname();?>
                <i class="fa-angle-down"></i>
              </span>
            </a>

            <ul class="dropdown-menu user-profile-menu list-unstyled">
              <!-- <li>
                <a href="#edit-profile">
                  <i class="fa-edit"></i>
                  信息中心
                </a>
              </li>
              <li>
                <a href="#settings">
                  <i class="fa-wrench"></i>
                  设置
                </a>
              </li>
              <li>
                <a href="<?php echo U('System/help');?>">
                  <i class="fa-info"></i>
                  帮助
                </a>
              </li> -->
              <li class="last">
                <a href="<?php echo U('Public/logout');?>">
                  <i class="fa-lock"></i>
                  退出
                </a>
              </li>
            </ul>
          </li>

        </ul>

      </nav>


  <!-- 内容文件 -->
  
  <div class="page-title">
    <div class="title-env">
      <h1 class="title"><?php echo ($meta_title); ?></h1>
      <p class="description"><?php echo ($list_title); ?></p>
    </div>
    <div class="breadcrumb-env">
      <ol class="breadcrumb bc-1">
        <li>
          <a href="<?php echo U('Index/index');?>"><i class="fa-home"></i>首页</a>
        </li>
        <?php if(is_array($__NAV__)): $k = 0; $__LIST__ = $__NAV__;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k; if(1 == $k): ?><li>
              <a href="<?php echo (U($vo["url"])); ?>"><?php echo ($vo["title"]); ?></a>
            </li><?php endif; ?>
          <?php if(2 == $k): ?><li class="active">
              <strong><?php echo ($vo["title"]); ?></strong>
            </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
      </ol>
    </div>
  </div>

  <!-- 删除搜索和结果数过滤器 -->
  <div class="panel panel-default">
    <div class="panel-heading">
      <button class="btn btn-turquoise btn-add " id="Service_add" url="<?php echo U('Service/add');?>">
      新 增
      </button>

      <button class="btn btn-secondary ajax-post" url="<?php echo U('Service/changeStatus',array('method'=>'resume'));?>" target-form="ids">
      启 用
      </button>

      <button class="btn btn-red ajax-post" url="<?php echo U('Service/changeStatus',array('method'=>'forbid'));?>" target-form="ids">
      禁 用
      </button>

      <button class="btn btn-blue ajax-post confirm" url="<?php echo U('Service/changeStatus',array('method'=>'delete'));?>" target-form="ids">
      删 除
      </button>

      <div class="panel-options">
        <a href="#" data-toggle="panel">
          <span class="collapse-icon">&ndash;</span>
          <span class="expand-icon">+</span>
        </a>
        <a href="#" data-toggle="remove">
          &times;
        </a>
      </div>
    </div>
    <div class="panel-body">
      <!-- 搜索 -->
      <form id="form" class="row" action="javascript:;" url="<?php echo U('Admin/Service/index');?>" style="height:50px;">
        <div class="col-xs-2">
          <input class="form-control date_plugin_start" name="start_time" type="text" autocomplete="off" placeholder="开始日期" value="" >
        </div>
        <div class="col-xs-2">
          <input class="form-control date_plugin_end" name="end_time" type="text" autocomplete="off" placeholder="结束日期" value="" >
        </div>

        <div class="col-xs-2">
          <select class="form-control col-xs-12" name="status" placeholder="请选择状态">
            <option value="0">请选择状态</option>
            <option value="1">启用</option>
            <option value="3">禁用</option>
          </select>
        </div>
        <div class="col-xs-2">
          <input name="search" class="form-control" type="text" placeholder="请输入标题">
        </div>

        <div class="col-xs-4">
          <button type="submit" class="btn btn-info">查询</button>
          <button type="reset" class="btn btn-white">重置</button>
        </div>
      </form>
      <!-- 搜索END -->

      <table class="table table-bordered table-striped" id="dataTables">
        <thead>
          <tr>
            <th class="row-selected row-selected">
              <input class="check-all cbr" type="checkbox"/>
            </th>
            <th class="col-md-1">编号</th>
            <th class="col-md-6">标题</th>
            <th class="col-md-2">创建时间</th>
            <th class="col-md-1">状态</th>
            <th class="col-md-2">操作</th>
          </tr>
        </thead>
        <tbody class="middle-align">
          <?php if(!empty($list)): if(is_array($list)): $k = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><tr class="odd" role="row">
                <td>
                  <input type='checkbox' class='ids cbr' type='checkbox' name='id[]' value='<?php echo ($vo["id"]); ?>'>
                </td>
                <td><?php echo ($vo["id"]); ?></td>
                <td><?php echo ($vo["title"]); ?></td>
                <td><?php echo ($vo["create_time_format"]); ?></td>
                <td><?php echo ($vo["status_format"]); ?></td>
                <td>
                  <a class='btn btn-info btn-sm btn-icon icon-left' href="<?php echo U('Service/edit', array('id'=>$vo['id']));?>">编辑</a>

                  <?php if($vo["status"] == 0): ?><a url="<?php echo U('Service/changeStatus?method=resume', array('id'=>$vo['id']));?>" class='btn btn-secondary btn-sm btn-icon icon-left confirm ajax-get'>启用</a>
                  <?php else: ?>
                    <a url="<?php echo U('Service/changeStatus?method=forbid', array('id'=>$vo['id']));?>" class='btn btn-red btn-sm btn-icon icon-left confirm ajax-get '>禁用</a><?php endif; ?>

                  <a url="<?php echo U('Service/changeStatus?method=delete', array('id'=>$vo['id']));?>" class='btn btn-blue btn-sm btn-icon icon-left confirm ajax-get'>删除</a>
                </td>
              </tr><?php endforeach; endif; else: echo "" ;endif; ?>
          <?php else: ?>
            <tr>
              <td colspan='9' class="text-center">暂无数据...</td>
            </tr><?php endif; ?>
        </tbody>
      </table>
      <!--数据分页-->
      <div class='row'>
        <div class="float_right">
          <div id="dataTables_paginate" class="dataTables_paginate paging_full_numbers">
            <ul class="pagination">
              <?php if($list != ""): echo ($page); endif; ?>
            </ul>
          </div>
        </div>
      </div>

    </div>
  </div>



  <!-- 尾部文件 -->
      <!-- Main Footer -->
    <!-- Choose between footer styles: "footer-type-1" or "footer-type-2" -->
    <!-- Add class "sticky" to  always stick the footer to the end of page (if page contents is small) -->
    <!-- Or class "fixed" to  always fix the footer to the end of page -->
    <footer class="main-footer sticky footer-type-1">

      <div class="footer-inner">

        <!-- Add your copyright text here -->
        <div class="footer-text">
          &copy;
          <strong><?php echo C('WEB_COPYRIGHT_EN');?></strong>
          <a href="<?php echo C('WEB_COPYRIGHT_URL');?>" target="_blank"> <?php echo C('WEB_COPYRIGHT_CN');?></a>
        </div>


        <!-- Go to Top Link, just add rel="go-top" to any link to add this functionality -->
        <div class="go-up">

          <a href="#" rel="go-top">
            <i class="fa-angle-up"></i>
          </a>

        </div>

      </div>

    </footer>
  </div>
</div>






  <!-- JS文件 -->
  <!-- Bottom Scripts -->
<script src="/Public/Static/bootstrap/bootstrap.min.js"></script>

<!-- 控制左侧菜单 -->
<script src="/Public/Admin/js/TweenMax.min.js"></script>

<script type="text/javascript" src="/Public/Static/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="/Public/Static/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>

<!-- 图表统计数据 -->
<script src="/Public/Admin/js/resizeable.js"></script>
<script src="/Public/Admin/js/joinable.js"></script>


<script src="/Public/Admin/js/xenon-api.js"></script>
<script src="/Public/Admin/js/xenon-toggles.js"></script>
<!-- JavaScripts initializations and stuff -->
<script src="/Public/Admin/js/xenon-custom.js"></script>

<!-- Imported scripts on this page -->
<script src="/Public/Admin/js/xenon-widgets.js"></script>

<script src="/Public/Admin/js/devexpress-web-14.1/js/globalize.min.js"></script>
<script src="/Public/Admin/js/devexpress-web-14.1/js/dx.chartjs.js"></script>
<!-- <script src="/Public/Admin/js/toastr/toastr.min.js"></script> -->

<script src="/Public/Admin/js/jquery-validate/jquery.validate.min.js"></script>

<!-- 弹出提示框，ajax用 js -->
<script src="/Public/Static/messenger/messenger.min.js"></script>
<!-- <script src="/Public/Admin/js/custom/alert_confirm_prompt.js"></script> -->
<script src="/Public/Static/js/custom_message.js"></script>
<script src="/Public/Static/js/custom_ajax.js"></script>
<script src="/Public/Admin/js/custom/think.js"></script>

<script src="/Public/Admin/js/common.js"></script>


  <script type="text/javascript" src="/Public/Admin/js/custom/custom_function.js"></script>
  <script type="text/javascript">
    $(document).ready(function()
    {
      var start_time = "<?php echo ($set['start_time']); ?>";
      var end_time   = "<?php echo ($set['end_time']); ?>";

      setDatePlugin('date_plugin_start', 'date_plugin_end');
      setDatePlugin('date_plugin_end');

      Think.setValue('status'    , <?php echo ((isset($set['status']) && ($set['status'] !== ""))?($set['status']):"0"); ?>);
      Think.setValue('search'    , "<?php echo ((isset($set['search']) && ($set['search'] !== ""))?($set['search']):'undefined'); ?>");
      Think.setValue('start_time', start_time);
      Think.setValue('end_time'  , end_time);
    });
  </script>


<!-- 页面footer钩子，一般用于加载插件JS文件和JS代码 -->
<?php echo hook('pageFooter', 'widget');?>

</body>
</html>