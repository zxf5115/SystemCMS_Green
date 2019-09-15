<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 联系控制器
 *     @english: ContactController.class.php
 *
 * @version: 1.0
 * @desc   : 联系控制器
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 14:42:11
 */
class ContactController extends AdminController
{

  /**
   * --------------------------------------------------------------------------------------
   * 联系列表
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

    $where['status'] = 1;

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

    # 调用父类数据分页方法 参数:$model ,$nowPage ,$where ,$field
    $result = D('Contact')->getWithWhereTablePagingInfo($nowPage, $where);
    D('Contact')->getWithWhereFormatDataInfo($result['data']);

    # 模版赋值
    $this->assign('set', $set);
    $this->assign('list', $result['data']);
    $this->assign('page', $result['show']);
    $this->meta_title = '联系列表';
    $this->list_title = '';
    $this->display();
  }


  /**
   * --------------------------------------------------------------------------------------
   * 新增联系
   */
  public function detail()
  {
    $id = I('get.id', '', 'op_t');

    empty($id) && $this->error('参数不能为空！');

    $where['id'] = $id;
    $list = D('Contact')->getWithWhereOneTableInfo($where);

    $this->assign('list', $list);
    $this->meta_title = '意见详情';
    $this->list_title = '';
    $this->display();
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
      case 'delete':
        # 记录行为
        record_log('delete_contact', 'Contact', $id, UID);
        $this->custom_forbid('Contact', $map, 'status', $url);
        break;
      default:
        $this->error('参数非法');
    }
  }
}
