 <notempty name="upload">
  <div class="modal fade bh-picture" id="bh-picture">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title">系统图片库</h4>
          </div>
          <div class="modal-body" style="margin:0; padding:0;">
            <div class="row modal-picture">
              <div class="col-md-2 col-sm-3 col-xs-4 picture-sidebar">
                <div style="height:auto; overflow:hidden;">
                  <div class="list-group pic-sidebar"><!--pagesidebar---></div> 
                </div>
              </div>
              <div class="col-md-10 col-sm-9 col-xs-8 picture-main">
                <div style="height:auto; overflow:hidden;">
                <div class="picture-mblock pic-main"><!--pagemain---></div>
                <div style=" height:10px; clear:both;"></div>
                <div class="picture-pagelist pic-pagelist"><!--pagelist---></div>
              </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="pull-left"><div class="up-progress" style="margin:10px auto;"><div class="up-bar"></div></div></div>
            <input type="hidden" value="" id="picture-file">
            <input type="hidden" value="" id="picture-path">
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">{:icon("off")} 关闭</button>
            <button type="button" class="btn btn-primary btn-sm btn-choice-picture">{:icon("picture")} 选择图片</button>
          </div>
        </div>
      </div>
      
      <script src="__js__/jqthumb.js" type="text/javascript"></script>
      <script>
		 $(document).ready(function(e) {
			$('body').on("click",'.btn-choice',function(){
				var $this = $(this);
				$(this).html('<span class="fa fa-spinner fa-spin"></span> 获取..');
				$.post('{:url("bhadmin/files/picmanger")}',{},function(data){
				   $this.html('<span class="glyphicon glyphicon-picture"></span> 选择'); 
				   $('.pic-sidebar').html(data.sidebar);
				   $('.pic-main').html(data.main);
				   $('.pic-pagelist').html(data.list);
				   $("#bh-picture").modal("show");
				   $(".picture-mblock img").jqthumb({width:128,height:128,classname:'jqthumb'});
				   $('.picture-sidebar').perfectScrollbar();
				   $('.picture-main').perfectScrollbar();
				   $("#picture-path").val(data.file);
				},'json');
			});
			//
			$("body").on("click",".btn-magic",function(e){
			   var pic = $("#pic").val();
			   if ( pic == '' ) { swal('请上传需要美化的图片','','error'); return false;}
			   var url = '{:url("bhadmin/files/meituxiuxiu","","")}?pic='+pic;
			   console.log(url);
			   $(".mtigxiuxiu").attr('src',url);
   			   $("#mtxiuxiu").modal("show");  
			});			 
         });
      </script>
   </div>
 </notempty>
 
 <div class="modal fade bh-uploadxiuxiu" id="mtxiuxiu" data-backdrop="false">
 <div class="modal-dialog modal-lg">
   <div class="modal-content" style="height:560px;">
     <div class="modal-header">
       <button type="button" class="close btn-xiuxiu-close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
       <h4 class="modal-title">美化图片</h4>
     </div>
     <div class="modal-body" style="margin:0; padding:0;">
       <iframe name="mtigxiuxiu" class="mtigxiuxiu" width="100%" height="500" scrolling="no" frameborder="0" src="{:url('bhadmin/index/loading')}"></iframe>
     </div>
   </div>
 </div>
 </div>
