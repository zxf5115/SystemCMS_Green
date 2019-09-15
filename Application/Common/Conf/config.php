<?php
/*
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 公共配置文件
 *     @english: config.php
 *
 * @version: 1.0
 * @desc   : 所有系统中公共配置信息
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-06-16 13:52:11
 */

return array(

  'APP_USE_NAMESPACE'     =>  true,    # 应用类库是否使用命名空间

  'URL_HTML_SUFFIX' => '', # URL伪静态后缀设置

  # 模块相关配置
  // 'AUTOLOAD_NAMESPACE' => array('Addons' => ADDON_PATH), # 扩展模块列表
  'DEFAULT_MODULE'     => 'Home', # 默认模块
  'MODULE_DENY_LIST'   => array('Common', 'User', 'Runtime'), # 禁止访问的模块列表



  # 调试配置
  'SHOW_PAGE_TRACE' => false,

  # 用户相关设置
  'USER_MAX_CACHE'     => 1000, #最大缓存用户数
  'USER_ADMINISTRATOR' => 1, #管理员用户ID

  # URL配置
  'URL_CASE_INSENSITIVE' => true, #默认false 表示URL区分大小写 true则表示不区分大小写
  'URL_MODEL'            => 2, #URL模式  默认关闭伪静态
  'VAR_URL_PARAMS'       => '', # PATHINFO URL参数变量
  'URL_PATHINFO_DEPR'    => '/', #PATHINFO URL分割符

  # 全局过滤配置
  'DEFAULT_FILTER' => '', #全局过滤函数

  # 数据库配置
  'DB_TYPE'         => 'mysqli', # 数据库类型
  'DB_HOST'         => '127.0.0.1', # 服务器地址
  'DB_NAME'         => 'qingyun', # 数据库名
  'DB_USER'         => 'root', # 用户名
  'DB_PWD'          => 'root',  # 密码
  'DB_PORT'         => '3306', # 端口
  'DB_PREFIX'       => '', # 数据库表前缀
  'DB_PARAMS'       => array(), # 数据库连接参数
  'DB_DEBUG'        => TRUE, # 数据库调试模式 开启后可以记录SQL日志
  'DB_FIELDS_CACHE' => true, # 启用字段缓存
  'DB_CHARSET'      => 'utf8', # 数据库编码默认采用utf8
  'DB_DEPLOY_TYPE'  => 0, # 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
  'DB_RW_SEPARATE'  => false, # 数据库读写是否分离 主从式有效
  'DB_MASTER_NUM'   => 1, # 读写分离后 主服务器数量
  'DB_SLAVE_NO'     => '', # 指定从服务器序号



  'LOAD_EXT_CONFIG' => 'router', # 不知道干嘛用的

  # 文件上传相关配置
  'DOWNLOAD_UPLOAD' => array(
  'mimes'    => '', #允许上传的文件MiMe类型
  'maxSize'  => 5*1024*1024, #上传的文件大小限制 (0-不做限制)
  'exts'     => 'jpg,gif,png,jpeg,zip,rar,tar,gz,7z,doc,docx,txt,xml,pdf', #允许上传的文件后缀
  'autoSub'  => true, #自动子目录保存文件
  'subName'  => array('date', 'Y-m-d'), #子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
  'rootPath' => './Uploads/Download/', #保存根路径
  'savePath' => '', #保存路径
  'saveName' => array('uniqid', ''), #上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
  'saveExt'  => '', #文件保存后缀，空则使用原后缀
  'replace'  => false, #存在同名是否覆盖
  'hash'     => true, #是否生成hash编码
  'callback' => false, #检测文件是否存在回调函数，如果存在返回文件信息数组
  ), #下载模型上传配置（文件上传类配置）


  # 图片上传相关配置
  'PICTURE_UPLOAD' => array(
  'mimes'    => '', #允许上传的文件MiMe类型
  'maxSize'  => 2*1024*1024, #上传的文件大小限制 (0-不做限制)
  'exts'     => 'jpg,gif,png,jpeg', #允许上传的文件后缀
  'autoSub'  => true, #自动子目录保存文件
  'subName'  => array('date', 'Y-m-d'), #子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
  'rootPath' => './Uploads/Picture/', #保存根路径
  'savePath' => '', #保存路径
  'saveName' => array('uniqid', ''), #上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
  'saveExt'  => '', #文件保存后缀，空则使用原后缀
  'replace'  => true, #存在同名是否覆盖
  'hash'     => true, #是否生成hash编码
  'callback' => false, #检测文件是否存在回调函数，如果存在返回文件信息数组
  ), #图片上传相关配置（文件上传类配置）

  # 视频上传相关配置
  'VIDEO_UPLOAD' => array(
  'mimes'    => '', #允许上传的文件MiMe类型
  'maxSize'  => 0, #上传的文件大小限制 (0-不做限制)
  'exts'     => 'mp4,avi', #允许上传的文件后缀
  'autoSub'  => true, #自动子目录保存文件
  'subName'  => array('date', 'Y-m-d'), #子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
  'rootPath' => './Uploads/Video/', #保存根路径
  'savePath' => '', #保存路径
  'saveName' => array('uniqid', ''), #上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
  'saveExt'  => '', #文件保存后缀，空则使用原后缀
  'replace'  => true, #存在同名是否覆盖
  'hash'     => true, #是否生成hash编码
  'callback' => false, #检测文件是否存在回调函数，如果存在返回文件信息数组
  ),
  'PICTURE_UPLOAD_DRIVER'=>'local',
  'DOWNLOAD_UPLOAD_DRIVER'=>'local',
  'VIDEO_UPLOAD_DRIVER'=>'local',
  #本地上传文件驱动配置
  'UPLOAD_LOCAL_CONFIG'=>array(),


  # 编辑器图片上传相关配置
  'EDITOR_UPLOAD' => array(
  'mimes'    => '', #允许上传的文件MiMe类型
  'maxSize'  => 2*1024*1024, #上传的文件大小限制 (0-不做限制)
  'exts'     => 'jpg,gif,png,jpeg', #允许上传的文件后缀
  'autoSub'  => true, #自动子目录保存文件
  'subName'  => array('date', 'Y-m-d'), #子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
  'rootPath' => './Uploads/Editor/', #保存根路径
  'savePath' => '', #保存路径
  'saveName' => array('uniqid', ''), #上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
  'saveExt'  => '', #文件保存后缀，空则使用原后缀
  'replace'  => false, #存在同名是否覆盖
  'hash'     => true, #是否生成hash编码
  'callback' => false, #检测文件是否存在回调函数，如果存在返回文件信息数组
  ),

  #邮件配置
  'THINK_EMAIL' => array(
      'SMTP_HOST'   => 'mail.careerforce.cn', #SMTP服务器
      'SMTP_PORT'   => '587', #SMTP服务器端口
      'SMTP_USER'   => 'admin@uyeah.cn', #SMTP服务器用户名
      'SMTP_PASS'   => 'zzdl123', #SMTP服务器密码
      'FROM_EMAIL'  => 'admin@uyeah.cn', #发件人EMAIL
      'FROM_NAME'   => 'UYeah', #发件人名称
      'REPLY_EMAIL' => '', #回复EMAIL（留空则为发件人EMAIL）
      'REPLY_NAME'  => '', #回复名称（留空则为发件人名称）
  ),

  # 系统数据加密设置
  'DATA_AUTH_KEY' => 'Dy&/9=UguK*(tS]!V}5|jTpLohfqx"1,F3EbCvRA', # 默认数据加密KEY

  'PAGE_ROLLPAGE' => '5',
  'PAGE_LISTROWS' => '10',
  'VAR_PAGE' => 'i',

  # 网站地址
  'WEBSITE_URL' => "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],
);
