 <div class="modal fade" id="meituxiuxiumodal" tabindex="-1" role="dialog" data-backdrop="false" data-url="{:url('bhadmin/files/meituxiuxiu')}?t={:time()}">
  <div class="modal-dialog" role="document" style="width:730px; height:640px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close btn-meitu-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">美图秀秀在线处理</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" value="" id="meitupic">
        <iframe name="iframexiuxiu" class="iframexiuxiu" width="700" height="550" scrolling="no" frameborder="0" src="###"></iframe>
      </div>
    </div>
  </div>
 </div>
 
 <div class="modal fade" id="bhmapmodal" tabindex="-1" role="dialog" data-backdrop="false" data-url="{:url('bhadmin/files/bhmap')}?t={:time()}">
  <div class="modal-dialog" role="document" style="width:730px; height:565px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close btn-bhmap-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">百度地图在线生成</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" value="" id="bhmapuri">
        <input type="hidden" value="100%" id="bhmapwidth">
        <input type="hidden" value="500px" id="bhmapheight">
        <iframe name="iframexiuxiu" class="iframebhmap" width="700" height="475" scrolling="no" frameborder="0" src="###"></iframe>
      </div>
    </div>
  </div>
 </div>
 
 <div class="modal fade" id="bhtpl" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document" style="width:530px; height:565px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close btn-bhmap-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">百恒高级编辑器</h4>
      </div>
      <div class="modal-body" style="padding:0;">
        <div class="row modal-bhtpl">
          <div class="bhtpl-sidebar">
            <?php
             $tpltype = tpltype();
             if ( $tpltype !='' ) {
               foreach( $tpltype as $ttk=>$ttv ) {
                 $ttkactive = ($ttk==0) ? 'active' : '';
                 echo '<a href="javascript:void(0)" class="list-group-item bhtpl-type '.$ttkactive.'" data-id="'.$ttv['id'].'">'.$ttv['topic'].'</a>';
               }
             }
            ?>
          </div>
          <div class="bhtpl-main"><div class="tpl-block"></div></div>
        </div>
      </div>
    </div>
  </div>
 </div>
 
 <link rel="stylesheet" href="__editor__/themes/default/default.css" />
 <link rel="stylesheet" href="__editor__/plugins/code/prettify.css" />
 <script src="__editor__/kindeditor.js"></script>
 <script src="__editor__/lang/zh_CN.js"></script>
 <script src="__editor__/plugins/code/prettify.js"></script>
 <script type="text/javascript">
    $(document).ready(function(e) {
      $(".btn-extmall").click(function(e) {
        $("#tmallmodal").modal('show'); 
      });
	  //$("#bhmapmodal").modal('show');
    });
	KindEditor.ready(function(K) {
		var editor1 = K.create('textarea[name="content"],textarea[name="parameter"]', {
			cssPath          : '__editor__/plugins/code/prettify.css',
			uploadJson       : '{:url("bhadmin/files/editorupload")}',
			fileManagerJson  : '{:url("bhadmin/files/filemanger")}',
			allowFileManager : true,
			afterCreate : function() {
			  var self = this;
			  K.ctrl(document, 13, function() {
				self.sync();
				K('form[name=example]')[0].submit();
			  });
			  K.ctrl(self.edit.doc, 13, function() {
				self.sync();
				K('form[name=example]')[0].submit();
			  });
			}
		});
		prettyPrint();
		//编辑器模板
		$("body").on("click",".bhtpldiv",function(e){
		  var html = $(this).html();
		  if ( html == '' ) return false;
		  editor1.insertHtml(html+'<p>&nbsp;</p>');
		  $("#bhtpl").modal('hide');
		});
		$(".bhtpl-sidebar .bhtpl-type").click(function(e) {
          var id = $(this).data('id');
		  $('.bhtpl-type').removeClass('active');
		  $(this).addClass('active');
		  getTpl(id);
        });
		getTpl(1);
		function getTpl(id){
		  $.post('{:url("files/bhtpl")}',{'id':id},function(data){
		    if ( data.state == 1 ) {
			  $(".tpl-block").html(data.html);
			} else {
			  swal(data.msg,'','error');
			}
		  },'json');  
		}
	    $('#meituxiuxiumodal').on('hidden.bs.modal', function (e) {
		  var pic = $("#meitupic").val();
		  if ( pic !='' ) {
		    editor1.insertHtml('<img src="__editor__/attached/image/'+pic+'" class="kind-one-img" alt="">');
			$("#meitupic").val('');
		  }
		});
	    $('#bhmapmodal').on('hidden.bs.modal', function (e) {
		  var uri   = $("#bhmapuri").val();
		  var wid   = $("#bhmapwidth").val();
		  var hei   = $("#bhmapheight").val();
		  var url   = "{:url('/home/map','','')}";
		  var bhmap = '<iframe src="'+url+'?'+uri+'" name="mapifrm" width="'+wid+'" height="'+hei+'" frameborder="0" scrolling="no"></iframe>';
		  if ( uri !='' ) {
		    editor1.insertHtml(bhmap);
			$("#bhmapuri").val('');
			$("#bhmapwidth").val('100%');
			$("#bhmapheight").val('500px');
		  }
		});
	    $("body").on("click",".ke-ill-word",function(e){
	       var content = editor1.text();
		   var html    = editor1.html();
		   var $this   = $(this);
		   if ( $.trim(content) == '' ) { swal('请在编辑器里面输入资料内容','','error'); return false;}
		   $this.html('<span class="fa fa-spinner fa-spin"></span> 检测中..');
		   $.post('{:url("bhadmin/files/ckillegalword")}',{'content':content},function(data){
		     $this.html('敏感词检测');
			 if ( data.state == 1 ) {
			   swal('敏感词检测',data.msg,'success');
			 } else if ( data.state == 2 ){
			   swal({
				 title : "敏感词检测",
				 text  : data.msg+'，点击确定按钮匹配掉敏感词。',
				 type  : "warning",
			  	 showCancelButton   : true,
			 	 confirmButtonColor : '#ef3535',
			 	 confirmButtonText  : '确定',
			 	 cancelButtonText   : "取消",
			 	 closeOnConfirm     : false,
			   },
			   function(){
				 $this.html('<span class="fa fa-spinner fa-spin"></span> 删除中..');  
				 $.post('{:url("bhadmin/files/illegalword")}',{'content':html},function(data){
				   $this.html('敏感词检测');
				   if ( data.state == 1 ) {
				     swal('已将敏感词替换成**','','success');
					 editor1.html('');
					 editor1.appendHtml(data.html);
				   } else {
				     swal(data.msg,'','error');
				   }
				 },'json');
			   }); 
			 } else {
			   swal(data.msg,'','error');
			 }
		   },'json');
	    }); 
		$(".btn-tmall").click(function(e) {
		  var uri = $(".tmallurl").val();
		  var issave = $("#issave").is(":checked") ? 1 : 0;
		  var type   = $(".extaobao:checked").val();
		  if ( uri == '' ) { swal('请填写天猫/淘宝产品详情链接','','error'); return false; } 
		  var $this = $(this);
		  $this.find(".btn-primary").html('<span class="fa fa-spinner fa-spin"></span> 分析中..').addClass("disabled");
		  var exurl = (type == 1) ? '{:url("product/extmall")}' : '{:url("product/extaobao")}';
		  $.post(exurl,{'uri':uri,'issave':issave},function(data){
			$this.find(".btn-primary").html('<span class="glyphicon glyphicon-share-alt"></span> 确定导入').removeClass("disabled"); 
			if ( data.state == 1 ) {
			  $(".p-productname,.p-keyword").val(data.name);
			  $(".p-intro").val(data.intro);
			  $(".p-video").val(data.video);
			  editor1.insertHtml(data.content);
			  if ( data.pic !='' ) {
				$("#pic").val(data.pic);
				if ( $(".img-container").length > 0 ) $(".img-container img").attr("src",upfile+'images/'+data.pic);
				$(".uppicdiv").find(".picfoot b").html(data.pic);
				$(".uppicdiv").show().find(".picdiv").html('<img src="'+upfile+'images/'+data.pic+'" data-action="zoom">');
			  }
			  var atlas = data.atlas;
			  if ( atlas !='' && atlas.length > 0 ) {
				$(".upupatlas").show();
				var no = parseInt($(".piclimit").text());
				$(".piclimit").text(no-atlas.length);
				for( i=0;i<atlas.length;i++ ) {
				  $(".upupatlas .atlaspiclist").append('<div class="atlaspic"><input type="hidden" name="atlas[]" value="'+atlas[i]+'"><div class="atlaspicfile"><img width="105" height="105" src="'+upfile+'images/'+atlas[i]+'" data-action="zoom"></div><div class="atlasdel"><span class="glyphicon glyphicon-trash"></span> 删除图片</div></div>');
				}
			  }
			  $("#tmallmodal").modal('hide');
			} else {
			  swal(data.msg,'','error');
			}
		  },'json');
		});
	});
 </script>