<?php if (!defined('THINK_PATH')) exit();?><link href="/Public/Static/ueditormini/themes/default/css/umeditor.min.css" type="text/css" rel="stylesheet">

<script type="text/javascript" charset="utf-8" src="/Public/Static/ueditormini/js/umeditor.config.js"></script>

<script type="text/javascript" charset="utf-8" src="/Public/Static/ueditormini/js/umeditor.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/Static/ueditormini/js/lang/zh-cn/zh-cn.js"></script>
<script type="text/plain" name="<?php echo ($name); ?>" id="<?php echo ($id); ?>" style="width:<?php echo ($width); ?>;height:<?php echo ($height); ?>;"><?php echo ($default); ?></script>




<?php if($config == ''): ?><script>
    $(function()
    {
      var url = '<?php echo ($url); ?>';
      var um = UM.getEditor('<?php echo ($id); ?>',{toolbar:[
        'source | bold italic underline | forecolor backcolor | ',
        'insertorderedlist | fontsize' ,
        '| justifyleft justifycenter justifyright justifyjustify |',
        'link emotion image video  | map'],
        imageUrl: url,
        imagePath: "",
        imageFieldName: "upfile",
        imageMaxSize: 2048,
        imageAllowFiles: [".png", ".jpg", ".jpeg", ".gif"],
        mergeEmptyline: true, //合并空行
        removeClass: true, //去掉冗余的class
        removeEmptyline: false, //去掉空行
        textAlign: "left", //段落的排版方式，可以是 left，right，center，justify 去掉这个属性表示不执行排版
        imageBlockLine: 'center', //图片的浮动方式，独占一行剧中，左右浮动，默认: center，left，right，none 去掉这个属性表示不执行排版
        pasteFilter: false, //根据规则过滤没事粘贴进来的内容
        clearFontSize: false, //去掉所有的内嵌字号，使用编辑器默认的字号
        clearFontFamily: false, //去掉所有的内嵌字体，使用编辑器默认的字体
        removeEmptyNode: false, // 去掉空节点
        indent: true, // 行首缩进
        indentValue: '2em', //行首缩进的大小
        bdc2sb: false,
        tobdc: false
        });

    })
  </script>
<?php else: ?>
  <script>
    $(function()
    {
      var config='{<?php echo ($config); ?>}';
      var um = UM.getEditor('<?php echo ($id); ?>',config);
    })
  </script><?php endif; ?>