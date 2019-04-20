<extend name="public/common" />
<block name="main">
 <div class="pubmain">
  <div class="panel-body">
  <div class="btn-group">
   {:btn(array('vals'=>'系统设置','size'=>3,'icon'=>'cog','scene'=>'default','round'=>1,'url'=>url('system/sysmod')))}
   {:btn(array('vals'=>'公司设置','size'=>3,'icon'=>'map-marker','scene'=>'default','url'=>url('system/syscompany')))}
   {:btn(array('vals'=>'水印设置','size'=>3,'icon'=>'tint','scene'=>'default','url'=>url('system/syswater')))}
   {:btn(array('vals'=>'上传设置','size'=>3,'icon'=>'paperclip','scene'=>'default','url'=>url('system/sysupload')))}
   {:btn(array('vals'=>'后台目录设置','size'=>3,'icon'=>'folder-open','scene'=>'default','url'=>url('system/sysadmin')))}
   {:btn(array('vals'=>'IP过滤设置','size'=>3,'icon'=>'cog','scene'=>'primary','url'=>url('system/ipfilter')))}
   {:btn(array('vals'=>'短信设置','size'=>3,'faicon'=>'commenting','scene'=>'default','url'=>url('system/sysmsg')))}
   {:btn(array('vals'=>'微信设置','size'=>3,'faicon'=>'weixin','scene'=>'default','url'=>url('system/sysweixin')))}
  </div>
  <div class="ui-block"></div>
   <form name="sysmod" method="post" action="">
    <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="{:tabstyle()}">
      <tr>
        <td width="10%" height="30" align="left" valign="middle">参数说明</td>
        <td align="left" valign="middle">参数值</td>
      </tr>
      <tr>
        <td align="left" valign="middle">过滤IP:<br/> <span class="full999" style="font-size:11px;">（IP地址）用|分开<br/> 但不要在结尾加，例如：127.0.0.1|127.0.0.2</span></td>
        <td align="left" valign="middle">{:inputs(array('name'=>'shieldip','val'=>$data['shieldip'],'type'=>'textarea'))}</tr>
      <tr>
        <td align="left" valign="middle">提示说明：</td>
        <td align="left" valign="middle">{:inputs(array('name'=>'iptips','val'=>$data['iptips'],'icon'=>'question-sign','tips'=>'屏蔽IP提示说明'))}</td>
      </tr>
      <tr>
        <td align="left" height="35" valign="middle"></td>
        <td align="left" valign="middle">{:btn(array('vals'=>'确定保存','size'=>3,'type'=>'submit','icon'=>'cog','scene'=>'primary'))}</td>
      </tr>
    </table>
    </form>
  </div>
 </div>
</block>