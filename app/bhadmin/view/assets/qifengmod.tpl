<extend name="public/common" />
<block name="main">
    <div class="pubmain">
        <div class="panel-body">
            <form name="adminform" method="post" action="" onSubmit="return sysassets(document.adminform)">
                <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="table tablevh">
                    <tr>
                        <td width="120" height="32" align="right" valign="middle">车牌号码<font class="addred">*</font>：</td>
                        <td width="200" align="left">{:dropdown($dengji,$data['licensenum'],gtopic('usecar',$data['licensenum'],'licensenum'),'licensenum','licensenum')}</td>
                        <td width="120" align="right" valign="middle">启封事由<font class="addred">*</font>：</td>
                        <td width="200" align="left">{:inputs(array('name'=>'qfreson','place'=>'启封事由','val'=>$data['qfreson'],'width'=>'20'))} </td>
                        <td width="120" align="right" valign="middle">启封日期<font class="addred">*</font>：</td>
                        <td align="left">{:inputs(array('name'=>'addtime','val'=>$data['addtime'],'add'=>'input-date','place'=>'日期','width'=>'20'))}</td>
                    </tr>
                    <tr>
                        <td width="120" align="right" valign="middle">经办人<font class="addred">*</font>：</td>
                        <td align="left"> {:inputs(array('name'=>'agent','place'=>'经办人','val'=>$data['agent'],'width'=>'20'))} </td>
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