<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: PV模型
 *     @english: PVModel.class.php
 *
 * @version: 1.0
 * @desc   : PV模型
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 14:42:11
 */
use Think\Model;

class PVModel extends CommonModel
{
  private $table = 'page_view'; # PV信息表

  /**
   * --------------------------------------------------------------------------------------
   * 钩子模型数据验证
   */
  protected $_validate = array(
    array('ip_address', 'require', 'IP地址必须', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
  );

  /**
   * --------------------------------------------------------------------------------------
   * 钩子模型自动完成
   */
  protected $_auto = array(
    array('status', 1, self::MODEL_INSERT, 'string'),
    array('create_time', NOW_TIME, self::MODEL_INSERT),
    array('founder', '游客', self::MODEL_INSERT, 'string'),
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

  /**
   * --------------------------------------------------------------------------------------
   * 保存UV数据
   */
  public function doSavePvDataAction()
  {
    $info['ip_address']  = get_client_ip(1);

    $this->doSaveFromDataAction($info);
  }


# + ----------------------------------------------------------------------------------------------
# + 统计

  /**
   * --------------------------------------------------------------------------------------
   * 昨日UV量统计
   */
  public function getWithWherePvCount()
  {
    $yesterday = strtotime(date('Y-m-d 00:00:00', strtotime('-1 day')));
    $today     = strtotime(date('Y-m-d 00:00:00'));

    $where['create_time'] = array(array('lt', $today), array('egt', $yesterday), 'AND');

    $current = $this->getWithWhereTableInfo($where, 'FROM_UNIXTIME(create_time,"%Y-%m-%d") AS data, count(id) AS val', 'create_time ASC', 1, 'FROM_UNIXTIME(create_time,"%Y-%m-%d")');



    $list['scale']   = number_format(($current[0]['val'] / 100) * 100, 2, '.', '');
    $list['current'] = $current[0]['val'];

    return $list;
  }
}
