  <?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 前台菜单控制器
 *     @english: ChannelController.class.php
 *
 * @version: 1.0
 * @desc   : 配置前台菜单内容
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 14:42:11
 */
class ChannelController extends AdminController
{

  /**
   * --------------------------------------------------------------------------------------
   * 前台菜单列表
   */
  public function index()
  {
    $pid               = I('get.pid', '0', 'op_t');
    $set['start_time'] = I('get.start_time', '', 'op_t');
    $set['end_time']   = I('get.end_time', '', 'op_t');
    $set['status']     = I('get.status', '', 'op_t');
    $set['search']     = I('get.search', '', 'op_t');
    $page              = I('get.i', '', 'op_t');

    # 获取分页参数
    $nowPage = intval($page) > 1 ? intval($page) : 1;

    # 获取搜索参数
    $set = isset($set) ? $set : array();

    $where['pid'] = $pid;

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
    $result = D('Channel')->getWithWhereTablePagingInfo($nowPage, $where, '*', 'id ASC');

    $result = $this->getWithWhereFormatDataInfo($result, 'Channel');

    # 模版赋值
    $this->assign('_set', $set);
    $this->assign('_list', $result['data']);
    $this->assign('page', $result['show']);
    $this->meta_title = '前台菜单管理';
    $this->list_title = '';
    $this->display();
  }


  /**
   * --------------------------------------------------------------------------------------
   * 添加前台菜单
   */
  public function add()
  {
    if(IS_POST)
    {
      $post = I('post.');

      # 获取数据对象
      $result = D('Channel')->doSaveFromDataAction($post);

      # 此处为自动验证错误提示信息
      if(-1 == $result['flag'])
      {
        $this->error($result['msg']);
      }
      else if(0 == $result['flag'])
      {
        $this->error($result['msg']);
      }
      else if(1 == $result['flag'])
      {
        if($result['id'])
        {
          # 记录行为
          record_log('add_channel', 'Channel', $result['id'], UID);
        }

        $this->success($result['msg'], U('Channel/index'));
      }
    }
    else
    {
      $pid = I('get.pid', 0, 'op_t');

      # 获取父导航
      if(!empty($pid))
      {
        $map['id'] = $pid;
        $parent = D('Channel')->getWithWhereOneTableInfo($map, 'title');
        $this->assign('parent', $parent);
      }

      $this->assign('pid', $pid);
      $this->assign('info',null);
      $this->meta_title = '新增导航';
      $this->list_title = '';
      $this->display();
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 编辑前台菜单
   */
  public function edit()
  {
    if(IS_POST)
    {
      $post = I('post.');

      # 获取数据对象
      $result = D('Channel')->doSaveFromDataAction($post);

      # 此处为自动验证错误提示信息
      if(-1 == $result['flag'])
      {
        $this->error($result['msg']);
      }
      else if(0 == $result['flag'])
      {
        $this->error($result['msg']);
      }
      else if(1 == $result['flag'])
      {
        if($result['id'])
        {
          # 记录行为
          record_log('edit_channel', 'Channel', $result['id'], UID);
        }

        $this->success($result['msg'], U('Channel/index'));
      }
    }
    else
    {
      $pid = i('get.pid', 0, 'op_t');
      $id  = i('get.id' , 0, 'op_t');

      $map['id'] = $id;
      $info = D('Channel')->getWithWhereOneTableInfo($map);

      if(false === $info)
      {
        $this->error('获取配置信息错误');
      }

      # 获取父导航
      if(!empty($pid))
      {
        $map['id'] = $pid;
        $parent = D('Channel')->getWithWhereOneTableInfo($map, 'title');
        $this->assign('parent', $parent);
      }

      $this->assign('pid', $pid);
      $this->assign('info', $info);
      $this->meta_title = '编辑导航';
      $this->list_title = '';
      $this->display();
    }
  }



  /**
   * --------------------------------------------------------------------------------------
   * 更改前台菜单状态
   */
  public function changeStatus($method = null)
  {
    $id = I('get.id', 0);

    $tmp = $_SERVER['HTTP_REFERER'];
    $params = parse_url($tmp);

    $msg['success'] = '操作成功！';
    $msg['error']   = '操作失败！';
    $msg['url']     = trim($params['query'], 's=');

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

    switch(strtolower($method))
    {
      case 'forbid':
        $this->forbid('Channel', $map, $msg);
        break;
      case 'resume':
        $this->resume('Channel', $map, $msg);
        break;
      case 'delete':
        # 记录行为
        record_log('delete_channel', 'Channel', $id, UID);
        $this->delete('Channel', $map, $msg);
        break;
      default:
        $this->error('参数非法');
    }
  }
}
