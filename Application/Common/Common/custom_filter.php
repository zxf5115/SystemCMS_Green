<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @curlinese: 自定义数据过滤
 *     @english: custom_validate.php
 *
 * @version: 1.0
 * @desc   : 过滤不需要的标签信息
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-10-30 10:56:43
 */


  /**
   * ------------------------------------------------------------------------------------------
   * 用于过滤标签，输出没有html的干净的文本
   *
   * @param string $text      需要过滤的内容
   * @param string $exception 添加例外html标签
   *
   * @return string 处理后内容
   */
  function op_t($text, $exception = '<p>&nbsp;')
  {
    $text = nl2br($text);
    $text = real_strip_tags($text, $exception);
    $text = addslashes($text);
    $text = trim($text);

    return $text;
  }

  /**
   * ------------------------------------------------------------------------------------------
   * 函数用于过滤富文本编辑内容
   *
   * @param string $text 待过滤的字符串
   * @param string $type 保留的标签格式
   *
   * @return string 处理后内容
   */
  function op_ue($text, $type = 'all')
  {
    # 专题等全HTML格式
    $all_tags = $link_tags . $image_tags . $form_tags . $html_tags . '<!DOCTYPE><meta><html><head><title><body><base><basefont><script><noscript><applet><object><param><style><frame><frameset><noframes><iframe><ul><ol><li><dl><dd><dt><table><caption><td><th><tr><thead><tbody><tfoot><col><colgroup><div><span><object><embed><param><form><input><textarea><button><select><optgroup><option><label><fieldset><legend><p><br><hr><a><img><map><area><pre><code><q><blockquote><acronym><cite><ins><del><center><strike><i><b><u><s><em><strong><font><big><small><sup><sub><bdo><h1><h2><h3><h4><h5><h6><img><a>';

    # 过滤标签
    $text = real_strip_tags($text, ${$type . '_tags'});

    return $text;
  }

  /**
   * ------------------------------------------------------------------------------------------
   * 函数用于过滤不安全的html标签，输出安全的html
   *
   * @param string $text 待过滤的字符串
   * @param string $type 保留的标签格式
   *
   * @return string 处理后内容
   */
  function op_h($text, $type = 'html')
  {
    # 无标签格式
    $text_tags = '';
    # 只保留链接
    $link_tags = '<a>';
    # 只保留图片
    $image_tags = '<img>';
    # 只存在字体样式
    $font_tags = '<i><b><u><s><em><strong><font><big><small><sup><sub><bdo><h1><h2><h3><h4><h5><h6>';
    # 标题摘要基本格式
    $base_tags = $font_tags . '<p><br><hr><a><img><map><area><pre><code><q><blockquote><acronym><cite><ins><del><center><strike>';
    # 兼容Form格式
    $form_tags = $base_tags . '<form><input><textarea><button><select><optgroup><option><label><fieldset><legend>';
    # 内容等允许HTML的格式
    $html_tags = $base_tags . '<ul><ol><li><dl><dd><dt><table><caption><td><th><tr><thead><tbody><tfoot><col><colgroup><div><span><object><embed><param>';
    # 专题等全HTML格式
    $all_tags = $form_tags . $html_tags . '<!DOCTYPE><meta><html><head><title><body><base><basefont><script><noscript><applet><object><param><style><frame><frameset><noframes><iframe>';

    # 过滤标签
    $text = real_strip_tags($text, ${$type . '_tags'});

    #  过滤攻击代码
    if ($type != 'all')
    {
      #  过滤危险的属性，如：过滤on事件lang js
      while (preg_match('/(<[^><]+)(ondblclick|onclick|onload|onerror|unload|onmouseover|onmouseup|onmouseout|onmousedown|onkeydown|onkeypress|onkeyup|onblur|onchange|onfocus|action|background|codebase|dynsrc|lowsrc)([^><]*)/i', $text, $mat))
      {
        $text = str_ireplace($mat[0], $mat[1] . $mat[3], $text);
      }

      while (preg_match('/(<[^><]+)(window\.|javascript:|js:|about:|file:|document\.|vbs:|cookie)([^><]*)/i', $text, $mat))
      {
        $text = str_ireplace($mat[0], $mat[1] . $mat[3], $text);
      }
    }

    return $text;
  }


  /**
   * ------------------------------------------------------------------------------------------
   * h函数用于过滤不安全的html标签，输出安全的html
   *
   * @param string $text 待过滤的字符串
   * @param string $type 保留的标签格式
   *
   * @return string 处理后内容
   */
  function real_strip_tags($str, $allowable_tags = "")
  {
    $str = html_entity_decode($str, ENT_QUOTES, 'UTF-8');
    return strip_tags($str, $allowable_tags);
  }



  /**
   * ------------------------------------------------------------------------------------------
   * 输出安全的html
   *
   * @param string $text 待过滤的字符串
   * @param string $tags 保留的标签格式
   *
   * @return string 处理后内容
   */
  function h($text, $tags = null)
  {
    $text = trim($text);

    # 完全过滤注释
    $text = preg_replace('/<!--?.*-->/', '', $text);

    # 完全过滤动态代码
    $text = preg_replace('/<\?|\?'.'>/', '', $text);

    # 完全过滤js
    $text = preg_replace('/<script?.*\/script>/', '', $text);

    $text = str_replace('[', '&#091;', $text);
    $text = str_replace(']', '&#093;', $text);
    $text = str_replace('|', '&#124;', $text);

    # 过滤换行符
    $text = preg_replace('/\r?\n/','',$text);

    $text = preg_replace('/<br(\s\/)?'.'>/i','[br]',$text);
    $text = preg_replace('/<p(\s\/)?'.'>/i','[br]',$text);
    $text = preg_replace('/(\[br\]\s*){10,}/i','[br]',$text);

    # 过滤危险的属性，如：过滤on事件lang js
    while(preg_match('/(<[^><]+)( lang|on|action|background|codebase|dynsrc|lowsrc)[^><]+/i', $text, $mat))
    {
      $text = str_replace($mat[0], $mat[1], $text);
    }

    while(preg_match('/(<[^><]+)(window\.|javascript:|js:|about:|file:|document\.|vbs:|cookie)([^><]*)/i', $text, $mat))
    {
      $text = str_replace($mat[0], $mat[1].$mat[3], $text);
    }

    if(empty($tags))
    {
      $tags = 'table|td|th|tr|i|b|u|strong|img|p|br|div|strong|em|ul|ol|li|dl|dd|dt|a';
    }

    # 允许的HTML标签
    $text = preg_replace('/<('.$tags.')( [^><\[\]]*)>/i', '[\1\2]', $text);
    $text = preg_replace('/<\/('.$tags.')>/Ui', '[/\1]', $text);

    # 过滤多余html
    $text = preg_replace('/<\/?(html|head|meta|link|base|basefont|body|bgsound|title|style|script|form|iframe|frame|frameset|applet|id|ilayer|layer|name|script|style|xml)[^><]*>/i', '', $text);

    # 过滤合法的html标签
    while(preg_match('/<([a-z]+)[^><\[\]]*>[^><]*<\/\1>/i', $text, $mat))
    {
      $text = str_replace($mat[0], str_replace('>',']', str_replace('<','[',$mat[0])), $text);
    }

    # 转换引号
    while(preg_match('/(\[[^\[\]]*=\s*)(\"|\')([^\2=\[\]]+)\2([^\[\]]*\])/i', $text, $mat))
    {
      $text = str_replace($mat[0], $mat[1].'|'.$mat[3].'|'.$mat[4], $text);
    }

    # 过滤错误的单个引号
    while(preg_match('/\[[^\[\]]*(\"|\')[^\[\]]*\]/i', $text, $mat))
    {
      $text=str_replace($mat[0], str_replace($mat[1], '', $mat[0]), $text);
    }

    # 转换其它所有不合法的 < >
    $text = str_replace('<', '&lt;', $text);
    $text = str_replace('>', '&gt;', $text);
    $text = str_replace('"', '&quot;', $text);

     # 反转换
    $text = str_replace('[', '<', $text);
    $text = str_replace(']', '>', $text);
    $text = str_replace('|', '"', $text);

    # 过滤多余空格
    $text = str_replace('  ', ' ', $text);

    return $text;
  }



  /**
   * ------------------------------------------------------------------------------------------
   * UBB标记
   *
   * @param string $text 待匹配的字符串
   *
   * @return string 使用UBB标记后的内容
   */
  function ubb($text)
  {
    $text = trim($text);

    # $text = htmlspecialchars($text);
    $text = preg_replace("/\\t/is", "  ", $text);
    $text = preg_replace("/\[h1\](.+?)\[\/h1\]/is", "<h1>\\1</h1>",$text);
    $text = preg_replace("/\[h2\](.+?)\[\/h2\]/is", "<h2>\\1</h2>",$text);
    $text = preg_replace("/\[h3\](.+?)\[\/h3\]/is", "<h3>\\1</h3>",$text);
    $text = preg_replace("/\[h4\](.+?)\[\/h4\]/is", "<h4>\\1</h4>",$text);
    $text = preg_replace("/\[h5\](.+?)\[\/h5\]/is", "<h5>\\1</h5>",$text);
    $text = preg_replace("/\[h6\](.+?)\[\/h6\]/is", "<h6>\\1</h6>",$text);
    $text = preg_replace("/\[separator\]/is", "", $text);
    $text = preg_replace("/\[center\](.+?)\[\/center\]/is", "<center>\\1</center>", $text);
    $text = preg_replace("/\[url = http:\/\/([^\[]*)\](.+?)\[\/url\]/is", "<a href = \"http:# \\1\" target = _blank>\\2</a>", $text);
    $text = preg_replace("/\[url = ([^\[]*)\](.+?)\[\/url\]/is", "<a href = \"http:# \\1\" target = _blank>\\2</a>", $text);
    $text = preg_replace("/\[url\]http:\/\/([^\[]*)\[\/url\]/is", "<a href = \"http:# \\1\" target = _blank>\\1</a>", $text);
    $text = preg_replace("/\[url\]([^\[]*)\[\/url\]/is", "<a href = \"\\1\" target = _blank>\\1</a>", $text);
    $text = preg_replace("/\[img\](.+?)\[\/img\]/is", "<img src = \\1>", $text);
    $text = preg_replace("/\[color = (.+?)\](.+?)\[\/color\]/is", "<font color = \\1>\\2</font>", $text);
    $text = preg_replace("/\[size = (.+?)\](.+?)\[\/size\]/is", "<font size = \\1>\\2</font>", $text);
    $text = preg_replace("/\[sup\](.+?)\[\/sup\]/is", "<sup>\\1</sup>", $text);
    $text = preg_replace("/\[sub\](.+?)\[\/sub\]/is", "<sub>\\1</sub>", $text);
    $text = preg_replace("/\[pre\](.+?)\[\/pre\]/is", "<pre>\\1</pre>", $text);
    $text = preg_replace("/\[email\](.+?)\[\/email\]/is", "<a href = 'mailto:\\1'>\\1</a>", $text);
    $text = preg_replace("/\[colorTxt\](.+?)\[\/colorTxt\]/eis", "color_txt('\\1')", $text);
    $text = preg_replace("/\[emot\](.+?)\[\/emot\]/eis", "emot('\\1')", $text);
    $text = preg_replace("/\[i\](.+?)\[\/i\]/is", "<i>\\1</i>", $text);
    $text = preg_replace("/\[u\](.+?)\[\/u\]/is", "<u>\\1</u>", $text);
    $text = preg_replace("/\[b\](.+?)\[\/b\]/is", "<b>\\1</b>", $text);
    $text = preg_replace("/\[quote\](.+?)\[\/quote\]/is", " <div class = 'quote'><h5>引用:</h5><blockquote>\\1</blockquote></div>", $text);
    $text = preg_replace("/\[code\](.+?)\[\/code\]/eis", "highlight_code('\\1')", $text);
    $text = preg_replace("/\[php\](.+?)\[\/php\]/eis", "highlight_code('\\1')", $text);
    $text = preg_replace("/\[sig\](.+?)\[\/sig\]/is", "<div class = 'sign'>\\1</div>", $text);
    $text = preg_replace("/\\n/is", "<br/>", $text);

    return $text;
  }



  /**
   * ------------------------------------------------------------------------------------------
   * 代码加亮
   *
   * @param String  $str  要高亮显示的字符串 或者 文件名
   * @param Boolean $show 是否输出
   *
   * @return String|Boolean 输出内容|成功失败
   */
  function highlight_code($str, $show = false)
  {
    if(file_exists($str))
    {
      $str = file_get_contents($str);
    }

    $str = stripslashes(trim($str));

    // The highlight string function encodes and highlights
    // brackets so we need them to start raw
    $str = str_replace(array('&lt;', '&gt;'), array('<', '>'), $str);

    // Replace any existing PHP tags to temporary markers so they don't accidentally
    // break the string out of PHP, and thus, thwart the highlighting.
    $str = str_replace(array('&lt;?php', '?&gt;',  '\\'), array('phptagopen', 'phptagclose', 'backslashtmp'), $str);

    // The highlight_string function requires that the text be surrounded
    // by PHP tags.  Since we don't know if A) the submitted text has PHP tags,
    // or B) whether the PHP tags enclose the entire string, we will add our
    // own PHP tags around the string along with some markers to make replacement easier later
    $str = '<?php //tempstart'."\n".$str.'//tempend ?>'; // <?

    // All the magic happens here, baby!
    $str = highlight_string($str, TRUE);

    // Prior to PHP 5, the highlight function used icky font tags
    // so we'll replace them with span tags.
    if(abs(phpversion()) < 5)
    {
      $str = str_replace(array('<font ', '</font>'), array('<span ', '</span>'), $str);
      $str = preg_replace('#color="(.*?)"#', 'style="color: \\1"', $str);
    }

    // Remove our artificially added PHP
    $str = preg_replace("#\<code\>.+?//tempstart\<br />\</span\>#is", "<code>\n", $str);
    $str = preg_replace("#\<code\>.+?//tempstart\<br />#is", "<code>\n", $str);
    $str = preg_replace("#//tempend.+#is", "</span>\n</code>", $str);

    // Replace our markers back to PHP tags.
    $str = str_replace(array('phptagopen', 'phptagclose', 'backslashtmp'), array('&lt;?php', '?&gt;', '\\'), $str); //<?
    $line   =   explode("<br />", rtrim(ltrim($str,'<code>'),'</code>'));
    $result =   '<div class="code"><ol>';

    foreach($line as $key=>$val)
    {
      $result .=  '<li>'.$val.'</li>';
    }

    $result .=  '</ol></div>';
    $result = str_replace("\n", "", $result);

    if($show!== false)
    {
      echo($result);
    }
    else
    {
      return $result;
    }
  }



  /**
   * ------------------------------------------------------------------------------------------
   * 代码加亮
   *
   * @param String  $str  要高亮显示的字符串 或者 文件名
   * @param Boolean $show 是否输出
   *
   * @return String|Boolean 输出内容|成功失败
   */
  function remove_xss($val)
  {
    # remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
    # this prevents some character re-spacing such as <java\0script>
    # note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
    $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);

    # straight replacements, the user should never need these since they're normal characters
    # this prevents like <IMG SRC=@avascript:alert('XSS')>
    $search = 'abcdefghijklmnopqrstuvwxyz';
    $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $search .= '1234567890!@#$%^&*()';
    $search .= '~`";:?+/={}[]-_|\'\\';

    for ($i = 0; $i < strlen($search); $i++)
    {
      # ;? matches the ;, which is optional
      # 0{0,7} matches any padded zeros, which are optional and go up to 8 chars
      # @ @ search for the hex values
      $val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val);

      # @ @ 0{0,7} matches '0' zero to seven times
      $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val);
    }

    # now the only remaining whitespace attacks are \t, \n, and \r
    $ra1 = array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');

    $ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');

    $ra = array_merge($ra1, $ra2);

    # keep replacing as long as the previous round replaced something
    $found = true;

    while($found == true)
    {
      $val_before = $val;

      for ($i = 0; $i < sizeof($ra); $i++)
      {
        $pattern = '/';

        for($j = 0; $j < strlen($ra[$i]); $j++)
        {
          if($j > 0)
          {
            $pattern .= '(';
            $pattern .= '(&#[xX]0{0,8}([9ab]);)';
            $pattern .= '|';
            $pattern .= '|(&#0{0,8}([9|10|13]);)';
            $pattern .= ')*';
          }

          $pattern .= $ra[$i][$j];
        }

        $pattern .= '/i';

        # add in <> to nerf the tag
        $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2);

        # filter out the hex tags
        $val = preg_replace($pattern, $replacement, $val);

        if ($val_before == $val)
        {
          # no replacements were made, so exit the loop
          $found = false;
        }
      }
    }

    return $val;
  }


  /**
   * --------------------------------------------------------------------------------------
   * 判断是否存在指定html标签
   *
   * @param String $content 内容字符串
   * @param String $tags 需要解析的字符串
   *
   * @return String URL地址的参数数据
   */
  function check_html_tags($content, $tags = array())
  {
    $tags = is_array($tags) ? $tags : array($tags);

    if(empty($tags))
    {
      $tags = array('script','!DOCTYPE','meta','html','head','title','body','base','basefont','noscript','applet','object','param','style','frame','frameset','noframes','iframe');
    }

    foreach($tags as $v)
    {
      $res = strpos($content, '<'.$v);

      if(!is_bool($res))
      {
        return true;
      }
    }

    return false;
  }



  /**
   * --------------------------------------------------------------------------------------
   * 对图片src进行安全过滤
   *
   * @param String $content 待过滤图片地址
   *
   * @return String 过滤后图片地址
   */
  function filter_image($content)
  {
    # 匹配所有的图片
    preg_match_all("/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/", $content, $arr);

    if($arr[1])
    {
      foreach($arr[1] as $v)
      {
        $check = check_html_tags($v);

        if(!$check)
        {
          $content = str_replace($v, '', $content);
        }
      }
    }

    return $content;
  }



  /**
   * --------------------------------------------------------------------------------------
   * 对图片src进行安全过滤
   *
   * @param String $content 待过滤图片地址
   *
   * @return String 过滤后图片地址
   */
  function filter_image_base64($content)
  {
    # 匹配base64编码
    preg_match_all("/data:.*?,(.*?)\"/", $content, $arr);

    if($arr[1])
    {
      foreach($arr[1] as $v)
      {
        $base64_decode = base64_decode($v);
        $check = check_html_tags($base64_decode);

        if($check)
        {
          $content = str_replace($v,'',$content);
        }
      }
    }

    return $content;
  }



