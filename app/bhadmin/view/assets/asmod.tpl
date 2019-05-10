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
                        <td width="200" align="left">{:inputs(array('name'=>'driver','place'=>'驾驶员','val'=>$data['driver'],'width'=>'20'))} </td>
                        <td width="120" align="right" valign="middle">邮政编码<font class="addred">*</font>：</td>
                        <td align="left">{:inputs(array('type'=>'number','name'=>'post','place'=>'邮政编码','val'=>$data['post'],'width'=>'20'))}</td>
                    </tr>
                    <tr>
                        <td width="120" align="right" valign="middle">邮编地址<font class="addred">*</font>：</td>
                        <td align="left">{:inputs(array('name'=>'address','place'=>'邮编地址','val'=>$data['address'],'width'=>'20'))}
                         </td>
                        <td width="120" align="right" valign="middle">手机号码<font class="addred">*</font>：</td>
                        <td align="left"> {:inputs(array('type'=>'number','name'=>'phone','val'=>$data['phone'],'place'=>'手机号码','width'=>'20'))} </td>
                        <td width="120" align="right" valign="middle">经办人<font class="addred">*</font>：</td>
                        <td align="left"> {:inputs(array('name'=>'agent','place'=>'经办人','val'=>$data['agent'],'width'=>'20'))} </td>
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