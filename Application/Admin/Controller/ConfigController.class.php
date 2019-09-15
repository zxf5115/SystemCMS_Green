<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 配置控制器
 *     @english: ConfigController.class.php
 *
 * @version: 1.0
 * @desc   : 配置系统配置信息
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 14:42:11
 */
class ConfigController extends AdminController
{

  /**
   * --------------------------------------------------------------------------------------
   * 配置管理
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
    $result = D('Config')->getWithWhereTablePagingInfo($nowPage, $where);
    $result['data'] = $this->getWithWhereFormatDataInfo($result['data'], 'Config');

    # 模版赋值
    $this->assign('_set', $set);
    $this->assign('_list', $result['data']);
    $this->assign('page', $result['show']);
    $this->meta_title = '配置管理';
    $this->list_title = '';
    $this->display();
  }


  /**
   * --------------------------------------------------------------------------------------
   * 新增配置
   */
  public function add()
  {
    if(IS_POST)
    {
      $post = I('post.');

      # 获取数据对象
      $result = D('Config')->doSaveFromDataAction($post);

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
        # 记录行为
        record_log('add_config', 'Config', $result['id'], UID);

        $config = D('Config')->getWithWhereConfigListInfo();
        S('DB_CONFIG_DATA',$config);

        $this->success($result['msg'], U('Config/index'));
      }
    }
    else
    {
      $this->meta_title = '新增配置';
      $this->list_title = '';
      $this->assign('info',null);
      $this->display();
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 编辑配置
   */
  public function edit($id = 0)
  {
    if(IS_POST)
    {
      $post = I('post.');

      # 获取数据对象
      $result = D('Config')->doSaveFromDataAction($post);

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
        # 记录行为
        record_log('update_config', 'Config', $id, UID);

        $config = D('Config')->getWithWhereConfigListInfo();
        S('DB_CONFIG_DATA',$config);

        $this->success($result['msg'], U('Config/index'));
      }
    }
    else
    {
      $map['id'] = $id;

      # 获取数据
      $list = D('Config')->getWithWhereOneTableInfo($map);

      if(false === $list)
      {
        $this->error('获取配置信息错误');
      }

      $this->assign('list', $list);
      $this->meta_title = '编辑配置';
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
        $this->forbid('Config', $map, $msg);
        break;
      case 'resume':
        $this->resume('Config', $map, $msg);
        break;
      case 'delete':
        # 记录行为
        record_log('delete_config', 'Config', $id, UID);
        $this->delete('Config', $map, $msg);
        $config = D('Config')->getWithWhereConfigListInfo();
        S('DB_CONFIG_DATA',$config);
        break;
      default:
        $this->error('参数非法');
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 网站设置
   */
  public function setting()
  {
    if(IS_POST)
    {
      $config = I('post.config');

      if($config && is_array($config))
      {
        foreach ($config as $name => $value)
        {
          $map = array('name' => $name);

          $state = D('Config')->doUpdateTableFieldAction($map, 'value', $value);

          if($state)
          {
            $config = D('Config')->getWithWhereConfigListInfo();
            S('DB_CONFIG_DATA',$config);

            $this->success('保存成功！', U('Config/setting'));
          }
        }
      }
      else
      {
        $this->error('保存失败！');
      }
    }
    else
    {
      $id   = I('get.id', 1, 'op_t');

      $type = C('CONFIG_GROUP_LIST');

      $field = 'id, name, title, extra, value, remark, type';

      $map['group'] = $id;

      $list = D("Config")->getWithWhereTableInfo($map, $field, 'sort ASC');

      $this->assign('id', $id);
      $this->assign('list',$list);
      $this->assign('group', C('CONFIG_GROUP_LIST'));
      $this->meta_title = $type[$id].'设置';
      $this->list_title = '';
      $this->display();
    }
  }
}
