<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="<?php echo C('WEB_SITE_TITLE');?>">
<meta name="author" content="">

<!-- 网站标题 -->
<title><?php echo ($meta_title); ?>|<?php echo C('WEB_SITE_TITLE');?></title>

<!-- 网站标志 -->
<link rel="shortcut icon" href="/Public/favicon.ico">


<link rel="stylesheet" href="/Public/Admin/css/fonts/linecons/css/linecons.css">
<link rel="stylesheet" href="/Public/Static/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="/Public/Admin/css/bootstrap.css">
<link rel="stylesheet" href="/Public/Admin/css/xenon-core.css">
<link rel="stylesheet" href="/Public/Admin/css/xenon-forms.css">
<link rel="stylesheet" href="/Public/Admin/css/xenon-components.css">
<!-- <link rel="stylesheet" href="/Public/Admin/css/xenon-skins.css"> -->
<link rel="stylesheet" href="/Public/Admin/css/custom.css">

<!-- 弹出提示框，ajax用 css -->
<link rel="stylesheet" href="/Public/Static/messenger/messenger.css">
<link rel="stylesheet" href="/Public/Static/messenger/messenger-theme-block.css">
<!-- <link rel="stylesheet" href="/Public/Admin/css/custom/alert_confirm_prompt.css"> -->


<link href="/Public/Static/datetimepicker/css/datetimepicker.css" rel="stylesheet" type="text/css">
<link href="/Public/Static/datetimepicker/css/dropdown.css" rel="stylesheet" type="text/css">

<script src="/Public/Static/jquery-1.11.1.min.js"></script>

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->



  <!-- 用于加载 css 代码 -->
  <style>
    .sidebar-menu{
      width: 240px;
    }

    .px25{
      width: 30px;
    }

    .float_left{
      float: left;
    }

    .float_right{
      float: right;
    }
  </style>


<!-- 页面header钩子，一般用于加载插件CSS文件和代码 -->
<?php echo hook('pageHeader');?>

</head>
<body class="page-body">
  <!-- 头部文件 -->
    <!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
  <div class="page-container">

    <!-- Add "fixed" class to make the sidebar fixed always to the browser viewport. -->
    <!-- Adding class "toggle-others" will keep only one menu item open at a time. -->
    <!-- Adding class "collapsed" collapse sidebar root elements and show only icons. -->
    <div class="sidebar-menu toggle-others fixed">

      <div class="sidebar-menu-inner">

        <header class="logo-env">

          <!-- logo -->
          <div class="logo">
            <a href="<?php echo U('Index/index');?>" class="logo-expanded">
              <!-- <img src="/Public/Admin/images/logo@2x.png" width="80" alt="" /> -->
              <span style="color:#fff;font-size:1.5em"><?php echo C('WEB_SITE_TITLE');?></span>
            </a>

            <a href="<?php echo U('Index/index');?>" class="logo-collapsed">
              <!-- <img src="/Public/Admin/images/logo-collapsed@2x.png" width="40" alt="" /> -->
              <span style="color:#fff;font-size:1.5em"><?php echo C('WEB_SITE_TITLE_ABBR');?></span>
            </a>
          </div>

          <!-- This will toggle the mobile menu and will be visible only on mobile devices -->
          <div class="mobile-menu-toggle visible-xs">
            <a href="#" data-toggle="user-info-menu">
              <i class="fa-bell-o"></i>
              <span class="badge badge-success">7</span>
            </a>

            <a href="#" data-toggle="mobile-menu">
              <i class="fa-bars"></i>
            </a>
          </div>

        </header>

        <ul id="main-menu" class="main-menu">
          <!-- add class "multiple-expanded" to allow multiple submenus to open -->
          <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->

          <?php if(is_array($__MENU__["main"])): $i = 0; $__LIST__ = $__MENU__["main"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="<?php echo ($vo["class"]); ?>">
              <a href="<?php echo (U($vo["url"])); ?>">
                <i class="glyphicon glyphicon-cog"></i>
                <span class="title"><?php echo ($vo["title"]); ?></span>
              </a>
              <?php if(!empty($vo["child"])): ?><ul>
                  <?php if(is_array($vo["child"])): $k = 0; $__LIST__ = $vo["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$xo): $mod = ($k % 2 );++$k; if(!empty($xo)): ?><li class="">
                        <a href="javascript:;">
                          <i class="glyphicon glyphicon-plus"></i>
                          <span class="title"><?php echo ($xo["title"]); ?></span>
                        </a>
                        <ul style="<?php echo ($xo['ul-class'] ? 'display:block' : ''); ?>">
                          <?php if(is_array($xo["info"])): $i = 0; $__LIST__ = $xo["info"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$zo): $mod = ($i % 2 );++$i; if(!empty($zo['title'])): ?><li class="<?php echo ($zo["li-class"]); ?>">
                                <a href="<?php echo (U($zo["url"])); ?>">
                                  <span class="title"><?php echo ($zo["title"]); ?></span>
                                </a>
                              </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                        </ul>
                      </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </ul><?php endif; ?>
            </li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
      </div>
    </div>

    <div class="main-content">

      <!-- User Info, Notifications and Menu Bar -->
      <nav class="navbar user-info-navbar" role="navigation">

        <!-- Left links for user info navbar -->
        <ul class="user-info-menu left-links list-inline list-unstyled">

          <li class="hidden-sm hidden-xs">
            <a href="#" data-toggle="sidebar">
              <i class="fa-bars"></i>
            </a>
          </li>
        </ul>


        <!-- Right links for user info navbar -->
        <ul class="user-info-menu right-links list-inline list-unstyled">

          <li class="search-form"><!-- You can add "always-visible" to show make the search input visible -->

           <!-- <form method="get" action="extra-search.html">
              <input type="text" name="s" class="form-control search-field" placeholder="搜索"/>

              <button type="submit" class="btn btn-link">
                <i class="glyphicon glyphicon-search"></i>
              </button>
            </form>-->

          </li>

          <li class="dropdown user-profile">
            <a href="#" data-toggle="dropdown">
              <img src="<?php echo session('user_auth.picture');?>" alt="" class="img-circle img-inline userpic-32" width="30" height="30"/>
              <span>
                <?php echo get_nickname();?>
                <i class="fa-angle-down"></i>
              </span>
            </a>

            <ul class="dropdown-menu user-profile-menu list-unstyled">
              <!-- <li>
                <a href="#edit-profile">
                  <i class="fa-edit"></i>
                  信息中心
                </a>
              </li>
              <li>
                <a href="#settings">
                  <i class="fa-wrench"></i>
                  设置
                </a>
              </li>
              <li>
                <a href="<?php echo U('System/help');?>">
                  <i class="fa-info"></i>
                  帮助
                </a>
              </li> -->
              <li class="last">
                <a href="<?php echo U('Public/logout');?>">
                  <i class="fa-lock"></i>
                  退出
                </a>
              </li>
            </ul>
          </li>

        </ul>

      </nav>


  <!-- 内容文件 -->
  

<div class="row">
  <div class="col-sm-3">
    <div class="xe-widget xe-counter">
      <div class="xe-icon">
        <i class="glyphicon glyphicon-cloud"></i>
      </div>
      <div class="xe-label">
        <strong class="num"><?php echo (PHP_OS); ?></strong>
        <span>服务器操作系统</span>
      </div>
    </div>

    <div class="xe-widget xe-counter xe-counter-purple" data-count=".num" data-from="1" data-to="<?php echo ($list["userCount"]); ?>" data-duration="3" data-easing="false">
      <div class="xe-icon">
        <i class="glyphicon glyphicon-user"></i>
      </div>
      <div class="xe-label">
        <strong class="num">0</strong>
        <span>用户总数</span>
      </div>
    </div>

    <div class="xe-widget xe-counter xe-counter-info" data-count=".num" data-from="0" data-to="<?php echo ($list["activeCount"]); ?>" data-duration="4" data-easing="true">
      <div class="xe-icon">
        <i class="glyphicon glyphicon-fire"></i>
      </div>
      <div class="xe-label">
        <strong class="num">0</strong>
        <span>昨日活跃</span>
      </div>
    </div>
  </div>

  <div class="col-sm-6">
    <div class="chart-item-bg">
      <div class="chart-label">
        <div class="h3 text-secondary text-bold" data-count="this" data-from="0" data-to="<?php echo ($list["registerCount"]); ?>" data-duration="1">0.00%</div>
        <span class="text-medium text-muted">用户注册量</span>
      </div>
      <div id="pageviews-visitors-chart" style="height: 298px;"></div>
    </div>
  </div>

  <div class="col-sm-3">
    <div class="chart-item-bg">
      <div class="chart-label chart-label-small">
        <div class="h4 text-purple text-bold"></div>
        <span class="text-small text-upper text-muted">用户地区分布</span>
      </div>
      <div id="server-uptime-chart" style="height: 134px;"></div>
    </div>

    <div class="chart-item-bg">
      <div class="chart-label chart-label-small">
        <span class="text-small text-upper text-muted">用户性别比例</span>
        <div class="h4 text-secondary text-bold">
          <span style="color:#87CEFF">男</span>
          &nbsp;&nbsp;
          <span style="color:#E066FF">女</span>
        </div>
      </div>
      <div id="sales-avg-chart" style="height: 134px; position: relative;">
        <div style="position: absolute; top: 25px; right: 0; left: 40%; bottom: 0"></div>
      </div>
    </div>
  </div>
</div>


<div class="row">
  <div class="col-sm-6">

    <div class="chart-item-bg">
      <div id="pageviews-stats" style="height: 350px; padding: 20px 0;"></div>

      <div class="chart-entry-view">
        <div class="chart-entry-label">
          页面浏览量
        </div>
        <div class="chart-entry-value">
          <div class="sparkline first-month"><?php echo ((isset($list["pv"]["current"]) && ($list["pv"]["current"] !== ""))?($list["pv"]["current"]):0); ?></div>
        </div>
      </div>

      <div class="chart-entry-view">
        <div class="chart-entry-label">
          用户访问量
        </div>
        <div class="chart-entry-value">
          <div class="sparkline second-month"><?php echo ((isset($list["uv"]["current"]) && ($list["uv"]["current"] !== ""))?($list["uv"]["current"]):0); ?></div>
        </div>
      </div>

      <div class="chart-entry-view">
        <div class="chart-entry-label">
          产品下载量
        </div>
        <div class="chart-entry-value">
          <div class="sparkline third-month">0</div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6">
    <div class="chart-item-bg">
      <div class="chart-label">
        <div id="network-mbs-packets" class="h1 text-purple text-bold" data-count="this" data-from="0.00" data-to="0.00" data-suffix="mb/s" data-duration="1">0.00mb/s</div>
        <span class="text-small text-muted text-upper">网络情况</span>
      </div>
      <div class="chart-right-legend">
        <div id="network-realtime-gauge" style="width: 170px; height: 140px"></div>
      </div>
      <div id="realtime-network-stats" style="height: 320px"></div>
    </div>

    <div class="chart-item-bg">
      <div class="chart-label">
        <div id="network-mbs-packets" class="h1 text-secondary text-bold" data-count="this" data-from="0.00" data-to="<?php echo ($list["sysinfo"]["memPercent"]); ?>" data-suffix="%" data-duration="1.5">0.00%</div>
        <span class="text-small text-muted text-upper">内存使用率</span>

        <p class="text-medium" style="margin-top: 10px">记录实时内存使用情况。</p>
      </div>
      <div id="other-stats" style="min-height: 183px">
        <div id="cpu-usage-gauge" style="width: 170px; height: 140px; position: absolute; right: 20px; top: 20px"></div>
      </div>
    </div>

  </div>
</div>




  <!-- 尾部文件 -->
      <!-- Main Footer -->
    <!-- Choose between footer styles: "footer-type-1" or "footer-type-2" -->
    <!-- Add class "sticky" to  always stick the footer to the end of page (if page contents is small) -->
    <!-- Or class "fixed" to  always fix the footer to the end of page -->
    <footer class="main-footer sticky footer-type-1">

      <div class="footer-inner">

        <!-- Add your copyright text here -->
        <div class="footer-text">
          &copy;
          <strong><?php echo C('WEB_COPYRIGHT_EN');?></strong>
          <a href="<?php echo C('WEB_COPYRIGHT_URL');?>" target="_blank"> <?php echo C('WEB_COPYRIGHT_CN');?></a>
        </div>


        <!-- Go to Top Link, just add rel="go-top" to any link to add this functionality -->
        <div class="go-up">

          <a href="#" rel="go-top">
            <i class="fa-angle-up"></i>
          </a>

        </div>

      </div>

    </footer>
  </div>
</div>






  <!-- JS文件 -->
  <!-- Bottom Scripts -->
<script src="/Public/Static/bootstrap/bootstrap.min.js"></script>

<!-- 控制左侧菜单 -->
<script src="/Public/Admin/js/TweenMax.min.js"></script>

<script type="text/javascript" src="/Public/Static/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="/Public/Static/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>

<!-- 图表统计数据 -->
<script src="/Public/Admin/js/resizeable.js"></script>
<script src="/Public/Admin/js/joinable.js"></script>


<script src="/Public/Admin/js/xenon-api.js"></script>
<script src="/Public/Admin/js/xenon-toggles.js"></script>
<!-- JavaScripts initializations and stuff -->
<script src="/Public/Admin/js/xenon-custom.js"></script>

<!-- Imported scripts on this page -->
<script src="/Public/Admin/js/xenon-widgets.js"></script>

<script src="/Public/Admin/js/devexpress-web-14.1/js/globalize.min.js"></script>
<script src="/Public/Admin/js/devexpress-web-14.1/js/dx.chartjs.js"></script>
<!-- <script src="/Public/Admin/js/toastr/toastr.min.js"></script> -->

<script src="/Public/Admin/js/jquery-validate/jquery.validate.min.js"></script>

<!-- 弹出提示框，ajax用 js -->
<script src="/Public/Static/messenger/messenger.min.js"></script>
<!-- <script src="/Public/Admin/js/custom/alert_confirm_prompt.js"></script> -->
<script src="/Public/Static/js/custom_message.js"></script>
<script src="/Public/Static/js/custom_ajax.js"></script>
<script src="/Public/Admin/js/custom/think.js"></script>

<script src="/Public/Admin/js/common.js"></script>


  <script type="text/javascript">

  function userStat(data)
  {
    $("#pageviews-visitors-chart").dxChart(
    {
      dataSource: data,

      commonSeriesSettings:
      {
        argumentField: "date",
        point: { visible: true, size: 8, hoverStyle: {size: 5, border: 0, color: 'inherit'} },
        // line: {width: 1, hoverStyle: {width: 1}}
      },
      series:
      [
        { valueField: "data", name: "昨日统计", color: "#68b828" },
      ],

      tooltip:
      {
        enabled: true
      },

      legend:
      {
        position: 'inside',
        paddingLeftRight: 5
      },
      valueAxis:
      {
        valueType: 'numeric',
        label:
        {
          visible: false
        }
      },
      commonAxisSettings:
      {
        label:
        {
          visible: true
        },
        grid:
        {
          visible: true,
          color: '#f9f9f9'
        }
      }
    });

        $("#showZeroCheckbox").change(function () {
        var chart = $("#chartContainer").dxChart("instance");
        chart.option({
            valueAxis: { showZero: this.checked }
        });
    });
  }

  function userSex(data)
  {
    $("#sales-avg-chart div").dxPieChart(
    {
      dataSource: data,
      tooltip:
      {
        enabled: true,
      },
      size:
      {
        height: 90
      },
      legend:
      {
        visible: false
      },
      series: [
      {
        type: "doughnut",
        argumentField: "sex"
      }],
      palette: ['#87CEFF', '#E066FF'],
    });
  }

  function userArea(data)
  {
    $("#server-uptime-chart").dxChart(
    {
      dataSource: data,
      tooltip:
      {
        enabled: true
      },
      series:
      {
        argumentField: "province",
        valueField: "val",
        name: "Sales",
        type: "bar",
        color: '#7c38bc'
      },
      commonAxisSettings:
      {
        label:
        {
          visible: true
        },
        grid:
        {
          visible: false
        }
      },
      legend:
      {
        visible: false
      },
      argumentAxis:
      {
        valueMarginsEnabled: true
      },
      valueAxis:
      {
        max: 12
      },
      equalBarWidth:
      {
        width: 11
      }
    });
  }

  jQuery(document).ready(function($)
  {
    $.ajax(
    {
      url: "<?php echo U('Stat/index');?>",
      method: 'POST',
      dataType: 'json',
      success: function(user)
      {
        userStat(user);
      }
    });

    $.ajax(
    {
      url: "<?php echo U('Stat/area');?>",
      method: 'POST',
      dataType: 'json',
      success: function(area)
      {
        userArea(area);
      }
    });

    $.ajax(
    {
      url: "<?php echo U('Stat/sex');?>",
      method: 'POST',
      dataType: 'json',
      success: function(sex)
      {
        userSex(sex);
      }
    });

    // 内存
    $("#cpu-usage-gauge").dxCircularGauge(
    {
      scale:
      {
        startValue: 0,
        endValue: 100,
        majorTick:
        {
          tickInterval: 25
        }
      },
      rangeContainer:
      {
        palette: 'pastel',
        width: 3,
        ranges:
        [
          { startValue: 0, endValue: 25, color: "#68b828" },
          { startValue: 25, endValue: 50, color: "#68b828" },
          { startValue: 50, endValue: 75, color: "#68b828" },
          { startValue: 75, endValue: 100, color: "#d5080f" },
        ],
      },
      value: <?php echo ($list["sysinfo"]["memPercent"]); ?>,
      valueIndicator:
      {
        offset: 10,
        color: '#68b828',
        type: 'rectangleNeedle',
        spindleSize: 12
      }
    });



    // Pageviews Visitors Chart
    var i = 0;

    // Pageview Stats
    $('#pageviews-stats').dxBarGauge(
    {
      startValue: 0,
      endValue: 100,
      baseValue: 0,
      values: [<?php echo ($list["uv"]["scale"]); ?>, <?php echo ($list["pv"]["scale"]); ?>, 30.9],
      // values: [<?php echo ($list["uv"]["scale"]); ?>, <?php echo ($list["pv"]["scale"]); ?>, 30.9],
      label:
      {
        customizeText: function (arg)
        {
          return arg.valueText + '%';
        }
      },
      palette: ['#68b828','#7c38bc','#0e62c7'],
      margin :
      {
        top: 0
      }
    });





    // Realtime Network Stats
    var i = 0,
    rns_values = [0, <?php echo ($list["sysinfo"]["NetInput"]); ?>],
    rns2_values = [0, <?php echo ($list["sysinfo"]["NetOut"]); ?>],
    realtime_network_stats = [];

    for(i=0; i<=100; i++)
    {
      realtime_network_stats.push(
      {
        id: i,
        x1: between(rns_values[0], rns_values[1]),
        x2: between(rns2_values[0], rns2_values[1])
      });
    }

    $("#realtime-network-stats").dxChart(
    {
      dataSource: realtime_network_stats,
      commonSeriesSettings:
      {
        type: "area",
        argumentField: "id"
      },
      series:
      [
        { valueField: "x1", name: "Packets Sent", color: '#7c38bc', opacity: .4 },
        { valueField: "x2", name: "Packets Received", color: '#000', opacity: .5},
      ],
      legend:
      {
        verticalAlignment: "bottom",
        horizontalAlignment: "center"
      },
      commonAxisSettings:
      {
        label:
        {
          visible: false
        },
        grid:
        {
          visible: true,
          color: '#f5f5f5'
        }
      },
      legend:
      {
        visible: false
      },
      argumentAxis:
      {
        valueMarginsEnabled: false
      },
      valueAxis:
      {
        max: 500
      },
      animation:
      {
        enabled: false
      }
    }).data('iCount', i);



    $('#network-realtime-gauge').dxCircularGauge(
    {
      scale:
      {
        startValue: 0,
        endValue: 50,
        majorTick:
        {
          tickInterval: 5
        }
      },
      rangeContainer:
      {
        palette: 'pastel',
        width: 3,
        ranges:
        [
          { startValue: 0,  endValue: 5,  color: "#d5080f" },
          { startValue: 5,  endValue: 10, color: "#fcd036" },
          { startValue: 10, endValue: 15, color: "#fcd036" },
          { startValue: 15, endValue: 20, color: "#68b828" },
          { startValue: 20, endValue: 25, color: "#68b828" },
          { startValue: 25, endValue: 30, color: "#68b828" },
          { startValue: 30, endValue: 35, color: "#68b828" },
          { startValue: 35, endValue: 40, color: "#68b828" },
          { startValue: 40, endValue: 45, color: "#0e62c7" },
          { startValue: 45, endValue: 50, color: "#0e62c7" },
        ],
      },
      value: 0,
      valueIndicator:
      {
        offset: 10,
        color: '#7c38bc',
        type: 'triangleNeedle',
        spindleSize: 12
      }
    });

    setInterval(function(){  networkRealtimeChartTick(rns_values, rns2_values); }, 1000);
    setInterval(function(){ networkRealtimeGaugeTick(); }, 2000);
    setInterval(function(){ networkRealtimeMBupdate(); }, 3000);






    // Resize charts
    $(window).on('xenon.resize', function()
    {
      $("#pageviews-visitors-chart").data("dxChart").render();
      $("#server-uptime-chart").data("dxChart").render();
      $("#realtime-network-stats").data("dxChart").render();
    });

  });




  function networkRealtimeChartTick(min_max, min_max2)
  {
    var $ = jQuery,
    i = 0;

    var chart_data = $('#realtime-network-stats').dxChart('instance').option('dataSource');

    var count = $('#realtime-network-stats').data('iCount');

    $('#realtime-network-stats').data('iCount', count + 1);

    chart_data.shift();
    chart_data.push({id: count + 1, x1: between(min_max[0],min_max[1]), x2: between(min_max2[0],min_max2[1])});

    $('#realtime-network-stats').dxChart('instance').option('dataSource', chart_data);
  }

  function networkRealtimeGaugeTick()
  {
    var nr_gauge = jQuery('#network-realtime-gauge').dxCircularGauge('instance');

    nr_gauge.value( between(0,<?php echo ($list["sysinfo"]["NetInput"]); ?>) );
  }

  // 实时网络百分比数据
  function networkRealtimeMBupdate()
  {
    var $el = jQuery("#network-mbs-packets"),
    options = {
      useEasing : true,
      useGrouping : true,
      separator : ',',
      decimal : '.',
      prefix : '' ,
      suffix : 'mb/s'
    },

    cntr = new countUp($el[0], parseFloat($el.text().replace('mb/s')), parseFloat(<?php echo ($list["sysinfo"]["NetInput"]); ?>), 2, 1.5, options);

    cntr.start();
  }

  function between(randNumMin, randNumMax)
  {
    var randInt = Math.floor((Math.random() * ((randNumMax + 1) - randNumMin)) + randNumMin);

    return randInt;
  }
</script>


<!-- 页面footer钩子，一般用于加载插件JS文件和JS代码 -->
<?php echo hook('pageFooter', 'widget');?>

</body>
</html>