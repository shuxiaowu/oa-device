<extend name="public/common" />
<block name="main">
 <div class="pubmain">
  <div class="panel-body">
  <div class="btn-group">
   {:btn(array('vals'=>'系统设置','size'=>3,'icon'=>'cog','scene'=>'default','round'=>1,'url'=>url('system/sysmod')))}
   {:btn(array('vals'=>'公司设置','size'=>3,'icon'=>'map-marker','scene'=>'default','url'=>url('system/syscompany')))}
   {:btn(array('vals'=>'水印设置','size'=>3,'icon'=>'tint','scene'=>'default','url'=>url('system/syswater')))}
   {:btn(array('vals'=>'上传设置','size'=>3,'icon'=>'paperclip','scene'=>'default','url'=>url('system/sysupload')))}
   {:btn(array('vals'=>'后台目录设置','size'=>3,'icon'=>'folder-open','scene'=>'default','url'=>url('system/sysadmin')))}
   {:btn(array('vals'=>'IP过滤设置','size'=>3,'icon'=>'cog','scene'=>'default','url'=>url('system/ipfilter')))}
   {:btn(array('vals'=>'短信设置','size'=>3,'faicon'=>'commenting','scene'=>'primary','url'=>url('system/sysmsg')))}
   {:btn(array('vals'=>'微信设置','size'=>3,'faicon'=>'weixin','scene'=>'default','url'=>url('system/sysweixin')))}
  </div>
   <div class="alert alert-primary" style="margin:10px auto 10px auto">账户检测：<span>{$msgtips}</span>，登录<a href="http://web.jianzhou.sh.cn:8080/WebSMP/" target="_blank" style="color:#f00;">建周短信平台</a>查看详细短信信息！</div>
   
   <form name="sysmod" method="post" action="">
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="{:tabstyle()}">
      <tr>
        <td width="10%" height="30" align="left" valign="middle">参数说明</td>
        <td height="30" align="left" valign="middle">参数值</td>
      </tr>
      <tr>
        <td height="25" align="left" valign="middle">您的账号</td>
        <td height="25" align="left" valign="middle">{:inputs(array('icon'=>'user','width'=>25,'place'=>'您的账号','name'=>'msguser','val'=>$data['msguser'],'tips'=>'输入短信账号'))}</td>
      </tr>
      <tr>
        <td height="25" align="left" valign="middle">账号密码</td>
        <td height="25" align="left" valign="middle">{:inputs(array('faicon'=>'unlock','type'=>'password','width'=>25,'place'=>'账号密码','name'=>'msgpass','val'=>$data['msgpass'],'tips'=>'输入短信密码'))}</td>
      </tr>
      <tr>
        <td height="25" align="left" valign="middle">短信尾巴<br/>说明：出现在短信尾部<br/>例如：百恒网络</td>
        <td height="25" align="left" valign="middle">{:inputs(array('faicon'=>'commenting','width'=>25,'place'=>'短信尾巴','name'=>'msgsuff','val'=>$data['msgsuff'],'tips'=>'输入短信尾巴，出现在短信尾部'))}</td>
      </tr>
      <tr>
        <td height="25" align="left" valign="middle">短信设置测试<br/><span class="full999" style="font-size:11px;">请填写接受测试的手机号码</span> </td>
        <td height="25" align="left" valign="middle">
         <input type="text" value="" name="phonetest" class="text phonetest" style="width:220px" />&nbsp;&nbsp;&nbsp;
         <?php echo '<a href="javascript:void(0)" class="sendphone">'.btn(array('vals'=>'发送测试短信','faicon'=>'commenting','scene'=>'primary','tips'=>'点击发送系统测试短信，检测短信服务器是否调试正常')).'</a>';?>
        </td>
      </tr>
      <tr>
        <td height="25" align="left" valign="middle"></td>
        <td height="35" align="left" valign="middle">{:btn(array('vals'=>'确定保存','size'=>3,'type'=>'submit','icon'=>'cog','scene'=>'primary'))}</td>
      </tr>
    </table>
   </form>
  </div>
 </div>
 <script type="text/javascript">
  $(".sendphone").click(function(e) {
    var phone = $.trim($(".phonetest").val());
	if(phone==''){
	  swal('请填写接受测试的手机号码','','error');
	  return false;
	}else{
	  var phonereg = /^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/;
	  if(!phonereg.test(phone)){swal('请填写正确的手机号码..','','error');return false;}
	  var _this = $(this);
	  _this.find(".btn-primary").html('<span class="fa fa-spinner fa-spin"></span> 短信发送中..').addClass("disabled");
	  $.post( "{:url('admin/phonetest')}", {'phone':phone},function(data){
		  _this.find(".btn-primary").html('<span class="fa fa-commenting"></span> 发送测试短信').removeClass("disabled");
		  if(data==1){
			swal('测试短信发送成功..','请查看您的手机','success');return false;
		  }else if(data==0){
			swal('测试短信发送失败..','请修改您的系统配置，重新试试吧','error');return false;
		  }else{
			swal(data,'','error');return false;
		  }
      },'json'); 
	}
  });
  $(document).ready(function(e) {
     $.post('{:url("bhadmin/system/getmsgcount")}',{},function(data){
	 	$('.sysmsg-tips').html(data);
	 },'json'); 
  });
 </script>
</block>