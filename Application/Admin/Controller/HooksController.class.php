<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 钩子控制器
 *     @english: HooksController.class.php
 *
 * @version: 1.0
 * @desc   : 系统用到的钩子
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-06-18 10:44:11
 */
class HooksController extends AdminController
{
  /**
   * --------------------------------------------------------------------------------------
   * 钩子列表
   */
  public function index()
  {
    $get   = I('get.'  , '', 'op_t');

    if($get)
    {
      # 可以排序的字段
      $keys = array('id','id','name','description','type','status');

      $search_fields = 'id|name|description';

      $this->getWithWhereTablePagingInfo('', 'Hooks', $keys, $search_fields, $get, 'id');

    }
    else
    {
      //使用前台排序
      $list = D('Hooks')->getWithWhereCurrentTableDetailInfo('', true, 'id DESC', -2, '', '0, 10');

      int_to_string($list, array('type'=>C('HOOKS_TYPE')));

      $this->assign('_list', $list);
      $this->meta_title = '钩子列表';
      $this->display();
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 新增插件钩子，用于挂载页面
   */
  public function add()
  {
    if(IS_POST)
    {
      $post = I('post.');

      # 获取数据对象
      $result = D('Hooks')->doSaveFromDataAction($post);

      # 此处为自动验证错误提示信息
      if(-1 == $result['flag'])
      {
        $this->error($result['msg']);
      }
      else if(0 == $result['flag'])
      {
        $this->error($result['msg']);
      }
      else if(1 == $result['flag'])
      {
        $this->success($result['msg'], U('Hooks/index'));
      }
    }
    else
    {
      $this->assign('data', null);

      $this->meta_title = '新增钩子';
      $this->display();
    }
  }


  /**
   * --------------------------------------------------------------------------------------
   * 编辑插件钩子，用于挂载页面
   */
  public function edit($id)
  {
    if(IS_POST)
    {
      $post = I('post.');

      # 获取数据对象
      $result = D('Hooks')->doSaveFromDataAction($post);

      # 此处为自动验证错误提示信息
      if(-1 == $result['flag'])
      {
        $this->error($result['msg']);
      }
      else if(0 == $result['flag'])
      {
        $this->error($result['msg']);
      }
      else if(1 == $result['flag'])
      {
        $this->success($result['msg'], U('Hooks/index'));
      }
    }
    else
    {
      $id = I('id', '', 'op_t');

      $where['id'] = $id;

      $hook = D('Hooks')->getWithWhereOneTableInfo($where);

      $this->assign('data',$hook);
      $this->meta_title = '编辑钩子';
      $this->display();
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
        $this->forbid('Hooks', $map);
        break;
      case 'resume':
        $this->resume('Hooks', $map);
        break;
      case 'delete':
        $this->delete('Hooks', $map);
        break;
      default:
        $this->error('参数非法');
    }
  }
}
