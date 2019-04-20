<extend name="public/common" />
<block name="main">
 <div class="pubmain">
  <div class="panel-body">
  <div class="btn-group">
  {:btn(array('vals'=>'列表模式','size'=>3,'icon'=>'th-list','scene'=>$scene[0],'round'=>1,'url'=>url('system/syslogs','act=1&pm='.$pm)))}
  {:btn(array('vals'=>'文件夹模式','size'=>3,'icon'=>'folder-open','scene'=>$scene[1],'url'=>url('system/syslogs','act=2&pm='.$pm)))}
  {:btn(array('vals'=>'日志统计','size'=>3,'icon'=>'signal','scene'=>'default','round'=>1,'tips'=>'统计文件夹内上传文件大小，文件夹数量，文件数量','dir'=>'bottom','add'=>'mysignal'))}
  </div>
  <div class="ui-block" style="height:10px;"></div>
  <div class="alert alert-primary filesignal" style="display:none; margin:0;">
   <p>统计路径：<b>{$upTotal['file']}</b></p>
   <p>目录大小：<b>{$upTotal['size']}</b></p>
   <p>　文件数：<b>{$upTotal['count']} 个</b></p>
   <p>　目录数：<b>{$upTotal['dircount']} 个</b></p>
  </div>
  <if condition="$act eq 1">
  <form name="publist" method="post" action="{:url('system/sysdellogs')}" onSubmit="return pubdel(document.publist)">
  <if condition="$data neq ''">
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="{:tabstyle()}">
   <tr class="active">
     <td width="45" align="center" valign="middle" height="30">{:ckall('top')}</td>
     <td width="35%" align="left" valign="middle">文件夹/日志名称</td>
     <td width="100" align="left" valign="middle">大小</td>
     <td width="160" align="left" valign="middle">{:icon('time')} 日志时间</td>
     <td align="left" valign="middle">查看日志</td>
   </tr>
   <volist name="data" id="obj">
   <tr class="maintr">
    <td align="center" valign="middle" height="25">{:ckbox($obj['file'],$i-1)}</td>
    <td align="left" valign="middle">{$obj['file']}</td>
    <td align="left" valign="middle">{$obj['size']}</td>
    <td align="left" valign="middle">{$obj['time']}</td>
    <td align="left" valign="middle"><a href="javascript:void(0)" class="open-logs" data-path="{$obj['file']}">{:btn(array('vals'=>'查看','round'=>1,'icon'=>'eye-open','tips'=>'点击查看日志详情'))}</a></td>
   </tr>
   </volist>
   <tr>
    <td align="center" valign="middle">{:ckall()}</td>
    <td height="35" align="left" valign="middle" colspan="4">
	 {:btn(array('vals'=>'删除','type'=>'submit','icon'=>'trash','round'=>1,'name'=>'deldata','scene'=>'danger'))}&nbsp;
     {$dshow['pageshow']}
    </td>
   </tr>
  </table>
   <input type="hidden" value="{$pm}" name="type">
   <input type="hidden" value="{$path}" name="path">
  <else/>
   <div class="alert alert-primary" style="margin:0 0 10px 0">暂无日志信息</div>
  </if>
  </form>
  </if>
  <if condition="$act eq 2">
   <volist name="file" id="fobj">
    <if condition="$fobj['count'] eq 0">
      <a href="javascript:void(0)">
    <else/>
      <a href="{:url('system/syslogs','pm='.$pm.'&path='.$fobj['file'])}">
    </if>
    <div class="myfolder">
     <div class="myfilenum"><span>{$fobj['count']}</span></div>
     <div class="myicon">{:icon('folder-open')}</div>
     <div class="mytips">{$fobj['file']}</div>
    </div></a>
   </volist>
  </if>
  <script type="text/javascript">
    $(".mysignal").click(function(e) {
      if ($(".filesignal").is(":hidden")) {
	    $(".filesignal").show(500);
	  }   
   });
  </script>
 </div>
 <div style="padding:10px; box-sizing:border-box"><div class="alert alert-info">{:icon('warning-sign')} 提示，任何日志删除都无法找回，建议只删除日期比较前的日志！</div></div>
 </div>

 <script type="text/javascript">
  (function ($) {
	var pm = '{$pm}';
    $(".open-logs").click(function(e) {
	  var $this = $(this);
	  $this.find("button").button('loading');
      var path = $(this).data("path");
	  if (!path) return false;
	  $.post('{:url("system/showlog")}', {'path':path,'pm':pm},function(data){
	   $this.find("button").button('reset');
	   if (data!='') {
	     $(".logshow").html('<pre style="padding:10px; border-radius:2px;margin:5px;"><code class="php">'+data+'</code></pre>');
		 $("#codeshow").modal('show');
	   } else {
	     swal('无法读取日志信息','','error');
	   }
	  },'json');
    });
  })(jQuery);  
 </script>
</block>
<block name="bootstrap">
 <!--显示-->
  <div class="modal fade" id="codeshow">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius:0;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">日志信息详情</h4>
      </div>
      <div class="modal-body nano scrollable" style="height:300px; overflow:auto; width:99%; margin:0px auto; padding:8px;">
       <div class="logshow nano-content" style="height:300px;"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">{:icon('off')} 关闭</button>
      </div>
    </div>
  </div>
 </div>
 <!--结束-->
</block>