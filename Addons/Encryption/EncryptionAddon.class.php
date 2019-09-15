<?php
  namespace Addons\Encryption;
  use Common\Controller\Addon;

  /**
   * -------------------------------------------------------------
   * Encryption插件
   */

  class EncryptionAddon extends Addon
  {

    public $info = array(
      'name'=>'Encryption',
      'title'=>'加密算法',
      'description'=>'对系统中的敏感信息进行加密处理',
      'status'=>1,
      'author'=>'张晓飞',
      'version'=>'1.0'
      );

    public $s11111 = '11111';

  
  public $s222222 = '222222';

    public function install()
    {
      return true;
    }

    public function uninstall()
    {
      return true;
    }

    //实现的AdminIndex钩子方法public function AdminIndex($param){}
  }