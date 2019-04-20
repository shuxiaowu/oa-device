<extend name="common/common" />
<block name="main">
<style>
 .form-control{font-size:13px;height:100%;border-radius:0;box-shadow:none;border:1px solid #e9e9e9;transition-duration:.5s}
 .form-control:focus{border-color:#42a5f5;box-shadow:none;transition-duration:.5s}
 .form-control:focus-feedback{z-index:10}
 .form-control{ height:30px !important; margin:0 5px 0 0;font-size:12px !important; border:solid 1px #ddd; border-radius:1px;}
</style>
  <div class="sidebar">
    <div class="version">接口调试记录</div>
    <dl>
      <dt><span></span>选择身份查询</dt>
      <volist name="tdata" id="tobj">
        <dd><a href="{:url('doc/index/record','type='.$tobj['type'])}">{$tobj['remark']}</a></dd>
      </volist>
      <dt><span></span>在线调试</dt>
        <dd><a href="{:url('doc/index/tool')}">在线调试 <font color="red">new</font></a></dd>
    </dl>
  </div>
  <div class="main" style="min-height:600px;">

        <if condition="$type neq ''">
          <div class="alert alert-info" style="margin:10px auto; 0px auto;">身份：{$type}</div>
        </if>
        <form class="form-inline" method="get" style="margin:10px auto; font-size:13px;">
          <div class="form-group">
            <label>接口名称：</label>
            <input type="text" class="form-control" name="apiname" value="{$apiname}" placeholder="">
          </div>
          <div class="form-group">
            <label>请求时间：</label>
            <input type="date" class="form-control" name="date" value="{$date}" placeholder="日期格式(2017-07-15)">
          </div>
          <button type="submit" class="btn btn-success">查询</button>
        </form>
        <if condition="$data neq ''">
          <table width="100%" class="table table-hover table-bordered" style="margin-bottom:0; padding:0; margin:0;">
            <tr class="active">
              <td width="60" align="center">序号</td>
              <td width="80" align="center">身份</td>
              <td>请求链接</td>
              <td width="160" align="center">请求日期</td>
              <td width="140" align="center">请求参数</td>
            </tr>
            <volist name="data" id="obj">
              <tr>
                <td align="center">{$pno+$i}</td>
                <td align="center">{$obj['apitype']}</td>
                <td>{$obj['url']}</td>
                <td align="center">{:date('Y-m-d H:i:s',$obj['date'])}</td>
                <td align="center">
                 <button class="btn btn-xs btn-success btn-show" data-id="{$obj['Id']}">查看</button>
                 <button class="btn btn-xs btn-info" onClick="window.location.href='{:url("doc/index/tool","id=".$obj['Id'])}'">调试</button>
                </td>
              </tr>
            </volist>
            <tr>
              <td align="center" colspan="5">{$pagelist}</td>
            </tr>
          </table>
        <else/>
        
        </if>
  </div>
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
  <script src="{$base}/js/bootstrap.min.js" type="text/javascript"></script> 
  <script type="text/javascript">
  $(".pre-open").click(function(e) {
    if ( $(this).parent().height() == 119 ) {
	  $(this).parent().height('auto'); 
	  $(this).text('收起');
	} else {
	  $(this).parent().height(119); 
	  $(this).text('展开');
	}
  });
  window.onload = function () {(window.onresize = function () {
	var width = document.documentElement.clientWidth - 240 - 42;
	var height = document.documentElement.clientHeight - $(".navbar").height() - 2;
    $(".sidebar,.main").height(height);
    $(".main").width(width);
  })()};
  
  $(".btn-show").click(function(e) {
    var $btn  = $(this).button('loading');
	var id    = $(this).data('id');
	var token = '{$token}';
	if ( id ) {
	  $.post('{:url("doc/index/ajaxrecord")}',{'id':id,'token':token},function(data){
		$("#showdata").modal('show');
	    $btn.button('reset')  
	    if ( data.state == 1 ) {
		  $(".modal-showdiv").html(data.html);
		}
	  },'json');
	}
  });
  
 </script> 
</block>
