<extend name="public/common" />
<block name="main">
  <div class="pubmain">
    <div class="panel-body">
      <form name="adminform" method="post" action="" onSubmit="return sysabout(document.adminform)">
        <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="{:tabstyle()}">
          <tr>
            <td width="10%" height="32" align="right" valign="middle">盘点任务名称：</td>
            <td height="32" align="left">{:inputs(array('name'=>'topic','val'=>$data['topic'],'place'=>'盘点任务名称（*必填）'))}</td>
          </tr>
          <tr>
            <td width="10%" height="32" align="right" valign="middle">盘点人：</td>
            <td height="32" align="left">{:searchField(['tables'=>'adminuser','field'=>'realname','val'=>$data['adminuid'],'s_field'=>'realname','name'=>'adminuid','width'=>200,'default'=>getdata('adminuser',$data['adminuid'],'realname')])}</td>
          </tr>          
          <tr>
            <td width="10%" height="32" align="right" valign="middle">盘点开始时间：</td>
            <td height="32" align="left">
              {:inputs(array('name'=>'sdate','add'=>'input-date','val'=>$data['sdate'],'place'=>'盘点开始时间','width'=>'20'))} {:inputs(array('name'=>'edate','val'=>$data['edate'],'add'=>'input-date','place'=>'盘点结束时间','width'=>'20'))}
            </td>
          </tr> 
          <tr>
            <td height="32" align="right" valign="middle">盘点备注：</td>
            <td height="32" align="left">{:inputs(array('name'=>'remark','type'=>'textarea','val'=>$data['remark'],'place'=>'盘点备注'))}</td>
          </tr>
          
          <tr>
            <td height="32" align="right" valign="middle">&nbsp;</td>
            <input type="hidden" value="{$data['Id']}" name="id">
            <td height="32" align="left">{:btn(array('vals'=>'确定修改','size'=>3,'type'=>'submit','icon'=>'cog','scene'=>'primary'))}</td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</block>
