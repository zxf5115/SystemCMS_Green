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
}
