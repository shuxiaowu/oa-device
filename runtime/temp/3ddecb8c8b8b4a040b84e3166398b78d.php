<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:65:"D:\phpStudy\PHPTutorial\WWW\oa-device/app/doc\view\index\tool.tpl";i:1544581124;s:68:"D:\phpStudy\PHPTutorial\WWW\oa-device\app\doc\view\common\common.tpl";i:1554789926;}*/ ?>
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
 .cs-plus{color:#333; position:relative; top:7px; font-size:12px;}
 .cs-minus{ color:red; position:relative; top:7px; font-size:12px;}
 .cs-minus:hover{ text-decoration:underline;color:red;}
 .csline,.headline{height:auto; overflow:hidden; padding:5px 0;}
 .form-control{font-size:13px;height:100%;border-radius:0;box-shadow:none;border:1px solid #e9e9e9;transition-duration:.5s}
 .form-control:focus{border-color:#42a5f5;box-shadow:none;transition-duration:.5s}
 .form-control:focus-feedback{z-index:10}
 .form-control{ height:30px !important; float:left; margin:0 5px 0 0;font-size:12px !important; border:solid 1px #ddd; border-radius:1px;}
</style>
<div class="sidebar pull-left">
  <div class="version">在线调试 <font color="red">new</font></div>
  <dl>
    <dt><span></span>选择身份查询</dt>
    <?php if(is_array($tdata) || $tdata instanceof \think\Collection || $tdata instanceof \think\Paginator): $i = 0; $__LIST__ = $tdata;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tobj): $mod = ($i % 2 );++$i;?>
      <dd><a href="<?php echo url('doc/index/record','type='.$tobj['type']); ?>"><?php echo $tobj['remark']; ?></a></dd>
    <?php endforeach; endif; else: echo "" ;endif; ?>
    <dt><span></span>在线调试</dt>
    <dd><a href="<?php echo url('doc/index/tool'); ?>" class="active">在线调试</a></dd>
  </dl>
</div>
<div class="main" style="min-height:700px;">
 <div class="alert alert-info" style="margin:10px auto;">接口在线调试</div>
 <form name="tookform" method="post" action="" onSubmit="return cktool(document.tookform)">
    
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table table-bordered" style="margin:15px auto 0px auto">
      <tr>
        <td height="30" align="left" valign="middle" colspan="2">
          <select class="form-control method" name="methods" style="width:110px; float:left; background-color:#f2f2f2">
            <option value="POST" <?php if($methods and $methods == 'POST'): ?>selected<?php endif; ?>>POST</option>
            <option value="GET" <?php if($methods and $methods == 'GET'): ?>selected<?php endif; ?>>GET</option>
          </select>
          <input type="text" placeholder="http://" value="<?php echo !empty($url)?$url:''; ?>" class="form-control" name="url" style="width:460px; float:left; background-color:#f2f2f2; color:#666;">
          <button class="btn btn-info send" type="submit" style="height:30px;">发送请求</button>
        </td>
      </tr>
      <tr>
        <td width="120" height="30" align="left" valign="middle">参数名称</td>
        <td height="30" align="left" valign="middle">参数值</td>
      </tr>
      <tr>
        <td height="30" align="left" valign="middle" colspan="2">
         <div class="csdiv">
           <?php if(!(empty($postdata) || (($postdata instanceof \think\Collection || $postdata instanceof \think\Paginator ) && $postdata->isEmpty()))): if(is_array($postdata) || $postdata instanceof \think\Collection || $postdata instanceof \think\Paginator): if( count($postdata)==0 ) : echo "" ;else: foreach($postdata as $k=>$ps): ?>
           <div class="csline">
            <input type="text" placeholder="参数名" value="<?php echo $k; ?>" class="form-control" name="csm[]" style="width:110px; float:left;">
            <input type="text" placeholder="参数值" value="<?php echo $ps; ?>" class="form-control" name="csz[]" style="width:460px; float:left;">
            <a href="javascript:void(0)" class="cs-plus">增加参数</a>
           </div>
           <?php endforeach; endif; else: echo "" ;endif; else: ?>
           <div class="csline">
            <input type="text" placeholder="参数名" value="" class="form-control" name="csm[]" style="width:110px; float:left;">
            <input type="text" placeholder="参数值" value="" class="form-control" name="csz[]" style="width:460px; float:left;">
            <a href="javascript:void(0)" class="cs-plus">增加参数</a>
           </div>
           <?php endif; ?>
           
           
         </div>
        </td>
      </tr>
    </table>
    <div style="height:10px;"></div>
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table table-bordered" style="margin:0 auto 10px auto">
      <tr>
        <td width="120" height="30" align="left" valign="middle">请求头参数名称</td>
        <td height="30" align="left" valign="middle">参数值 <font color="red">[GET参数传输无效]</font></td>
      </tr>
      <tr>
        <td height="30" align="left" valign="middle" colspan="2">
         <div class="headdiv">
           <?php if(!(empty($head) || (($head instanceof \think\Collection || $head instanceof \think\Paginator ) && $head->isEmpty()))): if(is_array($head) || $head instanceof \think\Collection || $head instanceof \think\Paginator): if( count($head)==0 ) : echo "" ;else: foreach($head as $h=>$he): ?>
           <div class="headline">
            <input type="text" placeholder="参数名" value="<?php echo $h; ?>" class="form-control" name="headcsm[]" style="width:110px; float:left;">
            <input type="text" placeholder="参数值" value="<?php echo $he; ?>" class="form-control" name="headcsz[]" style="width:460px; float:left;">
            <a href="javascript:void(0)" class="cs-plus">增加参数</a>
           </div>
           <?php endforeach; endif; else: echo "" ;endif; else: ?>
           <div class="headline">
            <input type="text" placeholder="参数名" value="" class="form-control" name="headcsm[]" style="width:110px; float:left;">
            <input type="text" placeholder="参数值" value="" class="form-control" name="headcsz[]" style="width:460px; float:left;">
            <a href="javascript:void(0)" class="cs-plus">增加参数</a>
           </div>
           <?php endif; ?>
         </div>
        </td>
      </tr>
    </table>
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table table-bordered">
      <tr>
        <td height="30" align="left" valign="middle">返回值</td>
      </tr>
      <tr>
        <td height="30" align="left" colspan="2" valign="middle">
        <div class="response-body">
         <?php if(!(empty($sheader) || (($sheader instanceof \think\Collection || $sheader instanceof \think\Paginator ) && $sheader->isEmpty()))): ?><h6>请求头：</h6><?php echo dump($sheader); endif; if($resjson != ''): ?><h6>Json：</h6><textarea class="form-control" style="min-height:60px; margin:0 auto 10px auto; background-color:#f2f2f2;"><?php echo $resjson; ?></textarea><?php endif; if($res != ''): ?><h6>渲染值：</h6><?php echo dump($res); endif; ?>
        </div>
        </td>
      </tr>
    </table>
   </form>
</div>
<script type="text/javascript">
  function cktool(td){
    if ( td.url.value == '' ) { alert('请求的链接为空'); return false; }
  }
  window.onload = function () {(window.onresize = function () {
	var width = document.documentElement.clientWidth - 240 - 42;
	var height = document.documentElement.clientHeight - $(".navbar").height() - 2;
    $(".sidebar,.main").height(height);
    $(".main").width(width);
  })()};
   $(".csdiv .cs-plus").click(function(e) {
	 var tpl = '<div class="csline"><input type="text" placeholder="参数名" value="" class="form-control" name="csm[]" style="width:110px; float:left;"><input type="text" placeholder="参数值" value="" class="form-control" name="csz[]" style="width:460px; float:left;"><a href="javascript:void(0)" class="cs-minus">删除参数</a></div>';
	 $('.csdiv').append(tpl);
   });
   $(".headdiv .cs-plus").click(function(e) {
	 var tpl = '<div class="headline"><input type="text" placeholder="参数名" value="" class="form-control" name="headcsm[]" style="width:110px; float:left;"><input type="text" placeholder="参数值" value="" class="form-control" name="headcsz[]" style="width:460px; float:left;"><a href="javascript:void(0)" class="cs-minus">删除参数</a></div>';
	 $('.headdiv').append(tpl);
   });
   $('body').on('click','.cs-minus',function(e){
	 $(this).parent().remove('*');
   });
   $(".csline .cs-plus").each(function(index, element) {
     if ( index > 0 ) $(this).removeClass('cs-plus').addClass('cs-minus').text('删除参数'); 
   });
   $(".headline .cs-plus").each(function(index, element) {
     if ( index > 0 ) $(this).removeClass('cs-plus').addClass('cs-minus').text('删除参数'); 
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
