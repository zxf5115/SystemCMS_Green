<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 后台广告控制器
 *     @english: PublicityController.class.php
 *
 * @version: 1.0
 * @desc   : 后台广告控制器
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 14:42:11
 */

class PublicityController extends AdminController
{
  /**
   * --------------------------------------------------------------------------------------
   * 广告首页
   */
  public function index()
  {
    # 查询条件
    $set['start_time'] = I('get.start_time', '', 'op_t');
    $set['end_time']   = I('get.end_time'  , '', 'op_t');
    $set['category']   = I('get.category'    , '', 'op_t');
    $set['status']     = I('get.status'    , '', 'op_t');
    $set['search']     = I('get.search'    , '', 'op_t');

    # 排序条件
    $sort['browse']    = I('get.browse', '', 'op_t');

    # 分页条件
    $page              = I('get.i'         , '', 'op_t');

    # 获取分页参数
    $nowPage = intval($page) > 1 ? intval($page) : 1;

    # 获取搜索参数
    $set = isset($set) ? $set : array();

    $where['status'] = array('gt', -1);
    $order = 'id DESC';

    # 排序
    if($sort['browse'])
    {
      if('down' == $sort['browse'])
      {
        $order = 'browse asc';
      }
      else
      {
        $order = 'browse desc';
      }

      $sort['browse'] = ($sort['browse'] == 'up') ? 'down' : 'up';
    }

    # 按时间搜索
    if(!empty($set['start_time']) && !empty($set['end_time']))
    {
      $start_time          = strtotime($set['start_time'].'00:00:00');
      $end_time            = strtotime($set['end_time'].'23:59:59');

      $where['create_time'] = array(array('gt', $start_time), array('lt', $end_time));
    }

    # 按状态搜索
    if(!empty($set['category']))
    {
      $status = trim($set['category']);

      $where['category'] = array('eq', $status);
    }

    # 按管理员搜索
    if(!empty($set['search']))
    {
      $search = trim($set['search']);
      $where['title'] = array('like','%'.$search.'%');
    }

    # 调用父类数据分页方法 参数:$model ,$nowPage ,$where ,$field
    $result = D('Publicity')->getWithWhereTablePagingInfo($nowPage, $where, '*', $order);
    D('Publicity')->getWithWhereFormatDataInfo($result['data']);


    # 模版赋值
    $this->assign('set', $set);
    $this->assign('sort', $sort);
    $this->assign('list', $result['data']);
    $this->assign('page', $result['show']);

    $this->meta_title = '广告信息';
    $this->list_title = '';
    $this->display();
  }


  /**
   * --------------------------------------------------------------------------------------
   * 新增广告
   */
  public function add()
  {
    if(IS_POST)
    {
      $post = I('post.', '', 'op_t');

      $where['status']   = array('gt', -1);
      $where['category'] = $post['category'];
      $where['sort']     = $post['sort'];

      # 因为排序编号唯一，所以新增广告时，新的排序编号对应的旧数据取消排序编号
      D('Publicity')->doUpdateTableFieldAction($where, 'sort', 0);

      # 获取数据对象
      $result = D('Publicity')->doSaveFromDataAction($post);

      # 此处为自动验证错误提示信息
      if(1 == $result['flag'])
      {
        $this->success($result['msg'], U('Publicity/index'));
      }
      else
      {
        $this->error($result['msg']);
      }
    }
    else
    {
      $this->meta_title = '新增广告';
      $this->list_title = '';
      $this->display();
    }
  }



  /**
   * --------------------------------------------------------------------------------------
   * 编辑广告
   */
  public function edit()
  {
    if(IS_POST)
    {
      $post = I('post.', '', 'op_t');

      $where['status']   = array('gt', -1);
      $where['category'] = $post['category'];
      $where['sort']     = $post['sort'];

      # 因为排序编号唯一，所以新增广告时，新的排序编号对应的旧数据取消排序编号
      D('Publicity')->doUpdateTableFieldAction($where, 'sort', 0);

      # 获取数据对象
      $result = D('Publicity')->doSaveFromDataAction($post);

      # 此处为自动验证错误提示信息
      if(1 == $result['flag'])
      {
        $this->success($result['msg'], U('Publicity/index'));
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
      $list = D('Publicity')->getWithWhereOneTableInfo($where);

      $this->assign('list', $list);
      $this->meta_title = '编辑广告';
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
    $id = I('get.id', 0, 'op_t');

    if(empty($id))
    {
      $id = array_unique((array)I('post.id', 0, 'op_t'));
    }
    else
    {
      $id = (array)$id;
    }

    $id = is_array($id) ? implode(',', $id) : $id;

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
        $this->custom_forbid('Publicity', $map, 'status', $url);
        break;
      case 'resume':
        $this->custom_resume('Publicity', $map, 'status', $url);
        break;
      case 'delete':
        $this->custom_delete('Publicity', $map, 'status', $url);
        break;
      default:
        $this->error('参数非法');
    }
  }
}
