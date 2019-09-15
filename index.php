<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',True);

$url = $_SERVER['REQUEST_URI'];

# 将URL格式化
if((strpos($url, '&')) && (strpos($url, '=')))
{
  if(strpos($url, '=&'))
  {
    $url = preg_replace('/\w*=&/', '', $url);
    $url = preg_replace('/&\w*=$/', '', $url);
  }

  $url = str_replace('&', '/', $url);
  $url = str_replace('=', '/', $url);

  header('Location:'.$url);
}

// 定义应用目录
define('APP_PATH','./Application/');


// # 开启xhprof
// xhprof_enable(XHPROF_FLAGS_MEMORY | XHPROF_FLAGS_CPU); register_shutdown_function(function()
// {
//   $xhprof_data = xhprof_disable();
//   if (function_exists('fastcgi_finish_request'))
//   {
//     fastcgi_finish_request();
//   }
//   include_once "E:/Workspace/PHP/Xhprof/xhprof_lib/utils/xhprof_lib.php";
//   include_once "E:/Workspace/PHP/Xhprof/xhprof_lib/utils/xhprof_runs.php";
//   $xhprof_runs = new XHProfRuns_Default();
//   $run_id = $xhprof_runs->save_run($xhprof_data, 'xhprof');
// });


// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单
