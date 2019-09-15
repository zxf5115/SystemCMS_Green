<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 配置模型
 *     @english: ConfigModel.class.php
 *
 * @version: 1.0
 * @desc   : 配置模型
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 14:42:11
 */
use Think\Model;

class ConfigModel extends CommonModel
{
  private $table = 'config'; # 配置信息表

  /**
   * --------------------------------------------------------------------------------------
   * 配置模型数据验证
   */
  protected $_validate = array(
    array('name' , 'require', '配置名称不能为空', self::EXISTS_VALIDATE, 'regex' , self::MODEL_BOTH),
    array('name' , ''       , '配置名称已经存在', self::VALUE_VALIDATE , 'unique', self::MODEL_BOTH),
    array('title', 'require', '配置说明不能为空', self::MUST_VALIDATE  , 'regex' , self::MODEL_BOTH),
  );


  /**
   * --------------------------------------------------------------------------------------
   * 配置模型数据验证
   */
  protected $_auto = array(
    array('name'       , 'strtoupper', self::MODEL_BOTH, 'function'),
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


  /**
   * --------------------------------------------------------------------------------------
   * 获取配置列表
   *
   * @return array    配置数组
   */
  public function getWithWhereConfigListInfo()
  {
    $map  = array('status' => 1);

    $field = 'type, name, value';

    $data = $this->getWithWhereTableInfo($map, $field, 'id ASC');

    $config = array();

    if($data && is_array($data))
    {
      foreach ($data as $value)
      {
        $config[$value['name']] = $this->parse($value['type'], $value['value']);
      }
    }

    return $config;
  }



  /**
   * --------------------------------------------------------------------------------------
   * 根据配置类型解析配置
   *
   * @param  integer $type  配置类型
   * @param  string  $value 配置值
   *
   * @return array   $value 配置数组
   */
  private function parse($type, $value)
  {
    switch ($type)
    {
      case 3: //解析数组
        $array = preg_split('/[,;\r\n]+/', trim($value, ",;\r\n"));

        if(strpos($value,':'))
        {
          $value  = array();
          foreach ($array as $val)
          {
            list($k, $v) = explode(':', $val);
            $value[$k]   = $v;
          }
        }
        else
        {
          $value =    $array;
        }
        break;
    }

    return $value;
  }
}
