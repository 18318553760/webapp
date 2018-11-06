<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:54:"D:\WWW\o1p1ga./application/admin\view\news\handle.html";i:1541498107;s:55:"D:\WWW\o1p1ga./application/admin\view\public\_meta.html";i:1541493533;}*/ ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <title>新闻编辑</title>
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
            <div class="col-sm-12 ">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><?php if($info['id']>0): ?>编辑新闻<?php else: ?>添加新闻<?php endif; ?></h5>
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
                        <form method="post" class="form-horizontal" action="<?php echo url('news/handle'); ?>" id="myform">
                            <input type="hidden" name="id" value="<?php echo $info['id']; ?>">
                            <input type="hidden" name="act" value="<?php echo $act; ?>">
                            <div class="form-group">
                                <label class="col-sm-1  col-xs-12 control-label">文章标题：</label>
                                <div class="col-sm-3">
                                    <input type="text" placeholder="文章标题" class="form-control" name="title" value="<?php echo $info['title']; ?>"> 
                                   
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-1 col-xs-12 control-label">简略标题：</label>
                                <div class="col-sm-3">
                                    <input type="text" placeholder="简略标题" class="form-control" name="samll_title" value="<?php echo $info['samll_title']; ?>"> 
                                  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-1 col-xs-12 control-label">分类栏目：</label>
                                <div class="col-sm-3">
                                    <select class="form-control" name="catid" style="height:auto;">
                                        <?php if(is_array($cats) || $cats instanceof \think\Collection || $cats instanceof \think\Paginator): $i = 0; $__LIST__ = $cats;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                         <option value="<?php echo $key; ?>" <?php if($vo['role_id'] == $info['role_id']): ?> selected="selected" <?php endif; ?> ><?php echo $vo; ?></option>
                                        <?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-1 col-xs-12 control-label">文章摘要：</label>
                                <div class="col-sm-3">
                                    <textarea name="description" cols="20" rows="6"  class="form-control"  placeholder="说点什么...最少输入10个字符" datatype="*10-100" dragonfly="true" nullmsg="备注不能为空！" ></textarea>
                                    <!-- <p class="textarea-numberbar"><em class="textarea-length">0</em>/200</p> -->
                                   
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-1 col-xs-12 control-label">允许评论：</label>
                                <div class="col-sm-3" skin-minimal>
                                    <input type="checkbox" id="is_allowcomments" name="is_allowcomments" value="1">
                                   <!--  <input type="checkbox" id="is_allowcomments" name="is_allowcomments" value="1" class="i-checks"> -->
                                   
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-1  col-xs-12 control-label">是否推荐到首页头图：</label>
                                <div class="col-sm-3">
                                    <input type="checkbox" id="is_head_figure" name="is_head_figure" value="1">
                                   
                                </div>
                            </div>  
                            <div class="form-group" >
                                <label class="col-sm-1 col-xs-12 control-label">缩略图：</label>
                                <div class="col-sm-3">
                                       <input id="file_upload"  type="file" multiple="true" >
                                        <img style="display: none" id="upload_org_code_img" src="" width="150" height="150">
                                        <input id="file_upload_image" name="image" type="hidden" multiple="true" value="">
                                </div>
                            </div>  
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-1 control-label">文章内容：</label>
                                <div class="col-xs-12 col-sm-9"">
                                    <script id="editor" type="text/plain" name="content" style="width:100%;height:400px;"></script>
                                </div>
                            </div>       
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
    <script src="__STATIC__/admin/js/common.js"></script> 
    <!-- 全局js -->
    <!-- 自定义js -->
    <script src="__STATIC__/hadmin/js/plugins/iCheck/icheck.min.js"></script>  
    <script type="text/javascript" src="__STATIC__/hadmin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
    <script type="text/javascript" src="__STATIC__/hadmin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
    <script type="text/javascript" src="__STATIC__/hadmin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
    <script type="text/javascript" src="__STATIC__/hadmin/lib/ueditor/1.4.3/ueditor.config.js"></script>
    <script type="text/javascript" src="__STATIC__/hadmin/lib/ueditor/1.4.3/ueditor.all.min.js"> </script>
    <script type="text/javascript" src="__STATIC__/hadmin/lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js"></script>
    <script type="text/javascript" src="__STATIC__/admin/uploadify/jquery.uploadify.min.js"></script>
   <script type="text/javascript" src="__STATIC__/admin/js/image.js" ></script>
    <!-- 自定义js -->
    <script>
        $(function(){
            //表单验证
            var ue = UE.getEditor('editor');
        });
        var validate = $("#myform").validate({
            debug: true, //调试模式取消submit的默认提交功能   
            //errorClass: "label.error", //默认为错误的样式类为：error   
            focusInvalid: false, //当为false时，验证无效时，没有焦点响应  
            onkeyup: false,   
            submitHandler: function(form){   //表单提交句柄,为一回调函数，带一个参数：form   
                from_save(from);               
            },  
            rules:{
                title:{
                    required:true
                },
                samll_title:{
                    required:true,                  
                },
                catid:{
                    required:true,                   
                },
                sources_type:{
                   required:true,
                },
                is_allowcomments:{
                  required:true,
                },                
            },          
                      
        }); 
    </script> 
    <style>

      .pagination>li>a,.pagination>li>span{padding:6px 10px;}
      #file_upload-button{position: absolute;z-index: 22;}
   
    </style> 
    </body>
</html>
