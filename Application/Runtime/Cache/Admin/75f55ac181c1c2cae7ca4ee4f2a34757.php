<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>系统错误|<?php echo C('WEB_SITE_TITLE');?></title>
  <style type="text/css">
    *{ padding: 0; margin: 0; }
    body{ background: #000; font-family: '微软雅黑'; color: #fff; font-size: 16px; }
    .system-message{ padding: 24px 48px; }
    .system-message h1{ font-size: 80px; font-weight: normal; line-height: 120px; margin-bottom: 12px }
    .system-message .success,.system-message .error{ line-height: 1.8em; font-size: 36px }
    .system-message .detail{ font-size: 12px; line-height: 20px; margin-top: 12px; display:none}
    #href{
      display: inline-block;
      margin-right: 10px;
      font-size: 16px;
      line-height: 18px;
      text-align: center;
      vertical-align: middle;
      cursor: pointer;
      border: 0 none;
      background-color: #8B0000;
      padding: 10px 20px;
      color: #fff;
      font-weight: bold;
      border-color: transparent;
      text-decoration:none;
    }

    #href:hover{
      background-color: #ff0000;
    }
  </style>
</head>
<body>
  <div class="system-message">
    <p class="error"><?php echo($error); ?></p>
    <p class="detail"></p>
    <div style="margin-top:20px">
      <a id="href" id="btn-now" href="<?php echo($jumpUrl); ?>">立即跳转</a> 
      <a id="href" id="btn-now" href="<?php echo(U('Public/logout')); ?>">重新登录</a> 
    </div>
  </div>
</body>
</html>