<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 关于模块控制器
 *     @english: AboutController.class.php
 *
 * @version: 1.0
 * @desc   : 关于模块控制器
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-08-26 14:38:11
 */
class AboutController extends HomeController
{

  /**
   * --------------------------------------------------------------------------------------
   * 关于列表页
   */
  public function index()
  {
    $where['status'] = 1;
    $where['display'] = 1;

    # 获取关于我们列表信息
    $list = D('Admin/About')->getWithWhereOneTableInfo($where);

    $where = array();
    $where['oid'] = $list['id'];
    $person = D('Admin/Person')->getWithWhereTableInfo($where, 'id, title, content, picture', 'id ASC');

    $i = 0;

    foreach($person as $k => $vo)
    {
      if(($k % 4 == 0) && ($k != 0))
      {
        $i++;
      }

      $list['person'][$i][$k] = $vo;
    }

    $this->assign('list', $list);
    $this->meta_title = '关于';
    $this->display();
  }


  /**
   * --------------------------------------------------------------------------------------
   * 人物信息页
   */
  public function person()
  {
    $id = I('get.id', '', 'op_t');

    $where['id'] = $id;
    $list = D('Admin/Person')->getWithWhereOneTableInfo($where, 'id, title, content, picture');

    $this->assign('list', $list);
    $this->meta_title = '人物信息';
    $this->display();
  }
}
