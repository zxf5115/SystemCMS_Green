<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @curlinese: 自定义表单数据过滤
 *     @english: custom_validate.php
 *
 * @version: 1.0
 * @desc   : 过滤表单中不需要的标签信息
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-10-30 10:56:43
 */



/**
 * ---------------------------------------------------------------------------------
 * 系统邮件发送函数
 * @param string $to    接收邮件者邮箱
 * @param string $name  接收邮件者名称
 * @param string $subject 邮件主题
 * @param string $body    邮件内容
 * @param string $attachment 附件列表
 * @return boolean
 */
function think_send_mail($to, $name, $subject = '', $body = '', $image, $attachment = null)
{
  $config = C('MIANSHI_EMAIL');
  require THINK_PATH.'Library/Vendor/Mail/PHPMailer.class.php';

  $mail             = new PHPMailer();    # PHPMailer对象
  $mail->CharSet    = 'UTF-8';    # 设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
  $mail->IsSMTP();   # 设定使用SMTP服务
  $mail->SMTPDebug  = 0;    # 关闭SMTP调试功能 1 = errors and messages  2 = messages only
  $mail->SMTPAuth   = true;  # 启用 SMTP 验证功能
  $mail->SMTPSecure = 'tls';   # 使用非安全协议 （非安全）tls （安全）ssl
  $mail->Host       = $config['SMTP_HOST'];   # SMTP 服务器
  $mail->Port       = $config['SMTP_PORT'];   # SMTP服务器的端口号
  $mail->Username   = $config['SMTP_USER'];   # SMTP服务器用户名
  $mail->Password   = $config['SMTP_PASS'];   # SMTP服务器密码

  $mail->SetFrom($config['FROM_EMAIL'], $config['FROM_NAME']);
  $replyEmail       = $config['REPLY_EMAIL'] ? $config['REPLY_EMAIL'] : $config['FROM_EMAIL'];
  $replyName        = $config['REPLY_NAME']  ? $config['REPLY_NAME']  : $config['FROM_NAME'];
  $mail->AddReplyTo($replyEmail, $replyName);
  $mail->Subject    = $subject;
  $mail->MsgHTML($body);
  $mail->AddAddress($to, $name);
  $mail->AddEmbeddedImage($image[0], 'logo');
  $mail->AddEmbeddedImage($image[1], 'logo2');
  $mail->AddEmbeddedImage($image[2], 'background');
  $mail->AddEmbeddedImage($image[3], 'vcode');

  if(is_array($attachment)) # 添加附件
  {
    $url   = $attachment['url'];
    $title = $attachment['title'];

    # 得到文件后缀
    $exten = substr($url, strrpos($url, '.') + 1);

    # 临时文件路径
    $temp_url = 'Public/Home/temp/temp.'.$exten;

    # 拷贝文件
    if(copy($url, $temp_url))
    {
      # 添加附件
      $mail->AddAttachment($temp_url, $title);
    }
  }

  # 如果发送成功
  if($mail->Send())
  {
    # 删除临时文件
    unlink($temp_url);
    return true;
  }
  else
  {
    return $mail->ErrorInfo;
  }
}

/**
 * ---------------------------------------------------------------------------------
 * 系统邮件发送函数
 * @param string $to    接收邮件者邮箱
 * @param string $name  接收邮件者名称
 * @param string $subject 邮件主题
 * @param string $body    邮件内容
 * @param string $attachment 附件列表
 * @return boolean
 */
function set_mail_content($account, $company, $email, $url)
{
  $html = <<<HTML
    <table style="margin:0 auto;">
      <tbody>
        <tr>
          <td style="height:62px; background-color:#019875; padding:10px 0 0 10px;">
            <a href="http://{$url}" target="_blank">
              <img src="http://www.lagou.com/images/logo_email.png" width="229" height="43" style="border:none;margin-left:10px;"/>
            </a>
          </td>
        </tr>
        <tr style="background-color:#fff;">
          <td style="padding:30px 38px;">
           <div style="margin:0px 0;">
              欢迎使用拉勾互联网招聘
            </div>
            <div style="margin:3px 0;">
              你的登录帐号：{$account}
            </div>
            <div style="margin:0px 0;">
              需要招聘的公司名称：{$company}
            </div>
            <div style="margin:0px 0;">
              接收简历的邮箱地址：{$email}
            </div><br  />
            <div style="margin:0px 0;">
              请点击以下链接验证你的邮箱地址，验证后就可以免费发布职位了！
            </div>
            <div style=" word-break:break-all;word-wrap:break-word;">
              <a href="http://{$url}" target="_blank" style="color:#019875; text-decoration:underline;">{$url}</a>
              <br  />
            </div>
            <div style="margin:20px 0;">
              如果以上链接无法访问，请将该网址复制并粘贴至新的浏览器窗口中。
            </div>
            <div style="margin:0px 0;">
              Uyeah团队
              <br />
              2014-11-04
            </div>
            <div style="height:119px;background:url(http://www.lagou.com/images/weixin/weixin_bg.png) 9px 0 no-repeat;padding-top:30px;padding-left:10px;margin:20px auto 20px auto;width:554px;">
              <div style="width:377px;height:80px;float:left;margin-left:10px;">
                <img src="http://www.lagou.com/images/weixin/weixin_text_one.png" width="377" height="80"  />
              </div>
              <div style="width:122px;height:125px;background:url(http://www.lagou.com/images/weixin/weixin_border.png) left top no-repeat;float:left;margin-left:25px;margin-top:-20px;">
                <img src="http://www.lagou.com:80/qr/qrcode.jpg?userCode=2f6e0dfb407b27fc913345ac85901461&amp;qrSource=sendBindCompanyEmail" width="103" height="103" style="margin:10px;"  />
              </div>
            </div>
            <div style="color:#c5c5c5; font-size:12px; border-top:1px solid #e6e6e6; padding:7px 0; line-height:20px;">
              如果你错误地收到了此电子邮&#x4EF6;，你可以放心忽略此封邮&#x4EF6;，无需进行任何操作
            </div>
            <div style="font-size:12px; color:#999;line-height:20px;border-top:1px solid #e6e6e6;padding:10px 0;">
              如有任何问题，可以与我们联系，我们将尽快为你解答。
              <br />
              Email：admin@uyeah.cn ，
              电话：400-605-9900，QQ:800056379
            </div>
          </td>
        </tr>
        <tr>
          <td style="line-height:30px;text-align:right;font-size:14px;"> 为保证邮箱正常接收，请将service@email.lagou.com添加进你的通讯录</td>
        </tr>
      </tbody>
    </table>
HTML;

  return $html;
}




/**
 * 用常规方式发送邮件。
 */
function send_mail_local($to = '', $subject = '', $body = '', $name = '', $attachment = null)
{
  $from_email = C('MAIL_SMTP_USER');
  $from_name = C('WEB_SITE');
  $reply_email = '';
  $reply_name = '';

  //require_once('./ThinkPHP/Library/Vendor/PHPMailer/phpmailer.class.php');增加命名空间，可以注释掉此行
  $mail = new PHPMailer(); //实例化PHPMailer
  $mail->CharSet = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
  $mail->IsSMTP(); // 设定使用SMTP服务
  $mail->SMTPDebug = 0; // 关闭SMTP调试功能
  // 1 = errors and messages
  // 2 = messages only
  $mail->SMTPAuth = true; // 启用 SMTP 验证功能

  $mail->SMTPSecure = ''; // 使用安全协议
  $mail->Host = C('MAIL_SMTP_HOST'); // SMTP 服务器
  $mail->Port = C('MAIL_SMTP_PORT'); // SMTP服务器的端口号
  $mail->Username = C('MAIL_SMTP_USER'); // SMTP服务器用户名
  $mail->Password = C('MAIL_SMTP_PASS'); // SMTP服务器密码
  $mail->SetFrom($from_email, $from_name);
  $replyEmail = $reply_email ? $reply_email : $from_email;
  $replyName = $reply_name ? $reply_name : $from_name;
  if ($to == '') {
      $to = C('MAIL_SMTP_CE'); //邮件地址为空时，默认使用后台默认邮件测试地址
  }
  if ($name == '') {
      $name = C('WEB_SITE'); //发送者名称为空时，默认使用网站名称
  }
  if ($subject == '') {
      $subject = C('WEB_SITE'); //邮件主题为空时，默认使用网站标题
  }
  if ($body == '') {
      $body = C('WEB_SITE'); //邮件内容为空时，默认使用网站描述
  }
  $mail->AddReplyTo($replyEmail, $replyName);
  $mail->Subject = $subject;
  $mail->MsgHTML($body); //解析
  $mail->AddAddress($to, $name);
  if (is_array($attachment)) { // 添加附件
      foreach ($attachment as $file) {
          is_file($file) && $mail->AddAttachment($file);
      }
  }

  return $mail->Send() ? true : $mail->ErrorInfo; //返回错误信息
}
