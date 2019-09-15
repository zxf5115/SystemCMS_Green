<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2011 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: luofei614 <weibo.com/luofei614>　
// +----------------------------------------------------------------------
namespace Think;
/**
 * 权限认证类
 * 功能特性：
 * 1，是对规则进行认证，不是对节点进行认证。用户可以把节点当作规则名称实现对节点进行认证。
 *      $auth=new Auth();  $auth->check('规则名称','用户id')
 * 2，可以同时对多条规则进行认证，并设置多条规则的关系（or或者and）
 *      $auth=new Auth();  $auth->check('规则1,规则2','用户id','and')
 *      第三个参数为and时表示，用户需要同时具有规则1和规则2的权限。 当第三个参数为or时，表示用户值需要具备其中一个条件即可。默认为or
 * 3，一个用户可以属于多个用户组(think_ROLE_MEMBER_RELEVANCE表 定义了用户所属用户组)。我们需要设置每个用户组拥有哪些规则(think_ROLE 定义了用户组权限)
 *
 * 4，支持规则表达式。
 *      在think_PERMISSION 表中定义一条规则时，如果type为1， condition字段就可以定义规则表达式。 如定义{score}>5  and {score}<100  表示用户的分数在5-100之间时这条规则才会通过。
 */

class Auth
{
  # 默认配置
  protected $_config = array(
    'AUTH_ON'               => true,                    // 认证开关
    'AUTH_TYPE'             => 1,                       // 认证方式，1为实时认证；2为登录认证。
    'ROLE'                  => 'role',                  // 角色数据表名
    'ROLE_MEMBER_RELEVANCE' => 'role_member_relevance', // 角色用户关联表
    'PERMISSION'            => 'permission',            // 权限规则表
    'MEMBER'                => 'member'                 // 用户信息表
  );

  public function __construct()
  {
    $prefix = C('DB_PREFIX');

    $this->_config['ROLE']                  = $prefix.$this->_config['ROLE'];
    $this->_config['PERMISSION']            = $prefix.$this->_config['PERMISSION'];
    $this->_config['MEMBER']                = $prefix.$this->_config['MEMBER'];
    $this->_config['ROLE_MEMBER_RELEVANCE'] = $prefix.$this->_config['ROLE_MEMBER_RELEVANCE'];

    if(C('AUTH_CONFIG'))
    {
      # 可设置配置项 AUTH_CONFIG, 此配置项为数组。
      $this->_config = array_merge($this->_config, C('AUTH_CONFIG'));
    }
  }

  /**
   * --------------------------------------------------------------------------------------
   * 检查权限
   *
   * @param name string|array  需要验证的规则列表,支持逗号分隔的权限规则或索引数组
   * @param uid  int           认证用户的id
   * @param string mode        执行check的模式
   * @param relation string    如果为 'or' 表示满足任一条规则即通过验证;如果为 'and'则表示需满足所有规则才能通过验证
   *
   * @return boolean           通过验证返回true;失败返回false
   */
  public function check($name, $uid, $type=1, $mode='url', $relation='or')
  {
    if(!$this->_config['AUTH_ON'])
    {
      return true;
    }

    $authList = $this->getAuthList($uid,$type); //获取用户需要验证的所有有效规则列表

    if(is_string($name))
    {
      $name = strtolower($name);

      if (strpos($name, ',') !== false)
      {
        $name = explode(',', $name);
      }
      else
      {
        $name = array($name);
      }
    }

    $list = array(); //保存验证通过的规则名

    if($mode=='url')
    {
      $REQUEST = unserialize( strtolower(serialize($_REQUEST)) );
    }

    foreach($authList as $auth)
    {
      $query = preg_replace('/^.+\?/U','',$auth);

      if($mode=='url' && $query!=$auth)
      {
        parse_str($query,$param); //解析规则中的param
        $intersect = array_intersect_assoc($REQUEST,$param);
        $auth = preg_replace('/\?.*$/U','',$auth);

        if( in_array($auth,$name) && $intersect==$param )
        {  //如果节点相符且url参数满足
          $list[] = $auth ;
        }
      }
      else if (in_array($auth , $name))
      {
        $list[] = $auth ;
      }
    }

    if($relation == 'or' and !empty($list))
    {
      return true;
    }

    $diff = array_diff($name, $list);

    if($relation == 'and' and empty($diff))
    {
      return true;
    }

    return false;
  }


  /**
   * --------------------------------------------------------------------------------------
   * 根据用户编号获取角色
   * @param  uid    int         用户id
   * @return res    array       角色 array(
   *                                        array('uid'=>'用户id',
   *                                              'group_id'=>'用户组id',
   *                                              'title'=>'用户组名称',
   *                                              'rules'=>'用户组拥有的规则id,多个,号隔开'
   *                                              ),
   *                                        ...)
   */
  public function getWithWhereRoleInfo($uid)
  {
    static $res = array();

    if(isset($res[$uid]))
    {
      return $res[$uid];
    }

    $list = M()->field('r.rules')
               ->table($this->_config['ROLE_MEMBER_RELEVANCE'] . ' l')
               ->join("LEFT JOIN ".$this->_config['ROLE']." r on l.rid=r.id")
               ->where("l.uid='$uid' and r.status='1'")
               ->select();

    $res[$uid] = $list ? $list : array();

    return $res[$uid];
  }

  /**
   * 获得权限列表
   * @param integer $uid  用户id
   * @param integer $type
   */
  protected function getAuthList($uid, $type)
  {
    static $_authList = array(); //保存用户验证通过的权限列表

    $t = implode(',',(array)$type);

    if(isset($_authList[$uid.$t]))
    {
      return $_authList[$uid.$t];
    }

    if($this->_config['AUTH_TYPE']==2 && isset($_SESSION['_AUTH_LIST_'.$uid.$t]))
    {
      return $_SESSION['_AUTH_LIST_'.$uid.$t];
    }

    # 读取用户所属用户组
    $groups = $this->getWithWhereRoleInfo($uid);

    # 保存用户所属用户组设置的所有权限规则id
    $ids = array();

    foreach($groups as $g)
    {
      $ids = array_merge($ids, explode(',', trim($g['rules'], ',')));
    }

    $ids = array_unique($ids);

    if(empty($ids))
    {
      $_authList[$uid.$t] = array();
      return array();
    }

    $map=array(
      'rid'=>array('in',$ids),
      'type'=>$type,
      'status'=>1,
    );

    //读取用户组所有权限规则
    $rules = M()->table($this->_config['PERMISSION'])->where($map)->field('condition,name')->select();

    //循环规则，判断结果。
    $authList = array();   //
    foreach ($rules as $rule)
    {
      if (!empty($rule['condition']))
      {
      //根据condition进行验证
        $user = $this->getUserInfo($uid);//获取用户信息,一维数组

        $command = preg_replace('/\{(\w*?)\}/', '$user[\'\\1\']', $rule['condition']);

        //dump($command);//debug
        @(eval('$condition=(' . $command . ');'));

        if ($condition)
        {
          $authList[] = strtolower($rule['name']);
        }
      }
      else
      {
        //只要存在就记录
        $authList[] = strtolower($rule['name']);
      }
    }

    $_authList[$uid.$t] = $authList;

    if($this->_config['AUTH_TYPE']==2)
    {
      //规则列表结果保存到session
      $_SESSION['_AUTH_LIST_'.$uid.$t]=$authList;
    }

    return array_unique($authList);
  }

  /**
   * 获得用户资料,根据自己的情况读取数据库
   */
  protected function getUserInfo($uid)
  {
    static $userinfo=array();

    if(!isset($userinfo[$uid]))
    {
      $userinfo[$uid]=M()->where(array('uid'=>$uid))->table($this->_config['MEMBER'])->find();
    }
    return $userinfo[$uid];
  }

}
