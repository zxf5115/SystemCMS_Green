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
                  <?php if(is_array($vo["child"])): $k = 0; $__LIST__ = $vo["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voo): $mod = ($k % 2 );++$k; if(!empty($voo)): ?><li class="">
                        <a href="<?php echo (U($voo["url"])); ?>">
                          <i class="glyphicon glyphicon-plus"></i>
                          <span class="title"><?php echo ($key); ?></span>
                        </a>
                        <ul style="<?php echo ($voo['ul']['ul-class'] ? 'display:block' : ''); ?>">
                          <?php if(is_array($voo)): $i = 0; $__LIST__ = $voo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vooo): $mod = ($i % 2 );++$i; if(!empty($vooo['title'])): ?><li class="<?php echo ($vooo["li-class"]); ?>">
                                <a href="<?php echo (U($vooo["url"])); ?>">
                                  <span class="title"><?php echo ($vooo["title"]); ?></span>
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

  <div class="row">
    <div class="col-sm-12">

      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"></h3>
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

          <form action="<?php echo U('Publicity/add');?>" method="post"  role="form" class="form form-horizontal validate">
            <div class="">
              <div class="panel-body">
                <div class="row">
                  <div class="col-sm-2 text-right">

                    <div class="droppable-area">
                      <span class="red">上传</span>
                      <input type="file" id="upload" class="custom-file">
                    </div>
                  </div>
                  <div class="col-sm-10">
                    <table class="table table-bordered table-striped" id="preview">
                      <thead>
                        <tr>
                          <th width="1%" class="text-center"></th>
                          <th width="50%">图片名称</th>
                          <th width="20%">图片状态</th>
                          <th>操作</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr class="clear">
                          <td colspan="4" class="text-center">等待上传</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group-separator"></div>

            <div class="form-group">
              <label class="col-sm-2 control-label red">广告标题</label>

              <div class="col-sm-10">
                <input name="title" type="text" class="form-control" placeholder="请输入广告标题，长度不超过五十个字（必须）">
              </div>
            </div>

            <div class="form-group-separator"></div>

            <div class="form-group">
              <label class="col-sm-2 control-label red">广告英文标题</label>

              <div class="col-sm-10">
                <input name="english" type="text" class="form-control" placeholder="请输入广告英文标题，长度不超过一百个字（必须）">
              </div>
            </div>

            <div class="form-group-separator"></div>

            <div class="form-group">
              <label class="col-sm-2 control-label">广告排序</label>

              <div class="col-sm-10">
                <select name="sort" class="form-control">
                  <option value="">请选择广告位置</option>
                  <option value="1">第一位</option>
                  <option value="2">第二位</option>
                  <option value="3">第三位</option>
                  <option value="4">第四位</option>
                  <option value="5">第五位</option>
                </select>
              </div>
            </div>

            <div class="form-group-separator"></div>

            <div class="form-group">
              <div class="col-sm-12">
                <button type="submit" class="btn btn-success ajax-post" target-form="form">提 交</button>
                <button type="reset" class="btn btn-white btn-return" onclick="javascript:history.back(-1);return false;">返 回</button>
              </div>
            </div>
          </form>

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


  <script type="text/javascript" src="/Public/Static/fileupload/vendor/jquery.ui.widget.js"></script>
  <script type="text/javascript" src="/Public/Static/fileupload/jquery.fileupload.js"></script>
  <script type="text/javascript" src="/Public/Static/fileupload/jquery.iframe-transport.js"></script>
  <script type="text/javascript" src="/Public/Static/fileupload/jquery.fileupload-process.js "></script>
  <script type="text/javascript" src="/Public/Static/fileupload/jquery.fileupload-validate.js"></script>
  <script type="text/javascript" src="/Public/Admin/js/custom/custom_file_upload.js"></script>

  <script type="text/javascript">
    jQuery(document).ready(function($)
    {
      var url = "<?php echo U('File/uploadImage');?>";
      $.custom_upload('picture', url, 0, '', 1);
    });
  </script>



<!-- 页面footer钩子，一般用于加载插件JS文件和JS代码 -->
<?php echo hook('pageFooter', 'widget');?>

</body>
</html>