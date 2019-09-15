<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 用户中心模型
 *     @english: UcenterModel.class.php
 *
 * @version: 1.0
 * @desc   : 用户中心逻辑实现
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-12-10 16:39:32
 */
class UcenterModel
{

# + ----------------------------------------------------------------------------------------------
# + 逻辑

  /**
   * --------------------------------------------------------------------------------------
   * 检查手机号码是否存在
   */
  public function checkMobileExist($mobile,$pname)
  {
    $data['clientid'] = C('SJCLIENTID');
    $data['token']    = C('SJTOKEN');
    $data['mobile']   = $mobile;
    $data['password']   = C('PASSWORD');
    $data['pname']   = $pname;

    # 检查手机号码是否存在接口路径
    $uri = C('CHECK_MOBILE_CREATE');
    $result = curl_data($uri, $data);

    if(0 != $result.result)
    {
      $this->error($result.message);
    }
    else
    {
      # 检查手机号码是否存在接口路径
      //$uri = C('REGISTER');
      //$data['regtype']  = 'phone';
      //$data['password'] = md5(C('PASSWORD'));
	  $arrayContents = json_decode($result,TRUE);
	  $arrayMessage = json_decode($arrayContents['message'],TRUE);
	  return $arrayMessage['account']['id'];
    }
  }

}
