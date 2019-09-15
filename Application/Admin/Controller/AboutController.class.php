<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 关于控制器
 *     @english: AboutController.class.php
 *
 * @version: 1.0
 * @desc   : 关于控制器
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2017-03-06 14:42:11
 */
class AboutController extends AdminController
{

  /**
   * --------------------------------------------------------------------------------------
   * 关于列表
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
    $result = D('About')->getWithWhereTablePagingInfo($nowPage, $where);
    D('About')->getWithWhereFormatDataInfo($result['data']);

    # 模版赋值
    $this->assign('set', $set);
    $this->assign('list', $result['data']);
    $this->assign('page', $result['show']);
    $this->meta_title = '关于列表';
    $this->list_title = '';
    $this->display();
  }


  /**
   * --------------------------------------------------------------------------------------
   * 新增关于
   */
  public function add()
  {
    if(IS_POST)
    {
      $post = I('post.', '', 'op_ue');

      $where['display'] = array('eq', 1);
      D('About')->doUpdateTableFieldAction($where, 'display', 0);

      # 获取数据对象
      $result = D('About')->doSaveFromDataAction($post);

      # 此处为自动验证错误提示信息
      if(1 == $result['flag'])
      {
        # 记录行为
        record_log('add_About', 'About', $result['id'], UID);

        $this->success($result['msg'], U('About/index'));
      }
      else
      {
        $this->error($result['msg']);
      }
    }
    else
    {
      $this->meta_title = '新增关于';
      $this->list_title = '';
      $this->assign('data',null);

      $this->display();
    }
  }



  /**
   * --------------------------------------------------------------------------------------
   * 编辑关于
   */
  public function edit()
  {
    if(IS_POST)
    {
      $post = I('post.', '', 'op_ue');

      $where['display'] = array('eq', 1);
      D('About')->doUpdateTableFieldAction($where, 'display', 0);

      # 获取数据对象
      $result = D('About')->doSaveFromDataAction($post);

      # 此处为自动验证错误提示信息
      if(1 == $result['flag'])
      {
        # 记录行为
        record_log('edit_About', 'About', $result['id'], UID);

        $this->success($result['msg'], U('About/index'));
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
      $list = D('About')->getWithWhereOneTableInfo($where);

      $this->assign('list', $list);
      $this->meta_title = '编辑关于';
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
        $this->custom_forbid('About', $map, 'status', $url);
        break;
      case 'resume':
        $this->custom_resume('About', $map, 'status', $url);
        break;
      case 'delete':
        # 记录行为
        record_log('delete_About', 'About', $id, UID);
        $this->custom_delete('About', $map, 'status', $url);
        break;
      default:
        $this->error('参数非法');
    }
  }
}
