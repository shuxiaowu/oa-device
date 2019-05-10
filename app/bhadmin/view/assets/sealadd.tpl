<extend name="public/common" />
<block name="main">
    <div class="pubmain">
        <div class="panel-body">
            <form name="adminform" method="post" action="" onSubmit="return sysassets(document.adminform)">
                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="table tablevh">
                    <tr>
                        <td width="120" height="32" align="right" valign="middle">车牌号码<font class="addred">*</font>：</td>
                        <td width="200" align="left">{:dropdown($dengji,0,'请选择车牌号','licensenum','licensenum')}</td>
                        <td width="120" align="right" valign="middle">封存事由<font class="addred">*</font>：</td>
                        <td width="200" align="left">{:inputs(array('name'=>'fcreson','place'=>'封存事由','width'=>'20'))} </td>
                        <td width="120" align="right" valign="middle">日期<font class="addred">*</font>：</td>
                        <td align="left">{:inputs(array('name'=>'addtime','add'=>'input-date','val'=>datem(),'place'=>'日期','width'=>'20'))}</td>
                    </tr>
                    <tr>
                        <td width="120" align="right" valign="middle">经办人<font class="addred">*</font>：</td>
                        <td align="left"> {:inputs(array('name'=>'agent','place'=>'经办人','width'=>'20'))} </td>
                        <td width="200" align="right" valign="middle">封存期限<font class="addred">*</font>：</td>
                        <td align="center">{:inputs(array('name'=>'fcdatestart','add'=>'input-date','val'=>datem(),'place'=>'起始','width'=>'9.3'))}至{:inputs(array('name'=>'fcdateend','add'=>'input-date','val'=>datem(),'place'=>'结束','width'=>'9.3'))}
                         </td>
                    </tr>
                    <tr>
                        <td width="120" align="right" valign="middle">封存图片<font class="addred">*</font>：</td>
                        <td align="left"> {:uppicture('','图片上传',1,'fcpic')} </td>
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