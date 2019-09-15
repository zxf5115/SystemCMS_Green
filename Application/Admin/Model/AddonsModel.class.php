<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 插件模型
 *     @english: AddonsModel.class.php
 *
 * @version: 1.0
 * @desc   : 系统用到的插件模型
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-06-18 10:44:11
 */
class AddonsModel extends CommonModel
{

  private $table = 'addons';


  /**
   * --------------------------------------------------------------------------------------
   * 插件模型数据验证
   */
  protected $_validate = array(
    array('name', 'require', '插件名必须', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    array('name', '/^[a-zA-Z]\w{0,39}$/', '插件名不合法', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    array('name', '', '插件名已经存在', self::MUST_VALIDATE, 'unique', self::MODEL_BOTH),
    array('title', 'require', '中文名不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    array('title', '1,80', '中文名长度不能超过80个字符', self::MUST_VALIDATE, 'length', self::MODEL_BOTH),
    array('description', 'require', '插件描述不能为空', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
    array('description', '1,140', '插件描述不能超过140个字符', self::MUST_VALIDATE, 'length', self::MODEL_BOTH)
  );

  /**
   * --------------------------------------------------------------------------------------
   * 插件模型自动完成
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



  /**
   * 查找后置操作
   */
  protected function _after_find(&$result,$options)
  {

  }

  protected function _after_select(&$result,$options)
  {
    foreach($result as &$record)
    {
      $this->_after_find($record,$options);
    }
  }


# + ----------------------------------------------------------------------------------------------
# + 逻辑

  /**
   * --------------------------------------------------------------------------------------
   * 保存表单提交数据
   */
  public function doSaveFromDataAction($info)
  {
    $result = $this->doCreateDataAction($info, $this->_validate, $this->_auto, true);

    return $result;
  }



  /**
   * --------------------------------------------------------------------------------------
   * 获取插件列表
   *
   * @param string $addon_dir 插件目录
   */
  public function getAddonsListInfo($addon_dir = '')
  {
    # 如果没有传入插件目录，调用默认目录
    if(empty($addon_dir))
    {
      $addon_dir = ADDON_PATH;
    }

    # 得到插件目录下的目录项
    $res = glob($addon_dir.'*', GLOB_ONLYDIR);

    # 得到目录项的目录名
    $dir = array_map('basename', $res);

    if($dir === FALSE || !file_exists($addon_dir))
    {
      $this->error = '插件目录不可读或者不存在';
      return FALSE;
    }

    $addons = array();

    $where['name'] = array('in', $dir);
    $list = D('Addons')->getWithWhereTableInfo($where, '', 'id ASC', array('gt', -1));

    foreach($list as $addon)
    {
      $addon['uninstall'] = 0;
      $addons[$addon['name']]	=	$addon;
    }

    foreach ($dir as $value)
    {
      if(!isset($addons[$value]))
      {
        # 获取插件的类名
        $class = get_addon_class($value);

        # 实例化插件失败忽略执行
				if(!class_exists($class))
        {
          # 记录日志信息
					\Think\Log::record('插件'.$value.'的入口文件不存在！');
					continue;
				}

        $obj = new $class;
        $addons[$value]	= $obj->info;

        if($addons[$value])
        {
          $addons[$value]['uninstall'] = 1;
          unset($addons[$value]['status']);
        }
      }
    }

    int_to_string($addons, array('status'=>array(-1=>'损坏', 0=>'禁用', 1=>'启用', null=>'未安装')));
    $addons = list_sort_by($addons, 'uninstall', 'desc');

    return $addons;
  }


  /**
   * --------------------------------------------------------------------------------------
   * 获取插件的后台列表
   */
  public function getInstalledAddonListInfo()
  {
    $result = array();

    $where['has_adminlist'] = 1;
    $field = 'title, name';

    $data = $this->getWithWhereTableInfo($where, $field, 'id ASC');

    if($data)
    {
      foreach ($data as $value)
      {
        $result[] = array('title'=>$value['title'], 'url'=>"Addons/installed?name={$value['name']}");
      }
    }

    return $result;
  }
}
