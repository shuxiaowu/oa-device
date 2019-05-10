<extend name="public/common" />
<block name="main">
  <div class="pubmain">
    <div class="panel-body">
      <div class="u-plus">{:btn(array('vals'=>'添加','size'=>3,'icon'=>'plus','scene'=>'primary','url'=>url('system/useradd')))}</div>
      <form name="publist" method="post" action="" onSubmit="return pubdel(document.publist)">
        <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center" class="{:tabstyle()}">
          <tr class="active">
            <td width="45" align="center" valign="middle" height="37">{:ckall()}</td>
            <td width="100" align="left" valign="middle">账号</td>
            <td width="160" align="left" valign="middle">单位名称</td>
            <td width="120" align="left" valign="middle">所属权限</td>
            <td width="120" align="left" valign="middle">负责人</td>
            <td width="120" align="left" valign="middle">联系方式</td>
            <td width="120" align="left" valign="middle">单位电话</td>
            <td width="120" align="left" valign="middle">地址</td>
            <td width="120" align="left" valign="middle">状态</td>
            <td width="120" align="center" valign="middle">登录次数</td>
            <td width="120" align="center" valign="middle">最后登录IP</td>
            <td width="160" align="center" valign="middle">最后登录时间</td>
            <td align="left" valign="middle">操作</td>
          </tr>
          <volist name="data" id="obj">
            <tr class="maintr">
              <td align="center" valign="middle" height="37">{:ckbox($obj['Id'],$i-1)}</td>
              <td align="left" valign="middle">{$obj['user']}</td>
              <td align="left" valign="middle">{$obj['realname']}</td>
              <td align="left" valign="middle">{:gtopic('admindepartment',$obj['depid'],'topic','--')}</td>
              <td align="center" valign="middle">{$obj['principal']}</td>
              <td align="center" valign="middle">{$obj['contact']}</td>
              <td align="center" valign="middle">{$obj['telephone']}</td>
              <td align="center" valign="middle">{$obj['address']}</td>
              <td align="center" valign="middle">{$obj['state']}</td>
              <td align="center" valign="middle">{$obj['count']}</td>
              <td align="center" valign="middle">{$obj['last_ip']?:'未登录'}</td>
              <td align="center" valign="middle">{$obj['last_time']?:'未登录'}</td>
              <td align="left" valign="middle">{:btn(array('vals'=>'编辑','round'=>1,'icon'=>'edit','tips'=>'点击编辑数据','url'=>url('system/usermod','id='.$obj['Id'])))}</td>
            </tr>
          </volist>
          <tr>
            <td height="37" align="center" valign="middle">{:ckall(2)}</td>
            <td height="35" colspan="15" align="left" valign="middle"> {:btn(array('vals'=>'删除','type'=>'submit','name'=>'deldata','round'=>1,'icon'=>'trash','scene'=>'danger'))}
              {$dshow['pageshow']} </td>
          </tr>
        </table>
      </form>
      <div class="alert alert-primary" style="margin:10px auto;">{:icon('warning-sign')} 提示，任何形式删除的数据都无法找回，管理员删除，请保证后台至少有一个管理用户。</div>
    </div>
  </div>
</block>
