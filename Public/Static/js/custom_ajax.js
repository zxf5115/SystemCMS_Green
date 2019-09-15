/**
 *
 * @authors Zhang xiaoFei (1326336909@qq.com)
 * @date    2015-09-18 15:38:56
 * @version 1.0
 */

////////////////////////////////////////////////////
// ajaxQuery  函数
//执行ajax  请求操作 ,
//参数为:
//elem 发起ajax请求的页面元素
// url  请求服务端 url 地址 ,
//method 请求的的方式，GET 操作还是 POST 操作
//
//执行的操作有:
// 如果url 地址为空 ,返回
//如果url 地址错误 ,调用ajax失败，返回  ajax执行失败
//如果url 正确 ,调用ajax成功，由  updateAlert 返回提示信息
//如果data为空，则执行get操作
//如果elem不为空，则页面重载或者设为可用
//no_refresh 如果为真值，不执行页面重载。默认为 false ,在更新完数据后，重载本页，保持前后台数据一致
//服务端返回的 json 格式为，必须包含 status项    { "status":1,"info": "服务端返回的提示信息","url": "jumpUrl" }
// jumpUrl 为跳转地址，例如  Admin/Index/index.html
/////////////////////////////////////////////////////////////
window.ajaxQuery = function( elem , url , method  , data )
{
  url = url||false ;
  data = data||'' ;
  no_refresh = $(elem).hasClass('no-refresh') ||false ;

  if(url == false)
  {
    //将提交按钮设置为可用状态
    $(elem).removeClass('disabled').prop('disabled',false);

    //url地址为空时返回
    return false ;
  }

  if( method != 'GET' || method != 'get' )
  {
    //默认用POST  避免数据缓存的问题
    method = 'POST' ;
  }

  $.ajax(
  {
    url      :  url ,
    type     :  method ,
    dataType :  'json' ,
    data     :  data  ,
    success  : function(data)
    {
      if (data.status==1)
      {
        if(data.url)
        {
            updateAlert(data.info, 'success');
        }
        else
        {
            updateAlert(data.info,'success');
        }

        setTimeout(function()
        {
          if(data.url)
          {
            location.href=data.url;
          }
          else if( no_refresh )
          {
            $(elem).removeClass('disabled').prop('disabled',false);
          }
          else
          {
            location.reload();
          }
        },1500);
      }
      else
      {
        updateAlert(data.info,'error');

        setTimeout(function()
        {
          if(data.url)
          {
            location.href=data.url;
          }
          else
          {
            $(elem).removeClass('disabled').prop('disabled',false);
          }
        },1500);
      }
    },
    error : function(textStatus, errorThrown)
    {
      updateAlert('执行ajax操作失败，请检查 URL 地址'+url,'warning');
      console.log(textStatus);
      console.log(errorThrown);
      console.log(url);
      $(elem).removeClass('disabled').prop('disabled',false);
    }
  });
};



$('.ajax-get').click(function()
{
  var target;
  var that = this;
  if ( (target = $(this).attr('href')) || (target = $(this).attr('url')) )
  {
    if ( $(this).hasClass('confirm') )
    {
      updateConfirm('确认要执行该操作吗?', function(opts)
      {
        //需要确认,才执行的ajax-post
        $(that).addClass('disabled').attr('autocomplete','off').prop('disabled',true);
        ajaxQuery( that, target ,'POST' );      //为了避免数据缓存造成的不一致性，可以统一改用POST
        //ajax-post结束点
      });
    }
    else
    {
      //不需要确认就可以执行的ajax-post
      $(that).addClass('disabled').attr('autocomplete','off').prop('disabled',true);
      ajaxQuery( that, target ,'POST' );    //为了避免数据缓存造成的不一致性，可以统一改用POST
      //ajax-post结束点
    }
  }
  return false;
});




/**
 * 不刷新页面操作
 *
 * 点击  ajax-post 操作
 */
$('.ajax-post').click(function()
{
  //初始值
  var target, query, form;

  var target_form = $(this).attr('target-form');
  var that = this;
  var nead_confirm=false;

  if(($(this).attr('type') == 'submit') || (target = $(this).attr('href')) || (target = $(this).attr('url')))
  {
    form = $('.'+target_form);

    //无数据时也可以使用的功能
    if($(this).attr('hide-data') === 'true')
    {
      form = $('.hide-data');
      query = form.serialize();
    }
    else if(form.get(0) == undefined)
    {
      return false;
    }
    else if(form.get(0).nodeName == 'FORM')
    {
      if($(this).attr('url') !== undefined)
      {
        target = $(this).attr('url');
      }
      else
      {
        target = form.get(0).action;
      }

      query = form.serialize();
    }
    else if(form.get(0).nodeName=='INPUT' || form.get(0).nodeName=='SELECT' || form.get(0).nodeName=='TEXTAREA')
    {
      form.each(function(k, v)
      {
        if(v.type=='checkbox' && v.checked==true)
        {
            nead_confirm = true;
        }
      })
      query = form.serialize();
    }
    else
    {
      query = form.find('input,select,textarea').serialize();
    }

    if (nead_confirm && $(this).hasClass('confirm'))
    {
      updateConfirm('确认要执行该操作吗?', function(opts)
      {
        //需要确认,才执行的ajax-post
        $(that).addClass('disabled').attr('autocomplete','off').prop('disabled',true);
        ajaxQuery( that, target ,'POST', query );
        //ajax-post结束点
      });
    }
    else
    {
      //不需要确认就可以执行的ajax-post
      $(that).addClass('disabled').attr('autocomplete','off').prop('disabled',true);
      ajaxQuery( that, target ,'POST', query );
      //ajax-post结束点
    }
  }
  return false;
});
