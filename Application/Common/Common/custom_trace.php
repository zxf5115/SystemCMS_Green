<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 自定义访问浏览记录（痕迹）函数库文件
 *     @english: custom_trace.php
 *
 * @version: 1.0
 * @desc   : 自定义访问浏览记录（痕迹）函数库文件
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-10-30 10:56:43
 */


  /**
   * ------------------------------------------------------------------------------------------
   * 记录行为日志，并执行该行为的规则
   *
   * @param string $action 行为标识
   * @param string $model 触发行为的模型名
   * @param int    $record_id 触发行为的记录id
   * @param int    $user_id 执行行为的用户id
   *
   * @return boolean
   */
  function record_log($action = null, $model = null, $record_id = null, $user_id = null)
  {
    # 参数检查
    if(empty($action) || empty($model) || empty($record_id))
    {
      return '参数不能为空';
    }

    if(empty($user_id))
    {
      $user_id = is_login();
    }

    # 查询行为,判断是否执行
    $action_info = M('Action')->getByName($action);

    if($action_info['status'] != 1)
    {
      return '当前行为不可用';
    }

    # 插入行为日志
    $data['action_id']   = $action_info['id'];
    $data['user_id']     = $user_id;
    $data['action_ip']   = ip2long(get_client_ip());
    $data['model']       = $model;
    $data['record_id']   = $record_id;
    $data['create_time'] = NOW_TIME;
    $data['founder']     = get_username($user_id);

    # 解析日志规则,生成日志备注
    if(!empty($action_info['log']))
    {
      if(preg_match_all('/\[(\S+?)\]/', $action_info['log'], $match))
      {
        $log['user']   = $user_id;
        $log['record'] = $record_id;
        $log['model']  = $model;
        $log['time']   = NOW_TIME;

        $log['data']   = array('user' => $user_id, 'model' => $model, 'record' => $record_id, 'time' => NOW_TIME);

        foreach($match[1] as $value)
        {
          $param = explode('|', $value);

          if(isset($param[1]))
          {
            $replace[] = call_user_func($param[1], $log[$param[0]]);
          }
          else
          {
            $replace[] = $log[$param[0]];
          }
        }

        $data['remark'] = str_replace($match[0], $replace, $action_info['log']);
      }
      else
      {
        $data['remark'] = $action_info['log'];
      }
    }
    else
    {
      # 未定义日志规则，记录操作url
      $data['remark'] = '操作url：' . $_SERVER['REQUEST_URI'];
    }

    M('Log')->add($data);

    if(!empty($action_info['rule']))
    {
      # 解析行为
      $rules = parse_action($action, $user_id);

      # 执行行为
      $res   = execute_action($rules, $action_info['id'], $user_id);
    }
  }


  /**
   * ------------------------------------------------------------------------------------------
   * 解析行为规则
   *
   * 规则定义  table:$table|field:$field|condition:$condition|rule:$rule[|cycle:$cycle|max:$max]
   * 规则字段解释：table->要操作的数据表，不需要加表前缀；
   *               field->要操作的字段；
   *               condition->操作的条件，目前支持字符串，默认变量{$self}为执行行为的用户
   *               rule->对字段进行的具体操作，目前支持四则混合运算，如：1+score*2/2-3
   *               cycle->执行周期，单位（小时），表示$cycle小时内最多执行$max次
   *               max->单个周期内的最大执行次数（$cycle和$max必须同时定义，否则无效）
   *
   * 单个行为后可加 ； 连接其他规则
   * @param string $action 行为id或者name
   * @param int    $self 替换规则里的变量为执行用户的id
   *
   * @return boolean|array: false解析出错 ， 成功返回规则数组
   */
  function parse_action($action = null, $self)
  {
    if(empty($action))
    {
      return false;
    }

    # 参数支持id或者name
    if(is_numeric($action))
    {
      $map = array('id' => $action);
    }
    else
    {
      $map = array('name' => $action);
    }

    # 查询行为信息
    $info = M('Action')->where($map)->find();

    if(!$info || $info['status'] != 1)
    {
      return false;
    }

    # 解析规则:table:$table|field:$field|condition:$condition|rule:$rule[|cycle:$cycle|max:$max]
    $rules  = $info['rule'];
    $rules  = str_replace('{$self}', $self, $rules);
    $rules  = explode(';', $rules);
    $return = array();

    foreach($rules as $key => &$rule)
    {
      $rule = explode('|', $rule);

      foreach($rule as $k => $fields)
      {
        $field = empty($fields) ? array() : explode(':', $fields);

        if(!empty($field))
        {
          $return[$key][$field[0]] = $field[1];
        }
      }

      # cycle(检查周期)和max(周期内最大执行次数)必须同时存在，否则去掉这两个条件
      if(!array_key_exists('cycle', $return[$key]) || !array_key_exists('max', $return[$key]))
      {
        unset($return[$key]['cycle'], $return[$key]['max']);
      }
    }

    return $return;
  }


  /**
   * ------------------------------------------------------------------------------------------
   * 执行行为
   *
   * @param array $rules 解析后的规则数组
   * @param int   $action_id 行为id
   * @param array $user_id 执行的用户id
   *
   * @return boolean false 失败 ， true 成功
   */
  function execute_action($rules = false, $action_id = null, $user_id = null)
  {
    if(!$rules || empty($action_id) || empty($user_id))
    {
      return false;
    }

    $return = true;
    foreach($rules as $rule)
    {
      # 检查执行周期
      $map = array('action_id' => $action_id, 'user_id' => $user_id);

      if($rule['cycle'] && $rule['max'])
      {
        $map['create_time'] = array('gt', NOW_TIME - intval($rule['cycle']) * 3600);

        $exec_count = M('Log')->where($map)->count();

        if($exec_count > $rule['max'])
        {
          continue;
        }
      }

      # 执行数据库操作
      $Model = M(ucfirst($rule['table']));

      # 判断是否加入了货币规则
      if($rule['tox_money_rule'] != '' && $rule['tox_money_rule'] != null)
      {
        $change = array($rule['field'] => array('exp', $rule['rule']), $rule['tox_money_field'] => array('exp', $rule['tox_money_rule']));

        $res = $Model->where($rule['condition'])->setField($change);
      }
      else
      {
        $field = $rule['field'];
        $res = $Model->where($rule['condition'])->setField($field, array('exp', $rule['rule']));
      }

      if(!$res)
      {
        $return = false;
      }
    }

    return $return;
  }



  /**
   * ------------------------------------------------------------------------------------------
   * 记录唯一访客信息
   *
   * @param array $rules 解析后的规则数组
   * @param int   $action_id 行为id
   * @param array $user_id 执行的用户id
   *
   * @return boolean false 失败 ， true 成功
   */
  function record_unique_visitor()
  {
    # 获得当前IP
    $where['ip_address'] = get_client_ip(1);

    # 如果IP地址存在
    if(!empty($where['ip_address']))
    {
      # 获得当前IP是否存在记录时间
      $update_time = D('Admin/UV')->getWithWhereTableOneFieldInfo($where, 'update_time');

      # 获得昨天时间戳
      $yesterday = strtotime(date('Y-m-d H:i:m', strtotime('-1 day')));
      # 获得今天时间戳
      $today     = strtotime(date('Y-m-d H:i:m'));

      if(is_null($update_time) || ($yesterday > $update_time || $today <= $update_time))
      {
        $info['browser']     = get_client_browser();
        $info['ip_address']  = get_client_ip(1);
        $info['system']      = get_client_language();
        $info['language']    = get_client_system();
        $info['update_time'] = time();

        D('Admin/UV')->doSaveFromDataAction($info);
      }
    }
  }



