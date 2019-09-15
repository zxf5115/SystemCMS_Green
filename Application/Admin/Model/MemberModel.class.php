<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 用户模型
 *     @english: MemberModel.class.php
 *
 * @version: 1.0
 * @desc   : 用户模型
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 14:42:11
 */
use Think\Model;

class MemberModel extends CommonModel
{
  private $table      = 'member';                # 用户信息表
  private $righttable = 'member_extend'; # 角色用户关联信息表

  /**
   * --------------------------------------------------------------------------------------
   * 用户模型数据验证
   */
  protected $_validate = array(
    array('username', '4,16'            , '管理员名长度必须在4-16个字符以内！', self::EXISTS_VALIDATE, 'length'  , self::MODEL_BOTH),
    array('username', 'checkDenyMember' , '管理员名被禁止注册！'              , self::EXISTS_VALIDATE, 'function', self::MODEL_BOTH),
    array('username', ''                , '管理员名被占用！'                  , self::EXISTS_VALIDATE, 'unique'  , self::MODEL_BOTH),
		array('password', '6,32'            , '密码长度必须在6-32个字符之间！'    , self::EXISTS_VALIDATE, 'length'  , self::MODEL_BOTH),
		array('email'   , 'email'           , '邮箱格式不正确！'                  , self::EXISTS_VALIDATE, 'regex'   , self::MODEL_BOTH),
		array('email'   , '6,32'            , '邮箱长度必须在6-32个字符之间！'    , self::EXISTS_VALIDATE, 'length'  , self::MODEL_BOTH),
		array('email'   , 'checkDenyEmail'  , '邮箱被禁止注册！'                  , self::EXISTS_VALIDATE, 'function', self::MODEL_BOTH),
		array('email'   , ''                , '邮箱被占用！'                      , self::EXISTS_VALIDATE, 'unique'  , self::MODEL_BOTH),
		array('mobile'  , '/^(0|86|17951)?(13[0-9]|15[012356789]|18[0-9]|14[57])[0-9]{8}$/', '手机格式不正确！' , self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
		array('mobile'  , 'checkDenyMobile' , '手机被禁止注册！'                  , self::EXISTS_VALIDATE, 'function', self::MODEL_BOTH),
		array('mobile', ''                  , '手机号被占用！'                    , self::EXISTS_VALIDATE, 'unique'  , self::MODEL_BOTH),
  );

	/**
   * --------------------------------------------------------------------------------------
   * 用户模型自动完成
   */
	protected $_auto = array(
    array('reg_time'   , NOW_TIME, self::MODEL_INSERT),
    array('reg_ip'     , 'get_client_ip', self::MODEL_INSERT, 'function', 1),
    array('update_time', 'time', self::MODEL_BOTH, 'function'),
    array('status'     , 1, self::MODEL_INSERT, 'string'),
    array('create_time', NOW_TIME, self::MODEL_INSERT),
    array('founder'    , 'get_username', self::MODEL_INSERT, 'function', get_uid),
	);


  /**
   * --------------------------------------------------------------------------------------
   * 初始化数据表信息
   */
  public function __construct()
  {
    parent::__construct($this->table, $this->righttable);
  }

# + ----------------------------------------------------------------------------------------------
# + 查询


  /* --------------------------------------------------------------------------------------
   * 根据条件查询数据表信息
   *
   * @param  Array   $where   查询数据条件
   * @param  String  $field   查询字段
   * @param  String  $order   排序条件
   * @param  String  $status  数据状态
   *
   * @return Array   $result  查询结果集
   */
  public function getWithWhereCurrentTableDetailInfo($where = array(), $field = true, $order = 'id DESC', $status = -1, $group = '',$nowPage,$listRows)
  {
    // $where = format_where_condition($where, 'l');  # 查询条件格式化 {方法位于:Application\Common\Common\uyeah_extend.php }

    $result = M($this->table) ->field('*')
                              ->where($where)
                              ->group($group)
                              ->order($order)
                              ->page($nowPage.','.$listRows)
                              ->select();

    return $result;
  }


# + ----------------------------------------------------------------------------------------------
# + 新增

  /**
   * --------------------------------------------------------------------------------------
   * 新增用户信息
   *
   * @param  array     $info [新增用户基本信息]
   *
   * @return [boolean]       [是否成功]
   */
  public function doAddMemberDetailAction($info = array(), $info_extend = array())
  {
    $res = $this->doSaveFromDataAction($info);

    if($res['flag'] > 0)
    {
      $info_extend['uid'] = $res['id'];

      $res_extend = D('MemberExtend')->doSaveFromDataAction($info_extend);

      if($res_extend['flag'] > 0)
      {
        return array(1, $res);
      }
      else if($res['flag'] == -1)
      {
        return array(1, $res_extend);
      }
      else
      {
        return array(0, $res_extend);
      }
    }
    else if($res['flag'] == -1)
    {
      return array(1, $res);
    }
    else
    {
      return array(0, $res);
    }
  }



# + ----------------------------------------------------------------------------------------------
# + 更新

  /**
   * --------------------------------------------------------------------------------------
   * 更新职位信息
   *
   * @param  int       $id   [当前用户信息编号]
   * @param  array     $info [更新用户基本信息]
   *
   * @return [boolean]       [是否成功]
   */
  public function doUpdateMemberDetailAction($info = array(), $info_extend = array())
  {
    // $res = $this->doSaveFromDataAction($info);

    $res_extend = D('MemberExtend')->doSaveFromDataAction($info_extend, 'uid');

    if(!empty($res['flag']) || !empty($res_extend['flag']))
    {
      return 1;
    }
    else
    {
      return 0;
    }
  }



# + ----------------------------------------------------------------------------------------------
# + 删除

  /**
   * --------------------------------------------------------------------------------------
   * 删除用户操作
   *
   * @param  array     $where [删除条件]
   *
   * @return [boolean]        [是否成功]
   */
  public function doDeleteMemberDetailAction($info = array(), $info_extend = array())
  {
    $model = new Model();

    $model->startTrans(); # 开始事务

    $res = $this->doDeleteTableAction($info);
    $res_extend = D('MemberExtend')->doDeleteTableAction($info_extend);

    if($res && $res_extend)
    {
      //如果2条都执行成功，则提交完成数据库操作
      $model->commit();

      return 1;
    }
    else
    {
      //如果有其中一条执行失败，则rollback,所有数据还原到两条数据都没执行的状态
      $model->rollback();

      return 0;
    }
  }



# + ----------------------------------------------------------------------------------------------
# + 逻辑


  /**
   * --------------------------------------------------------------------------------------
   * 保存表单提交数据
   */
  public function doSaveFromDataAction($info)
  {
    $result = $this->doCreateDataAction($info, $this->_validate, $this->_auto);

    return $result;
  }


  /**
   * --------------------------------------------------------------------------------------
   * 用户登录认证
   *
   * @param  string  $username 用户名
   * @param  string  $password 用户密码
   * @param  integer $type     用户名类型 （1-用户名，2-邮箱，3-手机，4-UID）
   *
   * @return integer           登录成功-用户ID，登录失败-错误编号
   */
	public function login($username, $password, $type = 1)
  {
		$map = array();

		switch ($type)
    {
			case 1:
				$map['username'] = $username;
				break;
			case 2:
				$map['email'] = $username;
				break;
			case 3:
				$map['mobile'] = $username;
				break;
			case 4:
				$map['id'] = $username;
				break;
			default:
				return 0;
		}

		# 获取用户数据
		$member = $this->getWithWhereOneTableInfo($map);

		if(is_array($member) && $member['status'])
    {
			# 验证用户密码
			if($member['password'] === think_auth_md5($password, UC_AUTH_KEY))
      {
        # 登录成功
        $uid = $member['id'];

        # 记录行为日志
        record_log('login', 'member', $uid, $uid);

        # 更新登录信息
        $this->autoLogin($member);

        # 登录成功，返回用户UID
				return $uid ;
			}
      else
      {
        # 密码错误
				return -2;
			}
		}
    else
    {
      # 用户不存在或被禁用
			return -1;
		}
	}



  /**
   * --------------------------------------------------------------------------------------
   * 自动登录用户
   *
   * @param  integer $user 用户信息数组
   *
   * @return integer           登录成功-用户ID，登录失败-错误编号
   */
  private function autoLogin($user)
  {
    # 更新登录信息
    $data = array(
      'id'              => $user['id'],
      'login_number'    => array('exp', '`login_number`+1'),
      'last_login_time' => NOW_TIME,
      'last_login_ip'   => get_client_ip(1),
    );

    $where['id'] = $user['id'];
    $res = $this->doUpdateTableAction($where, $data);

    $where = array();
    $where['uid'] = $user['id'];
    $result = D('MemberExtend')->getWithWhereOneTableInfo($where, 'nickname, picture');

    # 记录登录SESSION和COOKIES
    $auth = array(
      'uid'             => $user['id'],
      'username'        => $user['username'],
      'nickname'        => $result['nickname'],
      'picture'         => $result['picture'],
      'last_login_time' => $user['last_login_time'],
    );

    session('user_auth', $auth);
    session('user_auth_sign', data_auth_sign($auth));
  }


  /**
   * --------------------------------------------------------------------------------------
   * 注销当前用户
   */
  public function logout()
  {
    # 记录行为日志
    record_log('logout', 'member', get_uid(), get_uid());

    session('user_auth', null);
    session('user_auth_sign', null);
  }


	/**
   *--------------------------------------------------------------------------------------
	 * 注册一个新用户
   *
	 * @param  string $username 用户名
	 * @param  string $password 用户密码
	 * @param  string $email    用户邮箱
	 * @param  string $mobile   用户手机号码
   *
	 * @return integer          注册成功-用户信息，注册失败-错误编号
	 */
	public function register($username, $password, $email, $mobile)
  {
		$data = array(
			'username' => $username,
			'password' => $password,
			'email'    => $email,
			'mobile'   => $mobile,
		);

		//验证手机
		if(empty($data['mobile']))
    {
      unset($data['mobile']);
    }

		/* 添加用户 */
		if($this->create($data))
    {
			$uid = $this->doAddTableAction();

			return $uid ? $uid : 0; //0-未知错误，大于0-注册成功
		}
    else
    {
			return $this->getError(); //错误详情见自动验证注释
		}
	}


  /**
   * --------------------------------------------------------------------------------------
   * 检测手机号码是否合法
   * @param  string   $mobile 手机号码
   *
   * @return boolean          ture - 未禁用，false - 禁止注册
   */
  protected function checkLegalMobile($mobile)
  {
    $pattern = '/^(0|86|17951)?(13[0-9]|15[012356789]|18[0-9]|14[57])[0-9]{8}$/';

    if(preg_match($pattern, $mobile))
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
	 * 检测用户名是不是被禁止注册
   *
	 * @param  string $nickname 用户名
   *
	 * @return boolean          ture - 未禁用，false - 禁止注册
	 */
	protected function checkDenyMember($nickname)
  {
		return true; //TODO: 暂不限制，下一个版本完善
	}


	/**
   * --------------------------------------------------------------------------------------
	 * 检测邮箱是不是被禁止注册
   *
	 * @param  string $email 邮箱
   *
	 * @return boolean       ture - 未禁用，false - 禁止注册
	 */
	protected function checkDenyEmail($email)
  {
		return true; //TODO: 暂不限制，下一个版本完善
	}


	/**
   * --------------------------------------------------------------------------------------
	 * 检测手机是不是被禁止注册
   *
	 * @param  string $mobile 手机
   *
	 * @return boolean        ture - 未禁用，false - 禁止注册
	 */
	protected function checkDenyMobile($mobile)
  {
		return true; //TODO: 暂不限制，下一个版本完善
	}

	/**
   * --------------------------------------------------------------------------------------
	 * 根据配置指定用户状态
   *
	 * @return integer 用户状态
	 */
	protected function getStatus()
  {
		return true; //TODO: 暂不限制，下一个版本完善
	}

	/**
   * --------------------------------------------------------------------------------------
	 * 验证用户密码
   *
	 * @param int $uid 用户id
	 * @param string $password_in 密码
   *
	 * @return true 验证成功，false 验证失败
	 */
	public function verifyUserPassword($uid, $password_in)
  {
    $where['id'] = $uid;
		$password = $this->getWithWhereTableOneFieldInfo($where, 'password');

		if(think_auth_md5($password_in, UC_AUTH_KEY) === $password)
    {
			return true;
		}

		return false;
	}


	/**
   * --------------------------------------------------------------------------------------
	 * 更新用户密码
   *
	 * @param  string $uid  用户名
	 * @param  string $password 用户密码
   *
	 * @return integer          更新成功-用户信息，更新失败-错误编号
	 */
	public function updatePassword($uid, $old_password, $new_password)
  {
    $where['id'] = $uid;
    $password = $this->getWithWhereTableOneFieldInfo($where, 'password');

		if(think_auth_md5($old_password, UC_AUTH_KEY) === $password)
    {
      $data['id'] = $uid;
      $data['password'] = think_auth_md5($new_password, UC_AUTH_KEY);

      $res = $this->doUpdateTableAction($where, $data);

			return $res;
    }
    else
    {
      return  false;
    }
  }

# + ----------------------------------------------------------------------------------------------
# + 内部逻辑

  /**
   * --------------------------------------------------------------------------------------
   * 根据条件格式化数据
   *
   * @param  array    $data   格式化前数据
   *
   * @return array    $data   格式化后数据
   */
  public function getWithWhereFormatDataInfo(Array &$data)
  {
    $model = null;

    if(empty($data))
    {
      return '格式化数据有误！';
    }

    if(empty($model))
    {
      import("Admin.Plugin.FormatPlugin");

      $model = new FormatPlugin();
    }

    foreach($data as &$row)
    {
      if(isset($row['status']))
      {
        $row['status_format'] = $model->getFormatDataInfo($row['status'], 'status');
      }

      if(isset($row['last_login_ip']))
      {
        $row['last_login_ip_format'] = $model->getFormatDataInfo($row['last_login_ip'], 'function', 'long2ip');
      }

      if(isset($row['last_login_time']))
      {
        $row['last_login_time_format'] = $model->getFormatDataInfo($row['last_login_time'], 'date');
      }
    }
  }

# + ----------------------------------------------------------------------------------------------
# + 统计

  /**
   * --------------------------------------------------------------------------------------
   * 统计用户总量
   */
  public function getWithWhereUserCount($where = array())
  {
    $map['status'] = array('gt', -1);
    $where = array_merge($map, $where);

    $result = $this->getWithWhereCountTableInfo($where, 'count', 'id');

    return $result;
  }


  /**
   * --------------------------------------------------------------------------------------
   * 统计昨日注册用户量
   */
  public function getWithWhereUserRegisterCount($where = '')
  {
    # 开始时间为当前时间的前一天
    $start = strtotime(date('Y-m-d', strtotime('-1 day')));

    # 结束时间为当前时间的 00:00:00
    $end   = strtotime(date('Y-m-d'));

    $con = array(array('egt', $start), array('lt', $end));
    $where['create_time'] = $con;

    $result = $this->getWithWhereCountTableInfo($where, 'count', 'id');

    return $result;
  }
}
