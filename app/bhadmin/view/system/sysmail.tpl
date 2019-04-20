<extend name="public/common" />
<block name="main">
 <div class="pubmain">
  <div class="panel-body">
   <form name="sysmod" method="post" action="">
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table">
      <tr>
        <td width="15%" height="30" align="left" valign="middle">参数说明</td>
        <td height="30" align="left" valign="middle">参数值</td>
      </tr>
      <tr>
        <td width="10%" height="25" align="left" valign="middle">发送方式</td>
        <td height="25" align="left" valign="middle">通过（SMTP/POP3）协议发送 <span class="full999">（ 默认 ）</span></td>
      </tr>
      <tr>
        <td height="25" align="left" valign="middle">系统检测<br/><span class="full999" style="font-size:11px;">需要的支持 mail 函数</span></td>
        <td height="25" align="left" valign="middle">
         mail扩展<font class="text-success"> (<if condition="$ismail eq 1"><font color="green">{:icon('ok')}</font><else/><font color="red">{:icon('remove')}</font></if>)</font>
        </td>
      </tr>
      <tr>
        <td height="25" align="left" valign="middle">
        邮件服务器<br/>
        <span class="full999" style="font-size:11px;">SMTP服务器，<br/>只有正确设置才能使用发邮件功能<br/></span>
        </td>
        <td height="25" align="left" valign="middle">
        <input type="text" value="{$data['mailsmtp']}" style="width:200px" name="mailsmtp" class="text"{:tooltip('qq邮箱:smtp.qq.com<br>163邮箱：smtp.163.com<br>gmail邮箱：smtp.gmail.com','top',2)} /> <a href="{:url('system/sysmail','act=port')}">查看邮件服务器</a>
         <if condition="$act eq 'port'">
           <div style="width:700px; height:auto; background-color:#fff; margin:10px 0 0 0;">
            <table class="{:tabstyle()}">
              <tr class="active">
                <td>类型</td>
                <td>服务器名称</td>
                <td>服务器地址</td>
                <td>非SSL端口</td>
                <td>SSL端口</td>
              </tr>
              <tr>
                <td>收件服务器</td>
                <td>POP</td>
                <td>pop.domain(服务器).com</td>
                <td>110</td>
                <td>995</td>
              </tr>
              <tr>
                <td>收件服务器</td>
                <td>IMAP</td>
                <td>imap.domain(服务器).com</td>
                <td>143</td>
                <td>993</td>
              </tr>
              <tr class="success">
                <td><font color="green">发件服务器</font></td>
                <td>SMTP</td>
                <td>smtp.domain(服务器).com</td>
                <td>25</td>
                <td>465/994</td>
              </tr>
                           
            </table>
           </div>
         </if>
        </td>
      </tr>
      <tr>
        <td height="25" align="left" valign="middle">
        邮件发送端口<br/>
        <span class="full999" style="font-size:11px;">默认为25，一般无需更改</span>
        </td>
        <td height="25" align="left" valign="middle"><input type="text" value="{$data['mailport']}" name="mailport" class="textsort" /></td>
      </tr>
      <tr>
        <td height="25" align="left" valign="middle">
        邮箱帐号<br/>
        <span class="full999" style="font-size:11px;">SMTP服务器的用户帐号(完整的电子邮件地址如user@domain.com)，只有正确设置才能使用发邮件功能</span>
        </td>
        <td height="25" align="left" valign="middle">{:inputs(array('name'=>'mailname','val'=>$data['mailname'],'width'=>20,'icon'=>'envelope','tips'=>'请输入系统邮件地址','place'=>'请输入系统邮件地址'))}</td>
      </tr>
      <tr>
        <td height="25" align="left" valign="middle">邮箱密码(<font color="green">已加密</font>)</td>
        <td height="25" align="left" valign="middle"><input type="password" value="{$data['mailpass']}" name="mailpass" class="text" style="width:200px" /></td>
      </tr>
      <tr>
        <td height="25" align="left" valign="middle">邮件设置测试<br/><span class="full999" style="font-size:11px;">请填写接受测试的邮件地址</span> </td>
        <td height="25" align="left" valign="middle">
         <input type="text" value="" name="mailtest" class="text mailtest" style="width:200px" />&nbsp;&nbsp;&nbsp;
         <?php echo '<a href="javascript:void(0)" class="sendmail">'.btn(array('vals'=>'发送测试邮件','icon'=>'envelope','scene'=>'primary','tips'=>'点击发送系统测试邮件，检测邮件服务器是否调试正常')).'</a>';?>
        </td>
      </tr>
      <tr>
        <td height="25" align="left" valign="middle">设置须知</td>
        <td height="25" align="left" valign="middle">您填写的账号必须开启 SMTP/POP3 服务，点击查看如何开启 <a href="http://service.mail.qq.com/cgi-bin/help?subtype=1&&id=28&&no=1001256" target="_blank" style="color:red">服务</a>!</td>
      </tr>
      <tr>
        <td height="25" align="left" valign="middle">保存</td>
        <td height="35" align="left" valign="middle">{:btn(array('vals'=>'确定保存','size'=>3,'type'=>'submit','icon'=>'cog','scene'=>'primary'))}</td>
      </tr>
    </table>
   </form>
  </div>
 </div>
 <script type="text/javascript">
  $(".sendmail").click(function(e) {
    var mail = $.trim($(".mailtest").val());
	if(mail==''){
	  swal('请填写接受测试的邮件地址','例如：bh@jxbht.com','error');
	  return false;
	}else{
	  var mailreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/; /*邮箱正则*/
	  if(!mailreg.test(mail)){swal('请填写正确的邮件地址..','例如：bh@jxbht.com','error');return false;}
	  var _this = $(this);
	  _this.find(".btn-primary").html('<span class="glyphicon glyphicon-envelope"></span> 邮件发送中..').addClass("disabled");
	  $.post( "{:url('admin/mailtest')}", {'mail':mail},function(data){
		  var data = eval("(" + data + ")");
		  _this.find(".btn-primary").html('<span class="glyphicon glyphicon-envelope"></span> 发送测试邮件').removeClass("disabled");
		  if(data==1){
			swal('测试邮件发送成功..','请登录您的邮箱查看','success');return false;
		  }else if(data==0){
			swal('测试邮件发送失败..','请修改您的邮箱配置，重新试试吧','error');return false;
		  }else{
			swal(data,'','error');return false;
		  }
	  },'json');
	}
  });
 </script>
</block>