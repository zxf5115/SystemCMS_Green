<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 系统公用模型
 *     @english: CommonModel.class.php
 *
 * @version: 1.0
 * @desc   : 此模型实现最基础的增删改查功能，其他具体业务模型继承此模型，实现代码重用
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-06-18 10:44:11
 */
use Think\Model;

class CommonModel extends Model
{
  private $table        = '';
  private $righttable   = '';
  private $ucfirsttable = '';
  private $prefix       = '';

  # 自动验证规则
  protected $_validate = array();

  # 自动完成规则
  protected $_auto = array();

  /**
   * --------------------------------------------------------------------------------------
   * 初始化数据表信息
   *
   * @param  String  $tableName 数据表表名（不含前缀）
   */
  public function __construct($tableName, $rightTableName = '')
  {
    parent::_initialize();

    $this->prefix = C('DB_PREFIX');

    # 首字母大写的数据表名
    $this->ucfirsttable = ucfirst($tableName);

    # 数据信息表
    $this->table  = $this->prefix.$tableName;

    if($rightTableName)
    {
      # 首字母大写的左关联数据表名
      $this->ucfirstrighttable = ucfirst($rightTableName);

      # 左关联数据信息表
      $this->righttable  = $this->prefix.$rightTableName;
    }
  }



# + ----------------------------------------------------------------------------------------------
# + 查询


  /**
   * --------------------------------------------------------------------------------------
   * 根据条件查询数据表的一个字段信息
   *
   * @param  Array   $where   查询数据条件
   * @param  String  $field   查询字段
   * @param  String  $status  数据状态
   *
   * @return Array   $result  查询结果集
   */
  public function getWithWhereTableOneFieldInfo($where = array(), $field = true, $status = 1, $flag = false)
  {
    $map = array('status' => $status);

    $map = array_merge($map, $where);

    $result = M() ->table($this->table)
                  ->where($map)
                  ->getField($field, $flag);

    return $result;
  }


  /**
   * --------------------------------------------------------------------------------------
   * 根据条件查询一条数据表信息
   *
   * @param  Array   $where   查询数据条件
   * @param  String  $field   查询字段
   * @param  String  $status  数据状态
   *
   * @return Array   $result  查询结果集
   */
  public function getWithWhereOneTableInfo($where = array(), $field = true, $status = 1)
  {
    $map = array('status' => $status);
    $map = array_merge($map, $where);

    $result = M() ->field($field)
                  ->table($this->table)
                  ->where($map)
                  ->find();

    return $result;
  }


  /**
   * --------------------------------------------------------------------------------------
   * 根据条件查询一条数据表详细信息
   *
   * @param  Array   $where   查询数据条件
   * @param  String  $field   查询字段
   * @param  String  $status  数据状态
   * @param  String  $lid     左表编号
   * @param  String  $rid     右表编号
   *
   * @return Array   $result  查询结果集
   */
  public function getWithWhereOneTableDetailInfo($where = array(), $field = true, $status = 1, $lid = 'id', $rid = 'uid')
  {
    $map = array('status' => $status);
    $map = array_merge($map, $where);

    # 查询条件格式化 {方法位于:Application\Common\Common\uyeah_extend.php }
    $map = format_where_condition($map, 'l');

    $result = M() ->field($field)
                  ->table($this->table.' l ')
                  ->join('LEFT JOIN '. $this->righttable.' r ON l.'.$lid.' = r.'.$rid)
                  ->where($map)
                  ->find();

    return $result;
  }



  /**
   * --------------------------------------------------------------------------------------
   * 根据条件查询数据表信息
   *
   * @param  Array   $where   查询数据条件
   * @param  String  $field   查询字段
   * @param  String  $order   排序条件
   * @param  String  $status  数据状态
   *
   * @return Array   $result  查询结果集
   */
  public function getWithWhereTableInfo($where = array(), $field = true, $order = 'create_time DESC', $status = 1, $group = '', $limit = 0)
  {
    $map = array('status' => $status);
    $map = array_merge($map, $where);

    $result = M() ->field($field)
                  ->table($this->table)
                  ->where($map)
                  ->group($group)
                  ->order($order)
                  ->limit($limit)
                  ->select();

    return $result;
  }


  /**
   * --------------------------------------------------------------------------------------
   * 根据条件查询数据表详细信息
   *
   * @param  Array   $where   查询数据条件
   * @param  String  $field   查询字段
   * @param  String  $order   排序条件
   * @param  String  $status  数据状态
   * @param  String  $lid     左表编号
   * @param  String  $rid     右表编号
   *
   * @return Array   $result  查询结果集
   */
  public function getWithWhereTableDetailInfo($where = array(), $field = true, $order = '', $status = 1, $lid = 'id', $rid = 'uid', $group = '')
  {
    $map = array('status' => $status);
    $map = array_merge($map, $where);

    $map = format_where_condition($map, 'l');  # 查询条件格式化

    $result = M() ->field($field)
                  ->table($this->table.' l ')
                  ->join('LEFT JOIN '. $this->righttable.' r ON l.'.$lid.' = r.'.$rid)
                  ->where($map)
                  ->group($group)
                  ->order($order)
                  ->select();

    return $result;
  }



  /**
   * SQL语句查询
   * --------------------------------------------------------------------------------------
   * 根据条件定位查询数据表信息
   *
   * @param  String  $where   SQL语句查询数据条件
   *
   * @return Array   $result  查询结果集
   */
  public function getQueryTableInfo($sql = '')
  {
    # 实例化一个model对象, 没有对应任何数据表
    $model = new Model();
    $result = $model->query($sql);

    return $result;
  }


  /**
   * 定位查询
   * --------------------------------------------------------------------------------------
   * 根据条件定位查询数据表信息
   *
   * @param  Array   $where     定位查询数据条件
   * @param  String  $order     定位查询排序条件
   * @param  String  $location  定位查询方式（first、last、getN）
   * @param  String  $value     需要定位查询的字段
   * @param  String  $status    数据状态
   *
   * @return Array   $result    查询结果集
   */
  public function getWithWhereLocationTableInfo($where = array(), $order = 'create_time DESC', $location = 'first', $value = '', $status = 1)
  {
    $map = array('status' => $status);
    $map = array_merge($map, $where);

    $result = M() ->table($this->table)
                  ->where($map)
                  ->order($order)
                  ->$location($value);

    return $result;
  }


  /**
   * 统计查询
   * --------------------------------------------------------------------------------------
   * 根据条件统计数据表信息
   *
   * @param  Array   $where   统计数据条件
   * @param  String  $mode    统计方式（count、max、min、avg、sum）
   * @param  String  $value   需要统计的字段
   * @param  String  $status  数据状态
   *
   * @return Array   $result  查询结果集
   */
  public function getWithWhereCountTableInfo($where = array(), $mode = 'count', $value = 'id', $status = 1)
  {
    $map = array('status' => $status);
    $map = array_merge($map, $where);

    $result = M() ->table($this->table)
                  ->where($map)
                  ->$mode($value);

    return $result;
  }


  /**
   * --------------------------------------------------------------------------------------
   * 根据条件查询数据表同步分页信息
   *
   * @param  String  $nowPage 当前页数
   * @param  Array   $where   查询数据条件
   * @param  String  $field   查询字段
   * @param  String  $order   排序条件
   *
   * @return Array   $result  查询分页结果集
   */
  public function getWithWhereTablePagingInfo($nowPage = 1, $where = array(), $field = '*', $order = 'create_time DESC', $listrows = '')
  {
    # 导入分页类
    import('Org.Util.CustomPage');

    # 获得总页数
    $count = $this->getWithWhereCountTableInfo($where);

    # 获取每页数量
    $linkPage = C('PAGE_LISTROWS');

    if($listrows)
    {
      $linkPage = $listrows;
    }

    # 创建分页对象
    $page = new CustomPage($count, $linkPage);

    $show = $page->show();

    $list = M() ->table($this->table)
                ->field($field)
                ->where($where)
                ->order($order)
                ->page($nowPage.','.$page->listRows)
                ->select();

    $result['data'] = $list;
    $result['show'] = $show;

    return $result;
  }



  /**
   * --------------------------------------------------------------------------------------
   * 根据条件查询数据表异步分页信息
   *
   * @param  Array   $where   查询数据条件
   * @param  String  $field   查询字段
   * @param  String  $order   排序条件
   * @param  String  $status  数据状态
   *
   * @return Array   $result  查询分页结果集
   */
  public function getWithWhereTableAjaxPagingInfo($where = array(), $field = true, $order = 'create_time DESC', $page = '', $function)
  {
    $model = M($this->table);

    # 导入分页类
    // Vendor('Custom.CustomPage');
    import('Vendor.Custom.CustomAjaxPage');

    # 查询满足要求的总记录数
    $count = $model->where($where)
                   ->count();
    # 实例化分页类 传入总记录数和每页显示的记录数
    $Page = new \CustomAjaxPage($count,4, $function, $page);

    # 分页显示输出
    $result['page'] = $Page->show();


    $result['data'] = $model ->field($field)
                             ->where($where)
                             ->order($order)
                             ->limit($Page->firstRow.', '.$Page->listRows)
                             ->select();

    return $result;
  }



# + ----------------------------------------------------------------------------------------------
# + 新增

  /**
   * --------------------------------------------------------------------------------------
   * 新增一条数据
   *
   * @param  array    $info       新增数据内容（一维数组）
   * @param  array    $validate   验证数组
   * @param  array    $auto       自动完成数组
   *
   * @return boolean  $result 是否成功
   */
  public function doAddTableAction($info = array(), $validate = array(), $auto = array())
  {
    $result = M()->table($this->table)
                 ->validate($validate)
                 ->auto($auto)
                 ->add($info);

    return $result;
  }


  /**
   * --------------------------------------------------------------------------------------
   * 新增多条数据
   *
   * @param  array    $info       新增数据内容（二维数组）
   *
   * @return boolean  $result 是否成功
   */
  public function doAddAllTableAction($info = array())
  {
    $result = M()->table($this->table)
                 ->addAll($info);

    return $result;
  }


# + ----------------------------------------------------------------------------------------------
# + 更新

  /**
   * --------------------------------------------------------------------------------------
   * 更新数据
   *
   * @param  Array     $where   更新条件
   * @param  Array     $info    更新信息
   *
   * @return boolean   $result  是否成功
   */
  public function doUpdateTableAction($where = array(), $info = array())
  {
    $result = M()->table($this->table)
                 ->where($where)
                 ->save($info);

    return $result;
  }


  /**
   * --------------------------------------------------------------------------------------
   * 更新一个字段数据
   *
   * @param  Array     $where   更新条件
   * @param  String    $field   更新字段
   * @param  String    $value   更新信息
   *
   * @return boolean   $result  是否成功
   */
  public function doUpdateTableFieldAction($where = array(), $field = '', $value = '')
  {
    $result = M()->table($this->table)
                 ->where($where)
                 ->setField($field, $value);

    return $result;
  }

  /**
   * --------------------------------------------------------------------------------------
   * 更新一个数字类型字段数据，向上增加
   *
   * @param  Array     $where   更新条件
   * @param  String    $field   更新字段
   * @param  String    $value   更新信息
   *
   * @return boolean   $result  是否成功
   */
  public function doUpdateTableFieldIncAction($where = array(), $field = '', $value = '')
  {
    $result = M()->table($this->table)
                 ->where($where)
                 ->setInc($field, $value);

    return $result;
  }


  /**
   * --------------------------------------------------------------------------------------
   * 更新一个数字类型字段数据，向下减少
   *
   * @param  Array     $where   更新条件
   * @param  String    $field   更新字段
   * @param  String    $value   更新信息
   *
   * @return boolean   $result  是否成功
   */
  public function doUpdateTableFieldDecAction($where = array(), $field = '', $value = '')
  {
    $result = M()->table($this->table)
                 ->where($where)
                 ->setDec($field, $value);

    return $result;
  }



# + ----------------------------------------------------------------------------------------------
# + 删除

  /**
   * --------------------------------------------------------------------------------------
   * 删除数据表操作
   *
   * @param  array     $where     删除条件
   *
   * @return boolean   $result    是否成功
   */
  public function doDeleteTableAction($where = array())
  {
    $result = M()->table($this->table)
                 ->where($where)
                 ->delete();

    return $result;
  }



# + ----------------------------------------------------------------------------------------------
# + 创建


  /**
   * --------------------------------------------------------------------------------------
   * 创建数据信息
   *
   * @param  array    $info    数据信息
   *
   * @return array    $data    创建后的数组
   */
  public function doCreateDataAction($info = array(), $validate = array(), $auto = array(), $flag = false, $id = 'id')
  {
    $model = M($this->ucfirsttable);

    $model->setProperty("_validate", $validate);
    $model->setProperty('_auto', $auto);

    $data = $model->create($info);

    if(false === $data)
    {
      $result = array('flag' => -1, 'msg' => $model->getError());
      return $result;
    }
    else if($data && is_array($data))
    {
      if($flag)
      {
        return $data;
      }
      else
      {
        $result = $this->doSaveDataAction($data, $id);

        return $result;
      }
    }
    else
    {
      return -1;
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 创建并且保存数据信息
   *
   * @param  array     $data     数据信息
   *
   * @return boolean   $result   是否成功
   */
  public function doSaveDataAction($data = array(), $id = 'id')
  {
    if(empty($data[$id]))
    {
      $result = $this->doAddTableAction($data);

      if($result !== false)
      {
        return array('flag' => 1, 'id' => $result, 'msg' => '新增成功');
      }
      else
      {
        return array('flag' => 0, 'msg' => '新增失败');
      }
    }
    else
    {
      $where[$id] = $data[$id];
      $res = $this->getWithWhereTableOneFieldInfo($where, 'id');

      if(empty($res))
      {
        $result = $this->doAddTableAction($data);
      }
      else
      {
        $result = $this->doUpdateTableAction($where, $data);
      }


      if($result !== false)
      {
        return array('flag' => 1 ,'msg' => '更新成功');
      }
      else
      {
        return array('flag' => 0 ,'msg' => '更新失败');
      }
    }
  }



# + ----------------------------------------------------------------------------------------------
# + 逻辑

  /**
   * --------------------------------------------------------------------------------------
   * 检查id是否全部存在
   *
   * @param  array|string   $id        [需要检查的id]
   * @param  string         $msg       [返回的内容]
   *
   * @return [boolean]        [是否成功]
   */
  public function checkId($id, $msg = '以下id不存在')
  {
    if(is_array($id))
    {
      $count = count($id);
      $ids   = implode(',', $id);
    }
    else
    {
      $count = 1;
      $ids   = $id;
    }

    $where['id'] = array('IN', $ids);
    $res = $this->getWithWhereTableInfo($where, 'id', '', 1);

    if(count($res) === $count)
    {
      return true;
    }
    else
    {
      if(is_array($id))
      {
        $diff = implode(',', array_diff($id, $res));
        $this->error = $msg.$diff;
        return false;
      }
      else
      {
        $diff = $id;
        $this->error = $msg.$diff;
        return false;
      }
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 数量统计信息（小时统计）
   *
   * @param  array    $where    查询条件
   *
   * @return array    $list     结果数组
   */
  public function getWithWhereHourMumberStatInfo($where = array(), $id = 'id', $method = 'count')
  {
    $list = $this->getWithWhereTableInfo($where, $method.'('.$id.') AS sum, FROM_UNIXTIME(create_time,"%H") AS date, create_time', 'create_time ASC', 1, 'FROM_UNIXTIME(create_time,"%Y-%m-%d %H")');

    return $list;
  }


  /**
   * --------------------------------------------------------------------------------------
   * 数量统计信息（日统计）
   *
   * @param  array    $where    查询条件
   *
   * @return array    $list     结果数组
   */
  public function getWithWhereDayMumberStatInfo($where = array(), $id = 'id', $method = 'count')
  {
    $list = $this->getWithWhereTableInfo($where, $method.'('.$id.') AS sum, FROM_UNIXTIME(create_time,"%Y-%m-%d") AS date, create_time', 'create_time ASC', 1, 'FROM_UNIXTIME(create_time,"%Y-%m-%d")');

    return $list;
  }


  /**
   * --------------------------------------------------------------------------------------
   * 数量统计信息（周统计）
   *
   * @param  array    $where    查询条件
   *
   * @return array    $list     结果数组
   */
  public function getWithWhereWeekMumberStatInfo($where = array(), $id = 'id', $method = 'count')
  {
    $list = $this->getWithWhereTableInfo($where, $method.'('.$id.') AS sum, FROM_UNIXTIME(create_time,"%u") AS date, create_time', 'create_time ASC', 1, 'FROM_UNIXTIME(create_time,"%u")');

    return $list;
  }



  /**
   * --------------------------------------------------------------------------------------
   * 数量统计信息（月统计）
   *
   * @param  array    $where    查询条件
   *
   * @return array    $list     结果数组
   */
  public function getWithWhereMonthMumberStatInfo($where = array(), $id = 'id', $method = 'count')
  {
    $list = $this->getWithWhereTableInfo($where, $method.'('.$id.') AS sum, create_time, FROM_UNIXTIME(create_time,"%m") AS date', 'create_time ASC', 1, 'FROM_UNIXTIME(create_time,"%m")');

    return $list;
  }

}
