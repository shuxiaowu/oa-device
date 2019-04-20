<extend name="public/common" />
<block name="main">
  <div class="pubmain">
    <div class="panel-body">
      <form name="adminform" method="post" action="" onSubmit="return sysassets(document.adminform)">
        <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="table tablevh">
          <tr>
            <td width="120" height="32" align="right" valign="middle">转移单号<font class="addred">*</font>：</td>
            <td width="200" align="left">{:inputs(array('name'=>'','place'=>'请输入转移单号','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">转入部门<font class="addred">*</font>：</td>
            <td width="200" align="left">{:inputs(array('name'=>'','place'=>'请输入转入部门','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">接收人<font class="addred">*</font>：</td>
            <td align="left">{:inputs(array('name'=>'recipient','place'=>'请输入接收人','width'=>'20'))}</td>
          </tr>
          <tr>
            <td width="120" align="right" valign="middle">存放地方：</td>
            <td align="left"> {:inputs(array('name'=>'lingdate','place'=>'请输入存放地方','width'=>'20'))} </td>
            <td width="120" height="32" align="right" valign="middle">申请时间<font class="addred">*</font>：</td>
            <td width="200" align="left">{:inputs(array('name'=>'applydate','add'=>'input-date','place'=>'选择申请时间','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">状态：</td>
            <td align="left">{:dropdown([['Id'=>1,'topic'=>'未转移'],['Id'=>2,'topic'=>'已转移']],0,'请选择','state')}</td>
          </tr>
          <tr>
            <td width="120" height="32" align="right" valign="middle">备注：</td>
            <td align="left" colspan="5">
            <textarea class="mytextarea form-control" name="remark" style="width:880px !important;"></textarea>
            </td>
          </tr> 
          <tr>
          <td width="120" align="right" valign="middle">是否完成：</td>
            <td align="left"> {:dropdown([['Id'=>1,'topic'=>'未完成'],['Id'=>2,'topic'=>'完成']],0,'请选择','isachieve')}</td>
          </tr>
          <tr>
            <td width="120" height="32" align="right" valign="middle">转移时间<font class="addred">*</font>：</td>
            <td width="200" align="left">{:inputs(array('name'=>'','add'=>'input-date','place'=>'选择转移时间','width'=>'20'))} </td>
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
