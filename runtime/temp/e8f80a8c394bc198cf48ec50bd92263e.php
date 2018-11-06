<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:57:"D:\WWW\o1p1ga./application/admin\view\admin\role_log.html";i:1541414425;s:55:"D:\WWW\o1p1ga./application/admin\view\public\_meta.html";i:1541493533;}*/ ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <title>角色列表</title>
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
            <div class="col-sm-12">
                 <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>操作提示</h5>
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
                        <ul>
                            <li>网站管理员日志列表。</li>                        
                        </ul>                        
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>管理员列表</h5>                   
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
                        <div class="row m-b-sm m-t-sm">
                            <div class="col-md-5">
                                <span style="font-weight: 600;margin-right:6px;">角色列表    (共<?php echo $total; ?>条记录)</span>                          
                                <button type="button" id="loading-example-btn" class="btn btn-white btn-sm"><i class="fa fa-refresh"></i> 刷新</button>
                            </div>
                            
                        </div>
                        <div class="row m-b-sm m-t-sm">
                            <div class="col-md-5">                             
                                <button class="btn btn-info " type="button" onclick="doConfirmBatch('<?php echo url('Admin/log_delete',array('batchFlag' => 1)); ?>','确实要删除选择项吗？')"><i class="fa fa-trash-o"></i>  删除</button>       
                            </div>
                       
                        </div>

                        <div class="project-list table-responsive">
                            <form name="myform" id="myform" action="" method="post">           
                            <table class="table table-hover table table-striped">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" class="i-checks" id="check_box" ></th>
                                        <th>ID</th>
                                        <th>角色名称</th>
                                        <th>描述</th> 
                                        <th>IP</th>   
                                        <th>操作时间</th>                                    
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($list): if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>                                    
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="i-checks" value="<?php echo $vo['log_id']; ?>" name="ids[]">
                                        </td>
                                        <td >
                                            <?php echo $vo['log_id']; ?>
                                        </td>
                                        <td >
                                           <?php echo $vo['username']; ?>
                                        </td>
                                        <td >
                                            <?php echo $vo['log_info']; ?>
                                        </td>
                                        <td >
                                            <?php echo $vo['log_ip']; ?>
                                        </td>  
                                    
                                        <td>
                                            <?php echo date("Y-m-d H:i:s",$vo['log_time']); ?>
                                        </td>                
                                        <td > 
                                            <a href="javascript:doConfirmBatch('<?php echo url('Admin/log_delete',array('log_id' => $vo[log_id])); ?>','确实要删除选择项吗？','{log_id:<?php echo $vo[log_id]; ?>}');" class="btn btn-white btn-sm"><i class="fa fa-trash-o"></i> 删除 </a>                                           
                                        </td>
                                    </tr> 
                                    <?php endforeach; endif; else: echo "" ;endif; else: ?>
                                    <tr ><td colspan="7" align="center">暂无相关数据</td></tr>
                                    <?php endif; ?>
                                    </tbody>                               
                                </table>
                            </form>
                                <?php echo $page; ?>                                
                            </div>
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
    <!-- 自定义js -->
    <script src="__STATIC__/hadmin/js/plugins/iCheck/icheck.min.js"></script>  
    <script src="__STATIC__/admin/js/common.js"></script> 
    <!-- 自定义js -->
  
    <style>

      .pagination>li>a,.pagination>li>span{padding:6px 10px;}
   
    </style> 
    </body>
</html>
