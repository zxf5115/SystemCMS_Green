<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 自定义数据验证
 *     @english: custom_verification.php
 *
 * @version: 1.0
 * @desc   : 验证数据
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-10-30 10:56:43
 */


  /**
   * ------------------------------------------------------------------------------------------
   * 检查内容是否为浮点数
   *
   * @param String $data      需要验证的内容
   *
   * @return Boolean true|false
   */
  function check_float($data)
  {
    if(!preg_match("^[0-9][.][0-9]$", $data))
    {
      return false;
    }

    return true;
  }


  /**
   * ------------------------------------------------------------------------------------------
   * 检查是否为有效邮件地址
   *
   * @param String $data      需要验证的邮件地址
   *
   * @return Boolean true|false
   */
  function check_email($data)
  {
    if(!preg_matchi("^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*$", $data))
    {
      return false;
    }

    return true;
  }


  /**
   * ------------------------------------------------------------------------------------------
   * 检查是否为有效网址
   *
   * @param String $data      需要验证的网址
   *
   * @return Boolean true|false
   */
  function check_url($data)
  {
    if(!preg_match("^http://[_a-zA-Z0-9-]+(.[_a-zA-Z0-9-]+)*$", $data))
    {
      return false;
    }

    return true;
  }


  /**
   * ------------------------------------------------------------------------------------------
   * 检查字符串是否为空
   *
   * @param String $data      需要验证的字符串
   *
   * @return Boolean true|false
   */
  function check_empty_string($data)
  {
    if(!is_string($data))
    {
      return false; //是否是字符串类型
    }

    if(empty($data))
    {
      return false; //是否已设定
    }

    if($data == '')
    {
      return false; //是否为空
    }

    return true;
  }


  /**
   * ------------------------------------------------------------------------------------------
   * 检查是否为指定长度内字符串
   *
   * @param String $data      需要验证的字符串
   * @param String $start     目标字符串长度的下限
   * @param String $end       目标字符串长度的上限
   *
   * @return Boolean true|false
   */
  function check_string_size($data, $start = 0, $end = 100)
  {
    $data = trim($data);

    if(strlen($data) < $start)
    {
      return false;
    }

    if(strlen($data) > $end)
    {
      return false;
    }

    return true;
  }



  /**
   * ------------------------------------------------------------------------------------------
   * 检查是否为合法用户名
   *
   * @param String $data      需要验证的用户名
   * @param String $start     用户名长度的下限
   * @param String $end       用户名长度的上限
   *
   * @return Boolean true|false
   */
  function check_user($data, $start = 4, $end = 20)
  {
    if(!check_string_size($data, $start, $end))
    {
      return false; //宽度检验
    }
    if(!preg_match("^[_a-zA-Z0-9]*$", $data))
    {
      return false; //特殊字符检验
    }

    return true;
  }


  /**
   * ------------------------------------------------------------------------------------------
   * 检查是否为合法用户密码
   *
   * @param String $data      需要验证的用户密码
   * @param String $start     用户密码长度的下限
   * @param String $end       用户密码长度的上限
   *
   * @return Boolean true|false
   */
  function check_password($data, $start = 4, $end = 20)
  {
    if(!check_string_size($data, $start, $end))
    {
      return false; //宽度检测
    }

    if(!preg_match("^[_a-zA-Z0-9]*$", $data))
    {
      return false; //特殊字符检测
    }

    return true;
  }


  /**
   * ------------------------------------------------------------------------------------------
   * 检查是否为合法电话号码
   *
   * @param String $data      需要验证的电话号码
   *
   * @return Boolean true|false
   */
  function check_mobile($data)
  {
    if(!preg_match("/13[0-9]{9}$|14[0-9]{9}$|15[0-9]{9}$|17[0-9]{9}$|18[0-9]{9}$/", $data))
    {
      return false;
    }

    return true;
  }


  /**
   * ------------------------------------------------------------------------------------------
   * 检查是否为合法邮编
   *
   * @param String $data      需要验证的邮编
   *
   * @return Boolean true|false
   */
  function CheckPost($data)
  {
    $data=trim($data);

    if(strlen($data) == 6)
    {
      if(!preg_match("^[+]?[_0-9]*$", $data))
      {
        return true;;
      }
      else
      {
        return false;
      }
    }
    else
    {
      return false;;
    }
  }
