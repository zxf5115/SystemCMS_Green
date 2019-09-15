<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 行为模型
 *     @english: ActionhModel.class.php
 *
 * @version: 1.0
 * @desc   : 行为模型
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 14:42:11
 */
use Think\Model;

class ActionModel extends CommonModel
{
  private $table = 'action'; # 行为信息表

  /**
   * --------------------------------------------------------------------------------------
   * 钩子模型数据验证
   */
  protected $_validate = array(
    array('name', 'require', '行为标识必须', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    array('name', '/^[a-zA-Z]\w{0,39}$/', '行为标识不合法', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    array('title', 'require', '行为名称不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    array('title', '1,80', '行为名称长度不能超过80个字符', self::MUST_VALIDATE, 'length', self::MODEL_BOTH),
    array('remark', 'require', '行为描述不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    array('remark', '1,140', '行为描述不能超过140个字符', self::MUST_VALIDATE, 'length', self::MODEL_BOTH)
  );

  /**
   * --------------------------------------------------------------------------------------
   * 钩子模型自动完成
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


  /* --------------------------------------------------------------------------------------
   * 根据条件查询数据表信息
   *
   * @param  Array   $where   查询数据条件
   * @param  String  $field   查询字段
   * @param  String  $order   排序条件
   * @param  String  $status  数据状态
   *
   * @return Array   $result  查询结果集
   */
  public function getWithWhereCurrentTableDetailInfo($where = array(), $field = true, $order = 'id DESC', $status = -1, $group = '', $limit = '')
  {
    // $where = format_where_condition($where, 'l');  # 查询条件格式化 {方法位于:Application\Common\Common\uyeah_extend.php }

    $result = M($this->table) ->field('*')
                              ->where($where)
                              ->group($group)
                              ->order($order)
                              ->limit($limit)
                              ->select();

    return $result;
  }





# + ----------------------------------------------------------------------------------------------
# + 内部逻辑

  /**
   * --------------------------------------------------------------------------------------
   * 根据条件格式化数据
   *
   * @param  array    $data   格式化前数据
   *
   * @return array    $data   格式化后数据
   */
  private function getWithWhereFormatDataInfo($data)
  {
    $format = null;

    if(empty($data))
    {
      return '格式化数据有误！';
    }

    if(empty($format))
    {
      import("Admin.Plugin.FormatPlugin");

      $format = new FormatPlugin();
    }

    foreach($data as $k => $v)
    {
      if(isset($row['type']))
      {
        $format = array(1 => '系统行为', 2 => '用户行为');
        $data[$key]['type_format'] = $format->getFormatDataInfo($row['type'], 'status', $format);
      }

      if(isset($row['status']))
      {
        $data[$key]['status_format'] = $format->getFormatDataInfo($row['status'], 'status');
      }

      if(isset($row['update_time']))
      {
        $data[$key]['update_time_format'] = $format->getFormatDataInfo($row['update_time'], 'date');
      }

      if(isset($row['create_time']))
      {
        $data[$key]['create_time_format'] = $format->getFormatDataInfo($row['create_time'], 'date');
      }
    }

    return $data;
  }
}
