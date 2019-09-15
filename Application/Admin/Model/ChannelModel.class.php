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
class ChannelModel extends CommonModel
{
  private $table = 'channel'; # 前台菜单信息表

  /**
   * --------------------------------------------------------------------------------------
   * 前台菜单模型数据验证
   */
  protected $_validate = array(
    array('title', 'require', '标题不能为空', self::MUST_VALIDATE, 'regex' , self::MODEL_BOTH),
    array('title' , ''      , '标题已经存在', self::MUST_VALIDATE, 'unique', self::MODEL_BOTH),
    array('url'  , 'require', 'URL不能为空' , self::MUST_VALIDATE, 'regex' , self::MODEL_BOTH),
    array('url'  , ''       , 'URL已经存在' , self::MUST_VALIDATE, 'unique', self::MODEL_BOTH),
  );


  /**
   * --------------------------------------------------------------------------------------
   * 前台菜单模型自动完成
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
}
