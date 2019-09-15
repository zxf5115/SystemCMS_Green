;(function($)
{
  $.extend(
  {

    /**
     * ---------------------------------------------------------------------------------
     * @filename
     *     @chinese: 图文混排上传插件
     *     @english: custom_picture_text.php
     *
     * classNmae  数据提交字段名称
     * url  上传地址
     * edit  是否是编辑
     * i  是否多个插件
     *
     * @version: 1.0
     * @desc   : 主要用于图文混排上传
     *
     * @author : Zhang XiaoFei (1326336909@qq.com)
     * @date   : 2015-05-15 14:42:11
     */
    custom_picture_text: function(classNmae, url, edit, i)
    {
      // 点击button时打开分类选择窗体
      $('#picture_text_upload'+i).bind("click", function()
      {
        $.custom_multi_upload(classNmae, url, i, edit);
      });
    },

    custom_multi_upload: function(classNmae, url, i, edit)
    {
      var max = 20;
      var tr = 0;
      var x = 1;
      var $preview = $("#picture_text_preview"+i);

      var clear = $preview.find('tbody').find('.picture_text_clear');

      if(clear.length > 0)
      {
        $preview.find('tbody').html('');
      }

      var edit_clear = $preview.find('tbody').find('tr');

      if(edit_clear.length > 0)
      {
        max = 20 - parseInt(edit_clear.length);
        x = 1 + parseInt(edit_clear.length);
        tr = parseInt(edit_clear.length);
      }

      $('#picture_text_upload'+i).fileupload(
      {
        autoUpload: true,       //是否自动上传 [是]
        url: url,               //上传地址
        dataType: 'json',       //
        acceptFileTypes: /(\.|\/)(jpe?g|png)$/i,
        maxFileSize: 1000000, //文件大小限制 [1M]
        maxNumberOfFiles : max,   //文件数量限制
        processalways: function (e, data)
        {
          $.custom_multi_preview($preview, x);
          x++;

          data.submit();
        },
        done: function (e, data)
        {
          var data = data.result;

          if((data.status == 1) && (tr < 20))
          {
            var path = data.path;

            $.custom_multi_success($preview, path, classNmae, tr, 1);
            tr++;
          }
          else
          {
            $.custom_multi_error($preview, tr);
            tr++;
          }
        },
        messages:
        {
          acceptFileTypes: '图片格式错误，请重新选择文件',
          maxNumberOfFiles: '图片最多上传20张',
          maxFileSize: '图片大于1兆，请重新选择文件'
        }
      });
    },



    // 自定义预览
    custom_multi_preview: function(handle, x)
    {
      var clear = handle.find('tbody').find('.picture_text_clear');

      if(clear.length > 0)
      {
        handle.find('tbody').html('');
      }

      var tr = handle.find('tbody').find('tr');

      var $el = $('<tr>\
                    <td class="text-center">'+(x)+'</td>\
                    <td style="padding:7px 15px 0;height:30px;"></td>\
                    <td>上传中...</td>\
                    <td></td>\
                  </tr>');

      handle.find('tbody').append($el);
    },

    // 自定义成功
    custom_multi_success: function(handle, url, classNmae, tr, x)
    {
      handle.find('tbody').find('tr:eq('+tr+')').find('td:eq(1)').html("<a href='"+url+"' target='_black'><img src='"+url+"' style='width:30px;'/></a>");

      handle.find('tbody').find('tr:eq('+tr+')').find('td:eq(2)').html('<span class="text-success">成功</span>');

      handle.find('tbody').find('tr:eq('+tr+')').find('td:eq(3)').html('<a href="javascript:;" onclick="$.custom_multi_insert(this);"><span>插入</span></a> ');

      handle.find('tbody').find('tr:eq('+tr+')').find('td:eq(3)').append('<a href="javascript:;" onclick="$.custom_multi_remove(this);"><span>删除</span></a>');

      handle.find('tbody').find('tr:eq('+tr+')').find('td:eq(3)').append("<input name='"+classNmae+"' type='hidden' value='"+url+"'/>");
    },

    // 自定义错误
    custom_multi_error: function(handle, tr)
    {
      handle.find('tbody').find('tr:eq('+tr+')').find('td:eq(2)').html('<span class="text-success">失败</span>');


      handle.find('tbody').find('tr:eq('+tr+')').find('td:eq(3)').html('<a href="javascript:;" onclick="$.custom_remove(this);"><span>删除</span></a>');
    },

    // 自定义插入
    custom_multi_insert: function(self)
    {
      var url = $(self).parent().find('input').val();
      var str = '[$*$]'+url+'[$*$]';

      var picture_text = document.getElementById('picture_text');

      if(document.selection)
      {
        picture_text.focus();
        sel = document.selection.createRange();
        sel.text = str;
        sel.select();
      }
      else if (picture_text.selectionStart || picture_text.selectionStart == '0')
      {
        var startPos       = picture_text.selectionStart;
        var endPos         = picture_text.selectionEnd;

        var restoreTop     = picture_text.scrollTop;
        picture_text.value = picture_text.value.substring(0, startPos) + str + picture_text.value.substring(endPos, picture_text.value.length);

        if(restoreTop > 0)
        {
          picture_text.scrollTop = restoreTop;
        }

        picture_text.focus();
        picture_text.selectionStart = startPos + str.length;
        picture_text.selectionEnd   = startPos + str.length;
      }
      else
      {
        picture_text.value += str;
        picture_text.focus();
      }

    },


    // 自定义删除
    custom_multi_remove: function(self)
    {
      $(self).parent().parent().remove();
    }
  });

})(jQuery);




