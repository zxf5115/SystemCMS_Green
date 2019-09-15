<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 行为控制器
 *     @english: ActionController.class.php
 *
 * @version: 1.0
 * @desc   : 行为控制器
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 14:42:11
 */
class TemplateController extends AdminController
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
    $set['title']      = I('get.title', '', 'op_t');
    $sort['usecount']  = I('get.usecount', '', 'op_t');
    $page              = I('get.i', '', 'op_t');

    # 获取分页参数
    $nowPage = intval($_GET['p']) > 1 ? intval($_GET['p']) : 1;

    $where = array();

    # 过滤删除的数据
    $where['status'] = array('gt', -1);
    $order = 'id DESC';

    if($sort['usecount'])
    {
      $order = 'usecount '.$sort['usecount'];
      $sort['usecount'] = ($sort['usecount'] == 'desc') ? 'asc' : 'desc';
    }

    # 按时间搜索
    if(!empty($set['start_time']) && !empty($set['end_time']))
    {
      $start_time = strtotime($set['start_time'].'00:00:00');
      $end_time = strtotime($set['end_time'].'23:59:59');
      $where['createtime'] = array(array('gt',$start_time),array('lt',$end_time));
    }

    # 按分类名称搜索
    if(!empty($set['title']))
    {
      $title = trim($set['title']);

      # 组织查询大师条件
      $map['name'] = array('like','%'.$title.'%');

      $map['fid'] = array('neq', -1);
      $map['status'] = array('gt', -1);
      # 返回单条数据大师ID
      $category = D('Category')->getWithWhereTableInfo($map, 'id', 'id DESC');

      foreach($category as $vo)
      {
        $str .= $vo['id'].',';
      }
      $str = rtrim($str, ',');

      # 组织搜索条件
      $where['cateid'] = array('in', $str);
    }

    # 模板名称搜索
    if(!empty($set['search']))
    {
      $search = trim($set['search']);
      $where['name'] = array('like','%'.$search.'%');
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
    $result = D('Template')->getWithWhereTablePagingInfo($nowPage, $where, '*', $order);

    # 数据格式化
    foreach($result['data'] as $k => &$vo)
    {
      $vo['temp_type_format'] = $vo['temp_type'] == 'picture' ? '普通图文' : '涂抹效果';
      $vo['cateid_format'] = $this->setDataFormat($vo['cateid'], 'id', 'get_template_category_name', 'name');
      $vo['source_format'] = $this->setDataFormat($vo['source'], 'status', array(1=>'原生',2=>'大赛'));
      $vo['status_format'] = $this->setDataFormat($vo['status'], 'status', array(0=>'禁用',1=>'启用'));
      $vo['createtime_format'] = $this->setDataFormat($vo['createtime'], 'date', 'Y-m-d H:i:s');
    }

    # 模版赋值
    $this->assign('_set',$set);
    $this->assign('sort',$sort);
    $this->assign('_list', $result['data']);
    $this->assign('page', $result['show']);

    $this->meta_title = '模板列表';
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
      $result = D('Template')->doSaveFromDataAction($post);

      # 此处为自动验证错误提示信息
      if(-1 == $result['flag'])
      {
        $this->error ($result['msg']);
      }
      else if(0 == $result['flag'])
      {
        $this->error ($result['msg']);
      }
      else if(1 == $result['flag'])
      {
        $this->success ($result['msg'], U('Template/index'));
      }
    }
    else
    {
      $where ['status'] = 1;
      $where ['type'] = 'pageTemplate';
      $field = 'id, name';

      #  获取数据对象
      $list['category'] = D('Category')->getWithWhereTableInfo($where, $field);

      $this->assign('list', $list);

      $this->meta_title = '新增模板';
      $this->list_title = '';
      $this->display ();
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
      $post = I('post.', '', 'op_t');

      # 获取数据对象
      $result = D('Template')->doSaveFromDataAction($post);

      # 此处为自动验证错误提示信息
      if(-1 == $result['flag'])
      {
        $this->error ($result['msg']);
      }
      else if(0 == $result['flag'])
      {
        $this->error ($result['msg']);
      }
      else if(1 == $result['flag'])
      {
        $this->success ($result['msg'], U('Template/index'));
      }
    }
    else
    {
      $id = I('get.id', '', 'op_t');

      $where['id'] = $id;
      $list = D('Template')->getWithWhereOneTableInfo($where);

      $where = array();
      $where ['status'] = 1;
      $where ['type'] = 'pageTemplate';
      $field = 'id, name';

      #  获取数据对象
      $list['category'] = D('Category')->getWithWhereTableInfo($where, $field);
// dump($list);exit;
      $this->assign('list', $list);

      $this->meta_title = '编辑模板';
      $this->list_title = '';
      $this->display ();
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 状态修改
   */
  public function changeStatus($method = null)
  {
    $id = I('get.id', 0, 'op_t');

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

    $ids = $id;

    $id = is_array($id) ? implode(',', $id) : $id;

    if(empty($id))
    {
      $this->error('请选择要操作的数据!');
    }

    $map['id'] = array('in',$id);

    switch(strtolower($method))
    {
      case 'forbid' :
        $this->custom_forbid('Template', $map, 'status', $msg['url']);
        break;
      case 'resume' :
        $this->custom_resume('Template', $map, 'status', $msg['url']);
        break;
      case 'delete' :
        $this->custom_delete('Template', $map, 'status', $msg['url']);
        break;
      default :
        $this->error( '参数非法');
    }
  }
}
