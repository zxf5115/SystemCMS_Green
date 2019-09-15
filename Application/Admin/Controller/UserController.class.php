<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 后台用户控制器
 *     @english: UserController.class.php
 *
 * @version: 1.0
 * @desc   : 后台用户控制器
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 14:42:11
 */

class UserController extends AdminController
{

  /**
   * --------------------------------------------------------------------------------------
   * 用户管理首页
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

    $where = array();

    # 按时间搜索
    if(!empty($set['start_time']) && !empty($set['end_time']))
    {
      $start_time = strtotime($set['start_time'].'00:00:00');
      $end_time   = strtotime($set['end_time'].'23:59:59');

      $where['last_login_time'] = array(array('gt',$start_time),array('lt',$end_time));
    }

    # 按管理员搜索
    if(!empty($set['search']))
    {
      $search = trim($set['search']);
      $where['username'] = array('like','%'.$search.'%');
    }

    # 按状态搜索
    if(!empty($set['status']))
    {
      $status = $set['status'];

      if($set['status'] == 3)
      {
        $status = 0;
      }

      $where['status'] = array('eq',$status);
    }

    # 调用父类数据分页方法 参数:$model ,$nowPage ,$where ,$field
    $result = D('Member')->getWithWhereTablePagingInfo($nowPage, $where);
    D('Member')->getWithWhereFormatDataInfo($result['data']);

    # 模版赋值
    $this->assign('set',$set);
    $this->assign('list', $result['data']);
    $this->assign('page', $result['show']);
    $this->meta_title = '用户信息';
    $this->list_title ='';
    $this->display();
  }


  /**
   * --------------------------------------------------------------------------------------
   * 用户资料新增
   */
  public function add()
  {
    if(IS_POST)
    {
      $okpassword = I('post.okpassword');

      $data['username']        = I('post.username');
      $data['password']        = I('post.password');
      $data['email']           = I('post.email');
      $data['mobile']          = I('post.mobile');
      $data['reg_time']        = time();
      $data['reg_ip']          = get_client_ip(1);
      $data['last_login_time'] = time();
      $data['last_login_ip']   = get_client_ip(1);
      $data['update_time']     = time();
      $data['create_time']     = time();
      $data['founder']         = get_username(get_uid());

      $data_extend['nickname']    = I('post.nickname');
      $data_extend['province']    = I('post.province');
      $data_extend['picture']     = I('post.picture');
      $data_extend['description'] = I('post.description');
      $data_extend['sex']         = I('post.sex');
      $data_extend['birthday']    = I('post.birthday');
      $data_extend['qq']          = I('post.qq');

      # 检测密码
      if((strlen($data['password']) < 6) || (strlen($data['password']) > 32))
      {
        $this->error('密码长度必须在6-32个字符之间！');
      }

      # 检测密码
      if($data['password'] != $okpassword)
      {
        $this->error('密码和重复密码不一致！');
      }

      # 检测密码
      if(empty($data_extend['nickname']))
      {
        $this->error('用户昵称不能为空！');
      }

      # 检测密码
      if(empty($data_extend['picture']))
      {
        $this->error('用户头像不能为空！');
      }

      $data['password'] = think_auth_md5($data['password'], UC_AUTH_KEY);

      # 调用注册接口注册用户
      $result = D('Member')->doAddMemberDetailAction($data, $data_extend);

      if(0 < $result[0])
      {
        if(1 == $result[1]['flag'])
        {
          # 记录行为
          record_log('add_user', 'Member', $result[1]['id'], UID);

          $this->success($result[1]['msg'], U('User/index'));
        }
        else
        {
          $this->error($result[1]['msg']);
        }
      }
      else
      {
        # 修改密码失败，显示错误信息
        $this->error('用户添加失败');
      }
    }
    else
    {
      $where['type'] = array('NEQ', 5);
      $list = D('Province')->getWithWhereTableInfo($where, 'id, name', 'id ASC');

      $this->meta_title = '新增用户';
      $this->list_title ='';
      $this->assign('list', $list);
      $this->display();
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 修改用户资料
   */
  public function edit()
  {
    if(IS_POST)
    {
      $data['id']       = I('post.id');
      $data['username'] = I('post.username');
      $data['email']    = I('post.email');
      $data['mobile']   = I('post.mobile');

      $data_extend['uid']         = I('post.id');
      $data_extend['nickname']    = I('post.nickname');
      $data_extend['province']    = I('post.province');
      $data_extend['picture']     = I('post.picture');
      $data_extend['description'] = I('post.description');
      $data_extend['sex']         = I('post.sex');
      $data_extend['birthday']    = I('post.birthday');
      $data_extend['qq']          = I('post.qq');

      $state = D('Member')->doUpdateMemberDetailAction($data, $data_extend);

      if($state)
      {
        $user               =   session('user_auth');
        $user['username']   =   $data['nickname'];

        session('user_auth', $user);
        session('user_auth_sign', data_auth_sign($user));

        # 记录行为
        record_log('update_user', 'Member', $data['id'], UID);

        $this->success('修改成功！', U('User/index'));
      }
      else
      {
        $this->error('修改失败！');
      }
    }
    else
    {
      $map['id'] = I('get.id');

      $field = 'l.*, r.uid, r.nickname, r.sex, r.birthday, r.qq, r.province, r.picture, r.description';

      # 使用前台排序
      $list = D('Member')->getWithWhereTableDetailInfo($map, $field);

      $where['type'] = array('NEQ', 5);
      $province = D('Province')->getWithWhereTableInfo($where, 'id, name', 'id ASC');

      $list['province'] = $province;

      $this->assign('list', $list);
      $this->meta_title = '修改用户资料';
      $this->list_title ='';
      $this->display();
    }

  }


  /**
   * --------------------------------------------------------------------------------------
   * 修改密码初始化
   */
  public function password()
  {
    if(IS_POST)
    {
      $Member = D('Member');

      # 获取参数
      $uid          = I('post.id', '', 'op_t');
      $old_password = I('post.old_password', '', 'op_t');
      $new_password = I('post.new_password', '', 'op_t');
      $ok_password  = I('post.ok_password', '', 'op_t');

      if(empty($old_password))
      {
        $this->error('请输入原密码');
      }

      if(empty($new_password))
      {
        $this->error('请输入新密码');
      }

      if(count($new_password) > 5 && count($new_password) < 33)
      {
        $this->error('密码长度必须在6-32个字符之间！');
      }

      if(!$Member->verifyUserPassword($uid, $old_password))
      {
        $this->error('原密码不正确');
      }

      if(empty($ok_password))
      {
        $this->error('请输入确认密码');
      }

      if($new_password !== $ok_password)
      {
        $this->error('您输入的新密码与确认密码不一致');
      }

      # 调用修改密码接口
      $res = $Member->updatePassword($uid, $old_password ,$new_password);

      if($res)
      {
        # 记录行为
        record_log('update_password', 'Member', $uid, UID);

        # 修改密码成功
        $this->success('密码修改成功！', U('User/index'));
      }
      else
      {
        # 修改密码失败，显示错误信息
        $this->error('密码修改失败！');
      }
    }
    else
    {
      $id = I('get.id');

      $this->meta_title = '修改密码';
      $this->list_title = '';
      $this->assign('id', $id);
      $this->display();
    }

  }


  /**
   * --------------------------------------------------------------------------------------
   * 角色授权
   */
  public function authorization()
  {
    if(IS_POST)
    {
      $uid = I('post.uid', '', 'op_t');
      $rid = I('post.rid', '', 'op_t');

      if(empty($uid))
      {
        $this->error('参数有误，UID为空');
      }

      $role = D('Role');
      $roleUserRelation = D( 'RoleUserRelation');

      if(is_numeric($uid))
      {
        if(is_administrator($uid))
        {
          $this->error('该用户为超级管理员');
        }

        $map['id'] = $uid;
        $user = D('Member')->getWithWhereOneTableInfo($map);

        if(empty($user))
        {
          $this->error('管理员用户不存在');
        }
      }

      if($rid && ! $role->checkRoleId($rid))
      {
        $this->error($role->error);
      }

      if($roleUserRelation->addRoleUserRelation($uid, $rid))
      {
        # 记录行为
        record_log('authorize_user', 'Member', $uid, UID);

        $this->success('操作成功', U('User/index'));
      }
      else
      {
        $this->error($roleUserRelation->error);
      }
    }
    else
    {
      $uid = I( 'get.uid', '', 'op_t');

      $map['type']   = 1;
      $map['module'] = 'admin';

      $role = D('Role')->getWithWhereTableInfo($map, 'id, title, description', '', 1);

      $map['uid'][0]       = $uid; # 加入查询条件
      $map['uid']['alias'] = 'r';

      $role_user = D('Role')->getWithWhereRoleUserRelInfo($map, 1, '', 'uid, rid, title, description, rules');

      $rids = array();

      foreach($role_user as $value)
      {
        $rids[] = $value['rid'];
      }

      $nickname = D( 'MemberExtend' )->getNickName($uid);

      $this->assign('nickname', $nickname);
      $this->assign('role', $role);
      $this->assign('role_user', implode(',', $rids));

      $this->meta_title = '角色授权';
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

    if(empty($id))
    {
      $id = array_unique((array)I('post.id', 0));
    }
    else
    {
      $id = (array)$id;
    }

    if(in_array(C('USER_ADMINISTRATOR'), $id))
    {
      $this->error("不允许对超级用户执行该操作!");
    }

    $id = is_array($id) ? implode(',',$id) : $id;

    if(empty($id))
    {
      $this->error('请选择要操作的数据!');
    }

    $map['id']         =   array('in', $id);
    $map_extend['uid'] =   array('in', $id);

    # 获得当前URL地址的参数数据
    $url = get_current_url_data();

    switch(strtolower($method))
    {
      case 'forbid':
        # 记录行为
        record_log('forbid_user', 'Member', UID, UID);
        $this->custom_forbid('Member', $map, 'status', $url);
        break;
      case 'resume':
        # 记录行为
        record_log('resume_user', 'Member', UID, UID);
        $this->custom_resume('Member', $map, 'status', $url);
        break;
      case 'delete':
        # 记录行为
        record_log('delete_user', 'Member', UID, UID);
        $this->custom_delete('Member', $map, $map_extend, $url);
        break;
      default:
        $this->error('参数非法');
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 自定义删除
   *
   * 删除用户表中用户扩展表中内容
   */
  public function custom_delete($model, $info, $info_extend = '', $url = '')
  {
    $flag = D($model)->doDeleteMemberDetailAction($info, $info_extend);

    if($flag)
    {
      $this->success('操作成功！', U($url));
    }
    else
    {
      $this->error('操作失败！');
    }
  }
}
