<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 后台数据格式化插件类
 *     @english: FormatPlugin.class.php
 *
 * @version: 1.0
 * @desc   : 操作后台数据格式化
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-12-11 16:11:01
 */
class FormatPlugin
{
  /**
   * --------------------------------------------------------------------------------------
   * 根据条件格式化数据
   *
   * @param  String    $data   格式化前数据
   * @param  String    $type   使用格式化类型
   * @param  String    $format 格式化数据样式
   * @param  String    $field  格式化数据字段
   *
   * @return String    $data   格式化后数据
   */
  public function getFormatDataInfo($data, $type = 'date', $format = '', $condition = '', $field = '')
  {
    if(!isset($data))
    {
      return '';
    }

    if('date' === $type)
    {
      empty($format) && $format = 'Y-m-d H:i:s';
      # 格式化时间样式
      $data = $this->setDateTimeFormat($data, $format);
    }
    else if('size' === $type)
    {
      empty($format) && $format = '80';

      # 格式化内容数据长度
      $data = $this->setDataSizeFormat($data, $format);
    }
    else if('status' === $type)
    {
      empty($format) && $format = array(0=>'禁用',1=>'启用');

      # 格式化内容数据状态
      $data = $this->setDataStatusFormat($data, $format);
    }
    else if('pay' === $type)
    {
      # 格式化内容数据支付方式
      $data = $this->setDataPayFormat($data);
    }
    else if('model' === $type)
    {
      # 格式化内容数据模型名称
      $data = $this->setDataModelNameFormat($data);
    }
    else if('utf8' === $type)
    {
      empty($format) && $format  = 'UTF-8';

      # 格式化内容数据编号对应文字内容
      $data = $this->setDataTransFormat($data, $format);
    }
    else if('field' === $type)
    {
      empty($format)    && $format  = 'Member';
      empty($condition) && $format  = 'id';
      empty($field)     && $field   = 'id';

      # 格式化内容数据编号对应文字内容
      $data = $this->setDataDataFieldFormat($data, $format, $condition, $field);
    }
    else if('function' === $type)
    {
      # 调用方法格式化内容数据
      $data = $format($data);
    }
    else
    {
      # TODO: 暂时没有想到还需要什么，将来改进
    }

    return $data;
  }



# + ----------------------------------------------------------------------------------------------
# + 内部操作逻辑

  /**
   * --------------------------------------------------------------------------------------
   * 根据条件格式化时间数据
   *
   * @param  String    $data    需要格式化的数据
   * @param  String    $style   格式化样式
   *
   * @return String    格式化后数据
   */
  private function setDateTimeFormat($data, $style)
  {
    if(isset($data))
    {
      return date($style, $data);
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 根据条件格式化内容长度数据
   *
   * @param  String    $data    需要格式化的数据
   * @param  String    $size    格式化样式
   *
   * @return String    格式化后数据
   */
  private function setDataSizeFormat($data, $size)
  {
    if(isset($data))
    {
      if($size < strlen($data))
      {
        return msubstr($data, 0, $size);
      }
      else
      {
        return $data;
      }
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 根据条件格式化内容编码格式数据
   *
   * @param  String    $data    需要格式化的数据
   * @param  String    $format  格式化样式
   *
   * @return String    格式化后数据
   */
  private function setDataTransFormat($data, $format)
  {
    if(isset($data))
    {
      return mb_convert_encoding($data, $format);
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 根据条件格式化内容长度数据
   *
   * @param  String    $data    需要格式化的数据
   * @param  Array     $style   样式数组 array(0=>'禁用',1=>'启用',...)
   *
   * @return String    格式化后数据
   */
  private function setDataStatusFormat($data, $style)
  {
    if(isset($data))
    {
      switch($data)
      {
        case 0:
          return $style[0];
          break;
        case 1:
          return $style[1];
          break;
        case 2:
          return $style[2];
          break;
        case 3:
          return $style[3];
          break;
        case 4:
          return $style[4];
          break;
        case 5:
          return $style[5];
          break;
        case 6:
          return $style[6];
          break;
        case 7:
          return $style[7];
          break;
        case 8:
          return $style[8];
          break;
        default:
          return $style[9];
          break;
      }
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 根据条件格式化支付方式数据
   *
   * @param  String    $data    需要格式化的数据
   *
   * @return String    格式化后数据
   */
  private function setDataPayFormat($data)
  {
    if(isset($data))
    {
      switch($data)
      {
        case 'ALIPAY':
          return '支付宝';
          break;
        case 'WXPAY':
          return '微信';
          break;
        default:
          return '其他';
          break;
      }
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 根据条件格式化模块名称数据
   *
   * @param  String    $data    需要格式化的数据
   *
   * @return String    格式化后数据
   */
  private function setDataModelNameFormat($data)
  {
    if(isset($data))
    {
      switch($data)
      {
        case 'home':
          return '首页';
          break;
        case 'figure':
          return '大师';
          break;
        case 'question':
          return '问答';
          break;
        case 'course':
          return '课程';
          break;
        case 'commodity':
          return '商品';
          break;
        case 'find':
          return '发现';
          break;
        case 'pay':
          return '支付';
          break;
        case 'my':
          return '我的';
          break;
        case 'advertisement':
          return '广告';
          break;
        case 'welcome':
          return '启动页';
          break;
        case 'evaluate':
          return '评价';
          break;
        case 'backstage':
          return '运营后台';
          break;
        default:
          return '未知';
          break;
      }
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 根据条件格式化数据编号数据
   *
   * @param  String    $data     需要格式化的数据
   * @param  String    $function 方法名称
   *
   * @return String    格式化后数据
   */
  private function setDataDataFieldFormat($data, $model, $condition, $field)
  {
    if(isset($data))
    {
      if(empty($data))
      {
        return '无';
      }

      $where[$condition] = $data;
      return D($model)->getWithWhereTableOneFieldInfo($where, $field);
    }
  }

}
