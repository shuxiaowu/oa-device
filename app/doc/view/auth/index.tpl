<extend name="common/common" />
<block name="main">
<style>
nav{ display:none;}
.ui-mask img{
  filter: url(blur.svg#blur);
  -webkit-filter: blur(6px);
     -moz-filter: blur(6px);
      -ms-filter: blur(6px);    
          filter: blur(6px);
    filter: progid:DXImageTransform.Microsoft.Blur(PixelRadius=6, MakeShadow=false);
}
</style>
<div class="ui-mask">
 <img src="{$base}/images/mask.png" width="100%">
</div>
  <div class="modal fade" tabindex="-1" id="login" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" style="font-size:15px;">输入文档授权码</h4>
        </div>
        <div class="modal-body">
          <div class="alert alert-danger" style="margin:0 0 10px auto; display:none;">请输入</div>
          <div class="form-group">
            <label for="recipient-name" class="control-label" style="margin:10px auto; font-size:14px;">授权码 <font color="#999999" style="font-weight:normal; font-size:12px;">向管理员索取</font></label>
            <input type="password" class="form-control" id="autocode" placeholder="请输入授权码" style="font-size:12px;">
         </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info btn-auth">确定授权</button>
        </div>
      </div>
    </div>
  </div>
<script src="{$base}/js/bootstrap.min.js" type="text/javascript"></script> 
<script>
  $("#login").modal('show');
  $(".btn-auth").click(function(e) {
    var autocode = $("#autocode").val();
	if ( autocode == '' ) {
	  $(".alert-danger").show().text('请输入授权码？');
	  setTimeout(function(){ $('.alert-danger').hide() },2000);
	} else {
	  $.post('{:url("doc/auth/ajaxauth")}',{'code':autocode},function(data){
	    if ( data.state == 1 ) {
		  window.location.href = '{:url("doc/index/index")}';
		} else {
		  $(".alert-danger").show().text(data.msg);
		  setTimeout(function(){ $('.alert-danger').hide() },2000);
		}
	  },'json');
	} 
  });
  
  $('.ui-mask').click(function(e) {
  	 $("#login").modal('show');  
  });
  
</script>
</block>
