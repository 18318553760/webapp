<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:54:"D:\WWW\o1p1ga./application/admin\view\index\index.html";i:1541143143;s:55:"D:\WWW\o1p1ga./application/admin\view\public\_meta.html";i:1541493533;s:55:"D:\WWW\o1p1ga./application/admin\view\public\_menu.html";i:1541482276;s:57:"D:\WWW\o1p1ga./application/admin\view\public\_header.html";i:1541396948;s:57:"D:\WWW\o1p1ga./application/admin\view\public\_footer.html";i:1541143191;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <title>webapp后台管理系统</title>
    <meta name="keywords" content="后台管理">
    <meta name="description" content="后台管理">
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <link rel="shortcut icon" href="favicon.ico"> <link href="__STATIC__/hadmin/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="__STATIC__/hadmin/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="__STATIC__/hadmin/css/animate.css" rel="stylesheet">
      <link href="__STATIC__/hadmin/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="__STATIC__/hadmin/css/style.css?v=4.1.0" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="__STATIC__/admin/uploadify/uploadify.css" />
    <!--  ie6图片不透明start -->
    <!--[if IE 6]>
    <script type="text/javascript" src="__STATIC__/hadmin/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <!--  end -->
    <script>
        swf = '__STATIC__/admin/uploadify/uploadify.swf';
        image_upload_url = "<?php echo url('image/upload0'); ?>";
    </script>
</head>


<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
    <div id="wrapper">
        <!--左侧导航开始-->
        <nav class="navbar-default navbar-static-side" role="navigation">
    <div class="nav-close"><i class="fa fa-times-circle"></i>
    </div>
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu"> 
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs" style="font-size:20px;">
                                <i class="fa fa-area-chart"></i>
                                <strong class="font-bold">webapp</strong>
                            </span>
                        </span>
                    </a>
                </div>
                <div class="logo-element">app
                </div>
            </li>   
            <?php if(is_array($admin_menu) || $admin_menu instanceof \think\Collection || $admin_menu instanceof \think\Paginator): $i = 0; $__LIST__ = $admin_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
             <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                <span class="ng-scope"><?php echo $vo['name']; ?></span>
            </li>     
            <?php if(isset($vo['_child'])): if(is_array($vo['_child']) || $vo['_child'] instanceof \think\Collection || $vo['_child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['_child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i;?>
            <li <?php if($v1['id'] == $current_menu['parentid']): ?>class="active"<?php endif; ?>>
                <a class="J_menuItem" <?php if(!is_array($v1['_child'])): ?> href="<?php echo url($v1['group'].'/'.$v1['model'].'/'.$v1['action'],$v1['data']); ?>" <?php endif; ?>>
                    <i class="<?php echo $v1['icon']; ?>"></i>
                    <span class="nav-label"><?php echo $v1['name']; ?></span>  
                    <?php if(isset($v1['_child'])): ?>                         
                    <span class="fa arrow"></span> 
                    <?php endif; ?>                              
                </a>
                 <ul class="nav nav-second-level">
                    <?php if(isset($v1['_child'])): if(is_array($v1['_child']) || $v1['_child'] instanceof \think\Collection || $v1['_child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $v1['_child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v2): $mod = ($i % 2 );++$i;?>
                    <li>
                        <a class="J_menuItem" href="<?php echo url($v2['group'].'/'.$v2['model'].'/'.$v2['action'],$v2['data']); ?>"><?php echo $v2['name']; ?></a>
                    </li>
                    <?php endforeach; endif; else: echo "" ;endif; endif; ?>                   
                </ul>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; endif; ?>   
            <li class="line dk"></li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
</nav>
        <!--左侧导航结束-->
        <!--右侧部分开始-->
        <div id="page-wrapper" class="gray-bg dashbard-1">
            <div class="row border-bottom">
    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header"><a class="navbar-minimalize minimalize-styl-2 btn btn-info " href="#"><i class="fa fa-bars"></i> </a>
            <form role="search" class="navbar-form-custom" method="post" action="search_results.html">
                <div class="form-group">
                    <input type="text" placeholder="请输入您需要查找的内容 …" class="form-control" name="top-search" id="top-search">
                </div>
            </form>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                    <span style="margin-right:10px;"><?php echo $admin_info['role_name']; ?></span><span><?php echo $admin_info['username']; ?><span><i class="caret"></i> 
                </a>
                <ul class="dropdown-menu animated fadeInRight m-t-xs" >
                    <li>
                        <a href="mailbox.html">
                            <div>
                                <i class="fa fa-envelope fa-fw"></i> 个人信息
                               
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="<?php echo url('login/logout'); ?>">
                            <div>
                           
                               <i class="glyphicon glyphicon-off"></i> 退出
                                <!--<i class="fa fa-qq fa-fw"></i> 退出-->                                            
                            </div>
                        </a>
                    </li>                        
                </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle count-info"  href="javascript:update_cache();" target="_blank" title="更新缓存">
                    <i class="fa fa-refresh"></i> 
                </a>                
            </li>
      <!--       <li class="dropdown">
                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                    <i class="fa fa-envelope"></i> <span class="label label-warning">16</span>
                </a>
                <ul class="dropdown-menu dropdown-messages">
                    <li class="m-t-xs">
                        <div class="dropdown-messages-box">
                            <a href="profile.html" class="pull-left">
                             
                            </a>
                            <div class="media-body">
                                <small class="pull-right">46小时前</small>
                                <strong>小四</strong> 是不是只有我死了,你们才不骂爵迹
                                <br>
                                <small class="text-muted">3天前 2014.11.8</small>
                            </div>
                        </div>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <div class="dropdown-messages-box">
                            <a href="profile.html" class="pull-left">
                              
                            </a>
                            <div class="media-body ">
                                <small class="pull-right text-navy">25小时前</small>
                                <strong>二愣子</strong> 呵呵
                                <br>
                                <small class="text-muted">昨天</small>
                            </div>
                        </div>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <div class="text-center link-block">
                            <a class="J_menuItem" href="mailbox.html">
                                <i class="fa fa-envelope"></i> <strong> 查看所有消息</strong>
                            </a>
                        </div>
                    </li>
                </ul>
            </li> -->
            <li class="dropdown">
                <a class="dropdown-toggle count-info"  href="/index.php" target="_blank" title="新窗口打开首页">
                    <i class="fa fa-home"></i> 
                </a>                
            </li>
        </ul>
    </nav>
</div>

            <div class="row J_mainContent" id="content-main">
                <iframe id="J_iframe" width="100%" height="100%" src="<?php echo url('Index/welcome'); ?>" frameborder="0"  seamless></iframe>
            </div>
        </div>
        <!--右侧部分结束-->
    </div>
    <script type="text/javascript">
   //更新缓存
    function update_cache(){
        $.ajax({
            url:"<?php echo url('System/update_Cache'); ?>",
            beforeSend:function(){
                layer.msg('正在更新缓存');
            },
            success:function(data){
            	layer.msg(data.msg);
                window.location.reload();
            }
        });
    }

</script>
<div class="footer">
    <div class="pull-right">© 20018-2026 <a href="/" target="_blank">webapp-洪少版本所有</a>
    </div>
</div>

    <!-- 全局js -->
    <script src="__STATIC__/hadmin/js/jquery.min.js?v=2.1.4"></script>
    <script src="__STATIC__/hadmin/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="__STATIC__/hadmin/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="__STATIC__/hadmin/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="__STATIC__/hadmin/js/plugins/layer/layer.min.js"></script>

    <!-- 自定义js -->
    <script src="__STATIC__/hadmin/js/hAdmin.js?v=4.1.0"></script>
    <script type="text/javascript" src="__STATIC__/hadmin/js/index.js"></script>

    <!-- 第三方插件 -->
    <script src="__STATIC__/hadmin/js/plugins/pace/pace.min.js"></script>

</body>

</html>
