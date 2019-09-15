<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 行为控制器
 *     @english: CategoryController.class.php
 *
 * @version: 1.0
 * @desc   : 行为控制器
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 14:42:11
 */
class ProfessionController extends AdminController
{

  /**
   * --------------------------------------------------------------------------------------
   * 用户行为列表
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

    $where['status'] = array('gt', -1);

    # 获取搜索参数
    $set = isset($set) ? $set : array();

    # 按时间搜索
    if(!empty($set['start_time']) && !empty($set['end_time']))
    {
      $start_time = strtotime($set['start_time'].'00:00:00');
      $end_time = strtotime($set['end_time'].'23:59:59');
      $where['createtime'] = array(array('gt', $start_time), array('lt', $end_time));
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

    # 按管理员搜索
    if(!empty($set['search']))
    {
      $search = trim($set['search']);
      $where['title'] = array('like','%'.$search.'%');
    }

    # 调用父类数据分页方法 参数:$model ,$nowPage ,$where ,$field
    $result = D('Profession')->getWithWhereTablePagingInfo($nowPage, $where, '*', 'id DESC');

    # 数据格式化
    foreach($result['data'] as $k => &$vo)
    {
      $vo['fid_format'] = $this->setDataFormat($vo['fid'], 'id', 'get_profession_name', 'title');
      $vo['status_format'] = $this->setDataFormat($vo['status'], 'status', array(0=>'禁用',1=>'启用'));
      $vo['createtime_format'] = $this->setDataFormat($vo['createtime'], 'date', 'Y-m-d H:i:s');
    }

    # 模版赋值
    $this->assign('_set', $set);
    $this->assign('_list', $result['data']);
    $this->assign('page', $result['show']);
    $this->meta_title = '职业管理';
    $this->list_title = '';
    $this->display();
  }


  /**
   * --------------------------------------------------------------------------------------
   * 新增行为
   */
  public function add()
  {
    if(IS_POST)
    {
      $post = I('post.', '', 'op_t');

      # 获取数据对象
      $result = D('Profession')->doSaveFromDataAction($post);

      # 此处为自动验证错误提示管理
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
        $this->success($result['msg'], U('Profession/index'));
      }
    }
    else
    {
      $where['status'] = 1;
      $list['category'] = D('Profession')->getWithWhereTableInfo($where, 'id, title', 'id ASC, fid ASC');

      $this->assign('list', $list);

      $this->meta_title = '新增职业';
      $this->list_title = '';
      $this->display();
    }
  }



  /**
   * --------------------------------------------------------------------------------------
   * 编辑行为
   */
  public function edit()
  {
    if(IS_POST)
    {
      $post = I('post.');

      # 获取数据对象
      $result = D('Profession')->doSaveFromDataAction($post);

      # 此处为自动验证错误提示管理
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
        $this->success($result['msg'], U('Profession/index'));
      }
    }
    else
    {
      $id = I('get.id', '', 'op_t');

      $where['id'] = $id;
      $list = D('Profession')->getWithWhereOneTableInfo($where);

      $where = array();
      $where['status'] = 1;
      $list['category'] = D('Profession')->getWithWhereTableInfo($where, 'id, title', 'id ASC, fid ASC');

      $this->assign('list', $list);
      $this->meta_title = '编辑职业';
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
    $map['fid'] = array('in', $id);
    $map['_logic'] = 'OR';

    switch(strtolower($method))
    {
      case 'forbid':
        $this->custom_forbid('Profession', $map, 'status', $msg['url']);
        break;
      case 'resume':
        $this->custom_resume('Profession', $map, 'status', $msg['url']);
        break;
      case 'delete':
        $this->custom_delete('Profession', $map, 'status', $msg['url']);
        break;
      default:
        $this->error('参数非法');
    }
  }
}
