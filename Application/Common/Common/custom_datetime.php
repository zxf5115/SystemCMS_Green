<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 自定义时间显示样式方法
 *     @english: custom_datetime.php
 *
 * @version: 1.0
 * @desc   : 自定义时间显示样式
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-11-25 11:11:11
 */


  /**
   * --------------------------------------------------------------------------------------
   * 友好的年份样式
   *
   * @param  string    $date   时间戳
   *
   * @return string            年
   */
  function friendlyYearStyle($date)
  {
    return date("Y",$date);
  }


  /**
   * --------------------------------------------------------------------------------------
   * 友好的月份样式
   *
   * @param  [string] $date [标签类型]
   * @return [string]             [返回标签颜色]
   */
  function friendlyMonthStyle($date)
  {
    return date("M", $date);
  }


  /**
   * --------------------------------------------------------------------------------------
   * 友好的日期样式
   *
   * @param  [string] $date [标签类型]
   * @return [string]             [返回标签颜色]
   */
  function friendlyDayStyle($date)
  {
    return date("d", $date);
  }


  /**
   * --------------------------------------------------------------------------------------
   * 友好的年份月份样式
   *
   * @param  string    $date   时间戳
   *
   * @return string            年 月
   */
  function friendlyYearMonthStyle($date)
  {
    return date("Y-m",$date);
  }


  /**
   * --------------------------------------------------------------------------------------
   * 友好的日期样式
   *
   * @param  string    $date   时间戳
   *
   * @return string            年月日
   */
  function friendlyDateStyle($date)
  {
    return date("Y-m-d",$date);
  }

  /**
   * --------------------------------------------------------------------------------------
   * 友好的日期样式
   *
   * @param  string    $date   时间戳
   *
   * @return string            年月日
   */
  function friendlyDateChineseStyle($date)
  {
    return date("Y年m月d日",$date);
  }


  /**
   * --------------------------------------------------------------------------------------
   * 友好的日期小时样式
   *
   * @param  string    $date   时间戳
   *
   * @return string            年月日 小时
   */
  function friendlyDateHourStyle($date)
  {
    return date("Y-m-d H",$date);
  }


  /**
   * --------------------------------------------------------------------------------------
   * 友好的日期小时分钟样式
   *
   * @param  string    $date   时间戳
   *
   * @return string            年月日 小时 分钟
   */
  function friendlyDateMinuteStyle($date)
  {
    return date("Y-m-d H:i",$date);
  }


  /**
   * --------------------------------------------------------------------------------------
   * 友好的日期小时分钟秒样式
   *
   * @param  string    $date   时间戳
   *
   * @return string            年月日 小时 分钟 秒
   */
  function friendlyDateTimeStyle($date)
  {
    return date("Y-m-d H:i:s",$date);
  }



  /**
   * --------------------------------------------------------------------------------------
   * 友好的星期样式
   *
   * @param  string    $date   时间戳
   *
   * @return string            星期几
   */
  function friendlyWeekStyle($date)
  {
    $date = date("w", $data);
    switch($date)
    {
      case 1:
        return '周一';
      case 2:
        return '周二';
      case 3:
        return '周三';
      case 4:
        return '周四';
      case 5:
        return '周五';
      case 6:
        return '周六';
      default:
        return '周日';
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 友好的时间显示
   *
   * @param  Int      $sTime  待显示的时间
   * @param  String   $type   类型. normal | mohu | full | ymd | other
   * @param  String   $alt    已失效
   *
   * @return String
   */
  function friendlyFormatDate($sTime, $type = 'normal', $alt = 'false')
  {
    if(!$sTime)
    {
      return '';
    }

    # sTime=源时间，cTime=当前时间，dTime=时间差
    $cTime  = time();
    $dTime  = $cTime - $sTime;

    $dDay   = intval(date("z", $cTime)) - intval(date("z", $sTime));

    # $dDay = intval($dTime/3600/24);
    $dYear  = intval(date("Y", $cTime)) - intval(date("Y", $sTime));

    # normal：n秒前，n分钟前，n小时前，日期
    if($type=='normal')
    {
      if( $dTime < 60 )
      {
        if($dTime < 10)
        {
          return '刚刚';
        }
        else
        {
          return intval(floor($dTime / 10) * 10)."秒前";
        }
      }
      else if($dTime < 3600)
      {
        return intval($dTime/60)."分钟前";
      }
      else if($dYear==0 && $dDay == 0)
      {
        //return intval($dTime/3600)."小时前";
        return '今天'.date('H:i',$sTime);
      }
      else if($dYear==0)
      {
        return date("m月d日 H:i",$sTime);
      }
      else
      {
        return date("Y-m-d H:i",$sTime);
      }
    }
    else if($type=='mohu')
    {
      if( $dTime < 60 )
      {
        return $dTime."秒前";
      }
      else if( $dTime < 3600 )
      {
        return intval($dTime/60)."分钟前";
      }
      else if( $dTime >= 3600 && $dDay == 0  )
      {
        return intval($dTime/3600)."小时前";
      }
      else if( $dDay > 0 && $dDay<=7 )
      {
        return intval($dDay)."天前";
      }
      else if( $dDay > 7 &&  $dDay <= 30 )
      {
        return intval($dDay/7) . '周前';
      }
      else if( $dDay > 30 )
      {
        return intval($dDay/30) . '个月前';
      }
      //full: Y-m-d , H:i:s
    }
    else if($type=='full')
    {
      return date("Y-m-d , H:i:s",$sTime);
    }
    else if($type=='ymd')
    {
      return date("Y-m-d",$sTime);
    }
    else
    {
      if( $dTime < 60 )
      {
        return $dTime."秒前";
      }
      else if( $dTime < 3600 )
      {
        return intval($dTime/60)."分钟前";
      }
      else if( $dTime >= 3600 && $dDay == 0  )
      {
        return intval($dTime/3600)."小时前";
      }
      else if($dYear==0)
      {
        return date("Y-m-d H:i:s",$sTime);
      }
      else
      {
        return date("Y-m-d H:i:s",$sTime);
      }
    }
  }
