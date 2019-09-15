/**
 *
 * @authors Zhang xiaoFei (1326336909@qq.com)
 * @date    2015-09-18 15:38:56
 * @version 1.0
 */

function setUpload(url, type, x, name, info, res)
{
  var i = 1,
  $example_dropzone_filetable = $("#example-dropzone-filetable"+x),
  example_dropzone = $("#advancedDropzone"+x).dropzone(
  {
    //指定处理上传图片的路径
    url: url,
    withCredentials: 0,
    params: {"token": res[0], "clientid": res[1]},

    //指明允许上传的文件类型，格式是逗号分隔的 MIME type 或者扩展名。例如：image/*,application/pdf,.psd,.obj
    acceptedFiles: type,

    //每次上传的最多文件数
    maxFiles: 1,

    addedfile: function(file)
    {
      if(i == 1)
      {
        $example_dropzone_filetable.find('tbody').html('');
      }

      var $el = $('<tr>\
                    <td class="text-center">'+(i++)+'</td>\
                    <td></td>\
                    <td>上传中...</td>\
                    <td></td>\
                  </tr>');

      $example_dropzone_filetable.find('tbody').append($el);
      file.fileEntryTd = $el;
    },

    success: function(file, data)
    {
      file.fileEntryTd.find('td:eq(2)').html('<span class="text-success">成功</span>');
      file.fileEntryTd.find('td:eq(3)').html('<span class="text-error" onclick="getRemove(this);">删除</span>');

      if (data.status === 1)
      {
        var id = data.data.file.id;
        var path = data.data.file.path;
        file.fileEntryTd.find('td:eq(3)').append("<input name='"+name+"' type='hidden' value='"+id+"'/>");

        file.fileEntryTd.find('td:eq(1)').html("<a href='"+path+"' target='_black'>查看详情</a>");
      }
    },

    error: function(file)
    {
      file.fileEntryTd.find('td:eq(2)').html('<span class="text-danger">失败</span>');
    }
  });

  $("#advancedDropzone").css(
  {
    minHeight: 200
  });

}


function setCoverManyUpload(url, type, max, x)
{
  var i = 1,
  $example_dropzone_filetable = $("#example-dropzone-filetable"+x),
  example_dropzone = $("#advancedDropzone"+x).dropzone(
  {
    //指定处理上传图片的路径
    url: url,

    //指明允许上传的文件类型，格式是逗号分隔的 MIME type 或者扩展名。例如：image/*,application/pdf,.psd,.obj
    acceptedFiles: type,

    //每次上传的最多文件数
    maxFiles: max,

    addedfile: function(file)
    {
      if(i == 1)
      {
        $example_dropzone_filetable.find('tbody').html('');
      }

      var $el = $('<tr>\
                    <td class="text-center">'+(i++)+'</td>\
                    <td>'+file.name+'</td>\
                    <td>上传中...</td>\
                    <td class="cover"></td>\
                    <td></td>\
                  </tr>');

      $example_dropzone_filetable.find('tbody').append($el);
      file.fileEntryTd = $el;
    },

    success: function(file, data)
    {
      file.fileEntryTd.find('td:eq(2)').html('<span class="text-success">成功</span>');
      file.fileEntryTd.find('td:eq(3)').html('<span class="text-error">设置封面</span><input name="cover" type="hidden" value=""/>');
      file.fileEntryTd.find('td:eq(4)').html('<span class="text-error" onclick="getRemove(this);">删除</span>');

      if (data.status === 1)
      {
        var id = data.data.file.id;
        file.fileEntryTd.find('td:eq(4)').append("<input name='pid' type='hidden' value='"+id+"'/>");
        file.fileEntryTd.find('td:eq(3)').children("span").attr("onclick","getCover(this,'"+id+"');");
      }
    },

    error: function(file)
    {
      file.fileEntryTd.find('td:eq(2)').html('<span class="text-danger">失败</span>');
    }
  });

  $("#advancedDropzone").css(
  {
    minHeight: 200
  });

}


function getRemove(self)
{
  $(self).parent().parent().remove();
}

function getCover(self, pid)
{
  $('.cover > span').removeClass('text-success');
  $('.cover > input').val('');

  if($(self).hasClass('text-success'))
  {
    $(self).removeClass('text-success');
  }
  else
  {
    $(self).addClass('text-success');
    $(self).next().val(pid);
  }
}
