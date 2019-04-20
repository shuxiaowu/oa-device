<extend name="public/common" />
<block name="main">
  <div class="pubmain">
    <div class="panel-body">
      <form name="adminform" method="post" action="" onSubmit="return systype(document.adminform)">
        <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="{:tabstyle()}">
          <tr>
            <td width="10%" height="32" align="right" valign="middle">资料标题：</td>
            <td height="32" align="left">{:inputs(array('name'=>'topic','scene'=>'topic','tips'=>'资料标题（*必填）'))}</td>
          </tr>
          <tr <if condition="$sty neq 2 or $tables eq 'buildtype'"><else/>class="hide"</if>>
           <td align="right" valign="middle">类目配图：</td>
           <td align="left">{:uppic(array('tips'=>'请上传类目配图：200*200px的图片。','w'=>200,'h'=>200))}</td>
          </tr> 
          <tr <if condition="$sty neq 2">class="hide"</if>>
            <td width="10%" height="32" align="right" valign="middle">类别说明：</td>
            <td height="32" align="left">{:inputs(array('name'=>'domain','place'=>'类别说明'))}</td>
          </tr>
          <tr>
            <td height="32" align="right" valign="middle">是否启用：</td>
            <td height="32" align="left">{:checkbox(0,1)} <span class="text-warning"> 注：勾选表示启用</span></td>
          </tr>
          <tr>
            <td height="32" align="right" valign="middle">类别排序：</td>
            <td height="32" align="left">{:inputs(array('name'=>'ord','scene'=>'ord'))}</td>
          </tr>
          <tr>
            <td height="32" align="right" valign="middle">&nbsp;</td>
            <input type="hidden" value="{$tables}" name="tables">
            <input type="hidden" value="{$sty}" name="sty">
            <td height="32" align="left">{:btn(array('vals'=>'提交','size'=>3,'type'=>'submit','icon'=>'cog','scene'=>'primary'))}</td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</block>
