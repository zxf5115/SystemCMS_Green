<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 项目模块控制器
 *     @english: ItemController.class.php
 *
 * @version: 1.0
 * @desc   : 项目模块控制器
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-08-26 16:57:11
 */
class ItemController extends HomeController
{

  /**
   * --------------------------------------------------------------------------------------
   * 项目列表页
   */
  public function index()
  {
    $set['cid']    = I('get.cid', '', 'op_t');
    $set['lid']    = I('get.lid', '', 'op_t');

    $page          = I('get.i', '', 'op_t');

    # 获取分页参数
    $nowPage = intval($page) > 1 ? intval($page) : 1;

    $where = array();
    $where['status'] = 1;

    # 调用父类数据分页方法 参数:$model ,$nowPage ,$where ,$field
    $result = D('Admin/Item')->getWithWhereTablePagingInfo($nowPage, $where, '*', 'create_time DESC', '9');

    $where = array();
    $where['type'] = 1;
    $where['oid'] = $vo['id'];

    $category = D('Admin/Category')->getWithWhereTableInfo($where, 'id, title', 'id ASC');
    foreach($result['data'] as &$vo)
    {
      $vo['content'] = msubstr(op_h($vo['content'], 'tag'), 0 , 30);

      $where = array();
      $where['type'] = 1;
      $where['oid'] = $vo['id'];

      $cids = get_array_field(D('Admin/CategoryRelation')->getWithWhereTableInfo($where, 'cid', 'id ASC'), 'cid');

      if(!empty($cids))
      {
        $where = array();
        $where['id'] = array('in', $cids);
        $vo['category'] = get_array_field(D('Admin/Category')->getWithWhereTableInfo($where, 'title'), 'title');
      }
    }

// output($result['data']);

    # 模版赋值
    $this->assign('set', $set);
    $this->assign('category', $category);
    $this->assign('list', $result['data']);
    $this->assign('page', $result['show']);
    $this->meta_title = '全部项目';
    $this->display();
  }


  /**
   * --------------------------------------------------------------------------------------
   * 项目详情页
   */
  public function detail()
  {
    # 获得随笔编号
    $id = I('get.id', '', 'op_t');

    $where['id'] = $id;
    $list = D('Admin/Item')->getWithWhereOneTableInfo($where);

    $where = array();
    $where['type'] = 1;
    $where['oid'] = $list['id'];

    $cids = get_array_field(D('Admin/CategoryRelation')->getWithWhereTableInfo($where, 'cid', 'id ASC'), 'cid');
    $lids = get_array_field(D('Admin/LabelRelation')->getWithWhereTableInfo($where, 'lid', 'id ASC'), 'lid');

    if(!empty($cids))
    {
      $where = array();
      $where['id'] = array('in', $cids);
      $list['category'] = get_array_field(D('Admin/Category')->getWithWhereTableInfo($where, 'title'), 'title');
    }

    if(!empty($lids))
    {
      $where['id'] = array('in', $lids);
      $list['label'] = get_array_field(D('Admin/Label')->getWithWhereTableInfo($where, 'title'), 'title');
    }

    $where = array();
    $where['type'] = 1;
    $where['oid'] = $vo['id'];

    $category = D('Admin/Category')->getWithWhereTableInfo($where, 'id, title', 'id ASC');
    $label = D('Admin/Label')->getWithWhereTableInfo($where, 'id, title', 'id ASC');


    $where = array();
    $where['status'] = 1;
    # 查询其他项目
    $item = D('Admin/Item')->getWithWhereTableInfo($where, 'id, title, content, picture', 'create_time DESC', '1', '', '5');

    foreach($item as &$vo)
    {
      $vo['content'] = msubstr(op_h($vo['content'], 'tag'), 0 , 20);
    }

// output($item);

    $this->assign('category', $category);
    $this->assign('label', $label);
    $this->assign('item', $item);
    $this->assign('list', $list);
    $this->meta_title = '项目详情';
    $this->display();
  }
}
