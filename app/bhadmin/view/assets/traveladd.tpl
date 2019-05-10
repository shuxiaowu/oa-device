<extend name="public/common" />
<block name="main">
    <div class="pubmain">
        <div class="panel-body">
            <form name="adminform" method="post" action="" onSubmit="return sysassets(document.adminform)">
                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="table tablevh">
                    <tr>
                        <td width="120" height="32" align="right" valign="middle">车牌号码<font class="addred">*</font>：</td>
                        <td width="200" align="left">{:dropdown($dengji,0,'请选择车牌号','licensenum','licensenum')}</td>
                        <td width="120" align="right" valign="middle">驾驶员<font class="addred">*</font>：</td>
                        <td width="200" align="left">{:inputs(array('name'=>'driver','place'=>'驾驶员','width'=>'20'))} </td>
                        <td width="120" align="right" valign="middle">调度员<font class="addred">*</font>：</td>
                        <td align="left">{:inputs(array('name'=>'diaodu','place'=>'调度员','width'=>'20'))}</td>
                    </tr>
                    <tr>
                        <td width="120" align="right" valign="middle">出发日期<font class="addred">*</font>：</td>
                        <td align="left">{:inputs(array('name'=>'leavedate','add'=>'input-date','place'=>'出发日期','val'=>datem(),'width'=>'20'))} </td>
                        <td width="120" align="right" valign="middle">出行原因<font class="addred">*</font>：</td>
                        <td align="left"> {:inputs(array('name'=>'reason','place'=>'出行原因','width'=>'20'))} </td>
                        <td width="120" align="right" valign="middle">出行路线<font class="addred">*</font>：</td>
                        <td align="left"> {:inputs(array('name'=>'route','place'=>'出行路线','width'=>'20'))} </td>
                    </tr>
                    <tr>
                        <td width="120" align="right" valign="middle">行驶公里数<font class="addred">*</font>：</td>
                        <td align="left"> {:inputs(array('type'=>'number','name'=>'distance','place'=>'行驶公里数','width'=>'20'))} </td>
                        <td width="120" align="right" valign="middle">结束日期<font class="addred">*</font>：</td>
                        <td align="left">{:inputs(array('name'=>'enddate','add'=>'input-date','place'=>'结束日期','val'=>datem(),'width'=>'20'))}</td>
                        <td width="120" align="right" valign="middle">用车部门<font class="addred">*</font>：</td>
                        <td align="left"> {:inputs(array('name'=>'usedep','place'=>'用车部门','width'=>'20'))} </td>
                    </tr>
                    <tr>
                        <td width="120" align="right" valign="middle">用车人<font class="addred">*</font>：</td>
                        <td align="left"> {:inputs(array('name'=>'useman','place'=>'用车人','width'=>'20'))} </td>
                        <td width="120" height="32" align="right" valign="middle">用车人数<font class="addred">*</font>：</td>
                        <td width="200" align="left">{:inputs(array('type'=>'number','name'=>'usecount','place'=>'用车人数','width'=>'20'))}</td>
                        <td width="120" align="right" valign="middle">派单编号<font class="addred">*</font>：</td>
                        <td align="left"> {:inputs(array('name'=>'paichenum','place'=>'派单编号','width'=>'20'))} </td>
                    </tr>
                    <tr>
                        <td width="120" align="right" valign="middle">审批人<font class="addred">*</font>：</td>
                        <td align="left"> {:inputs(array('name'=>'officer','place'=>'审批人','width'=>'20'))} </td>
                        <td width="120" align="right" valign="middle">车辆状态<font class="addred">*</font>：</td>
                        <td align="left">{:dropdown([['Id'=>1,'topic'=>'报废'],['Id'=>2,'topic'=>'拍卖'],['Id'=>3,'topic'=>'使用']],0,'请选择','status')}</td>
                    </tr>
                    <tr>
                        <td height="32" align="right" valign="middle">&nbsp;</td>
                        <td colspan="5" align="left">{:btn(array('vals'=>'确定添加','size'=>3,'type'=>'submit','icon'=>'edit','scene'=>'primary'))}</td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</block>