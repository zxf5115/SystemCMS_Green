<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!--[if lt IE 7 ]>
<html class="ie ie6" lang="en">
<![endif]-->
<!--[if IE 7 ]>
<html class="ie ie7" lang="en">
<![endif]-->
<!--[if IE 8 ]>
<html class="ie ie8" lang="en">
<![endif]-->
<!--[if (gte IE 9)|!(IE)]>
<html class="not-ie" lang="en">
<![endif]-->
<head>
  <meta charset="utf-8">
<title><?php echo ($meta_title); ?>|<?php echo C('WEB_SITE_TITLE');?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<!--[if (gte IE 9)|!(IE)]>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<![endif]-->

<!-- Favicon -->
<link href="./img/favicon.png" rel="icon" type="image/png"/>

<!-- Styles -->
<link href="/Public/Home/css/styles.css" rel="stylesheet"/>
<link href="/Public/Home/css/bootstrap-override.css" rel="stylesheet"/>

<!-- Font Avesome Styles -->
<link href="/Public/Home/css/font-awesome.css" rel="stylesheet"/>
<!--[if IE 7]>
  <link href="./css/font-awesome-ie7.min.css"/>
<![endif]-->

<!-- FlexSlider Style -->
<link rel="stylesheet" href="/Public/Home/css/flexslider.css" type="text/css" media="screen"/>

<!-- Web Fonts -->
<link href="/Public/Home/css/css-family=Open+Sans-300,400,600,700,800.css" rel="stylesheet" type="text/css"/>

<!-- Internet Explorer condition - HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
  <script src="/Public/Home/js/html5.js"></script>
<![endif]-->

<!-- 弹出提示框，ajax用 css -->
<link rel="stylesheet" href="/Public/static/messenger/messenger.css">
<link rel="stylesheet" href="/Public/static/messenger/messenger-theme-block.css">

<script type="text/javascript" src="/Public/static/jquery-1.7.2.min.js" ></script>

<!-- Custom styles for this template -->

<!-- 用于加载 css 代码 -->

</head>
<body>
    <div class="space30"></div>
  <div class="content">
    <div class="container site">
      <div class="row">
        <div class="span12">
          <div class="row">
            <div class="span12 logo">
              <a href="index.html">
                <img src="/Public/Home/images/logo.png" alt="">
              </a>
              <div class="slogan">追求卓越, 成就梦想</div>
            </div>
          </div>
          <div class="row">
            <div class="space10"></div>
          </div>
          <div class="row">
            <div class="span12">
              <nav class="navbar">
                <ul class="nav">
                  <?php if(is_array($channel)): $i = 0; $__LIST__ = $channel;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo["url"] != 'null'): ?><li class="<?php echo ($vo["active"]); ?>"><a href="<?php echo (U($vo["url"])); ?>"><?php echo ($vo["title"]); ?></a></li>
                    <?php else: ?>
                      <li class="<?php echo ($vo["active"]); ?>">
                        <a href="javascript:;"><?php echo ($vo["title"]); ?></a>
                        <ul>
                          <?php if(is_array($vo["child"])): $i = 0; $__LIST__ = $vo["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voo): $mod = ($i % 2 );++$i;?><li><a href="<?php echo (U($voo["url"])); ?>"><?php echo ($voo["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                      </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </ul>
              </nav>
            </div>
          </div>
          <div class="row space10"></div>


  
  <div class="row">
    <div class="span9">
      <h1><?php echo ($meta_title); ?></h1>
    </div>
    <div class="span3">
      <div class="actual-section">
        <a href="<?php echo U('Index/index');?>" >首页</a> > <?php echo ($meta_title); ?>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="span9">
      <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="note">
	      	<?php if($vo['picture'] != ''): ?><a href="<?php echo U('Note/detail', array('id'=>$vo['id']));?>">
		          <img src="<?php echo ($vo["picture"]); ?>" class="picture">
		        </a><?php endif; ?>
	        <!-- Space -->
	        <div class="row space30"></div>

	        <div class="row">
	          <div class="span2">
	            <div class="blog-icon-container hidden-phone">
	              <div class="blog-icon">
	                <i class="fa fa-<?php echo ($vo["icon"]); ?>"></i>
	              </div>
	            </div>
	            <div class="blog-date"><?php echo (friendlyDateChineseStyle($vo["create_time"])); ?></div>

	          </div>
	          <div class="span7 post-d-info">
	            <a href="<?php echo U('Note/detail', array('id'=>$vo['id']));?>">
	            	<h2><?php echo ($vo["title"]); ?></h2>
	            </a>
	            <i class="fa fa-user-circle-o"></i> <?php echo ($vo["founder"]); ?>
	            <i class="fa fa-tags"></i> <?php echo ($vo["label"]); ?>
	            <i class="fa fa-list"></i> <?php echo ($vo["category"]); ?>
	            <p><?php echo ($vo["content"]); ?></p>
	            <a href="<?php echo U('Note/detail', array('id'=>$vo['id']));?>"></i> 查看更多</a>
	            <div class="row space5"></div>
	          </div>
	        </div>
	        <hr />
	      </div><?php endforeach; endif; else: echo "" ;endif; ?>

      <div class="row space300"></div>

      <!-- Paging -->
      <div class="row">
        <div class="span9">
		      <div class="pagination">
		        <ul>
		          <?php if($list != ""): echo ($page); endif; ?>
		        </ul>
		      </div>
        </div>
      </div>
    </div>

    <div class="span3">
      <h2>搜索</h2>
      <div class="search-box">
        <a href="javascript:;" class="search-icon"><i class="fa fa-search"></i></a>
        <input class="search" name="search" placeholder="请输入内容" >
      </div>

      <div class="row space30"></div>
      <h2>分类</h2>
      <ul class="list-c">
      	<?php if(is_array($category)): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
	        	<i class="fa fa-chevron-right"></i>
	        	<a class="<?php echo ($set['cid'] == $vo['id'] ? 'active' : ''); ?>" href="<?php echo U('Note/index', array('cid'=>$vo['id']));?>"><?php echo ($vo["title"]); ?></a>
        	</li><?php endforeach; endif; else: echo "" ;endif; ?>
      </ul>

      <div class="row space30"></div>
      <h2>标签</h2>
      <div class="list-t">
	      <?php if(is_array($label)): $i = 0; $__LIST__ = $label;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Note/index', array('lid'=>$vo['id']));?>">
	      		<div class="tag <?php echo ($set['lid'] == $vo['id'] ? 'active' : ''); ?>"><?php echo ($vo["title"]); ?></div>
	      	</a><?php endforeach; endif; else: echo "" ;endif; ?>
      </div>
      <div class="row space30"></div>
    </div>
  </div>



          </div>
      </div>
    </div>
    <div id="footer" class="container">
      <div class="row">
        <div class="span7 copyright">
          <a href="<?php echo U('Index/index');?>"><?php echo C('WEB_SITE_ICP');?></a>
        </div>
        <div class="span4 copyright right">
          <a href="#">注意事项</a> | <a href="#">服务条款</a>
        </div>
        <div class="span1">
          <a id="back-to-the-top">
            <div class="back-top"></div>
          </a>
        </div>
      </div>
    </div>
    <div class="space30"></div>
  </div>



  <!-- JavaScripts -->
<script type="text/javascript" src="/Public/static/bootstrap/bootstrap.min.js" ></script>
<script type="text/javascript" src="/Public/Home/js/functions.js" ></script>
<script type="text/javascript" src="/Public/Home/js/jquery.isotope.min.js" ></script>
<script type="text/javascript" defer src="/Public/Home/js/jquery.flexslider.js" ></script>

<script src="/Public/static/messenger/messenger.min.js"></script>
<script src="/Public/static/js/custom_message.js"></script>
<script src="/Public/static/js/custom_ajax.js"></script>


	<script type="text/javascript">
		$('document').ready(function()
		{
			$('input[name="search"]').val("<?php echo ($set['search']); ?>");

			$('.fa-search').bind('click', function()
			{
				var search = $("input[class='search']").val();

				if(search)
				{
					window.location.href="<?php echo U('Note/index');?>/search/"+search;
				}
				else
				{
					window.location.href="<?php echo U('Note/index');?>";
				}

			});
		});
	</script>


</body>
</html>