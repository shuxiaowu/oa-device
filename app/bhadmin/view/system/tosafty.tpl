<extend name="public/common" />
<block name="main">
  <div class="pubmain">
    <div class="panel-body">
      <form name="adminform" method="post" action="" onSubmit="return cksafty(document.adminform)">
        <div class="alert alert-primary" style="margin-bottom:10px;">在操作此项目，您需要更高的权限，请输入安全授权码。</div>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="{:tabstyle()}">
          <tr>
            <td height="32" align="right" valign="middle" width="15%">请输入安全授权码：</td>
            <td height="32" align="left">{:inputs(array('type'=>'password','name'=>'pass','icon'=>'log-out','width'=>30,'place'=>'请输入安全授权码','tips'=>''))}</td>
          </tr>
          <tr>
            <td height="32" align="right" valign="middle">&nbsp;</td>
            <input type="hidden" value="{$act}" name="act">
            <td height="32" align="left">{:btn(array('vals'=>'提交','size'=>3,'type'=>'submit','icon'=>'cog','scene'=>'primary'))}</td>
          </tr>
        </table>
      </form>
    </div>
  </div>
  <script type="text/javascript">
    function cksafty(td)
	{
		pass = $.trim(pass);
		if ( pass == '' ) { swal('请输入安全授权码','','error'); return false; }
	}
  </script>
</block>
