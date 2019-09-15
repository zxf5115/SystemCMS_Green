<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 分享插件类
 *     @english: SharePlugin.class.php
 *
 * @version: 1.0
 * @desc   : 分享
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-12-11 16:11:01
 */
class SharePlugin
{
  /**
   * --------------------------------------------------------------------------------------
   * 分享
   *
   * @param  String    $type   分享类型 1 微信 2 QQ
   *
   * @return String    $data   格式化后数据
   */
  public function share($type = 1)
  {
    switch($type)
    {
      case 1:
        return $this->getWeiXinSignInfo(C('WX_APP_ID'), C('WX_APP_SECRET'));
        break;
      case 2:
        return $this->getQQSignInfo();
        break;
      case 3:
        break;
      default:
        break;
    }
  }



# + ----------------------------------------------------------------------------------------------
# + 内部操作逻辑

  /**
   * --------------------------------------------------------------------------------------
   * 获得微信信息
   *
   * @param  String    $appId       公众号的唯一标识
   * @param  String    $appSecret
   *
   * @return String    结果
   */
  private function getWeiXinSignInfo($appId, $appSecret)
  {
    if($appId && $appSecret)
    {
      $weixin = new WeiXinShare($appId, $appSecret);
      $signPackage = $weixin->getSignPackage();

      return $signPackage;
    }
    else
    {
      return '参数错误';
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 根据条件格式化时间数据
   *
   * @param  String    $data    需要格式化的数据
   * @param  String    $style   格式化样式
   *
   * @return String    格式化后数据
   */
  private function getQQSignInfo($appId, $appSecret)
  {
    if($appId && $appSecret)
    {
      $jssdk = new WeiXinShare($appId, $appSecret);
      $signPackage = $jssdk->getSignPackage();

      return $signPackage;
    }
    else
    {
      return '参数错误';
    }
  }
}
