<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 分类关联模型
 *     @english: CategoryRelationModel.class.php
 *
 * @version: 1.0
 * @desc   : 分类关联模型
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2016-05-26 10:10:25
 */
use Think\Model;

class CategoryRelationModel extends CommonModel
{
  private $table = 'category_relevance'; # 分类关联模型信息表

  /**
   * --------------------------------------------------------------------------------------
   * 分类模型数据验证
   */
  protected $_validate = array(
    array('type', 'require', '分类类型是必须选择的', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    array('oid', 'require', '对象编号是必须选择的', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    array('cid', 'require', '分类编号是必须选择的', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
  );

  /**
   * --------------------------------------------------------------------------------------
   * 分类模型自动完成
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
