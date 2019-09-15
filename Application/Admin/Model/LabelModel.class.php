<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 标签模型
 *     @english: CategoryModel.class.php
 *
 * @version: 1.0
 * @desc   : 标签模型
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2016-05-26 10:10:25
 */
use Think\Model;

class LabelModel extends CommonModel
{
  private $table = 'label'; # 标签模型信息表

  /**
   * --------------------------------------------------------------------------------------
   * 标签模型数据验证
   */
  protected $_validate = array(
    array('type', 'require', '标签类型是必须选择的', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    array('title', 'require', '标签名称不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    array('title', '0,20', '标签名称长度不能超过二十个字符', self::MUST_VALIDATE, 'length', self::MODEL_BOTH),
    array('description', '0,200', '标签描述不能超过二百个字符', self::MUST_VALIDATE, 'length', self::MODEL_BOTH)
  );

  /**
   * --------------------------------------------------------------------------------------
   * 标签模型自动完成
   */
  protected $_auto = array(
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
  public function getWithWhereFormatDataInfo(Array &$data)
  {
    $model = null;

    if(empty($data))
    {
      return '格式化数据有误！';
    }

    if(empty($model))
    {
      import("Admin.Plugin.FormatPlugin");

      $model = new FormatPlugin();
    }

    foreach($data as &$row)
    {
      if(isset($row['type']))
      {
        $format = array(1 => '游记', 2 => '随笔');
        $row['type_format'] = $model->getFormatDataInfo($row['type'], 'status', $format);
      }

      if(isset($row['pid']))
      {
        $format = array(1 => '游记', 2 => '随笔');
        $row['pid_format'] = $model->getFormatDataInfo($row['pid'], 'field', 'Label', 'id', 'title');
      }

      if(isset($row['status']))
      {
        $row['status_format'] = $model->getFormatDataInfo($row['status'], 'status');
      }

      if(isset($row['create_time']))
      {
        $row['create_time_format'] = $model->getFormatDataInfo($row['create_time'], 'date');
      }
    }
  }
}
