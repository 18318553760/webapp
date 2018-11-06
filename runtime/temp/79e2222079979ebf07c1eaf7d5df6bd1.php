<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:55:"D:\WWW\o1p1ga./application/admin\view\admin\handle.html";i:1541218920;s:55:"D:\WWW\o1p1ga./application/admin\view\public\_meta.html";i:1541145415;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <title>编辑管理员</title>
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
    <script>
        swf = '__STATIC__/admin/uploadify/uploadify.swf';
        image_upload_url = "<?php echo url('image/upload'); ?>";
    </script>
</head>


<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInUp">  
        <div class="row">          
            <div class="col-sm-12 ">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>编辑管理员</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="form_basic.html#">
                                <i class="fa fa-wrench"></i>
                            </a>                            
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>

                    <div class="ibox-content ">
                        <form method="post" class="form-horizontal" action="<?php echo url('Admin/handle'); ?>" id="myform">
                            <input type="hidden" name="id" value="<?php echo $info['id']; ?>">
                            <input type="hidden" name="act" value="<?php echo $act; ?>">
                            <div class="form-group">
                                <label class="col-sm-1 control-label">用户名：</label>
                                <div class="col-sm-3">
                                    <input type="text" placeholder="用户名" class="form-control" name="username" value="<?php echo $info['username']; ?>"> 
                                    <span class="help-block m-b-none">请输入您注册时所填的用户名</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-1 control-label">E-mail：</label>
                                <div class="col-sm-3">
                                    <input type="text" placeholder="E-mail" class="form-control" name="email" value="<?php echo $info['email']; ?>"> 
                                    <span class="help-block m-b-none">请输入您注册时所填的E-mail</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-1 control-label">登录密码：</label>
                                <div class="col-sm-3">
                                    <input type="password" placeholder="登录密码" class="form-control" name="password" value="<?php echo $info['password']; ?>">
                                </div>
                            </div>
                            <?php if(($act == 'add') OR ($info['id'] > 1)): ?>
                            <div class="form-group">
                                <label class="col-sm-1 control-label">所属角色：</label>
                                <div class="col-sm-3">
                                    <select class="form-control" name="role_id" style="height:auto;">
                                        <?php if(is_array($role) || $role instanceof \think\Collection || $role instanceof \think\Paginator): $i = 0; $__LIST__ = $role;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                         <option value="<?php echo $vo['role_id']; ?>" <?php if($vo['role_id'] == $info['role_id']): ?> selected="selected" <?php endif; ?> ><?php echo $vo['role_name']; ?></option>
                                        <?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <div class="col-sm-offset-1 col-sm-3">
                                    <button class="btn btn-sm btn-info" type="submit" >确定提交</button>
                                </div>
                            </div>
                        </form>
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
    <!-- 自定义js -->
    <script>
        $(document).ready(function(){
            $('#loading-example-btn').click(function () {
                btn = $(this);
                simpleLoad(btn, true)
                simpleLoad(btn, false)
            });
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
        function simpleLoad(btn, state) {
            if (state) {
                btn.children().addClass('fa-spin');
                btn.contents().last().replaceWith(" Loading");
            } else {
                setTimeout(function () {
                    btn.children().removeClass('fa-spin');
                    btn.contents().last().replaceWith(" Refresh");
                }, 2000);
            }
        }
        $('#loading-example-btn').click(function(){
            location.reload();
        }) 
        $("#myform").submit(function () {
            var self = $(this);
            $.post(self.attr("action"), self.serialize(), success, "json");
            return false;          
        }); 
        function success(data) {
            if (data.code == 1) {                
                layer.msg(data.msg, {
                    icon: 1,
                    time: 2000 //2秒关闭（如果不配置，默认是3秒）
                }, function(){

                    setTimeout(function(){
                        window.location.href = data.url;
                    },500);
                });
            } else {
                layer.msg(data.msg, {
                    icon: 2,
                    time: 2000 //2秒关闭（如果不配置，默认是3秒）
                });
            }
        }
    </script> 
    <style>

      .pagination>li>a,.pagination>li>span{padding:6px 10px;}
   
    </style> 
    </body>
</html>
