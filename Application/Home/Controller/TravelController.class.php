<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 旅行模块控制器
 *     @english: TravelController.class.php
 *
 * @version: 1.0
 * @desc   : 旅行模块控制器
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-08-26 14:38:11
 */
class TravelController extends HomeController
{

  /**
   * --------------------------------------------------------------------------------------
   * 旅行列表页
   */
  public function index()
  {
    // # 获取旅行列表信息
    // $list = D('Admin/Travel')->getWithWhereTableInfo();

    // # 获取附加信息
    // $attach['category'] = D('Admin/Category')->getWithWhereTableInfo();
    // $attach['label']    = D('Admin/Label')->getWithWhereTableInfo();

    // foreach($list as $k => $v)
    // {
    //   $map['tid'] = $list[$k]['id'];

    //   $category = D('Admin/TravelCategoryRelevance')->getWithWhereTravelCategoryRelInfo($map,'l.*, r.name');
    //   $label    = D('Admin/TravelLabelRelevance')->getWithWhereTravelLabelRelInfo($map,'l.*, r.name');
    //   $picture  = D('Admin/TravelPictureRelevance')->getWithWhereTravelPictureRelInfo($map);

    //   $list[$k]['category'] = $category;
    //   $list[$k]['label']    = $label;
    //   $list[$k]['picture']  = $picture;
    // }

    // $this->assign('list', $list);
    // $this->assign('attach', $attach);

    $this->meta_title = '游记';
    $this->display();
  }


  /**
   * --------------------------------------------------------------------------------------
   * 旅行详情页
   */
  public function detail()
  {
    # 获得旅行编号
    $id = I('get.id', '', 'op_t');

    $where['id'] = $id;
    $list = D('Admin/Travel')->getWithWhereOneTableInfo($where);

    $map['tid'] = $list['id'];

    $category = D('Admin/TravelCategoryRelevance')->getWithWhereTravelCategoryRelInfo($map,'l.*, r.name');
    $label    = D('Admin/TravelLabelRelevance')->getWithWhereTravelLabelRelInfo($map,'l.*, r.name');
    $picture  = D('Admin/TravelPictureRelevance')->getWithWhereTravelPictureRelInfo($map);

    $list['category'] = $category;
    $list['label']    = $label;
    $list['picture']  = $picture;

    foreach($label as $k => $v)
    {
      $data[$k] = $v['lid'];
    }
    $str = implode(',', $data);
    $ids .= $str.', ';
    $ids = trim($ids, ', ');

    unset($where);
    $where['lid'] = array('IN', $ids);
    $ids = D('Admin/TravelLabelRelevance')->getWithWhereTableInfo($where, 'tid');

    foreach($ids as $k => $v)
    {
      if((4 > $k) && ($id != $v['tid']))
      {
        unset($where);
        $where['id'] = $v['tid'];

        $related[$k] = D('Admin/Travel')->getWithWhereOneTableInfo($where);

        $map['tid'] = $related[$k]['id'];

        $category = D('Admin/TravelCategoryRelevance')->getWithWhereTravelCategoryRelInfo($map,'l.*, r.name');
        $label    = D('Admin/TravelLabelRelevance')->getWithWhereTravelLabelRelInfo($map,'l.*, r.name');
        $picture  = D('Admin/TravelPictureRelevance')->getWithWhereTravelPictureRelInfo($map);

        $related[$k]['category'] = $category;
        $related[$k]['label']    = $label;
        $related[$k]['picture']  = $picture;

        $this->assign('related', $related);
      }
    }

    $this->assign('list', $list);

    $this->meta_title = '旅行详情';
    $this->display();
  }
}
