<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: SEO管理控制器
 *     @english: SeoController.class.php
 *
 * @version: 1.0
 * @desc   : 控制SEO信息
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 14:42:11
 */
class SeoController extends AdminController
{
  /**
   * --------------------------------------------------------------------------------------
   * SEO管理首页
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
      $where['seo_keywords'] = array('like','%'.$search.'%');
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
    $result = D('Seo')->getWithWhereTablePagingInfo($nowPage, $where);
    $result['data'] = $this->getWithWhereFormatDataInfo($result['data'], 'Seo');

    # 模版赋值
    $this->assign('_set', $set);
    $this->assign('_list', $result['data']);
    $this->assign('page', $result['show']);
    $this->meta_title = 'SEO信息';
    $this->list_title = '';
    $this->display();
  }


  /**
   * --------------------------------------------------------------------------------------
   * 创建全新角色
   */
  public function add()
  {
    if(IS_POST)
    {
      $post = I('post.');

      # 获取数据对象
      $result = D('Seo')->doSaveFromDataAction($post);

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
        $this->success($result['msg'], U('Seo/index'));
      }
    }
    else
    {
      $this->meta_title = '新增SEO';
      $this->list_title = '';
      $this->display();
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 编辑角色
   */
  public function edit()
  {
    if(IS_POST)
    {
      $post = I('post.');

      # 获取数据对象
      $result = D('Seo')->doSaveFromDataAction($post);

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
        $this->success($result['msg'], U('Seo/index'));
      }
    }
    else
    {
      $id = I('get.id', '', 'op_t');

      $map['id']     = $id;

      $list = D('Seo')->getWithWhereOneTableInfo($map);

      $this->assign('list', $list);
      $this->meta_title = '编辑SEO';
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
    $id = I('get.id', '', 'op_t');

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
    else
    {
      $map['id'] =   array('in', $id);
    }

    switch( strtolower($method))
    {
      case 'forbid':
        $this->forbid('Seo', $map, $msg);
        break;
      case 'resume':
        $this->resume('Seo', $map, $msg);
        break;
      case 'delete':
        $this->delete('Seo', $map, $msg);
        break;
      default:
        $this->error($method.'参数非法');
    }
  }

}
