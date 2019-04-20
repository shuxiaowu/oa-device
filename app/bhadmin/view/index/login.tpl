<!DOCTYPE html>
<html>
<head>
 <meta charset="utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <meta name="description" content="{:config('devcompany')}">
 <meta name="keywords" content="{:config('devcompany')}">
 <meta name="author" content="jxbh">
 <link rel="shortcut icon" href="__img__/favicon.ico" />
 <title>{:config('devcompany')}后台管理系统</title>
<style>
body{ font-size:12px;margin:0; padding:0;  background-size:cover; background:url('__img__/fourseasons/{$bg}') no-repeat center center;background-attachment:fixed;font-family:"微软雅黑"; }
div,input{margin:0; padding:0;-webkit-appearance: none;}
.gear{ width:166px; height:198px; background:url('__img__/gear-line.png') no-repeat center center; position:absolute; z-index:1; left:460px; top:80px; display:none;} 
.i-login{ width:auto; width:480px; height:380px; overflow:hidden; margin:0px auto; position:fixed; top:50%; left:50%; margin:-190px 0 0 -240px;font-family:"微软雅黑";}
.i-login .logo{ width:480px; height:71px; margin:0px auto 15px auto; cursor:pointer;}
.i-login .i-logindiv{ width:480px; height:auto; margin:0px auto; overflow:hidden; border-radius:0px;}
.i-login .i-btn-reg:hover{ color:#fff;}
.i-login .i-loginhead div.selected{ background:#fff; color:#444;}
.i-login .i-loginbody{ width:480px; height:295px; background:#fff; overflow:hidden;}
.i-login .i-user-div,.i-pass-div,.i-btn-div,.i-code-div{ width:420px; margin:0px auto;position:relative; overflow:hidden;}
.i-login .i-user-div{ margin:54px auto 0px auto;}
.i-login .i-user-div .i-user{ width:388px; height:32px; border:solid 1px #e9e9e9; padding:4px 15px; color:#999;}
.i-login .i-code-div .i-code{ width:388px; height:32px; border:solid 1px #e9e9e9; padding:4px 15px; color:#999;border-top:none;}
.i-login #code-verify{ position:absolute; right:2px; top:4px;}
.i-login .i-pass-div .i-pass{ width:388px; height:32px; border:solid 1px #e9e9e9; padding:4px 15px; color:#999; border-top:none;}
.i-login .i-btn-div{ margin:10px auto 0px auto;}
.i-login-btn{ width:420px; height:40px; line-height:40px; background:#38a0f4; color:#fff; text-align:center; border:none; cursor:pointer; font-size:16px;font-family:"微软雅黑"; }
.i-login .i-reg-btn:hover,.i-login-btn:hover{background:#42a5f5;}
.i-login .i-loginfoot{ width:420px;height:35px; text-align:right; margin:10px auto 0px auto; color:#999;}
.i-login .i-loginfoot a{ color:#999; margin:0 5px 0 5px; text-decoration:none;}
.i-login .i-loginfoot a:hover{ color:#333;}
.i-alert{ width:500px; height:40px; background:rgba(255,255,255,.9); position:fixed; top:0%; left:50%; margin-top:10px; margin-left:-250px; z-index:300; border-radius:0px; display:none; border-left:solid 2px #fa5b5b;}
.i-alert div.i-alert-body{ width:480px; height:40px; margin:0px auto; overflow:hidden; line-height:40px; text-align:left; color:#fa5b5b;}
.i-alert div.i-alert-body span{font-size:13px;}
.i-alert div.i-alert-body b{ font-weight:normal; float:right; margin-right:5px; cursor:pointer;}
.i-login input:focus{ outline:none; color:#191919;}
@media (max-width:500px){
 .i-alert{ width:98%; height:auto; position:fixed; top:0; left:1%; margin:10px auto 0px auto; overflow:hidden; z-index:999;}
 .i-alert div.i-alert-body{ width:95%; margin:0px auto;}
 .gear{ display:none;}
 .i-login{ width:95%; height:100%; overflow:hidden; position:fixed; top:15.5%; left:2.5%; margin:0;}
 .i-login .i-logindiv,.i-login .i-loginbody,.i-login .i-loginfoot{ width:100%;}
 .i-login .i-loginbody{ height:100%;}
 .i-login .logo{ width:100%; height:70px; margin:0;}
 .i-login .logo img{ height:60px;}
 .i-login .i-user-div{ margin:25px auto 0px auto;}
 .i-login .i-user-div,.i-pass-div,.i-btn-div,.i-code-div{ width:95%;}
 .i-btn-div{ border-radius:2px;}
 .i-login-btn{ width:100%;}
 .i-login .i-user-div .i-user,.i-login .i-code-div .i-code,.i-login .i-pass-div .i-pass{ width:90%;}
 .i-login #code-verify{ right:5px;}
 .i-loginfoot a{ margin-right:10px !important;}
}
.lockscreen{ width:480px; height:140px; position:fixed; top:50%; left:50%; margin-left:-240px; margin-top:-70px; background:rgba(0,0,0,.7); overflow:hidden; border-radius:180px;}
.bhface{ width:120px; height:120px; background:rgba(0,0,0,.6) url('__img__/logo/locklogo.png') no-repeat center center; background-size:80%; border-radius:50%; border:solid 10px #1f292e; float:left; margin-right:20px; cursor:pointer; position:relative;}
.lockscreen .h2{ font-size:16px; color:#fff; margin-top:22px;}
.lockscreen .tips{ font-size:12px; color:#fff; line-height:23px;}
.lockscreen .tips a{ color:#ecde2d; text-decoration:none;}
.bhmark{ position:fixed; bottom:10px; right:10px; width:260px; height:20px; line-height:20px; text-align:right; color:#fff;text-shadow: -1px 1px 1px rgba(0, 0, 0, 0.9)}
</style>
</head>
<body>
<div class="bhmark">背景：{$scene}</div>
<if condition="$data['adminpath'] eq ''">
 <form name="bhadmin" method="post" action="">
 <div class="i-login">
   <div class="logo"><img src="__img__/logo.png"></div>
   <div class="i-logindiv">    
     <div class="i-loginbody">
       <div class="i-user-div"><input type="text" value="" placeholder="用户名" class="i-user"></div>
       <div class="i-pass-div"><input type="password" value="" placeholder="密码" class="i-pass"></div>
       <div class="i-code-div"><input type="text" value="" placeholder="验证码" maxlength="4" class="i-code"><div id="code-verify"></div></div>
       <div class="i-btn-div"><div class="i-login-btn">登录</div> </div>
       <div class="i-loginfoot"> <a href="http://www.jxbh.cn" target="_blank">Powered by jxbh</a> </div>
     </div> 
   </div>
 </div>
 </form>
 <div class="i-alert">
  <div class="i-alert-body"><span class="alert-tips">我是提示</span> <b>&times;</b></div>
 </div>  
 <div class="gear"><img src="__img__/gear.png" class="gear-div"></div>
 <script type="text/javascript" src="__js__/jquery.min.js"></script>
 <script type="text/javascript">
  function gcode() {
	var files = "{:url('bhadmin/index/logincode','','')}";
    $('#code-verify').html('<img src="'+files+'/t/'+Math.random()+'" style="cursor:pointer;border:0;vertical-align:middle;margin:2px 0 0 1px;"/>');
  }
  gcode();
  $("#code-verify").click(function(e) {gcode();});
  angle = 0;
  f = setInterval(function(){
	angle+=3;
	$(".gear-div").css("transform", "rotate(" + (angle) + "deg)");
  },40);
  var l = parseInt(parseInt($(window).width()-745)/2)+20;
  var t = parseInt(parseInt($(window).height()-542)/2)-50;
  $(".gear").css({"top":t+'px','left':l+'px'}).fadeIn(500);
  window.onload = function () {(window.onresize = function () {
   var wl = parseInt(parseInt($(window).width()-745)/2)+20;
   var wt = parseInt(parseInt($(window).height()-542)/2)+0;
   $(".gear").css({"top":wt+'px','left':wl+'px'}).fadeIn(500);
  })()};
  $(".i-login-btn").click(function(e) {
    var user = $.trim($(".i-loginbody .i-user").val());
	var pass = $.trim($(".i-loginbody .i-pass").val());
	var code = $.trim($(".i-loginbody .i-code").val());
	if (user == '') {
	   $(".i-alert").show().find(".alert-tips").text('请输入您的用户名');setTimeout(function(){$(".i-alert").hide(80);},2000);
	   return false;
	}  
	if (pass.length < 6) {
	   $(".i-alert").show().find(".alert-tips").text('密码长度不够，请重新输入');setTimeout(function(){$(".i-alert").hide(80);},2000);
       return false;
	}
	if (code == '' || code.length<4) {
	   $(".i-alert").show().find(".alert-tips").text('验证码位数不够，请重新输入');setTimeout(function(){$(".i-alert").hide(80);},2000);
       return false;
	}
  
	$(".i-login-btn").val('登录中....');
    $.post( "{:url('bhadmin/index/checklogin')}", {'user':user,'pass':pass,'code':code},function(data){
	   $(".i-login-btn").val('登录');
	   var loginTips = '';
	   if ( data.state == 1 ) {
	     window.location.href = "{:url('bhadmin/index/index')}";
	   } else {
		 gcode();
	     $(".i-alert").show().find(".alert-tips").text(data.msg);
		 setTimeout(function(){$(".i-alert").hide(80);},2000);
	   }
    },'json');
  }); 
  $(".i-alert b").click(function(e) {
     $(".i-alert").hide(80);  
  });
  document.onkeydown = function(e) {
    var theEvent = e || window.event;
    var code = theEvent.keyCode || theEvent.which|| theEvent.charCode;
    if (code == 13) {
	  $(".i-login-btn").click();
	}
  }
 </script>
 <else/>
   <div class="lockscreen">
     <div class="bhface"></div>
     <div class="bhlist">
       <p class="h2">{:config('devcompany')}提醒您！</p>
       <p class="tips">您已经设置了后台目录保护，该登录链接已经失效。</p>
       <p class="tips">点击<a href="{:url('home/index/index')}">链接</a>跳转到首页吧。</p>
     </div>
   </div>
 </if> 
</body>
</html>