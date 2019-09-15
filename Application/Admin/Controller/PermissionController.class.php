<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 权限控制器
 *     @english: PermissionController.class.php
 *
 * @version: 1.0
 * @desc   : 权限控制器
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 14:42:11
 */
class PermissionController extends AdminController
{

  /**
   * --------------------------------------------------------------------------------------
   * 权限不足
   */
  public function index()
  {
    $this->assign('data', '未授权访问');

    $this->meta_title = '权限不足';
    $this->display();
  }
}
