<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 后台系统字符串库
 *     @english: heredoc.php
 *
 * @version: 1.0
 * @desc   : 后台系统字符串库
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-06-18 10:44:11
 */


function getAddonController($data)
{
  $addonController = <<<str
<?php
  namespace Addons\\{$data['info']['name']}\Controller;
  use Home\Controller\AddonsController;

  /**
   * --------------------------------------------------------------------------------------
   * {$data['info']['name']}控制器
   */
  class {$data['info']['name']}Controller extends AddonsController
  {

  }
str;

  return $addonController;
}



function getAddonModel($data)
{
  $addonModel = <<<str
<?php
  namespace Addons\\{$data['info']['name']}\Model;
  use Think\Model;

  /**
   * -------------------------------------------------------------
   * {$data['info']['name']}模型
   */
  class {$data['info']['name']}Model extends Model
  {
    public \$model = array(
      'title'=>'',//新增[title]、编辑[title]、删除[title]的提示
      'template_add'=>'',//自定义新增模板自定义html edit.html 会读取插件根目录的模板
      'template_edit'=>'',//自定义编辑模板html
      'search_key'=>'',// 搜索的字段名，默认是title
      'extend'=>1,
    );

    public \$_fields = array(
      'id'=>array(
        'name'=>'id',//字段名
        'title'=>'ID',//显示标题
        'type'=>'num',//字段类型
        'remark'=>'',// 备注，相当于配置里的tip
        'is_show'=>3,// 1-始终显示 2-新增显示 3-编辑显示 0-不显示
        'value'=>0,//默认值
      ),
      'title'=>array(
        'name'=>'title',
        'title'=>'书名',
        'type'=>'string',
        'remark'=>'',
        'is_show'=>1,
        'value'=>0,
        'is_must'=>1,
      ),
    );
  }
str;

  return $addonModel;
}


function getAddonInfo($data, $extend, $hook)
{
  $tpl = <<<str
<?php
  namespace Addons\\{$data['info']['name']};
  use Common\Controller\Addon;

  /**
   * -------------------------------------------------------------
   * {$data['info']['name']}插件
   */

  class {$data['info']['name']}Addon extends Addon
  {

    public \$info = array(
      'name'=>'{$data['info']['name']}',
      'title'=>'{$data['info']['title']}',
      'description'=>'{$data['info']['description']}',
      'status'=>{$data['info']['status']},
      'author'=>'{$data['info']['author']}',
      'version'=>'{$data['info']['version']}'
      );

    {$extend}

    public function install()
    {
      return true;
    }

    public function uninstall()
    {
      return true;
    }

    {$hook}
  }
str;

  return $tpl;
}

