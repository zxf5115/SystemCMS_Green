<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 自定义缓存函数
 *     @english: custom_datetime.php
 *
 * @version: 1.0
 * @desc   : 自定义缓存函数
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2016-02-26 11:03:11
 */


  /**
   * --------------------------------------------------------------------------------------
   * 自动缓存
   *
   * @param  String    $key       缓存数据键值
   * @param  String    $func
   * @param  String    $interval  缓存有效期（时间为秒）
   *
   * @return String    缓存内容
   */
  function op_cache($key, $func, $interval)
  {
    $result = S($key);

    if(!$result)
    {
      $result = $func();

      S($key, $result, $interval);
    }

    return $result;
  }


  /**
   * --------------------------------------------------------------------------------------
   * 清除全部缓存
   */
  function clean_all_cache()
  {
    $dirname = './Runtime/';

    //清文件缓存
    $dirs = array($dirname);

    //清理缓存
    foreach($dirs as $value)
    {
      rmdirr($value);
    }

    @mkdir($dirname, 0777, true);
  }


  /**
   * --------------------------------------------------------------------------------------
   * 清除页面缓存
   */
  function clean_html_cache()
  {
    $dirname = './Runtime/Cache/';

    //清文件缓存
    $dirs = array($dirname);

    //清理缓存
    foreach($dirs as $value)
    {
      rmdirr($value);
    }

    @mkdir($dirname, 0777, true);
  }


  /**
   * --------------------------------------------------------------------------------------
   * 清除数据缓存
   */
  function clean_data_cache()
  {
    $dirname = './Runtime/Data/';

    //清文件缓存
    $dirs = array($dirname);

    //清理缓存
    foreach($dirs as $value)
    {
      rmdirr($value);
    }

    @mkdir($dirname, 0777, true);
  }


  /**
   * --------------------------------------------------------------------------------------
   * 清除日志缓存
   */
  function clean_log_cache()
  {
    $dirname = './Runtime/Logs/';

    //清文件缓存
    $dirs = array($dirname);

    //清理缓存
    foreach($dirs as $value)
    {
      rmdirr($value);
    }

    @mkdir($dirname, 0777, true);
  }


  /**
   * --------------------------------------------------------------------------------------
   * 清除临时缓存
   */
  function clean_temp_cache()
  {
    $dirname = './Runtime/Temp/';

    //清文件缓存
    $dirs = array($dirname);

    //清理缓存
    foreach($dirs as $value)
    {
      rmdirr($value);
    }

    @mkdir($dirname, 0777, true);
  }


  /**
   * --------------------------------------------------------------------------------------
   * 删除空的目录
   *
   * @param  String    $dirname  目录名
   *
   * @return Boolean   true|false
   */
  function rmdirr($dirname)
  {
    # 如果文件不存在，返回false
    if(!file_exists($dirname))
    {
      return false;
    }

    # 如果是文件或链接，删除
    if(is_file($dirname) || is_link($dirname))
    {
      return unlink($dirname);
    }

    $dir = dir($dirname);

    if($dir)
    {
      while(false !== $entry = $dir->read())
      {
        if($entry == '.' || $entry == '..')
        {
          continue;
        }

        rmdirr($dirname . DIRECTORY_SEPARATOR . $entry);
      }
    }

    $dir->close();

    return rmdir($dirname);
  }
