<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 角色模型
 *     @english: RoleModel.class.php
 *
 * @version: 1.0
 * @desc   : 角色模型
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 16:58:32
 */
use Think\Model;

class RoleModel extends CommonModel
{
  private $table      = 'role'; # 角色信息表
  private $righttable = 'role_member_relevance'; # 角色用户关联信息表

  /**
   * --------------------------------------------------------------------------------------
   * 角色模型数据验证
   */
  protected $_validate = array(
    array('title', '', '角色标题已经存在', self::MUST_VALIDATE, 'unique', self::MODEL_BOTH),
    array('title'      , 'require', '角色名称不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
  );


  /**
   * --------------------------------------------------------------------------------------
   * 角色模型自动完成
   */
  protected $_auto = array(
    array('update_time', 'time', self::MODEL_BOTH, 'function'),
    array('status', 1, self::MODEL_INSERT, 'string'),
    array('create_time', NOW_TIME, self::MODEL_INSERT),
    array('founder', 'get_username', self::MODEL_INSERT, 'function', get_uid),
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
  public function getWithWhereCurrentTableDetailInfo($where = array(), $field = true, $order = 'id DESC', $status = -1, $group = '', $limit = '')
  {
    // $where = format_where_condition($where, 'l');  # 查询条件格式化 {方法位于:Application\Common\Common\uyeah_extend.php }

    $result = M($this->table) ->field('*')
                              ->where($where)
                              ->group($group)
                              ->order($order)
                              ->limit($limit)
                              ->select();

    return $result;
  }

  /**
   * --------------------------------------------------------------------------------------
   * 根据条件查询用户信息
   */
  public function getWithWhereRoleUserRelInfo($where = array(), $status = 1, $order = '', $field = true)
  {
    $result = $this->getWithWhereTableDetailInfo($where, $field, $order, $status, 'id', 'rid');

    return $result;
  }


# + ----------------------------------------------------------------------------------------------
# + 删除

  /**
   * --------------------------------------------------------------------------------------
   * 删除角色关联操作
   *
   * @param  array     $where        [删除条件]
   * @param  array     $where_extend [删除条件]
   *
   * @return [boolean]        [是否成功]
   */
  public function doDeleteRoleAction($where = array(), $where_extend = array())
  {
    # 角色表
    $res               = $this->doDeleteTableAction($where);
    # 角色扩展表
    $res_extend        = D('RoleExtend')->doDeleteTableAction($where_extend);
    # 角色用户关联表
    $res_user_relation = D('RoleUserRelation')->doDeleteTableAction($where_extend);

    if($res || $res_extend || $res_user_relation)
    {
      return 1;
    }
    else
    {
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
   * 检查角色是否全部存在
   *
   * @param  array|string  $rid  [角色编号]
   *
   * @return [boolean]           [是否成功]
   */
  public function checkRoleId($rid)
  {
    return $this->checkId($rid, '以下角色编号不存在');
  }


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
    }
  }
}
