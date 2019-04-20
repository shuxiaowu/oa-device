<extend name="public/common" />
<block name="main">
  <div class="pubmain">
    <div class="panel-body">
      <form name="adminform" method="post" action="" onSubmit="return sysassets(document.adminform)">
        <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="table tablevh">
          <tr>
            <td width="120" height="32" align="right" valign="middle">资产编号<font class="addred">*</font>：</td>
            <td width="200" align="left">{:inputs(array('name'=>'','place'=>'请输入资产编号','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">资产名称<font class="addred">*</font>：</td>
            <td width="200" align="left">{:inputs(array('name'=>'','place'=>'请输入资产名称','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">资产原值<font class="addred">*</font>：</td>
            <td align="left">{:inputs(array('name'=>'','place'=>'请输入资产原值','width'=>'20'))}</td>
          </tr>
          <tr>
            <td width="120" height="32" align="right" valign="middle">预计净残值<font class="addred">*</font>：</td>
            <td width="200" align="left">{:inputs(array('name'=>'','place'=>'请输入预计净残值','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">使用年限：</td>
            <td width="200" align="left">{:inputs(array('name'=>'','add'=>'input-date','place'=>'选择使用年限','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">残值率：</td>
            <td align="left"> {:inputs(array('name'=>'','place'=>'请输入残值率','width'=>'20'))} </td>
          </tr>
           <tr>
            <td width="120" height="32" align="right" valign="middle">已使用月份<font class="addred">*</font>：</td>
            <td width="200" align="left">{:inputs(array('name'=>'','add'=>'input-date','place'=>'请选择已使用月份','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">月折旧额：</td>
            <td width="200" align="left">{:inputs(array('name'=>'','place'=>'请输入月折旧额','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">年折旧额：</td>
            <td align="left"> {:inputs(array('name'=>'','place'=>'请输入年折旧额率','width'=>'20'))} </td>
          </tr>
          <tr>
            <td width="120" height="32" align="right" valign="middle">累计折旧<font class="addred">*</font>：</td>
            <td width="200" align="left">{:inputs(array('name'=>'','place'=>'请输入累计折旧','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">净值：</td>
            <td width="200" align="left">{:inputs(array('name'=>'','place'=>'请输入净值','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">截止计算日期：</td>
            <td align="left"> {:inputs(array('name'=>'','add'=>'input-date','place'=>'请选择截止计算日期','width'=>'20'))} </td>
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
