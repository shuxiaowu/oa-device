<extend name="public/common" />
<block name="main">
    <div class="pubmain">
        <div class="panel-body">
            <form name="adminform" method="post" action="" onSubmit="return sysassets(document.adminform)">
                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="table tablevh">
                    <tr>
                        <td width="120" height="32" align="right" valign="middle">车牌号码<font class="addred">*</font>：</td>
                        <td width="200" align="left">{:inputs(array('name'=>'licensenum','place'=>'车牌号码','val'=>$data['licensenum'],'width'=>'20'))} </td>
                        <td width="120" align="right" valign="middle">品牌号码<font class="addred">*</font>：</td>
                        <td width="200" align="left">{:inputs(array('name'=>'brand','val'=>$data['brand'],'place'=>'品牌号码','width'=>'20'))} </td>
                        <td width="120" align="right" valign="middle">排气量(升)<font class="addred">*</font>：</td>
                        <td align="left">{:inputs(array('type'=>'number','name'=>'displacement','val'=>$data['displacement'],'place'=>'排气量(升)','width'=>'20'))}</td>
                    </tr>
                    <tr>
                        <td width="120" align="right" valign="middle">车辆类型<font class="addred">*</font>：</td>
                        <td align="left">{:inputs(array('name'=>'cartype','val'=>$data['cartype'],'place'=>'车辆类型','width'=>'20'))}</td>
                        <td width="120" align="right" valign="middle">座位数<font class="addred">*</font>：</td>
                        <td align="left"> {:inputs(array('type'=>'number','name'=>'seat','val'=>$data['seat'],'place'=>'座位数','width'=>'20'))} </td>
                        <td width="120" align="right" valign="middle">购车净价(万元)<font class="addred">*</font>：</td>
                        <td align="left"> {:inputs(array('type'=>'number','name'=>'price','val'=>$data['price'],'place'=>'购车净价(万元)','width'=>'20'))} </td>
                    </tr>
                    <tr>
                        <td width="120" align="right" valign="middle">行驶里程(公里)<font class="addred">*</font>：</td>
                        <td align="left"> {:inputs(array('type'=>'number','name'=>'distance','place'=>'行驶里程(公里)','val'=>$data['distance'],'width'=>'20'))} </td>
                        <td width="120" align="right" valign="middle">累积行驶里程(公里)<font class="addred">*</font>：</td>
                        <td align="left"> {:inputs(array('type'=>'number','name'=>'alldistance','val'=>$data['alldistance'],'place'=>'累积行驶里程(公里)','width'=>'20'))} </td>
                        <td width="120" align="right" valign="middle">加油卡号<font class="addred">*</font>：</td>
                        <td align="left"> {:inputs(array('name'=>'jiayouc','place'=>'加油卡号','val'=>$data['jiayouc'],'width'=>'20'))} </td>
                    </tr>
                    <tr>
                        <td width="120" align="right" valign="middle">赣通卡号<font class="addred">*</font>：</td>
                        <td align="left"> {:inputs(array('name'=>'gantongc','val'=>$data['gantongc'],'place'=>'赣通卡号','width'=>'20'))} </td>
                        <td width="120" height="32" align="right" valign="middle">上次保险日期<font class="addred">*</font>：</td>
                        <td width="200" align="left">{:inputs(array('name'=>'safedate','val'=>showdate($data['safedate']),'add'=>'input-date','place'=>'上次保险日期','width'=>'20'))} </td>
                        <td width="120" align="right" valign="middle">年保险金额<font class="addred">*</font>：</td>
                        <td align="left"> {:inputs(array('type'=>'number','name'=>'safeprice','val'=>$data['safeprice'],'place'=>'年保险金额','width'=>'20'))} </td>
                    </tr>
                    <tr>
                        <td width="120" align="right" valign="middle">用途<font class="addred">*</font>：</td>
                        <td align="left"> {:inputs(array('name'=>'purpose','val'=>$data['purpose'],'place'=>'用途','width'=>'20'))} </td>
                    </tr>
                    <tr>
                        <td width="120" height="32" align="right" valign="middle">备注：</td>
                        <td align="left" colspan="5">
                            <textarea class="mytextarea form-control" name="remark" style="width:880px !important;">{$data.remark}</textarea>
                        </td>
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