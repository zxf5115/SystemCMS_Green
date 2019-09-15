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
class MessageController extends AdminController
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

    # 获取搜索参数
    $set = isset($set) ? $set : array();

    $where['status'] = array('gt', -1);
    $where['type'] = array('eq', 1);

    # 按时间搜索
    if(!empty($set['start_time']) && !empty($set['end_time']))
    {
      $start_time = $set['start_time'].' 00:00:00';
      $end_time = $set['end_time'].' 23:59:59';
      $where['push_time'] = array(array('gt', $start_time), array('lt', $end_time));
    }

    # 按管理员搜索
    if(!empty($set['search']))
    {
      $search = trim($set['search']);
      $where['content'] = array('like','%'.$search.'%');
    }

    # 调用父类数据分页方法 参数:$model ,$nowPage ,$where ,$field
    $result = D('Message')->getWithWhereTablePagingInfo($nowPage, $where);

    # 数据格式化
    foreach($result['data'] as $k => &$vo)
    {
      $vo['device_format'] = $this->setDataFormat($vo['device'], 'status', array(1=>'Android',2=>'IOS'));
    }

    # 模版赋值
    $this->assign('_set', $set);
    $this->assign('_list', $result['data']);
    $this->assign('page', $result['show']);

    $this->meta_title = '消息列表';
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
      $result = D('Message')->doSaveFromDataAction($post);

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
        $this->success($result['msg'], U('Message/index'));
      }
    }
    else
    {
      $where['status'] = 1;
      $field = 'id, title';

      # 获取数据对象
      $list['schools'] = D('School')->getWithWhereTableInfo($where, $field);
      $list['careers'] = D('Career')->getWithWhereTableInfo($where, $field);

      $this->assign('list', $list);

      $this->meta_title = '新增消息';
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
      $post = I('post.', '', 'op_t');

      # 获取数据对象
      $result = D('Message')->doSaveFromDataAction($post);

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
        $this->success($result['msg'], U('Message/index'));
      }
    }
    else
    {
      $id = I('get.id', '', 'op_t');
      $where['id'] = $id;
      $list = D('Message')->getWithWhereOneTableInfo($where);

      $where = array();
      $where['status'] = 1;
      $field = 'id, title';

      # 获取数据对象
      $list['schools'] = D('School')->getWithWhereTableInfo($where, $field);
      $list['careers'] = D('Career')->getWithWhereTableInfo($where, $field);
      $this->assign('list', $list);

      $this->meta_title = '编辑消息';
      $this->list_title = '';
      $this->display();
    }
  }


  public function send()
  {
    $id = I('get.id', '', 'op_t');
    $where['id'] = $id;
    $list = D('Message')->getWithWhereOneTableInfo($where);

    $where = array();
    $where['school'] = $list['school'];
    $where['career'] = $list['career'];
    $where['sex'] = $list['sex'];

    if(!empty($where['school']) && !empty($where['career']))
    {
      $users = D('Client')->getWithWhereTableInfo($where, 'userid', 'userid DESC');
    }

    if(!empty($users))
    {
      $i = 0;
      $j = 0;
      foreach($users as $k => $v)
      {
        if(($k % 2000) == 0)
        {
          $i++;
          $j = 0;
        }

        $res[$i][$j] = $v['userid'];
        $j++;
      }
    }

    $where = array();
    $where['id'] = $id;

    foreach($res as $kk => $vv)
    {
      $str[$kk] = implode(',', $vv);
      D('Message')->doUpdateTableFieldAction($where, 'uid', $str[$kk]);
    }

    $data['start_time'] = $list['push_time'];

    $now = date('Y-m-d H:i:s');

    if($now > $data['start_time'])
    {
      $this->error('消息已过期');
    }

    $data['text'] = $list['content'];

    $data['title'] = $list['title'];
    $data['clientid'] = C('MSCLIENTID');
    $data['module_name'] = 'backstage';
    $data['platform'] = $list['device'] == 1? 'android' : 'ios';

    $extra['createtime'] = $data['start_time'];
    $extra['content'] = $data['text'];
    $extra['type'] = 0;


    $data['extra'] = json_encode($extra);

    if(empty($str))
    {
      # 广播
      $uri = C('PUSH_B_URI');
      $result = curl_data($uri, $data);
    }
    else
    {
      # 列播
      $uri = C('PUSH_R_URI');

      foreach($str as $vo)
      {
        $data['userids'] = $vo;
        $result = curl_data($uri, $data);
      }
    }

    $result = json_decode($result, true);

    if(0 == $result['result'])
    {
      $where['id'] = $id;
      $res = D('Message')->doUpdateTableFieldAction($where, 'status', 2);


      # 此处为自动验证错误提示信息
      if(empty($res))
      {
        $this->error('发送失败');
      }
      else
      {
        $this->success('发送成功', U('Message/index'));
      }
    }
    else
    {
      $this->error($result['message']);
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

    switch(strtolower($method))
    {
      case 'forbid':
        $this->custom_forbid('Message', $map, 'status', $msg['url']);
        break;
      case 'resume':
        $this->custom_resume('Message', $map, 'status', $msg['url']);
        break;
      case 'delete':
        $this->custom_delete('Message', $map, 'status', $msg['url']);
        break;
      default:
        $this->error('参数非法');
    }
  }
}
