<!DOCTYPE html>
<html>
<head>
<include file="public/meta" />
</head>
<body style="background:#fff;">
 <script src="http://open.web.meitu.com/sources/xiuxiu.js" type="text/javascript"></script>
 <script type="text/javascript">
	xiuxiu.setLaunchVars("nav","edit");
	xiuxiu.embedSWF("xiuxiu", 3, '100%', 500, "lite");
	xiuxiu.setLaunchVars("nav",'beautifySkin');
	xiuxiu.setLaunchVars("sizeTipVisible", 1);
	xiuxiu.onInit = function (id){
      xiuxiu.setUploadURL("{$uploadurl}");
      xiuxiu.setUploadType(2);
	  xiuxiu.loadPhoto("{$pic}");
      xiuxiu.setUploadDataFieldName("Filedata");
	  xiuxiu.setUploadArgs({'from':''});
	}
	xiuxiu.onUploadResponse = function (data){
	   var data = eval("("+data+")");
	   if ( data.error!='' ) {
	     swal(data.error,'','error');
	   } else {
		 $(parent.document.body).find('#pic').val(data.file);
		 $(parent.document.body).find('.picdiv').html('<img src="'+upfile+'images/'+data.file+'" data-action="zoom">');
		 $(parent.document.body).find('.btn-xiuxiu-close').click();
	   }
	}
	xiuxiu.onDebug = function (data){
       swal(data,'','error');
	}
	xiuxiu.onClose = function (id){
	   $(parent.document.body).find('.btn-xiuxiu-close').click();
	}	
 </script>
 </if>
 <div id="flashEditorOut">
   <div id="xiuxiu">
     <div class="xiuxiuloading" style="width:100%; height:500px; background:#fafafa; color:#666; line-height:500px; text-align:center;"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> 加载中..</div>
   </div>
 </div>
<include file="public/footer" />
</body>
</html>
