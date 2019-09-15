<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 标签控制器
 *     @english: LabelController.class.php
 *
 * @version: 1.0
 * @desc   : 标签控制器
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-06-15 14:42:11
 */
class LabelController extends AdminController
{

  /**
   * --------------------------------------------------------------------------------------
   * 标签列表
   */
  public function index()
  {
    $set['start_time'] = I('get.start_time', '', 'op_t');
    $set['end_time']   = I('get.end_time', '', 'op_t');
    $set['status']     = I('get.status', '', 'op_t');
    $set['type']       = I('get.type', '', 'op_t');
    $set['search']     = I('get.search', '', 'op_t');
    $page              = I('get.i', '', 'op_t');

    # 获取分页参数
    $nowPage = intval($page) > 1 ? intval($page) : 1;

    # 获取搜索参数
    $set = isset($set) ? $set : array();

    $where['status'] = array('gt', -1);

    # 按时间搜索
    if(!empty($set['start_time']) && !empty($set['end_time']))
    {
      $start_time = strtotime($set['start_time'].'00:00:00');
      $end_time = strtotime($set['end_time'].'23:59:59');
      $where['create_time'] = array(array('gt',$start_time),array('lt',$end_time));
    }

    # 按管理员搜索
    if(!empty($set['search']))
    {
      $search = trim($set['search']);
      $where['title'] = array('like','%'.$search.'%');
    }

    # 按标签类型搜索
    if(!empty($set['type']))
    {
      $type = trim($set['type']);

      $where['type'] = array('eq', $type);
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
    $result = D('Label')->getWithWhereTablePagingInfo($nowPage, $where);
    D('Label')->getWithWhereFormatDataInfo($result['data']);

    # 模版赋值
    $this->assign('set', $set);
    $this->assign('list', $result['data']);
    $this->assign('page', $result['show']);
    $this->meta_title = '标签列表';
    $this->list_title = '';
    $this->display();
  }


  /**
   * --------------------------------------------------------------------------------------
   * 新增标签
   */
  public function add()
  {
    if(IS_POST)
    {
      $post = I('post.', '', 'op_t');

      # 获取数据对象
      $result = D('Label')->doSaveFromDataAction($post);

      # 此处为自动验证错误提示信息
      if(1 == $result['flag'])
      {
        $this->success($result['msg'], U('Label/index'));
      }
      else
      {
        $this->error($result['msg']);
      }
    }
    else
    {
      $where['status'] = array('gt', -1);
      $where['type']   = array('eq', 1);

      $list['label'] = D('Label')->getWithWhereTableInfo($where, 'id, title');

      $this->assign('list', $list);
      $this->meta_title = '新增标签';
      $this->list_title = '';
      $this->display();
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 编辑标签
   */
  public function edit()
  {
    if(IS_POST)
    {
      $post = I('post.', '', 'op_t');

      # 获取数据对象
      $result = D('Label')->doSaveFromDataAction($post);

      # 此处为自动验证错误提示信息
      if(1 == $result['flag'])
      {
        $this->success($result['msg'], U('Label/index'));
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

      $list = D('Label')->getWithWhereOneTableInfo($where);

      $where = array();
      $where['status'] = array('gt', -1);
      $where['type']   = array('eq', $list['type']);

      $list['label'] = D('Label')->getWithWhereTableInfo($where, 'id, title');

      $this->assign('list', $list);
      $this->meta_title = '编辑标签';
      $this->list_title = '';
      $this->display();
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 异步请求数据
   */
  public function data()
  {
    $type = I('post.type', '', 'op_t');

    $where['status'] = array('gt', -1);
    $where['type']   = array('eq', $type);

    $data = D('Label')->getWithWhereTableInfo($where, 'id, title');

    $this->ajaxReturn($data);
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
        $this->custom_forbid('Label', $map, 'status', $url);
        break;
      case 'resume':
        $this->custom_resume('Label', $map, 'status', $url);
        break;
      case 'delete':
        $this->custom_delete('Label', $map, 'status', $url);
        break;
      default:
        $this->error('参数非法');
    }
  }
}
