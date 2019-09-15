<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 插件控制器
 *     @english: AddonsController.class.php
 *
 * @version: 1.0
 * @desc   : 系统用到的插件
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-06-18 10:44:11
 */
class AddonsController extends AdminController
{

  public function _initialize()
  {
    parent::_initialize();

    $this->assign('_extra_menu',array(
      '已装插件'=> D('Addons')->getInstalledAddonListInfo(),
    ));
  }

  /**
   * --------------------------------------------------------------------------------------
   * 插件列表页
   */
  public function index()
  {
    $list = D('Addons')->getAddonsListInfo();

    $this->assign('_list', $list);

    $this->meta_title = '插件列表';
    $this->list_title = '';
    $this->display();
  }



  /**
   * --------------------------------------------------------------------------------------
   * 创建向导首页
   */
  public function add()
  {
    if(IS_POST)
    {
      $data       = I('post.', '', 'op_t');
      $addonFile  = $this->preview(false);
      $addons_dir = ADDON_PATH;

      # 创建目录结构
      $files      = array();
      $addon_dir  = "$addons_dir{$data['info']['name']}/";
      $files[]    = $addon_dir;
      $addon_name = "{$data['info']['name']}Addon.class.php";
      $files[]    = "{$addon_dir}{$addon_name}";

      # 如果有配置文件
      if($data['has_config'] == 1);
      $files[] = $addon_dir.'config.php';

      if($data['has_outurl'])
      {
        $files[] = "{$addon_dir}Controller/";
        $files[] = "{$addon_dir}Controller/{$data['info']['name']}Controller.class.php";
        $files[] = "{$addon_dir}Model/";
        $files[] = "{$addon_dir}Model/{$data['info']['name']}Model.class.php";
      }

      $custom_config = trim($data['custom_config']);

      if($custom_config)
      {
        $data[] = "{$addon_dir}{$custom_config}";
      }

      $custom_adminlist = trim($data['custom_adminlist']);

      if($custom_adminlist)
      {
        $data[] = "{$addon_dir}{$custom_adminlist}";
      }

      create_dir_or_files($files);

      # 写文件
      file_put_contents("{$addon_dir}{$addon_name}", $addonFile);

      if($data['has_outurl'])
      {
        $addonController = getAddonController($data);

        file_put_contents("{$addon_dir}Controller/{$data['info']['name']}Controller.class.php", $addonController);

        $addonModel = getAddonModel($data);
        file_put_contents("{$addon_dir}Model/{$data['info']['name']}Model.class.php", $addonModel);
      }

      if($data['has_config'] == 1)
      {
        file_put_contents("{$addon_dir}config.php", $data['config']);
      }

      $this->success('新增成功', U('Addons/index'));
    }
    else
    {
      if(!is_writable(ADDON_PATH))
      {
        $this->error('您没有创建目录写入权限，无法使用此功能');
      }

      $hooks = D('Hooks')->getWithWhereTableInfo('', 'name, description');

      $this->assign('Hooks',$hooks);
      $this->meta_title = '新增向导';
      $this->list_title = '';
      $this->display();
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 设置插件页面
   */
  public function config()
  {
    if(IS_POST)
    {
      $id     = I('id'    , '', 'op_t');
      $config = I('config', '', 'op_t');

      $where['id'] = $id;
      $field = 'config';
      $value = json_encode($config);

      $flag = D('Addons')->doUpdateTableFieldAction($where, $field, $value);

      if($flag !== false)
      {
        $this->success('保存成功', Cookie('__forward__'));
      }
      else
      {
        $this->error('保存失败');
      }
    }
    else
    {
      $id = I('id', '', 'op_t');

      $where['id'] = $id;
      $addon = D('Addons')->getWithWhereOneTableInfo($where);

      if(empty($addon))
      {
        $this->error('插件未安装');
      }

      $addon_class = get_addon_class($addon['name']);

      if(!class_exists($addon_class))
      {
        trace("插件{$addon['name']}无法实例化,", 'ADDONS', 'ERR');
      }

      $data = new $addon_class;

      $addon['addon_path'] = $data->addon_path;
      $addon['custom_config'] = $data->custom_config;

      $this->meta_title   =   '设置插件-'.$data->info['title'];

      $db_config = $addon['config'];

      $addon['config'] = include $data->config_file;

      if($db_config)
      {
        $db_config = json_decode($db_config, true);

        foreach ($addon['config'] as $key => $value)
        {
          if($value['type'] != 'group')
          {
            $addon['config'][$key]['value'] = $db_config[$key];
          }
          else
          {
            foreach ($value['options'] as $gourp => $options)
            {
              foreach ($options['options'] as $gkey => $value)
              {
                $addon['config'][$key]['options'][$gourp]['options'][$gkey]['value'] = $db_config[$gkey];
              }
            }
          }
        }
      }

      $this->assign('data',$addon);

      if($addon['custom_config'])
      {
        $this->assign('custom_config', $this->fetch($addon['addon_path'].$addon['custom_config']));
      }

      $this->display();
    }
  }



  /**
   * --------------------------------------------------------------------------------------
   * 检查表单数据
   */
  public function checkForm()
  {
    $data = I('post.', '', 'op_t');

    if(empty($data['info']['name']))
    {
      $this->error('插件标识必须');
    }

    # 检测插件名是否合法
    $addons_dir = ADDON_PATH;

    if(file_exists("{$addons_dir}{$data['info']['name']}"))
    {
      $this->error('插件已经存在了');
    }

    $this->success('可以创建');
  }


  /**
   * --------------------------------------------------------------------------------------
   * 预览页
   */
  public function preview($output = true)
  {
    $data                   =   I('post.', '', 'op_t');
    $data['info']['status'] =   (int)$data['info']['status'];
    $extend                 =   array();
    $custom_config          =   trim($data['custom_config']);

    if($data['has_config'] && $custom_config)
    {
      $custom_config = "public $custom_config = '{$custom_config}';";
      $extend[] = $custom_config;
    }

    $admin_list = trim($data['admin_list']);

    if($data['has_adminlist'] && $admin_list)
    {
      $admin_list = "public $admin_list = array({$admin_list});";
      $extend[] = $admin_list;
    }

    $custom_adminlist = trim($data['custom_adminlist']);

    if($data['has_adminlist'] && $custom_adminlist)
    {
      $custom_adminlist = "public $custom_adminlist = '{$custom_adminlist}';";
      $extend[] = $custom_adminlist;
    }

    $extend = implode('', $extend);
    $hook = '';
    foreach ($data['hook'] as $value)
    {
      $hook .= "//实现的{$value}钩子方法".
               "public function {$value}(\$param)".
               "{}";
    }

    $tpl = getAddonInfo($data, $extend, $hook);

    if($output)
    {
      exit($tpl);
    }
    else
    {
      return $tpl;
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 安装插件
   */
  public function install()
  {
    $addon_name = I('get.addon_name', '', 'op_t');

    $class = get_addon_class($addon_name);

    if(!class_exists($class))
    {
      $this->error('插件不存在');
    }

    $addons = new $class;
    $info   = $addons->info;

    # 检测信息的正确性
    if(empty($info) || !$addons->checkInfo())
    {
      $this->error('插件信息缺失');
    }

    session('addons_install_error', null);

    $install_flag = $addons->install();

    if(empty($install_flag))
    {
      $this->error('执行插件预安装操作失败'.session('addons_install_error'));
    }

    $addonsModel = D('Addons');
    $data = $addonsModel->doSaveFromDataAction($info);

    if(is_array($addons->admin_list) && $addons->admin_list !== array())
    {
      $data['has_adminlist'] = 1;
    }
    else
    {
      $data['has_adminlist'] = 0;
    }

    if(empty($data))
    {
      $this->error($addonsModel->getError());
    }

    if($addonsModel->doAddTableAction($data))
    {
      $config = array('config'=>json_encode($addons->getConfig()));

      $where['name'] = $addon_name;
      $addonsModel->doUpdateTableAction($where, $config);

      $hooks_update = D('Hooks')->doUpdateHookAction($addon_name);

      if($hooks_update)
      {
        S('hooks', null);
        $this->success('安装成功');
      }
      else
      {
        $addonsModel->where("name='{$addon_name}'")->delete();
        $this->error('更新钩子处插件失败,请卸载后尝试重新安装');
      }
    }
    else
    {
      $this->error('写入插件数据失败');
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 卸载插件
   */
  public function uninstall()
  {
    $id = I('get.id', '', 'op_t');

    $addonsModel = D('Addons');

    $where['id'] = $id;
    $data = $addonsModel->getWithWhereOneTableInfo($where);

    $class = get_addon_class($data['name']);

    $this->assign('jumpUrl', U('index'));

    if(!$data || !class_exists($class))
    {
      $this->error('插件不存在');
    }

    session('addons_uninstall_error',null);

    $addons = new $class;
    $uninstall_flag = $addons->uninstall();

    if(!$uninstall_flag)
    {
      $this->error('执行插件预卸载操作失败'.session('addons_uninstall_error'));
    }

    $hooks_update = D('Hooks')->doRemoveHookAction($data['name']);

    if($hooks_update === false)
    {
      $this->error('卸载插件所挂载的钩子数据失败');
    }

    S('hooks', null);

    $where['name'] = $data['name'];
    $delete = $addonsModel->doDeleteTableAction($where);

    if($delete === false)
    {
      $this->error('卸载插件失败');
    }
    else
    {
      $this->success('卸载成功');
    }
  }



  /**
   * --------------------------------------------------------------------------------------
   * 状态修改
   */
  public function changeStatus($method = null)
  {
    $id = I('get.id', 0);

    if(empty($id))
    {
      $id = array_unique((array)I('post.id', 0));
    }
    else
    {
      $id = (array)$id;
    }

    $id = is_array($id) ? implode(',',$id) : $id;

    if(empty($id))
    {
      $this->error('请选择要操作的数据!');
    }

    $map['id'] = array('in', $id);

    switch(strtolower($method))
    {
      case 'forbid':
        S('hooks', null);
        $this->forbid('Addons', $map);
        break;
      case 'resume':
        S('hooks', null);
        $this->resume('Addons', $map);
        break;
      case 'delete':
        $this->delete('Addons', $map);
        break;
      default:
        $this->error('参数非法');
    }
  }





  /**
   * --------------------------------------------------------------------------------------
   * 插件显示页面
   */
  public function installed()
  {
    $name = I('name', '', 'op_t');

    # 记录当前列表页的cookie
    Cookie('__forward__',$_SERVER['REQUEST_URI']);

    $class = get_addon_class($name);

    if(!class_exists($class))
    {
      $this->error('插件不存在');
    }

    $addon = new $class();

    $this->assign('addon', $addon);

    $param  =   $addon->admin_list;

    if(!$param)
    {
      $this->error('插件列表信息不正确');
    }

    $this->meta_title = $addon->info['title'];

    extract($param);

    $this->assign('title', $addon->info['title']);

    $this->assign($param);

    if(!isset($fields))
    {
      $fields = '*';
    }

    if(!isset($map))
    {
      $map = array();
    }

    if(isset($model))
    {
      $list = $this->paging(D("Addons://{$model}/{$model}")->field($fields),$map,$order);
    }

    $this->assign('_list', $list);

    if($addon->custom_adminlist)
    {
      $this->assign('custom_adminlist', $this->fetch($addon->addon_path.$addon->custom_adminlist));
    }

    $this->display();
  }


  /**
   * --------------------------------------------------------------------------------------
   * 插件执行
   */
  public function execute($_addons = null, $_controller = null, $_action = null)
  {
    if(C('URL_CASE_INSENSITIVE'))
    {
      $_addons        =   ucfirst(parse_name($_addons, 1));
      $_controller    =   parse_name($_controller,1);
    }

    $TMPL_PARSE_STRING = C('TMPL_PARSE_STRING');
    $TMPL_PARSE_STRING['__ADDONROOT__'] = __ROOT__ . "/Addons/{$_addons}";
    C('TMPL_PARSE_STRING', $TMPL_PARSE_STRING);


    if(!empty($_addons) && !empty($_controller) && !empty($_action))
    {
      $Addons = A("Addons://{$_addons}/{$_controller}")->$_action();
    }
    else
    {
      $this->error('没有指定插件名称，控制器或操作！');
    }
  }



  /**
   * --------------------------------------------------------------------------------------
   * 插件编辑
   */
  public function edit($name, $id = 0)
  {
    $this->assign('name', $name);
    $class = get_addon_class($name);

    if(!class_exists($class))
    {
      $this->error('插件不存在');
    }

    $addon = new $class();
    $this->assign('addon', $addon);
    $param = $addon->admin_list;

    if(!$param)
    {
      $this->error('插件列表信息不正确');
    }
    extract($param);
    $this->assign('title', $addon->info['title']);

    if(isset($model))
    {
      $addonModel = D("Addons://{$name}/{$model}");
    }

    if(!$addonModel)
    {
      $this->error('模型无法实列化');
    }
    $model = $addonModel->model;
    $this->assign('model', $model);


    if($id)
    {
      $data = $addonModel->find($id);
      $data || $this->error('数据不存在！');
      $this->assign('data', $data);
    }

    if(IS_POST)
    {
      // 获取模型的字段信息
      if(!$addonModel->create())
      {
        $this->error($addonModel->getError());
      }

      if($id)
      {
        $flag = $addonModel->save();
        if($flag !== false)
        {
          $this->success("编辑{$model['title']}成功！", Cookie('__forward__'));
        }
        else
        {
          $this->error($addonModel->getError());
        }
      }
      else
      {
        $flag = $addonModel->add();
        if($flag)
        {
          $this->success("添加{$model['title']}成功！", Cookie('__forward__'));
        }
      }

      $this->error($addonModel->getError());
    }
    else
    {
      $fields = $addonModel->_fields;
      $this->assign('fields', $fields);
      $this->meta_title = $id? '编辑'.$model['title']:'新增'.$model['title'];
      if($id)
      {
        $template = $model['template_edit']? $model['template_edit']: '';
      }
      else
      {
        $template = $model['template_add']? $model['template_add']: '';
      }

      $this->display($addon->addon_path.$template);
    }
  }



  /**
   * --------------------------------------------------------------------------------------
   * 插件删除
   */
  public function del($id = '', $name)
  {
    $ids = array_unique((array)I('ids',0));

    if ( empty($ids) )
    {
      $this->error('请选择要操作的数据!');
    }

    $class = get_addon_class($name);
    if(!class_exists($class))
    {
      $this->error('插件不存在');
    }

    $addon = new $class();
    $param = $addon->admin_list;

    if(!$param)
    {
      $this->error('插件列表信息不正确');
    }
    extract($param);

    if(isset($model))
    {
      $addonModel = D("Addons://{$name}/{$model}");
      if(!$addonModel)
      {
        $this->error('模型无法实列化');
      }
    }

    $map = array('id' => array('in', $ids) );
    if($addonModel->where($map)->delete())
    {
      $this->success('删除成功');
    }
    else
    {
      $this->error('删除失败！');
    }
  }
}
