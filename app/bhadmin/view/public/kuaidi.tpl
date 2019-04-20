 <div class="modal fade" id="kdmodal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header"><button type="button" class="close btn-bhmap-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title">快递查询</h4></div>
      <div class="modal-body"></div>
    </div>
  </div>
 </div>
 <script type="text/javascript">
   $(document).ready(function(e) {
	 $('.wl_order').click(function(e) {
       var id    = $(this).data('id');
	   var $this = $(this);
	   if ( id == '' ) { swal('订单不存在','','error'); return false; }   
	   $this.find("button").html('<span class="fa fa-spinner fa-spin"></span> 查询').addClass("disabled"); 
	   $.post('{:url("order/ajaxkuaidi")}',{'id':id},function(data){
		 $this.find("button").html('<span class="fa fa-wpforms"></span> 物流').removeClass("disabled"); 
	     if ( data.state == 1 ) {
		   $("#kdmodal .modal-body").html(data.html);
		 } else {
		   $("#kdmodal .modal-body").html('<div class="alert alert-danger">'+data.msg+'</div>');
		 }
		 $("#kdmodal").modal('show');
	   },'json');
     });
   });
 </script>