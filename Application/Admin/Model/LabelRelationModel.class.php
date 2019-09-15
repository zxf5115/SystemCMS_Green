<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 标签关联模型
 *     @english: LabelRelationModel.class.php
 *
 * @version: 1.0
 * @desc   : 标签关联模型
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2016-05-26 10:10:25
 */
use Think\Model;

class LabelRelationModel extends CommonModel
{
  private $table = 'label_relevance'; # 标签关联模型信息表

  /**
   * --------------------------------------------------------------------------------------
   * 标签模型数据验证
   */
  protected $_validate = array(
    array('type', 'require', '标签类型是必须选择的', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    array('oid', 'require', '对象编号是必须选择的', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    array('lid', 'require', '标签编号是必须选择的', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
  );

  /**
   * --------------------------------------------------------------------------------------
   * 标签模型自动完成
   */
  protected $_auto = array();


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
    $result = $this->doAddAllTableAction($info);

    return $result;
  }


# + ----------------------------------------------------------------------------------------------
# + 内部逻辑


}
