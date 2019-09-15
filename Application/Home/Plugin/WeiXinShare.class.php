<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 微信分享类
 *     @english: WeiXinShare.class.php
 *
 * @version: 1.0
 * @desc   : 分享到微信
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2017-03-16 10:41:01
 */
class WeiXinShare
{
  private $appId;
  private $appSecret;

  public function __construct($appId, $appSecret)
  {
    $this->appId = $appId;
    $this->appSecret = $appSecret;
  }



  /**
   * --------------------------------------------------------------------------------------
   * 新建字符串
   *
   * @param  String    $length    需要格式化的数据
   *
   * @return String    格式化后数据
   */
  public function getSignPackage()
  {
    $apiTicket = $this->getApiTicket();

    # 得到抢钱
    $url = C('WEBSITE_URL');

    $timestamp = time();
    $nonceStr = create_rand_string(16);

    # 这里参数的顺序要按照 key 值 ASCII 码升序排序
    $string = "jsapi_ticket=".$apiTicket."&noncestr=".$nonceStr."×tamp=".$timestamp."&url=".$url;

    $signature = sha1($string);

    $signPackage = array(
      "appId"     => $this->appId, # 公众号的唯一标识
      "nonceStr"  => $nonceStr, # 生成签名的随机串
      "timestamp" => $timestamp, # 生成签名的时间戳
      "url"       => $url, # 网站地址
      "signature" => $signature, # 签名
      "rawString" => $string
      );

    return $signPackage;
  }



# + ----------------------------------------------------------------------------------------------
# + 内部操作逻辑

  /**
   * --------------------------------------------------------------------------------------
   * 新建字符串
   *
   * @param  String    $length    需要格式化的数据
   *
   * @return String    格式化后数据
   */
  private function getApiTicket()
  {
    # jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
    $data = json_decode(file_get_contents("jsapi_ticket.json"));

    if($data->expire_time < time())
    {
      $accessToken = $this->getAccessToken();

      $url = "https:#api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=".$accessToken;

      $res = json_decode($this->httpGet($url));

      $ticket = $res->ticket;

      if($ticket)
      {
        $data->expire_time = time() + 7000;
        $data->jsapi_ticket = $ticket;
        $fp = fopen("jsapi_ticket.json", "w");
        fwrite($fp, json_encode($data));
        fclose($fp);
      }
    }
    else
    {
      $ticket = $data->jsapi_ticket;
    }
    return $ticket;
  }

  private function getAccessToken()
  {
    # access_token 应该全局存储与更新，以下代码以写入到文件中做示例
    $data = json_decode(file_get_contents("access_token.json"));

    if ($data->expire_time < time())
    {
      $url = "https:#api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";

      $res = json_decode($this->httpGet($url));

      $access_token = $res->access_token;

      if ($access_token)
      {
        $data->expire_time = time() + 7000;
        $data->access_token = $access_token;
        $fp = fopen("access_token.json", "w");
        fwrite($fp, json_encode($data));
        fclose($fp);
      }
    }
    else
    {
      $access_token = $data->access_token;
    }

    return $access_token;
  }

  private function httpGet($url)
  {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $url);
    $res = curl_exec($curl);
    curl_close($curl);
    return $res;
  }
}
