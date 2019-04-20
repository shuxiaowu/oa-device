<extend name="public/common" />
<block name="main">
  <div class="pubmain">
    <div class="panel-body">
      <form name="pubserch" method="get" action="">
        <div class="search"> 接口名称：
          <input type="text" class="text" name="url" placeholder="接口名称" style="width:150px;">
          &nbsp;身份：
          <input type="text" class="text" name="apitype" value="{$apitype}" placeholder="身份" style="width:80px;">
          &nbsp;请求时间：
          <input type="text" value="{$sday}" name="sday" class="textsort input-date">
          至&nbsp;
          <input type="text" value="{$eday}" name="eday" class="textsort input-date">
          &nbsp;{:btn(array('vals'=>'查询','type'=>'submit','icon'=>'search','name'=>'searchdata','round'=>1,'scene'=>'primary'))} </div>
      </form>
      <div class="ui-block"></div>
      <form name="publist" method="post" action="" onSubmit="return pubdel(document.publist)">
        <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center" class="{:tabstyle()}">
          <tr class="active">
            <td width="45" align="center" valign="middle" height="37">{:ckall()}</td>
            <td width="60" align="left" valign="middle">序号</td>
            <td align="left" valign="middle">请求链接</td>
            <td width="100" align="left" valign="middle">身份</td>
            <td width="160" align="center" valign="middle">请求日期</td>
            <td width="140" align="center" valign="middle">请求参数</td>
          </tr>
          <volist name="data" id="obj">
            <tr class="maintr">
              <td align="center" valign="middle" height="37">{:ckbox($obj['Id'],$i-1)}</td>
              <td align="left" valign="middle">{$dshow['pageno']+$i}</td>
              <td>{$obj['url']}</td>
              <td>{$obj['apitype']}</td>
              <td align="center">{:date('Y-m-d H:i:s',$obj['date'])}</td>
              <td align="center"><button class="btn btn-xs btn-success btn-show" type="button" data-id="{$obj['Id']}"><span class="glyphicon glyphicon-eye-open"></span> 查看</button>
                {:btn(['vals'=>'模拟','faicon'=>'github-alt','url'=>url('bhadmin/system/tool','id='.$obj['Id'])])} </td>
            </tr>
          </volist>
          <tr>
            <td height="37" align="center" valign="middle">{:ckall(2)}</td>
            <td height="35" colspan="8" align="left" valign="middle"> {:btn(array('vals'=>'删除','type'=>'submit','name'=>'deldata','round'=>1,'icon'=>'trash','scene'=>'danger'))} <font class="text-warning">&nbsp;{:icon('warning-sign')} 提示，任何形式删除的数据都无法找回，请谨慎操作！</font> {$dshow['pageshow']} </td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</block>
<block name="bootstrap">
  <div class="modal fade" tabindex="-1" id="showdata" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">查看请求参数</h4>
        </div>
        <div class="modal-body">
          <div class="modal-showdiv"> </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
  $(document).ready(function(e) {
    $(".btn-show").click(function(e) {
     var $btn  = $(this).button('loading');
	 var id    = $(this).data('id');
	 if ( id ) {
	   $.post('{:url("system/ajaxrecord")}',{'id':id},function(data){
		 $("#showdata").modal('show');
	     $btn.button('reset')  
	     if ( data.state == 1 ) {
		   $(".modal-showdiv").html(data.html);
		 }
	   },'json');
	 }
    });  
  });
 </script> 
</block>
