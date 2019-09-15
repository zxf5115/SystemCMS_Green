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
            $.custom_preview($preview, 1, 1);

            data.submit();
          }
        },
        done: function (e, data)
        {
          var data = data.result;

          if(data.status == 0)
          {
            var path = data.message;

            $.custom_success($preview, path, classNmae, 0, 1);
          }
          else
          {
            $.custom_error($preview, 0, 1);
          }
        },
        messages:
        {
          acceptFileTypes: '图片类型不合法（只接受：jpeg、png）',
          maxFileSize: '图片大小超过限制,最大不应大于1M'
        }
      });
    },

    custom_more_upload: function(classNmae, url, i, edit)
    {
      var tr = 0;
      var x = 1;
      var max = 8;
      var $preview = $("#preview"+i);

      var clear = $preview.find('tbody').find('.clear');

      if(clear.length > 0)
      {
        $preview.find('tbody').html('');
      }

      var edit_clear = $preview.find('tbody').find('tr');

      if(edit_clear.length > 0)
      {
        max = 8 - parseInt(edit_clear.length);
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
            $.custom_preview($preview, x, 2);
            x++;

            data.submit();
          }
        },
        done: function (e, data)
        {
          var data = data.result;

          if((data.status == 0) && (tr < 8))
          {
            var path = data.message;

            $.custom_success($preview, path, classNmae, tr, 2);
            tr++;
          }
          else
          {
            $.custom_error($preview, tr, 2);
            tr++;
          }
        },
        messages:
        {
          acceptFileTypes: '图片类型不合法（只接受：jpeg、png）',
          maxFileSize: '图片大小超过限制,最大不应大于1M'
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
            $.custom_preview($preview, 1, 1);

            data.submit();
          }
        },
        done: function (e, data)
        {
          var data = data.result;

          if(data.error == 0)
          {
            var path = data.data;
            path1 = path[0]['mp4_1'];
            path2 = path[0]['mp4_2'];

            if(('' == path2) || ('undefined' == path2) || (!path2))
            {
              video = path1;
            }
            else
            {
              video = path2;
            }

            $.custom_success($preview, video, classNmae, 0, 3);
          }
          else
          {
            $.custom_error($preview, 0, 1);
          }
        },
        messages:
        {
          acceptFileTypes: '视频类型不合法（只接受：MP4）',
        }
      });
    },


    // 自定义预览
    custom_preview: function(handle, x, y)
    {
      var clear = handle.find('tbody').find('.clear');

      if(clear.length > 0)
      {
        handle.find('tbody').html('');
      }

      var tr = handle.find('tbody').find('tr');
      if(tr.length > 0)
      {
        if(1 == y)
        {
          var $el = $('<tr>\
                        <td class="text-center">'+(x)+'</td>\
                        <td style="padding:7px 15px 0;height:30px;"></td>\
                        <td>上传中...</td>\
                        <td></td>\
                      </tr>');
        }
        else
        {
          var $el = $('<tr>\
                        <td class="text-center">'+(x)+'</td>\
                        <td style="padding:7px 15px 0;height:30px;"></td>\
                        <td>上传中...</td>\
                        <td class="cover"></td>\
                        <td></td>\
                      </tr>');
        }
        handle.find('tbody').append($el);
      }
      else
      {
        if(1 == y)
        {
          var $el = $('<tr>\
                        <td class="text-center">'+(x)+'</td>\
                        <td style="padding:7px 15px 0;height:30px;"></td>\
                        <td>上传中...</td>\
                        <td></td>\
                      </tr>');
        }
        else
        {
          var $el = $('<tr>\
                        <td class="text-center">'+(x)+'</td>\
                        <td style="padding:7px 15px 0;height:30px;"></td>\
                        <td>上传中...</td>\
                        <td class="cover"></td>\
                        <td></td>\
                      </tr>');
        }

        handle.find('tbody').append($el);
      }
    },

    // 自定义成功
    custom_success: function(handle, url, classNmae, tr, x)
    {
      if(3 == x)
      {
        handle.find('tbody').find('tr:eq('+tr+')').find('td:eq(1)').html("<a href='"+url+"' target='_black'>查看详情</a>");
      }
      else
      {
        handle.find('tbody').find('tr:eq('+tr+')').find('td:eq(1)').html("<a href='"+url+"' target='_black'><img src='"+url+"' style='width:30px;'/></a>");
      }


      handle.find('tbody').find('tr:eq('+tr+')').find('td:eq(2)').html('<span class="text-success">成功</span>');

      if((1 == x) || (3 ==x))
      {
        handle.find('tbody').find('tr:eq('+tr+')').find('td:eq(3)').html('<a href="javascript:;" onclick="$.custom_remove(this);"><span>删除</span></a>');

        handle.find('tbody').find('tr:eq('+tr+')').find('td:eq(3)').append("<input name='"+classNmae+"' type='hidden' value='"+url+"'/>");
      }
      else
      {
        handle.find('tbody').find('tr:eq('+tr+')').find('td:eq(3)').html('<a href="javascript:;" onclick="$.custom_cover(this,\''+url+'\');"><span>设置轮播图首页</span></a>');

        handle.find('tbody').find('tr:eq('+tr+')').find('td:eq(4)').html('<a href="javascript:;" onclick="$.custom_remove(this);"><span>删除</span></a>');

        handle.find('tbody').find('tr:eq('+tr+')').find('td:eq(4)').append("<input name='"+classNmae+"' type='hidden' value='"+url+"'/>");
      }

    },

    // 自定义错误
    custom_error: function(handle, tr, x)
    {
      handle.find('tbody').find('tr:eq('+tr+')').find('td:eq(2)').html('<span class="text-success">失败</span>');

      if(1 == x)
      {
        handle.find('tbody').find('tr:eq('+tr+')').find('td:eq(3)').html('<a href="javascript:;" onclick="$.custom_remove(this);"><span>删除</span></a>');
      }
      else
      {
        handle.find('tbody').find('tr:eq('+tr+')').find('td:eq(4)').html('<a href="javascript:;" onclick="$.custom_remove(this);"><span>删除</span></a>');
      }

    },

    custom_cover: function(self, pid)
    {
      // 如果当前已选择封面
      var flag = $(self).parent().find('input').val();

      if(flag)
      {
        $('.cover  span').removeClass('text-success');
        $(self).parent().find('input').val('');
        console.log(flag);
      }
      else
      {
        $('.cover  span').removeClass('text-success');
        $('.cover  input[name="cover_img_detail"]').remove();

        if($(self).find('span').hasClass('text-success'))
        {
          $(self).find('span').removeClass('text-success');
        }
        else
        {
          $(self).find('span').addClass('text-success');
          $(self).parent().append('<input name="cover_img_detail" type="hidden" value="'+pid+'"/>');
        }
      }
    },


    // 自定义删除
    custom_remove: function(self)
    {
      $(self).parent().parent().remove();
    }
  });
})(jQuery);
