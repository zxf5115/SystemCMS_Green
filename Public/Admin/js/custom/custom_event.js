/**
 * 自定义事件
 * @authors Zhang XiaoFei (1326336909@qq.com)
 * @date    2015-07-29 16:19:56
 * @version 0.1
 */

(function()
{
  // 1 var n = $(this).add(3,2);
  // 2 alert(n); //5
  // 3 var m = $(this).dev(3,2);
  // 4 alert(m);//1

  $.fn.ltrim = function(options)
  {
    return (options||"").replace("/^\s+g","");
  }

  $.fn.rtrim = function(options)
  {
    return (options||"").replace("/\s+$/g","");
  }
})(jQuery);



