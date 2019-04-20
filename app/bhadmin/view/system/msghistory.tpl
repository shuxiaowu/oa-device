<extend name="public/common" />
<block name="main">
 <div class="pubmain">
 <div class="panel-body" style="min-height:600px;">
 <form name="pubserch" method="get" action="" style="margin-bottom:10px;"> 
  <div class="search">
   目标：<input type="text" class="text" name="amount" placeholder="" style="width:120px;">
   &nbsp;发送成功：{:dropdown([['Id'=>1,'topic'=>'成功'],['Id'=>2,'topic'=>'失败']],0,'请选择','issuccess')}
   &nbsp;类目：{:dropdown([['Id'=>1,'topic'=>'手机发送'],['Id'=>2,'topic'=>'邮箱发送'],['Id'=>3,'topic'=>'微信发送'],['Id'=>4,'topic'=>'极光推送'],['Id'=>5,'topic'=>'模板消息']],0,'请选择','type')}
   &nbsp;发送时间：<input type="text" value="{$sday}" name="sday" class="textsort input-date">
   至&nbsp;<input type="text" value="{$eday}" name="eday" class="textsort input-date">
   &nbsp;{:btn(array('vals'=>'查询','type'=>'submit','icon'=>'search','name'=>'searchdata','round'=>1,'scene'=>'primary'))}
  </div>
  </form>
  <form name="publist" method="post" action="" onSubmit="return pubdel(document.publist)"> 
  <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center" class="{:tabstyle()}">
   <tr class="active">
     <td width="60" align="left" valign="middle">序号</td>
     <td width="180" valign="middle">目标手机/邮箱/微信</td>
     <td width="100" align="left" valign="middle">系统用户</td>
     <td width="80" align="center" valign="middle">类目</td>
     <td width="80" align="center" valign="middle">发送反馈</td>
     <td width="160" align="center" valign="middle">发送时间</td>
     <td align="left" valign="middle">信息内容</td>
   </tr>
   <volist name="data" id="obj">
   <tr class="maintr">
    <td align="left" valign="middle">{$dshow['pageno']+$i}</td>
    <td align="left" valign="middle">{$obj['amount']?:'--'}</td>
    <td align="left" valign="middle">{$obj['sysuser']?:'--'}</td>
    <td align="center" valign="middle">
     <if condition="$obj['type'] eq 1">手机</if>
     <if condition="$obj['type'] eq 2">邮箱</if>
     <if condition="$obj['type'] eq 3">微信</if>
     <if condition="$obj['type'] eq 4">极光推送</if>
     <if condition="$obj['type'] eq 5">模板消息</if>
     <if condition="$obj['type'] eq 6">eqmtt</if>
    </td>
    <td align="center" valign="middle">
     <if condition="$obj['successid'] eq 1"><font color="green">成功</font></if>
     <if condition="$obj['successid'] neq 1"><font color="red"{:tooltip($obj['successid'])}>失败</font></if>
    </td>
    <td align="center" valign="middle">{:date('Y-m-d H:i:s',$obj['date'])}</td>
    <td align="left" valign="middle"><div style="height:22px; line-height:22px; overflow:hidden; cursor:pointer;" {:tooltip(strip_tags($obj['msg']))}>{:strip_tags($obj['msg'])?:'--'}</div></td>
   </tr>
   </volist>
   <tr>
    <td height="35" colspan="7" align="left" valign="middle">
    <font class="text-warning">&nbsp;{:icon('warning-sign')} 发送记录暂时不支持删除 ！</font>
    {$dshow['pageshow']}
    </td>
   </tr>
   </table>
   </form>
 </div>
 </div>
 <script type="text/javascript">
   $(".msgshow").click(function(e) {
     $(this).height('90'); 
   });
 </script>
</block>