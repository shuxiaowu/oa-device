<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:65:"D:\phpStudy\PHPTutorial\WWW\oa-device/app/doc\view\auth\index.tpl";i:1555332621;s:68:"D:\phpStudy\PHPTutorial\WWW\oa-device\app\doc\view\common\common.tpl";i:1554789926;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title>百恒开发者文档</title>
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<meta name="renderer" content="webkit" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link type="text/css" rel="stylesheet" href="<?php echo $base; ?>/css/bootstrap.min.css">
<link type="text/css" rel="stylesheet" href="<?php echo $base; ?>/css/common.css?v=2">
<link rel="shortcut icon" href="<?php echo $base; ?>/images/favicon.ico" />
<script src="<?php echo $base; ?>/js/jquery.min.js"></script>
<script src="<?php echo $base; ?>/js/json.js"></script>
<body>
 <nav class="navbar navbar-inverse border-none" style="margin:0; padding:0;">
  <ul class="nav navbar-nav" style="width:100%; margin:0px auto; display:block;">
    <li style="width:238px; text-align:center; height:48px; overflow:hidden;"><a href="<?php echo url('doc/index/index'); ?>"><img src="<?php echo $base; ?>/images/doclogo.png" style=" display:block; position:relative; top:-7px;"></a></li>
    <li <?php if($mark == 'index'): ?>class="active"<?php endif; ?>><a href="<?php echo url('doc/index/index'); ?>">API文档</a></li>
    <li <?php if($mark == 'download'): ?>class="active"<?php endif; ?>><a href="<?php echo url('doc/index/download'); ?>">版本下载</a></li>
    <li <?php if($mark == 'record'): ?>class="active"<?php endif; ?>><a href="<?php echo url('doc/index/record'); ?>">调试记录</a></li>
    <li <?php if($mark == 'json'): ?>class="active"<?php endif; ?>><a href="javascript:void(0)" class="dejson">JSON解析</a><span class="ibadge"></span></li>
    <li class="pull-right"><a href="https://www.jxbh.cn?act=bhoadoc" target="_blank">官网</a></li>
    <li class="pull-right"><a href="<?php echo url('doc/index/logout'); ?>">退出授权</a></li>
  </ul>
 </nav>
 <div class="jsonmask">&nbsp;</div>
 <div class="jsondiv">
   <div class="jsondiv-title">JSON解析 <span class="jsonclose">&times;</span></div>
   <div class="jsondiv-tips">注释：请复制Json数据到下面的文本域里面，如果此功能无法满足您的需求，您可以<a href="http://www.bejson.com/" target="_blank">点击此处处理！</a></div>
   <div class="jsondiv-main">
     <textarea class="jsonarea" name="jsonarea" placeholder="JSON数据"></textarea>
     <div class="jsonright" id="jsonarea"><div class="json-error">待提交JSON数据.</div></div>
   </div>
   <div class="btn-group" style=" float:right; margin:10px 10px 0 0;">
     <button class="btn btn-default btn-dw" style="background-color:#19be6b; color:#fff; border:solid 1px #19be6b;">解析JSON</button>
     <button class="btn btn-default btn-clean">清空数据</button>
     <button class="btn btn-default jsonclose">关闭</button>
   </div>
 </div>
 
<style>
nav{ display:none;}
.ui-mask img{
  filter: url(blur.svg#blur);
  -webkit-filter: blur(6px);
     -moz-filter: blur(6px);
      -ms-filter: blur(6px);    
          filter: blur(6px);
    filter: progid:DXImageTransform.Microsoft.Blur(PixelRadius=6, MakeShadow=false);
}
</style>
<div class="ui-mask">
 <img src="<?php echo $base; ?>/images/mask.png" width="100%">
</div>
  <div class="modal fade" tabindex="-1" id="login" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" style="font-size:15px;">输入文档授权码</h4>
        </div>
        <div class="modal-body">
          <div class="alert alert-danger" style="margin:0 0 10px auto; display:none;">请输入</div>
          <div class="form-group">
            <label for="recipient-name" class="control-label" style="margin:10px auto; font-size:14px;">授权码 <font color="#999999" style="font-weight:normal; font-size:12px;">向管理员索取</font></label>
            <input type="password" class="form-control" id="autocode" placeholder="请输入授权码" style="font-size:12px;">
         </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info btn-auth">确定授权</button>
        </div>
      </div>
    </div>
  </div>
<script src="<?php echo $base; ?>/js/bootstrap.min.js" type="text/javascript"></script> 
<script>
  $("#login").modal('show');
  $(".btn-auth").click(function(e) {
    var autocode = $("#autocode").val();
	if ( autocode == '' ) {
	  $(".alert-danger").show().text('请输入授权码？');
	  setTimeout(function(){ $('.alert-danger').hide() },2000);
	} else {
	  $.post('<?php echo url("doc/auth/ajaxauth"); ?>',{'code':autocode},function(data){
	    if ( data.state == 1 ) {
		  window.location.href = '<?php echo url("doc/index/index"); ?>';
		} else {
		  $(".alert-danger").show().text(data.msg);
		  setTimeout(function(){ $('.alert-danger').hide() },2000);
		}
	  },'json');
	} 
  });
  
  $('.ui-mask').click(function(e) {
  	 $("#login").modal('show');  
  });
  
</script>


</body>

<script>
  $('.btn-clean').click(function(e) {
  	 $('.jsonarea').val('');
	 $("#jsonarea").html('<div class="json-error">待提交JSON数据.</div>');  
  });
  $('.jsonmask,.jsonclose').click(function(e) {
     $('.jsonmask,.jsondiv').fadeOut(100);
  });
  $('.dejson').click(function(e) {
  	 $('.jsonmask,.jsondiv').fadeIn(200);
  });
  $('.btn-dw').click(function(e) {
  	 var msg = $.trim($('.jsonarea').val());
	 if ( msg == '' ) return false;
  	 try {
	   var msg = eval('(' + msg + ')');
	 } catch (error) {
	   $("#jsonarea").html('<div class="json-error">'+error+'</div>');return false;
	 }
	 var options = {collapsed : false,withQuotes: false};
 	 $('#jsonarea').jsonViewer(msg, options);
  });
</script>

</html>
