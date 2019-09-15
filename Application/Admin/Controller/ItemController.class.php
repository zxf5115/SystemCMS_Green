<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 项目控制器
 *     @english: ItemController.class.php
 *
 * @version: 1.0
 * @desc   : 项目控制器
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2016-05-12 14:42:11
 */
class ItemController extends AdminController
{

  /**
   * --------------------------------------------------------------------------------------
   * 项目列表
   */
  public function index()
  {
    $set['start_time'] = I('get.start_time', '', 'op_t');
    $set['end_time']   = I('get.end_time', '', 'op_t');
    $set['status']     = I('get.status', '', 'op_t');
    $set['search']     = I('get.search', '', 'op_t');
    $page              = I('get.i', '', 'op_t');

    # 获取分页参数
    $nowPage = intval($page) > 1 ? intval($page) : 1;

    # 获取搜索参数
    $set = isset($set) ? $set : array();

    $where = array();

    # 按时间搜索
    if(!empty($set['start_time']) && !empty($set['end_time']))
    {
      $start_time = strtotime($set['start_time'].'00:00:00');
      $end_time = strtotime($set['end_time'].'23:59:59');
      $where['create_time'] = array(array('gt', $start_time), array('lt', $end_time));
    }

    # 按管理员搜索
    if(!empty($set['search']))
    {
      $search = trim($set['search']);
      $where['title'] = array('like','%'.$search.'%');
    }

    # 按状态搜索
    if(!empty($set['status']))
    {
      $status = $set['status'];

      if($set['status'] == 3)
      {
        $status = 0;
      }

      $where['status'] = array('eq', $status);
    }

    # 调用父类数据分页方法 参数:$model ,$nowPage ,$where ,$field
    $result = D('Item')->getWithWhereTablePagingInfo($nowPage, $where, '*', 'create_time DESC');

    foreach($result['data'] as &$vo)
    {
      if(!empty($vo))
      {
        $where = array();
        $where['type'] = 1;
        $where['oid'] = $vo['id'];

        $cids = get_array_field(D('CategoryRelation')->getWithWhereTableInfo($where, 'cid', 'id ASC'), 'cid');
        $lids = get_array_field(D('LabelRelation')->getWithWhereTableInfo($where, 'lid', 'id ASC'), 'lid');

        if(!empty($cids))
        {
          $where = array();
          $where['id'] = array('in', $cids);
          $vo['category'] = get_array_field(D('Category')->getWithWhereTableInfo($where, 'title'), 'title');
        }

        if(!empty($lids))
        {
          $where['id'] = array('in', $lids);
          $vo['label'] = get_array_field(D('Label')->getWithWhereTableInfo($where, 'title'), 'title');
        }
      }
    }

    D('Item')->getWithWhereFormatDataInfo($result['data']);

    # 模版赋值
    $this->assign('set', $set);
    $this->assign('list', $result['data']);
    $this->assign('page', $result['show']);
    $this->meta_title = '项目列表';
    $this->list_title = '';
    $this->display();
  }


  /**
   * --------------------------------------------------------------------------------------
   * 新增项目
   */
  public function add()
  {
    if(IS_POST)
    {
      $post = I('post.', '', 'op_ue');

      $cids = $post['cid'];
      $lids = $post['lid'];

      remove_array_field($post, array('cid', 'lid'));

      # 获取数据对象
      $result = D('Item')->doSaveFromDataAction($post);

      # 此处为自动验证错误提示信息
      if(1 == $result['flag'])
      {
        if(!empty($cids))
        {
          $data = array();

          foreach($cids as $k => $vo)
          {
            $data[$k]['type'] = 1;
            $data[$k]['oid']  = $result['id'];
            $data[$k]['cid']  = $vo;
          }

          D('CategoryRelation')->doSaveFromDataAction($data);
        }

        if(!empty($lids))
        {
          $data = array();

          foreach($lids as $kk => $voo)
          {
            $data[$kk]['type'] = 1;
            $data[$kk]['oid']  = $result['id'];
            $data[$kk]['lid']  = $voo;
          }

          D('LabelRelation')->doSaveFromDataAction($data);
        }

        # 记录行为
        record_log('add_Item', 'Item', $result['id'], UID);

        $this->success($result['msg'], U('Item/index'));
      }
      else
      {
        $this->error($result['msg']);
      }
    }
    else
    {
      $where['status'] = 1;
      $where['type'] = 1;
      $list['category'] = D('Category')->getWithWhereTableInfo($where, 'id, title');
      $list['label'] = D('Label')->getWithWhereTableInfo($where, 'id, title');

      $this->assign('list', $list);
      $this->meta_title = '新增项目';
      $this->list_title = '';

      $this->display();
    }
  }



  /**
   * --------------------------------------------------------------------------------------
   * 编辑项目
   */
  public function edit()
  {
    if(IS_POST)
    {
      $post = I('post.', '', 'op_ue');

      $cids = $post['cid'];
      $lids = $post['lid'];

      remove_array_field($post, array('cid', 'lid'));

      # 获取数据对象
      $result = D('Item')->doSaveFromDataAction($post);

      # 此处为自动验证错误提示信息
      if(1 == $result['flag'])
      {
        if(!empty($cids))
        {
          $where = array();
          $where['oid'] = $post['id'];
          D('CategoryRelation')->doDeleteTableAction($where);

          $data = array();

          foreach($cids as $k => $vo)
          {
            $data[$k]['type'] = 1;
            $data[$k]['oid']  = $post['id'];
            $data[$k]['cid']  = $vo;
          }

          D('CategoryRelation')->doSaveFromDataAction($data);
        }

        if(!empty($lids))
        {
          $where = array();
          $where['oid'] = $post['id'];
          D('LabelRelation')->doDeleteTableAction($where);

          $data = array();

          foreach($lids as $kk => $voo)
          {
            $data[$kk]['type'] = 1;
            $data[$kk]['oid']  = $post['id'];
            $data[$kk]['lid']  = $voo;
          }

          D('LabelRelation')->doSaveFromDataAction($data);
        }

        # 记录行为
        record_log('edit_Item', 'Item', $post['id'], UID);

        $this->success($result['msg'], U('Item/index'));
      }
      else
      {
        $this->error($result['msg']);
      }
    }
    else
    {
      $id = I('get.id', '', 'op_t');

      $where['id'] = $id;
      $list = D('Item')->getWithWhereOneTableInfo($where);

      $where = array();
      $where['status'] = 1;
      $where['type'] = 1;
      $list['category'] = D('Category')->getWithWhereTableInfo($where, 'id, title');
      $list['label'] = D('Label')->getWithWhereTableInfo($where, 'id, title');

      $where = array();
      $where['status'] = 1;
      $where['oid'] = $id;
      $cids = D('CategoryRelation')->getWithWhereTableInfo($where, 'cid', '');
      $lids = D('LabelRelation')->getWithWhereTableInfo($where, 'lid', '');

//       echo '<pre>';
// dump($list);
//       echo '</pre>';
//       exit;
      $this->assign('list', $list);
      $this->assign('cids', json_encode($cids));
      $this->assign('lids', json_encode($lids));
      $this->meta_title = '编辑项目';
      $this->list_title = '';
      $this->display();
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 状态修改
   */
  public function changeStatus($method = null)
  {
    $id = I('get.id', 0);

    if(empty($id))
    {
      $id = array_unique((array)I('post.id', 0));
    }
    else
    {
      $id = (array)$id;
    }

    $id = is_array($id) ? implode(',',$id) : $id;

    if(empty($id))
    {
      $this->error('请选择要操作的数据!');
    }

    $map['id'] = array('in', $id);

    # 获得当前URL地址的参数数据
    $url = get_current_url_data();

    switch(strtolower($method))
    {
      case 'forbid':
        $this->custom_forbid('Item', $map, 'status', $url);
        break;
      case 'resume':
        $this->custom_resume('Item', $map, 'status', $url);
        break;
      case 'delete':
        # 记录行为
        record_log('delete_Item', 'Item', $id, UID);
        $this->custom_delete('Item', $map, 'status', $url);
        break;
      default:
        $this->error('参数非法');
    }
  }
}
