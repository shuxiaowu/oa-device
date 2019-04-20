<!--选择图片-->
<div class="modal fade" id="model_pic" data-backdrop='static'>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">产品图库</h4>
            </div>
            <div class="modal-body" style="margin:0; padding:0;">
                <div class="row modal-picture">
                    <div class="col-md-12 col-sm-12 col-xs-12 picture-main">
                        <div style="height:auto; overflow:hidden;">
                            <div class="picture-mblock"></div>
                            <div style=" height:10px; clear:both;"></div>
                            <div class="picture-pagelist propagelist"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{:icon('off')} 关闭</button>
                <button type="button" class="specupload_choose" data-path="">{:icon("picture")} 选择图片</button>
                <div class="specupload" data-id="0" data-index="0">{:icon('upload')}上传图片<input type="file" name="Filedata" class="specuploadpic" /></div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function(e) {
   //选择图片
   $('body').on("click",".spec_item_pic",function(){
	   picstock('products');
	   var spec_item_id = $(this).data('spec_item_id');
	   var _index = $(this).index('.spec_item_pic');
	   $('.specupload').data('id',spec_item_id).data('index',_index);
	   $('#model_pic').modal("show");
   });
   $("#model_pic").on("click",'.picture-fname',function(){
     var path = $(this).data('path');
	 $('.specupload_choose').data('path',path);
   });
   //确定图库图片  
   $('.specupload_choose').click(function(){
	   if ( $(this).data('path') == '' ) { swal('请至少选择一张图片吧','','error'); return false;}
	   $('.spec_item_pic').eq($('.specupload').data('index')).html('<img src="'+upfile+'images/'+$(this).data('path')+'" width="100%" height="100%"/><input value="'+$(this).data('path')+'" type="hidden" name="specitempic['+$('.specupload').data('id')+']"/>');
	   $('#model_pic').modal("hide");
   })
   //规格传图专用
   if($(".specupload").length > 0){
		$(function(){
			$(".specuploadpic").wrap("<form id='specupload' action='"+abspath+"/Files/picupload' enctype='multipart/form-data' method='post'></form>");
			$(".specuploadpic").change(function(){
				if($(".specuploadpic").val()=="") return false;
				$("#specupload").ajaxSubmit({
					dataType : 'json',
					data     : {'isproimg':1},
					beforeSend: function() {
					},
					success: function(data) {
						if(data.error!=''){
							swal(data.error,'','error'); return false;
						}else{
							$('.spec_item_pic').eq($('.specupload').data('index')).html('<img src="'+upfile+'images/'+data.file+'" width="100%" height="100%"/><input value="'+data.file+'" type="hidden" name="specitempic['+$('.specupload').data('id')+']"/>');
							$('#model_pic').modal("hide");
						}
					},
					error:function(xhr){
					}
				});
			});
		});
   }
});
function picstock(path,page){
 	$.post(abspath+'/Admin/getpiclist',{'path':path,'page':1,'ispro':1},function(data){
	  if ( data.state == 1 ) {
	    $(".picture-mblock").html(data.html);
		$(".picture-pagelist").html(data.pagelist);
	  } else {
	    swal(data.msg,'','error');
	  }
	},'json');
 }
</script>