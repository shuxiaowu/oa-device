<extend name="public/common" />
<block name="main">
 <div class="pubmain">
 <div class="panel-body">
  <form name="publist" method="post" action="" onSubmit="return pubdel(document.publist)"> 
  <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center" class="{:tabstyle()}">
   <tr class="active">
     <td width="60" align="left" valign="middle">序号</td>
     <td width="180" valign="middle">登录名</td>
     <td width="120" align="left" valign="middle">登录IP</td>
     <td align="left" valign="middle">登录时间</td>
   </tr>
   <volist name="data" id="obj">
   <tr class="maintr">
    <td align="left" valign="middle">{$dshow['pageno']+$i}</td>
    <td align="left" valign="middle">{$obj['user']}</td>
    <td align="left" valign="middle">{$obj['ip']?:'--'}</td>
    <td align="left" valign="middle">{$obj['date']?:'--'}</td>
   </tr>
   </volist>
   <tr>
    <td height="35" colspan="4" align="left" valign="middle">
    {$dshow['pageshow']}
    </td>
   </tr>
   </table>
   </form>
 </div>
 </div>
</block>