$(document).ready(function(e){$(".ckallbox input").click(function(e){if($(this).is(":checked")){$(".maintr").addClass("info");$('input').prop("checked",true)}else{$(".maintr").removeClass("info");$('input').prop("checked",false)}});$('.maintr input').click(function(e){if($(this).is(":checked")){$(this).parent().parent().addClass("info");if($("input[type='checkbox']").length-2==$(".maintr input[type='checkbox']:checked").length){$('input').prop("checked",true)}}else{$(this).parent().parent().removeClass("info");$(".ckallbox input").prop("checked",false)}});$(".btn-enabled,.btn-disabled").click(function(e){var tables=$(this).parent().data("tables");var id=$(this).parent().data("id");var field=$(this).parent().data("field");var tip1=$(this).parent().data("tip1");var tip2=$(this).parent().data("tip2");var $this=$(this);var modval=($this.data('mark')==1)?1:0;if(tables!=''&&id!=''&&field!=''){var atxt=$(this).text();$(this).attr("disabled",true).text('更改中..');$.post(abspath+'/admin/modattr',{'tables':tables,'field':field,'id':id,'val':modval,'act':'modattr'},function(data){$this.attr("disabled",false);if(data!=''){if($this.data("mark")==1){$this.text(tip1);$this.removeClass("btn-default").addClass("btn-info");$this.parent().find(".btn-disabled").removeClass("active")}else{$this.text(tip2);$this.removeClass("active").addClass("active");$this.parent().find(".btn-enabled").removeClass("btn-info").addClass("btn-default")}}else{$this.attr("disabled",false).text(atxt);swal('数据有误，请重新操作！','','error')}},'json')}else{swal('数据有误，请重新操作！','','error')}});if($("#uppic").length>0){$(function(){$("#uppic").wrap("<form id='uppicform' action='"+abspath+"/Files/picupload' enctype='multipart/form-data' method='post'></form>");$("#uppic").change(function(){var iswater=($(".nowater").length>0)?1:0;var isproimg=($('.isproimg').length>0)?1:0;$("#uppicform").ajaxSubmit({dataType:'json',data:{'iswater':iswater,'isproimg':isproimg,'width':$(".cutswidth").val(),'height':$(".cutsheight").val()},beforeSend:function(){$(".uploadloading").html('<i class="fa fa-spinner fa-spin"></i> 上传中..')},success:function(data){$(".uploadloading").html('<span class="glyphicon glyphicon-picture"><b>选择上传</b></span>');if(data.error!=''){swal(data.error,'','error');return false}else{$("#pic").val(data.file);if($(".img-container").length>0)$(".img-container img").attr("src",upfile+'images/'+data.file);$(".uppicdiv").find(".picfoot b").html(data.file);$(".uppicdiv").show().find(".picdiv").html('<img src="'+upfile+'images/'+data.file+'" data-action="zoom">');if($(".showcroptool").length>0)croppic()}},error:function(xhr){}})})})}$(".picfoot span").click(function(e){$("#pic").val('');$(".uppicdiv").hide().find(".picdiv").html('')});$(".btn-cut").click(function(e){if($(".crop-container").is(":hidden")){var path=$("#pic").val();if(path==''){swal('裁剪路径为空，请上传一张裁剪的图片吧','','error');return false}croppic()}else{$(".crop-container,.crop-mask").fadeOut(500)}});function croppic(){var size_w=parseInt($("#size-w").val());var size_h=parseInt($("#size-h").val());var aspectRatio=(size_w>0&&size_h>0)?size_w/size_h:null;$(".img-container img").cropper('destroy');var cropoption={minContainerWidth:320,minContainerHeight:180,zoomin:null,zoomout:null,movable:true,aspectRatio:aspectRatio,crop:function(data){$('#img-x').val(Math.round(data.x));$('#img-y').val(Math.round(data.y));$('#img-h').val(Math.round(data.height));$('#img-w').val(Math.round(data.width));$('#img-r').val(Math.round(data.rotate));$(".c-w").text(Math.round(data.width));$(".c-h").text(Math.round(data.height));$(".c-l").text(Math.round(data.x));$(".c-t").text(Math.round(data.y))}};$(".img-container img").on({'build.cropper':function(e){},'built.cropper':function(e){},'dragstart.cropper':function(e){},'dragmove.cropper':function(e){},'dragend.cropper':function(e){},'zoomin.cropper':function(e){},'zoomout.cropper':function(e){}}).cropper(cropoption);$(".crop-container,.crop-mask").fadeIn(500)}$("body").on("click",".btn-close-cropper,.crop-mask",function(data){$(".crop-container,.crop-mask").fadeOut(500)});$("body").on("click",".btn-cropper",function(){var $this=$(this);var path=$("#pic").val();var x=$("#img-x").val();var y=$("#img-y").val();var w=$("#img-w").val();var h=$("#img-h").val();var r=$("#img-r").val();var iswater=($(".nowater").length>0)?1:0;var delpic=($(".nodeloriginal").length>0)?1:0;if(path==''){swal('裁剪路径为空，请上传一张裁剪的图片吧','','error');return false}if(w==0||h==0){swal('裁剪宽度和高度不能为0','','error');return false}$this.html('<span class="fa fa-spinner fa-spin"></span> 裁剪中..').addClass("disabled");$.post(abspath+'/admin/croppic',{'path':path,'x':x,'y':y,'w':w,'h':h,'r':r,'iswater':iswater,'delpic':delpic},function(data){$this.html('<span class="glyphicon glyphicon-scissors"></span> 裁剪').removeClass("disabled");if(data.state==1){$(".crop-container,.crop-mask").fadeOut(500);$("#pic").val(data.file);$(".uppicdiv").find(".picfoot b").html(data.file);$(".uppicdiv").show().find(".picdiv").html('<img src="'+upfile+'images/'+data.file+'" data-action="zoom">');$(".img-container img").attr("src",upfile+'images/'+data.file)}else{swal(data.msg,'','error')}},'json')});$("body").on("click",".picture-fname",function(){var path=$(this).data("path");$(".pic-active").hide();$(this).find(".pic-active").show();$("#picture-file").val(path)});$("body").on("click",".picture-litype",function(){$(".picture-sidebar .list-group-item").removeClass("active");$(this).addClass("active");var path=$(this).data("path");$("#picture-path").val(path);picprogress();$.post(abspath+'/admin/getpiclist',{'path':path,'page':1},function(data){picprogress(1);if(data.state==1){$(".picture-mblock").html(data.html);$(".picture-pagelist").html(data.pagelist);$(".picture-mblock img").jqthumb({width:128,height:128,classname:'jqthumb'})}else{swal(data.msg,'','error')}},'json')});$("body").on("click",".picture-pagelist li a",function(){var path=$("#picture-path").val();var page=$(this).data("page");if(page>0){var ispro=$(this).parent().parent().parent().parent().parent().hasClass('propagelist')?1:0;picprogress();$.post(abspath+'/admin/getpiclist',{'path':path,'page':page,'ispro':ispro},function(data){picprogress(1);if(data.state==1){$(".picture-mblock").html(data.html);$(".picture-pagelist").html(data.pagelist);$(".picture-mblock img").jqthumb({width:128,height:128,classname:'jqthumb'})}else{swal(data.msg,'','error')}},'json')}});$("body").on("click",".btn-choice-picture",function(){var file=$("#picture-file").val();if(file!=''){$("#pic").val(file);$(".uppicdiv").find(".picfoot b").html(file);$(".uppicdiv").show().find(".picdiv").html('<img src="'+upfile+'images/'+file+'" data-action="zoom">');$("#bh-picture").modal("hide");$(".img-container img").attr("src",upfile+'images/'+file)}else{swal('请在图库选择一张图片','','error')}});if($(".uploadpic").length>0){$(".uploadpic").each(function(e){var _index=$(this).data('id');var id="#uploadpic"+$(this).data('id');var fromid="myupload"+$(this).data('id');$(function(){$(id).wrap("<form id='"+fromid+"' action='"+abspath+"/files/picupload' enctype='multipart/form-data' method='post'></form>");$(id).change(function(){if($(id).val()=="")return false;$("#"+fromid).ajaxSubmit({dataType:'json',data:{},beforeSend:function(){picprogress(0,(_index-1))},success:function(data){picprogress(1,(_index-1));if(data.error!=''){swal(data.error,'','error');return false}else{$('#uppic'+_index).val(data.file);$(".uppicturediv").eq(_index-1).find(".mypicfoot b").html(data.file);$(".uppicturediv").eq(_index-1).show().find(".picdiv").html('<img src="'+upfile+'images/'+data.file+'" data-action="zoom">')}},error:function(xhr){}})})})})}$(".mypicfoot span").click(function(e){$id=$(this).parent().data("id");$('#uppic'+$id).val('');$(".uppicturediv").eq($id-1).hide().find(".picdiv").html('')});function picprogress($statue,$index){var $statue=($statue==''||$statue==undefined)?0:$statue;var $index=($index==''||$index==undefined)?0:$index;if(!$statue){$(".up-progress").eq($index).show();$(".up-progress").eq($index).find(".up-bar").animate({"width":'400'},7000,function(e){$(".up-progress").eq($index).find(".up-bar").css("width",0);if(!$(".up-progress").eq($index).is(":hidden"))picprogress($statue,$index)})}else{$(".up-progress").eq($index).find(".up-bar").css("width",0);$(".up-progress").eq($index).hide(200)}}$("body").on("click",".bhcopy",function(e){var id=$(this).data('id');var tables=$(this).data('tables');if(!id||!tables)return false;swal({title:"操作无法返回",text:"您真的要复制该条数据吗？",type:"warning",showCancelButton:true,confirmButtonColor:'#38a0f4',confirmButtonText:'确定复制',cancelButtonText:"取消",closeOnConfirm:false,},function(){$.post(abspath+'/admin/bhcopy',{'id':id,'tables':tables},function(data){if(data.state==1){swal('复制成功','','success');setTimeout(function(){window.location.reload()},2000)}else{swal(data.msg,'','error')}},'json')})});if($("#upfile").length>0){$(function(){$("#upfile").wrap("<form id='upfileform' action='"+abspath+"/files/fileupload' enctype='multipart/form-data' method='post'></form>");$("#upfile").change(function(){$("#upfileform").ajaxSubmit({dataType:'json',data:{},beforeSend:function(){$(".ui-file-foot").html('<span><i class="fa fa-spinner fa-spin"></i>上传中..</span>')},success:function(data){$(".ui-file-foot").html('<span class="glyphicon glyphicon-folder-open"><b>选择上传</b></span>');if(data.error!=''){swal(data.error,'','error');return false}else{$("#filename").val(data.file);$(".upfilediv").show();$(".upfilename").html('<a href="'+upfile+'files/'+data.file+'">'+data.file+'</a>')}},error:function(xhr){}})})})}$(".del-file").click(function(e){$("#filename").val('');$(".upfilediv").hide().find(".upfilename").html('')});if($("#upatlas").length>0){$(function(){$("#upatlas").wrap("<form id='uppicform2' action='"+abspath+"/files/picupload' enctype='multipart/form-data' method='post'></form>");$("#upatlas").change(function(){var iswater=($(".nowater").length>0)?1:0;if($(".piclimit").text()==0){swal("已经超过允许上传范围",'','error');return false}$("#uppicform2").ajaxSubmit({dataType:'json',data:{'iswater':iswater,'isproimg':1,'width':$(".cutswidth").val(),'height':$(".cutsheight").val()},beforeSend:function(){$(".uploadloadings").html('<i class="fa fa-spinner fa-spin"></i> 上传中..')},success:function(data){$(".uploadloadings").html('<span class="glyphicon glyphicon-picture"><b>选择上传</b></span>');if(data.error!=''){swal(data.error,'','error');return false}else{var no=parseInt($(".piclimit").text());no--;$(".upupatlas").show();$(".piclimit").text(no);$(".upupatlas .atlaspiclist").append('<div class="atlaspic"><input type="hidden" name="atlas[]" value="'+data.file+'"><div class="atlaspicfile"><img width="105" height="105" src="'+upfile+'images/'+data.file+'" data-action="zoom"></div><div class="atlasdel"><span class="glyphicon glyphicon-trash"></span> 删除图片</div></div>')}},error:function(xhr){}})})})}$(".atlaspiclist").on("click",".atlasdel",function(){$(this).parent().remove();var no=parseInt($(".piclimit").text());$(".piclimit").text((no+1))});$("body").on("click",".dropdown-type li a",function(){$(this).parent().parent().parent().find(".drop-val").val($(this).data("id"));$(this).parent().parent().parent().find(".drop-topic").text($(this).text())});$("body").on("click",".mydrop-menu-type1 li a",function(){$(this).parent().parent().parent().find(".drop-hide").val($(this).data("id"));$(this).parent().parent().parent().find(".drop-topic").text($(this).text());var $this=$(this);$(".btn-group-type2").find(".drop-topic").text('请选择子类');$(".btn-dropdownlink").find(".drop-hide").eq(1).val(0);$.post(abspath+'/admin/droplinks',{'tables':$this.data("tables1"),'tables2':$this.data("tables2"),'field':$this.data("field1"),'field2':$this.data("field2"),'id':$this.data("id")},function(data){$(".mydrop-menu-type2").html(data)},'json')});$(".mydrop-menu-type2").on("click",".menu-li2",function(e){$(this).parent().parent().parent().find(".drop-hide").val($(this).data("id"));$(this).parent().parent().parent().find(".drop-topic").text($(this).text());var $this=$(this);var tables=$(this).data("tables");var field=$(this).data("field");if(field!=''&&tables!=''){$(".btn-group-type3").find(".drop-topic").text('请选择小类');$(".btn-dropdownlink").find(".drop-hide").eq(2).val(0);$.post(abspath+'/admin/droplinks2',{'tables':tables,'field':field,'id':$this.data("id")},function(data){$(".mydrop-menu-type3").html(data)},'json')}});$(".mydrop-menu-type3").on("click",".menu-li3",function(e){$(this).parent().parent().parent().find(".drop-hide").val($(this).data("id"));$(this).parent().parent().parent().find(".drop-topic").text($(this).text())});$(".mypage .jump_go").click(function(e){var page=$(".mypage .page_num").val();var url=$(".mypage .jump_url").val()+"/page/"+page;if(page==''){swal('请输入您要跳转的页码','','error');$(".mypage .page_num").focus();return false}if(isNaN(page)){swal('页码请输入数字','','error');$(".mypage .page_num").val('');$(".mypage .page_num").focus();return false}location.href=url});$("body").on("blur",".modfield",function(){var $tables=$(this).data("tables");var $id=$(this).data("id");var $val=$(this).val();var $field=$(this).data("field");var $old=$(this).data("odata");if($tables!=''&&$id!=''&&$val!=''&&$field!=''){if($val!=$old){$.post(abspath+'/admin/modField',{'tables':$tables,'val':$val,'id':$id,'field':$field},function(data){if(data==1){swal('修改成功','修改字段：'+$field+' 修改值为：'+$val,'success')}else{swal('修改失败','','error')}},'json')}}});$("body").on("click",".chosen-single",function(){var $this=$(this);if(!$this.parent().hasClass("chosen-with-drop")){$this.parent().addClass("chosen-with-drop")}else{$this.parent().removeClass("chosen-with-drop")}});$("body").on("click",".active-result",function(){var $parent=$(this).parent().parent().parent();var $id=$(this).data("id");$parent.find(".chose-keyid").val($id);$parent.find(".chosen-single span").text($(this).text());$parent.removeClass("chosen-with-drop")});$("body").on("keyup",".chosen-keys",function(){var $obj=$(this).parent().parent().parent();var $keys=$(this).val();var $field=$(this).data("field");var $sfield=$(this).data("sfield");var $tables=$(this).data("tables");var $where=$(this).data("where");if($field!=''&&$sfield!=''&&$tables!=''){$obj.find(".chosen-loading").show();$.post(abspath+'/admin/searchField',{'field':$field,'sfield':$sfield,'key':$keys,'tables':$tables,'where':$where},function(data){$obj.find(".chosen-loading").hide();if(data==0){$obj.find(".chosen-results").html('<li class="active-result" data-id="0">没有数据</li>')}else{$obj.find(".chosen-results").html(data)}},'json')}else{$obj.find(".chosen-loading").hide()}});$("body").on("click",".search-choice-close",function(){$(this).parent().parent().find(".chose-keyid").val(0);$(this).parent().find("span").text('请选择')})});function sysadv(td){if(td.topic.value.length==0){swal('请输入广告标题','','error');td.topic.focus();return false}if(td.linkurl.value.length==0){swal('请输入广告链接','','error');td.linkurl.focus();return false}}function systype(td){if(td.topic.value.length==0){swal('请输入类别名称','','error');td.topic.focus();return false}}function pubdel(td){var objs=document.getElementsByTagName("input");var is=0;for(var j=0;j<objs.length;j++){if(objs[j].type=='checkbox'){if(objs[j].checked==true){is++}}}if(is==0){swal('请选择您要操作的数据','','error');return false}}function sysdata(td){if(td.topic.value.length==0){swal('请输入资料名称','','error');td.topic.focus();return false}if(td.inftype.value==0){swal('请选择资料所属','','error');return false}}function sysabout(td){if(td.topic.value.length==0){swal('请输入资料名称','','error');td.topic.focus();return false}}function syslink(td){if(td.topic.value.length==0){swal('请输入链接名称','','error');td.topic.focus();return false}if(td.linkurl.value.length==0){swal('请输入链接地址','','error');td.linkurl.focus();return false}}function sysonline(td){if(td.topic.value.length==0){swal('请输入客服名称','','error');td.topic.focus();return false}if(td.amount.value.length==0){swal('请输入客服账号','','error');td.amount.focus();return false}}function sysmtag(td){if(td.topic.value.length==0){swal('请输入类别名称','','error');td.topic.focus();return false}if(td.inftype.value==0){swal('请选择类别所属','','error');return false}}function sysstag(td){if(td.topic.value.length==0){swal('请输入类别名称','','error');td.topic.focus();return false}if(td.ctag.value==0){swal('请选择大类','','error');return false}if(td.mtag.value==0){swal('请选择子类','','error');return false}}function modord(tables,id){var inp="modord"+id;var ord=document.getElementsByName(inp)[0].value;if(tables!=''&&id!=''){$.post(abspath+'/admin/modord',{'tables':tables,'id':id,'ord':ord,'act':'modord'},function(data){if(data==1){swal('排序修改成功','','success')}else{swal('排序修改失败，请重试','','error')}},'json')}}function uniteTable(tb,colLength){if(!checkTable(tb))return;var i=0;var j=0;var rowCount=tb.rows.length;var colCount=tb.rows[0].cells.length;var obj1=null;var obj2=null;for(i=0;i<rowCount;i++){for(j=0;j<colCount;j++){tb.rows[i].cells[j].id="tb__"+i.toString()+"_"+j.toString()}}for(i=0;i<colCount;i++){if(i==colLength)return;obj1=document.getElementById("tb__0_"+i.toString());for(j=1;j<rowCount;j++){obj2=document.getElementById("tb__"+j.toString()+"_"+i.toString());if(obj1.innerText==obj2.innerText){obj1.rowSpan++;obj2.parentNode.removeChild(obj2)}else{obj1=document.getElementById("tb__"+j.toString()+"_"+i.toString())}}}}function checkTable(tb){if(tb.rows.length==0)return false;if(tb.rows[0].cells.length==0)return false;for(var i=0;i<tb.rows.length;i++){if(tb.rows[0].cells.length!=tb.rows[i].cells.length)return false}return true}function bhload(){$("body").append('<div class="bhmask"></div><div class="bhload"><div></div></div>')}function hideload(){$('.bhmask,.bhload').hide().remove('*')}
//多级下拉选择
$('body').on("change",'.select-event',function(){
	 var params = new Object();
	 var url = $(this).parent().data('url');
	 var _this = $(this);
	 params.index = $(this).parent().data('index');
	 params.scene = $(this).parent().data('scene');
	 params.val = $(this).val();
	 if($(this).parent().parent().find('.select-event:gt('+params.index+')').length==0) return false;
	 $(this).parent().parent().find('.select-event:gt('+params.index+')').find('option:gt(0)').remove('*');
	 $.post(abspath+'/'+url,params,function(data){
		 if(data.success==1){
			 var html = '';
			 $.each(data.data,function(key,val){
				html += '<option value="'+val['Id']+'">'+val['topic']+'</option>';
			 })
			 _this.parent().parent().find('.select-event:eq('+(params.index+1)+')').append(html);
		 }else{
			 swal(data.msg,'','error');
		 }
	 },'json')
});