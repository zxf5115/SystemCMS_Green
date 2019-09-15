//dom加载完成后执行的js
$(document).ready(function()
{
  //新增按钮  点击事件，跳转到 url 地址
  $(".btn-add").click(function()
  {
    location.href = $(this).attr('url');
  });

  custom_check_all("#dataTables");
});


/* --------------------------------------------------------------------------------------
 * 自定义CheckBox选择函数
 *
 * @param  String   classid   容器ID或者类ID
 */
function custom_check_all(classid)
{
  var $state = $(classid+" thead input[type='checkbox']");

  $(classid).on('draw.dt', function()
  {
    // cbr_replace();

    $state.trigger('change');
  });

  // Script to select all checkboxes
  $state.on('change', function(ev)
  {
    var $chcks = $(classid+" tbody input[type='checkbox']");

    if($state.is(':checked'))
    {
      $chcks.prop('checked', true).trigger('change');
    }
    else
    {
      $chcks.prop('checked', false).trigger('change');
    }
  });
}


/* --------------------------------------------------------------------------------------
 * 自定义操作函数
 *
 * TODO: Datatables中使用，待整合完成后，删除
 *
 * @param  String   classid   容器ID或者类ID
 */
function custom_opertion(id, iRow)
{
  var target;
  var that = '.custom_'+id+iRow;

  if((target = $(that).attr('href')) || (target = $(that).attr('url')))
  {
    if( $(that).hasClass('confirm'))
    {
      updateConfirm('确认要执行该操作吗?(ajax-get)', function(opts)
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
}
