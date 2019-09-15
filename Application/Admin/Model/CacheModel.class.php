<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 缓存模型
 *     @english: CacheModel.class.php
 *
 * @version: 1.0
 * @desc   : 缓存模型
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 14:42:11
 */
class CacheModel extends CommonModel
{

# + ----------------------------------------------------------------------------------------------
# + 逻辑

  /**
   * --------------------------------------------------------------------------------------
   * 计算文件大小
   */
  public function getFileSize($dirname)
  {
    # 获取目录
    $dir = glob($dirname.'/*');

    $num = 0;

    foreach($dir as $file)
    {
      if(is_dir($file))
      {
        $num += $this->getFileSize($file);
      }
      else
      {
        $num += filesize($file);
      }
    }

    return $num;
  }


  /**
   * --------------------------------------------------------------------------------------
   * 删除文件
   */
  public function deleteFile($dirname)
  {
    $dir = opendir($dirname);

    while($file = readdir($dir))
    {
      $filename = $dirname.'/'.$file;

      if(is_dir($filename))
      {
        if($file != '.' && $file != '..')
        {
          $this->deleteFile($filename);
        }
      }
      else
      {
        unlink($filename);
      }
    }

    closedir($dir);
  }
}
