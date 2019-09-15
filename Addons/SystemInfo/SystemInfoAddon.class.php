<?php
namespace Addons\SystemInfo;
use Common\Controller\Addon;


/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 系统环境信息插件文件
 *     @english: SystemInfoAddon.class.php
 *
 * @version: 1.0
 * @desc   : 获得系统环境信息
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-12 13:40:21
 */
class SystemInfoAddon extends Addon
{

  public $info = array(
    'name'        => 'SystemInfo',
    'title'       => '系统环境信息',
    'description' => '用于显示一些服务器的信息',
    'status'      => 1,
    'author'      => 'Zhang XiaoFei',
    'version'     => '1.0'
  );


  /**
   * --------------------------------------------------------------------------------------
   * 安装
   */
  public function install()
  {
    return true;
  }


  /**
   * --------------------------------------------------------------------------------------
   * 卸载
   */
  public function uninstall()
  {
    return true;
  }

  
  /**
   * --------------------------------------------------------------------------------------
   * 简历预览页 实现的AdminIndex钩子方法
   */
  public function AdminIndex($param)
  {
    $config = $this->getConfig();

    $this->assign('addons_config', $config);
    if($config['display'])
    {
      $this->display('widget');
    }
  }
}