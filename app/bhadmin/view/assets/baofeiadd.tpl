<extend name="public/common" />
<block name="main">
  <div class="pubmain">
    <div class="panel-body">
      <form name="adminform" method="post" action="" onSubmit="return sysassets(document.adminform)">
        <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="table tablevh">
          <tr>
            <td width="120" height="32" align="right" valign="middle">报废单号：<font class="addred">*</font>：</td>
            <td width="200" align="left">{:inputs(array('name'=>'','place'=>'请输入报废单号','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">报废部门：<font class="addred">*</font>：</td>
            <td width="200" align="left">{:inputs(array('name'=>'','place'=>'请输入报废部门','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">报废人：<font class="addred">*</font>：</td>
            <td align="left">{:inputs(array('name'=>'','place'=>'请输入报废人','width'=>'20'))}</td>
          </tr>
          <tr>
            <td width="120" height="32" align="right" valign="middle">申请日期：<font class="addred">*</font>：</td>
            <td width="200" align="left">{:inputs(array('name'=>'applydate','add'=>'input-date','place'=>'选择申请日期','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">报废状态：</td>
            <td width="200" align="left">{:dropdown([['Id'=>1,'topic'=>'未报废'],['Id'=>2,'topic'=>'已报废']],0,'请选择','state')}</td>
            <td width="120" align="right" valign="middle">报废日期：</td>
            <td align="left"> {:inputs(array('name'=>'','add'=>'input-date','place'=>'选择报废日期','width'=>'20'))} </td>
          </tr>
          <tr>
            <td width="120" height="32" align="right" valign="middle">备注：</td>
            <td align="left" colspan="5">
            <textarea class="mytextarea form-control" name="remark" style="width:880px !important;"></textarea>
            </td>
          </tr> 
          <tr>
            <td height="32" align="right" valign="middle">&nbsp;</td>
            <td colspan="5"align="left">{:btn(array('vals'=>'确定添加','size'=>3,'type'=>'submit','icon'=>'edit','scene'=>'primary'))}</td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</block>
