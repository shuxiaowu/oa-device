<extend name="public/common" />
<block name="main">
  <div class="pubmain">
    <div class="panel-body">
      <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center" class="{:tabstyle()}">
        <tr class="active">
          <td width="60" align="left" valign="middle">序号</td>
          <td width="120" valign="middle">字段名</td>
          <td width="185" align="left" valign="middle">数据类型</td>
          <td width="80" align="center" valign="middle">是否为空</td>
          <td width="80" align="center" valign="middle">Key</td>
          <td width="80" align="center" valign="middle">默认</td>
          <td align="left" valign="middle">Extra</td>
        </tr>
        <if condition="$data neq ''">
        <volist name="data" id="dobj">
        <tr>
          <td width="60" align="left" valign="middle">{$key+1}</td>
          <td align="left" valign="middle">{$dobj['Field']}</td>
          <td align="left" valign="middle">{$dobj['Type']}</td>
          <td align="center" valign="middle">{$dobj['Null']}</td>
          <td align="center" valign="middle">{$dobj['Key']}</td>
          <td align="center" valign="middle">
          <?php
            if ( $dobj['Default'] == '0' ){
              echo '0';
            } else if($dobj['Default'] === ''){
              echo '空';
            } else if ( $dobj['Default'] == NULL ) {
              echo 'NULL';
            } else {
              echo $dobj['Default'];
            }
          ?>
          </td>
          <td valign="middle">{$dobj['Extra']}</td>
        </tr>
        </volist>
        </if>
        
      </table>
    </div>
  </div>
</block>
