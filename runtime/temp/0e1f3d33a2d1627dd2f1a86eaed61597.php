<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:69:"D:\phpStudy\PHPTutorial\WWW\oa-device/app/doc\view\index\download.tpl";i:1554772901;s:68:"D:\phpStudy\PHPTutorial\WWW\oa-device\app\doc\view\common\common.tpl";i:1554789926;}*/ ?>
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
   ::-webkit-scrollbar{width: 0px;}
   .navbar{ position:fixed; top:0; width:100%;}
  </style>
  <div style="height:50px;"></div>
  <div style="width:80%; height:auto; overflow:hidden; background-color:#fff; padding:20px; box-sizing:border-box; margin:20px auto;">
    <h2 style="font-size:16px; line-height:40px;">版本上架</h2>
  	<table class="table table-bordered table-hover" style="margin:10px auto;">
      <tr>
        <td width="140">版本名称</td>
        <td width="100" align="center">APP类型</td>
        <td width="100" align="center">是否上架</td>
        <td width="100" align="center">上架平台</td>
        <td width="100" align="center">上架时间</td>
        <td width="100" align="center">操作人</td>
        <td align="left">操作</td>
      </tr>
      <tr>
        <td>1.0.0</td>
        <td align="center">小程序</td>
        <td align="center"><font color="red">否</font></td>
        <td align="center">安卓</td>
        <td align="center">--</td>
        <td align="center">百恒</td>
        <td align="left"></td>
      </tr>
    </table>
   <p>注释：上架应用需要备份在说明中..安卓留需要在文档上备份安装包,命名规则：<font color="red">应用名称+版本号.APK</font>，安卓版本号说明.</p>
   <p></p>
   <h2 style="font-size:16px; line-height:40px; margin-top:15px;">素材备份</h2>
  	<table class="table table-bordered table-hover" style="margin:10px auto;">
      <tr>
        <td width="140">素材类型</td>
        <td width="100" align="center">操作</td>
        <td width="150" align="left">备注</td>
        <td align="left">路径</td>
      </tr>   
   </table>
   
   <h2 style="font-size:16px; line-height:40px; margin-top:15px;">上架资料</h2>
  	<table class="table table-bordered table-hover" style="margin:10px auto;">
      <tr class="active">
        <td width="140">资料名称</td>
        <td align="left">操作</td>
      </tr>
      <tr>
        <td>应用名称</td>
        <td align="left">手持扫码设备</td>
      </tr>
      <tr>
        <td>体验</td>
        <td align="left">
         
         <p class="tips">微信客户端6.5.7版本以上才可识别小程序码！</p>
        </td>
      </tr>
      <tr>
        <td>应用图标</td>
        <td align="left">
          
          <p class="tips">背景透明且带圆角，建议上传分辨率512px*512px（最低256px*256px）</p>
        </td>
      </tr>
      <tr>
        <td>应用截图</td>
        <td align="left">
          <p class="tips">支持jpg或png格式，不可上传iOS应用截图，分辨率请勿小于480*800或800*480</p>
        </td>
      </tr>      
      <tr>
        <td>搜索关键字</td>
        <td align="left"> </td>
      </tr>
      <tr>
        <td>一句话简介</td>
        <td align="left"> </td>
      </tr>
      <tr>
        <td>应用描述</td>
        <td align="left"></td>
      </tr>
      <tr>
        <td>新版特征</td>
        <td align="left"></td>
      </tr>
      <tr>
        <td>权限获取说明</td>
        <td align="left"></td>
      </tr>
      <tr>
        <td>电子版权信息</td>
        <td align="left"></td>
      </tr>
   </table>
   
   
  </div>


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
