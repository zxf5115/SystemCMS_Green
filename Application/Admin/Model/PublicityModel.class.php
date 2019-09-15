<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 广告模型
 *     @english: AdvertisementModel.class.php
 *
 * @version: 1.0
 * @desc   : 广告模型
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 14:42:11
 */
use Think\Model;

class PublicityModel extends CommonModel
{
  private $table = 'publicity'; # 广告信息表

  /**
   * --------------------------------------------------------------------------------------
   * 广告模型数据验证
   */
  protected $_validate = array(
    array('title', 'require', '广告标题是必须填写的', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    array('title','0,20','广告标题多于二十个字，请进行删减',self::EXISTS_VALIDATE,'length', self::MODEL_BOTH),
    array('category', 'require', '广告分类是必须填写的', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    array('picture', 'require', '图片是必须填写的', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
  );

  /**
   * --------------------------------------------------------------------------------------
   * 广告模型自动完成
   */
  protected $_auto = array(
    array('status', 1, self::MODEL_INSERT, 'string'),
    array('create_time' , NOW_TIME, self::MODEL_INSERT),
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
      if(isset($row['category']))
      {
        $format = array(1=>'客户端',2=>'网站端');
        $row['category_format'] = $model->getFormatDataInfo($row['category'], 'status', $format);
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
