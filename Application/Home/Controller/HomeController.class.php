<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 公共控制器
 *     @english: HomeController.class.php
 *
 * @version: 1.0
 * @desc   : 全部控制器父类
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2017-02-16 10:47:11
 */
use Think\Controller;

class HomeController extends Controller
{

  /**
   * --------------------------------------------------------------------------------------
   * 后台控制器初始化
   */
  protected function _initialize()
  {
    # 读取数据库中的配置
    $config = S('DB_CONFIG_DATA');

    if(!$config)
    {
      # 如果无缓存，查询数据库
      $config	=	D('Admin/Config')->getWithWhereConfigListInfo();

      # 更新缓存
      S('DB_CONFIG_DATA',$config);
    }

    # 添加配置
    C($config);

    # 当前访问路径
    $rule  = strtolower(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME);

    # 如果无缓存，查询数据库
    $channel = $this->getHomeMenus();

    foreach($channel as $k => $vo)
    {
      if(strpos($rule, strtolower($vo['url'])))
      {
        $channel[$k]['active'] = 'active';
      }
      else
      {
        $channel[$k]['active'] = '';
      }
    }

    $this->assign('channel', $channel);
  }


  /**
   * --------------------------------------------------------------------------------------
   * 获取前台菜单
   */
  final public function getHomeMenus($controller=CONTROLLER_NAME)
  {
    $menus = session('HOME_MENU_LIST'.$controller);

    # 如果无缓存，查询数据库
    if(empty($menus))
    {
      $where['status'] = 1;
      $where['pid'] = 0;
      $field = 'id, pid, title, url';

      $menus = D('Admin/Channel')->getWithWhereTableInfo($where, $field, 'id ASC');

      foreach($menus as $k => $vo)
      {
        $where['pid'] = $vo['id'];
        $menus[$k]['child'] = D('Admin/Channel')->getWithWhereTableInfo($where, $field, 'id ASC');
      }

      session('HOME_MENU_LIST'.$controller, $menus);
    }

    return $menus;
  }
}
