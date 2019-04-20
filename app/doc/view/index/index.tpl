<extend name="common/common" />
<block name="main">
  <include file="common/sidebar" />
  <div class="main">
    <include file="api/base" />
	
<h1><a id="devreport">盘点上报接口</a></h1>
<blockquote class="success">
  <div class="alert alert-info" style="margin-bottom:15px;">
    <dd><kbd class="method">GET</kbd> 调用地址：{$loacUrl}api/device/report</dd>
  </div>
  <table class="table table-bordered table-hover" style="margin:10px auto;">
    <tr>
      <th>参数名</th>
      <th>参数类型</th>
      <th>必传</th>
      <th>默认值</th>
      <th>描述</th>
    </tr>
    <tr>
      <td>devno</td>
      <td>String</td>
      <td><span style="color:green">Y<span></span></span></td>
      <td></td>
      <td>设备编号</td>
    </tr>
    <tr>
      <td>sn</td>
      <td>String</td>
      <td><span style="color:green">Y<span></span></span></td>
      <td></td>
      <td>盘点单号</td>
    </tr>
  </table>
  <h6>返回值</h6>
  <pre style="height:auto;">
{
  "success": 1,
  "retCode": 200,
  "msg": ""
}</pre>
</blockquote>
   
  </div>
  
  <div class="modal fade" role="dialog" id="copymodal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title">复制数据</h4></div>
        <div class="modal-body"><textarea class="form-control copyhtml" style="height:300px; border-radius:0;"></textarea></div>
      </div>
    </div>
  </div>

  <script src="{$base}/js/bootstrap.min.js" type="text/javascript"></script> 
  <script type="text/javascript">
  $(".pre-open").click(function(e) {
    if ( $(this).parent().height() <= 119 ) {
	  $(this).parent().height('auto'); 
	  $(this).text('收起');
	} else {
	  $(this).parent().height(119); 
	  $(this).text('展开');
	}
  });
  window.onload = function () {(window.onresize = function () {
	var width = document.documentElement.clientWidth - 242 - 40;
	var height = document.documentElement.clientHeight - $(".navbar").height() - 2;
    $(".sidebar,.main").height(height);
    $(".main").width(width);
  })()};
  
  $(".sidebar dd").click(function(e) {
	$(".sidebar dd a").css({'background':'#fff','color':'#666'})
    $(this).find('a').css({'background':'#f0faff','color':"#2d8cf0"});
  });
  
  $(".sidebar dl dt").click(function(e) {
	var h = $(this).parent().height();
	h = parseInt(h);
    if ( h <= 30 ) {
	  $(this).parent().find('.mybadge').remove('*');
	  $(this).parent().height('auto');
	} else {
	  len = $(this).parent().find("dd").length;
	  $(this).parent().find("dt").append('<font class="mybadge">'+len+'</font>') ;
	  $(this).parent().height(30);
	}
  });
  
  $("blockquote").each(function(index, element) {
	$(this).removeClass('info');
	$(this).removeClass('success');
    if ( (index+1)%2 ) {
	  $(this).addClass("info");
	} else {
	  $(this).addClass('success');
	}
  });
  
  //刷新到锚地
  var href  = window.location.href;
  var markA = href.split("#");
  var mark  = markA[markA.length-1];
  var ckid  = '';
  $(".sidebar dd").each(function(index, element) {
	 if ( $(this).find("a").attr('href') == '#'+mark ) {
	   setTimeout(function(){ window.location.href = '?#'+mark; },100);
	   ckid = $(this); 
	 }   
  });

  $(".s-hide").each(function(index, element) {
    $(this).height(30);
	len = $(this).find("dd").length;
	$(this).find("dt").append('<font class="mybadge">'+len+'</font>');
  });
  
  if ( ckid !='' ) {
    var h = parseInt(ckid.parent().height());
    if ( h <= 30 ) {
	  ckid.parent().find('.mybadge').remove('*');
	  ckid.parent().height('auto');
    }
    ckid.find('a').css({'background':'#f0faff','color':"#2d8cf0"});
  }
  
  $(".pre-copy").click(function(e) {
    var data = JSON.stringify($(this).data('cdata'));
	if ( data!='' ) {
	  $(".copyhtml").val(data);
	  $("#copymodal").modal('show');
	}  
  });
  
  $(".showsecret").click(function(e) {
     $(this).text($(this).data('secret')); 
  });
 </script> 
</block>
