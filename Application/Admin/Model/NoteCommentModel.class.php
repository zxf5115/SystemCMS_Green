<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 随笔管理模型类
 *     @english: TravelModel.class.php
 *
 * @version: 1.0
 * @desc   : 随笔逻辑实现
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2016-03-24 16:58:32
 */
class NoteCommentModel extends CommonModel
{
  private $table = 'note_comment'; # 随笔讨论信息表

  /**
   * --------------------------------------------------------------------------------------
   * 随笔模型数据验证
   */
  protected $_validate = array(
    array('conetnt', 'require', '讨论内容不能为空', self::EXISTS_VALIDATE, 'regex', self::MODEL_BOTH),

  );


  /**
   * --------------------------------------------------------------------------------------
   * 随笔模型自动完成
   */
  protected $_auto = array(
    array('status', 1, self::MODEL_INSERT, 'string'),
    array('create_time', NOW_TIME, self::MODEL_INSERT),
    array('founder'    , 'get_username', self::MODEL_INSERT, 'function', get_uid),
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
      if(isset($row['status']))
      {
        $row['status_format'] = $model->getFormatDataInfo($row['status'], 'status');
      }

      if(isset($row['create_time']))
      {
        $row['create_time_format'] = $model->getFormatDataInfo($row['create_time'], 'date');
      }

      if(isset($row['nid']))
      {
        $row['title'] = $model->getFormatDataInfo($row['nid'], 'field', 'Note', 'id', 'title');
      }
    }
  }
}
