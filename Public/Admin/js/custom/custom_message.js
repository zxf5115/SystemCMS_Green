/**
 *
 * @authors Zhang xiaoFei (1326336909@qq.com)
 * @date    2015-09-18 15:38:56
 * @version 1.0
 */

//updateConfirm  对话框，主程序 需要回调函数执行确认后的操作
//和原生的 confirm  不同的地方是，不会有 true  flase 返回值
window.updateConfirm = function(message, callback)
{
  message = message||'确认要执行该操作吗?';
  msg = Messenger().post(
  {
    message: message ,
    showCloseButton : true ,
    type: 'info' ,
    theme: 'block',
    id : 'updateAlert' ,
    actions:
    {
      confirm:
      {
        label: '   确定  ',
        action: function()
        {
          // 方法回调
          callback(true);
          msg.hide();
          return false ;
        }
      },
      cancel:
      {
        label: '   取消    ',
        action: function()
        {
          return msg.cancel();
        }
      }
    }
  });
};


//updateAlert 提示信息显示条，可以替代系统的 alert ,样式主题和位置由 Messenger.options 定义
window.updateAlert =function(message,type)
{
  message = message||'出错了';
  type = type||'error';

  Messenger().post(
  {
    message: message ,
    type: type ,
    theme: 'block',
    showCloseButton: true ,
    id: 'updateAlert'
  });
};
