<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:51:"D:\WWW\o1p1ga./application/admin\view\news\add.html";i:1501441678;s:55:"D:\WWW\o1p1ga./application/admin\view\public\_meta.html";i:1541145415;s:57:"D:\WWW\o1p1ga./application/admin\view\public\_footer.html";i:1541143191;}*/ ?>
<!--header-->
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
    <script>
        swf = '__STATIC__/admin/uploadify/uploadify.swf';
        image_upload_url = "<?php echo url('image/upload'); ?>";
    </script>
</head>


<article class="page-container">
  <form class="form form-horizontal" id="form-singwaapp" url="<?php echo url('news/add'); ?>">
    <div class="row cl">
      <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>文章标题：</label>
      <div class="formControls col-xs-8 col-sm-9">
        <input type="text" class="input-text" value="" placeholder="" id="title" name="title">
      </div>
    </div>
    <div class="row cl">
      <label class="form-label col-xs-4 col-sm-2">简略标题：</label>
      <div class="formControls col-xs-8 col-sm-9">
        <input type="text" class="input-text" value="" placeholder="" id="samll_title" name="small_title">
      </div>
    </div>
    <div class="row cl">
      <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>分类栏目：</label>
      <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select name="catid" class="select">
                 <?php if(is_array($cats) || $cats instanceof \think\Collection || $cats instanceof \think\Paginator): $i = 0; $__LIST__ = $cats;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                  <option value="<?php echo $key; ?>"><?php echo $vo; ?></option>
                  <?php endforeach; endif; else: echo "" ;endif; ?>
                  
                </select>
				</span> </div>
    </div>

    <div class="row cl">
      <label class="form-label col-xs-4 col-sm-2">文章摘要：</label>
      <div class="formControls col-xs-8 col-sm-9">
        <textarea name="description" cols="" rows="" class="textarea"  placeholder="说点什么...最少输入10个字符" datatype="*10-100" dragonfly="true" nullmsg="备注不能为空！" ></textarea>
        <p class="textarea-numberbar"><em class="textarea-length">0</em>/200</p>
      </div>
    </div>


    <div class="row cl">
      <label class="form-label col-xs-4 col-sm-2">允许评论：</label>
      <div class="formControls col-xs-8 col-sm-9 skin-minimal">
        <div class="check-box">
          <input type="checkbox" id="is_allowcomments" name="is_allowcomments" value="1">
          <label for="checkbox-pinglun">&nbsp;</label>
        </div>
      </div>
    </div>
    <div class="row cl">
      <label class="form-label col-xs-4 col-sm-2">是否推荐到首页头图：</label>
      <div class="formControls col-xs-8 col-sm-9 skin-minimal">
        <div class="check-box">
          <input type="checkbox" id="is_head_figure" name="is_head_figure" value="1">
          <label for="checkbox-pinglun">&nbsp;</label>
        </div>
      </div>
    </div>
    <div class="row cl">
      <label class="form-label col-xs-4 col-sm-2">是否推荐：</label>
      <div class="formControls col-xs-8 col-sm-9 skin-minimal">
        <div class="check-box">
          <input type="checkbox" id="is_position" name="is_position" value="1">
          <label for="checkbox-pinglun">&nbsp;</label>
        </div>
      </div>
    </div>

    <div class="row cl">
      <label class="form-label col-xs-4 col-sm-2">缩略图：</label>
      <div class="formControls col-xs-8 col-sm-9">
        <input id="file_upload"  type="file" multiple="true" >
        <img style="display: none" id="upload_org_code_img" src="" width="150" height="150">
        <input id="file_upload_image" name="image" type="hidden" multiple="true" value="">
      </div>
    </div>

    <div class="row cl">
      <label class="form-label col-xs-4 col-sm-2">文章内容：</label>
      <div class="formControls col-xs-8 col-sm-9">
        <script id="editor" type="text/plain" name="content" style="width:100%;height:400px;"></script>
      </div>
    </div>
    <div class="row cl">
      <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-2">
        <button  class="btn btn-secondary radius" type="submit"><i class="Hui-iconfont">&#xe632;</i> 保存</button>
        <button onClick="removeIframe();" class="btn btn-default radius" type="button">&nbsp;&nbsp;取消&nbsp;&nbsp;</button>
      </div>
    </div>
  </form>
</article>

<!--header-->
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


<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="__STATIC__/hadmin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="__STATIC__/hadmin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="__STATIC__/hadmin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript" src="__STATIC__/hadmin/lib/ueditor/1.4.3/ueditor.config.js"></script>
<script type="text/javascript" src="__STATIC__/hadmin/lib/ueditor/1.4.3/ueditor.all.min.js"> </script>
<script type="text/javascript" src="__STATIC__/hadmin/lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" src="__STATIC__/admin/uploadify/jquery.uploadify.min.js"></script>
<script type="text/javascript" src="__STATIC__/admin/js/image.js"></script>
<script type="text/javascript">
  $(function(){
    $('.skin-minimal input').iCheck({
      checkboxClass: 'icheckbox-blue',
      radioClass: 'iradio-blue',
      increaseArea: '20%'
    });

    //表单验证
    $("#form-singwaapp").validate({
      rules:{
        title:{
          required:true,
        },
        small_title:{
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
      onkeyup:false,
      focusCleanup:true,
      success:"valid",
      submitHandler:function(form){
        singwaapp_save(form);// 需要小伙伴自定义一个singwaapp_save方法 用来处理抛送请求的哦
      }
    });

    var ue = UE.getEditor('editor');

  });

</script>
<!--/请在上方写此页面业务相关的脚本-->

</body>
</html>