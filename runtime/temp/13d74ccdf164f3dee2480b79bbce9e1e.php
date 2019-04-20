<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:66:"D:\phpStudy\PHPTutorial\WWW\oa-device/app/doc\view\index\index.tpl";i:1554799242;s:68:"D:\phpStudy\PHPTutorial\WWW\oa-device\app\doc\view\common\common.tpl";i:1554789926;s:69:"D:\phpStudy\PHPTutorial\WWW\oa-device\app\doc\view\common\sidebar.tpl";i:1554772962;s:63:"D:\phpStudy\PHPTutorial\WWW\oa-device\app\doc\view\api\base.tpl";i:1554773073;}*/ ?>
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
 
  ﻿<div class="sidebar pull-left">
  <div class="version">小程序版本：1.0.0</div>
  <dl>
    <dt><span></span>服务器（LOAC）</dt>
    <dd><a href="#loac">服务器地址</a></dd>
    <dd><a href="#xcxdoc">小程序开发文档 <font color="red">新</font></a></dd>
    <dd><a href="#safety">API接口安全</a></dd>
    <dd><a href="#retCode">错误码定义</a></dd>
    <dd><a href="#parameter">常用参数约定</a></dd>
    <dd><a href="#variable">全局变量</a></dd>
  </dl>
  <dl>
    <dt><span></span>服务器Token</dt>
    <dd><a href="#getAppid">获取appid和secret</a></dd>
    <dd><a href="#getToken">获取access_token</a></dd>
  </dl>
  <dl>
    <dt><span></span>图片上传</dt>
    <dd><a href="#uploadPic">图片上传</a></dd>
    <dd><a href="#uploadFormPic">表单图片上传 <font color="red">建议</font></a></dd>
  </dl>
  <dl>
    <dt><span></span>设备上报管理</dt>
    <dd><a href="#devreport">上报接口</a></dd>
  </dl>
</div>

  <div class="main">
    ﻿<h1><a id="docversion">文档版本</a></h1>
<div class="alert alert-info">
  <p>版本：v2.0</p>
  <p>更新：优化接口展现形式，新增调试功能，新增复制JSON功能,重写文档结构.新增JSON解析数据功能，新增模拟接口发送功能！</p>
</div>
<h1><a id="apiauthor">文档修订</a></h1>
  <table class="table table-bordered table-hover" style="margin:0px auto 0px auto;">
    <tr>
      <th align="left">版本</th>
      <th align="left">版本说明</th>
      <th align="left">修订人</th>
      <th align="left">修订时间</th>
      <th align="left">修订日志</th>
    </tr>
    <tr>
      <td align="left">1.0.0</td>
      <td align="left">初次版本</td>
      <td align="left">百恒网络</td>
      <td align="left">2018-12-20</td>
      <td align="left"><a href="javascript:void(0)">查看</a></td>
    </tr>
  </table>
<h1><a id="loac">服务器地址</a></h1>
<blockquote class="success">
  <div class="alert alert-info">
    <dd>测试环境：<?php echo $loacUrl; ?></dd>
    <dd>生产环境：<?php echo $onlineUrl; ?></dd>
    <dd>接口地址：<?php echo $loacUrl; ?>api/</dd>
    <dd>图片地址：<?php echo $loacUrl; ?>uploads/images/</dd>
    <dd>文件地址：<?php echo $loacUrl; ?>uploads/files/</dd>
  </div>
</blockquote>

<h1><a id="safety">API接口默认TOKEN</a></h1>
<blockquote class="info">
  <div class="alert alert-info">
    <dd>苹　果：<?php echo $appid['ios']; ?></dd>
    <dd>安　卓：<?php echo $appid['android']; ?></dd>
    <dd>前　端：<?php echo $appid['web']; ?></dd>
  </div>
</blockquote>
<h1><a id="retCode">错误码定义</a></h1>
<blockquote class="success">
  <div class="alert alert-info">
    <dd>请求成功 JSON 格式</dd>
    <pre>{"data":"","success":1,"msg":"",'retCode'=>'200'}</pre>
    <dd>请求失败 JSON 格式</dd>
    <pre>{"data":"","success":0,"msg":"错误原因",'retCode'=>'000'}</pre>
    <dd class="text-danger">PS1:错误码见下方</dd>
    <dd class="text-danger">PS2:错误码并不是唯一的，请在判断 success 的值为0的时候，就是请求错误的.retCode = 200 时候也是检测成功的.</dd>
  </div>
  <table class="table table-bordered table-hover" style="margin:10px auto 0px auto;">
    <tr>
      <td width="150" align="left">错误码</td>
      <td width="300" align="left">错误说明</td>
      <td class="left">错误原因及解决方案</td>
    </tr>
    <tr>
      <td align="left">-1</td>
      <td align="left">系统繁忙，请稍后再试</td>
      <td class="left"></td>
    </tr>
    <tr>
      <td align="left">-2</td>
      <td align="left">API接口无效或者失效</td>
      <td class="left"></td>
    </tr>
    <tr class="success">
      <td align="left">200</td>
      <td align="left">参数请求成功</td>
      <td class="left"></td>
    </tr>
    <tr>
      <td align="left">40001</td>
      <td align="left">非法的请求Id或者请求Id为空</td>
      <td class="left">见 <a href="#getAppid">API接口安全。</a></td>
    </tr>
    <tr>
      <td align="left">40002</td>
      <td align="left">请求的数据参数无效。</td>
      <td class="left">未传必传的参数</td>
    </tr>
    <tr>
      <td align="left">40003</td>
      <td align="left">请求方式无效</td>
      <td class="left">接口的参数必须是POST 方式传递，GET无效。</td>
    </tr>
    <tr>
      <td align="left">40004</td>
      <td align="left">接口请求错误</td>
      <td class="left">此条错误Code请后端在封装接口调用方法的时候自行封装，防止程序报错。<span class="badge badge-danger">new</span></td>
    </tr>    
    <tr>
      <td align="left">40005</td>
      <td align="left">TOKEN验证失败</td>
      <td class="left">TOKEN验证失败.请重新提交新的Token <span class="badge badge-danger">new</span></td>
    </tr
    ><tr>
      <td align="left">400031</td>
      <td align="left">请求方式无效</td>
      <td class="left">接口的参数必须是GET 方式传递，POST无效。</td>
    </tr>
    <tr>
      <td align="left">400034</td>
      <td align="left">未开放的接口</td>
      <td class="left">未开放的接口，暂无权限访问，请提升您的访问等级。</td>
    </tr>
    <tr>
      <td align="left">400035</td>
      <td align="left">条件下暂无任何数据。</td>
      <td class="left">条件下暂无任何数据。</td>
    </tr>
  </table>
</blockquote>
<h1><a id="parameter">常用参数约定</a></h1>
<div class="alert alert-info">
 <p>参数命名规则：场景 google 翻译取短语，为了参数速记及长度控制 建议每个参数及方法不得超过10英文字符</p> 
 <p>v3.0版本参数命名优先纯小写，文档修订人在修订文档时候尽量备注各种参数的用法，类型，及备注.</p>
</div>
<blockquote class="success">
  <table class="table table-bordered table-hover" style="margin:10px auto;">
    <tr>
      <th width="150" align="left">参数名</th>
      <th align="left">参数值</th>
    </tr>
    <tr>
      <td align="left">分页值</td>
      <td align="left"> pagesize </td>
    </tr>
    <tr>
      <td align="left">id值</td>
      <td align="left"> id </td>
    </tr>
    <tr>
      <td align="left">分页索引值</td>
      <td align="left"> index </td>
    </tr>
    <tr>
      <td align="left">会员Id</td>
      <td align="left"> userid </td>
    </tr>
    <tr>
      <td align="left">时间</td>
      <td align="left">date time day month</td>
    </tr>
    <tr>
      <td align="left">状态</td>
      <td align="left">status paystatus</td>
    </tr>
    <tr>
      <td align="left">链接</td>
      <td align="left"> url </td>
    </tr>
    <tr>
      <td align="left">标题</td>
      <td align="left"> topic </td>
    </tr>
    <tr>
      <td align="left">备注</td>
      <td align="left"> remark </td>
    </tr>
    <tr>
      <td align="left">内容</td>
      <td align="left"> content </td>
    </tr>
    <tr>
      <td align="left">图片</td>
      <td align="left"> pic </td>
    </tr>
  </table>
</blockquote>
<h1><a id="variable">全局变量</a></h1>
<blockquote class="success">
  <table class="table table-bordered table-hover" style="margin:10px auto;">
    <tr>
      <th>参数名</th>
      <th>参数类型</th>
      <th>必传</th>
      <th>默认值</th>
      <th>描述</th>
    </tr>
    <tr>
      <td>token</td>
      <td>String</td>
      <td><span style="color:green">Y<span></span></span></td>
      <td></td>
      <td>获取参数必传 token值。可带header传送</td>
    </tr>
    <tr>
      <td>sleep</td>
      <td>INT</td>
      <td><span style="color:red">N<span></span></span></td>
      <td>范围(1-10)</td>
      <td>系统延时的值，默认不延时，若想测试获取接口参数速度响应，可传此值 单位为秒</td>
    </tr>
    <tr>
      <td>debug</td>
      <td>INT</td>
      <td><span style="color:red">N<span></span></span></td>
      <td>1</td>
      <td> debug值 1会返回 短信验证码 0不会返回！ </td>
    </tr>
    <tr>
      <td>version</td>
      <td>String</td>
      <td><span style="color:red">N<span></span></span></td>
      <td>1.0.0</td>
      <td>接口版本 默认1.0.0 <font color="red">news</font> 可带header传送.</td>
    </tr>
  </table>
</blockquote>
<h1><a id="getAppid">获取Appid和sceret的值</a></h1>
<blockquote class="success">
  <table class="table table-bordered table-hover" style="margin:10px auto;">
    <tr>
      <th width="100">身份</th>
      <th width="130">appid</th>
      <th width="320">secret</th>
      <th>状态</th>
    </tr>
    <?php if(is_array($tlist) || $tlist instanceof \think\Collection || $tlist instanceof \think\Paginator): $i = 0; $__LIST__ = $tlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tobj): $mod = ($i % 2 );++$i;
         $secret   = $tobj['secret'];
         $mdsecret = substr($secret,0,2).'***'.substr($secret,30,2);
       ?>
      <tr>
        <td><?php echo $tobj['type']; ?></td>
        <td><?php echo $tobj['appid']; ?></td>
        <td><a href="javascript:void(0)" class="showsecret" data-secret="<?php echo $secret; ?>" title="点击查看完整 secret"><?php echo $mdsecret; ?></a></td>
        <td><?php if($tobj['enabled'] == 1): ?><font color="green">正常</font><?php else: ?><font color="red">禁用</font><?php endif; ?></td>
      </tr>
    <?php endforeach; endif; else: echo "" ;endif; ?>
  </table>
</blockquote>
<h1><a id="getToken">获取服务器TOKEN值</a></h1>
<blockquote class="success">
  <div class="alert alert-info" style="margin-bottom:15px;">
    <dd><kbd class="method">GET</kbd> 调用地址：<?php echo $loacUrl; ?>api/token/gettoken</dd>
  </div>
  <table class="table table-bordered table-hover" style="margin:10px auto;">
    <tr>
      <th>参数名</th>
      <th>参数类型</th>
      <th>必传</th>
      <th>默认值</th>
      <th>描述</th>
    </tr>
    <tr>
      <td>appid</td>
      <td>String</td>
      <td><span style="color:green">Y<span></span></span></td>
      <td></td>
      <td>用户唯一凭证</td>
    </tr>
    <tr>
      <td>secret</td>
      <td>String</td>
      <td><span style="color:green">Y<span></span></span></td>
      <td></td>
      <td>唯一凭证密钥，即appsecret</td>
    </tr>
  </table>
  <h6>返回值</h6>
  <pre style="height:auto;">
{
  "token": "TOKEN",
  "expires_in": 7200,
  "success": 1,
  "retCode": 200,
  "msg": ""
}<span class="pre-copy" data-cdata='{"token": "TOKEN","expires_in": 7200,"success": 1,"retCode": 200,"msg": ""}'>复制</span></pre>
  <h6>参数解析</h6>
  <table class="table table-bordered table-hover" style="margin:10px auto;">
    <tr>
      <th>参数名</th>
      <th>描述</th>
    </tr>
    <tr>
      <td>token</td>
      <td>获取到的凭证</td>
    </tr>
    <tr>
      <td>expires_in</td>
      <td>凭证有效时间，单位：秒</td>
    </tr>
  </table>
</blockquote>
<h1><a id="uploadPic">图片上传</a></h1>
<blockquote class="success">
  <div class="alert alert-info" style="margin-bottom:15px;">
    <dd><kbd class="method">POST</kbd> 调用地址：<?php echo $loacUrl; ?>api/upload/uploadPic</dd>
  </div>
  <table class="table table-bordered table-hover" style="margin:10px auto;">
    <tr>
      <th>参数名</th>
      <th>参数类型</th>
      <th>必传</th>
      <th>默认值</th>
      <th>描述</th>
    </tr>
    <tr>
      <td>pic</td>
      <td>String</td>
      <td><span style="color:green">Y<span></span></span></td>
      <td></td>
      <td>图片二进制格式 多张用 # 隔开</td>
    </tr>
  </table>
  <h6>返回值</h6>
  <pre style="height:auto;">
{
  "data": { <font color="red"></font>
    "pic": "20170822/314b9ca0af8.png,20170822/314b9ca0af8249b.png" <font color="red">返回上传成功的路径名 ，多张返回用,隔开</font>
  },
  "success": 1,
  "msg": "",
  "retCode": 200
}<span class="pre-copy" data-cdata='{"data": {"pic": "20170822/314b9ca0af8249b6.png,20170822/314b9ca0af8249b2.png"},"success": 1,"msg": "","retCode": 200}'>复制</span></pre>
</blockquote>
<h1><a id="uploadFormPic">表单图片上传</a></h1>
<blockquote class="success">
  <div class="alert alert-info" style="margin-bottom:15px;">
    <dd><kbd class="method">POST</kbd> 调用地址：<?php echo $loacUrl; ?>api/upload/uploadFormPic</dd>
  </div>
  <table class="table table-bordered table-hover" style="margin:10px auto;">
    <tr>
      <th>参数名</th>
      <th>参数类型</th>
      <th>必传</th>
      <th>默认值</th>
      <th>描述</th>
    </tr>
    <tr>
      <td>file</td>
      <td>FILE</td>
      <td><span style="color:green">Y<span></span></span></td>
      <td></td>
      <td>文件对象</td>
    </tr>
  </table>
  <h6>返回值</h6>
  <pre style="height:auto;">
{
  "data": {
      "pic": "20170822/314b9ca0af8249b6.png"
  },
  "success": 1,
  "msg": "",
  "retCode": 200
}<span class="pre-copy" data-cdata='{"data": {"pic": "20170822/314b9ca0af8249b6.png"},"success": 1,"msg": "","retCode": 200}'>复制</span></pre>
</blockquote>

	
<h1><a id="devreport">盘点上报接口</a></h1>
<blockquote class="success">
  <div class="alert alert-info" style="margin-bottom:15px;">
    <dd><kbd class="method">GET</kbd> 调用地址：<?php echo $loacUrl; ?>api/device/report</dd>
  </div>
  <table class="table table-bordered table-hover" style="margin:10px auto;">
    <tr>
      <th>参数名</th>
      <th>参数类型</th>
      <th>必传</th>
      <th>默认值</th>
      <th>描述</th>
    </tr>
    <tr>
      <td>devno</td>
      <td>String</td>
      <td><span style="color:green">Y<span></span></span></td>
      <td></td>
      <td>设备编号</td>
    </tr>
    <tr>
      <td>sn</td>
      <td>String</td>
      <td><span style="color:green">Y<span></span></span></td>
      <td></td>
      <td>盘点单号</td>
    </tr>
  </table>
  <h6>返回值</h6>
  <pre style="height:auto;">
{
  "success": 1,
  "retCode": 200,
  "msg": ""
}</pre>
</blockquote>
   
  </div>
  
  <div class="modal fade" role="dialog" id="copymodal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title">复制数据</h4></div>
        <div class="modal-body"><textarea class="form-control copyhtml" style="height:300px; border-radius:0;"></textarea></div>
      </div>
    </div>
  </div>

  <script src="<?php echo $base; ?>/js/bootstrap.min.js" type="text/javascript"></script> 
  <script type="text/javascript">
  $(".pre-open").click(function(e) {
    if ( $(this).parent().height() <= 119 ) {
	  $(this).parent().height('auto'); 
	  $(this).text('收起');
	} else {
	  $(this).parent().height(119); 
	  $(this).text('展开');
	}
  });
  window.onload = function () {(window.onresize = function () {
	var width = document.documentElement.clientWidth - 242 - 40;
	var height = document.documentElement.clientHeight - $(".navbar").height() - 2;
    $(".sidebar,.main").height(height);
    $(".main").width(width);
  })()};
  
  $(".sidebar dd").click(function(e) {
	$(".sidebar dd a").css({'background':'#fff','color':'#666'})
    $(this).find('a').css({'background':'#f0faff','color':"#2d8cf0"});
  });
  
  $(".sidebar dl dt").click(function(e) {
	var h = $(this).parent().height();
	h = parseInt(h);
    if ( h <= 30 ) {
	  $(this).parent().find('.mybadge').remove('*');
	  $(this).parent().height('auto');
	} else {
	  len = $(this).parent().find("dd").length;
	  $(this).parent().find("dt").append('<font class="mybadge">'+len+'</font>') ;
	  $(this).parent().height(30);
	}
  });
  
  $("blockquote").each(function(index, element) {
	$(this).removeClass('info');
	$(this).removeClass('success');
    if ( (index+1)%2 ) {
	  $(this).addClass("info");
	} else {
	  $(this).addClass('success');
	}
  });
  
  //刷新到锚地
  var href  = window.location.href;
  var markA = href.split("#");
  var mark  = markA[markA.length-1];
  var ckid  = '';
  $(".sidebar dd").each(function(index, element) {
	 if ( $(this).find("a").attr('href') == '#'+mark ) {
	   setTimeout(function(){ window.location.href = '?#'+mark; },100);
	   ckid = $(this); 
	 }   
  });

  $(".s-hide").each(function(index, element) {
    $(this).height(30);
	len = $(this).find("dd").length;
	$(this).find("dt").append('<font class="mybadge">'+len+'</font>');
  });
  
  if ( ckid !='' ) {
    var h = parseInt(ckid.parent().height());
    if ( h <= 30 ) {
	  ckid.parent().find('.mybadge').remove('*');
	  ckid.parent().height('auto');
    }
    ckid.find('a').css({'background':'#f0faff','color':"#2d8cf0"});
  }
  
  $(".pre-copy").click(function(e) {
    var data = JSON.stringify($(this).data('cdata'));
	if ( data!='' ) {
	  $(".copyhtml").val(data);
	  $("#copymodal").modal('show');
	}  
  });
  
  $(".showsecret").click(function(e) {
     $(this).text($(this).data('secret')); 
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
