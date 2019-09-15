<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 权限管理模型类
 *     @english: PermissionModel.class.php
 *
 * @version: 1.0
 * @desc   : 权限逻辑实现
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 16:58:32
 */
class PermissionModel extends CommonModel
{
  private $table = 'permission';   # 权限信息表

  const RULE_URL  = 1;
  const RULE_MAIN = 2;

  /**
   * --------------------------------------------------------------------------------------
   * 初始化数据表信息
   */
  public function __construct()
  {
    parent::__construct($this->table);
  }


  public function getDataTable()
  {
    return M($this->table);
  }


# + ----------------------------------------------------------------------------------------------
# + 逻辑


}