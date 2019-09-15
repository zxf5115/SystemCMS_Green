<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @curlinese: 自定义函数
 *     @english: custom_function.php
 *
 * @version: 1.0
 * @desc   : 自定义函数
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-10-30 10:56:43
 */


  /**
   * --------------------------------------------------------------------------------------
   * 获得访客浏览器类型
   */
  function get_client_browser()
  {
    if(!empty($_SERVER['HTTP_USER_AGENT']))
    {
      $br = $_SERVER['HTTP_USER_AGENT'];

      if (preg_match('/MSIE/i',$br))
      {
        $br = 'IE';
      }
      elseif (preg_match('/Firefox/i',$br))
      {
        $br = 'Firefox';
      }
      elseif (preg_match('/Chrome/i',$br))
      {
        $br = 'Chrome';
      }
      elseif (preg_match('/Safari/i',$br))
      {
        $br = 'Safari';
      }
      elseif (preg_match('/Opera/i',$br))
      {
        $br = 'Opera';
      }
      else
      {
        $br = 'Other';
      }

      return $br;
    }
    else
    {
      return "";
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 获得访客浏览器语言
   */
  function get_client_language()
  {
    if(!empty($_SERVER['HTTP_ACCEPT_LANGUAGE']))
    {
      $lang = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
      $lang = substr($lang,0,5);

      if(preg_match("/zh-cn/i",$lang))
      {
        $lang = "简体中文";
      }
      elseif(preg_match("/zh/i",$lang))
      {
        $lang = "繁体中文";
      }
      else
      {
        $lang = "English";
      }

      return $lang;
    }
    else
    {
      return "";
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 获取访客操作系统
   */
  function get_client_system()
  {
    if(!empty($_SERVER['HTTP_USER_AGENT']))
    {
      $OS = $_SERVER['HTTP_USER_AGENT'];

      if (preg_match('/win/i',$OS))
      {
        $OS = 'Windows';
      }
      elseif (preg_match('/mac/i',$OS))
      {
        $OS = 'MAC';
      }
      elseif (preg_match('/linux/i',$OS))
      {
        $OS = 'Linux';
      }
      elseif (preg_match('/unix/i',$OS))
      {
        $OS = 'Unix';
      }
      elseif (preg_match('/bsd/i',$OS))
      {
        $OS = 'BSD';
      }
      else
      {
        $OS = 'Other';
      }

      return $OS;
    }
    else
    {
      return "";
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * is_ie 判断当前浏览器是否为IE
   */
  function is_ie()
  {
    $userAgent = $_SERVER['HTTP_USER_AGENT'];

    $pos = strpos($userAgent, ' MSIE ');

    if ($pos === false)
    {
      return false;
    }
    else
    {
      return true;
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * create_rand_string  产生随机字串，可用来自动生成密码 默认长度6位 字母和数字混合
   *
   * @param int $length 字符串的长度
   * @param string $type 字串类型   0 字母 1 数字 2 大写字母 3 小写字母 4 汉字 默认 字母加数字
   * @param string $addChars 额外字符
   *
   * @return string 随机字符串
   */
  function create_rand_string($length=6, $type='', $addChars='')
  {
    $str ='';
    switch($type)
    {
      case 0:
        $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.$addChars;
        break;
      case 1:
        $chars= str_repeat('0123456789',3);
        break;
      case 2:
        $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ'.$addChars;
        break;
      case 3:
        $chars='abcdefghijklmnopqrstuvwxyz'.$addChars;
        break;
      case 4:
        $chars = "们以我到他会作时要动国产的一是工就年阶义发成部民可出能方进在了不和有大这主中人上为来分生对于学下级地个用同行面说种过命度革而多子后自社加小机也经力线本电高量长党得实家定深法表着水理化争现所二起政三好十战无农使性前等反体合斗路图把结第里正新开论之物从当两些还天资事队批点育重其思与间内去因件日利相由压员气业代全组数果期导平各基或月毛然如应形想制心样干都向变关问比展那它最及外没看治提五解系林者米群头意只明四道马认次文通但条较克又公孔领军流入接席位情运器并飞原油放立题质指建区验活众很教决特此常石强极土少已根共直团统式转别造切九你取西持总料连任志观调七么山程百报更见必真保热委手改管处己将修支识病象几先老光专什六型具示复安带每东增则完风回南广劳轮科北打积车计给节做务被整联步类集号列温装即毫知轴研单色坚据速防史拉世设达尔场织历花受求传口断况采精金界品判参层止边清至万确究书术状厂须离再目海交权且儿青才证低越际八试规斯近注办布门铁需走议县兵固除般引齿千胜细影济白格效置推空配刀叶率述今选养德话查差半敌始片施响收华觉备名红续均药标记难存测士身紧液派准斤角降维板许破述技消底床田势端感往神便贺村构照容非搞亚磨族火段算适讲按值美态黄易彪服早班麦削信排台声该击素张密害侯草何树肥继右属市严径螺检左页抗苏显苦英快称坏移约巴材省黑武培著河帝仅针怎植京助升王眼她抓含苗副杂普谈围食射源例致酸旧却充足短划剂宣环落首尺波承粉践府鱼随考刻靠够满夫失包住促枝局菌杆周护岩师举曲春元超负砂封换太模贫减阳扬江析亩木言球朝医校古呢稻宋听唯输滑站另卫字鼓刚写刘微略范供阿块某功套友限项余倒卷创律雨让骨远帮初皮播优占死毒圈伟季训控激找叫云互跟裂粮粒母练塞钢顶策双留误础吸阻故寸盾晚丝女散焊功株亲院冷彻弹错散商视艺灭版烈零室轻血倍缺厘泵察绝富城冲喷壤简否柱李望盘磁雄似困巩益洲脱投送奴侧润盖挥距触星松送获兴独官混纪依未突架宽冬章湿偏纹吃执阀矿寨责熟稳夺硬价努翻奇甲预职评读背协损棉侵灰虽矛厚罗泥辟告卵箱掌氧恩爱停曾溶营终纲孟钱待尽俄缩沙退陈讨奋械载胞幼哪剥迫旋征槽倒握担仍呀鲜吧卡粗介钻逐弱脚怕盐末阴丰雾冠丙街莱贝辐肠付吉渗瑞惊顿挤秒悬姆烂森糖圣凹陶词迟蚕亿矩康遵牧遭幅园腔订香肉弟屋敏恢忘编印蜂急拿扩伤飞露核缘游振操央伍域甚迅辉异序免纸夜乡久隶缸夹念兰映沟乙吗儒杀汽磷艰晶插埃燃欢铁补咱芽永瓦倾阵碳演威附牙芽永瓦斜灌欧献顺猪洋腐请透司危括脉宜笑若尾束壮暴企菜穗楚汉愈绿拖牛份染既秋遍锻玉夏疗尖殖井费州访吹荣铜沿替滚客召旱悟刺脑措贯藏敢令隙炉壳硫煤迎铸粘探临薄旬善福纵择礼愿伏残雷延烟句纯渐耕跑泽慢栽鲁赤繁境潮横掉锥希池败船假亮谓托伙哲怀割摆贡呈劲财仪沉炼麻罪祖息车穿货销齐鼠抽画饲龙库守筑房歌寒喜哥洗蚀废纳腹乎录镜妇恶脂庄擦险赞钟摇典柄辩竹谷卖乱虚桥奥伯赶垂途额壁网截野遗静谋弄挂课镇妄盛耐援扎虑键归符庆聚绕摩忙舞遇索顾胶羊湖钉仁音迹碎伸灯避泛亡答勇频皇柳哈揭甘诺概宪浓岛袭谁洪谢炮浇斑讯懂灵蛋闭孩释乳巨徒私银伊景坦累匀霉杜乐勒隔弯绩招绍胡呼痛峰零柴簧午跳居尚丁秦稍追梁折耗碱殊岗挖氏刃剧堆赫荷胸衡勤膜篇登驻案刊秧缓凸役剪川雪链渔啦脸户洛孢勃盟买杨宗焦赛旗滤硅炭股坐蒸凝竟陷枪黎救冒暗洞犯筒您宋弧爆谬涂味津臂障褐陆啊健尊豆拔莫抵桑坡缝警挑污冰柬嘴啥饭塑寄赵喊垫丹渡耳刨虎笔稀昆浪萨茶滴浅拥穴覆伦娘吨浸袖珠雌妈紫戏塔锤震岁貌洁剖牢锋疑霸闪埔猛诉刷狠忽灾闹乔唐漏闻沈熔氯荒茎男凡抢像浆旁玻亦忠唱蒙予纷捕锁尤乘乌智淡允叛畜俘摸锈扫毕璃宝芯爷鉴秘净蒋钙肩腾枯抛轨堂拌爸循诱祝励肯酒绳穷塘燥泡袋朗喂铝软渠颗惯贸粪综墙趋彼届墨碍启逆卸航衣孙龄岭骗休借".$addChars;
        break;
      default :
        $chars='ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789'.$addChars;
        break;
    }

    # 位数过长重复字符串一定次数
    if($length > 10)
    {
      $chars = $type == 1 ? str_repeat($chars, $length) : str_repeat($chars, 5);
    }

    if($type != 4)
    {
      $chars = str_shuffle($chars);
      $str   = substr($chars, 0, $length);
    }
    else
    {
      # 中文随机字
      for($i=0; $i < $length; $i++)
      {
        $str.= msubstr($chars, floor(mt_rand(0, mb_strlen($chars,'utf-8') - 1)), 1);
      }
    }

    return $str;
  }



  /**
   * --------------------------------------------------------------------------------------
   * 获取登录验证码 【默认为4位数字】
   *
   * @param  String $length 字符串长度
   * @param  String $mode   字符串类型
   *
   * @return String         字符串
   */
  function build_verify ($length = 4, $mode = 1)
  {
    return create_rand_string($length, $mode);
  }



  /**
   * --------------------------------------------------------------------------------------
   * 随机生成一组字符串
   *
   * @param  String $number
   * @param  String $length 字符串长度
   * @param  String $mode   字符串类型
   *
   * @return String         字符串
   */
  function build_count_rand($number, $length = 4, $mode = 1)
  {
    if($mode == 1 && $length < strlen($number))
    {
      # 不足以生成一定数量的不重复数字
      return false;
    }

    $rand = array();

    for($i=0; $i<$number; $i++)
    {
      $rand[] =   create_rand_string($length, $mode);
    }

    $unqiue = array_unique($rand);

    if(count($unqiue)==count($rand))
    {
      return $rand;
    }

    $count   = count($rand)-count($unqiue);

    for($i=0; $i<$count*3; $i++)
    {
      $rand[] =   create_rand_string($length,$mode);
    }

    $rand = array_slice(array_unique ($rand),0,$number);

    return $rand;
  }



  /**
   * --------------------------------------------------------------------------------------
   * 检查字符串是否是UTF8编码
   *
   * @param  String $string 字符串
   *
   * @return Boolean        是|否
   */
  function is_utf8($string)
  {
    return preg_match('%^(?:
         [\x09\x0A\x0D\x20-\x7E]            # ASCII
       | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
       |  \xE0[\xA0-\xBF][\x80-\xBF]        # excluding overlongs
       | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
       |  \xED[\x80-\x9F][\x80-\xBF]        # excluding surrogates
       |  \xF0[\x90-\xBF][\x80-\xBF]{2}     # planes 1-3
       | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
       |  \xF4[\x80-\x8F][\x80-\xBF]{2}     # plane 16
    )*$%xs', $string);
  }



  /**
   * --------------------------------------------------------------------------------------
   * 自动转换字符集 支持数组转换
   *
   * @param  String $text 字符串
   * @param  String $from 原编码格式
   * @param  String $to   新编码格式
   *
   * @return String       新字符串
   */
  function auto_charset($text, $from = 'gbk', $to = 'utf-8')
  {
    $from = strtoupper($from) == 'UTF8' ? 'utf-8' : $from;
    $to   = strtoupper($to) == 'UTF8' ? 'utf-8' : $to;

    if(strtoupper($from) === strtoupper($to) || empty($text) || (is_scalar($text) && !is_string($text)))
    {
      # 如果编码相同或者非字符串标量则不转换
      return $text;
    }

    if(is_string($text))
    {
      if(function_exists('mb_convert_encoding'))
      {
        return mb_convert_encoding($text, $to, $from);
      }
      elseif(function_exists('iconv'))
      {
        return iconv($from, $to, $text);
      }
      else
      {
        return $text;
      }
    }
    elseif(is_array($text))
    {
      foreach($text as $key => $val)
      {
        $_key = auto_charset($key, $from, $to);

        $text[$_key] = auto_charset($val, $from, $to);

        if($key != $_key)
        {
          unset($text[$key]);
        }
      }

      return $text;
    }
    else
    {
      return $text;
    }
  }



  /**
   * --------------------------------------------------------------------------------------
   * 格式化字节大小
   *
   * @param  number $size 字节数
   * @param  string $delimiter 数字和单位分隔符
   *
   * @return string            格式化后的带单位的大小
   */
  function format_bytes($size, $delimiter = '')
  {
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');

    for($i = 0; $size >= 1024 && $i < 5; $i++)
    {
      $size /= 1024;
    }

    return round($size, 2) . $delimiter . $units[$i];
  }


  /**
   * --------------------------------------------------------------------------------------
   * 字符串截取，支持中文和其他编码
   *
   * @param string $str 需要转换的字符串
   * @param string $start 开始位置
   * @param string $length 截取长度
   * @param string $charset 编码格式
   * @param string $suffix 截断显示字符
   *
   * @return string
   */
  function msubstr($str, $start = 0, $length = 80, $charset = "utf-8", $suffix = '...')
  {
    if(function_exists("mb_substr"))
    {
      $slice = mb_substr($str, $start, $length, $charset);
    }
    else if(function_exists('iconv_substr'))
    {
      $slice = iconv_substr($str, $start, $length, $charset);

      if(false === $slice)
      {
        $slice = '';
      }
    }
    else
    {
      $re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
      $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
      $re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
      $re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";

      preg_match_all($re[$charset], $str, $match);

      $slice = join("", array_slice($match[0], $start, $length));
    }

    return strlen($str) > $length ? $slice . $suffix : $slice;
  }


  /**
   * --------------------------------------------------------------------------------------
   * 简单对称加密算法之加密
   *
   * @param String $string 需要加密的字串
   * @param String $skey 加密EKY
   *
   * @return String
   */
  function encode($string = '', $skey = 'careerforce')
  {
    $strArr = str_split(base64_encode($string));

    $strCount = count($strArr);

    foreach (str_split($skey) as $key => $value)
    {
      $key < $strCount && $strArr[$key].=$value;
    }

    return str_replace(array('=', '+', '/'), array('OXOXO', 'oXVXo', 'XV00X'), join('', $strArr));
  }

  /**
   * --------------------------------------------------------------------------------------
   * 简单对称加密算法之解密
   *
   * @param String $string 需要解密的字串
   * @param String $skey 解密KEY
   *
   * @return String
   */
  function decode($string = '', $skey = 'careerforce')
  {
    $strArr = str_split(str_replace(array('OXOXO', 'oXVXo', 'XV00X'), array('=', '+', '/'), $string), 2);

    $strCount = count($strArr);

    foreach (str_split($skey) as $key => $value)
    {
      $key <= $strCount && $strArr[$key][1] === $value && $strArr[$key] = $strArr[$key][0];
    }

    return base64_decode(join('', $strArr));
  }



  /**
   * --------------------------------------------------------------------------------------
   * 将内容中多余空格减短到一个空格
   *
   * @param String $content 需要减短的字符串
   *
   * @return String         减短后的字符串
   */
  function shorten_white_space($content)
  {
    $content = preg_replace('/\s+/', ' ', $content);

    return $content;
  }


  /**
   * --------------------------------------------------------------------------------------
   * 解析URL地址
   *
   * @param String $content 需要解析的字符串
   *
   * @return String         减解析的字符串
   */
  function parse_url_link($content)
  {
    $content = preg_replace("#((http|https|ftp)://(\S*?\.\S*?))(\s|\;|\)|\]|\[|\{|\}|,|\"|'|:|\<|$|\.\s)#ie", "'<a href=\"$1\" target=\"_blank\"><i class=\"glyphicon glyphicon-link\" title=\"$1\"></i></a>$4'", $content);

    return $content;
  }



  /**
   * --------------------------------------------------------------------------------------
   * 判断链接是否为图片
   *
   * @param String $path 链接地址
   *
   * @return Boolean     true|false
   */
  function check_image_path($path)
  {
    $header  = tox_get_headers($path);

    $res = strpos($header['Content-Type'], 'image/');

    return is_bool($res) ? false : true;
  }



  /**
   * --------------------------------------------------------------------------------------
   * 自定义哈希值
   *
   * @param String $message 待处理内容
   * @param String $salt    特定字符串
   *
   * @return String         处理后内容
   */
  function custom_hash($message, $salt = "ZhangXiaoFei")
  {
    $s01 = $message . $salt;
    $s02 = md5($s01) . $salt;
    $s03 = sha1($s01) . md5($s02) . $salt;
    $s04 = $salt . md5($s03) . $salt . $s02;
    $s05 = $salt . sha1($s04) . md5($s04) . crc32($salt . $s04);

    return md5($s05);
  }



  /**
   * --------------------------------------------------------------------------------------
   * 格式化输出
   *
   * @param  Array     $arr   要分割的字符串
   * @param  String    $glue  分割符
   *
   * @return String    字符串
   */
  function output($arr)
  {
    echo '<pre>';
    dump($arr);
    echo '</pre>';
    exit;
  }


  /**
   * --------------------------------------------------------------------------------------
   * 获得当前URL地址的参数数据
   *
   * @return String URL地址的参数数据
   */
  function get_current_url_data()
  {
    # 获得当前URL地址
    $tmp = $_SERVER['HTTP_REFERER'];

    # 解析URL地址，获得其组成部分
    $params = parse_url($tmp);

    if(trim($params['query'], 's='))
    {
      # 获得URL地址参数数据，并且去掉特殊字符串
      $url = trim($params['query'], 's=');
    }
    else
    {
      # 获得URL地址参数数据，并且去掉两边的空格
      $url = trim($params['path']);
    }

    return $url;
  }


  /**
   * --------------------------------------------------------------------------------------
   * 获得当前URL地址，设置高亮
   *
   * @param Array $urls URL地址数组
   *
   * @return String URL地址的参数数据
   */
  function get_current_active_url($urls)
  {
    # 得到当前URL地址
    $string = S('CURRENT_PATH');

    if(empty($string))
    {
      return '';
    }

    foreach($urls as $k => $vo)
    {
      if($string == strtolower($vo['url']))
      {
        return 'active';
      }
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 为URL地址添加http
   *
   * @param  String    $url     要添加的url地址
   * @param  String    $format  要添加的的格式
   *
   * @return String    添加完成的url地址
   */
  function set_url_format($url, $format = 'http://')
  {
    if(false === strpos($url, $format))
    {
      $url = $format.$url;
    }

    return $url;
  }




  /**
   * --------------------------------------------------------------------------------------
   * 设置返回数据【将一对多数据进行整合】
   *
   * @param  Array   $parent  一数据
   * @param  Array   $child   多数据
   * @param  String  $lid     一条件字段编号
   * @param  String  $rid     多条件字段编号
   * @param  String  $field   自定义多数组键值
   *
   * @return Array   重组后的数据
   */
  function set_return_data($parent = array(), $child = array(), $lid = '', $rid = '', $field = '')
  {
    if(!empty($parent) && is_array($parent))
    {
      if(!empty($child) && is_array($child))
      {
        foreach($parent as $k=> $vo)
        {
          $j = 0;
          foreach($child as $voo)
          {
            if($voo[$rid] == $vo[$lid])
            {
              $parent[$k][$field][] = $voo;
              $j++;
            }
          }
          continue;
        }

        return $parent;
      }
      else
      {
        return $parent;
      }
    }
  }



  /**
   * --------------------------------------------------------------------------------------
   * 获得数组中指定字段的字符串
   *
   * @param  Array   $data  数据
   * @param  String  $field 指定字段
   *
   * @return Array   指定字段内容字符串
   */
  function get_array_field($data = array(), $field = 'id')
  {
    if(!empty($data) && is_array($data))
    {
      foreach($data as $vo)
      {
        $list[] = $vo[$field];
      }

      $info = implode(',', $list);

      return $info;
    }
  }



  /**
   * --------------------------------------------------------------------------------------
   * 获得数组中指定字段的字符串
   *
   * @param  Array   $data  数组
   * @param  Array|String  $field 指定删除的字段
   *
   * @return Array   指定字段内容字符串
   */
  function remove_array_field(&$data, $field)
  {
    if((!empty($data) && is_array($data)) && !empty($field))
    {
      if(is_array($field))
      {
        foreach($field as $vo)
        {
          unset($data[$vo]);
        }
      }
      else
      {
        unset($data[$field]);
      }
    }
  }



  /**
   * --------------------------------------------------------------------------------------
   * 清除数组中空值
   *
   * @param  Array   $data  数据
   *
   * @return Array   清除后的数据
   */
  function clear_array_null($data = array())
  {
    foreach($data as $k => &$vo)
    {
      if(empty($vo))
      {
        unset($vo);
      }
    }

    return $data;
  }



  /**
   * --------------------------------------------------------------------------------------
   * 数组是否是多维数组
   *
   * @param  Array     $data  数据
   *
   * @return Boolean   是否为多维数组
   */
  function is_multi_array($data = array())
  {
    if(count($data, 1) > 1)
    {
      return true;
    }
    else
    {
      return false;
    }
  }



  /**
   * --------------------------------------------------------------------------------------
   * 格式化查询条件【因为多表查询时，实现条件归宿】
   *
   * @param  array  $list   [查询条件数组]
   * @param  string $alias  [默认表别名]
   * @return [array]        [返回格式良好的查询条件数组]
   *
   * [code]
   *   $map['company_name'][0] = array("like", "%".$name."%");  # 加入查询条件
   *   $map['company_name']['alias'] = 'l';                     # 加入查询条件
   * [/code]
   */
  function format_where_condition($list = array(), $alias = "")
  {
    $where = array();

    if(is_array($list))
    {
      foreach($list as $key => $vo)
      {
        if(false !== strpos($key, '|'))
        {
          return $list;
        }

        if(!is_multi_array($vo))
        {
          $where[$alias.'.'.$key] = $list[$key];
        }
        else
        {
          if(!empty($vo['alias']))
          {
            $new_alias = $vo['alias'];
            unset($vo['alias']);
          }

          if(!is_multi_array($vo))
          {
            $value = $vo[0];
            $where[$new_alias.'.'.$key] = $value;
          }
          else
          {
            $value = $vo;
            $where[$alias.'.'.$key] = $value;
          }
        }
      }
    }

    return $where;
  }



  /**
   * --------------------------------------------------------------------------------------
   * 字符串转换为数组，主要用于把分隔符调整到第二个参数
   *
   * @param  String    $str   要分割的字符串
   * @param  String    $glue  分割符
   *
   * @return Array     数组
   */
  function str2arr($str, $glue = ',')
  {
    return explode($glue, $str);
  }


  /**
   * --------------------------------------------------------------------------------------
   * 数组转换为字符串，主要用于把分隔符调整到第二个参数
   *
   * @param  Array     $arr   要分割的字符串
   * @param  String    $glue  分割符
   *
   * @return String    字符串
   */
  function arr2str($arr, $glue = ',')
  {
    return implode($glue, $arr);
  }

  /**
   * --------------------------------------------------------------------------------------
   * 数组转换为对象
   *
   * @param  Array     $arr   要转换的数组
   *
   * @return Object    对象
   */
  function array2object($array)
  {
    if(is_array($array))
    {
      $obj = new StdClass();
      foreach ($array as $key => $val)
      {
        $obj->$key = $val;
      }
    }
    else
    {
      $obj = $array;
    }

    return $obj;
  }


  /**
   * --------------------------------------------------------------------------------------
   * 对象转换为数组
   *
   * @param  Array     $arr   要转换的对象
   *
   * @return Object    数组
   */
  function object2array($object)
  {
    if(is_object($object))
    {
      foreach ($object as $key => $value)
      {
        $array[$key] = $value;
      }
    }
    else
    {
      $array = $object;
    }

    return $array;
  }
