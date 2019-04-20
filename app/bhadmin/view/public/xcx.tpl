<?php
  $xcxdomain  = xcxdomain();
?>
<div class="modal fade" id="xcxurlmodal" tabindex="-1" role="dialog" data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close btn-bhmap-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">选择小程序域名</h4>
      </div>
      <div class="modal-body" style=" overflow:auto; height:350px;">
      	 <volist name="xcxdomain" id="xobj">
         	 <div class="xcxdomain" data-uri="{$xobj['url']}"><font color="#999">{$xobj['mark']?:'无'}</font><br/>{$xobj['url']}</div>
         </volist>
      </div>
    </div>
  </div>
</div>

<script>
 $(document).ready(function(e) {
    $('.selxcx').click(function(e) {
       $('#xcxurlmodal').modal('show');
    });   
	$('body').on("click",'.xcxdomain',function(e){
	   $('.linkurl').val($(this).data('uri'));
	   $('#xcxurlmodal').modal('hide');
	});
 });
</script>
