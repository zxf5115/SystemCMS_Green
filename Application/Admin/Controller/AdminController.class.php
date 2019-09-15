<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 后台公共控制器
 *     @english: AdminController.class.php
 *
 * @version: 1.0
 * @desc   : 控制后台全部控制器父类
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 14:42:11
 */
use Think\Controller;
use Think\Cache;
use Think\Model;

class AdminController extends Controller
{

  /**
   * --------------------------------------------------------------------------------------
   * 后台控制器初始化
   */
  protected function _initialize()
  {
    # 获取当前用户ID
    define('UID', is_login());

    # 还没登录 跳转到登录页面
    if(!UID)
    {
      $this->redirect('Public/login');
    }

    # 读取数据库中的配置
    $config = S('DB_CONFIG_DATA');

    if(!$config)
    {
      # 如果无缓存，查询数据库
      $config	=	D('Config')->getWithWhereConfigListInfo();

      # 更新缓存
      S('DB_CONFIG_DATA',$config);
    }

    # 添加配置
    C($config);

    # 是否是超级管理员
    define('IS_ROOT', is_administrator());

    if(!IS_ROOT && C('ADMIN_ALLOW_IP'))
    {
      # 检查IP地址访问
      if(!in_array(get_client_ip(), explode(',', C('ADMIN_ALLOW_IP'))))
      {
        $this->error('403:禁止访问');
      }
    }

    # 当前访问路径
    $rule  = strtolower(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME);
    S('CURRENT_PATH', $rule);

    # 检测访问权限
    $access = $this->accessControl();

    if($access === false)
    {
      $this->error('403:禁止访问');
    }
    elseif($access === null)
    {
      # 检测分类栏目有关的各项动态权限
      $dynamic = $this->checkDynamic();

      if($dynamic === null)
      {
        if(!$this->checkRule($rule, array('in','1,2')))
        {
          $this->redirect('Permission/index');
        }
      }
      elseif($dynamic === false)
      {
        $this->redirect('Permission/index');
      }
    }

    $this->assign('__MENU__', $this->getMenus());
    $this->assign('__NAV__', $this->getNavigation());
  }


  /**
   * --------------------------------------------------------------------------------------
   * 访问控制
   *
   * 在登陆成功，后执行的第一项权限检测任务
   *
   * @return boolean|null  返回值必须使用 `===` 进行判断
   */
  final protected function accessControl()
  {
    if(IS_ROOT)
    {
      # 管理员允许访问任何页面
      return true;
    }

    # 不受限控制器方法
    $allow = C('ALLOW_VISIT');

    # 仅超级管理员可访问的控制器方法
    $deny  = C('DENY_VISIT');

    # 当前地址链接
    $check = strtolower(CONTROLLER_NAME.'/'.ACTION_NAME);

    if(!empty($deny) && in_array_case($check, $deny))
    {
      # 不允许任何人访问(超管除外)
      return false;
    }

    if(!empty($allow) && in_array_case($check, $allow))
    {
      # 允许任何管理员访问,无需执行节点权限检测
      return true;
    }

    # 需要继续执行节点权限检测决定是否允许访问
    return null;
  }



  /**
   * --------------------------------------------------------------------------------------
   * 检测是否是需要动态判断的权限
   *
   * @return boolean|null
   */
  protected function checkDynamic()
  {
    if(IS_ROOT)
    {
      # 返回true则表示当前访问有权限
      return true;
    }
    #  else
    #  {
    #    # 返回false则表示当前访问无权限
    #    return false;
    #  }

    # 返回null，则会进入checkRule根据节点授权判断权限
    return null;
  }




  /**
   * --------------------------------------------------------------------------------------
   * 权限检测
   *
   * @param string  $rule    检测的规则
   * @param string  $mode    check模式
   *
   * @return boolean
   */
  final protected function checkRule($rule, $type=\PermissionModel::RULE_URL, $mode='url')
  {
    if(IS_ROOT)
    {
      # 管理员允许访问任何页面
      return true;
    }

    static $Auth = null;

    if(!$Auth)
    {
      $Auth = new \Think\Auth();
    }

    if(!$Auth->check($rule, UID, $type, $mode))
    {
      return false;
    }

    return true;
  }


  /**
   * --------------------------------------------------------------------------------------
   * 获取控制器菜单数组, 二级菜单元素位于一级菜单的'_child'元素中
   */
  final public function getMenus($controller=CONTROLLER_NAME)
  {
    // $menu = session('ADMIN_MENU_LIST'.$controller);

    if(empty($menu))
    {
      # 获取主菜单
      $where['pid']   =   0;
      $where['hide']  =   0;

      # 是否开发者模式
      if(!C('DEVELOP_MODE'))
      {
        $where['is_dev'] = 0;
      }

      # 设置主菜单
      $menu['main'] = D('Menu')->getWithWhereTableInfo($where, 1, 'sort ASC');

      # 设置左侧副菜单
      #  $menu['child'] = array();

      $where        = array();
      $where['url'] = array('LIKE', "%{$controller}/".ACTION_NAME."%");

      # 高亮主菜单
      $current = D('Menu')->getWithWhereOneTableInfo($where, 'id');

      if($current)
      {
        $nav = D('Menu')->getPath($current['id']);

        $nav_first_title = $nav[0]['title'];

        if(count($nav) > 1)
        {
          $nav_next_title = $nav[1]['title'];
          $nav_next_group = $nav[1]['group'];
        }

        foreach($menu['main'] as $key => $item)
        {
          $menu['main'][$key]['child'] = array();

          if(!is_array($item) || empty($item['title']) || empty($item['url']))
          {
            $this->error('控制器基类$menu属性元素配置有误');
          }

          if(stripos($item['url'], MODULE_NAME)!==0)
          {
            $item['url'] = MODULE_NAME.'/'.$item['url'];
          }

          # 判断主菜单权限
          if(!IS_ROOT && !$this->checkRule($item['url'], PermissionModel::RULE_MAIN, null))
          {
            unset($menu['main'][$key]);

            # 继续循环
            continue;
          }

          $menu['main'][$key]['class']='';

          # 获取当前主菜单的子菜单项
          if($item['title'] == $nav_first_title)
          {
            $menu['main'][$key]['class']='active opened active';
          }

          # 生成child树
          $groups = M('Menu')->where("pid = {$item['id']}")->distinct(true)->field("`group`")->select();

          if($groups)
          {
            $groups = array_column($groups, 'group');
          }
          else
          {
            $groups =   array();
          }

          # 获取二级分类的合法url
          $where          =   array();
          $where['pid']   =   $item['id'];
          $where['hide']  =   0;

          if(!C('DEVELOP_MODE'))
          {
            # 是否开发者模式
            $where['is_dev']    =   0;
          }

          $second_urls = M('Menu')->where($where)->getField('id,url');

          if(!IS_ROOT)
          {
            # 检测菜单权限
            $to_check_urls = array();

            foreach ($second_urls as $k=>$to_check_url)
            {
              if( stripos($to_check_url,MODULE_NAME)!==0 )
              {
                $rule = MODULE_NAME.'/'.$to_check_url;
              }
              else
              {
                $rule = $to_check_url;
              }
              if($this->checkRule($rule, PermissionModel::RULE_URL,null))
              {
                $to_check_urls[] = $to_check_url;
              }
            }
          }
// header('Content-type: text/html; charset=utf-8');
// echo '<pre>';
//  dump($menu['main']);
// echo '</pre>';exit;
          if(!empty($groups))
          {
            # 按照分组生成子菜单树
            foreach ($groups as $i =>$g)
            {
              $map = array('group'=>$g);

              if(isset($to_check_urls))
              {
                if(empty($to_check_urls))
                {
                  # 没有任何权限
                  continue;
                }
                else
                {
                  $map['url'] = array('in', $to_check_urls);
                }
              }

              $map['pid']  = $item['id'];
              $map['hide'] = 0;

              # 是否开发者模式
              if(!C('DEVELOP_MODE'))
              {
                $map['is_dev'] = 0;
              }

              $menuList = M('Menu')->where($map)->field('id,pid,title,group,url,tip')->order('sort asc')->select();
              $menu['main'][$key]['child'][$i]['title'] = $g;
              $menu['main'][$key]['child'][$i]['info'] = list_to_tree($menuList, 'id', 'pid', 'operater', $item['id']);

              if(!empty($nav_next_group))
              {
                foreach($menu['main'][$key]['child'] as $x=> &$vo)
                {
                  foreach($vo['info'] as $y => &$to)
                  {
                    $vo['ul-class']=  '';
                    $to['li-class']=  '';

                    # 获取当前主菜单的子菜单项
                    if($to['group'] == $nav_next_group)
                    {
                      $vo['ul-class']= 'active';
                    }

                    # 获取当前主菜单的子菜单项
                    if($to['title'] == $nav_next_title)
                    {
                      $to['li-class']= 'active';
                    }
                  }
                }
              }
            }

            #  if($menu['child'] === array())
            #  {
            #    # $this->error('主菜单下缺少子菜单，请去系统=》后台菜单管理里添加');
            #  }
          }

        }
      }

      session('ADMIN_MENU_LIST'.$controller,$menu);
    }
// header('Content-type: text/html; charset=utf-8');
// echo '<pre>';
//  dump($menu['main']);
// echo '</pre>';exit;
    return $menu;
  }


  /**
   * --------------------------------------------------------------------------------------
   * 获取面包屑
   */
  final public function getNavigation($controller=CONTROLLER_NAME)
  {
    $where['url'] = array('LIKE', "%{$controller}/".ACTION_NAME."%");
    $where['pid'] = array('NEQ', 0);

    # 高亮主菜单
    $current = D('Menu')->getWithWhereOneTableInfo($where);

    $nav = '';

    if($current && $current['pid'])
    {
      unset($where);
      $where['id'] = $current['pid'];

      $nav[0] = D('Menu')->getWithWhereOneTableInfo($where);
      $nav[1] = $current;
    }

    return $nav;
  }


  /**
   * --------------------------------------------------------------------------------------
   * 对数据表中的单行或多行记录执行修改 GET参数id为数字或逗号分隔的数字
   *
   * @param string $model 模型名称,供M函数使用的参数
   * @param array  $data  修改的数据
   * @param array  $where 查询时的where()方法的参数
   * @param array  $msg   执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
   *                      url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
   */
  final protected function editRow($model, $data, $where, $msg)
  {
    $id    = array_unique((array)I('id', 0));
    $id    = is_array($id) ? implode(',', $id) : $id;
    $where = array_merge(array('id' => array('in', $id )) ,(array)$where);
    $msg   = array_merge(array('success'=>'操作成功！', 'error'=>'操作失败！', 'url'=>'' ,'ajax'=>IS_AJAX) , (array)$msg);

    if(M($model)->where($where)->save($data)!==false)
    {
      $this->updateRecord($where, $model, $data);

      $this->success($msg['success'], U($msg['url']), $msg['ajax']);
    }
    else
    {
      $this->error($msg['error'], U($msg['url']), $msg['ajax']);
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 对数据表中的单行或多行记录执行删除 GET参数id为数字或逗号分隔的数字
   *
   * @param string $model 模型名称,供M函数使用的参数
   * @param array  $data  修改的数据
   * @param array  $where 查询时的where()方法的参数
   * @param array  $msg   执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
   *                      url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
   */
  final protected function delRow($model, $data, $where, $msg)
  {
    $id    = array_unique((array)I('id', 0));
    $id    = is_array($id) ? implode(',', $id) : $id;
    $where = array_merge(array('id' => array('in', $id)) ,(array)$where);
    $msg   = array_merge(array('success'=>'操作成功！', 'error'=>'操作失败！', 'url'=>'' ,'ajax'=>IS_AJAX) , (array)$msg);

    if(M($model)->where($where)->delete()!==false)
    {
      $this->updateRecord($where, $model, $data);

      $this->success($msg['success'],U($msg['url']),$msg['ajax']);
    }
    else
    {
      $this->error($msg['error'],U($msg['url']),$msg['ajax']);
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 禁用条目
   * @param string $model 模型名称,供M函数使用的参数
   * @param array  $where 查询时的 where()方法的参数
   * @param array  $msg   执行正确和错误的消息,可以设置四个元素 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
   *                      url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
   */
  protected function forbid($model, $where = array(), $msg = array( 'success'=>'禁用成功！', 'error'=>'禁用失败！'))
  {
    $data = array('status' => 0);

    $this->editRow($model, $data, $where, $msg);
  }


  /**
   * --------------------------------------------------------------------------------------
   * 恢复条目
   * @param string $model 模型名称,供M函数使用的参数
   * @param array  $where 查询时的where()方法的参数
   * @param array  $msg   执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
   *                      url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
   *
   *
   */
  protected function resume($model, $where = array(), $msg = array( 'success'=>'恢复成功！', 'error'=>'恢复失败！'))
  {
    $data = array('status' => 1);

    $this->editRow($model, $data, $where, $msg);
  }


  /**
   * --------------------------------------------------------------------------------------
   * 还原条目
   * @param string $model 模型名称,供D函数使用的参数
   * @param array  $where 查询时的where()方法的参数
   * @param array  $msg   执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
   *                      url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
   */
  protected function restore($model, $where = array(), $msg = array( 'success'=>'还原成功！', 'error'=>'还原失败！'))
  {
    $data  = array('status' => 1);
    $where = array_merge(array('status' => -1), $where);

    $this->editRow($model, $data, $where, $msg);
  }


  /**
   * --------------------------------------------------------------------------------------
   * 条目假删除
   * @param string $model 模型名称,供D函数使用的参数
   * @param array  $where 查询时的where()方法的参数
   * @param array  $msg   执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
   *                      url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
   */
  protected function delete($model, $where = array(), $msg = array( 'success'=>'删除成功！', 'error'=>'删除失败！'))
  {
    $data['status']      = -1;
    $data['update_time'] = NOW_TIME;

    $this->delRow($model, $data, $where, $msg);
  }


  /**
   * --------------------------------------------------------------------------------------
   * 条目假删除 清空内容
   * @param string $model 模型名称,供D函数使用的参数
   * @param array  $where 查询时的where()方法的参数
   * @param array  $msg   执行正确和错误的消息 array('success'=>'','error'=>'', 'url'=>'','ajax'=>false)
   *                      url为跳转页面,ajax是否ajax方式(数字则为倒数计时秒数)
   */
  protected function clear($model, $where = array(), $msg = array( 'success'=>'删除成功！', 'error'=>'删除失败！'), $field = 'status')
  {
    $data  = array($field => null);

    $this->editRow($model, $data, $where, $msg);
  }


  /**
   * --------------------------------------------------------------------------------------
   * 设置一条或者多条数据的状态
   */
  public function setStatus($Model = CONTROLLER_NAME)
  {
    $ids    = I('request.ids');
    $status = I('request.status');

    if(empty($ids))
    {
      $this->error('请选择要操作的数据');
    }

    $map['id'] = array('in',$ids);

    switch($status)
    {
      case -1 :
        $this->delete($Model, $map, array('success'=>'删除成功', 'error'=>'删除失败'));
        break;
      case 0  :
        $this->forbid($Model, $map, array('success'=>'禁用成功', 'error'=>'禁用失败'));
        break;
      case 1  :
        $this->resume($Model, $map, array('success'=>'启用成功', 'error'=>'启用失败'));
        break;
      default :
        $this->error('参数错误');
        break;
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 返回后台节点数据
   *
   * @param boolean $tree    是否返回多维数组结构(生成菜单时用到),为false返回一维数组(生成权限节点时用到)
   * @retrun array
   *
   * 注意,返回的主菜单节点数组中有'controller'元素,以供区分子节点和主节点
   */
  final protected function returnNodes($tree = true)
  {
    static $tree_nodes = array();

    if($tree && !empty($tree_nodes[(int)$tree]))
    {
      return $tree_nodes[$tree];
    }

    if((int)$tree)
    {
      $list = M('Menu')->field('id,pid,title,url,tip,hide')->order('sort asc')->select();

      foreach($list as $key => $value)
      {
        if( stripos($value['url'],MODULE_NAME)!==0 )
        {
          $list[$key]['url'] = MODULE_NAME.'/'.$value['url'];
        }
      }

      $nodes = list_to_tree($list,$pk='id',$pid='pid',$child='operator',$root=0);

      foreach ($nodes as $key => $value)
      {
        if(!empty($value['operator']))
        {
          $nodes[$key]['child'] = $value['operator'];
          unset($nodes[$key]['operator']);
        }
      }
    }
    else
    {
      $nodes = M('Menu')->field('id,title,url,tip,pid')->order('sort asc')->select();

      foreach ($nodes as $key => $value)
      {
        if( stripos($value['url'],MODULE_NAME)!==0 )
        {
          $nodes[$key]['url'] = MODULE_NAME.'/'.$value['url'];
        }
      }
    }

    $tree_nodes[(int)$tree]   = $nodes;

    return $nodes;
  }



  /**
   * --------------------------------------------------------------------------------------
   * 更新记录
   *
   * 数据库操作都要进行记录
   *
   * @param array  $ids    id数组
   * @param string $model  模型名称
   * @param string $data   操作数据
   */
  final protected function updateRecord($ids = array(), $model, $data)
  {
    if($data['status'])
    {
      $label_right = strtolower($model);

      switch($data['status'])
      {
        # 删除
        case -1:
          $label = 'delete'.'_'.$label_right;
          break;
        # 禁用
        case 0:
          $label = 'forbid'.'_'.$label_right;
          break;
        # 恢复
        case 1:
          $label = 'resume'.'_'.$label_right;
          break;
      }

      $list =explode(',', $ids['id'][1]);

      foreach($list as $id)
      {
        # 记录行为
        record_log($label, $model, $id, UID);
      }
    }
  }



  /**
   * --------------------------------------------------------------------------------------
   * 通用分页列表数据集获取方法
   *
   *  可以通过url参数传递where条件,例如:  index.html?name=asdfasdfasdfddds
   *  可以通过url空值排序字段和方式,例如: index.html?_field=id&_order=asc
   *  可以通过url参数r指定每页数据条数,例如: index.html?r=5
   *
   * @param sting|Model  $model   模型名或模型实例
   * @param array        $where   where查询条件(优先级: $where>$_REQUEST>模型设定)
   * @param array|string $order   排序条件,传入null时使用sql默认排序或模型属性(优先级最高);
   *                              请求参数中如果指定了_order和_field则据此排序(优先级第二);
   *                              否则使用$order参数(如果$order参数,且模型也没有设定过order,则取主键降序);
   *
   * @param array        $base    基本的查询条件
   * @param boolean      $field   单表模型用不到该参数,要用在多表join时为field()方法指定参数
   *
   *
   * @return array|false
   * 返回数据集
   */
  protected function paging($model, $where=array(), $order='', $base = array('status'=>array('egt',0)), $field=true)
  {
    $options = array();
    $REQUEST = (array)I('request.');

    if(is_array($model))
    {
      $model = M($model['name'], '', $model['category']);
    }
    else if(is_string($model))
    {
      $model = M($model);
    }

    $OPT = new \ReflectionProperty($model,'options');
    $OPT->setAccessible(true);

    $pk = $model->getPk();

    if($order===null)
    {
      # order置空
    }
    else if(isset($REQUEST['_order']) && isset($REQUEST['_field']) && in_array(strtolower($REQUEST['_order']),array('desc','asc')))
    {
      $options['order'] = '`'.$REQUEST['_field'].'` '.$REQUEST['_order'];
    }
    elseif($order==='' && empty($options['order']) && !empty($pk))
    {
      $options['order'] = $pk.' desc';
    }
    elseif($order)
    {
      $options['order'] = $order;
    }

    unset($REQUEST['_order'],$REQUEST['_field']);

    $options['where'] = array_filter(array_merge( (array)$base, /*$REQUEST,*/ (array)$where ),function($val)
    {
      if($val===''||$val===null)
      {
        return false;
      }
      else
      {
        return true;
      }
    });

    if( empty($options['where']))
    {
      unset($options['where']);
    }

    $options = array_merge( (array)$OPT->getValue($model), $options );
    $total   = $model->where($options['where'])->count();

    if(isset($REQUEST['r']))
    {
      $listRows = (int)$REQUEST['r'];
    }
    else
    {
      $listRows = C('LIST_ROWS') > 0 ? C('LIST_ROWS') : 10;
    }

    $page = new \Think\Page($total, $listRows, $REQUEST);

    if($total>$listRows)
    {
      $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
    }

    $p =$page->show();

    $this->assign('_page', $p? $p: '');
    $this->assign('_total',$total);

    $options['limit'] = $page->firstRow.','.$page->listRows;

    $model->setProperty('options',$options);

    return $model->field($field)->select();
  }


# ---------------------------------------------------------------------------------------------
# 统计

  /**
   * --------------------------------------------------------------------------------------
   * 获得统计条件
   *
   * @param  string   $interval    统计间隔条件 1：小时 2：日 3：周 4：月
   *
   * @return array    $onset       结果数组
   */
  public function getWithWhereStatCondition($interval, $start, $end)
  {
    # 如果按小时进行统计
    if(1 == $interval)
    {
      if(empty($start) && empty($end))
      {
        $onset[0] = date('Y-m-d 00:00:00');
        $onset[1] = date('Y-m-d H:i:s');
      }
      else if(empty($start) || empty($end))
      {
        $this->error('请选择开始时间或结束时间');
      }
      else
      {
        $onset[0] = $start;
        $onset[1] = $end.' 23:59:59';
      }
    }

    # 如果按日进行统计
    if(2 == $interval)
    {
      if(!empty($start) && !empty($end))
      {
        $onset[0] = $start;
        $today = date('Y-m-d');

        if($end >= $today)
        {
          $onset[1] = $today.' 00:00:00';
        }
        else
        {
          $onset[1] = $end.' 23:59:59';
        }
      }
      else
      {
        $onset[0] = date('Y-m-d', strtotime('-1 day'));
        $onset[1] = date('Y-m-d');
      }
    }

    # 如果按周进行统计
    if(3 == $interval)
    {
      if(!empty($start) && !empty($end))
      {
        $onset[0] = $start;
        $onset[1] = $end.' 23:59:59';
      }
      else
      {
        $onset[0] = date('Y-m-d', strtotime('-1 week'));
        $onset[1] = date('Y-m-d');
      }
    }

    # 如果按月进行统计
    if(4 == $interval)
    {
      if(!empty($start) && !empty($end))
      {
        $onset[0] = $start;

        $end = date("Y-m", strtotime($end));

        $year  = date("Y", strtotime($end));
        $month = date("m", strtotime($end));
        $day   = date("d", strtotime($end));

        $end = $year.'-0'.($month+1).'-'.$day;

        $onset[1] = $end;
      }
      else
      {
        $onset[0] = date('Y-m-d', strtotime('-1 month'));
        $onset[1] = date('Y-m-d');
      }
    }

    return $onset;
  }



  /**
   * --------------------------------------------------------------------------------------
   * 根据获取X轴坐标范围数据
   *
   * @param  string   $type   统计间隔条件
   * @param  string   $start  开始时间
   * @param  string   $end    结束时间
   *
   * @return array    $date   天数数组
   */
  public function getWithWherePeriodInfo($type = 0, $start = 0, $end = 0)
  {
    # 按小时进行统计
    if(1 == $type)
    {
      # 根据起始时间统计天数
      $date = $this->getWithOnsetDateStatDay($type, $start, $end);
// dump($date);exit;
      $x = 0;
      foreach($date as $k =>$v)
      {
        if(10 > $v)
        {
          $data[$x] = '0'.$v.':00';
          $x++;
        }
        else
        {
          $data[$x] = $v.':00';
          $x++;
        }
      }
    }
    # 按日进行统计
    else if(2 == $type)
    {
      # 根据起始时间统计天数
      $data = $this->getWithOnsetDateStatDay($type, $start, $end);
    }
    # 按周进行统计
    else if(3 == $type)
    {
      # 根据起始时间统计天数
      $data = $this->getWithOnsetDateStatDay($type, $start, $end);
    }
    # 按月进行统计
    else if(4 == $type)
    {
      # 根据起始时间统计天数
      $data = $this->getWithOnsetDateStatDay($type, $start, $end);
    }

    return $data;
  }




  /**
   * --------------------------------------------------------------------------------------
   * 根据起始时间统计天数
   *
   * @param  string   $start  开始时间
   * @param  string   $end    结束时间
   *
   * @return array    $date   天数数组
   */
  public function getWithOnsetDateStatDay($type, $start, $end)
  {
    if($type == 1)
    {
      $start_f = date('d', strtotime($start));
      $end_f = date('d', strtotime($end));

      if($start_f == $end_f)
      {
        $total = date('H', strtotime($end));
      }
      else
      {
        $total = 24;
      }

      for($i=0; $i <= $total; $i++)
      {
        $date[$i] = $i;
      }
    }
    else if($type == 2)
    {
      # 获得当前日期
      $today = date('Y-m-d');

      # 如果当前日期小于等于结束日期，结束日期为当前日期
      if(strtotime($today) <= strtotime($end))
      {
        for($i=0; strtotime($start.'+'.$i.' days') < strtotime($today) && $i < 365; $i++)
        {
          $date[$i] = date('Y-m-d', strtotime($start.'+'.$i.' days'));
        }
      }
      # 如果当前日期大于结束日期，结束日期为结束日期
      else
      {
        for($i=0; strtotime($start.'+'.$i.' days') <= strtotime($end) && $i < 365; $i++)
        {
          $date[$i] = date('Y-m-d', strtotime($start.'+'.$i.' days'));
        }
      }
    }
    else if($type == 4)
    {
      $now_f = date('Y-m');
      $start_f = date('Y-m', strtotime($start));
      $end_f = date('Y-m', strtotime($end));

      $end_f = ($end_f > $now_f) ? date('Y-m', strtotime($now_f.'1 month')) : $end_f;

      for($i = 0; strtotime($start_f.'+'.$i.' month') < strtotime($end_f); $i++)
      {
        $date[$i] = date('Y-m', strtotime($start_f.'+'.$i.' month'));
      }
    }

    return $date;
  }



  /**
   * --------------------------------------------------------------------------------------
   * 根据条件获取统计数据
   *
   * @param  string   $model  模型名称
   * @param  string   $cid    统计字段
   * @param  string   $id     统计间隔条件
   * @param  string   $start  开始时间
   * @param  string   $end    结束时间
   *
   * @return array    $date   统计数组
   */
  public function getWithWhereStatInfo($model, $cid, $id, $start, $end, $where = array(), $method = 'count')
  {
    $lstart = strtotime($start);
    $rend   = strtotime($end);

    # 按小时进行统计
    if(1 == $id)
    {
      $con = array(array('egt', $lstart), array('lt', $rend));
      $where['create_time'] = $con;

      # 按小时进行统计调用
      $list = D($model)->getWithWhereHourMumberStatInfo($where, $cid, $method);
      $list = formatHour($list);

      $time = $start;
      $content = "'按小时统计'";
      // $content = "'".$start."---".$end." （按小时统计）'";
    }
    # 按日进行统计
    else if(2 == $id)
    {
      $rend = $rend+ (24 * 60 * 60);
      $con = array(array('egt', $lstart), array('lt', $rend));
      $where['create_time'] = $con;

      # 周统计调用
      $list = D($model)->getWithWhereDayMumberStatInfo($where, $cid, $method);

      $content = "'按日统计'";
      // $content = "'".$start."---".$end." （按日统计）'";
    }
    # 按周进行统计
    else if(3 == $id)
    {
      $rend = $rend+ (24 * 60 * 60);
      $con = array(array('egt', $lstart), array('elt', $rend));
      $where['create_time'] = $con;

      # 周统计调用
      $list = D($model)->getWithWhereWeekMumberStatInfo($where, $cid, $method);

      $content = "'按周统计'";
      // $content = "'".$start."---".$end." （按周统计）'";
    }
    # 按月进行统计
    else if(4 == $id)
    {
      // $month = date('Y-m');

      // if($month >= date("Y-m", $rend))
      // {
      //   $rend = date('Y-m-t',strtotime('last month',$rend));
      // }

      // $rend = strtotime($rend) + (24 * 60 * 60);

      $con = array(array('egt', $lstart), array('lt', $rend));
      $where['create_time'] = $con;

      # 日统计调用
      $list = D($model)->getWithWhereMonthMumberStatInfo($where, $cid, $method);
      $content = "'按月统计'";
      // $content = "'".date('Y-m', strtotime('-1 month'))." （月）'";
    }


    $res[0] = $list;
    $res[1] = $content;

    return $res;
  }


  /**
   * --------------------------------------------------------------------------------------
   * 分页列表页
   */
  public function getWithWhereTablePagingInfo($where = array(), $model, $keys, $search_fields, $get,$countid = 'id', $table = '')
  {
    $draw   = $get['draw'];
    $order  = $get['order'];
    $search = $get['search'];
    $start  = $get['start'];
    $length = $get['length'];

    # 排序
    $order_column = $order['0']['column']; # 那一列排序，从0开始
    $order_dir    = $order['0']['dir'];    # ase desc 升序或者降序

    # 搜索
    $search       = $search['value']; # 获取前台传过来的过滤条件

    $search_fields_ = explode('|', $search_fields);

    foreach($search_fields_ as $k => $v)
    {
      if(!empty($v))
      {
        $search_where[$search_fields][$k] = array('LIKE', '%'.$search.'%');
      }
    }

    $search_where[$search_fields]['_multi'] = true;

    unset($search_fields_);

    if($draw)
    {
      # 排序条件
      if(isset($order_column))
      {
        # 第一行为选择框，所以排序行数减一
        $i = intval($order_column) ;

        $order = $keys[$i].' '.$order_dir;
      }
#  dump($i);exit;
      # 分页条件
      if(isset($start) && $length != -1)
      {
        $limit = ' '.intval($start).', '.intval($length);
      }

      if('Database' == $model)
      {
        # 内容总条数
        $total = D($model)->getWithWhereCountTableInfo($table, $where);
      }
      else
      {
        # 内容总条数
        $total = D($model)->getWithWhereCountTableInfo($where, 'count', $countid);
      }
      #  dump($model);exit;

      if(strlen($search)>0)
      {
        if('Database' == $model)
        {
          # 内容总条数
          $total = D($model)->getWithWhereCountTableInfo($table, $search_where);
        }
        else
        {
          # 搜索到的内容总条数
          $filter = D($model)->getWithWhereCountTableInfo($search_where, 'count', $countid);
        }
        #  dump($search_where);exit;
      }
      else
      {
        $filter = $total;
      }

      if(strlen($search)>0)
      {
        if('Database' == $model)
        {
          # 如果有搜索条件，按条件过滤找出记录
          $list = D($model)->getWithWhereCurrentTableDetailInfo($table, '', $group, $limit);
        }
        else
        {
          # 如果有搜索条件，按条件过滤找出记录
          $list = D($model)->getWithWhereCurrentTableDetailInfo($search_where, true, $order,'','',$limit);
        }

      }
      else
      {
        if('Database' == $model)
        {
          #  $table = '', $where = '', $group = '', $limit = ''

          # 如果有搜索条件，按条件过滤找出记录
          $list = D($model)->getWithWhereCurrentTableDetailInfo($table, '', $group, $limit);
        }
        else
        {
          # 直接查询所有记录
          $list = D($model)->getWithWhereCurrentTableDetailInfo($where, true, $order,'','',$limit);
        }

#  dump($order);exit;
        foreach($list as $k => $v)
        {
          $list[$k][0] = 1;
        }
      }

      $list = $this->getWithWhereFormatDataInfo($list, $model);

      if(empty($list))
      {
        $list = false;
      }

      /*
       * Output 包含的是必要的
       */
      echo json_encode(array(
        "draw" => intval($draw),
        "recordsTotal" => intval($total),
        "recordsFiltered" => intval($filter),
        "data" => $list
      ),JSON_UNESCAPED_UNICODE);
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 根据条件格式化数据
   *
   * @param  array    $data   格式化前数据
   *
   * @return array    $data   格式化后数据
   */
  public function getWithWhereFormatDataInfo($data, $model = '')
  {
    if($data === false || $data === null )
    {
      return $data;
    }

    foreach($data as $key => $row)
    {
      if('Course' == $model)
      {
        if(isset($row['course_time']))
        {
          $data[$key]['course_time'] = date('Y-m-d H:i', $row['course_time']);
        }

        if(isset($row['course_time_end']))
        {
          $data[$key]['course_time_end'] = date('Y-m-d H:i', $row['course_time_end']);
        }

        if(isset($row['personage_id']))
        {
          $name = C('REDIS_FIGURE').'_'.$row['personage_id'];
          $data[$key]['personage_id'] = $this->handleRedis($name, '', 'pname', 'Figure');
        }
      }

      if('Commodity' == $model)
      {
        if(isset($row['personage_id']))
        {
          $name = C('REDIS_FIGURE').'_'.$row['personage_id'];
          $data[$key]['personage_id'] = $this->handleRedis($name, '', 'pname', 'Figure');
        }
      }


      if('Circle' == $model)
      {
        if(isset($row['a_userid']))
        {
          $where['user_id'] = $row['a_userid'];
          $where['valid']   = 1;

          $id = D('Figure')->getWithWhereTableOneFieldInfo($where, 'id', -2);
          $name = C('REDIS_FIGURE').'_'.$id;
          $data[$key]['a_userid'] = $this->handleRedis($name, '', 'pname', 'Figure');
        }

        if(isset($row['createtime']))
        {
          $data[$key]['createtime'] = date('Y-m-d H:i:s', $row['createtime']);
        }
      }


      if('Inform' == $model)
      {
        if(isset($row['object_id']))
        {
          $name = C('REDIS_QUESTION').'_'.$row['object_id'];
          $data[$key]['object_id'] = $this->handleRedis($name, '', 'title', 'Circle');
        }

        if(isset($row['userid']))
        {
          $name = C('REDIS_USER').$row['userid'];
          $data[$key]['userid'] = $this->handleRedis($name, '', 'reg_tel', 'Client');
        }

        if(isset($row['accuse_userid']))
        {
          $name = C('REDIS_USER').$row['accuse_userid'];
          $data[$key]['accuse_userid'] = $this->handleRedis($name, '', 'reg_tel', 'Client');
        }

        if(isset($row['summary']))
        {
          $name = C('REDIS_QUESTION').'_'.$row['object_id'];
          $summary = $this->handleRedis($name, '', 'content', 'Circle');

          if(80 < strlen($summary))
          {
            $data[$key]['summary'] = msubstr($summary, 0, 80);
          }
          else
          {
            $data[$key]['summary'] =  $summary;
          }
        }

        if(isset($row['createtime']))
        {
          $data[$key]['createtime'] = date('Y-m-d H:i:s', $row['createtime']);
        }
      }

      if('Comment' == $model)
      {
        if(isset($row['object_id']))
        {
          $name = C('REDIS_QUESTION').'_'.$row['object_id'];
          $data[$key]['object_id_text'] = $this->handleRedis($name, '', 'title', 'Circle');
        }

        if(isset($row['createtime']))
        {
          $data[$key]['createtime'] = date('Y-m-d H:i:s', $row['createtime']);
        }

        $name = C('REDIS_USER').$row['userid'];

        $data[$key]['username'] = $this->handleRedis($name, '', 'reg_tel', 'Client');

        if(isset($row['content']))
        {
          if(80 < strlen($row['content']))
          {
            $data[$key]['content'] = msubstr($row['content'], 0, 80);
          }
        }

        if(isset($row['module_name']))
        {
          switch($row['module_name'])
          {
            case 'question':
              $data[$key]['module_name_text'] = '问答';
              break;
            case 'course':
              $data[$key]['module_name_text'] = '课程';
              break;
            case 'commodity':
              $data[$key]['module_name_text'] = '商品';
              break;
            default:
              $data[$key]['module_name_text'] = '其他';
              break;
          }
        }
      }

      if('Message' == $model)
      {
        if(isset($row['uid']))
        {
          $name = C('REDIS_FIGURE').'_'.$row['uid'];
          $data[$key]['uid'] = $this->handleRedis($name, '', 'pname', 'Figure');
        }

        if(isset($row['content']))
        {
          if(80 < strlen($row['content']))
          {
            $data[$key]['content'] = msubstr($row['content'], 0, 80);
          }
        }

        if(isset($row['status']))
        {
          $data[$key]['status_text'] = $row['status'] == 1 ? '已完成' : ($row['status'] == -1 ? '已删除' : '等待中');
        }

        // if(isset($row['push_time']))
        // {
        //   $data[$key]['push_time'] = date('Y-m-d H:i:s', $row['push_time']);
        // }
      }
      if('Comment' == $model)
      {

      }
      else if('Message' == $model)
      {}
      else if('Config' == $model)
      {}
      else
      {
        if(isset($row['status']))
        {
          // $data[$key]['status'] = $row['status'] == 1 ? '启用' : '禁用';
        }
      }

      if(isset($row['create_time']))
      {
        $data[$key]['create_time'] = date('Y-m-d H:i:s', $row['create_time']);
      }

      if(isset($row['start']))
      {
        $data[$key]['start'] = date('Y-m-d H:i', $row['start']);
      }

      if(isset($row['end']))
      {
        $data[$key]['end'] = date('Y-m-d H:i', $row['end']);
      }

      if('Action' == $model)
      {
        if(isset($row['type']))
        {
          $data[$key]['type'] = $row['type'] == 1 ? '系统行为' : '用户行为';
        }

        if(isset($row['action_id']))
        {
          $data[$key]['action_id'] = get_action($row['action_id'],'title');
        }
      }

      if('Log' == $model)
      {
        if(isset($row['action_id']))
        {
          $data[$key]['action_id'] = get_action($row['action_id'],'title');
        }

        if(isset($row['user_id']))
        {
          $data[$key]['user_id'] = get_username($row['user_id']);
        }
      }

      if('Config' == $model)
      {
        if(isset($row['group']))
        {
          $data[$key]['group'] = get_config_group($row['group']);
        }

        if(isset($row['type']))
        {
          $data[$key]['type'] = get_config_type($row['type']);
        }
      }

      if('Advertisement' == $model)
      {
        if(isset($row['type']))
        {
          $data[$key]['type'] = $row['type'] == 1 ? '首页广告' : '其他广告';
        }
      }

      if('Menu' == $model)
      {
        if(isset($row['group']))
        {
          $data[$key]['group'] = empty($row['group']) ? '无' : $row['group'];
        }

        if(isset($row['is_dev']))
        {
          $data[$key]['is_dev'] = $row['is_dev'] == 1 ? '是' : '否';
        }

        if(isset($row['hide']))
        {
          $data[$key]['hide'] = $row['hide'] == 1 ? '是' : '否';
        }
      }

      if('Database' == $model)
      {
        if(isset($row['data_length']))
        {
          $data[$key]['data_length'] = format_bytes($row['data_length']);
        }
      }

      if(('Advertisement' == $model) || ('AdvertisementStart' == $model))
      {
        if(isset($row['object_type']))
        {
          $data[$key]['object_type'] = $row['object_type'] == 'service' ? '服务' : ($row['object_type'] == 'product' ? '商品' : ($row['object_type'] == 'people' ? '人物' : ($row['object_type'] == 'weblink' ? '链接' : '其他')));
        }

        if(isset($row['createtime']))
        {
          $data[$key]['createtime'] = date('Y-m-d H:i:s', $row['createtime']);
        }
      }

      if('Category' == $model)
      {
        if(isset($row['pid']))
        {
          $pid = $row['pid'];
          $data[$key]['cname'] = empty($data[$pid]['name']) ? '顶级分类' : $data[$pid]['name'];
        }
      }

      if('Order' == $model)
      {
        if(isset($row['user_id']))
        {
          $name = C('REDIS_USER').$row['user_id'];
          $data[$key]['user_id'] = $this->handleRedis($name, '', 'reg_tel', 'Client');
        }

        if(isset($row['user_id']))
        {
          $map['user_id'] = $row['user_id'];
          $data[$key]['pname'] = D('Figure')->getWithWhereTableOneFieldInfo($map, 'pname', -2);
          // $name = C('REDIS_FIGURE').'_'.$id;
          // $data[$key]['pname'] = $this->handleRedis($name, '', 'pname', 'Figure');
        }

        if('course' == $row['module_name'])
        {
          if(isset($row['object_id']))
          {
            $name = C('REDIS_COURSE').'_'.$row['object_id'];
            $data[$key]['title'] = $this->handleRedis($name, '', 'title', 'Course');

            // $id = $this->handleRedis($name, '', 'personage_id', 'Course');

            // $name = C('REDIS_FIGURE').'_'.$id;

            // $data[$key]['pname'] = $this->handleRedis($name, '', 'pname', 'Figure');
          }
        }
        else if('commodity' == $row['module_name'])
        {
          if(isset($row['object_id']))
          {
            $name = C('REDIS_COMMODITY').'_'.$row['object_id'];
            $data[$key]['title'] = $this->handleRedis($name, '', 'title', 'Commodity');

            // $id = $this->handleRedis($name, '', 'personage_id', 'Commodity');

            // $name = C('REDIS_FIGURE').'_'.$id;
            // $data[$key]['pname'] = $this->handleRedis($name, '', 'pname', 'Figure');
          }
        }

        if(isset($row['finish_time']))
        {
          $data[$key]['finish_time'] = date('Y-m-d H:i:s', $row['finish_time']);
        }

        if(isset($row['pay_type']))
        {
          $data[$key]['pay_type'] = $row['pay_type'] == 'ALIPAY' ? '支付宝' : '微信';
        }

        if(isset($row['module_name']))
        {
          $data[$key]['module_name_text'] = $row['module_name'] == 'course' ? '课程' : ($row['module_name'] == 'commodity' ? '商品' : '未知');
        }

        if(isset($row['order_status']))
        {
          if(1 == $row['order_status'])
          {
            if(1 == $row['pay_status'])
            {
              $data[$key]['order_status_text'] = '待支付';
            }
            else if(2 == $row['pay_status'])
            {
              $data[$key]['order_status_text'] = '待完成';
            }
            else if(0 == $row['pay_status'])
            {
              $data[$key]['order_status_text'] = '已支付';
            }
          }
          else if(2 == $row['order_status'])
          {
            $data[$key]['order_status_text'] = '已发货';
          }
          else if(0 == $row['order_status'])
          {
            $data[$key]['order_status_text'] = '已完成';
          }
          else if(-1 == $row['order_status'])
          {
            $data[$key]['order_status_text'] = '已删除';
          }
        }
      }
    }

    return $data;
  }





  /**
   * --------------------------------------------------------------------------------------
   * 格式化数据信息
   *
   * getFormatDataInfo($data, $type = 'date', $format = '', $field = '')
   */
  public function setDataFormat($data, $type, $style, $field)
  {
    import("Admin.Plugin.FormatPlugin");

    $format = new FormatPlugin();

    $result = $format->getFormatDataInfo($data, $type, $style, $field);

    return $result;
  }


  /**
   * --------------------------------------------------------------------------------------
   * 自定义禁用方法
   *
   * @param  String    $model  模型
   * @param  String    $where  执行条件
   * @param  String    $field  执行字段
   * @param  String    $return 跳转链接
   */
  public function custom_forbid($model, $where, $field = 'status', $return = '')
  {
    $info[$field] = 0;
    $flag = D($model)->doUpdateTableAction($where, $info);

    if ($flag)
    {
      $this->success('操作成功！', U($return));
    }
    else
    {
      $this->error('操作失败！');
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 自定义启用方法
   *
   * @param  String    $model  模型
   * @param  String    $where  执行条件
   * @param  String    $field  执行字段
   * @param  String    $return 跳转链接
   */
  public function custom_resume($model, $where, $field = 'status', $return = '')
  {
    $info[$field] = 1;
    $flag = D($model)->doUpdateTableAction($where, $info);

    if ($flag)
    {
      $this->success( '操作成功！', U($return));
    }
    else
    {
      $this->error('操作失败！');
    }
  }

  /**
   * --------------------------------------------------------------------------------------
   * 自定义删除方法
   *
   * @param  String    $model  模型
   * @param  String    $where  执行条件
   * @param  String    $field  执行字段
   * @param  String    $return 跳转链接
   */
  public function custom_delete($model, $where, $field='status', $return= '')
  {
    $result = D($model)->doUpdateTableFieldAction($where, $field, -1);

    if($result)
    {
      $this->success('删除成功！', U($return));
    }
    else
    {
      $this->error('删除失败！');
    }
  }
}
