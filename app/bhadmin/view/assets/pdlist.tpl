<extend name="public/common" />
<block name="main">
  <div class="pubmain" style="min-width:1400px;">
    <div class="panel-body">
      <div class="u-plus btn-group">
        {:btn(array('vals'=>'新建盘点任务','size'=>3,'scene'=>'primary','url'=>url('assets/pdadd')))}
      </div>
      <form name="pubserch" method="get" action="{:url('assets/assetslist')}">
        <div class="search"> 任务名称/盘点单号：
          <input type="text" class="text" name="name" placeholder="任务名称/盘点单号" style="width:180px;">
          资产类目：{:dropdown([['Id'=>1,'topic'=>'闲置资产'],['Id'=>2,'topic'=>'维护资产'],['Id'=>3,'topic'=>'报废资产']],0,'请选择','state')}
          &nbsp;{:btn(array('vals'=>'查询','type'=>'submit','icon'=>'search','name'=>'searchdata','round'=>1,'scene'=>'primary'))}
        </div>
      </form>
      <div class="ui-block"></div>
      <form name="publist" method="post" action="" onSubmit="return pubdel(document.publist)">
        <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center" class="{:tabstyle()}">
          <tr class="active">
            <td width="45" align="center" valign="middle" height="37">{:ckall()}</td>
            <td width="140" align="center" valign="middle">盘点单号</td>
            <td width="150" align="left" valign="middle">盘点任务名称</td>
            <td width="140" align="center" valign="middle">盘点开始时间</td>
            <td width="140" align="center" valign="middle">盘点结束时间 </td>
            <td width="140" align="center" valign="middle">盘点执行人</td>
            <td width="140" align="center" valign="middle">盘点状态</td>
            <td width="140" align="center" valign="middle">盘点备注</td>
            <td align="left" valign="middle">操作</td>
          </tr>
          <volist name="data" id="obj">
            <tr class="maintr">
              <td align="center" valign="middle" height="37">{:ckbox($obj['Id'],$i-1)}</td>
              <td align="center" valign="middle">{$obj['sn']}</td>
              <td align="left" valign="middle">{$obj['topic']}</td>
              <td align="center" valign="middle">{$obj['sdate']}</td>
              <td align="center" valign="middle">{$obj['edate']}</td>
              <td align="center" valign="middle">{:getdata('adminuser',$obj['adminuid'],'realname')}</td>
              <td align="center" valign="middle">
               <if condition="$obj['state'] eq 1"><font color="red">待完成</font></if>
               <if condition="$obj['state'] eq 2"><font color="green">已完成</font></if>
              </td>
              <td align="center" valign="middle">{$obj['remark']}</td>
              <td align="left" valign="middle">
                {:btn(array('vals'=>'编辑','icon'=>'edit','round'=>1,'tips'=>'点击编辑数据','url'=>url('assets/pdmod','id='.$obj['Id'])))}
                {:btn(array('vals'=>'删除','icon'=>'trash','round'=>1,'tips'=>'点击删除数据','scene'=>'danger'))}
                {:btn(array('vals'=>'结果','faicon'=>'list','round'=>1,'tips'=>'点击查看盘点结果','scene'=>'success','url'=>url('assets/pdresult','sn='.$obj['sn'])))}
              </td>
            </tr>
          </volist>
          <tr>
            <td height="37" align="center" valign="middle">{:ckall(2)}</td>
            <td height="35" colspan="22" align="left" valign="middle">{$dshow['pageshow']} </td>
          </tr>
        </table>
      </form>
      
    </div>
  </div>
</block>
