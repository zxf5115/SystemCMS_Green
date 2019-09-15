<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 角色管理控制器
 *     @english: RoleController.class.php
 *
 * @version: 1.0
 * @desc   : 控制角色信息
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 14:42:11
 */
class RoleController extends AdminController
{
  /**
   * --------------------------------------------------------------------------------------
   * 权限管理首页
   */
  public function index()
  {
    $set['search']   = I('get.search', '', 'op_t');
    $set['roleName'] = I('get.roleName', '', 'op_t');
    $set['status']   = I('get.status', '', 'op_t');
    $page            = I('get.i', '', 'op_t');

    # 获取参数
    $nowPage = intval($page) > 1 ? intval($page) : 1;

    $where['status'] = array('neq', -1);

    # 按角色名称搜索
    if(!empty($set['roleName']))
    {
      $roleName = trim($set['roleName']);
      $where['title'] = array('like', '%'.$roleName.'%');
    }

    # 按描述搜索
    if(!empty($set['search']))
    {
      $search = trim($set['search']);
      $where['description'] = array('like', '%'.$search.'%');
    }

    # 状态搜索
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
    $result = D('Role')->getWithWhereTablePagingInfo($nowPage, $where);
    D('Member')->getWithWhereFormatDataInfo($result['data']);

    # 模版赋值
    $this->assign('set',$set);
    $this->assign('list', $result['data']);
    $this->assign('page', $result['show']);
    $this->meta_title = '角色管理';
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
      $post = I('post.', '', 'op_t');

      $post['module'] = 'admin';
      $post['type'] = 1;

      # 获取数据对象
      $result = D('Role')->doSaveFromDataAction($post);

      # 此处为自动验证错误提示信息
      if(1 == $result['flag'])
      {
        # 记录行为
        record_log('add_role', 'Role', $result ['id'], UID);
        $this->success($result['msg'], U('Role/index'));
      }
      else
      {
        $this->error($result['msg']);
      }
    }
    else
    {
      $this->meta_title = '新增角色';
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
      $post = I( 'post.', '', 'op_t');

      $post['module'] = 'admin';
      $post['type']   = 1;

      # 获取数据对象
      $result = D('Role')->doSaveFromDataAction($post);

      # 此处为自动验证错误提示信息
      if(1 == $result['flag'])
      {
        # 记录行为
        record_log('update_role', 'Role', $result ['id'], UID);
        $this->success( $result['msg'], U('Role/index'));
      }
      else
      {
        $this->error($result['msg']);
      }
    }
    else
    {
      $id = I('get.id', '', 'op_t');

      $map['module'] = 'admin';
      $map['type']   = 1;
      $map['id']     = $id;

      $list = D('Role')->getWithWhereOneTableInfo($map);

      $this->assign('list', $list);
      $this->meta_title = '编辑角色';
      $this->list_title = '';
      $this->display();
    }
  }



  /**
   * --------------------------------------------------------------------------------------
   * 访问授权页面
   */
  public function visit()
  {
    if(IS_POST)
    {
      $post = I('post.', '', 'op_t');

      if(isset( $post['rules']))
      {
        sort($post['rules']);
        $post['rules'] = implode(',', array_unique($post['rules']));
      }

      $post['module'] = 'admin';
      $post['type']   = 1;

      # 获取数据对象
      $result = D('Role')->doSaveFromDataAction($post);

      # 此处为自动验证错误提示信息
      if(1 == $result['flag'])
      {
        $this->success($result['msg'], U('Role/index'));
      }
      else
      {
        $this->error($result['msg']);
      }
    }
    else
    {
      $id = I('rid', '', 'op_t');

      $this->updatePermission();

      $map['status'] = array('egt', '0');
      $map['module'] = 'admin';
      $map['type'] = 1;

      $field = 'id, title, rules';

      $all_role = D('Role')->getWithWhereTableInfo($map, $field);

      $map['id'] = $id;
      $this_role = D('Role')->getWithWhereOneTableInfo($map, $field);

      $list = $this->returnNodes();

      $map['status'] = 1;
      $map['type'] = PermissionModel::RULE_MAIN;
      $field = 'id, name';
      $main_rules = D('Permission')->getWithWhereTableInfo($map, $field);

      $map['type'] = PermissionModel::RULE_URL;
      $child_rules = D('Permission')->getWithWhereTableInfo($map, $field);

      $this->assign('main_rules', $main_rules);
      $this->assign('auth_rules', $child_rules);
      $this->assign('list', $list);
      $this->assign('all_role', $all_role);
      $this->assign('this_role', $this_role);

      $this->meta_title = '访问授权';
      $this->list_title = '';
      $this->display ();
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 用户组授权用户列表
   */
  public function user()
  {
    $rid = I('rid', '', 'op_t');

    if(empty($rid))
    {
      $this->error('参数错误');
    }

    $map['status'] = array('egt', '0');
    $map['module'] = 'admin';
    $map['type'] = 1;

    $field = 'id, title, rules';

    $role = D('Role')->getWithWhereTableOneFieldInfo($map, $field, 1, $flag);

    $map = array();
    $map['rid'] = $rid; # 加入查询条件
    $map['status'][0] = 1; # 加入查询条件
    $map['status']['alias'] = 'r'; # 加入查询条件

    $field = 'r.id, r.username, r.last_login_time, r.last_login_ip, r.status';

    $list = D('RoleUserRelation')->getWithWhereMemberRoleRelInfo($map, $field, '', '');

    int_to_string($list);

    $this->assign('list', $list);
    $this->assign('role', $role);
    $this->assign('current', $role[$rid]);

    $this->meta_title = '成员列表';
    $this->list_title = '';
    $this->display();
  }


  /**
   * --------------------------------------------------------------------------------------
   * 将用户从用户组中移除 入参:uid,group_id
   */
  public function removeUser()
  {
    $uid = I('get.uid', '', 'op_t');
    $rid = I('get.rid', '', 'op_t');

    if($uid == UID)
    {
      $this->error('不允许解除自身授权');
    }

    if(empty($uid) || empty($rid))
    {
      $this->error('参数有误');
    }

    $map['id'] = $rid;
    $state = D('Role')->getWithWhereOneTableInfo($map);

    if(empty($state))
    {
      $this->error('角色不存在');
    }

    $map = array('uid' => $uid, 'rid' => $rid);

    $result = D('RoleUserRelation')->doDeleteTableAction($map);

    if($result)
    {
      $this->success('操作成功');
    }
    else
    {
      $this->error('操作失败');
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 后台节点配置的url作为规则存入权限表
   *
   * 执行新节点的插入,已有节点的更新,无效规则的删除三项任务
   */
  public function updatePermission()
  {
    # 需要新增的节点必然位于$nodes
    $nodes = $this->returnNodes(false);

    $Permission = D('Permission');

    $map['module'] = 'admin';
    $map['type'] = array('in', '1,2');

    # 需要更新和删除的节点必然位于$rules
    $permission = $Permission->getWithWhereTableInfo($map, 'name, module, type');

    # 构建insert数据 保存需要插入和更新的新节点
    $data = array();

    foreach($nodes as $value)
    {
      $temp['rid']    = $value['id'];
      $temp['name']   = $value['url'];
      $temp['title']  = $value['title'];
      $temp['module'] = 'admin';

      if($value['pid'] > 0)
      {
        $temp['type'] = PermissionModel::RULE_URL;
      }
      else
      {
        $temp['type'] = PermissionModel::RULE_MAIN;
      }

      $temp ['status'] = 1;

      # 去除重复项
      $data[strtolower($temp['name'] . $temp['module'] . $temp['type'])] = $temp;
    }

    # 保存需要更新的节点
    $update = array();

    # 保存需要删除的节点的id
    $ids = array();

    foreach($permission as $index => $rule)
    {
      $key = strtolower($rule['name'] . $rule['module'] . $rule['type']);

      # 如果数据库中的规则与配置的节点匹配,说明是需要更新的节点
      if(isset($data[$key]))
      {
        # 为需要更新的节点补充id值
        $data[$key]['id'] = $rule['id'];

        $update[] = $data[$key];

        unset($data[$key]);
        unset($permission[$index]);
        unset($rule['condition']);

        $diff[$rule['id']] = $rule;
      }
      else if($rule['status'] == 1)
      {
        $ids[] = $rule['id'];
      }
    }

    if(count( $update))
    {
      foreach($update as $k => $row)
      {
        if($row != $diff[$row['id']])
        {
          $map['id'] = $row['id'];
          $Permission->doUpdateTableAction($map, $row);
        }
      }
    }

    if(count($ids))
    {
      $map['id'] = array('IN', implode(',', $ids));

      # 删除规则是否需要从每个用户组的访问授权表中移除该规则?
      $Permission->doDeleteTableAction($map);
    }

    if(count($data))
    {
      $state = $Permission->doAddAllTableAction(array_values($data));
    }

    if($state)
    {
      return true;
    }
    else
    {
      return false;
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 状态修改
   */
  public function changeStatus($method = null)
  {
    $id = I('get.id', '', 'op_t');

    if(empty($id))
    {
      $id = array_unique((array)I('post.id', 0));
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
    else
    {
      $map['id']         = array('in', $id);
      $map_extend['rid'] = array('in', $id);
    }

    # 获得当前URL地址的参数数据
    $url = get_current_url_data();

    switch(strtolower($method))
    {
      case 'forbid':
        # 记录行为
        record_log('forbid_role', 'Role', $id, UID);
        $this->custom_forbid('Role', $map , 'status', $url);
        break;
      case 'resume':
        # 记录行为
        record_log('resume_role', 'Role', $id, UID);
        $this->custom_resume('Role', $map , 'status', $url);
        break;
      case 'delete':
        # 记录行为
        record_log('delete_role', 'Role', $id, UID);
        $this->custom_delete('Role', $map, $map_extend ,$url);
        break;
      default:
        $this->error($method . '参数非法');
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 自定义删除
   *
   * 删除用户表中用户扩展表中内容
   */
  public function custom_delete($model, $info, $info_extend, $return)
  {
    $res = D($model)->doDeleteRoleAction($info, $info_extend);

    if($res)
    {
      $this->success('操作成功！', U($return));
    }
    else
    {
      $this->error('操作失败！');
    }
  }
}
