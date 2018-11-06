<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:53:"D:\WWW\o1p1ga./application/admin\view\news\index.html";i:1541490407;s:55:"D:\WWW\o1p1ga./application/admin\view\public\_meta.html";i:1541493533;}*/ ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <title>新闻列表</title>
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
                            <li>新闻列表管理，可修改新闻的内容</li>                        
                        </ul>                        
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>新闻列表</h5>                   
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
                                <span style="font-weight: 600;margin-right:6px;">新闻列表    (共<?php echo $total; ?>条记录)</span>                          
                                <button type="button" id="loading-example-btn" class="btn btn-white btn-sm"><i class="fa fa-refresh"></i> 刷新</button>
                            </div>
                            <div class="col-md-7">
                                <form  id="search-form2" onsubmit="return check_form();" action="<?php echo url('news/index'); ?>"  method="get" class="form-inline" style="float:right" >
                                    <div class="form-group">                                      
                                        <select  name="catid" class="form-control" style="height:auto">
                                            <option value="0">全部分类</option>
                                            <?php if(is_array($cats) || $cats instanceof \think\Collection || $cats instanceof \think\Paginator): $i = 0; $__LIST__ = $cats;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                                <option value="<?php echo $key; ?>" <?php if($key == $catid): ?>selected="selected"<?php endif; ?>><?php echo $vo; ?></option>
                                            <?php endforeach; endif; else: echo "" ;endif; ?>
                                        </select>
                                    </div> 
                                    <div class="form-group"> 
                                        <label> 日期范围：</label> 
                                        <input type="text" name="start_time" class="input-sm form-control" id="countTimestart" onfocus="selecttime(1)" value="<?php echo $start_time; ?>" > -
                                        <input type="text" name="end_time" class="input-sm form-control" id="countTimestart" onfocus="selecttime(1)" value="<?php echo $end_time; ?>" >    
                                    </div>  
                                   <!--  <div class="form-group" id="data_5">
                                        <label class="font-noraml">范围选择</label>
                                        <div class="input-daterange input-group" id="datepicker">
                                            <input type="text" name="start_time" class="input-sm form-control" name="start" value="<?php echo $start_time; ?>" />
                                            <span class="input-group-addon">到</span>
                                            <input type="text" name="end_time" class="input-sm form-control" name="end" value="<?php echo $end_time; ?>" />
                                        </div>
                                    </div>    -->                
                                    <div class="input-group">
                                        <input type="text" placeholder="搜索相关数据..." class="input-sm form-control" name="title" value="<?php echo $title; ?>"> 
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-sm btn-primary"> 搜索</button>
                                        </span>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <div class="row m-b-sm m-t-sm">
                            <div class="col-md-5">
                                <a href="<?php echo url('news/handle'); ?>">
                                <button class="btn btn-info " type="button"><i class="fa fa-plus" ></i> 添加</button> 
                                </a> 
                                <button class="btn btn-info " type="button" onclick="doConfirmBatch('<?php echo url('Admin/delete',array('batchFlag' => 1)); ?>','确实要删除选择项吗？')"><i class="fa fa-trash-o"></i>  删除</button>       
                            </div>                       
                        </div>
                        <div class="project-list table-responsive">
                            <form name="myform" id="myform" action="" method="post">           
                            <table class="table table-hover table table-striped">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" class="i-checks" id="check_box" ></th>
                                        <th>ID</th>
                                        <th>标题</th>
                                        <th>分类</th>
                                        <th>缩图</th>
                                        <th>更新时间</th>
                                        <th >是否推荐</th>
                                        <th>是否展示</th>                                       
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($total>0): if(is_array($news) || $news instanceof \think\Collection || $news instanceof \think\Paginator): $i = 0; $__LIST__ = $news;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="i-checks" value="<?php echo $vo['id']; ?>" name="ids[]">
                                        </td>
                                        <td >
                                            <?php echo $vo['id']; ?>
                                        </td>
                                        <td >
                                            <?php echo $vo['title']; ?>
                                        </td>
                                        <td >
                                            <?php echo getCatName($vo['catid']); ?>
                                        </td>
                                        <td><img width="60" height="60" class="picture-thumb" src="<?php echo $vo['image']; ?>"></td>
                                        <td >
                                            <?php echo $vo['update_time']; ?>
                                        </td>
                                        <td >
                                            <?php echo isYesNo($vo['is_position']); ?>
                                        </td>
                                        <td class="td-status"><?php echo status($vo['id'], $vo['status']); ?></td>
                                        <td >                                           
                                            <a href="<?php echo url('Admin/handle',array('id'=>$vo['id'])); ?>" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> 编辑 </a>
                                            <?php if($vo['id'] > 1): ?>
                                            <a href="javascript:doConfirmBatch('<?php echo url('Admin/delete',array('id' => $vo[id])); ?>','确实要删除选择项吗？','{id:<?php echo $vo[id]; ?>}');" class="btn btn-white btn-sm"><i class="fa fa-trash-o"></i> 删除 </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>  
                                    <?php endforeach; endif; else: echo "" ;endif; else: ?>
                                    <tr><td colspan="9" align="center">暂无相关数据</td></tr>
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
    <script type="text/javascript" src="__STATIC__/hadmin/lib/My97DatePicker/4.8/WdatePicker.js"></script>    
    <!-- 全局js -->
    <!-- 自定义js -->
    <script src="__STATIC__/hadmin/js/plugins/iCheck/icheck.min.js"></script>  
    <script src="__STATIC__/admin/js/common.js"></script> 
    <!-- 自定义js -->    
    <script type="text/javascript">
        function check_form(){
            var start_time = $.trim($("input[name='start_time']").val());
            var end_time =  $.trim($("input[name='end_time']").val());
            if(start_time == '' ^ end_time == ''){
                layer.alert('请选择完整的时间间隔', {icon: 2});
                return false;
            }

            return true;
        }
    </script>
    <style>
      .pagination>li>a,.pagination>li>span{padding:6px 10px;}   
    </style> 
    </body>
</html>
