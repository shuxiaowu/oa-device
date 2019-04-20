<extend name="common/common" />
<block name="main">
<style>
 .cs-plus{color:#333; position:relative; top:7px; font-size:12px;}
 .cs-minus{ color:red; position:relative; top:7px; font-size:12px;}
 .cs-minus:hover{ text-decoration:underline;color:red;}
 .csline,.headline{height:auto; overflow:hidden; padding:5px 0;}
 .form-control{font-size:13px;height:100%;border-radius:0;box-shadow:none;border:1px solid #e9e9e9;transition-duration:.5s}
 .form-control:focus{border-color:#42a5f5;box-shadow:none;transition-duration:.5s}
 .form-control:focus-feedback{z-index:10}
 .form-control{ height:30px !important; float:left; margin:0 5px 0 0;font-size:12px !important; border:solid 1px #ddd; border-radius:1px;}
</style>
<div class="sidebar pull-left">
  <div class="version">在线调试 <font color="red">new</font></div>
  <dl>
    <dt><span></span>选择身份查询</dt>
    <volist name="tdata" id="tobj">
      <dd><a href="{:url('doc/index/record','type='.$tobj['type'])}">{$tobj['remark']}</a></dd>
    </volist>
    <dt><span></span>在线调试</dt>
    <dd><a href="{:url('doc/index/tool')}" class="active">在线调试</a></dd>
  </dl>
</div>
<div class="main" style="min-height:700px;">
 <div class="alert alert-info" style="margin:10px auto;">接口在线调试</div>
 <form name="tookform" method="post" action="" onSubmit="return cktool(document.tookform)">
    
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table table-bordered" style="margin:15px auto 0px auto">
      <tr>
        <td height="30" align="left" valign="middle" colspan="2">
          <select class="form-control method" name="methods" style="width:110px; float:left; background-color:#f2f2f2">
            <option value="POST" <if condition="$methods and $methods eq 'POST'">selected</if>>POST</option>
            <option value="GET" <if condition="$methods and $methods eq 'GET'">selected</if>>GET</option>
          </select>
          <input type="text" placeholder="http://" value="{$url?:''}" class="form-control" name="url" style="width:460px; float:left; background-color:#f2f2f2; color:#666;">
          <button class="btn btn-info send" type="submit" style="height:30px;">发送请求</button>
        </td>
      </tr>
      <tr>
        <td width="120" height="30" align="left" valign="middle">参数名称</td>
        <td height="30" align="left" valign="middle">参数值</td>
      </tr>
      <tr>
        <td height="30" align="left" valign="middle" colspan="2">
         <div class="csdiv">
           <notempty name="postdata">
           <foreach name="postdata" key="k" item="ps">
           <div class="csline">
            <input type="text" placeholder="参数名" value="{$k}" class="form-control" name="csm[]" style="width:110px; float:left;">
            <input type="text" placeholder="参数值" value="{$ps}" class="form-control" name="csz[]" style="width:460px; float:left;">
            <a href="javascript:void(0)" class="cs-plus">增加参数</a>
           </div>
           </foreach>
           
           <else/>
           <div class="csline">
            <input type="text" placeholder="参数名" value="" class="form-control" name="csm[]" style="width:110px; float:left;">
            <input type="text" placeholder="参数值" value="" class="form-control" name="csz[]" style="width:460px; float:left;">
            <a href="javascript:void(0)" class="cs-plus">增加参数</a>
           </div>
           </notempty>
           
           
         </div>
        </td>
      </tr>
    </table>
    <div style="height:10px;"></div>
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table table-bordered" style="margin:0 auto 10px auto">
      <tr>
        <td width="120" height="30" align="left" valign="middle">请求头参数名称</td>
        <td height="30" align="left" valign="middle">参数值 <font color="red">[GET参数传输无效]</font></td>
      </tr>
      <tr>
        <td height="30" align="left" valign="middle" colspan="2">
         <div class="headdiv">
           <notempty name="head">
           <foreach name="head" key="h" item="he">
           <div class="headline">
            <input type="text" placeholder="参数名" value="{$h}" class="form-control" name="headcsm[]" style="width:110px; float:left;">
            <input type="text" placeholder="参数值" value="{$he}" class="form-control" name="headcsz[]" style="width:460px; float:left;">
            <a href="javascript:void(0)" class="cs-plus">增加参数</a>
           </div>
           </foreach>
           <else/>
           <div class="headline">
            <input type="text" placeholder="参数名" value="" class="form-control" name="headcsm[]" style="width:110px; float:left;">
            <input type="text" placeholder="参数值" value="" class="form-control" name="headcsz[]" style="width:460px; float:left;">
            <a href="javascript:void(0)" class="cs-plus">增加参数</a>
           </div>
           </notempty>
         </div>
        </td>
      </tr>
    </table>
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table table-bordered">
      <tr>
        <td height="30" align="left" valign="middle">返回值</td>
      </tr>
      <tr>
        <td height="30" align="left" colspan="2" valign="middle">
        <div class="response-body">
         <notempty name="sheader"><h6>请求头：</h6>{:dump($sheader)}</notempty>
         <if condition="$resjson neq ''"><h6>Json：</h6><textarea class="form-control" style="min-height:60px; margin:0 auto 10px auto; background-color:#f2f2f2;">{$resjson}</textarea></if>
         <if condition="$res neq ''"><h6>渲染值：</h6>{:dump($res)}</if>
        </div>
        </td>
      </tr>
    </table>
   </form>
</div>
<script type="text/javascript">
  function cktool(td){
    if ( td.url.value == '' ) { alert('请求的链接为空'); return false; }
  }
  window.onload = function () {(window.onresize = function () {
	var width = document.documentElement.clientWidth - 240 - 42;
	var height = document.documentElement.clientHeight - $(".navbar").height() - 2;
    $(".sidebar,.main").height(height);
    $(".main").width(width);
  })()};
   $(".csdiv .cs-plus").click(function(e) {
	 var tpl = '<div class="csline"><input type="text" placeholder="参数名" value="" class="form-control" name="csm[]" style="width:110px; float:left;"><input type="text" placeholder="参数值" value="" class="form-control" name="csz[]" style="width:460px; float:left;"><a href="javascript:void(0)" class="cs-minus">删除参数</a></div>';
	 $('.csdiv').append(tpl);
   });
   $(".headdiv .cs-plus").click(function(e) {
	 var tpl = '<div class="headline"><input type="text" placeholder="参数名" value="" class="form-control" name="headcsm[]" style="width:110px; float:left;"><input type="text" placeholder="参数值" value="" class="form-control" name="headcsz[]" style="width:460px; float:left;"><a href="javascript:void(0)" class="cs-minus">删除参数</a></div>';
	 $('.headdiv').append(tpl);
   });
   $('body').on('click','.cs-minus',function(e){
	 $(this).parent().remove('*');
   });
   $(".csline .cs-plus").each(function(index, element) {
     if ( index > 0 ) $(this).removeClass('cs-plus').addClass('cs-minus').text('删除参数'); 
   });
   $(".headline .cs-plus").each(function(index, element) {
     if ( index > 0 ) $(this).removeClass('cs-plus').addClass('cs-minus').text('删除参数'); 
   });
 </script>
</block>
