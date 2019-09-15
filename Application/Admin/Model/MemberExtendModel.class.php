<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 用户扩展模型
 *     @english: MemberExtendModel.class.php
 *
 * @version: 1.0
 * @desc   : 用户扩展模型
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 14:42:11
 */
class MemberExtendModel extends CommonModel
{
  private $table = 'member_extend'; # 用户信息扩展表


  /**
   * --------------------------------------------------------------------------------------
   * 用户扩展模型数据验证
   */
  protected $_validate = array(
    array('nickname', 'require', '管理员昵称必须', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    array('picture' , 'require', '管理员头像必须', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
  );


  /**
   * --------------------------------------------------------------------------------------
   * 用户扩展模型自动完成
   */
  protected $_auto = array(
    array('update_time', 'time', self::MODEL_BOTH, 'function'),
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
# + 查询

  /**
   * --------------------------------------------------------------------------------------
   * 根据用户编号查询用户信息
   */
  public function getNickName($uid)
  {
    $where['uid'] = $uid;
    $field = 'nickname';
    $result = $this->getWithWhereTableOneFieldInfo($where, $field);

    return $result;
  }


# + ----------------------------------------------------------------------------------------------
# + 逻辑


  /**
   * --------------------------------------------------------------------------------------
   * 保存表单提交数据
   */
  public function doSaveFromDataAction($info, $id = '')
  {
    $result = $this->doCreateDataAction($info, $this->_validate, $this->_auto, '', $id);

    return $result;
  }

}
