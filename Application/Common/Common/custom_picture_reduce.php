<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @curlinese: 自定义图片压缩函数
 *     @english: custom_picture_reduce.php
 *
 * @version: 1.0
 * @desc   : 图片压缩
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2016-06-23 17:02:43
 */

  /**
   * --------------------------------------------------------------------------------------
   * 根据上传图片路径压缩图片
   *
   * @param  String  $url        图片原始路径
   * @param  String  $type       图片压缩类型
   * @param  String  $filetype   最终生成的图片类型（.jpg/.png/.gif）
   */
  function reduce($url, $type = 1, $filetype = '.jpg')
  {
    $data = pathinfo($url);

    $dirname  = $data['dirname'];
    $filename = $data['filename'];

    $picture = imagecreatefromjpeg('.'.$url);

    $name = '.'.$dirname.'/'.$filename;

    $proportion = proportion($type);

    $maxwidth  = $proportion[0];
    $maxheight = $proportion[1];

    custom_reduce($picture, $maxwidth, $maxheight, $name, $filetype);
  }


  /**
   * --------------------------------------------------------------------------------------
   * 图片压缩比例类型
   *
   * @param  String  $type       图片压缩类型
   *
   * @return Array   $result     压缩比例
   */
  function proportion($type = 1)
  {
    switch($type)
    {
      case 1:
        return array(800, 600);
        break;
      case 2:
        return array(600, 400);
        break;
      case 3:
        return array(400, 400);
        break;
      default:
        return array(100, 100);
    }
  }

  /**
   * --------------------------------------------------------------------------------------
   * 根据条件查询数据表的一个字段信息
   *
   * @param  Array   $picture    图片对象，应用函数之前，你需要用imagecreatefromjpeg()读取图片对象，如果PHP环境支持PNG，GIF，也可使用imagecreatefromgif()，imagecreatefrompng()；
   * @param  String  $maxwidth   定义生成图片的最大宽度（单位：像素）
   * @param  String  $maxheight  生成图片的最大高度（单位：像素）
   * @param  String  $name       生成的图片名
   * @param  String  $filetype   最终生成的图片类型（.jpg/.png/.gif）
   * <code>
       代码注释：

       第3~4行：读取需要缩放的图片实际宽高

       第8~26行：通过计算实际图片宽高与需要生成图片的宽高的压缩比例最终得出进行图片缩放是根据宽度还是高度进行缩放，当前程序是根据宽度进行图片缩放。如果你想根据高度进行图片缩放，你可以将第22行的语句改成$widthratio>$heightratio

       第28~31行：如果实际图片的长度或者宽度小于规定生成图片的长度或者宽度，则要么根据长度进行图片缩放，要么根据宽度进行图片缩放。

       第33~34行：计算最终缩放生成的图片长宽。

       第36~45行：根据计算出的最终生成图片的长宽改变图片大小，有两种改变图片大小的方法：ImageCopyResized()函数在所有GD版本中有效，但其缩放图像的算法比较粗糙。ImageCopyResamples()，其像素插值算法得到的图像边缘比较平滑，但该函数的速度比ImageCopyResized()慢。

       第47~49行：最终生成经过处理后的图片，如果你需要生成GIF或PNG，你需要将imagejpeg()函数改成imagegif()或imagepng()

       第51~56行：如果实际图片的长宽小于规定生成的图片长宽，则保持图片原样，同理，如果你需要生成GIF或PNG，你需要将imagejpeg()函数改成imagegif()或imagepng()。

       特别说明：

       　GD库1.6.2版以前支持GIF格式，但因GIF格式使用LZW演算法牵涉专利权，因此在GD1.6.2版之后不支持GIF的格式。如果你是WINDOWS的环境，你只要进入PHP.INI文件找到extension=php_gd2.dll，将#去除，重启APACHE即可，如果你是Linux环境，又想支持GIF，PNG，JPEG，你需要去下载libpng，zlib，以及freetype字体并安装。
   * </code>
   *
   * @return Array   $result  查询结果集
   */
  function custom_reduce($picture, $maxwidth, $maxheight, $name, $filetype)
  {
    $picwidth = imagesx($picture);
    $picheight = imagesy($picture);

    if(($maxwidth && $picwidth > $maxwidth) || ($maxheight && $picheight > $maxheight))
    {
      if($maxwidth && $picwidth>$maxwidth)
      {
        $widthratio = $maxwidth/$picwidth;
        $resizewidth_tag = true;
      }

      if($maxheight && $picheight>$maxheight)
      {
        $heightratio = $maxheight/$picheight;
        $resizeheight_tag = true;
      }

      if($resizewidth_tag && $resizeheight_tag)
      {
        if($widthratio<$heightratio)
        {
          $ratio = $widthratio;
        }
        else
        {
          $ratio = $heightratio;
        }
      }

      if($resizewidth_tag && !$resizeheight_tag)
      {
        $ratio = $widthratio;
      }

      if($resizeheight_tag && !$resizewidth_tag)
      {
        $ratio = $heightratio;
      }

      $newwidth = $picwidth * $ratio;
      $newheight = $picheight * $ratio;

      if(function_exists("imagecopyresampled"))
      {
        $newpicture = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($newpicture, $picture, 0,0,0,0, $newwidth, $newheight, $picwidth, $picheight);
      }
      else
      {
        $newpicture = imagecreate($newwidth,$newheight);
        imagecopyresized($newpicture,$picture,0,0,0,0,$newwidth,$newheight,$picwidth,$picheight);
      }

      $name = $name.$filetype;
      imagejpeg($newpicture,$name);
      imagedestroy($newpicture);
    }
    else
    {
      $name = $name.$filetype;
      imagejpeg($picture,$name);
    }
  }
