<extend name="public/common" />
<block name="main">
  <div class="pubmain">
    <div class="panel-body">
      <form name="adminform" method="post" action="" onSubmit="return sysassets(document.adminform)">
        <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="table tablevh">
          <tr>
            <td width="120" height="32" align="right" valign="middle">资产编号：<font class="addred">*</font>：</td>
            <td width="200" align="left">{:inputs(array('name'=>'','place'=>'请输入资产编号','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">车牌号码：<font class="addred">*</font>：</td>
            <td width="200" align="left">{:inputs(array('name'=>'','place'=>'请输入车牌号码','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">品牌型号：<font class="addred">*</font>：</td>
            <td align="left">{:inputs(array('name'=>'','place'=>'请输入品牌型号','width'=>'20'))}</td>
          </tr>
          <tr>
            <td width="120" height="32" align="right" valign="middle">管理部门：<font class="addred">*</font>：</td>
            <td width="200" align="left">{:inputs(array('name'=>'','place'=>'请输入管理部门','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">管理人：</td>
            <td width="200" align="left">{:inputs(array('name'=>'','place'=>'请输入管理人','width'=>'20'))}</td>
            <td width="120" align="right" valign="middle">金额：</td>
            <td align="left"> {:inputs(array('name'=>'lingdate','place'=>'请输入金额','width'=>'20'))} </td>
          </tr>
           <tr>
            <td width="120" height="32" align="right" valign="middle">保险期限：<font class="addred">*</font>：</td>
            <td width="200" align="left">{:inputs(array('name'=>'','place'=>'请输入保险期限','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">年检时间：</td>
            <td width="200" align="left">{:inputs(array('name'=>'','add'=>'input-date','place'=>'请选择年检时间','width'=>'20'))}</td>
            <td width="120" align="right" valign="middle">入账时间：</td>
            <td align="left"> {:inputs(array('name'=>'','add'=>'input-date','place'=>'请选择入账时间','width'=>'20'))} </td>
          </tr>
            <tr>
            <td width="120" height="32" align="right" valign="middle">预计总行驶路程：<font class="addred">*</font>：</td>
            <td width="200" align="left">{:inputs(array('name'=>'','place'=>'请输入预计总行驶路程','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">预计月行驶路程：</td>
            <td width="200" align="left">{:inputs(array('name'=>'','place'=>'请输入预计月行驶路程','width'=>'20'))}</td>
            <td width="120" align="right" valign="middle">入账时间：</td>
            <td align="left"> {:inputs(array('name'=>'','add'=>'input-date','place'=>'请选择入账时间','width'=>'20'))} </td>
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
