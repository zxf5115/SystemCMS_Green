;(function($)
{
  $.extend(
  {
    /**
     * ---------------------------------------------------------------------------------
     * @filename
     *     @chinese: 文件自定义上传插件
     *     @english: file_custom_upload.php
     *
     * @version: 1.0
     * @desc   : 主要用于文件上传
     *
     * @author : Zhang XiaoFei (1326336909@qq.com)
     * @date   : 2015-05-15 14:42:11
     */
    custom_upload: function(classNmae, url, edit, i, type)
    {
      // 点击button时打开分类选择窗体
      $('#upload'+i).bind("click", function()
      {
        if(1 == type)
        {
          $.custom_single_upload(classNmae, url, i, edit);
        }
        else if(3 == type)
        {
          $.custom_video_upload(classNmae, url, i, edit);
        }
        else
        {
          $.custom_more_upload(classNmae, url, i, edit);
        }

      });
    },

    custom_single_upload: function(classNmae, url, i, edit)
    {
      var $preview = $("#preview"+i);


      var edit_clear = $preview.find('tbody').find('tr');

      if(edit_clear.length > 0)
      {
        $preview.find('tbody').html('');
      }


      $('#upload'+i).fileupload(
      {
        autoUpload: true,       //是否自动上传 [是]
        url: url,               //上传地址
        dataType: 'json',       //
        acceptFileTypes: /(\.|\/)(jpe?g|png)$/i,
        maxFileSize: 1000000, //文件大小限制 [1M]
        maxNumberOfFiles : 1,   //文件数量限制
        processalways: function (e, data)
        {
          var index = data.index,
          file = data.files[index];
          if (file.error)
          {
            updateAlert(file.error,'alert-error');
          }
          else
          {
            $.custom_preview($preview, 1);

            data.submit();
          }
        },
        done: function (e, data)
        {
          var data = data.result;

          if(data.status == 1)
          {
            var path = data.path;

            $.custom_success($preview, path, classNmae, 0, 1);
          }
          else
          {
            $.custom_error($preview, 0);
          }
        },
        messages:
        {
          acceptFileTypes: '图片格式错误，请重新选择文件',
          maxFileSize: '图片大于1兆，请重新选择文件'
        }
      });
    },

    custom_more_upload: function(classNmae, url, i, edit)
    {
      var max = 7;
      var tr = 0;
      var x = 1;
      var $preview = $("#preview"+i);

      var clear = $preview.find('tbody').find('.clear');

      if(clear.length > 0)
      {
        $preview.find('tbody').html('');
      }

      var edit_clear = $preview.find('tbody').find('tr');

      if(edit_clear.length > 0)
      {
        max = 7 - parseInt(edit_clear.length);
        x = 1 + parseInt(edit_clear.length);
        tr = parseInt(edit_clear.length);
      }


      $('#upload'+i).fileupload(
      {
        autoUpload: true,       //是否自动上传 [是]
        url: url,               //上传地址
        dataType: 'json',       //
        acceptFileTypes: /(\.|\/)(jpe?g|png)$/i,
        maxFileSize: 1000000, //文件大小限制 [1M]
        maxNumberOfFiles : max,   //文件数量限制
        processalways: function (e, data)
        {
          var index = data.index,
          file = data.files[index];
          if (file.error)
          {
            updateAlert(file.error,'alert-error');
          }
          else
          {
            $.custom_preview($preview, x);
            x++;

            data.submit();
          }
        },
        done: function (e, data)
        {
          var data = data.result;

          if((data.status == 1) && (tr < 7))
          {
            var path = data.path;

            $.custom_success($preview, path, classNmae, tr, 1);
            tr++;
          }
          else
          {
            $.custom_error($preview, tr);
            tr++;
          }
        },
        messages:
        {
          acceptFileTypes: '图片格式错误，请重新选择文件',
          maxNumberOfFiles: '轮播图最多上传7张',
          maxFileSize: '图片大于1兆，请重新选择文件'
        }
      });
    },

    custom_video_upload: function(classNmae, url, i, edit)
    {
      var $preview = $("#preview"+i);

      if(1 == edit)
      {
        var edit_clear = $preview.find('tbody').find('tr');

        if(edit_clear.length > 0)
        {
          $preview.find('tbody').html('');
        }
      }

      $('#upload'+i).fileupload(
      {
        autoUpload: true,       //是否自动上传 [是]
        url: url,               //上传地址
        dataType: 'json',       //
        acceptFileTypes: /(\.|\/)(mp4)$/i,
        maxNumberOfFiles : 1,   //文件数量限制
        processalways: function (e, data)
        {
          var index = data.index,
          file = data.files[index];
          if (file.error)
          {
            updateAlert(file.error,'alert-error');
          }
          else
          {
            $.custom_preview($preview, 1);

            data.submit();
          }
        },
        done: function (e, data)
        {
          var data = data.result;

          if(data.error == 1)
          {
            var path = data.path;
            // path1 = path[0]['mp4_1'];
            // path2 = path[0]['mp4_2'];

            // if(('' == path2) || ('undefined' == path2) || (!path2))
            // {
            //   video = path1;
            // }
            // else
            // {
            //   video = path2;
            // }

            $.custom_success($preview, path, classNmae, 0, 2);
          }
          else
          {
            $.custom_error($preview, 0);
          }
        },
        messages:
        {
          acceptFileTypes: '图片格式错误，请重新选择文件',
          maxFileSize: '图片大于1兆，请重新选择文件'
        }
      });
    },

    // 自定义预览
    custom_preview: function(handle, x)
    {
      var clear = handle.find('tbody').find('.clear');

      if(clear.length > 0)
      {
        handle.find('tbody').html('');
      }

      var tr = handle.find('tbody').find('tr');
      if(tr.length > 0)
      {
        var $el = $('<tr>\
                      <td class="text-center">'+(x)+'</td>\
                      <td style="padding:7px 15px 0;height:30px;"></td>\
                      <td>上传中...</td>\
                      <td></td>\
                    </tr>');

        handle.find('tbody').append($el);
      }
      else
      {
        var $el = $('<tr>\
                      <td class="text-center">'+(x)+'</td>\
                      <td style="padding:7px 15px 0;height:30px;"></td>\
                      <td>上传中...</td>\
                      <td></td>\
                    </tr>');

        handle.find('tbody').append($el);
      }
    },

    // 自定义成功
    custom_success: function(handle, url, classNmae, tr, x)
    {
      if(2 == x)
      {
        handle.find('tbody').find('tr:eq('+tr+')').find('td:eq(1)').html("<a href='"+url+"' target='_black'>查看详情</a>");
      }
      else
      {
        handle.find('tbody').find('tr:eq('+tr+')').find('td:eq(1)').html("<a href='"+url+"' target='_black'><img src='"+url+"' style='width:30px;'/></a>");
      }

      handle.find('tbody').find('tr:eq('+tr+')').find('td:eq(2)').html('<span class="text-success">成功</span>');

      handle.find('tbody').find('tr:eq('+tr+')').find('td:eq(3)').html('<a href="javascript:;" onclick="$.custom_remove(this);"><span>删除</span></a>');

      handle.find('tbody').find('tr:eq('+tr+')').find('td:eq(3)').append("<input name='"+classNmae+"' type='hidden' value='"+url+"'/>");
    },

    // 自定义错误
    custom_error: function(handle, tr)
    {
      handle.find('tbody').find('tr:eq('+tr+')').find('td:eq(2)').html('<span class="text-success">失败</span>');


      handle.find('tbody').find('tr:eq('+tr+')').find('td:eq(3)').html('<a href="javascript:;" onclick="$.custom_remove(this);"><span>删除</span></a>');
    },

    // 自定义删除
    custom_remove: function(self)
    {
      $(self).parent().parent().remove();
    }
  });
})(jQuery);
