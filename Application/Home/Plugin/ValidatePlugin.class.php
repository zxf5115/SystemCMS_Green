<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 后台验证插件类
 *     @english: ValidatePlugin.class.php
 *
 * @version: 1.0
 * @desc   : 操作后台数据验证
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-12-11 09:24:01
 */
class ValidatePlugin
{
  private $redis = '';

  /**
   * --------------------------------------------------------------------------------------
   * 初始化
   */
  public function __construct()
  {
    # 缓存操作的同时初始化
    if(empty($this->redis))
    {
      import('Vendor.Predis.Autoloader');

      \Predis\Autoloader::register();

      $servers = C('PREDIS');

      $options = array('cluster' => 'redis');

      $this->redis = new \Predis\Client($servers, $options);
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * Redis缓存增删改查操作方法
   *
   * @param  String    $name   缓存唯一键值
   * @param  String    $value  缓存内容字段
   * @param  String    $field  缓存内容值
   *
   * @return String    $value  缓存值
   */
  public function handle($name, $value='', $field = '')
  {
    # 如果字段为空并且内容为空，获取缓存
    if(('' === $value) && ('' === $field))
    {
      return $this->select($name);
    }
    # 如果值为空并且字段不为空
    elseif(('' === $value) && ('' != $field))
    {
      return $this->select($name, $field);
    }
    # 删除缓存
    elseif(is_null($value))
    {
      if($field)
      {
        return $this->delete($name, $field);
      }
      else
      {
        return $this->delete($name);
      }
    }
    # 缓存元素到hash表
    else
    {
      if($field && $value)
      {
        return $this->insert($name, $field, $value);
      }
      else
      {
        # 缓存多个元素到hash表
        return $this->insert($name, $value);
      }
    }
  }


# + ----------------------------------------------------------------------------------------------
# + 内部操作逻辑

  /**
   * --------------------------------------------------------------------------------------
   * Redis缓存新增操作方法
   *
   * @param  String    $name   缓存唯一键值
   * @param  String    $field  缓存内容字段
   * @param  String    $value  缓存内容值
   *
   * @return Array     缓存内容数组
   */
  private function insert($name, $field, $value)
  {
  	if($field)
    {
    	# 将指定键值的内容存入缓存中
    	return $this->redis->hset($name, $field , $value) ;
    }
    else
    {
    	# 缓存多个元素到hash表
      return $this->redis->hmset($name, $value);
    }
  }

  /**
   * --------------------------------------------------------------------------------------
   * Redis缓存删除操作方法
   *
   * @param  String    $name   缓存唯一键值
   * @param  String    $field  缓存内容字段
   *
   * @return Boolean   成功|失败
   */
  private function delete($name, $field)
  {
  	if($field)
  	{
  		# 删除hash表中指定key的元素
			return $this->redis ->hdel($name, $field);
  	}
  	else
  	{
  		# 删除键值内的全部内容
  		return $this->redis->del($name);
  	}
  }


  /**
   * --------------------------------------------------------------------------------------
   * Redis缓存查询操作方法
   *
   * @param  String    $name   缓存唯一键值
   * @param  String    $field  缓存内容字段
   *
   * @return Array|Boolean     缓存内容数组|不存在
   */
  private function select($name, $field = '')
  {
  	# 如果字段为空，获取全部缓存
    if('' === $field)
    {
    	# 如果唯一键值存在
      if($this->redis->exists($name))
      {
        return $this->redis->hgetall($name);
      }
      else
      {
      	return false;
      }
    }
    # 如果字段不为空，获取指定字段的缓存
    else if('' != $field)
    {
      # 如果指定键值存在
      if($this->redis->hexists($name, $field))
      {
        # 获取唯一键值下指定字段内容
        return $this->redis->hget($name, $field);
      }
      else
      {
        return false;
      }
    }
  }
}
