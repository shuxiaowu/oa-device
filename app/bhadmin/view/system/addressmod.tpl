 <extend name="public/common" />
<block name="main">
 <div class="pubmain">
  <div class="panel-body">
  <form name="adminform" method="post" action="" onSubmit="return sysattr(document.adminform)">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="{:tabstyle()}">
   <tr>
    <td width="10%" height="32" align="right" valign="middle">地址名称：</td>
    <td height="32" align="left">{:inputs(array('name'=>'name','icon'=>'map-marker','val'=>$data['name'],'place'=>'请填写地址名称'))}</td>
   </tr>
   <tr>
     <td height="32" align="right" valign="middle">地址所属：</td>
     <td height="32" align="left">{:gaddress($data['upid'],'--')}</td>
   </tr>
   <tr>
     <td height="32" align="right" valign="middle">&nbsp;</td>
     <td height="32" align="left">{:btn(array('vals'=>'提交','size'=>3,'type'=>'submit','icon'=>'cog','scene'=>'primary'))}</td>
   </tr>
  </table>
  </form>
 </div>
 </div>
</block>