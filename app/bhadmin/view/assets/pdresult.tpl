<extend name="public/common" />
<block name="main">
  <div class="pubmain" style="min-width:1400px;">
    <div class="panel-body">
        <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center" class="{:tabstyle()}">
          <tr class="active">
            <td width="45" align="center" valign="middle" height="37">序号</td>
            <td width="140" align="center" valign="middle">盘点单号</td>
            <td width="150" align="left" valign="middle">设备编号</td>
            <td align="left" valign="middle">盘点时间</td>
          </tr>
          <volist name="data" id="obj">
            <tr class="maintr">
              <td align="center" valign="middle" height="37">{$dshow['pageno']+$i}</td>
              <td align="center" valign="middle">{$obj['pdsn']}</td>
              <td align="left" valign="middle">{$obj['devno']}</td>
              <td align="left" valign="middle">{:date('Y-m-d H:i:s',$obj['pdtime'])}</td>
            </tr>
          </volist>
          <tr>
            <td height="37" align="center" valign="middle"> </td>
            <td height="35" colspan="22" align="left" valign="middle">{$dshow['pageshow']} </td>
          </tr>
        </table>

      
    </div>
  </div>
</block>
