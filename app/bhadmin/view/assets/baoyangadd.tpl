<extend name="public/common" />
<block name="main">
  <div class="pubmain">
    <div class="panel-body">
      <form name="adminform" method="post" action="" onSubmit="return sysassets(document.adminform)">
        <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="table tablevh">
          <tr>
            <td width="120" height="32" align="right" valign="middle">资产编号：<font class="addred">*</font>：</td>
            <td width="200" align="left">{:inputs(array('name'=>'','place'=>'请输入资产编号','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">保养资产：<font class="addred">*</font>：</td>
            <td width="200" align="left">{:inputs(array('name'=>'','place'=>'请输入保养资产','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">保养部门：<font class="addred">*</font>：</td>
            <td align="left">{:inputs(array('name'=>'','place'=>'请输入保养部门','width'=>'20'))}</td>
          </tr>
          <tr>
            <td width="120" height="32" align="right" valign="middle">保养人：<font class="addred">*</font>：</td>
            <td width="200" align="left">{:inputs(array('name'=>'','place'=>'请输入保养人','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">保养项目：</td>
            <td width="200" align="left">{:inputs(array('name'=>'','place'=>'请输入保养项目','width'=>'20'))}</td>
            <td width="120" align="right" valign="middle">保养费用：</td>
            <td align="left"> {:inputs(array('name'=>'','place'=>'请输入保养费用','width'=>'20'))}</td>
          </tr>
           <tr>
            <td width="120" align="right" valign="middle">保养时间：</td>
            <td align="left"> {:inputs(array('name'=>'','add'=>'input-date','place'=>'请选择保养时间','width'=>'20'))} </td>
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
