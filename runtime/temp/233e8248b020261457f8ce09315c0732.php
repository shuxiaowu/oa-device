<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:67:"D:\phpStudy\PHPTutorial\WWW\oa-device/app/doc\view\index\record.tpl";i:1544746590;s:68:"D:\phpStudy\PHPTutorial\WWW\oa-device\app\doc\view\common\common.tpl";i:1554789926;}*/ ?>
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
 .form-control{font-size:13px;height:100%;border-radius:0;box-shadow:none;border:1px solid #e9e9e9;transition-duration:.5s}
 .form-control:focus{border-color:#42a5f5;box-shadow:none;transition-duration:.5s}
 .form-control:focus-feedback{z-index:10}
 .form-control{ height:30px !important; margin:0 5px 0 0;font-size:12px !important; border:solid 1px #ddd; border-radius:1px;}
</style>
  <div class="sidebar">
    <div class="version">接口调试记录</div>
    <dl>
      <dt><span></span>选择身份查询</dt>
      <?php if(is_array($tdata) || $tdata instanceof \think\Collection || $tdata instanceof \think\Paginator): $i = 0; $__LIST__ = $tdata;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tobj): $mod = ($i % 2 );++$i;?>
        <dd><a href="<?php echo url('doc/index/record','type='.$tobj['type']); ?>"><?php echo $tobj['remark']; ?></a></dd>
      <?php endforeach; endif; else: echo "" ;endif; ?>
      <dt><span></span>在线调试</dt>
        <dd><a href="<?php echo url('doc/index/tool'); ?>">在线调试 <font color="red">new</font></a></dd>
    </dl>
  </div>
  <div class="main" style="min-height:600px;">

        <?php if($type != ''): ?>
          <div class="alert alert-info" style="margin:10px auto; 0px auto;">身份：<?php echo $type; ?></div>
        <?php endif; ?>
        <form class="form-inline" method="get" style="margin:10px auto; font-size:13px;">
          <div class="form-group">
            <label>接口名称：</label>
            <input type="text" class="form-control" name="apiname" value="<?php echo $apiname; ?>" placeholder="">
          </div>
          <div class="form-group">
            <label>请求时间：</label>
            <input type="date" class="form-control" name="date" value="<?php echo $date; ?>" placeholder="日期格式(2017-07-15)">
          </div>
          <button type="submit" class="btn btn-success">查询</button>
        </form>
        <?php if($data != ''): ?>
          <table width="100%" class="table table-hover table-bordered" style="margin-bottom:0; padding:0; margin:0;">
            <tr class="active">
              <td width="60" align="center">序号</td>
              <td width="80" align="center">身份</td>
              <td>请求链接</td>
              <td width="160" align="center">请求日期</td>
              <td width="140" align="center">请求参数</td>
            </tr>
            <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$obj): $mod = ($i % 2 );++$i;?>
              <tr>
                <td align="center"><?php echo $pno+$i; ?></td>
                <td align="center"><?php echo $obj['apitype']; ?></td>
                <td><?php echo $obj['url']; ?></td>
                <td align="center"><?php echo date('Y-m-d H:i:s',$obj['date']); ?></td>
                <td align="center">
                 <button class="btn btn-xs btn-success btn-show" data-id="<?php echo $obj['Id']; ?>">查看</button>
                 <button class="btn btn-xs btn-info" onClick="window.location.href='<?php echo url("doc/index/tool","id=".$obj['Id']); ?>'">调试</button>
                </td>
              </tr>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <tr>
              <td align="center" colspan="5"><?php echo $pagelist; ?></td>
            </tr>
          </table>
        <?php else: endif; ?>
  </div>
  <div class="modal fade" tabindex="-1" id="showdata" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">查看请求参数</h4>
        </div>
        <div class="modal-body">
          <div class="modal-showdiv"> </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        </div>
      </div>
    </div>
  </div>
  <script src="<?php echo $base; ?>/js/bootstrap.min.js" type="text/javascript"></script> 
  <script type="text/javascript">
  $(".pre-open").click(function(e) {
    if ( $(this).parent().height() == 119 ) {
	  $(this).parent().height('auto'); 
	  $(this).text('收起');
	} else {
	  $(this).parent().height(119); 
	  $(this).text('展开');
	}
  });
  window.onload = function () {(window.onresize = function () {
	var width = document.documentElement.clientWidth - 240 - 42;
	var height = document.documentElement.clientHeight - $(".navbar").height() - 2;
    $(".sidebar,.main").height(height);
    $(".main").width(width);
  })()};
  
  $(".btn-show").click(function(e) {
    var $btn  = $(this).button('loading');
	var id    = $(this).data('id');
	var token = '<?php echo $token; ?>';
	if ( id ) {
	  $.post('<?php echo url("doc/index/ajaxrecord"); ?>',{'id':id,'token':token},function(data){
		$("#showdata").modal('show');
	    $btn.button('reset')  
	    if ( data.state == 1 ) {
		  $(".modal-showdiv").html(data.html);
		}
	  },'json');
	}
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
