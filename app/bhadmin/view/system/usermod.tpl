<extend name="public/common" />
<block name="main">
 <div class="pubmain">
 <div class="panel-body">
  <form name="adminform" method="post" action="" onSubmit="return sysadminuser(document.adminform)">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="{:tabstyle()}">
   <tr>
    <td width="10%" height="32" align="right" valign="middle">登录ID：</td>
    <td height="32" align="left">{:inputs(array('name'=>'user','val'=>$data['user'],'icon'=>'minus','width'=>15,'disabled'=>1))}</td>
   </tr>
   <tr>
     <td height="32" align="right" valign="middle">单位名称：</td>
     <td height="32" align="left">{:inputs(array('name'=>'name','val'=>$data['realname'],'icon'=>'user','width'=>15))}</td>
   </tr>
   <tr>
     <td height="32" align="right" valign="middle">选择权限：</td>
     <td height="32" align="left">{:dropdown($admindep,$data['depid'],gtopic('admindepartment',$data['depid'],'topic','请选择一个权限'),'depid')}</td>
   </tr>
    <tr>
     <td height="32" align="right" valign="middle">负责人：</td>
     <td height="32" align="left">{:inputs(array('name'=>'principal','val'=>$data['principal'],'icon'=>'user','width'=>18,'place'=>'负责人'))}</td>
   </tr>
    <tr>
     <td height="32" align="right" valign="middle">联系方式：</td>
     <td height="32" align="left">{:inputs(array('name'=>'contact','val'=>$data['contact'],'icon'=>'phone','width'=>18,'place'=>'联系方式'))}</td>
   </tr>
    <tr>
     <td height="32" align="right" valign="middle">单位电话：</td>
     <td height="32" align="left">{:inputs(array('name'=>'telephone','val'=>$data['telephone'],'icon'=>'earphone','width'=>18,'place'=>'单位电话'))}</td>
   </tr>
    <tr>
     <td height="32" align="right" valign="middle">地址：</td>
     <td height="32" align="left">{:inputs(array('name'=>'address','val'=>$data['address'],'icon'=>'map-marker','width'=>18,'place'=>'地址'))}</td>
   </tr>
    <tr>
     <td height="32" align="right" valign="middle">状态：</td>
     <td height="32" align="left">{:inputs(array('name'=>'state','val'=>$data['state'],'icon'=>'record','width'=>18,'place'=>'状态'))}</td>
   </tr>
   <tr>
     <td height="32" align="right" valign="middle">修改密码：</td>
     <td height="32" align="left">{:inputs(array('type'=>'password','name'=>'pass','icon'=>'log-out','width'=>30,'place'=>'修改密码','tips'=>'长度大于6位，支持大小写，留空表示不修改密码'))}</td>
   </tr>
   <tr>
     <td height="32" align="right" valign="middle">&nbsp;</td>
     <input type="hidden" value="{$data['Id']}" name="id">
     <td height="32" align="left">{:btn(array('vals'=>'确定修改','size'=>3,'type'=>'submit','icon'=>'edit','scene'=>'primary'))}</td>
   </tr>
  </table>
  </form>
  </div>
 </div>
 <script type="text/javascript">
    $('.lev1 input,.lev2 input').on('ifChecked', function(event){
	  var id = $(this).val();
	  $(".adminauth"+id).find("input").iCheck('check');
    });
    $(".lev1 input,.lev2 input").on("ifUnchecked",function(event){
	  var id = $(this).val();
	  $(".adminauth"+id).find(".icheckbox_minimal").removeClass("checked");
      $(".adminauth"+id).find("input").attr("checked",false);
    }); 
    $("body").on("click",".opened",function(){
     var id  = $(this).data("id");
	 var obj = $(".adminauth"+id);
	 var $this = $(this);
	 if (obj.is(":hidden")){
	   obj.show();
	   $this.find("font").removeClass("fa-plus-square").addClass("fa-minus-square");
	 } else {
	   obj.hide();
	   $this.find("font").removeClass("fa-minus-square").addClass("fa-plus-square");
	 }
   });
 </script>
</block>