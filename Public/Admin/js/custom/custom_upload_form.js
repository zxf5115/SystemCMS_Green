/**
 * 上传图片自定义控件

 * @author Zhang Xiaofei (1326336909@qq.com)
 * @date    2015-07-29 14:33:17
 * @version 0.1
 */

(function($)
{
  $.fn.customUpload = function(url, arr)
  {
    return this.each(function()
    {

      $('<div id="data" class="m-t-4"></div>').insertAfter($(this));
      $('<div id="preview" class="form-group m-t-4" style="display:none;"></div>').insertAfter($(this));
      $('<div id="progress" class="m-t-4"></div>').insertAfter($(this));

      custom_preview_file();

      custom_default_data(arr);

      // 点击button时打开分类选择窗体
      $(this).bind("click", function()
      {
        custom_clear_data();
        custom_upload_file(url);
      });
    });


    // 自定义上传文件
    function custom_upload_file(url)
    {
      //初始化，主要是设置上传参数，以及事件处理方法(回调函数)
      $('#upload').fileupload(
      {
        autoUpload: true,       //是否自动上传 [是]
        url: url,               //上传地址
        // data: { 'AppId': '123583172', 'AppKey': '35c9fd4446bcfaf8b86b414d9cb8b466'},
        dataType: 'json',       //
        maxFileSize: 5000000 ,  //文件大小限制 [5M]
        progressall: function (e, data)
        {
          var progress = parseInt(data.loaded / data.total * 100, 10);

          $('.progress-bar-success').css('width',progress + '%');
          $('.progress-bar-success').text(progress + '%');
        },
        add: function (e, data)
        {
          custom_upload_progress();
          data.submit();
        },
        done: function (e, data)
        {
          var data = data.result;

          if(data.status == 1)
          {
            custom_preview_data(data.data);
            custom_from_data(data.id);
          }
        }
      });
    }


    // 自定义上传进度
    function custom_upload_progress()
    {
      $('#progress').append('<div class="row">'+
          '<div class="col-md-8">'+
            '<div class="progress">'+
            '<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100">'+
            '</div>'+
            '</div>'+
          '</div>'+
          '<div class="col-md-4">'+
            '<button type="button" class="btn btn-default btn-xs" onclick="custom_upload_delete();">删除</button>'+
          '</div>'+
        '</div>'
      );
    }


    // 自定义预览文件
    function custom_preview_file()
    {
      $('#preview').append('<div id="carousel-example-generic" class="carousel slide" data-ride="carousel"></div>');
      $('#preview').children().append('<div id="preview2" class="carousel-inner" role="listbox"></div>');
      $('#preview').children().append('<a class="carousel-control" href="#carousel-example-generic" role="button" data-slide="prev"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span><span class="sr-only">上一张</span></a><a class="carousel-control" style="left:auto;right:0;" href="#carousel-example-generic" role="button" data-slide="next"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span><span class="sr-only">下一张</span></a>');
    }
  };
})(jQuery);


// 加载预览数据
function custom_preview_data(url)
{
  $('#preview').removeAttr('style');

  $('#preview2').append('<div class="item"><img src="'+url+'" class="img-thumbnail" style="margin: 0 auto;max-height:350px"></div>');

  $('#preview2').children('div:first').addClass('active');
}


// 加载表单数据
function custom_from_data(url)
{
  $('#data').append('<input type="hidden" name="file[]" value="' + url + '"/>');
}


// 加载默认数据
function custom_default_data(arr)
{
  if(arr != 0)
  {
    for(var i in arr)
    {
      custom_preview_data(arr[i]['url']);
      custom_from_data(arr[i]['rid']);
    }
  }
}


function custom_clear_data()
{
  $('#data input').remove();
  $('#preview2 .item').remove();
}

// 自定义上传删除
function custom_upload_delete()
{
  $("#progress .row").click(function()
  {
    var index = $(this).index();

    $("#progress .row").eq(index).remove();
    $('#data input').eq(index).remove();
    $('#preview2 .item').eq(index).remove();
  });
}
