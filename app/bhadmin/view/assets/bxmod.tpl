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
                        <td width="120" align="right" valign="middle">保险期限<font class="addred">*</font>：</td>
                        <td align="left">{:inputs(array('name'=>'deadlinestart','add'=>'input-date','val'=>showdate($data['deadlinestart']),'place'=>'起始','width'=>'20'))}-{:inputs(array('name'=>'deadlineend','add'=>'input-date','val'=>showdate($data['deadlineend']),'place'=>'结束','width'=>'20'))}</td>
                    </tr>
                    <tr>
                        <td width="120" align="right" valign="middle">保险金额<font class="addred">*</font>：</td>
                        <td align="left">{:inputs(array('type'=>'number','name'=>'price','place'=>'保险金额','val'=>$data['price'],'width'=>'20'))}
                         </td>
                        <td width="120" align="right" valign="middle">保险单号码<font class="addred">*</font>：</td>
                        <td align="left"> {:inputs(array('name'=>'bxnum','val'=>$data['bxnum'],'place'=>'保险单号码','width'=>'20'))} </td>
                        <td width="120" align="right" valign="middle">保险公司名称<font class="addred">*</font>：</td>
                        <td align="left"> {:inputs(array('name'=>'bxname','val'=>$data['bxname'],'place'=>'保险公司名称','width'=>'20'))} </td>
                    </tr>
                    <tr>
                        <td width="120" align="right" valign="middle">有无事故<font class="addred">*</font>：</td>
                        <td align="left">{:dropdown([['Id'=>1,'topic'=>'有'],['Id'=>2,'topic'=>'没有']],$data['isaccident'],isaccident($data['isaccident']),'isaccident')}</td>
                        <td width="120" align="right" valign="middle">责任比例<font class="addred">*</font>：</td>
                        <td align="left">{:inputs(array('name'=>'ratio','place'=>'责任比例','val'=>$data['ratio'],'width'=>'20'))}</td>
                        <td width="120" align="right" valign="middle">所赔金额<font class="addred">*</font>：</td>
                        <td align="left"> {:inputs(array('type'=>'number','name'=>'payloss','place'=>'所赔金额','val'=>$data['payloss'],'width'=>'20'))} </td>
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