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
class KeywordModel extends CommonModel
{
  private $table = 'user_search'; # 搜索信息表



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
  public function getWithWhereKeywordStat($start, $end, $limit = 12)
  {
    # 关键字必须大于-1，-1为已删除
    $where['status'] = array('gt', -1);

    $lstart = strtotime($start);
    $rend   = strtotime($end);
    $where['createtime'] = array(array('egt', $lstart), array('lt', $rend));

    # 统计
    $list = $this->getWithWhereTableInfo($where, 'id, content as name, count(`content`) as y', 'y DESC', 'content', $limit);

    $str = '';
    $gap = '';
    foreach($list as $k => $vo)
    {
      $gap .= '"'.str_replace('&nbsp;', ' ', $vo['name']).'",';
      $str .= $vo['y'].',';
      $sum = $sum - $vo['y'];
    }

    # 如果关键字统计前十二位存在，加入其它关键字位
    if(count($list) == 12)
    {
      $data['gap'] = $gap.'"其他关键字"';
      $data['str'] = $str.$sum;
    }
    else
    {
      $data['gap'] = rtrim($gap, ',');
      $data['str'] = rtrim($str, ',');
    }

    return $data;
  }

  /**
   * --------------------------------------------------------------------------------------
   * 根据条件统计发布类型信息
   */
  public function getWithWhereKeywordTypeStat($start, $end, $limit = 15)
  {
    $where['status'] = array('gt', -1);

    $lstart = strtotime($start);
    $rend   = strtotime($end);
    $where['createtime'] = array(array('egt', $lstart), array('lt', $rend));

    $list = $this->getWithWhereTableInfo($where, 'id, content as title, count(`content`) as total', 'total DESC', 'content', $limit);

    $total = $this->getWithWhereCountTableInfo($where, 'count', 'content');

    $sum = $total;

    foreach($list as $k => &$vo)
    {
      $vo['than']  = round($vo['total']  / $total * 100).'%';
    }
    // dump($list);exit;
    return array_values($list);
  }

  /**
   * --------------------------------------------------------------------------------------
   * 根据条件统计发布类型信息
   */
  public function getWithWhereKeywordTypePagingStat($start, $end, $limit = 15)
  {
    $page = I('get.p', '', 'op_t');

    # 获取分页参数
    $nowPage = intval($page) > 1 ? intval($page) : 1;

    $where['status'] = array('gt', -1);

    $lstart = strtotime($start);
    $rend   = strtotime($end);
    $where['createtime'] = array(array('egt', $lstart), array('lt', $rend));

    $total = count($this->getWithWhereTableInfo($where, 'content', '', 'content'));

    # 调用父类数据分页方法 参数:$model ,$nowPage ,$where ,$field
    $result = $this->getWithWhereTablePagingInfo($nowPage, $where, 'id, content as title, count(`content`) as total' ,'total DESC', 'id', 'content', $total);

    $sum = $total;

    foreach($result['data'] as $k => &$vo)
    {
      $vo['than']  = round($vo['total']  / $total * 100).'%';
    }

    return $result;
  }
}
