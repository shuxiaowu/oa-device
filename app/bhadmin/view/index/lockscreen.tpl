<!DOCTYPE html>
<html>
<head>
 <meta charset="utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <meta name="description" content="{:config('devcompany')} {:config('admin_version')}">
 <meta name="keywords" content="{:config('devcompany')} {:config('admin_version')}">
 <meta name="author" content="jxbh">
 <title>{$title} - {:config('devcompany')}</title>
 <style>
  body{ font-size:12px;margin:0; padding:0;  background-size:cover; background:url('__img__/fourseasons/{$bg}') no-repeat center center;background-attachment:fixed;font-family:"微软雅黑"; }
  div,input{margin:0; padding:0;}
  .lockscreen{ width:480px; height:140px; position:fixed; top:50%; left:50%; margin-left:-240px; margin-top:-70px; background:rgba(0,0,0,.7); overflow:hidden; border-radius:180px;}
  .bhface{ width:120px; height:120px; background:rgba(0,0,0,.7) url('__img__/logo/locklogo.png') no-repeat center center; background-size:62%; border-radius:50%; border:solid 10px #1f292e; float:left; margin-right:20px; cursor:pointer; position:relative;}
  .mpass{ width:180px; height:32px; border:solid 1px #3e4142; background:rgba(0,0,0,.5); outline:none; padding-left:10px; color:#777;font-family:"微软雅黑"; border-radius:3px;}
  .lockscreen .h2{ font-size:14px; color:#fff; margin-top:15px;}
  .lockscreen .tips{ font-size:12px; color:#979898; line-height:20px;}
  .btn-login{ width:66px; height:32px; line-height:30px; border:solid 1px #3e4142; background:rgba(0,0,0,.5);cursor:pointer; color:#fafafa;font-family:"微软雅黑"; position:relative; top:2px; outline:none; border-radius:3px;}
  .bhlist-input{ position:relative;}
  .bhmark{ position:fixed; bottom:10px; right:10px; width:260px; height:20px; line-height:20px; text-align:right; color:#fff;text-shadow: -1px 1px 1px rgba(0, 0, 0, 0.9)}
 </style>
</head>
<body>
 <div class="bhmark">背景：{$scene}</div>
 <div class="lockscreen">
   <div class="bhface"></div>
   <div class="bhlist">
     <p class="h2">欢迎您回来，{$lockrealname} ！</p>
     <p class="tips">请您输入 {$lockrealname} 的登录密码验证。</p>
     <div class="bhlist-input">
       <input type="password" name="pass" placeholder="密码" class="mpass">
       <button class="btn-login" type="button">登 录</button>
     </div>
   </div>
 </div>
 <script type="text/javascript" src="__js__/jquery.min.js"></script>
 <script type="text/javascript">
   $(".btn-login").click(function(e) {
	 var user = '{$lockuser}';
     var pass = $.trim($(".mpass").val());
	 if ( pass == '' ) { $(".tips").css('color','#ecde2d').text('请输入您的登录密码'); return false; } 
	 var $this = $(this);
	 $this.text('验证中').attr('disabled',true);
	 $.post('{:url("index/ajaxlock")}',{'user':user,'pass':pass},function(data){
	   $this.text('登录').attr('disabled',false);
	   if ( data.state == 1) {
	     window.location.href = "{:url('index/index')}";
	   } else {
	     $(".tips").css('color','#ecde2d').text(data.msg); return false; 
	   }
	 },'json');
   });
   document.onkeydown = function(e) {
     var theEvent = e || window.event;
     var code = theEvent.keyCode || theEvent.which|| theEvent.charCode;
     if (code == 13) {
	   $(".btn-login").click();
	 }
   }
 </script>
</body>
</html>