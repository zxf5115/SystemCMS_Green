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
class KeywordController extends AdminController
{

  /**
   * --------------------------------------------------------------------------------------
   * 用户行为列表
   */
  public function index()
  {
    $set['start_time'] = I('get.start_time', '', 'op_t');
    $set['end_time']   = I('get.end_time', '', 'op_t');
    $set['search']     = I('get.search', '', 'op_t');
    $page              = I('get.i', '', 'op_t');

    # 获取分页参数
    $nowPage = intval($page) > 1 ? $page : 1;

    $where['status'] = array('gt', -1);

    # 按时间段搜索
    if(!empty($set['start_time']) && !empty($set['end_time']))
    {
      $start_time = strtotime($set['start_time'].'00:00:00');
      $end_time = strtotime($set['end_time'].'23:59:59');
      $where['createtime'] = array(array('gt',$start_time),array('lt',$end_time));
    }

    # 按关键字内容搜索
    if(!empty($set['search']))
    {
      $content = trim($set['search']);
      $where['content'] = array('like','%'.$content.'%');
    }


    # 调用父类数据分页方法 参数:$model ,$nowPage ,$where ,$field
    $result = D('Keyword')->getWithWhereTablePagingInfo($nowPage, $where, '*', 'id DESC');

    # 数据格式化
    foreach($result['data'] as $k => &$vo)
    {
      $vo['objid_format'] = $this->setDataFormat($vo['objid'], 'id', 'get_resume_name', 'name');
      $vo['userid_format'] = $this->setDataFormat($vo['userid'], 'id', 'get_user_name', 'username');
      $vo['createtime_format'] = $this->setDataFormat($vo['createtime'], 'date', 'Y-m-d H:i:s');
    }

    $this->assign('_set',$set);
    $this->assign('_list', $result['data']);
    $this->assign('page',$result['show']);
    $this->meta_title = '关键字列表';
    $this->list_title = '';
    $this->display ();
  }


  /**
   * --------------------------------------------------------------------------------------
   * 状态修改
   */
  public function changeStatus($method = null)
  {
    $id = I ( 'get.id', 0 );

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

    $id = is_array ( $id ) ? implode ( ',', $id ) : $id;

    if(empty($id))
    {
      $this->error('请选择要操作的数据!');
    }

    $map['id'] = array('in',$id);

    switch(strtolower($method))
    {
      case 'unshow' :
        $this->custom_forbid('Keyword', $map, 'status', $msg['url']);
        break;
      case 'show' :
        $this->custom_resume('Keyword', $map, 'status', $msg['url']);
        break;
      case 'delete' :
        $this->custom_delete('Keyword', $map, 'status', $msg['url'] );
        break;
      default :
        $this->error ( '参数非法' );
    }
  }
}
