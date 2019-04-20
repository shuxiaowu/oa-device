<extend name="public/common" />
<block name="main">
  <div class="pubmain">
    <div class="panel-body">
      <form name="adminform" method="post" action="" onSubmit="return sysassets(document.adminform)">
        <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="table tablevh">
      <tr>
            <td width="120" height="32" align="right" valign="middle">领用单号<font class="addred">*</font>：</td>
            <td width="200" align="left">{:inputs(array('name'=>'danhao','val'=>$data['danhao'],'place'=>'请输入领用单号','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">领用部门<font class="addred">*</font>：</td>
            <td width="200" align="left">{:inputs(array('name'=>'branch','val'=>$data['branch'],'place'=>'请输入领用部门','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">领用人<font class="addred">*</font>：</td>
            <td align="left">{:inputs(array('name'=>'recipient','val'=>$data['recipient'],'place'=>'请输入领用人','width'=>'20'))}</td>
          </tr>
          <tr>
            <td width="120" height="32" align="right" valign="middle">申请时间<font class="addred">*</font>：</td>
            <td width="200" align="left">{:inputs(array('name'=>'applydate','val'=>$data['applydate'],'add'=>'input-date','place'=>'选择申请时间','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">领用状态：</td>
            <td width="200" align="left">{:dropdown([['Id'=>1,'topic'=>'未领用'],['Id'=>2,'topic'=>'领用']],$data['state'],'请选择','state')}</td>
            <td width="120" align="right" valign="middle">领用时间：</td>
            <td align="left"> {:inputs(array('name'=>'lingdate','val'=>$data['lingdate'],'add'=>'input-date','place'=>'选择领用时间','width'=>'20'))} </td>
          </tr>
          <tr>
            <td width="120" height="32" align="right" valign="middle">领用备注：</td>
            <td align="left" colspan="5">
            <textarea class="mytextarea form-control" name="remark" style="width:880px !important;">{$data['remark']}</textarea>
            </td>
          </tr> 
          <tr>
            <td width="120" height="32" align="right" valign="middle">全部归还：</td>
            <td align="left" colspan="5">
            <textarea class="mytextarea form-control" name="guihuan" style="width:880px !important;">{$data['guihuan']}</textarea>
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
