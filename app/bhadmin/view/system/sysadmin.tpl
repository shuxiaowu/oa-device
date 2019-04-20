<extend name="public/common" />
<block name="main">
 <div class="pubmain">
  <div class="panel-body">
  <div class="btn-group">
   {:btn(array('vals'=>'系统设置','size'=>3,'icon'=>'cog','scene'=>'default','round'=>1,'url'=>url('system/sysmod')))}
   {:btn(array('vals'=>'公司设置','size'=>3,'icon'=>'map-marker','scene'=>'default','url'=>url('system/syscompany')))}
   {:btn(array('vals'=>'水印设置','size'=>3,'icon'=>'tint','scene'=>'default','url'=>url('system/syswater')))}
   {:btn(array('vals'=>'上传设置','size'=>3,'icon'=>'paperclip','scene'=>'default','url'=>url('system/sysupload')))}
   {:btn(array('vals'=>' 后台目录设置','size'=>3,'icon'=>'folder-open','scene'=>'primary','round'=>1,'url'=>url('system/sysadmin')))}
   {:btn(array('vals'=>'IP过滤设置','size'=>3,'icon'=>'cog','scene'=>'default','url'=>url('system/ipfilter')))}
   {:btn(array('vals'=>'短信设置','size'=>3,'faicon'=>'commenting','scene'=>'default','url'=>url('system/sysmsg')))}
   {:btn(array('vals'=>'微信设置','size'=>3,'faicon'=>'weixin','scene'=>'default','url'=>url('system/sysweixin')))}
  </div>
  <div class="ui-block"></div>
  <div class="alert alert-primary" style="margin-bottom:10px;">
    小程序版本暂不支持
  </div>
 </div>
</block>