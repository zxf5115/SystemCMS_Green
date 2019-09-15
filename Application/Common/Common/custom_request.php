<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @curlinese: 使用curl得到数据
 *     @english: custom_request.php
 *
 * @version: 1.0
 * @desc   : 使用curl得到数据
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-10-30 10:56:43
 */




  /**
   * ------------------------------------------------------------------------------------------
   * 使用curl得到数据
   *
   * @param string $uri  请求地址
   * @param string $data 请求参数
   *
   * @return 返回数据
   */
  function curl_data($uri, $data = array())
  {
    $curl = curl_init();

    # 需要获取的URL地址
    curl_setopt($curl, CURLOPT_URL, $uri);

    curl_setopt($curl, CURLOPT_HEADER, false);

    // curl_setopt($curl, CURLOPT_POST, true);

    # 设置超时参数
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);

    # 获取数据返回
    curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);

    # curl_exec()获取的信息以文件流的形式返回，而不是直接输出
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));

    if(curl_errno($curl))
    {
      return curl_error($curl);
    }

    $info= curl_exec($curl);

    curl_close($curl);

    return $info;
  }



  /**
   * ------------------------------------------------------------------------------------------
   * 参数设置
   *
   * @param array $data 参数数组
   *
   * @return 将数组参数进行从新设置
   */
  function setParamStyle($data)
  {
    $str = '';
    foreach($data as $k => $v)
    {
      $str .= '&'.$k.'='.$v;
    }

    return $str;
  }
