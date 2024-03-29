<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------


use Think\Action;

/**
 * 分类widget
 * 用于动态调用分类信息
 */
class UeditorMiniWidget extends Action
{

    /* 显示指定分类的同级分类或子分类列表 */
    public function editor($id = 'myeditor', $name = 'content',$default='',$url='',$width='100%',$height='200px',$config='')
    {
        $this->assign('id',$id);
        $this->assign('url',$url);
        $this->assign('name',$name);
        $this->assign('default',$default);
        $this->assign('width',$width);
        $this->assign('height',$height);
        if($config=='')
        {
            //$config='toolbar: [\'undo redo | bold italic underline insertimage\']';
        }
        $this->assign('config',$config);

        $this->display('Widget/ueditormini');
    }

}
