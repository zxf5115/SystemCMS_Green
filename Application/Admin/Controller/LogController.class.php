<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 日志控制器
 *     @english: LogController.class.php
 *
 * @version: 1.0
 * @desc   : 日志控制器
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 14:42:11
 */
class LogController extends AdminController
{

  /**
   * --------------------------------------------------------------------------------------
   * 行为日志列表
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
      $where['name'] = array('like','%'.$search.'%');
    }

    # 调用父类数据分页方法 参数:$model ,$nowPage ,$where ,$field
    $result = D('Log')->getWithWhereTablePagingInfo($nowPage, $where);
    $result['data'] = $this->getWithWhereFormatDataInfo($result['data'], 'Log');

    # 模版赋值
    $this->assign('_set', $set);
    $this->assign('_list', $result['data']);
    $this->assign('page', $result['show']);
    $this->meta_title = '行为日志';
    $this->display();
  }


  /**
   * --------------------------------------------------------------------------------------
   * 查看行为日志
   */
  public function view($id = 0)
  {
    if(empty($id))
    {
      $this->error('参数错误！');
    }

    $map['id'] = $id;

    $info = D('Log')->getWithWhereOneTableInfo($map);

    $this->assign('info', $info);
    $this->meta_title = '查看操作日志';
    $this->display();
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
        $this->forbid('Log', $map, $msg);
        break;
      case 'resume':
        $this->resume('Log', $map, $msg);
        break;
      case 'delete':
        $this->delete('Log', $map, $msg);
        break;
      default:
        $this->error('参数非法');
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 清空日志
   */
  public function clear()
  {
    $map['id'] = array('gt', 0);

    $res = D('Log')->doDeleteTableAction($map);

    if($res !== false)
    {
      $this->success('日志清空成功！');
    }
    else
    {
      $this->error('日志清空失败！');
    }
  }
}
