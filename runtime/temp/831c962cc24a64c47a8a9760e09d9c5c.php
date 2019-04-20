<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:72:"D:\phpStudy\PHPTutorial\WWW\oa-device/app/bhadmin\view\system\sysmod.tpl";i:1531195276;s:72:"D:\phpStudy\PHPTutorial\WWW\oa-device\app\bhadmin\view\public\common.tpl";i:1545869180;s:70:"D:\phpStudy\PHPTutorial\WWW\oa-device\app\bhadmin\view\public\meta.tpl";i:1555400400;s:72:"D:\phpStudy\PHPTutorial\WWW\oa-device\app\bhadmin\view\public\footer.tpl";i:1555400335;s:69:"D:\phpStudy\PHPTutorial\WWW\oa-device\app\bhadmin\view\public\pic.tpl";i:1546851127;s:72:"D:\phpStudy\PHPTutorial\WWW\oa-device\app\bhadmin\view\public\editor.tpl";i:1545093518;}*/ ?>
<!DOCTYPE html>
<html>
<head>
 <meta charset="utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <meta name="description" content="<?php echo config('devcompany'); ?>后台管理系统">
 <meta name="keywords" content="<?php echo config('devcompany'); ?>后台管理系统">
 <meta name="author" content="jxbh.cn">
 <title><?php echo config('devcompany'); ?>后台管理系统</title>
 <link rel="shortcut icon" href="/oa-device/public/bhadmin/images/favicon.ico">
 <link href="/oa-device/public/bhadmin/css/bootstrap.min.css" rel="stylesheet">
 <link href="/oa-device/public/bhadmin/css/nifty.min.css" rel="stylesheet">
 <link href="/oa-device/public/bhadmin/css/font-awesome.min.css" rel="stylesheet">
 <link href="/oa-device/public/bhadmin/css/alert.css" rel="stylesheet">
 <link href="/oa-device/public/bhadmin/css/common.css" rel="stylesheet">
 <!--[if IE 8]>
 <link rel="stylesheet" type="text/css" href="/oa-device/public/bhadmin/css/comie.css">
 <![endif]-->
 <!--[if IE 9]>
 <link rel="stylesheet" type="text/css" href="/oa-device/public/bhadmin/css/comie.css">
 <![endif]-->
  <script src="/oa-device/public/bhadmin/js/Chart.min.js"></script>
 <script src="/oa-device/public/bhadmin/js/jquery.min.js" type="text/javascript"></script>
 <script src="/oa-device/public/bhadmin/js/jquery.scorll.js" type="text/javascript"></script>
 <link href="/oa-device/public/bhadmin/css/skin.css" rel="stylesheet">
</head>
<body>
<div class="u-container">
  <div class="u-sidebar">
    <div class="u-logo"><a href="<?php echo url('bhadmin/index/index'); ?>"><img src="/oa-device/public/bhadmin/images/logo/adminface.png" alt="百恒后台管理系统"></a></div>
    <ul class="u-siderbar-ul">
      <?php if(is_array($cmenu) || $cmenu instanceof \think\Collection || $cmenu instanceof \think\Paginator): $i = 0; $__LIST__ = $cmenu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cobj): $mod = ($i % 2 );++$i;if(in_array(($cobj['Id']), is_array($myauth)?$myauth:explode(',',$myauth))): ?>
         <li <?php if($topmenuid == $cobj['Id']): ?>class="u-li-active"<?php endif; ?>>
          <a href="javascript:void(0)" class="u-nav-li" data-id="<?php echo $cobj['Id']; ?>" data-uri="<?php echo tplUrl($cobj['linkurl']); ?>">
          <?php if($cobj['icon'] != ''): ?><?php echo !empty($cobj['isext'])?faicon($cobj['icon'],'span'):icon($cobj['icon'],'span'); else: ?><?php echo icon('user','span'); endif; ?>
          <font><?php echo $cobj['title']; ?></font>
          </a>
          </li>
        <?php endif; endforeach; endif; else: echo "" ;endif; ?>
    </ul>
    <div class="u-sidebar-bottom"><div style="text-align:center; width:100%;"><?php echo !empty($adminauth['adminuser'])?$adminauth['adminuser']:'--'; ?></div>
      <div class="u-adminuser">
        <h1><?php echo $adminauth['adminuser']; ?></h1>
        <ul>
          <li><a href="<?php echo url('bhadmin/index/index'); ?>">系统首页</a></li>
          <li><a href="<?php echo url('bhadmin/index/modpass'); ?>">修改密码</a></li>
          <li><a href="http://www.jxbh.cn" target="_blank">关于百恒</a></li>
          <li><a href="javascript:void(0)" class="lockscreen">系统锁屏</a></li>
          <li><a href="<?php echo url('bhadmin/index/logout'); ?>">安全退出</a></li>
        </ul>
      </div>
      <div class="u-arrow-b"></div>
    </div>
  </div>
  <div class="u-siderbar-two">
     <!--<div class="u-siderbar-title">栏目管理</div>-->
     <?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$io): $mod = ($i % 2 );++$i;if(in_array(($io['Id']), is_array($myauth)?$myauth:explode(',',$myauth))): ?>
         <dl>
           <dt><?php if($io['icon'] != ''): ?><?php echo !empty($io['isext'])?faicon($io['icon'],'i'):icon($io['icon'],'i'); endif; ?><a href="<?php echo tplUrl($io['linkurl']); ?>"><?php echo $io['title']; ?></a></dt>
           <?php if($io['menu'] != ''): if(is_array($io['menu']) || $io['menu'] instanceof \think\Collection || $io['menu'] instanceof \think\Paginator): $i = 0; $__LIST__ = $io['menu'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$im): $mod = ($i % 2 );++$i;if(in_array(($im['Id']), is_array($myauth)?$myauth:explode(',',$myauth))): ?>
                 <dd class="u-dd-<?php echo $im['Id']; ?>"><a href="<?php echo tplUrl($im['linkurl']); ?>"><?php echo $im['title']; ?></a></dd>
               <?php endif; endforeach; endif; else: echo "" ;endif; endif; ?>
         </dl>
       <?php endif; endforeach; endif; else: echo "" ;endif; ?>
  </div>
  <div class="u-title">
    <?php 
    if( isset($title) ) {
      if ( is_array($title) ) {
        echo '<dl class="u-title-dl">';
        foreach( $title as $tk=>$tv ) {
          $tactive = (isset($tv['active']) && $tv['active'] == 1) ? 'active' : '';
          echo '<dd class="'.$tactive.'"><a href="'.$tv['url'].'">'.$tv['topic'].'</a></dd>';
        }
        echo '</dl>';
      } else {
        echo $title;
      }
    } else {
      echo '系统设置';
    }
    ?>
    <li><a href="http://www.jxbh.cn" target="_blank"><i class="pli-home"></i> 关于百恒</a></li>
    <li><a href="<?php echo url('bhadmin/index/cleancache'); ?>"><i class="pli-recycling"></i> 清除缓存</a></li>
  </div>
  <div class="u-main">
 <div class="pubmain">
  <div class="panel-body">
  <div class="btn-group">
   <?php echo btn(array('vals'=>'系统设置','size'=>3,'icon'=>'cog','scene'=>'primary','round'=>1,'url'=>url('system/sysmod'))); ?>
   <?php echo btn(array('vals'=>'公司设置','size'=>3,'icon'=>'map-marker','scene'=>'default','url'=>url('system/syscompany'))); ?>
   <?php echo btn(array('vals'=>'水印设置','size'=>3,'icon'=>'tint','scene'=>'default','url'=>url('system/syswater'))); ?>
   <?php echo btn(array('vals'=>'上传设置','size'=>3,'icon'=>'paperclip','scene'=>'default','url'=>url('system/sysupload'))); ?>
   <?php echo btn(array('vals'=>'后台目录设置','size'=>3,'icon'=>'folder-open','scene'=>'default','url'=>url('system/sysadmin'))); ?>
   <?php echo btn(array('vals'=>'IP过滤设置','size'=>3,'icon'=>'cog','scene'=>'default','url'=>url('system/ipfilter'))); ?>
   <?php echo btn(array('vals'=>'短信设置','size'=>3,'faicon'=>'commenting','scene'=>'default','url'=>url('system/sysmsg'))); ?>
   <?php echo btn(array('vals'=>'微信设置','size'=>3,'faicon'=>'weixin','scene'=>'default','url'=>url('system/sysweixin'))); ?>
  </div>
  <div class="ui-block"></div>
  <form name="sysmod" method="post" action="" onSubmit="return sysck(document.sysmod)">
    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="<?php echo tabstyle(); ?>">
      <tr>
        <td width="132" height="42" align="right" valign="middle">　站点名称：</td>
        <td height="42" align="left"><?php echo inputs(array('name'=>'metatitle','val'=>$data['metatitle'],'scene'=>'topic','tips'=>'( 应用程序名称，用在站点显示中 )')); ?></td>
      </tr>
      <tr>
        <td width="132" height="32" align="right" valign="middle">　站点ICP备案号：</td>
        <td height="32"><?php echo inputs(array('name'=>'icpnote','val'=>$data['icpnote'],'units'=>'ICP','tips'=>'(申请过程是免费的,没有ICP备案号表示该网站不合法) ')); ?></td>
      </tr>
      <tr>
        <td width="132" height="82" align="right" valign="middle">　描述信息：</td>
        <td height="82" align="left"><?php echo inputs(array('name'=>'metades','type'=>'textarea','val'=>$data['metades'])); ?></td>
      </tr>
      <tr>
        <td width="132" height="82" align="right" valign="middle">　站点关键字：</td>
        <td height="82" align="left"><?php echo inputs(array('name'=>'metakey','type'=>'textarea','val'=>$data['metakey'])); ?></td>
      </tr>
      <tr>
        <td width="132" height="82" align="right" valign="middle">　可放代码：</td>
        <td height="82" align="left"><?php echo inputs(array('name'=>'sys_code','type'=>'textarea','val'=>$data['sys_code'],'place'=>'您可以把第三方的代码放在这里，例如：百度统计代码')); ?></td>
      </tr>
      <tr class="hide">
        <td width="132" height="32" align="right" valign="middle">　开启在线客服：</td>
        <td height="32" align="left"><?php echo checkbox($data['isqq'],0,'isqq'); ?><span class="text-warning">&nbsp;注：勾选表示开启在线客服功能。</span></td>
      </tr>
      <tr>
        <td width="132" height="32" align="right" valign="middle">　开启访问统计：</td>
        <td height="32" align="left"><?php echo checkbox($data['isonline'],0,'isonline'); ?><span class="text-warning">&nbsp;注：勾选表示开启访问统计。</span></td>
      </tr>    
      <tr>
        <td width="132" height="32" align="right" valign="middle">　是否关闭项目：</td>
        <td height="32" align="left"><?php echo checkbox($data['c_site'],0,'c_site'); ?><span class="text-warning">&nbsp;注：勾选表示关闭项目。</span></td>
      </tr>
      <tr>
        <td width="132" height="82" align="right" valign="middle">　关闭说明：</td>
        <td height="82" align="left"><?php echo inputs(array('name'=>'c_text','type'=>'textarea','val'=>$data['c_text'],'tips'=>'')); ?></td>
      </tr>
      <tr>
        <td width="132" height="32" align="right" valign="middle">　后台分页值：</td>
        <td height="32" align="left"><?php echo inputs(array('name'=>'adminpage','val'=>$data['adminpage'],'width'=>'10','place'=>'(设置后台资料管理分页值，大于1的整数，清除缓存后生效)')); ?></td>
      </tr>
      <tr>
        <td width="132" height="32" align="right" valign="middle">　</td>
        <td height="50"><?php echo btn(array('vals'=>'确定保存','size'=>3,'type'=>'submit','icon'=>'cog','scene'=>'primary')); ?></td>
      </tr>
  </table>
  </form>
 <script type="text/javascript">
  function sysck(td){
    if($.trim(td.metatitle.value)==''){swal('请输入站点名称','','error');return false;}
	if($.trim(td.metades.value)==''){swal('请输入站点描述','','error');return false;}
	if($.trim(td.metakey.value)==''){swal('请输入站点关键词','','error');return false;}
  }
 </script>
 </div>
 </div>
</div>
</div>



  <?php if(!(empty($upload) || (($upload instanceof \think\Collection || $upload instanceof \think\Paginator ) && $upload->isEmpty()))): ?>
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
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><?php echo icon("off"); ?> 关闭</button>
            <button type="button" class="btn btn-primary btn-sm btn-choice-picture"><?php echo icon("picture"); ?> 选择图片</button>
          </div>
        </div>
      </div>
      
      <script src="/oa-device/public/bhadmin/js/jqthumb.js" type="text/javascript"></script>
      <script>
		 $(document).ready(function(e) {
			$('body').on("click",'.btn-choice',function(){
				var $this = $(this);
				$(this).html('<span class="fa fa-spinner fa-spin"></span> 获取..');
				$.post('<?php echo url("bhadmin/files/picmanger"); ?>',{},function(data){
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
			   var url = '<?php echo url("bhadmin/files/meituxiuxiu","",""); ?>?pic='+pic;
			   console.log(url);
			   $(".mtigxiuxiu").attr('src',url);
   			   $("#mtxiuxiu").modal("show");  
			});			 
         });
      </script>
   </div>
 <?php endif; ?>
 
 <div class="modal fade bh-uploadxiuxiu" id="mtxiuxiu" data-backdrop="false">
 <div class="modal-dialog modal-lg">
   <div class="modal-content" style="height:560px;">
     <div class="modal-header">
       <button type="button" class="close btn-xiuxiu-close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
       <h4 class="modal-title">美化图片</h4>
     </div>
     <div class="modal-body" style="margin:0; padding:0;">
       <iframe name="mtigxiuxiu" class="mtigxiuxiu" width="100%" height="500" scrolling="no" frameborder="0" src="<?php echo url('bhadmin/index/loading'); ?>"></iframe>
     </div>
   </div>
 </div>
 </div>

 <script src="/oa-device/public/bhadmin/js/bootstrap.min.js"></script>
 <script src="/oa-device/public/bhadmin/js/nifty.min.js"></script>
 <?php if(!(empty($tag) || (($tag instanceof \think\Collection || $tag instanceof \think\Paginator ) && $tag->isEmpty()))): ?>
 <script src="/oa-device/public/bhadmin/js/tags.min.js"></script>
 <?php endif; ?>
 <script src="/oa-device/public/bhadmin/js/alert.min.js"></script>
 <script src="/oa-device/public/bhadmin/js/common.js"></script>
 <script src="/oa-device/public/bhadmin/js/zoom.js"></script>
 <?php if(!(empty($upload) || (($upload instanceof \think\Collection || $upload instanceof \think\Paginator ) && $upload->isEmpty()))): ?>
 <link href="/oa-device/public/bhadmin/css/cropper.css" rel="stylesheet">
 <script src="/oa-device/public/bhadmin/js/jquery.form.js"></script>
 <script src="/oa-device/public/bhadmin/js/cropper.min.js"></script>
 <?php endif; if(!(empty($color) || (($color instanceof \think\Collection || $color instanceof \think\Paginator ) && $color->isEmpty()))): ?>
 <script src="/oa-device/public/bhadmin/js/color.js"></script>
 <link href="/oa-device/public/bhadmin/css/color.css" rel="stylesheet">
 <script type="text/javascript">
  $(document).ready( function() {
	$('.colorselect').each( function() {
		$(this).minicolors({
			theme: 'bootstrap'
		});
	});
  });
 </script>
 <?php endif; ?>
 <script type="text/javascript">
  var img     = '/oa-device/public/bhadmin/images';
  var abspath = '<?php echo $abspath; ?>/bhadmin';
  var upfile  = '/oa-device/uploads/';
  $(function () {
    $('[data-toggle="tooltip"]').tooltip({container : 'body'});
    $('[data-toggle="popover"]').popover({html:true,container:'html',trigger:'focus',title:'','placement':'right'});
	var mheight = $(window).height()-240;
	$('.minheight').css({'min-height':mheight});
  });
 </script>
 <?php if(!(empty($date) || (($date instanceof \think\Collection || $date instanceof \think\Paginator ) && $date->isEmpty()))): ?>
 <link href="/oa-device/public/bhadmin/js/date/bootstrap-datepicker.css" rel="stylesheet">
 <script src="/oa-device/public/bhadmin/js/date/bootstrap-datepicker.js"></script>
 <link href="/oa-device/public/bhadmin/js/timepicker/bootstrap-timepicker.css" rel="stylesheet">
 <script src="/oa-device/public/bhadmin/js/timepicker/bootstrap-timepicker.js"></script>
 <script>
   $(document).ready(function(e) {
    $('.input-date').datepicker({
        format: "yyyy-mm-dd",
        todayBtn: "linked",
		orientation: "auto",
        autoclose: true,
        todayHighlight: true
    }); 
	$('.boottimes').timepicker({}); 
	var dt = new Date();
	var df = dt.getHours()+':'+dt.getMinutes()+':'+dt.getSeconds();
    $('.input-time').datepicker({
        format: "yyyy-mm-dd "+df+"",
        todayBtn: "linked",
		orientation: "auto",
        autoclose: true,
        todayHighlight: true
    }); 
  });
 </script>
 <?php endif; if(!(empty($editor) || (($editor instanceof \think\Collection || $editor instanceof \think\Paginator ) && $editor->isEmpty()))): ?>
   <div class="modal fade" id="meituxiuxiumodal" tabindex="-1" role="dialog" data-backdrop="false" data-url="<?php echo url('bhadmin/files/meituxiuxiu'); ?>?t=<?php echo time(); ?>">
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
 
 <div class="modal fade" id="bhmapmodal" tabindex="-1" role="dialog" data-backdrop="false" data-url="<?php echo url('bhadmin/files/bhmap'); ?>?t=<?php echo time(); ?>">
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
 
 <link rel="stylesheet" href="/oa-device/public/kindedit/themes/default/default.css" />
 <link rel="stylesheet" href="/oa-device/public/kindedit/plugins/code/prettify.css" />
 <script src="/oa-device/public/kindedit/kindeditor.js"></script>
 <script src="/oa-device/public/kindedit/lang/zh_CN.js"></script>
 <script src="/oa-device/public/kindedit/plugins/code/prettify.js"></script>
 <script type="text/javascript">
    $(document).ready(function(e) {
      $(".btn-extmall").click(function(e) {
        $("#tmallmodal").modal('show'); 
      });
	  //$("#bhmapmodal").modal('show');
    });
	KindEditor.ready(function(K) {
		var editor1 = K.create('textarea[name="content"],textarea[name="parameter"]', {
			cssPath          : '/oa-device/public/kindedit/plugins/code/prettify.css',
			uploadJson       : '<?php echo url("bhadmin/files/editorupload"); ?>',
			fileManagerJson  : '<?php echo url("bhadmin/files/filemanger"); ?>',
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
		  $.post('<?php echo url("files/bhtpl"); ?>',{'id':id},function(data){
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
		    editor1.insertHtml('<img src="/oa-device/public/kindedit/attached/image/'+pic+'" class="kind-one-img" alt="">');
			$("#meitupic").val('');
		  }
		});
	    $('#bhmapmodal').on('hidden.bs.modal', function (e) {
		  var uri   = $("#bhmapuri").val();
		  var wid   = $("#bhmapwidth").val();
		  var hei   = $("#bhmapheight").val();
		  var url   = "<?php echo url('/home/map','',''); ?>";
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
		   $.post('<?php echo url("bhadmin/files/ckillegalword"); ?>',{'content':content},function(data){
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
				 $.post('<?php echo url("bhadmin/files/illegalword"); ?>',{'content':html},function(data){
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
		  var exurl = (type == 1) ? '<?php echo url("product/extmall"); ?>' : '<?php echo url("product/extaobao"); ?>';
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
 <?php endif; ?>

<iframe name="<?php echo url('bhadmin/index/loading'); ?>" id="hideframe" width="0" height="0" style="display:none;"></iframe>
<script type="text/javascript">
  window.noread = 0;
  var uadmin = {
    init : function(){
      var w  = $(window).width();
	  var h  = $(window).height();
	  var bw = $('.u-sidebar').width() + $('.u-siderbar-two').width();
	  var bh = $('.u-title').height();
	  $('.u-title,.u-main').width(w-bw-20);
	  $('.u-main').height(h-bh-25);
	  $('.u-title,.u-main').show();
	  window.onresize = function(){ uadmin.init()};
	  $('body').on('click','.u-siderbar-ul li a',function(e){
	    var id  = $(this).data('id');
		var uri = $(this).data('uri');
		if ( uri == 'javascript:void(0)' ) uri = '<?php echo url("bhadmin/index/index"); ?>';
		if ( id ) {
		   $.post('<?php echo url("bhadmin/admin/switchtab"); ?>',{'id':id},function(data){
			 if ( data.state == 1 ) {
			   window.location.href = uri;
			 } else {
			   swal(data.msg,'','error');
			 }
		   },'json');
		}
	  });
	  $('.u-sidebar-bottom').hover(function(){
	    $('.u-adminuser,.u-arrow-b').show();
	  },function(){
	    $('.u-adminuser,.u-arrow-b').hide();
	  });
	  $(".lockscreen").click(function(e) {
		 var $this = $(this);
		 $this.html('<span class="fa fa-spinner fa-spin"></span> 锁屏中..');
		 $.post('<?php echo url("Admin/lockscreen"); ?>',{'act':'lock'},function(data){
		   $this.html('<span class="fa fa-lock"></span> 锁屏');
		   if ( data == 1 ) {
			 window.location.reload();
		   } else {
			 swal(data,'','error');
		   }
		 },'json');
	  });
	  if ( $(".middle-page").length > 0 ) {
	    var pw = $(".middle-page .mypage").width() + 30;
	    $(".middle-page .m-page").show().width(pw).css({'margin':'0px auto','clear':'both','opacity':1});
	  }
	},
	immsg  : function(){
	},
	active : function(){
	  <?php if(!(empty($activeid) || (($activeid instanceof \think\Collection || $activeid instanceof \think\Paginator ) && $activeid->isEmpty()))): ?>
        var activeid = <?php echo $activeid; ?>;
        $(".u-dd-"+activeid).addClass('active');
	  <?php else: ?> 
	    var authid = <?php echo json_encode($authid); ?>;
	    if ( authid['level'] == 2 ) {
	      var id = authid['id'];
	      $(".u-dd-"+id).addClass('active-link');
	    } else if ( authid['level'] == 3 ) {
	      var id = authid['id'];
	      $(".u-dd-"+id).addClass('active');
	    }
      <?php endif; ?>
	},
  }
  uadmin.init();
  uadmin.active();
</script>
</body>
</html>