<extend name="public/common" />
<block name="main">
 <style>
 .cs-plus{ padding:5px 6px; background-color:#31b0d5; color:#fff; position:relative; top:7px; border-radius:3px; padding:4px 8px;}
 .cs-plus:hover{ color:#fff;}
 .cs-minus{ padding:5px 6px; background-color:#f00; color:#fff; position:relative; top:7px; border-radius:3px; padding:4px 8px;}
 .cs-minus:hover{ color:#fff;}
 .csline,.headline{border-bottom:dashed 1px #ddd; height:auto; overflow:hidden; padding:5px 0;}
 </style>
 <div class="pubmain">
  <div class="panel-body">
  <div class="ui-block"></div>
   <form name="tookform" method="post" action="" onSubmit="return cktool(document.tookform)">
    
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="{:tabstyle()}">
      <tr>
        <td height="30" align="left" valign="middle" colspan="2">
          <select class="form-control method" name="methods" style="width:110px; float:left;">
            <option value="POST" <if condition="$methods and $methods eq 'POST'">selected</if>>POST</option>
            <option value="GET" <if condition="$methods and $methods eq 'GET'">selected</if>>GET</option>
          </select>
          <input type="text" placeholder="http://" value="{$url?:''}" class="form-control" name="url" style="width:460px; float:left;">
          <button class="btn btn-success send" type="submit" style="height:30px;">发送请求</button>
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
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="{:tabstyle()}">
      <tr>
        <td width="120" height="30" align="left" valign="middle">HEAD参数名称</td>
        <td height="30" align="left" valign="middle">参数值 <font color="red">[GET方式传输无效]</font></td>
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
    <div style="height:10px;"></div>
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="{:tabstyle()}">
      <tr>
        <td height="30" align="left" valign="middle">返回值</td>
      </tr>
      <tr>
        <td height="30" align="left" colspan="2" valign="middle"><div class="response-body">
        <notempty name="sheader"><h6>请求头：</h6>{:dump($sheader)}</notempty>
        <if condition="$resjson neq ''"><h6>JSON：</h6><textarea class="form-control" style="min-height:60px; margin:0 auto 10px auto">{$resjson}</textarea></if>
        <if condition="$res neq ''"><h6>渲染值：</h6>{:dump($res)}</if>
        </div></td>
      </tr>
    </table>
   </form>
  </div>
 </div>
 <script type="text/javascript">
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