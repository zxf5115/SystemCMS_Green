<?php
/**
 * ---------------------------------------------------------------------------------
 * @filename
 *     @chinese: 缓存控制器
 *     @english: CacheController.class.php
 *
 * @version: 1.0
 * @desc   : 配置系统缓存信息
 *
 * @author : Zhang XiaoFei (1326336909@qq.com)
 * @date   : 2015-05-15 14:42:11
 */
class CacheController extends AdminController
{

  /**
   * --------------------------------------------------------------------------------------
   * 缓存信息
   */
  public function index()
  {
    $dirname = rtrim(CACHE_PATH, '/');
    $cache = format_bytes(D('Cache')->getFileSize($dirname), '-');
    $cache = explode('-', $cache);

    $dirname = rtrim(LOG_PATH, '/');
    $log = format_bytes(D('Cache')->getFileSize($dirname), '-');
    $log = explode('-', $log);

    $dirname = rtrim(TEMP_PATH, '/');
    $temp = format_bytes(D('Cache')->getFileSize($dirname), '-');
    $temp = explode('-', $temp);

    $this->assign('cacheSize', $cache[0]);
    $this->assign('cacheUnit', $cache[1]);
    $this->assign('logSize', $log[0]);
    $this->assign('logUnit', $log[1]);
    $this->assign('tempSize', $temp[0]);
    $this->assign('tempUnit', $temp[1]);
    $this->meta_title = '缓存信息';
    $this->list_title = '';
    $this->display();
  }

  public function clearCache()
  {
    $dirname = rtrim(CACHE_PATH, '/');

    D('Cache')->deleteFile($dirname);

    # 记录行为
    record_log('cache', 'Cache', 0, UID);

    # 此处为自动验证错误提示信息
    $this->success('清除缓存完成！', U('Cache/index'));
  }

  public function logCache()
  {
    $dirname = rtrim(LOG_PATH, '/');

    D('Cache')->deleteFile($dirname);

    # 记录行为
    record_log('cache', 'Cache', 0, UID);

    # 此处为自动验证错误提示信息
    $this->success('清除缓存完成！', U('Cache/index'));
  }

  public function tempCache()
  {
    $dirname = rtrim(TEMP_PATH, '/');

    # 记录行为
    record_log('cache', 'Cache', 0, UID);

    D('Cache')->deleteFile($dirname);

    # 此处为自动验证错误提示信息
    $this->success('清除缓存完成！', U('Cache/index'));
  }
}
