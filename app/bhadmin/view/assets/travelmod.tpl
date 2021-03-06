<extend name="public/common" />
<block name="main">
    <div class="pubmain">
        <div class="panel-body">
            <form name="adminform" method="post" action="" onSubmit="return sysassets(document.adminform)">
                 <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="table tablevh">
                    <tr>
                        <td width="120" height="32" align="right" valign="middle">车牌号码<font class="addred">*</font>：</td>
                        <td width="200" align="left">{:dropdown($dengji,$data['licensenum'],gtopic('usecar',$data['licensenum'],'licensenum'),'licensenum','licensenum')}</td>
                        <td width="120" align="right" valign="middle">驾驶员<font class="addred">*</font>：</td>
                        <td width="200" align="left">{:inputs(array('name'=>'driver','val'=>$data['driver'],'place'=>'驾驶员','width'=>'20'))} </td>
                        <td width="120" align="right" valign="middle">调度员<font class="addred">*</font>：</td>
                        <td align="left">{:inputs(array('name'=>'diaodu','val'=>$data['diaodu'],'place'=>'调度员','width'=>'20'))}</td>
                    </tr>
                    <tr>
                        <td width="120" align="right" valign="middle">出发日期<font class="addred">*</font>：</td>
                        <td align="left">{:inputs(array('name'=>'leavedate','add'=>'input-date','place'=>'出发日期','val'=>showdate($data['leavedate']),'width'=>'20'))} </td>
                        <td width="120" align="right" valign="middle">出行原因<font class="addred">*</font>：</td>
                        <td align="left"> {:inputs(array('name'=>'reason','val'=>$data['reason'],'place'=>'出行原因','width'=>'20'))} </td>
                        <td width="120" align="right" valign="middle">出行路线<font class="addred">*</font>：</td>
                        <td align="left"> {:inputs(array('name'=>'route','val'=>$data['route'],'place'=>'出行路线','width'=>'20'))} </td>
                    </tr>
                    <tr>
                        <td width="120" align="right" valign="middle">行驶公里数<font class="addred">*</font>：</td>
                        <td align="left"> {:inputs(array('type'=>'number','name'=>'distance','val'=>$data['distance'],'place'=>'行驶公里数','width'=>'20'))} </td>
                        <td width="120" align="right" valign="middle">结束日期<font class="addred">*</font>：</td>
                        <td align="left">{:inputs(array('name'=>'enddate','add'=>'input-date','place'=>'结束日期','val'=>showdate($data['enddate']),'width'=>'20'))}</td>
                        <td width="120" align="right" valign="middle">用车部门<font class="addred">*</font>：</td>
                        <td align="left"> {:inputs(array('name'=>'usedep','val'=>$data['usedep'],'place'=>'用车部门','width'=>'20'))} </td>
                    </tr>
                    <tr>
                        <td width="120" align="right" valign="middle">用车人<font class="addred">*</font>：</td>
                        <td align="left"> {:inputs(array('name'=>'useman','val'=>$data['useman'],'place'=>'用车人','width'=>'20'))} </td>
                        <td width="120" height="32" align="right" valign="middle">用车人数<font class="addred">*</font>：</td>
                        <td width="200" align="left">{:inputs(array('type'=>'number','name'=>'usecount','val'=>$data['usecount'],'place'=>'用车人数','width'=>'20'))}</td>
                        <td width="120" align="right" valign="middle">派单编号<font class="addred">*</font>：</td>
                        <td align="left"> {:inputs(array('name'=>'paichenum','val'=>$data['paichenum'],'place'=>'派单编号','width'=>'20'))} </td>
                    </tr>
                    <tr>
                        <td width="120" align="right" valign="middle">审批人<font class="addred">*</font>：</td>
                        <td align="left"> {:inputs(array('name'=>'officer','val'=>$data['officer'],'place'=>'审批人','width'=>'20'))} </td>
                         <td width="120" align="right" valign="middle">车辆状态<font class="addred">*</font>：</td>
                        <td align="left">{:dropdown([['Id'=>1,'topic'=>'报废'],['Id'=>2,'topic'=>'拍卖'],['Id'=>3,'topic'=>'使用']],$data['status'],travelstatus($data['status']),'status')}</td>
                    </tr>
                    <tr>
                        <td height="32" align="right" valign="middle">&nbsp;</td>
                        <td colspan="5" align="left">{:btn(array('vals'=>'确定修改','size'=>3,'type'=>'submit','icon'=>'edit','scene'=>'primary'))}</td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</block>