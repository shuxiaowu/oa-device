<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title>百恒开发者文档</title>
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<meta name="renderer" content="webkit" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link type="text/css" rel="stylesheet" href="{$base}/css/bootstrap.min.css">
<link type="text/css" rel="stylesheet" href="{$base}/css/common.css?v=2">
<link rel="shortcut icon" href="{$base}/images/favicon.ico" />
<script src="{$base}/js/jquery.min.js"></script>
<script src="{$base}/js/json.js"></script>
<body>
 <nav class="navbar navbar-inverse border-none" style="margin:0; padding:0;">
  <ul class="nav navbar-nav" style="width:100%; margin:0px auto; display:block;">
    <li style="width:238px; text-align:center; height:48px; overflow:hidden;"><a href="{:url('doc/index/index')}"><img src="{$base}/images/doclogo.png" style=" display:block; position:relative; top:-7px;"></a></li>
    <li <if condition="$mark eq 'index'">class="active"</if>><a href="{:url('doc/index/index')}">API文档</a></li>
    <li <if condition="$mark eq 'download'">class="active"</if>><a href="{:url('doc/index/download')}">版本下载</a></li>
    <li <if condition="$mark eq 'record'">class="active"</if>><a href="{:url('doc/index/record')}">调试记录</a></li>
    <li <if condition="$mark eq 'json'">class="active"</if>><a href="javascript:void(0)" class="dejson">JSON解析</a><span class="ibadge"></span></li>
    <li class="pull-right"><a href="https://www.jxbh.cn?act=bhoadoc" target="_blank">官网</a></li>
    <li class="pull-right"><a href="{:url('doc/index/logout')}">退出授权</a></li>
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
 <block name="main"></block>

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
