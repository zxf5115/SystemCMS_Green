<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 角色扩展模型
 *     @english: RoleExtendModel.class.php
 *
 * @version: 1.0
 * @desc   : 角色扩展模型
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 16:58:32
 */
class RoleExtendModel extends CommonModel
{
  private $table = 'role_extend'; # 角色扩展信息表

  const CATEGORY_TYPE = 1;  # 分类权限标识

  /**
   * --------------------------------------------------------------------------------------
   * 初始化数据表信息
   */
  public function __construct()
  {
    parent::__construct($this->table);
  }


# + ----------------------------------------------------------------------------------------------
# + 逻辑

  /**
   * --------------------------------------------------------------------------------------
   * 获取用户组授权的分类id列表
   *
   * @param int     $gid  用户组id
   *
   * @return array  array(2,4,8,13)
   */
  public function getRoleExtendCategoryInfo($rid)
  {
    return $this->getRoleExtendCategoryDetailInfo($rid, self::CATEGORY_TYPE);
  }



  /**
   * --------------------------------------------------------------------------------------
   * 获取授权的角色扩展信息数据
   *
   * @param int     $gid  用户组id
   *
   * @return array  array(2,4,8,13)
   */
  public function getRoleExtendCategoryDetailInfo($rid, $type)
  {
    if(!is_numeric($type))
    {
      return false;
    }

    $map['rid'] = $rid;
    $map['type'] = $type;

    $field = 'cid';

    $res = $this->getWithWhereTableOneFieldInfo($map, $field);

    return $res;
  }



  /**
   * --------------------------------------------------------------------------------------
   * 批量设置用户组可管理的扩展权限数据
   *
   * @param int|string|array $gid   用户组id
   * @param int|string|array $cid   分类id
   */
  static public function addToExtend($rid, $cid, $type)
  {
    $rid = is_array($rid) ? implode(',',$rid) : trim($rid,',');
    $cid = is_array($cid) ? $cid : explode( ',',trim($cid,',') );

    $map['rid']  = array('in',$rid);
    $map['type'] = $type;

    $del = $this->doDeleteTableAction($map);

    $rid = explode(',',$rid);
    $add = array();

    if($del!==false)
    {
      foreach($rid as $r)
      {
        foreach($cid as $c)
        {
          if(is_numeric($r) && is_numeric($c))
          {
            $add[] = array('rid'=>$r, 'cid'=>$c, 'type'=>$type);
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


  /**
   * --------------------------------------------------------------------------------------
   * 批量设置用户组可管理的分类
   *
   * @param int|string|array $gid   用户组id
   * @param int|string|array $cid   分类id
   */
  static public function addToCategory($gid, $cid)
  {
    return self::addToExtend($gid, $cid, self::CATEGORY_TYPE);
  }
}