<extend name="public/common" />
<block name="main">
  <div class="pubmain">
    <div class="panel-body">
      <form name="adminform" method="post" action="" onSubmit="return systype(document.adminform)">
        <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="{:tabstyle()}">
          <tr>
            <td width="10%" height="32" align="right" valign="middle">资料标题：</td>
            <td height="32" align="left">{:inputs(array('name'=>'topic','scene'=>'topic','val'=>$data['topic'],'tips'=>'资料标题（*必填）'))}</td>
          </tr>
          <tr <if condition="$data['sty'] eq 2 or $tables eq 'buildtype'"><else/>class="hide"</if>>
           <td align="right" valign="middle">类目配图：</td>
           <td align="left">{:uppic(array('tips'=>'请上传类目配图：200*200px的图片。','pic'=>$data['pic'],'w'=>200,'h'=>200))}</td>
          </tr> 
          <tr <if condition="$data['sty'] neq 2">class="hide"</if>>
            <td width="10%" height="32" align="right" valign="middle">类别说明：</td>
            <td height="32" align="left">{:inputs(array('name'=>'domain','val'=>$data['domain']))}</td>
          </tr>
          <tr>
            <td height="32" align="right" valign="middle">是否启用：</td>
            <td height="32" align="left">{:checkbox($data['enabled'])} <span class="text-warning"> 注：勾选表示启用</span></td>
          </tr>
          <tr>
            <td height="32" align="right" valign="middle">资料排序：</td>
            <td height="32" align="left">{:inputs(array('name'=>'ord','val'=>$data['ord'],'scene'=>'ord'))}</td>
          </tr>
          <tr>
            <td height="32" align="right" valign="middle">&nbsp;</td>
            <input type="hidden" value="{$tables}" name="tables">
            <input type="hidden" value="{$data['Id']}" name="id">
            <td height="32" align="left">{:btn(array('vals'=>'确定修改','size'=>3,'type'=>'submit','icon'=>'edit','scene'=>'primary'))}</td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</block>
