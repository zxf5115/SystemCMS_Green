/*
 * 文 件 名: select2-easyPlugin.java
 * 版 权: Copyright 2012-2013, All rights reserved
 * 描 述: <描述>
 * 创 建 人:王骁然   wangxiaoran@itany.com
 * 创建时间: 13-12-11 下午5:04
 * 简化的select2 使用必须先引入select2.js
 */


$.fn.select2Remote = function(options)
{
  var opts = $.extend({},$.fn.select2Remote.defaults, options);
  this.select2(
  {
    allowClear:true,
    placeholder: opts.blankMsg,
    minimumInputLength:opts.minLength,
    id: function (e) { return e == undefined ? null : e.id; },
    // id:function(obj){return obj[opts.valueField]},
    ajax: function()
    {
      url: opts.url,
      dataType: 'json',
      quietMillis: opts.delay ,
      data: function (term, page) {return {q: term};},
      results: function (data, page) { return {results: data};}
    },
    initSelection: function(element, callback)
    {
      var id=$(element).val();
      if (id!=="")
      {
        $.ajax(opts.initUrl,
        {
          data:
          {
            q:id
          },
          dataType: "json"
        }).done(function(data) { callback(data); });
      }
    },
    formatResult: function(obj){return obj[opts.textField]},
    formatSelection:function(obj){return obj[opts.textField]},
    dropdownCssClass: "bigdrop",
    escapeMarkup: function (m) { return m; }
  });
}

$.fn.select2Remote.defaults = {
  blankMsg: "请输入",
  minLength: 2,
  url:'',
  initUrl:'',
  delay:1000,
  valueField:'id',
  textField:'text'
}
