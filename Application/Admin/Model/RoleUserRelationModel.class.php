<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 角色用户关联模型
 *     @english: RoleUserRelationModel.class.php
 *
 * @version: 1.0
 * @desc   : 角色用户关联模型
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 16:58:32
 */
class RoleUserRelationModel extends CommonModel
{
  private $table      = 'role_member_relevance'; # 角色用户关联表
  private $righttable = 'member';                # 用户信息表

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

  /**
   * --------------------------------------------------------------------------------------
   * 根据条件查询用户信息
   */
  public function getWithWhereMemberRoleRelInfo($where = array(), $field = true, $order = '', $status = 1)
  {
    $result = $this->getWithWhereTableDetailInfo($where, $field, $order, $status, 'uid', 'id');

    return $result;
  }



# + ----------------------------------------------------------------------------------------------
# + 逻辑

  /**
   * --------------------------------------------------------------------------------------
   * 把用户添加到用户组,支持批量添加用户到用户组
   */
  public function addRoleUserRelation($uid, $rid)
  {
    $uid = is_array($uid) ? implode(',', $uid) : trim($uid, ',');
    $rid = is_array($rid) ? $rid : explode(',', trim($rid,' ,'));

    if(isset($_REQUEST['batch']) )
    {
      # 为单个用户批量添加用户组时,先删除旧数据
      $map['uid'] = array('IN', $uid);
      $del = $this->doDeleteTableAction($map);
    }

    $uid_arr = explode(',', $uid);
    $uid_arr = array_diff($uid_arr, array(C('USER_ADMINISTRATOR')));

    $add = array();

    if($del !== false)
    {
      foreach ($uid_arr as $u)
      {
        foreach ($rid as $r)
        {
          if( is_numeric($u) && is_numeric($r) )
          {
            $add[] = array('rid'=>$r, 'uid'=>$u);
          }
        }
      }

      $state = $this->doAddAllTableAction($add);
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
}