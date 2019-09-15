<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 商品模块控制器
 *     @english: ShopController.class.php
 *
 * @version: 1.0
 * @desc   : 商品模块控制器
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-08-26 16:57:11
 */
class ShopController extends HomeController
{

  /**
   * --------------------------------------------------------------------------------------
   * 商品列表页
   */
  public function index()
  {
    # 获取商品列表信息
    $list = D('Admin/Shop')->getWithWhereTableInfo();

    # 获取附加信息
    $attach['category'] = D('Admin/Category')->getWithWhereTableInfo();
    $attach['label']    = D('Admin/Label')->getWithWhereTableInfo();

    foreach($list as $k => $v)
    {
      $map['sid'] = $list[$k]['id'];

      $category = D('Admin/ShopCategoryRelevance')->getWithWhereShopCategoryRelInfo($map,'l.*, r.name');
      $label    = D('Admin/ShopLabelRelevance')->getWithWhereShopLabelRelInfo($map,'l.*, r.name');
      $picture  = D('Admin/ShopPictureRelevance')->getWithWhereShopPictureRelInfo($map);

      $list[$k]['category'] = $category;
      $list[$k]['label']    = $label;
      $list[$k]['picture']  = $picture;
    }

    $this->assign('list', $list);
    $this->assign('attach', $attach);
// dump($list);exit;
    $this->meta_title = '全部商品';
    $this->display();
  }


  /**
   * --------------------------------------------------------------------------------------
   * 商品详情页
   */
  public function detail()
  {
    # 获得商品编号
    $id = I('get.id', '', 'op_t');

    $where['id'] = $id;
    $list = D('Admin/Shop')->getWithWhereOneTableInfo($where);

    $size['weight']  = $list['weight'];
    $size['length']  = $list['length'];
    $size['width']   = $list['width'];
    $size['height']  = $list['height'];
    $size['limited'] = $list['limited'];
    $size['origin']  = $list['origin'];
    $size['cycle']   = $list['cycle'];

    foreach($size as $kk => $v)
    {
      if(empty($v))
      {
        unset($size[$kk]);
      }
      else
      {
        $list['size'][$kk][0] = $this->getWithEnglishChinese($kk);
        $list['size'][$kk][1] = $v;
      }
    }

    $map['sid'] = $list['id'];

    $category = D('Admin/ShopCategoryRelevance')->getWithWhereShopCategoryRelInfo($map,'l.*, r.name');
    $label    = D('Admin/ShopLabelRelevance')->getWithWhereShopLabelRelInfo($map,'l.*, r.name');
    $picture  = D('Admin/ShopPictureRelevance')->getWithWhereShopPictureRelInfo($map);

    $list['category'] = $category;
    $list['label']    = $label;
    $list['picture']  = $picture;

    foreach($label as $kkk => $v)
    {
      $data[$kkk] = $v['lid'];
    }
    $str = implode(',', $data);
    $ids .= $str.', ';
    $ids = trim($ids, ', ');

    unset($where);
    $where['lid'] = array('IN', $ids);
    $ids = D('Admin/ShopLabelRelevance')->getWithWhereTableInfo($where, 'sid');

    foreach($ids as $k => $v)
    {
      if((4 > $k) && ($id != $v['sid']))
      {
        unset($where);
        $where['id'] = $v['sid'];

        $related[$k] = D('Admin/Shop')->getWithWhereOneTableInfo($where);

        $map['sid'] = $related[$k]['id'];

        $category = D('Admin/ShopCategoryRelevance')->getWithWhereShopCategoryRelInfo($map,'l.*, r.name');
        $label    = D('Admin/ShopLabelRelevance')->getWithWhereShopLabelRelInfo($map,'l.*, r.name');
        $picture  = D('Admin/ShopPictureRelevance')->getWithWhereShopPictureRelInfo($map);

        $related[$k]['category'] = $category;
        $related[$k]['label']    = $label;
        $related[$k]['picture']  = $picture;

        $related = array_values($related);

        $this->assign('related', $related);
      }
    }

    # 获取附加信息
    $attach['category'] = D('Admin/Category')->getWithWhereTableInfo();
    $attach['label']    = D('Admin/Label')->getWithWhereTableInfo();


    $this->assign('list', $list);
    $this->assign('attach', $attach);

    $this->meta_title = '商品详情';
    $this->display();
  }


  private function getWithEnglishChinese($string)
  {
    switch($string)
    {
      case 'weight':
        return '商品重量';
        break;
      case 'length':
        return '商品长度';
        break;
      case 'width':
        return '商品宽度';
        break;
      case 'height':
        return '商品高度';
        break;
      case 'limited':
        return '商品有效期';
        break;
      case 'origin':
        return '商品产地';
        break;
      case 'cycle':
        return '商品制作周期';
        break;
    }
  }
}
