  <?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 前台菜单控制器
 *     @english: ChannelController.class.php
 *
 * @version: 1.0
 * @desc   : 配置前台菜单内容
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 14:42:11
 */
class ContentController extends AdminController
{

  /**
   * --------------------------------------------------------------------------------------
   * 前台菜单列表
   */
  public function index()
  {
    header('Location:'.U('Admin/Client/index'));
    exit;
  }
}
