<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 联系控制器
 *     @english: ContactController.class.php
 *
 * @version: 1.0
 * @desc   : 联系控制器
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2017-03-03 16:18:11
 */
class ContactController extends HomeController
{
  /**
   * --------------------------------------------------------------------------------------
   * 联系页
   */
  public function index()
  {
    $this->assign('list', $list);
    $this->meta_title = '联系';
    $this->display();
  }

  /**
   * --------------------------------------------------------------------------------------
   * 新增意见
   */
  public function add()
  {
    if(IS_POST)
    {
      $post = I('post.', '', 'op_t');

      # 同一天内同一个IP只能提交一次意见信息
      $start_time = strtotime(date('Y-m-d').'00:00:00');
      $end_time = strtotime(date('Y-m-d').'23:59:59');
      $where['create_time'] = array(array('gt',$start_time),array('lt',$end_time));
      $where['ip_adress'] = get_client_ip();

      # 判断当前用户是否在今天提交过信息
      $flag = D('Admin/Contact')->getWithWhereOneTableInfo($where, 'id');

      if(empty($flag))
      {
        $post['ip_adress'] = get_client_ip();

        # 获取数据对象
        $result = D('Admin/Contact')->doSaveFromDataAction($post);

        # 此处为自动验证错误提示信息
        if(1 == $result['flag'])
        {
          $this->success('提交成功', U('Contact/index'));
        }
        else
        {
          $this->error($result['msg']);
        }
      }
      else
      {
        $this->error('您今日已经提交过意见，请明天继续。');
      }
    }
  }
}
