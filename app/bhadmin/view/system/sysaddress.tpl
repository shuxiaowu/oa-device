<extend name="public/common" />
<block name="main">
 <div class="pubmain">
 <div class="panel-body">
 <form name="pubserch" method="get" action=""> 
  <div class="search" style="margin-bottom:10px;">
   地址名称：<input type="text" class="text" name="name" value="{$name}" placeholder="地址名称" style="width:150px;">
   &nbsp;{:btn(array('vals'=>'查询','type'=>'submit','icon'=>'search','name'=>'searchdata','round'=>1,'scene'=>'primary'))}
  </div>
  </form>
 <form name="publist" method="post" action="" onSubmit="return pubdel(document.publist)"> 
  <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center" class="{:tabstyle()}">
   <tr class="active">
     <td width="60" align="center" valign="middle">序号</td>
     <td width="70" align="center" valign="middle">地址ID</td>
     <td width="150" valign="middle">地址名称</td>
     <td width="150" align="center" valign="middle">地址所属</td>
     <td width="110" align="center" valign="middle">地址等级</td>
     <td width="110" align="center" valign="middle">是否热门</td>
     <td width="120" align="center" valign="middle">是否启用</td>
     <td align="left" valign="middle">操作</td>
   </tr>
   <volist name="data" id="obj">
   <tr class="maintr">
    <td align="center" valign="middle">{$dshow['pageno']+$i}</td>
    <td align="center" valign="middle">{$obj['Id']}</td>
    <td align="left" valign="middle">{:modField($obj['name'],$obj['Id'],'name',$dshow['table'])}</td>
    <td align="center" valign="middle">{:gaddress($obj['upid'],'--')}</td>
    <td align="center" valign="middle">
    <if condition="$obj['level'] eq 1">省/行政区</if>
    <if condition="$obj['level'] eq 2">市</if>
    <if condition="$obj['level'] eq 3">区</if>
    <if condition="$obj['level'] eq 4">街道</if>
    </td>
    <td align="center" valign="middle">{:modattr($obj['Id'],$obj['ishot'],$dshow['table'],'ishot',array('热门','取消'))}</td>
    <td align="center" valign="middle">{:modattr($obj['Id'],$obj['enabled'],$dshow['table'])}</td>
    <td align="left" valign="middle">
     <if condition="$obj['level'] neq 4">
      	{:btn(array('vals'=>'添加','scene'=>'danger','tips'=>'添加数据到'.$obj['name'].'旗下','round'=>1,'url'=>url('system/addressadd','did='.$obj['Id'].'&lev='.((int)$obj['level']+1)))).'&nbsp;'} 
	    {:btn(array('vals'=>'查看','icon'=>'eye-open','scene'=>'success','tips'=>'点击查看旗下数据','round'=>1,'url'=>url('system/sysaddress','lev='.((int)$obj['level']+1).'&did='.$obj['Id']))).'&nbsp;'}
     <else/>
     	{:btn(array('vals'=>'添加','scene'=>'danger','round'=>1,'ban'=>1)).'&nbsp;'}
	    {:btn(array('vals'=>'查看','icon'=>'eye-open','scene'=>'success','round'=>1,'ban'=>1)).'&nbsp;'}
     </if>
     {:btn(array('vals'=>'编辑','icon'=>'edit','tips'=>'点击编辑数据','round'=>1,'url'=>url('system/addressmod','id='.$obj['Id'])))}
    </td>
   </tr>
   </volist>
   <if condition="$dshow['pageshow'] neq ''">
   <tr>
    <td height="35" colspan="9" align="left" valign="middle">
     {$dshow['pageshow']}
    </td>
   </tr>
   </if>
   </table>
   </form>
 </div>
 </div>
</block>