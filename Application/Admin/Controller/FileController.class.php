<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 后台文件控制器
 *     @english: FileController.class.php
 *
 * @version: 1.0
 * @desc   : 主要用于下载模型的文件上传和下载
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 14:42:11
 */

class FileController extends AdminController
{
  /**
   * --------------------------------------------------------------------------------------
   * 文件上传
   */
  public function upload()
  {
    $return = array('status' => 1, 'info' => '上传成功', 'data' => '');

    $File = D('FileUpload');

    $file_driver = C('DOWNLOAD_UPLOAD_DRIVER');

    $info = $File->upload(
      $_FILES,
      C('DOWNLOAD_UPLOAD'),
      C('DOWNLOAD_UPLOAD_DRIVER'),
      C("UPLOAD_{$file_driver}_CONFIG")
    );

    if ($info)
    {
      $return['data'] = $info[0]['path'];
      $return['id']   = $info[0]['id'];
    }
    else
    {
      $return['status'] = 0;
      $return['info'] = $File->getError();
    }

    $this->ajaxReturn($return);
  }

  /**
   * --------------------------------------------------------------------------------------
   * 文件下载
   */
  public function download($id = null)
  {
    if(empty($id) || !is_numeric($id))
    {
      $this->error('参数错误！');
    }

    $logic = D('Download', 'Logic');

    if(!$logic->download($id))
    {
      $this->error($logic->getError());
    }

  }


  /**
   * --------------------------------------------------------------------------------------
   * 用于表单自动上传图片的通用方法
   */
  public function uploadFile()
  {
    $return = array('status' => 1, 'info' => '上传成功', 'data' => '');

    $File = D('File');

    $file_driver = C('DOWNLOAD_UPLOAD_DRIVER');

    $info = $File->upload(
      $_FILES,
      C('DOWNLOAD_UPLOAD'),
      C('DOWNLOAD_UPLOAD_DRIVER'),
      C("UPLOAD_{$file_driver}_CONFIG")
      );

    if ($info)
    {
      $return['data'] = $info;
    }
    else
    {
      $return['status'] = 0;
      $return['info'] = $File->getError();
    }

    $this->ajaxReturn($return);
  }


  /**
   * --------------------------------------------------------------------------------------
   * 上传图片
   */
  public function uploadPicture()
  {
    $data['clientid'] = C('SJCLIENTID');
    $data['token']    = C('SJTOKEN');

    $uri = C('URI');
    return curl_data($uri, $data);
  }

  /**
   * --------------------------------------------------------------------------------------
   * 上传图片
   */
  public function uploadPicture2()
  {
    //TODO: 用户登录检测

    $return = array('status' => 1, 'info' => '上传成功', 'data' => '');

    $Picture = D('FileUpload');

    $pic_driver = C('PICTURE_UPLOAD_DRIVER');

    $info = $Picture->upload(
      $_FILES,
      C('PICTURE_UPLOAD'),
      C('PICTURE_UPLOAD_DRIVER'),
      C("UPLOAD_{$pic_driver}_CONFIG")
      );

    //TODO:上传到远程服务器

    if ($info)
    {
      $return['status'] = 1;

      if ($info['Filedata'])
      {
        $return = array_merge($info['Filedata'], $return);
      }

      if ($info['download'])
      {
        $return = array_merge($info['download'], $return);
      }

      if ($info['file'])
      {
        $return['data']['file'] = $info['file'];
      }
    }
    else
    {
      $return['status'] = 0;
      $return['info'] = $Picture->getError();
    }

    $this->ajaxReturn($return);
  }

  /**
   * --------------------------------------------------------------------------------------
   * 上传图片
   */
  public function uploadImage()
  {
    //TODO: 用户登录检测

    $return = array('status' => 1, 'info' => '上传成功', 'data' => '');

    $Picture = D('FileUpload');

    $pic_driver = C('PICTURE_UPLOAD_DRIVER');

    $info = $Picture->upload(
      $_FILES,
      C('PICTURE_UPLOAD'),
      C('PICTURE_UPLOAD_DRIVER'),
      C("UPLOAD_{$pic_driver}_CONFIG")
      );

    //TODO:上传到远程服务器

    if ($info)
    {
      $return['status'] = '1';

      if($info[0]['id'])
      {
        $return['id'] = $info[0]['id'];
      }

      if ($info[0]['path'])
      {
        reduce($info[0]['path']);
        $return['path'] = $info[0]['path'];
      }

      if ($info[0]['url'])
      {
        reduce($info[0]['url']);
        $return['url'] = $info[0]['url'];
      }

      if ($info['file'])
      {
        reduce($info[0]['file']);
        $return['data']['file'] = $info['file'];
      }
    }
    else
    {
      $return['status'] = 0;
      $return['info'] = $Picture->getError();
    }

    $this->ajaxReturn($return);
  }


  /**
   * --------------------------------------------------------------------------------------
   * 上传图片
   */
  public function uploadImageUE()
  {
    //TODO: 用户登录检测

    $return = array('status' => 'SUCCESS', 'info' => '上传成功', 'data' => '');

    $Picture = D('FileUpload');

    $pic_driver = C('PICTURE_UPLOAD_DRIVER');

    $info = $Picture->upload(
      $_FILES,
      C('PICTURE_UPLOAD'),
      C('PICTURE_UPLOAD_DRIVER'),
      C("UPLOAD_{$pic_driver}_CONFIG")
      );

    //TODO:上传到远程服务器

    if ($info)
    {
      $return['state'] = 'SUCCESS';

      if($info[0]['id'])
      {
        $return['id'] = $info['upfile']['id'];
      }

      if ($info['upfile']['path'])
      {
        reduce($info['upfile']['path']);
        $return['url'] = $info['upfile']['path'];
      }

      if ($info['upfile']['url'])
      {
        reduce($info['upfile']['url']);
        $return['url'] = $info['upfile']['url'];
      }

      if ($info['file'])
      {
        reduce($info['upfile']['file']);
        $return['data']['file'] = $info['file'];
      }
    }
    else
    {
      $return['status'] = 0;
      $return['info'] = $Picture->getError();
    }

    echo json_encode($return);
  }

  /**
   * --------------------------------------------------------------------------------------
   * 上传视频
   */
  public function uploadVideo()
  {
    //TODO: 用户登录检测
dump($_FILES);exit;
    $return = array('status' => 1, 'info' => '上传成功', 'data' => '');

    $Picture = D('FileUpload');

    $pic_driver = C('VIDEO_UPLOAD_DRIVER');

    $info = $Picture->upload(
      $_FILES,
      C('VIDEO_UPLOAD'),
      C('VIDEO_UPLOAD_DRIVER'),
      C("UPLOAD_{$pic_driver}_CONFIG")
      );

    //TODO:上传到远程服务器

    if ($info)
    {
      $return['status'] = 1;

      if($info[0]['id'])
      {
        $return['id'] = $info[0]['id'];
      }

      if ($info[0]['path'])
      {
        $return['path'] = $info[0]['path'];
      }

      if ($info[0]['url'])
      {
        $return['url'] = $info[0]['url'];
      }

      if ($info['file'])
      {
        $return['data']['file'] = $info['file'];
      }
    }
    else
    {
      $return['status'] = 0;
      $return['info'] = $Picture->getError();
    }

    $this->ajaxReturn($return);
  }


  /**
   * --------------------------------------------------------------------------------------
   * 用于兼容UM编辑器的图片上传方法
   */
  public function uploadPictureUM()
  {
    header("Content-Type:text/html;charset=utf-8");

    //TODO: 用户登录检测

    $return = array('status' => 1, 'info' => '上传成功', 'data' => '');

    //实际有用的数据只有name和state，这边伪造一堆数据保证格式正确
    $originalName = 'u=2830036734,2219770442&fm=21&gp=0.jpg';
    $newFilename = '14035912861705.jpg';
    $filePath = 'upload\/20140624\/14035912861705.jpg';
    $size = '7446';
    $type = '.jpg';
    $status = 'success';

    $rs = array(
      "originalName" => $originalName,
      'name' => $newFilename,
      'url' => $filePath,
      'size' => $size,
      'type' => $type,
      'state' => $status
      );

    $Picture = D('File');

    $pic_driver = C('PICTURE_UPLOAD_DRIVER');

    $info = $Picture->upload(
      $_FILES,
      C('PICTURE_UPLOAD'),
      C('PICTURE_UPLOAD_DRIVER'),
      C("UPLOAD_{$pic_driver}_CONFIG")
      );

    //TODO:上传到远程服务器

    if ($info)
    {
      $return['status'] = 1;

      if($info['Filedata'])
      {
        $return = array_merge($info['Filedata'], $return);
      }

      if($info['download'])
      {
        $return = array_merge($info['download'], $return);
      }

      $rs['state'] = 'SUCCESS';
      $rs['url'] = $info['upfile']['path'];

      if ($type == 'ajax')
      {
        echo json_encode($rs);
        exit;
      }
      else
      {
        echo json_encode($rs);
        exit;
      }
    }
    else
    {
      $return['state'] = 0;
      $return['info'] = $Picture->getError();
    }

    $this->ajaxReturn($return);
  }
}
