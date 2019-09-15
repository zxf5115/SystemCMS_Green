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
<body class="page-body login-page">

  <div class="login-container">

    <div class="row">

      <div class="col-sm-6">

        <!-- Errors container -->
        <div class="errors-container">


        </div>

        <!-- Add class "fade-in-effect" for login form effect -->
        <form method="post" role="form" id="login" class="login-form fade-in-effect">

          <div class="login-header">
            <a href="<?php echo U('Index/index');?>" class="logo">
              <!-- <img src="/Public/Admin/images/logo@2x.png" alt="" width="80" /> -->
              <span style="color:#fff;font-size:1.5em"><?php echo C('WEB_SITE_TITLE');?></span>
              <span>登 录</span>
            </a>

            <p>亲爱的用户，登录进入管理系统！</p>
          </div>


          <div class="form-group">
            <!-- <label class="control-label" for="username">用户名</label> -->
            <input type="text" class="form-control input-dark" name="username" id="username" autocomplete="off" placeholder="用户名"/>
          </div>

          <div class="form-group">
            <!-- <label class="control-label" for="password">密码</label> -->
            <input type="password" class="form-control input-dark" name="password" id="password" autocomplete="off" placeholder="密码"/>
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-dark  btn-block text-left">
              <i class="fa-lock"></i>
              登录
            </button>
          </div>

          <div class="login-footer">
            <a href="#">忘记了你的密码？</a>

            <div class="info-links">
              <a href="#">服务条款</a> -
              <a href="#">隐私政策</a>
            </div>

          </div>

        </form>

        <!-- External login -->
        <!-- <div class="external-login">
          <a href="#" class="facebook">
            <i class="fa-facebook"></i>
            Facebook Login
          </a>


          <a href="#" class="twitter">
            <i class="fa-twitter"></i>
            Login with Twitter
          </a>

          <a href="#" class="gplus">
            <i class="fa-google-plus"></i>
            Login with Google Plus
          </a>

        </div> -->

      </div>

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


  <!-- 用于加载js代码 -->


<!-- 页面footer钩子，一般用于加载插件JS文件和JS代码 -->
<?php echo hook('pageFooter', 'widget');?>



  <script type="text/javascript">
    jQuery(document).ready(function($)
    {
      // 显示登录表单
      setTimeout(function(){ $(".fade-in-effect").addClass('in'); }, 1);

      // 验证和Ajax提交
      $("form#login").validate({
        rules: {
          username: {
            required: true
          },

          password: {
            required: true
          }
        },

        messages: {
          username: {
            required: '请输入您的账号名.'
          },

          password: {
            required: '请输入您的密码.'
          }
        },

        // 通过AJAX表单处理
        submitHandler: function(form)
        {
          // 填补进度条到70%(就一个给定值)
          show_loading_bar(70);

          var opts = {
            "closeButton": true,
            "debug": false,
            "positionClass": "toast-top-full-width",
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
          };

          $.ajax(
          {
            url: "<?php echo U('login');?>",
            method: 'POST',
            dataType: 'json',
            data:
            {
              do_login: true,
              username: $(form).find('#username').val(),
              password: $(form).find('#password').val(),
            },
            success: function(resp)
            {
              show_loading_bar(
              {
                delay: .5,
                pct: 100,
                finish: function()
                {
                  // 成功登录后页面重定向(当进度条达到100%)
                  if(resp.status)
                  {
                    window.location.href = resp.url;
                  }
                  else
                  {
                    updateAlert('登录失败！','error');
                    // $password.select();
                  }
                }
              });
            }
          });
        }
      });

      // Set Form focus
      $("form#login .form-group:has(.form-control):first .form-control").focus();
    });
  </script>
</body>
</html>