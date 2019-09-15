<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

// OneThink常量定义
const ONETHINK_VERSION = '1.0.131218';
const ADDON_PATH = './Addons/';


require_once(APP_PATH . '/Common/Common/thumb.php');
require_once(APP_PATH . '/Common/Common/api.php');

require_once(APP_PATH . '/Common/Common/custom_seo.php');
require_once(APP_PATH . '/Common/Common/custom_cache.php');
require_once(APP_PATH . '/Common/Common/custom_email.php');
require_once(APP_PATH . '/Common/Common/custom_trace.php');
require_once(APP_PATH . '/Common/Common/custom_request.php');
require_once(APP_PATH . '/Common/Common/custom_datetime.php');
require_once(APP_PATH . '/Common/Common/custom_filter.php');
require_once(APP_PATH . '/Common/Common/custom_function.php');
require_once(APP_PATH . '/Common/Common/custom_picture_reduce.php');


/**
 * 系统公共库文件
 * 主要定义系统公共函数库
 */

/**
 * 检测用户是否登录
 * @return integer 0-未登录，大于0-当前登录用户ID
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function is_login()
{
  $user = session('user_auth');
  if (empty($user)) {
    return 0;
  } else {
    return session('user_auth_sign') == data_auth_sign($user) ? $user['uid'] : 0;
  }
}

function get_uid()
{
  return is_login();
}

/**
 * 检测权限
 */
function CheckPermission($uids)
{
  if (is_administrator()) {
    return true;
  }
  if (in_array(is_login(), $uids)) {
    return true;
  }
  return false;
}

function check_auth($rule, $type = PermissionModel::RULE_URL )
{
  if (is_administrator()) {
        return true;//管理员允许访问任何页面
      }
      static $Auth = null;
      if (!$Auth) {
        $Auth = new \Think\Auth();
      }
      if (!$Auth->check($rule, get_uid(), $type)) {
        return false;
      }
      return true;

    }

/**
 * 检测当前用户是否为管理员
 * @return boolean true-管理员，false-非管理员
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function is_administrator($uid = null)
{
  $uid = is_null($uid) ? is_login() : $uid;
    $admin_uids = explode(',', C('USER_ADMINISTRATOR'));//调整验证机制，支持多管理员，用,分隔
    //dump($admin_uids);exit;
    return $uid && (in_array(intval($uid), $admin_uids));//调整验证机制，支持多管理员，用,分隔
  }



/**
 * 系统加密方法
 * @param string $data 要加密的字符串
 * @param string $key 加密密钥
 * @param int    $expire 过期时间 单位 秒
 * @return string
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function think_encrypt($data, $key = '', $expire = 0)
{
  $key = md5(empty($key) ? C('DATA_AUTH_KEY') : $key);
  $data = base64_encode($data);
  $x = 0;
  $len = strlen($data);
  $l = strlen($key);
  $char = '';

  for ($i = 0; $i < $len; $i++) {
    if ($x == $l) $x = 0;
    $char .= substr($key, $x, 1);
    $x++;
  }

  $str = sprintf('%010d', $expire ? $expire + time() : 0);

  for ($i = 0; $i < $len; $i++) {
    $str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1))) % 256);
  }
  return str_replace(array('+', '/', '='), array('-', '_', ''), base64_encode($str));
}

/**
 * 系统解密方法
 * @param  string $data 要解密的字符串 （必须是think_encrypt方法加密的字符串）
 * @param  string $key 加密密钥
 * @return string
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function think_decrypt($data, $key = '')
{
  $key = md5(empty($key) ? C('DATA_AUTH_KEY') : $key);
  $data = str_replace(array('-', '_'), array('+', '/'), $data);
  $mod4 = strlen($data) % 4;
  if ($mod4) {
    $data .= substr('====', $mod4);
  }
  $data = base64_decode($data);
  $expire = substr($data, 0, 10);
  $data = substr($data, 10);

  if ($expire > 0 && $expire < time()) {
    return '';
  }
  $x = 0;
  $len = strlen($data);
  $l = strlen($key);
  $char = $str = '';

  for ($i = 0; $i < $len; $i++) {
    if ($x == $l) $x = 0;
    $char .= substr($key, $x, 1);
    $x++;
  }

  for ($i = 0; $i < $len; $i++) {
    if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1))) {
      $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
    } else {
      $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
    }
  }
  return base64_decode($str);
}

/**
 * 数据签名认证
 * @param  array $data 被认证的数据
 * @return string       签名
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function data_auth_sign($data)
{
    //数据类型检测
  if (!is_array($data)) {
    $data = (array)$data;
  }
    ksort($data); //排序
    $code = http_build_query($data); //url编码并生成query字符串
    $sign = sha1($code); //生成签名
    return $sign;
  }

/**
 * 对查询结果集进行排序
 * @access public
 * @param array  $list 查询结果
 * @param string $field 排序的字段名
 * @param array  $sortby 排序类型
 * asc正向排序 desc逆向排序 nat自然排序
 * @return array
 */
function list_sort_by($list, $field, $sortby = 'asc')
{
  if (is_array($list)) {
    $refer = $resultSet = array();
    foreach ($list as $i => $data)
      $refer[$i] = &$data[$field];
    switch ($sortby) {
            case 'asc': // 正向排序
            asort($refer);
            break;
            case 'desc': // 逆向排序
            arsort($refer);
            break;
            case 'nat': // 自然排序
            natcasesort($refer);
            break;
          }
          foreach ($refer as $key => $val)
            $resultSet[] = &$list[$key];
          return $resultSet;
        }
        return false;
      }

/**
 * 把返回的数据集转换成Tree
 * @param array  $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * @return array
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0)
{


    // 创建Tree
  $tree = array();
  if (is_array($list)) {
        // 创建基于主键的数组引用
    $refer = array();
    foreach ($list as $key => $data) {
      $refer[$data[$pk]] =& $list[$key];
    }
    foreach ($list as $key => $data) {
            // 判断是否存在parent
      $parentId = $data[$pid];
      if ($root == $parentId) {
        $tree[] =& $list[$key];
      } else {
        if (isset($refer[$parentId])) {
          $parent =& $refer[$parentId];
          $parent[$child][] =& $list[$key];
        }
      }
    }
  }

  return $tree;
}

/**
 * 将list_to_tree的树还原成列表
 * @param  array  $tree 原来的树
 * @param  string $child 孩子节点的键
 * @param  string $order 排序显示的键，一般是主键 升序排列
 * @param  array  $list 过渡用的中间数组，
 * @return array        返回排过序的列表数组
 * @author yangweijie <yangweijiester@gmail.com>
 */
function tree_to_list($tree, $child = '_child', $order = 'id', &$list = array())
{
  if (is_array($tree)) {
    $refer = array();
    foreach ($tree as $key => $value) {
      $reffer = $value;
      if (isset($reffer[$child])) {
        unset($reffer[$child]);
        tree_to_list($value[$child], $child, $order, $list);
      }
      $list[] = $reffer;
    }
    $list = list_sort_by($list, $order, $sortby = 'asc');
  }
  return $list;
}



/**
 * 设置跳转页面URL
 * 使用函数再次封装，方便以后选择不同的存储方式（目前使用cookie存储）
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function set_redirect_url($url)
{
  cookie('redirect_url', $url);
}

/**
 * 获取跳转页面URL
 * @return string 跳转页URL
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function get_redirect_url()
{
  $url = cookie('redirect_url');
  return empty($url) ? __APP__ : $url;
}

/**
 * 处理插件钩子
 * @param string $hook 钩子名称
 * @param mixed  $params 传入参数
 * @return void
 */
function hook($hook, $params = array())
{
  \Think\Hook::listen($hook, $params);
}

/**
 * 获取插件类的类名
 * @param strng $name 插件名
 */
function get_addon_class($name)
{
  $name=ucfirst($name);
  $class = "Addons\\{$name}\\{$name}Addon";
  return $class;
}

/**
 * 获取插件类的配置文件数组
 * @param string $name 插件名
 */
function get_addon_config($name)
{
  $class = get_addon_class($name);
  if (class_exists($class)) {
    $addon = new $class();
    return $addon->getConfig();
  } else {
    return array();
  }
}

/**
 * 插件显示内容里生成访问插件的url
 * @param string $url url
 * @param array  $param 参数
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function addons_url($url, $param = array())
{
  $url = parse_url($url);
  $case = C('URL_CASE_INSENSITIVE');
  $addons = $case ? parse_name($url['scheme']) : $url['scheme'];
  $controller = $case ? parse_name($url['host']) : $url['host'];
  $action = trim($case ? strtolower($url['path']) : $url['path'], '/');

  /* 解析URL带的参数 */
  if (isset($url['query'])) {
    parse_str($url['query'], $query);
    $param = array_merge($query, $param);
  }

  /* 基础参数 */
  $params = array(
    '_addons' => $addons,
    '_controller' => $controller,
    '_action' => $action,
    );
    $params = array_merge($params, $param); //添加额外参数
    if (strtolower(MODULE_NAME) == 'admin') {
      return U('Admin/Addons/execute', $params);
    } else {
      return U('Home/Addons/execute', $params);

    }

  }

/**
 * 时间戳格式化
 * @param int $time
 * @return string 完整的时间显示
 * @author huajie <banhuajie@163.com>
 */
function time_format($time = NULL, $format = 'Y-m-d H:i')
{
  $time = $time === NULL ? NOW_TIME : intval($time);
  return date($format, $time);
}

/**
 * 根据用户ID获取用户名
 * @param  integer $uid 用户ID
 * @return string       用户名
 */
function get_username($uid = 0)
{
  static $list;

  # 获取当前登录用户名
  if(!($uid && is_numeric($uid)))
  {
    return session('user_auth.username');
  }

  # 获取缓存数据
  if(empty($list))
  {
    $list = S('sys_active_user_list');
  }

  # 查找用户信息
  $key = "u{$uid}";

  # 已缓存，直接使用
  if (isset($list[$key]))
  {
    $name = $list[$key];
  }
  # 调用接口获取用户信息
  else
  {
    $username = M('Member')->getFieldById($uid, 'username');

    if($username)
    {
      $name = $list[$key] = $username;

      # 缓存用户
      $count = count($list);
      $max = C('USER_MAX_CACHE');
      while ($count-- > $max)
      {
        array_shift($list);
      }

      S('sys_active_user_list', $list);
    }
    else
    {
      $name = '';
    }
  }

  return $name;
}

/**
 * 根据用户ID获取用户昵称
 * @param  integer $uid 用户ID
 * @return string       用户昵称
 */
function get_nickname($uid = 0)
{
  static $list;
    if (!($uid && is_numeric($uid))) { //获取当前登录用户名
      return session('user_auth.nickname');
    }

    /* 获取缓存数据 */
    if (empty($list)) {
      $list = S('sys_user_nickname_list');
    }

    /* 查找用户信息 */
    $key = "u{$uid}";
    if (isset($list[$key])) { //已缓存，直接使用
      $name = $list[$key];
    } else { //调用接口获取用户信息
      $where['uid'] = $uid;
      $info = M('MemberExtend')->field('nickname')->where($where)->find();
      if ($info !== false && $info['nickname']) {
        $nickname = $info['nickname'];
        $name = $list[$key] = $nickname;
        /* 缓存用户 */
        $count = count($list);
        $max = C('USER_MAX_CACHE');
        while ($count-- > $max) {
          array_shift($list);
        }
        S('sys_user_nickname_list', $list);
      } else {
        $name = '';
      }
    }
    return $name;
  }

/**
 * 获取分类信息并缓存分类
 * @param  integer $id 分类ID
 * @param  string  $field 要获取的字段名
 * @return string         分类信息
 */
function get_category($id, $field = null)
{
  static $list;

  /* 非法分类ID */
  if (empty($id) || !is_numeric($id)) {
    return '';
  }

  /* 读取缓存数据 */
  if (empty($list)) {
    $list = S('sys_category_list');
  }

  /* 获取分类名称 */
  if (!isset($list[$id])) {
    $cate = M('Category')->find($id);
        if (!$cate || 1 != $cate['status']) { //不存在分类，或分类被禁用
          return '';
        }
        $list[$id] = $cate;
        S('sys_category_list', $list); //更新缓存
      }
      return is_null($field) ? $list[$id] : $list[$id][$field];
    }

    /* 根据ID获取分类标识 */
    function get_category_name($id)
    {
      return get_category($id, 'name');
    }

    /* 根据ID获取分类名称 */
    function get_category_title($id)
    {
      return get_category($id, 'title');
    }

/**
 * 获取文档模型信息
 * @param  integer $id 模型ID
 * @param  string  $field 模型字段
 * @return array
 */
function get_document_model($id = null, $field = null)
{
  static $list;

  /* 非法分类ID */
  if (!(is_numeric($id) || is_null($id))) {
    return '';
  }

  /* 读取缓存数据 */
  if (empty($list)) {
    $list = S('DOCUMENT_MODEL_LIST');
  }

  /* 获取模型名称 */
  if (empty($list)) {
    $map = array('status' => 1, 'extend' => 1);
    $model = M('Model')->where($map)->field(true)->select();
    foreach ($model as $value) {
      $list[$value['id']] = $value;
    }
        S('DOCUMENT_MODEL_LIST', $list); //更新缓存
      }

      /* 根据条件返回数据 */
      if (is_null($id)) {
        return $list;
      } elseif (is_null($field)) {
        return $list[$id];
      } else {
        return $list[$id][$field];
      }
    }





//基于数组创建目录和文件
    function create_dir_or_files($files)
    {
      foreach ($files as $key => $value) {
        if (substr($value, -1) == '/') {
          mkdir($value);
        } else {
          @file_put_contents($value, '');
        }
      }
    }

    if (!function_exists('array_column')) {
      function array_column(array $input, $columnKey, $indexKey = null)
      {
        $result = array();
        if (null === $indexKey) {
          if (null === $columnKey) {
            $result = array_values($input);
          } else {
            foreach ($input as $row) {
              $result[] = $row[$columnKey];
            }
          }
        } else {
          if (null === $columnKey) {
            foreach ($input as $row) {
              $result[$row[$indexKey]] = $row;
            }
          } else {
            foreach ($input as $row) {
              $result[$row[$indexKey]] = $row[$columnKey];
            }
          }
        }
        return $result;
      }
    }

/**
 * 获取表名（不含表前缀）
 * @param string $model_id
 * @return string 表名
 * @author huajie <banhuajie@163.com>
 */
function get_table_name($model_id = null)
{
  if (empty($model_id)) {
    return false;
  }
  $Model = M('Model');
  $name = '';
  $info = $Model->getById($model_id);
  if ($info['extend'] != 0) {
    $name = $Model->getFieldById($info['extend'], 'name') . '_';
  }
  $name .= $info['name'];
  return $name;
}

/**
 * 获取属性信息并缓存
 * @param  integer $id 属性ID
 * @param  string  $field 要获取的字段名
 * @return string         属性信息
 */
function get_model_attribute($model_id, $group = true)
{
  static $list;

  /* 非法ID */
  if (empty($model_id) || !is_numeric($model_id)) {
    return '';
  }

  /* 读取缓存数据 */
  if (empty($list)) {
    $list = S('attribute_list');
  }

  /* 获取属性 */
  if (!isset($list[$model_id])) {
    $map = array('model_id' => $model_id);
    $extend = M('Model')->getFieldById($model_id, 'extend');

    if ($extend) {
      $map = array('model_id' => array("in", array($model_id, $extend)));
    }
    $info = M('Attribute')->where($map)->select();
    $list[$model_id] = $info;
        //S('attribute_list', $list); //更新缓存
  }

  $attr = array();
  foreach ($list[$model_id] as $value) {
    $attr[$value['id']] = $value;
  }

  if ($group) {
    $sort = M('Model')->getFieldById($model_id, 'field_sort');

        if (empty($sort)) { //未排序
          $group = array(1 => array_merge($attr));
        } else {
          $group = json_decode($sort, true);

          $keys = array_keys($group);
          foreach ($group as &$value) {
            foreach ($value as $key => $val) {
              $value[$key] = $attr[$val];
              unset($attr[$val]);
            }
          }

          if (!empty($attr)) {
            $group[$keys[0]] = array_merge($group[$keys[0]], $attr);
          }
        }
        $attr = $group;
      }
      return $attr;
    }



/**
 * 根据条件字段获取指定表的数据
 * @param mixed  $value 条件，可用常量或者数组
 * @param string $condition 条件字段
 * @param string $field 需要返回的字段，不传则返回整个数据
 * @param string $table 需要查询的表
 * @author huajie <banhuajie@163.com>
 */
function get_table_field($value = null, $condition = 'id', $field = null, $table = null)
{
  if (empty($value) || empty($table)) {
    return false;
  }

    //拼接参数
  $map[$condition] = $value;
  $info = M(ucfirst($table))->where($map);
  if (empty($field)) {
    $info = $info->field(true)->find();
  } else {
    $info = $info->getField($field);
  }
  return $info;
}

/**
 * 获取链接信息
 * @param int    $link_id
 * @param string $field
 * @return 完整的链接信息或者某一字段
 * @author huajie <banhuajie@163.com>
 */
function get_link($link_id = null, $field = 'url')
{
  $link = '';
  if (empty($link_id)) {
    return $link;
  }
  $link = M('Url')->getById($link_id);
  if (empty($field)) {
    return $link;
  } else {
    return $link[$field];
  }
}

/**
 * 获取文档封面图片
 * @param int    $cover_id
 * @param string $field
 * @return 完整的数据  或者  指定的$field字段值
 * @author huajie <banhuajie@163.com>
 */
function get_cover($cover_id, $field = null)
{
  if (empty($cover_id)) {
    return false;
  }
  $picture = M('File')->where(array('status' => 1))->getById($cover_id);

  if (is_bool(strpos($picture['path'], 'http://'))) {
    $picture['path'] = fixAttachUrl($picture['path']);
  }

  return empty($field) ? $picture : $picture[$field];
}

/**
 * 检查$pos(推荐位的值)是否包含指定推荐位$contain
 * @param number $pos 推荐位的值
 * @param number $contain 指定推荐位
 * @return boolean true 包含 ， false 不包含
 * @author huajie <banhuajie@163.com>
 */
function check_document_position($pos = 0, $contain = 0)
{
  if (empty($pos) || empty($contain)) {
    return false;
  }

    //将两个参数进行按位与运算，不为0则表示$contain属于$pos
  $res = $pos & $contain;
  if ($res !== 0) {
    return true;
  } else {
    return false;
  }
}

/**
 * 获取数据的所有子孙数据的id值
 * @author 朱亚杰 <xcoolcc@gmail.com>
 */

function get_stemma($pids, Model &$model, $field = 'id')
{
  $collection = array();

    //非空判断
  if (empty($pids)) {
    return $collection;
  }

  if (is_array($pids)) {
    $pids = trim(implode(',', $pids), ',');
  }
  $result = $model->field($field)->where(array('pid' => array('IN', (string)$pids)))->select();
  $child_ids = array_column((array)$result, 'id');

  while (!empty($child_ids)) {
    $collection = array_merge($collection, $result);
    $result = $model->field($field)->where(array('pid' => array('IN', $child_ids)))->select();
    $child_ids = array_column((array)$result, 'id');
  }
  return $collection;
}

/**
 * 获取导航URL
 * @param  string $url 导航URL
 * @return string      解析或的url
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function get_nav_url($url)
{
  switch ($url) {
    case 'http://' === substr($url, 0, 7):
    case '#' === substr($url, 0, 1):
    break;
    default:
    $url = U($url);
    break;
  }
  return $url;
}

/**
 * @param $url 检测当前url是否被选中
 * @return bool|string
 * @auth 陈一枭
 */
function get_nav_active($url)
{
  switch ($url) {
    case 'http://' === substr($url, 0, 7):
    if (strtolower($url) === strtolower($_SERVER['HTTP_REFERER'])) {
      return 1;
    }
    case '#' === substr($url, 0, 1):
    return 0;
    break;
    default:
    $url_array = explode('/', $url);
    if ($url_array[0] == '') {
      $MODULE_NAME = $url_array[1];
    } else {
                $MODULE_NAME = $url_array[0]; //发现模块就是当前模块即选中。

              }
              if (strtolower($MODULE_NAME) === strtolower(MODULE_NAME)) {
                return 1;
              };
              break;

            }
            return 0;
          }

/**
 * 获取列表总行数
 * @param  string  $category 分类ID
 * @param  integer $status 数据状态
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function get_list_count($category, $status = 1)
{
  static $count;
  if (!isset($count[$category])) {
    $count[$category] = D('Document')->listCount($category, $status);
  }
  return $count[$category];
}


function array_subtract($a, $b)
{
  return array_diff($a, array_intersect($a, $b));
}


function tox_addons_url($url, $param)
{
    // 拆分URL
  $url = explode('/', $url);
  $addon = $url[0];
  $controller = $url[1];
  $action = $url[2];

    // 调用u函数
  $param['_addons'] = $addon;
  $param['_controller'] = $controller;
  $param['_action'] = $action;
  return U("Home/Addons/execute", $param);
}


/**
 * 取一个二维数组中的每个数组的固定的键知道的值来形成一个新的一维数组
 * @param $pArray 一个二维数组
 * @param $pKey 数组的键的名称
 * @return 返回新的一维数组
 */
function getSubByKey($pArray, $pKey = "", $pCondition = "")
{
  $result = array();
  if (is_array($pArray)) {
    foreach ($pArray as $temp_array) {
      if (is_object($temp_array)) {
        $temp_array = (array)$temp_array;
      }
      if (("" != $pCondition && $temp_array[$pCondition[0]] == $pCondition[1]) || "" == $pCondition) {
        $result[] = ("" == $pKey) ? $temp_array : isset($temp_array[$pKey]) ? $temp_array[$pKey] : "";
      }
    }
    return $result;
  } else {
    return false;
  }
}



/**
 * tox_get_headers 获取链接header
 * @param $url
 * @return array
 * @author:xjw129xjt xjt@ourstu.com
 */
function tox_get_headers($url)
{
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_NOBODY, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_HEADER, 1);
  $f = curl_exec($ch);
  curl_close($ch);
  $h = explode("\n", $f);
  $r = array();
  foreach ($h as $t) {
    $rr = explode(":", $t, 2);
    if (count($rr) == 2) {
      $r[$rr[0]] = trim($rr[1]);
    }
  }
  return $r;
}



require_once(APP_PATH . 'Common/Conf/config_ucenter.php');


