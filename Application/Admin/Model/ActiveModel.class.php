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
class ActiveModel extends CommonModel
{
  private $table = 'active'; # 活跃量信息表

  /**
   * --------------------------------------------------------------------------------------
   * 分类模型数据验证
   */
  protected $_validate = array(
    // array('personage_id'      , 'require', '人物编号不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
    // array('title'      , 'require', '商品标题不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
    // array('price'      , 'require', '商品价格不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
    // array('amount'      , 'require', '商品数量不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
    // array('description'      , 'require', '商品介绍不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
    // array('note'      , 'require', '商品注意事项不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
  );

  /**
   * --------------------------------------------------------------------------------------
   * 分类模型自动完成
   */
  protected $_auto = array(
    array('create_time', NOW_TIME, self::MODEL_INSERT),
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



# + ----------------------------------------------------------------------------------------------
# + 统计

  /**
   * --------------------------------------------------------------------------------------
   * 昨日活跃量统计
   */
  public function getWithWhereActiveCount($where = array())
  {
    $yesterday = strtotime(date('Y-m-d', strtotime('-1 day')));
    $today     = strtotime(date('Y-m-d'));

    $map['create_time'] = array(array('lt', $today), array('egt', $yesterday), 'AND');

    $where = array_merge($map, $where);

    $result = $this->getWithWhereCountTableInfo($where, 'count', 'id');

    return $result;
  }
}
