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
                        <td width="120" align="right" valign="middle">日期<font class="addred">*</font>：</td>
                        <td align="left">{:inputs(array('name'=>'adddate','val'=>datem(),'add'=>'input-date','place'=>'日期','width'=>'20'))}</td>
                    </tr>
                    <tr>                        
                        <td width="120" align="right" valign="middle">加油地点<font class="addred">*</font>：</td>
                        <td align="left"> {:inputs(array('name'=>'address','place'=>'加油地点','width'=>'20'))} </td>
                        <td width="120" align="right" valign="middle">费用(元)<font class="addred">*</font>：</td>
                        <td align="left"> {:inputs(array('type'=>'number','name'=>'price','place'=>'费用(元)','width'=>'20'))} </td>
                         <td width="120" align="right" valign="middle">核检人<font class="addred">*</font>：</td>
                        <td align="left"> {:inputs(array('name'=>'checkman','place'=>'核检人','width'=>'20'))} </td>
                    </tr>
                    <tr>
                        <td width="120" align="right" valign="middle">加油类型<font class="addred">*</font>：</td>
                        <td align="left"> {:inputs(array('name'=>'gastype','place'=>'加油类型','width'=>'20'))} </td>
                        <td width="120" align="right" valign="middle">加油量(升)<font class="addred">*</font>：</td>
                        <td align="left"> {:inputs(array('type'=>'number','name'=>'gasvolum','place'=>'加油量(升)','width'=>'20'))} </td>
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