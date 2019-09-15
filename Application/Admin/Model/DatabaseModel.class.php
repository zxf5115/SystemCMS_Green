<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 前台菜单模型
 *     @english: ChannelModel.class.php
 *
 * @version: 1.0
 * @desc   : 前台菜单模型
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 14:42:11
 */
class DatabaseModel extends CommonModel
{


  public function getWithWhereCountTableInfo($table = '', $where = '')
  {
    $list  = M()->query("SELECT COUNT('TABLE_NAME') as total FROM information_schema.tables WHERE Table_Schema='".$table."' ".$where);

    return $list[0]['total'];
  }

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
  public function getWithWhereCurrentTableDetailInfo($table = '', $where = '', $group = '', $limit = '')
  {
    if($limit)
    {
      $limit = ' LIMIT '.$limit;
    }
    $list  = M()->query("SELECT * FROM information_schema.tables WHERE Table_Schema='".$table."' ".$where." ".$group." ".$limit);
    $result  = array_map('array_change_key_case', $list);

    return $result;
  }
}
