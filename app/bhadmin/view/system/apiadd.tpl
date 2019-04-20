<extend name="public/common" />
<block name="main">
 <div class="pubmain">
 <div class="panel-body">
  <form name="adminform" method="post" action="" onSubmit="return styapi(document.adminform)">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="{:tabstyle()}">
   <tr>
    <td width="10%" height="32" align="right" valign="middle">身份：</td>
    <td height="32" align="left">{:inputs(array('name'=>'type','place'=>'type，输入英文，例如 ios xcx web','tips'=>''))}</td>
   </tr>
   <tr>
    <td width="10%" height="32" align="right" valign="middle">APPID：</td>
    <td height="32" align="left"><input type="text" value="" placeholder="appid" style="width:400px;" name="appid" class="form-control" onkeyup="this.value=this.value.replace(/[^\d]/g,'') " onafterpaste="this.value=this.value.replace(/[^\d]/g,'') "></td>
   </tr>
   
   <tr>
     <td height="32" align="right" valign="middle">备注：</td>
     <td height="32" align="left">{:inputs(array('name'=>'remark','place'=>'备注'))}</td>
   </tr>
   <tr>
     <td height="32" align="right" valign="middle">&nbsp;</td>
     <td height="32" align="left">{:btn(array('vals'=>'提交','size'=>3,'type'=>'submit','icon'=>'cog','scene'=>'primary'))}</td>
   </tr>
  </table>
  </form>
 </div>
 </div>
 <script type="text/javascript">
  //
  function styapi(td){
	if( td.type.value == '' ) { swal('请输入身份，例如 xcx ios','','error'); return false; }
	var pg = /^[A-Za-z]+$/;
	if(!pg.test(td.type.value)){
	  swal('身份只允许输入英文','','error'); return false;
	}
	
	if( td.appid.value == '' ) { swal('请输入APPID，例如 100005 100006','','error'); return false; }
  }
 </script>
</block>