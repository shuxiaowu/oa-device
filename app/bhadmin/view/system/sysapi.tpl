<extend name="public/common" />
<block name="main">
 <div class="pubmain" style="height:auto; min-height:auto;">
 <div class="panel-body">
  <div class="u-plus">{:btn(array('vals'=>'添加TOKEN','size'=>3,'icon'=>'plus','scene'=>'primary','url'=>url('system/apiadd')))}</div>
  <form name="publist" method="post" action="" onSubmit="return pubdel(document.publist)"> 
  <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center" class="{:tabstyle()}">
   <tr class="active">
     <td width="45" align="center" valign="middle" height="37">{:ckall()}</td>
     <td width="100" align="center" valign="middle">身份</td>
     <td width="100" align="center" valign="middle">appid</td>
     <td width="100" align="center" valign="middle">secret</td>
     <td width="200" align="left" valign="middle">备注</td>
     <td width="120" align="center" valign="middle">启用</td>
     <td width="160" align="center" valign="middle">添加时间</td>
     <td align="left" valign="middle"></td>
   </tr>
   <volist name="data" id="obj">
   <?php
     $secret   = $obj['secret'];
     $mdsecret = substr($secret,0,2).'***'.substr($secret,30,2);
   ?>
   <tr class="maintr">
    <td align="center" valign="middle" height="37">{:ckbox($obj['Id'],$i-1)}</td>
    <td align="center" valign="middle">{$obj['type']}</td>
    <td align="center" valign="middle">{$obj['appid']}</td>
    <td align="center" valign="middle"><a href="javascript:void(0)" class="showsecret" data-secret="{$secret}"{:tooltip('点击查看完整secret')}>{$mdsecret}</a></td>
    <td align="left" valign="middle">{$obj['remark']?:'--'}</td>
    <td align="center" valign="middle">{:modattr($obj['Id'],$obj['enabled'],$dshow['table'])}</td>
    <td align="center" valign="middle">{$obj['date']?:'未登录'}</td>
    <td align="left" valign="middle"></td>
   </tr>
   </volist>
   <tr>
    <td height="37" align="center" valign="middle">{:ckall(2)}</td>
    <td height="35" colspan="8" align="left" valign="middle">
    {:btn(array('vals'=>'删除','type'=>'submit','name'=>'deldata','round'=>1,'icon'=>'trash','scene'=>'danger'))}
    {$dshow['pageshow']}
    </td>
   </tr>
   </table>
   </form>
   <div class="alert alert-info" style="margin:10px auto">{:icon('warning-sign')} 提示，任何形式删除的数据都无法找回。</div>
 </div>
 
 </div>
 <script type="text/javascript">
   $(".showsecret").click(function(e) {
     $(this).text($(this).data('secret')); 
   });
 </script>
</block>