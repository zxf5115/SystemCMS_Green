<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 日志模型
 *     @english: LogModel.class.php
 *
 * @version: 1.0
 * @desc   : 日志模型
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 14:42:11
 */
class LogModel extends CommonModel
{
  private $table = 'log'; # 日志信息表

  /**
   * --------------------------------------------------------------------------------------
   * 日志模型数据验证
   */
  protected $_validate = array(
    array('action_id', 'require', '行为标识必须'        , self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    array('user_id'  , 'require', '执行用户标识已经存在', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
  );

  /**
   * --------------------------------------------------------------------------------------
   * 日志模型自动完成
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
    parent::__construct($this->table);
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
  public function doDeleteActionLogAction($where = array())
  {
    $result = M()->table($this->ActionLogTable)
                 ->where($where)
                 ->delete();

    return $result;
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
  public function getWithWhereCurrentTableDetailInfo($where = array(), $field = true, $order = 'id DESC', $status = -1, $group = '', $limit = '')
  {
    $where = format_where_condition($where, 'l');  # 查询条件格式化 {方法位于:Application\Common\Common\uyeah_extend.php }

    $result = M($this->table.' l ') ->field('l.*, r.username')
                              ->join('LEFT JOIN member r ON r.id = l.user_id')
                              ->where($where)
                              ->group($group)
                              ->order($order)
                              ->limit($limit)
                              ->select();

    return $result;
  }
}
