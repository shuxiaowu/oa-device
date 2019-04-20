<extend name="public/common" />
<block name="main">
  <div class="pubmain">
    <div class="panel-body">
      <form name="adminform" method="post" action="" onSubmit="return sysassets(document.adminform)">
        <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="table tablevh">
          <tr>
            <td width="120" height="32" align="right" valign="middle">设备编号：<font class="addred">*</font>：</td>
            <td width="200" align="left">{:inputs(array('name'=>'','place'=>'请输入设备编号','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">设备名称：<font class="addred">*</font>：</td>
            <td width="200" align="left">{:inputs(array('name'=>'','place'=>'请输入设备名称','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">型号：<font class="addred">*</font>：</td>
            <td align="left">{:inputs(array('name'=>'','place'=>'请输入型号','width'=>'20'))}</td>
          </tr>
          <tr>
            <td width="120" height="32" align="right" valign="middle">管理部门：<font class="addred">*</font>：</td>
            <td width="200" align="left">{:inputs(array('name'=>'','place'=>'请输入管理部门','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">管理员：</td>
            <td width="200" align="left">{:inputs(array('name'=>'','place'=>'请输入管理员','width'=>'20'))}</td>
            <td width="120" align="right" valign="middle">状态：</td>
            <td align="left"> {:dropdown([['Id'=>1,'topic'=>'闲置'],['Id'=>2,'topic'=>'未闲置']],0,'请选择','state')}</td>
          </tr>
           <tr>
            <td width="120" height="32" align="right" valign="middle">单位：<font class="addred">*</font>：</td>
            <td width="200" align="left">{:inputs(array('name'=>'','place'=>'请输入单位','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">单价：</td>
            <td width="200" align="left">{:inputs(array('name'=>'','place'=>'请输入单价','width'=>'20'))}</td>
            <td width="120" align="right" valign="middle">入账日期间：</td>
            <td align="left"> {:inputs(array('name'=>'','add'=>'input-date','place'=>'请选择入账日期','width'=>'20'))} </td>
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
