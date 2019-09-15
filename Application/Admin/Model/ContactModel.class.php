<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 分类模型
 *     @english: CategoryModel.class.php
 *
 * @version: 1.0
 * @desc   : 分类模型
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2016-05-26 10:10:25
 */
use Think\Model;

class ContactModel extends CommonModel
{
  private $table = 'contact'; # 意见模型信息表

  /**
   * --------------------------------------------------------------------------------------
   * 分类模型数据验证
   */
  protected $_validate = array(
    array('email', 'require', '联系邮箱不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    array('email', 'email', '联系邮箱格式不正确！', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),
    array('name', 'require', '姓名不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    array('content', 'require', '内容不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
  );

  /**
   * --------------------------------------------------------------------------------------
   * 分类模型自动完成
   */
  protected $_auto = array(
    array('status', 1, self::MODEL_INSERT, 'string'),
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
        $row['pid_format'] = $model->getFormatDataInfo($row['pid'], 'field', 'Category', 'id', 'title');
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
