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
   {:btn(array('vals'=>'短信设置','size'=>3,'faicon'=>'commenting','scene'=>'default','url'=>url('system/sysmsg')))}
   {:btn(array('vals'=>'微信设置','size'=>3,'faicon'=>'weixin','scene'=>'primary','url'=>url('system/sysweixin')))}
  </div>
  <div class="ui-block"></div>
   <form name="sysmod" method="post" action="" onSubmit="return ckWeixin(document.sysweixinset)">
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="{:tabstyle()}">
      <tr>
        <td width="10%" height="30" align="left" valign="middle">参数说明</td>
        <td height="30" align="left" valign="middle">参数值</td>
      </tr>
      <tr>
        <td height="25" align="left" valign="middle">公众号名称</td>
        <td height="25" align="left" valign="middle">{:inputs(array('faicon'=>'weixin','width'=>30,'place'=>'微信公众号名称','name'=>'wxname','val'=>$data['wxname'],'tips'=>'输入微信公众号名称'))}</td>
      </tr>     
      <tr>
        <td height="25" align="left" valign="middle">微信APPID</td>
        <td height="25" align="left" valign="middle">{:inputs(array('faicon'=>'weixin','width'=>30,'place'=>'微信APPID','name'=>'wxappid','val'=>$data['wxappid'],'tips'=>'输入微信APPID，登录您的微信公众号获取'))}</td>
      </tr>
      <tr>
        <td height="25" align="left" valign="middle">微信SECRET</td>
        <td height="25" align="left" valign="middle">{:inputs(array('faicon'=>'weixin','width'=>30,'place'=>'微信SECRET','name'=>'wxsecret','val'=>$data['wxsecret'],'tips'=>'输入微信SECRET，登录您的微信公众号获取'))}</td>
      </tr>
      <tr>
        <td height="25" align="left" valign="middle">项目URL</td>
        <td height="25" align="left" valign="middle">{:inputs(array('faicon'=>'link','width'=>30,'place'=>'项目URL，需要填写http://','name'=>'companyurl','val'=>$data['companyurl'],'tips'=>'输入项目域名，也是你在公众号填写的授权域名，最后请不要加/结尾，需要填写http://或者https://'))} </td>
      </tr>
      <tr>
        <td height="25" align="left" valign="middle">微信测试</td>
        <td height="25" align="left" valign="middle"><?php echo '<a href="javascript:void(0)" class="testwx">'.btn(array('vals'=>'点击测试','faicon'=>'weixin','scene'=>'success','tips'=>'点击调试微信链接，参数是否正常')).'</a>';?></td>
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
   function ckWeixin(td) {
     var url = td.companyurl.value;
	 if (url!='') {         
	   urlReg = !!url.match(/^((https|http|ftp|rtsp|mms)?:\/\/)[^\s]+/);
	   if (urlReg == false) {
	     swal('项目URL有误','例如：http://www.jxbh.com，必须填写http:// 或者https:// 结尾不要加/','error'); return false;
	   }
	 }
   }
   $('.testwx').click(function(e) {
	  var _this = $(this);
	  _this.find(".btn-success").html('<span class="fa fa-weixin"></span> 微信测试中..').addClass("disabled");
	  $.post( "{:url('bhadmin/admin/weixintest')}", {},function(data){
		 _this.find(".btn-success").html('<span class="fa fa-weixin"></span> 点击测试').removeClass("disabled");
		 if ( data.state == 1 ) {
		    swal('微信配置可正常使用','','success');
		 } else {
		 	swal(data.msg,'','error');
		 }
	  },'json');
   });
 </script>
</block>