<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 钩子模型
 *     @english: HooksModel.class.php
 *
 * @version: 1.0
 * @desc   : 系统用到的钩子模型
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-06-18 10:44:11
 */
class HooksModel extends CommonModel
{
  private $table = 'hooks';

  /**
   * --------------------------------------------------------------------------------------
   * 钩子模型数据验证
   */
  protected $_validate = array(
    array('name', 'require', '钩子名称必须！'), # 默认情况下用正则进行验证
    array('description', 'require', '钩子描述必须！'), # 默认情况下用正则进行验证
  );

  /**
   * --------------------------------------------------------------------------------------
   * 钩子模型自动完成
   */
  protected $_auto = array(
    array('update_time', NOW_TIME, self::MODEL_BOTH),
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
   * 更新插件里的所有钩子对应的插件
   */
  public function doUpdateHookAction($addons_name)
  {
    # 获取插件名
    $addons_class = get_addon_class($addons_name);

    if(!class_exists($addons_class))
    {
      $this->error = "未实现{$addons_name}插件的入口文件";
      return false;
    }

    $methods = get_class_methods($addons_class);

    $hooks = $this->getWithWhereTableOneFieldInfo('', 'name', '', true);

    $common = array_intersect($hooks, $methods);

    if(!empty($common))
    {
      foreach($common as $hook)
      {
        $flag = $this->doUpdateAddonAction($hook, array($addons_name));

        if(false === $flag)
        {
          $this->doRemoveHookAction($addons_name);
          return false;
        }
      }
    }

    return true;
  }



  /**
   * --------------------------------------------------------------------------------------
   * 更新单个钩子处的插件
   */
  public function doUpdateAddonAction($hook_name, $addons_name)
  {
    $where['name'] = $hook_name;
    $old_addons = $this->getWithWhereTableOneFieldInfo('', 'addons');

    if($old_addons)
    {
      $old_addons = str2arr($old_addons);
    }

    if($old_addons)
    {
      $addons = array_merge($old_addons, $addons_name);
      $addons = array_unique($addons);
    }
    else
    {
      $addons = $addons_name;
    }

    $field = 'addons';
    $value = arr2str($addons);

    $flag = $this->doUpdateTableFieldAction($where, $field, $value);

    if(false === $flag)
    {
      $value = arr2str($old_addons);
      $this->doUpdateTableFieldAction($where, $field, $value);
    }

    return $flag;
  }


  /**
   * --------------------------------------------------------------------------------------
   * 去除插件所有钩子里对应的插件数据
   */
  public function doRemoveHookAction($addons_name)
  {
    $addons_class = get_addon_class($addons_name);

    if(!class_exists($addons_class))
    {
      return false;
    }

    $methods = get_class_methods($addons_class);

    $hooks = $this->getWithWhereTableOneFieldInfo('', 'name', '', true);

    $common = array_intersect($hooks, $methods);

    if($common)
    {
      foreach($common as $hook)
      {
        $flag = $this->doRemoveAddonAction($hook, array($addons_name));

        if(false === $flag)
        {
          return false;
        }
      }
    }

    return true;
  }


  /**
   * --------------------------------------------------------------------------------------
   * 去除单个钩子里对应的插件数据
   */
  public function doRemoveAddonAction($hook_name, $addons_name)
  {
    $where['name'] = $hook_name;
    $old_addons = $this->getWithWhereTableOneFieldInfo('', 'addons');

    $old_addons = str2arr($old_addons);

    if($old_addons)
    {
      $addons = array_diff($old_addons, $addons_name);
    }
    else
    {
      return true;
    }

    $field = 'addons';
    $value = arr2str($addons);

    $flag = $this->doUpdateTableFieldAction($where, $field, $value);

    if(false === $flag)
    {
      $value = arr2str($old_addons);
      $this->doUpdateTableFieldAction($where, $field, $value);
    }

    return $flag;
  }
}
