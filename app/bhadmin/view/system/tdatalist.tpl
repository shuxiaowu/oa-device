<extend name="public/common" />
<block name="main">
  <div class="pubmain">
    <div class="panel-body">
    <form name="pubserch" method="get" action="{:url('system/tdatalist')}">
      <div class="search"> 查询条件：
        <input type="text" class="text" name="where" value="{$where}" placeholder="查询条件" style="width:200px;">
        排序：<input type="text" class="text" name="order" value="{$order}" placeholder="排序条件" style="width:100px;">
        <input type="hidden" value="{$dshow['table']}" name="tb">
        &nbsp;{:btn(array('vals'=>'查询','type'=>'submit','icon'=>'search','name'=>'searchdata','round'=>1,'scene'=>'primary'))} </div>
    </form>
    <?php
      if ( !$data ) echo '<div class="alert alert-danger">条件下暂无资料！</div>';
    ?>
    <div class="ui-block"></div>
      <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center" class="{:tabstyle()}">
        <tr class="active">
          <?php
            if ( $data ) {
              foreach( $data[0] as $kk=>$vv ) {
                echo '<td>'.$kk.'</td>';
              }
            }
          ?>
        </tr>
        <?php
          if ( $data ) {
            foreach( $data as $dk=>$dv ) {
        ?>
        <tr>
         <?php
            foreach( $dv as $d=>$v ) {
              echo '<td><div style="height:22px; line-height:22px; overflow:hidden; cursor:pointer;" '.tooltip(strip_tags($v)).'>'.strip_tags($v).'</div></td>';
            }
         ?>
        </tr>
        <?php }}?>
      </table>
      <div style="margin:10px;">{$dshow['pageshow']}</div>
    </div>
  </div>
</block>
