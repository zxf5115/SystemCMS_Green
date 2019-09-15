<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 模板管理模型类
 *     @english: CategoryModel.class.php
 *
 * @version: 1.0
 * @desc   : 模板逻辑实现
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 16:58:32
 */
class TemplateModel extends CommonModel
{
  private $table = 'page_template'; # 模板信息表

  /**
   * --------------------------------------------------------------------------------------
   * 模板模型数据验证
   */
  protected $_validate = array(
    array('pre_picture', 'require', '模板预览图片不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    array('cateid', 'require', '模板分类不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    array('name', 'require', '模板名称不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    array('name', '', '模板名称已经存在', self::MUST_VALIDATE, 'unique', self::MODEL_BOTH),
    array('temp_type', 'require', '模板类型不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    array('source', 'require', '模板来源不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    array('data_json', 'require', '模板代码不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
  );


  /**
   * --------------------------------------------------------------------------------------
   * 模板模型自动完成
   */
  protected $_auto = array(
    array('createtime', NOW_TIME, self::MODEL_INSERT),
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



# + ----------------------------------------------------------------------------------------------
# + 统计

  /**
   * --------------------------------------------------------------------------------------
   * 根据条件统计发布类型信息
   */
  public function getWithWhereTemplateStat($start, $end, $limit = 12)
  {
    //$where['status'] = array('gt', -1);

    $lstart = strtotime($start);
    $rend   = strtotime($end);
    $where['createtime'] = array(array('egt', $lstart), array('lt', $rend));

    $list = $this->getWithWhereTableInfo($where, 'id, name, usecount', 'usecount DESC', '', $limit);

    $total = $this->getWithWhereCountTableInfo($where, 'sum', 'usecount');

    $sum = $total;
    $str = '';
    $gap = '';
    foreach($list as $k => $vo)
    {
      $gap .= '"'.$vo['name'].'",';
      $str .= $vo['usecount'].',';
      $sum = $sum - $vo['usecount'];
    }

    $data['gap'] = $gap.'"其他模板"';
    $data['str'] = $str.$sum;

    return $data;
  }

  /**
   * --------------------------------------------------------------------------------------
   * 根据条件统计发布类型信息
   */
  public function getWithWhereCategoryTypeStat($start, $end, $limit = 15)
  {
    //$where['status'] = array('gt', -1);

    $lstart = strtotime($start);
    $rend   = strtotime($end);
    $where['createtime'] = array(array('egt', $lstart), array('lt', $rend));

    $list = $this->getWithWhereTableInfo($where, 'id, name as title, usecount as total', 'usecount DESC', '', $limit);

    $total = $this->getWithWhereCountTableInfo($where, 'sum', 'usecount');

    $sum = $total;

    foreach($list as $k => &$vo)
    {
      $vo['than']  = round($vo['total']  / $total * 100).'%';
    }

    return array_values($list);
  }


  /**
   * --------------------------------------------------------------------------------------
   * 根据条件统计发布类型信息
   */
  public function getWithWhereCategoryTypePagingStat($start, $end, $limit = 15)
  {
    $page = I('get.p', '', 'op_t');

    # 获取分页参数
    $nowPage = intval($page) > 1 ? intval($page) : 1;

    //$where['status'] = array('gt', -1);

    $lstart = strtotime($start);
    $rend   = strtotime($end);
    $where['createtime'] = array(array('egt', $lstart), array('lt', $rend));

    $sum = count($this->getWithWhereTableInfo($where, 'id'));

    # 调用父类数据分页方法 参数:$model ,$nowPage ,$where ,$field
    $result = $this->getWithWhereTablePagingInfo($nowPage, $where, 'id, name as title, usecount as total' ,'usecount DESC', 'id', '', $sum);

    $total = $this->getWithWhereCountTableInfo($where, 'sum', 'usecount');



    $sum = $total;

    foreach($result['data'] as $k => &$vo)
    {
      $vo['than']  = round($vo['total']  / $total * 100).'%';
    }

    return $result;
  }

}
