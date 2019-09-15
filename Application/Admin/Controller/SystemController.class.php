<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 配置控制器
 *     @english: ConfigController.class.php
 *
 * @version: 1.0
 * @desc   : 配置系统配置信息
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 14:42:11
 */
class SystemController extends AdminController
{

  /**
   * --------------------------------------------------------------------------------------
   * 配置管理
   */
  public function index()
  {
    header('Location:index.php?s=/admin/menu/index.html');
  }


  /**
   * --------------------------------------------------------------------------------------
   * 帮助中心
   */
  public function help()
  {
    $this->meta_title = '帮助中心';
    $this->display();
  }
}
