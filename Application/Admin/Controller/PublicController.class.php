<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 后台登录页控制器
 *     @english: PublicController.class.php
 *
 * @version: 1.0
 * @desc   : 管理后台登录
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 14:42:11
 */
use Think\Controller;

class PublicController extends Controller
{

  /**
   * --------------------------------------------------------------------------------------
   * 后台用户登录
   */
  public function login($username = null, $password = null, $verify = null)
  {
    if(IS_POST)
    {
      # 检测验证码
      if(!check_verify($verify))
      {
        // $this->error('验证码输入错误！');
      }

      # 调用 Member 模型的 login 方法，验证用户名、密码
      $uid = D('Member')->login($username, $password);

      if(0 < $uid)
      {
        $this->success('登录成功！', U('Index/index'));
      }
      else
      {
        # 登录失败
        switch($uid)
        {
          # 系统级别禁用
          case -1:
            $error = '用户不存在或被禁用！';
            break;
          case -2:
            $error = '密码错误！';
            break;
          # 0-接口参数错误（调试阶段使用）
          default:
            $error = '未知错误！';
            break;
        }

        $this->error($error);
      }
    }
    else
    {
      if(is_login())
      {
        $this->redirect('Index/index');
      }
      else
      {
        # 读取数据库中的配置
        $config	=	S('DB_CONFIG_DATA');

        if(!$config)
        {
          # 获取配置内容
          $config	=	D('Config')->getWithWhereConfigListInfo();

          # 缓存配置内容
          S('DB_CONFIG_DATA',$config);
        }

        #添加配置
        C($config);

        $this->meta_title = '登录';
        $this->display();
      }
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 退出登录
   */
  public function logout()
  {
    if(is_login())
    {
      D('Member')->logout();

      # 销毁session
      session('[destroy]');

      $this->redirect('login');
    }
    else
    {
      $this->redirect('login');
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 生成验证码
   */
  public function verify()
  {
    $verify = new \Think\Verify();
    $verify->entry(1);
  }
}
