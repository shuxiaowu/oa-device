<extend name="public/common" />
<block name="main">
  <div class="pubmain">
    <div class="panel-body">
      <form name="adminform" method="post" action="" onSubmit="return sysassets(document.adminform)">
        <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="table tablevh">
          <tr>
            <td width="120" height="32" align="right" valign="middle">资产编码<font class="addred">*</font>：</td>
            <td width="200" align="left">{:inputs(array('name'=>'devno','val'=>$data['devno'],'place'=>'请输入资产编码','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">资产名称<font class="addred">*</font>：</td>
            <td width="200" align="left">{:inputs(array('name'=>'devname','val'=>$data['devname'],'place'=>'请输入资产名称','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">资产类别<font class="addred">*</font>：</td>
            <td align="left">{:searchField(['tables'=>'assetstype','field'=>'topic','val'=>$data['devtype'],'s_field'=>'topic','name'=>'devtype','width'=>200,'default'=>getdata('assetstype',$data['devtype'])])}</td>
          </tr>
          <tr>
            <td width="120" height="32" align="right" valign="middle">入库时间<font class="addred">*</font>：</td>
            <td width="200" align="left">{:inputs(array('name'=>'rkdate','val'=>$data['rkdate'],'add'=>'input-date','place'=>'选择入库时间','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">型号：</td>
            <td width="200" align="left">{:inputs(array('name'=>'devxh','val'=>$data['devxh'],'place'=>'请输入型号','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">计量单位：</td>
            <td align="left"> {:inputs(array('name'=>'units','place'=>'请输入计量单位','val'=>$data['units'],'width'=>'20'))} </td>
          </tr>
          <tr>
            <td width="120" height="32" align="right" valign="middle">来源<font class="addred">*</font>：</td>
            <td width="200" align="left">{:searchField(['tables'=>'assetssource','field'=>'topic','val'=>$data['source'],'s_field'=>'topic','name'=>'source','width'=>200,'default'=>getdata('assetssource',$data['source'])])}</td>
            <td width="120" align="right" valign="middle">渠道：</td>
            <td width="200" align="left">{:inputs(array('name'=>'channel','val'=>$data['channel'],'place'=>'请输入渠道','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">金额：</td>
            <td align="left"> {:inputs(array('name'=>'price','place'=>'请输入金额','val'=>$data['price'],'width'=>'20'))} </td>
          </tr>
          <tr>
            <td width="120" height="32" align="right" valign="middle">品牌<font class="addred">*</font>：</td>
            <td width="200" align="left">{:inputs(array('name'=>'brand','place'=>'请输入品牌','val'=>$data['brand'],'width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">购入时间<font class="addred">*</font>：</td>
            <td width="200" align="left">{:inputs(array('name'=>'buydate','add'=>'input-date','val'=>$data['buydate'],'place'=>'请选择购入时间','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle"> 使用期限：</td>
            <td align="left"> {:inputs(array('name'=>'uselimit','place'=>'请输入使用期限','val'=>$data['uselimit'],'units'=>'月','width'=>'20'))} </td>
          </tr>
          <tr>
            <td width="120" height="32" align="right" valign="middle">SN号：</td>
            <td width="200" align="left">{:inputs(array('name'=>'sn','val'=>$data['sn'],'place'=>'SN号','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">保修起始：</td>
            <td width="200" align="left">{:inputs(array('name'=>'bxsdate','val'=>$data['bxsdate'],'add'=>'input-date','place'=>'请选择保修起始','width'=>'20'))} </td>
            <td width="120" align="right" valign="middle">过保时间：</td>
            <td align="left"> {:inputs(array('name'=>'bxedate','val'=>$data['bxedate'],'place'=>'请选择过保时间','add'=>'input-date','width'=>'20'))} </td>
          </tr>
          <tr>
            <td width="120" height="32" align="right" valign="middle">图片：</td>
            <td align="left" colspan="5">
             {:uppic(['pic'=>$data['pic'],'tips'=>'请选择设备图片，尺寸保持在400*400即可'])}
            </td>
          </tr> 
          <tr>
            <td width="120" height="32" align="right" valign="middle">备注：</td>
            <td align="left" colspan="5">
            <textarea class="mytextarea form-control" name="remark" style="width:880px !important;">{$data['remark']}</textarea>
            </td>
          </tr> 
          <tr>
            <td width="120" height="32" align="right" valign="middle">配置：</td>
            <td align="left" colspan="5">
            <textarea class="mytextarea form-control" name="devsetup" style="width:880px !important;">{$data['devsetup']}</textarea>
            </td>
          </tr> 
          <tr>
            <td width="120" height="32" align="right" valign="middle">额外配置：</td>
            <td align="left" colspan="5">
            <textarea class="mytextarea form-control" name="devsetup2" style="width:880px !important;">{$data['devsetup2']}</textarea>
            </td>
          </tr> 
          <tr>
            <td height="32" align="right" valign="middle">&nbsp;</td>
            <input type="hidden" value="{$data['Id']}" name="id">
            <td colspan="5"align="left">{:btn(array('vals'=>'确定修改','size'=>3,'type'=>'submit','icon'=>'edit','scene'=>'primary'))}</td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</block>
