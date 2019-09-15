<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 首页控制器
 *     @english: IndexController.class.php
 *
 * @version: 1.0
 * @desc   : 控制后台首页显示信息
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 13:36:21
 */
class IndexController extends AdminController
{
  /**
   * --------------------------------------------------------------------------------------
   * 系统信息
   */
  public function index()
  {
    # 记录PV
    D('PV')->doSavePvDataAction();
    # 记录UV
    D('UV')->doSaveUvDataAction();

    # 昨天活跃量统计
    $activeCount   = D('Active')->getWithWhereActiveCount();
    # 查询用户总数
    $userCount     = D('Member')->getWithWhereUserCount();
    # 查询昨日注册用户数量
    $registerCount = D('Member')->getWithWhereUserRegisterCount();
    # 查询昨日UV数量
    $uv            = D('UV')->getWithWhereUvCount();
    # 查询昨日PV数量
    $pv            = D('PV')->getWithWherePvCount();
    # 内存信息
    $sysinfo        = $this->getSystemInfo();

    $list['activeCount']  = $activeCount;
    $list['userCount']     = $userCount;
    $list['registerCount'] = $registerCount;
    $list['sysinfo']        = $sysinfo;

    $list['uv'] = $uv;
    $list['pv'] = $pv;

    $this->assign('list', $list);
    $this->meta_title = '控制台';
    $this->display();
  }


  /**
   * --------------------------------------------------------------------------------------
   * 服务器信息
   */
  private function getSystemInfo()
  {
    import("Admin.Plugin.SysinfoPlugin");

    $sys = new SysinfoPlugin();
    $sysinfo = $sys->getinfo();

    return $sysinfo;
  }
}
