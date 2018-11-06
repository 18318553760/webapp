<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:56:"D:\WWW\o1p1ga./application/admin\view\index\welcome.html";i:1541128538;s:55:"D:\WWW\o1p1ga./application/admin\view\public\_meta.html";i:1541493533;s:57:"D:\WWW\o1p1ga./application/admin\view\public\_footer.html";i:1541143191;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <title>[title]</title>
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


<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInUp">
        <div class="row">
            <div class="col-sm-10">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="row row-sm text-center">
                            <div class="col-xs-6">
                                <div class="panel padder-v item">
                                    <div class="h1 text-info font-thin h1">521</div>
                                    <span class="text-muted text-xs">同比增长</span>
                                    <div class="top text-right w-full">
                                        <i class="fa fa-caret-down text-warning m-r-sm"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="panel padder-v item bg-info">
                                    <div class="h1 text-fff font-thin h1">521</div>
                                    <span class="text-muted text-xs">今日访问</span>
                                    <div class="top text-right w-full">
                                        <i class="fa fa-caret-down text-warning m-r-sm"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="panel padder-v item bg-primary">
                                    <div class="h1 text-fff font-thin h1">521</div>
                                    <span class="text-muted text-xs">销售数量</span>
                                    <div class="top text-right w-full">
                                        <i class="fa fa-caret-down text-warning m-r-sm"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="panel padder-v item">
                                    <div class="font-thin h1">$129</div>
                                    <span class="text-muted text-xs">近日盈利</span>
                                    <div class="bottom text-left">
                                        <i class="fa fa-caret-up text-warning m-l-sm"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title" style="border-bottom:none;background:#fff;">
                                <h5>系统信息</h5>
                                <div class="ibox-tools">
                                    <a class="collapse-link">
                                        <i class="fa fa-chevron-up"></i>
                                    </a>
                                    <a class="close-link">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="ibox-content table-responsive" style="border-top:none;">
                                <table class="table table-striped">                           
                                    <tbody>
                                        <tr>                                       
                                            <td>服务器操作系统</td>
                                            <td><?php echo $system_info['os']; ?></td>
                                            <td>服务器域名/IP:</td>
                                            <td><?php echo $system_info['domain']; ?> [ <?php echo $system_info['ip']; ?> ]</td>                                            
                                        </tr>
                                        <tr>
                                            <td>服务器环境:</td>
                                            <td><?php echo $system_info['domain']; ?></td>
                                            <td>Mysql 版本:</td>
                                            <td><?php echo $system_info['mysql_version']; ?></td>                                           
                                        </tr>
                                        <tr>
                                            <td>PHP 版本:</td>
                                            <td><?php echo $system_info['php_version']; ?></td>
                                            <td>文件上传限制:</td>
                                            <td><?php echo $system_info['fileupload']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>最大执行时间:</td>
                                            <td><?php echo $system_info['max_ex_time']; ?></td>
                                            <td>最大占用内存:</td>
                                            <td><?php echo $system_info['memory_limit']; ?></td>                                            
                                        </tr>
                                        <tr>
                                            <td>Zlib支持:</td>
                                            <td><?php echo $system_info['zlib']; ?></td>
                                            <td>Curl支持:</td>
                                            <td><?php echo $system_info['curl']; ?></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>               
            </div>
            <div class="col-sm-2">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>任务列表</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <ul class="todo-list m-t small-list ui-sortable">
                            <li>
                                <a href="widgets.html#" class="check-link"><i class="fa fa-check-square"></i> </a>
                                <span class="m-l-xs todo-completed">任务1</span>

                            </li>
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 全局js -->
    <script src="__STATIC__/hadmin/js/jquery.min.js?v=2.1.4"></script>
    <script src="__STATIC__/hadmin/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="__STATIC__/hadmin/js/plugins/layer/layer.min.js"></script>
    <script src="__STATIC__/hadmin/js/content.min.js"></script>
    <!-- 全局js -->
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

</body>

</html>
