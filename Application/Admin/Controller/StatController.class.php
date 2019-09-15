<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 统计控制器
 *     @english: StatController.class.php
 *
 * @version: 1.0
 * @desc   : 统计控制器
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 14:42:11
 */

class StatController extends AdminController
{

  /**
   * --------------------------------------------------------------------------------------
   * 用户统计
   */
  public function index()
  {
    # 获取时间间隔条件
    $set['interval'] = I('get.interval', '1', 'op_t');

    $yesterday = date('Y-m-d 00:00:00', strtotime('-1 day'));
    $today     = date('Y-m-d 00:00:00');

    # 调用继承方法得到坐标X轴的范围数据
    $data = $this->getWithWherePeriodInfo($set['interval'], $yesterday, $today);

    # 调用继承方法得到统计数据
    $result = $this->getWithWhereStatInfo('Member', 'id', $set['interval'], $yesterday, $today);

    $list = $result[0];

    # 统计数据整理
    $res = trimStatInfo($data, $list);

    $data = array();
    $str = explode(',', $res['str']);
    $gap = explode(',', $res['gap']);

    foreach($str as $k => $vo)
    {
      $data[$k]['date'] = $gap[$k];
      // $data[$k]['date'] = $k;
      $data[$k]['data'] = $vo;
    }

    echo json_encode($data);
  }



  /**
   * --------------------------------------------------------------------------------------
   * 用户地区统计
   */
  public function area()
  {
    $where = array();

    $list = D('Member')->getWithWhereTableDetailInfo($where, 'province, count(province) AS val', 'create_time ASC', 1, 'id', 'uid','province');

    foreach($list as &$v)
    {
      $where['id'] = $v['province'];

      $v['province'] = D('Province')->getWithWhereTableOneFieldInfo($where, 'name');
      $v['val'] = (int)$v['val'];
    }

    echo json_encode($list);
  }

  /**
   * --------------------------------------------------------------------------------------
   * 用户性别统计
   */
  public function sex()
  {
    $where = array();

    $list = D('MemberExtend')->getWithWhereTableInfo($where, 'sex, count(sex) AS val', 'id ASC', 'sex');

    foreach($list as &$v)
    {
      $v['val'] = (int)$v['val'];
    }

    echo json_encode($list);
  }


  /**
   * --------------------------------------------------------------------------------------
   * PV统计
   */
  public function pv()
  {
    $yesterday = strtotime(date('Y-m-d H:i:m', strtotime('-1 day')));
    $today     = strtotime(date('Y-m-d H:i:m'));

    $where['create_time'] = array(array('lt', $today), array('egt', $yesterday), 'AND');

    $current = D('PV')->getWithWhereTableInfo($where, 'FROM_UNIXTIME(create_time,"%Y-%m-%d") AS data, count(id) AS val', 'create_time ASC', 1, 'FROM_UNIXTIME(create_time,"%Y-%m-%d")');

    $total   = D('PV')->getWithWhereTableInfo('', 'FROM_UNIXTIME(create_time,"%Y-%m-%d") AS data, count(id) AS val', 'create_time ASC', 1, '');


    $list['scale']   = number_format(($current[0]['val'] / $total[0]['val']) * 100, 2, '.', '');
    $list['current'] = $current[0]['val'];

    echo json_encode($list);
  }



  /**
   * --------------------------------------------------------------------------------------
   * UV统计
   */
  public function uv()
  {
    $yesterday = strtotime(date('Y-m-d H:i:m', strtotime('-1 day')));
    $today     = strtotime(date('Y-m-d H:i:m'));

    $where['create_time'] = array(array('lt', $today), array('egt', $yesterday), 'AND');

    $current = D('UV')->getWithWhereTableInfo($where, 'FROM_UNIXTIME(create_time,"%Y-%m-%d") AS data, count(id) AS val', 'create_time ASC', 1, 'FROM_UNIXTIME(create_time,"%Y-%m-%d")');

    $total   = D('UV')->getWithWhereTableInfo('', 'FROM_UNIXTIME(create_time,"%Y-%m-%d") AS data, count(id) AS val', 'create_time ASC', 1, '');


    $list['scale']   = number_format(($current[0]['val'] / $total[0]['val']) * 100, 2, '.', '');
    $list['current'] = $current[0]['val'];

    echo json_encode($list);
  }
}
