<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 随笔模块控制器
 *     @english: NoteController.class.php
 *
 * @version: 1.0
 * @desc   : 随笔模块控制器
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-08-26 12:09:11
 */
class NoteController extends HomeController
{

  /**
   * --------------------------------------------------------------------------------------
   * 随笔列表页
   */
  public function index()
  {
    $set['search'] = I('get.search', '', 'op_t');
    $set['cid']    = I('get.cid', '', 'op_t');
    $set['lid']    = I('get.lid', '', 'op_t');

    $page          = I('get.i', '', 'op_t');

    # 获取分页参数
    $nowPage = intval($page) > 1 ? intval($page) : 1;

    $where = array();
    $where['status'] = 1;

    # 按管理员搜索
    if(!empty($set['search']))
    {
      $search = trim($set['search']);
      $where['title'] = array('like','%'.$search.'%');
    }
    # 按管理员搜索
    if(!empty($set['cid']))
    {
      $cid = trim($set['cid']);

      $map = array();
      $map['status'] = 1;
      $map['type']   = 2;
      $map['cid']    = $cid;

      $cids = get_array_field(D('Admin/CategoryRelation')->getWithWhereTableInfo($map, 'oid', 'id ASC'), 'oid');

      $where['id'] = array('in', $cids);
    }
    # 按管理员搜索
    if(!empty($set['lid']))
    {
      $lid = trim($set['lid']);

      $map = array();
      $map['status'] = 1;
      $map['type']   = 2;
      $map['lid']    = $lid;

      $lids = get_array_field(D('Admin/LabelRelation')->getWithWhereTableInfo($map, 'oid', 'id ASC'), 'oid');

      $where['id'] = array('in', $lids);
    }

    # 调用父类数据分页方法 参数:$model ,$nowPage ,$where ,$field
    $result = D('Admin/Note')->getWithWhereTablePagingInfo($nowPage, $where);

    $where = array();
    $where['type'] = 2;
    $where['oid'] = $vo['id'];

    $category = D('Admin/Category')->getWithWhereTableInfo($where, 'id, title', 'id ASC');
    $label = D('Admin/Label')->getWithWhereTableInfo($where, 'id, title', 'id ASC');

    foreach($result['data'] as &$vo)
    {
      $img   = strpos($vo['content'], '<img');
      $embed = strpos($vo['content'], '<embed');

      if(false !== $img)
      {
        $vo['icon'] = 'camera';

        preg_match('/<[img|IMG].*?src=[\'|\"]([^file].*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/si', $vo['content'], $picture);

        $vo['picture'] = $picture[1];
      }
      else if(false !== $embed)
      {
        $vo['icon'] = 'play';
      }
      else
      {
        $vo['icon'] = 'file';
      }

      $vo['content'] = msubstr(op_h($vo['content'], 'tag'), 0 , 30);

      $where = array();
      $where['type'] = 2;
      $where['oid'] = $vo['id'];

      $cids = get_array_field(D('Admin/CategoryRelation')->getWithWhereTableInfo($where, 'cid', 'id ASC'), 'cid');
      $lids = get_array_field(D('Admin/LabelRelation')->getWithWhereTableInfo($where, 'lid', 'id ASC'), 'lid');

      if(!empty($cids))
      {
        $where = array();
        $where['id'] = array('in', $cids);
        $vo['category'] = get_array_field(D('Admin/Category')->getWithWhereTableInfo($where, 'title'), 'title');
      }

      if(!empty($lids))
      {
        $where['id'] = array('in', $lids);
        $vo['label'] = get_array_field(D('Admin/Label')->getWithWhereTableInfo($where, 'title'), 'title');
      }
    }

// output($result['data']);

    # 模版赋值
    $this->assign('set', $set);
    $this->assign('category', $category);
    $this->assign('label', $label);
    $this->assign('list', $result['data']);
    $this->assign('page', $result['show']);
    $this->meta_title = '随笔';
    $this->display();
  }


  /**
   * --------------------------------------------------------------------------------------
   * 随笔详情页
   */
  public function detail()
  {
    # 获得随笔编号
    $id = I('get.id', '', 'op_t');

    $where['id'] = $id;
    $list = D('Admin/Note')->getWithWhereOneTableInfo($where);

    $where = array();
    $where['type'] = 2;
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

    $img   = strpos($list['content'], '<img');
    $embed = strpos($list['content'], '<embed');

    if(false !== $img)
    {
      $list['icon'] = 'camera';

      preg_match('/<[img|IMG].*?src=[\'|\"]([^file].*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/si', $list['content'], $picture);

      $list['picture'] = $picture[1];
    }
    else if(false !== $embed)
    {
      $list['icon'] = 'play';
    }
    else
    {
      $list['icon'] = 'file';
    }

    $where = array();
    $where['type'] = 2;
    $where['oid'] = $vo['id'];

    $category = D('Admin/Category')->getWithWhereTableInfo($where, 'id, title', 'id ASC');
    $label = D('Admin/Label')->getWithWhereTableInfo($where, 'id, title', 'id ASC');

    $where = array();
    $where['status'] = 1;
    $where['nid'] = $id;
    $comment = D('Admin/NoteComment')->getWithWhereTableInfo($where, 'id, nid, content, reply_id, by_reply_id, create_time, founder', 'id ASC');

    $this->assign('comment', $comment);
    $this->assign('category', $category);
    $this->assign('label', $label);
    $this->assign('list', $list);
    $this->meta_title = '随笔详情';
    $this->display();
  }


  public function comment()
  {
    if(IS_POST)
    {
      $post = I('post.', '', 'op_t');

      # 获取数据对象
      $result = D('Admin/NoteComment')->doSaveFromDataAction($post);

      # 此处为自动验证错误提示信息
      if(1 == $result['flag'])
      {
        # 获得当前URL地址的参数数据
        $url = get_current_url_data();

        $this->success('提交成功', U($url));
      }
      else
      {
        $this->error($result['msg']);
      }
    }
  }
}
