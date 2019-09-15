<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 首页控制器
 *     @english: IndexController.class.php
 *
 * @version: 1.0
 * @desc   : 行为控制器
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-07-24 14:42:11
 */
class IndexController extends HomeController
{

  /**
   * --------------------------------------------------------------------------------------
   * 网站首页
   */
  public function index()
  {
    # TODO:
    record_unique_visitor();

    $where['status'] = 1;
    # 获取项目列表信息
    $picture  = D('Admin/Publicity')->getWithWhereTableInfo($where, 'id, title, picture', 'sort ASC', 1, '', 5);

    $list['picture'] = $picture;

    $where = array();
    $where['display'] = 1;
    # 获取关于我们列表信息
    $id = D('Admin/Service')->getWithWhereTableOneFieldInfo($where, 'id');

    $where = array();
    $where['oid'] = $id;
    $merit = D('Admin/Merit')->getWithWhereTableInfo($where, 'id, title, content, picture', 'id ASC');

    foreach($merit as $v => $xo)
    {
      $xo['content'] = msubstr(op_h($xo['content'], 'tag'), 0 , 50);

      if(($v % 4 == 0) && ($v != 0))
      {
        $x++;
      }

      $list['merit'][$x][$v] = $xo;
    }


    $where = array();
    $where['status'] = 1;
    # 查询其他项目
    $note = D('Admin/Note')->getWithWhereTableInfo($where, 'id, title, content');

    foreach($note as $k => &$vo)
    {
      $img   = strpos($vo['content'], '<img');

      if(false !== $img)
      {
        preg_match('/<[img|IMG].*?src=[\'|\"]([^file].*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/si', $vo['content'], $picture);

        $vo['picture'] = $picture[1];

        $vo['content'] = msubstr(op_h($vo['content'], 'tag'), 0 , 60);
      }
      else
      {
        unset($note[$k]);
      }
    }

    $where = array();
    $where['status'] = 1;
    # 查询其他项目
    $item = D('Admin/Item')->getWithWhereTableInfo($where, 'id, title, content, picture', 'create_time DESC', '1', '', '2');

    foreach($item as &$vo)
    {
      $vo['content'] = msubstr(op_h($vo['content'], 'tag'), 0 , 50);
    }

    $this->assign('item', $item);
    $this->assign('note', $note);
    $this->assign('list', $list);
    $this->meta_title = '首页';
    $this->display();
  }
}
