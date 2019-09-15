<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 分类管理模型类
 *     @english: CategoryModel.class.php
 *
 * @version: 1.0
 * @desc   : 分类逻辑实现
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 16:58:32
 */
class MessageModel extends CommonModel
{
  private $table = 'message'; # 消息信息表

  /**
   * --------------------------------------------------------------------------------------
   * 分类模型数据验证
   */
  protected $_validate = array(
    # 验证推送内容以及字数
    array('content'      , 'require', '内容是必须填写的~', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
    array('content'      , '1,50', '内容多于50个字，请进行删减~', self::EXISTS_VALIDATE, 'length', self::MODEL_BOTH),
    # 验证时间
    array('push_time'      , 'require', '时间是必须填写的~', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
  );

  /**
   * --------------------------------------------------------------------------------------
   * 分类模型自动完成
   */
  protected $_auto = array(
    array('status', 1, self::MODEL_INSERT, 'string'),
    array('create_time', NOW_TIME, self::MODEL_INSERT),
  );



  /**
   * --------------------------------------------------------------------------------------
   * 初始化数据表信息
   */
  public function __construct()
  {
    parent::__construct($this->table, 'DB_CONFIG');
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
}
