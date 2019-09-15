<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 自定义SEO规则函数库文件
 *     @english: custom_seo.php
 *
 * @version: 1.0
 * @desc   : 自定义SEO规则函数库文件
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-10-30 10:56:43
 */


  /**
   * ------------------------------------------------------------------------------------------
   * 读取SEO规则
   *
   * @param String $vars 行为标识
   * @param String $seo  触发行为的模型名
   *
   * @return String
   */
  function get_seo_meta($vars, $seo)
  {
    # 获取还没有经过变量替换的META信息
    $meta = D('Admin/Seo')->getMetaOfCurrentPage($seo);

    # 替换META中的变量
    foreach($meta as $key => &$value)
    {
      $value = seo_replace_variables($value, $vars);
    }

    unset($value);

    # 返回被替换的META信息
    return $meta;
  }


  /**
   * ------------------------------------------------------------------------------------------
   * SEO规则替换变量
   *
   * @param String $string 模板输出内容
   * @param String $vars   模板变量名称
   *
   * @return String
   */
  function seo_replace_variables($string, $vars)
  {
    if(!$string)
    {
      return '';
    }

    # 调用ThinkPHP中的解析引擎解析变量
    $view = new Think\View();

    # 模板变量赋值
    $view->assign($vars);

    # 解析和获取模板内容，用于输出
    $result = $view->fetch('', $string);

    # 返回替换变量后的结果
    return $result;
  }
