<extend name="public/common" />
<block name="main">
  <div class="pubmain">
    <div class="panel-body">
      <form name="adminform" method="post" action="" onSubmit="return systpl(document.adminform)">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="tablev table table-bordered">
          <tr>
            <td width="10%" height="32" align="right" valign="middle">模板标题：</td>
            <td height="32" align="left">{:inputs(array('name'=>'topic','scene'=>'topic','val'=>$data['topic'],'tips'=>'模板标题（*必填）'))}</td>
          </tr>
          <tr>
            <td width="10%" height="32" align="right" valign="middle">模板名称：</td>
            <td height="32" align="left">{:inputs(array('name'=>'tplname','readonly'=>1,'val'=>$data['tplname'],'place'=>'模板名称'))}</td>
          </tr>
          <tr>
            <td height="32" align="right" valign="middle">模板内容：</td>
            <td height="32" align="left"><textarea name='content'. class='mytextarea form-control' style='width:65%;height:500px !important;'>{$data['content']}</textarea></td>
          </tr>
          <tr>
            <td height="32" align="right" valign="middle">是否启用：</td>
            <td height="32" align="left">{:checkbox($data['enabled'])} <span class="text-warning"> 注：勾选表示启用</span></td>
          </tr>
          <tr>
            <td height="32" align="right" valign="middle">模板排序：</td>
            <td height="32" align="left">{:inputs(array('name'=>'ord','val'=>$data['ord'],'scene'=>'ord'))}</td>
          </tr>
          <tr>
            <td height="32" align="right" valign="middle">&nbsp;
              <input type="hidden" value="{$data['Id']}" name="id"></td>
            <td height="32" align="left">{:btn(array('vals'=>'确定修改','size'=>3,'type'=>'submit','icon'=>'cog','scene'=>'primary'))}</td>
          </tr>
        </table>
      </form>
    </div>
  </div>
  <script type="text/javascript">
  function systpl(td){
    if ( td.topic.value == '' ) {
	  swal('请输入模板标题','','error'); return false;
	}
  }
 </script> 
</block>
