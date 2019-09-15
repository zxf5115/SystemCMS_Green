<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: UV模型
 *     @english: UVModel.class.php
 *
 * @version: 1.0
 * @desc   : UV模型
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 14:42:11
 */
use Think\Model;

class UVModel extends CommonModel
{
  private $table = 'unique_visitor'; # UV信息表

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
    array('update_time', 'time', self::MODEL_BOTH, 'function'),
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
  public function doSaveUvDataAction()
  {
    $where['ip_adress'] = get_client_ip(1);

    $result = $this->getWithWhereTableInfo($where);

    $update_time = $result[0]['update_time'];

    $yesterday = strtotime(date('Y-m-d H:i:m', strtotime('-1 day')));
    $today     = strtotime(date('Y-m-d H:i:m'));

    if(is_null($update_time) || ($yesterday > $update_time || $today <= $update_time))
    {
      $info['browser']     = get_client_browser();
      $info['ip_address']  = get_client_ip(1);
      $info['system']      = get_client_language();
      $info['language']    = get_client_system();
      $info['update_time'] = time();

      $this->doSaveFromDataAction($info);
    }
  }


# + ----------------------------------------------------------------------------------------------
# + 统计

  /**
   * --------------------------------------------------------------------------------------
   * 昨日UV量统计
   */
  public function getWithWhereUvCount()
  {
    $yesterday = strtotime(date('Y-m-d 00:00:00', strtotime('-1 day')));
    $today     = strtotime(date('Y-m-d 00:00:00'));

    $where['update_time'] = array(array('lt', $today), array('egt', $yesterday), 'AND');

    $current = $this->getWithWhereTableInfo($where, 'FROM_UNIXTIME(update_time,"%Y-%m-%d") AS data, count(id) AS val', 'update_time ASC', 1, 'FROM_UNIXTIME(update_time,"%Y-%m-%d")');


    $list['scale']   = number_format(($current[0]['val'] / 100) * 100, 2, '.', '');
    $list['current'] = $current[0]['val'];

    return $list;
  }
}
