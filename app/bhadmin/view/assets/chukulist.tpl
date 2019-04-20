<extend name="public/common" />
<block name="main">
  <div class="pubmain" style="min-width:1200px;">
    <div class="panel-body">
      <div class="u-plus btn-group">
        {:btn(array('vals'=>'新建领用单','size'=>3,'scene'=>'primary','url'=>url('assets/chukuadd')))}

      </div>
      <form name="pubserch" method="get" action="{:url('assets/assetslist')}">
        <div class="search"> 领用编码/名称：
          <input type="text" class="text" name="name" placeholder="资产编码/名称/领用单号" style="width:180px;">
          资产类目：{:dropdown([['Id'=>1,'topic'=>'闲置资产'],['Id'=>2,'topic'=>'维护资产'],['Id'=>3,'topic'=>'报废资产']],0,'请选择','state')}
          &nbsp;{:btn(array('vals'=>'查询','type'=>'submit','icon'=>'search','name'=>'searchdata','round'=>1,'scene'=>'primary'))}
        </div>
      </form>
      <div class="ui-block"></div>
      <form name="publist" method="post" action="" onSubmit="return pubdel(document.publist)">
        <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center" class="{:tabstyle()}">
          <tr class="active">
            <td width="45" align="center" valign="middle" height="37">{:ckall()}</td>
            <td width="100" align="center" valign="middle">领用单号</td>
            <td width="100" align="center" valign="middle">领用部门</td>
            <td width="100" align="center" valign="middle">领用人</td>
            <td width="100" align="center" valign="middle">申请时间</td>
            <td width="100" align="center" valign="middle">领用备注</td>
            <td width="100" align="center" valign="middle">领用状态</td>
            <td width="100" align="center" valign="middle">领用时间</td>
            <td width="100" align="center" valign="middle">全部归还</td>
            <td width="140" align="center" valign="middle">操作</td>
          </tr>
          <volist name="data" id="obj">
            <tr class="maintr">
             <td align="center" valign="middle" height="37">{:ckbox($obj['Id'],$i-1)}</td>
             <td align="center" valign="middle">{$obj['danhao']}</td>
             <td align="center" valign="middle">{$obj['branch']}</td>
             <td align="center" valign="middle">{$obj['recipient']}</td>
             <td align="center" valign="middle">{$obj['applydate']}</td>
             <td align="center" valign="middle">{$obj['remark']}</td>
             <td align="center" valign="middle">{$obj['state']}</td>
             <td align="center" valign="middle">{$obj['lingdate']}</td>
             <td align="center" valign="middle">{$obj['guihuan']}</td>
              <td align="center" valign="middle">
                {:btn(array('vals'=>'编辑','icon'=>'edit','round'=>1,'tips'=>'点击编辑数据','url'=>url('assets/chukumod','id='.$obj['Id'])))}
                {:btn(array('vals'=>'删除','icon'=>'trash','round'=>1,'tips'=>'点击删除数据','scene'=>'danger'))}
              </td>
           </tr>
         </volist>
         </table>
       </form>

     </div>
   </div>
 </block>
