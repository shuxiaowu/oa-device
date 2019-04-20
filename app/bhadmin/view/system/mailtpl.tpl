<extend name="public/common" />
<block name="main">
  <div class="pubmain">
    <div class="panel-body"> 
      <div class="u-plus">{:btn(array('vals'=>'添加模板','size'=>3,'icon'=>'plus','scene'=>'primary','url'=>url('system/mailtpladd')))}</div>
      <form name="publist" method="post" action="" onSubmit="return pubdel(document.publist)">
        <if condition="$data neq ''">
        <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center" class="{:tabstyle()}">
          <tr class="active">
            <td width="45" align="center" valign="middle" height="37">{:ckall()}</td>
            <td width="60" align="left" valign="middle">序号</td>
            <td align="left" valign="middle">模板标题</td>
            <td width="105" align="center" valign="middle">模板名称</td>
            <td width="85" align="center" valign="middle">模板排序</td>
            <td width="120" align="center" valign="middle">是否启用</td>
            <td width="100" align="center" valign="middle">更新日期</td>
            <td width="100" align="center" valign="middle">测试模板</td>
            <td width="100" align="center" valign="middle">模板操作</td>
          </tr>
          <volist name="data" id="obj">
            <tr class="maintr">
              <td align="center" valign="middle" height="37">{:ckbox($obj['Id'],$i-1)}</td>
              <td align="left" valign="middle">{$dshow['pageno']+$i}</td>
              <td align="left" valign="middle">{:modField($obj['topic'],$obj['Id'],'topic',$dshow['table'])}</td>
              <td align="center" valign="middle">{$obj['tplname']?:'--'}</td>
              <td align="center" valign="middle">{:modord($obj['ord'],$obj['Id'],$dshow['table'])}</td>
              <td align="center" valign="middle">{:modattr($obj['Id'],$obj['enabled'],$dshow['table'])}</td>
              <td align="center" valign="middle">{:showdate($obj['date'])}</td>
              <td align="center" valign="middle"><a href="javascript:void(0)" class="btn-email" data-topic="{$obj['topic']}" data-id="{$obj['Id']}">{:btn(array('vals'=>'测试','icon'=>'envelope','scene'=>'success','round'=>1,'tips'=>'点击编辑数据'))}</a></td>
              <td align="center" valign="middle">{:btn(array('vals'=>'编辑','icon'=>'edit','round'=>1,'tips'=>'点击编辑数据','url'=>url('system/mailtplmod','id='.$obj['Id'])))}</td>
            </tr>
          </volist>
          <tr>
            <td height="37" align="center" valign="middle">{:ckall(2)}</td>
            <td height="35" colspan="8" align="left" valign="middle"> {:btn(array('vals'=>'删除','type'=>'submit','name'=>'deldata','round'=>1,'icon'=>'trash','scene'=>'danger'))} <font class="text-warning">&nbsp;{:icon('warning-sign')} 提示，任何形式删除的数据都无法找回，请谨慎操作！</font> {$dshow['pageshow']} </td>
          </tr>
        </table>
      </form>
      <else/>
      <div class="alert alert-danger">暂无模板，您可以点击添加按钮添加一条数据。</div>
      </if>
    </div>
  </div>
</block>
<block name="bootstrap">
  <div class="modal fade" id="modelemail" data-backdrop="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close btn-bhmap-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">测试邮件</h4>
        </div>
        <div class="modal-body">
          <table class="tablev table-bordered table">
            <tr>
              <td align="center" width="100">模板名称：</td>
              <td align="left"><span class="tplname">&nbsp;</span></td>
            </tr>
            <tr>
              <td align="center" width="100">收件邮箱：</td>
              <input type="hidden" class="tid" value="0">
              <input type="hidden" class="ttopic" value="">
              <td align="left"><input type="text" value="" name="mailtest" class="text mailtest" style="width:200px" />
                &nbsp;&nbsp;&nbsp; <?php echo '<a href="javascript:void(0)" class="sendmail">'.btn(array('vals'=>'发送测试邮件','icon'=>'envelope','scene'=>'primary','tips'=>'点击发送系统测试邮件，检测邮件服务器是否调试正常')).'</a>';?></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
  $(document).ready(function(e) {
     $(".btn-email").click(function(e) {
       var id = $(this).data('id'); 
	   $(".tid").val(id);
	   $(".ttopic").val($(this).data('topic'));
	   $(".tplname").text($(this).data('topic'));
	   $("#modelemail").modal('show');
     });
	 
	 $(".sendmail").click(function(e) {
		var mail  = $.trim($(".mailtest").val());
		var id    = $('.tid').val();
		var topic = $('.ttopic').val();
		if(mail==''){
		  swal('请填写接受测试的邮件地址','例如：bh@jxbht.com','error');
		  return false;
		}else{
		  var mailreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/; /*邮箱正则*/
		  if(!mailreg.test(mail)){swal('请填写正确的邮件地址..','例如：bh@jxbht.com','error');return false;}
		  var _this = $(this);
		  _this.find(".btn-primary").html('<span class="glyphicon glyphicon-envelope"></span> 邮件发送中..').addClass("disabled");
		  $.post( "{:url('admin/mailtest')}", {'mail':mail,'id':id,'topic':topic},function(data){
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
	 
  });
 </script> 
</block>
