/*常量*/
var init =
{
  datatable :
  {
    //DataTables初始化选项
    option :
    {
      // 分页样式
      "sPaginationType" : "full_numbers",

      // 当处理大数据时，延迟渲染数据，有效提高Datatables处理能力
      "deferRender": true,

      // 是否打开客户端状态记录功能。这个数据是记录在cookies中的，打开了这个记录后，即使刷新一次页面，或重新打开浏览器，之前的状态都是保存下来的
      'bStateSave': true,

      // 当datatable获取数据时候是否显示正在处理提示信息。
      "bProcessing": false,

      // 客户端处理分页
      "bServerSide": true,

      // 当处理大数据时，延迟渲染数据，有效提高Datatables处理能力
      "deferRender": true,

      "bSort": true,

      "aaSorting": [[ 0, "DESC" ]],



      // "columnDefs":[{
      //             "orderable":false,//禁用排序
      //             "targets":[1,7]   //指定的列
      //             }],
    },

    //复选框单元格
    checkbox :
    {
      "mDataProp": "id",
      "fnCreatedCell": function (nTd, sData, oData, iRow, iCol)
      {
        $(nTd).html("<input type='checkbox' class='ids cbr' type='checkbox' name='id[]' value='" + sData + "'>");
      }
    },
  }
};
