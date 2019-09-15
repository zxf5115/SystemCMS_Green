<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 服务模块控制器
 *     @english: TravelController.class.php
 *
 * @version: 1.0
 * @desc   : 服务模块控制器
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-08-26 14:38:11
 */
class ServiceController extends HomeController
{

  /**
   * --------------------------------------------------------------------------------------
   * 服务列表页
   */
  public function index()
  {
    $where['status'] = 1;
    $where['display'] = 1;

    # 获取关于我们列表信息
    $list = D('Admin/Service')->getWithWhereOneTableInfo($where);

    $where = array();
    $where['oid'] = $list['id'];
    $merit = D('Admin/Merit')->getWithWhereTableInfo($where, 'id, title, content, picture', 'id ASC');
// dump($merit);exit;
    $x = 0;

    foreach($merit as $v => $xo)
    {
      $xo['content'] = msubstr(op_h($xo['content'], 'tag'), 0 , 30);

      if(($v % 3 == 0) && ($v != 0))
      {
        $x++;
      }

      $list['merit'][$x][$v] = $xo;
    }
// dump($list['merit']);exit;
    $where = array();
    $where['oid'] = $list['id'];
    $client = D('Admin/Client')->getWithWhereTableInfo($where, 'id, title, url, picture', 'id ASC');

    $i = 0;

    foreach($client as $k => $vo)
    {
      if(($k % 4 == 0) && ($k != 0))
      {
        $i++;
      }

      $list['client'][$i][$k] = $vo;
    }

    $this->assign('list', $list);
    $this->meta_title = '服务';
    $this->display();
  }

  /**
   * --------------------------------------------------------------------------------------
   * 服务信息页
   */
  public function merit()
  {
    $id = I('get.id', '', 'op_t');

    $where['id'] = $id;
    $list = D('Admin/Merit')->getWithWhereOneTableInfo($where, 'id, title, content, picture');

    $this->assign('list', $list);
    $this->meta_title = '服务信息';
    $this->display();
  }
}
