<extend name="public/common" />
<block name="main">
 <div class="pubmain pub-minw">
 <div class="panel-body">
 <div class="alert alert-primary" style="margin:0px auto 10px auto">数据大小：{$sdata[0]['data_size']} 索引大小：{$sdata[0]['index_size']} 数据库占用大小：{$sdata[0]['data_size']+$sdata[0]['index_size']} MB</span></div>
 <form name="publist" method="post" action="" onSubmit="return pubdel(document.publist)"> 
  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="{:tabstyle()}">
   <tr>
     <td width="45" align="center" valign="middle" height="35">{:ckall()}</td>
     <td width="140" align="left" valign="middle">数据表名称</td>
     <td width="140" align="left" valign="middle">记录数</td>
     <td width="140" align="left" valign="middle">类型</td>
     <td width="140" align="left" valign="middle">编码</td>
     <td align="left" valign="middle">操作</td>
   </tr>
   <volist name="data" id="obj">
   <tr class="maintr">
    <td align="center" valign="middle" height="35"><input type="checkbox" value="{$obj['table']}" id="box{$i}" name="datebasename[]" class="myselect m-checkbox" /><label for="box{$i}"></label></td>
    <td align="left" valign="middle">{$obj['table']}</td>
    <td align="left" valign="middle">{$obj['count']}</td>
    <td align="left" valign="middle">MyISAM</td>
    <td align="left" valign="middle">utf8_general_ci</td>
    <td align="left" valign="middle">
     &nbsp;<a href="javascript:void(0)" onClick="setData('{$obj['table']}','opt')">{:btn(array('vals'=>'优化','round'=>1,'tips'=>'优化数据表结构，清除索引数据','faicon'=>'repeat','scene'=>'purple'))}</a>
     &nbsp;<a href="javascript:void(0)" onClick="setData('{$obj['table']}','repair')">{:btn(array('vals'=>'修复','round'=>1,'tips'=>'修复数据表','icon'=>'wrench','scene'=>'success'))}</a>
     &nbsp;{:btn(array('vals'=>'查看','round'=>1,'tips'=>'点击查看数据','url'=>url('system/tdatalist','tb='.$obj['table']),'icon'=>'eye-open','scene'=>'info'))}
     &nbsp;{:btn(array('vals'=>'结构','round'=>1,'tips'=>'点击查看数据结构','url'=>url('system/struct','tb='.$obj['table']),'icon'=>'cog','scene'=>'danger'))}
    </td>
   </tr>
   </volist>
   <tr>
     <td height="35" align="center" valign="middle">{:ckall(2)}</td>
     <td colspan="5" align="left" valign="middle">
     &nbsp;{:btn(array('vals'=>'优化','type'=>'submit','round'=>1,'tips'=>'优化数据表结构，清除索引数据','faicon'=>'repeat','scene'=>'purple'))}
     &nbsp;{:btn(array('vals'=>'修复','type'=>'submit','round'=>1,'tips'=>'修复数据表','icon'=>'wrench','scene'=>'success'))}
     &nbsp;{:btn(array('vals'=>'备份','type'=>'submit','round'=>1,'tips'=>'对所选数据库的数据及结构进行备份处理，备份文件在服务器内','faicon'=>'copy','scene'=>'primary'))}
     </td>
   </tr>
  </table>
  </form>
   <div class="alert alert-danger" style="margin:10px auto;">{:icon('warning-sign')} 提示，建议您定期对数据库进行备份处理，防止数据丢失,<font color="red">假设您的数据量太大，不建议在线上备份数据库！</font></div>
  </div>
 </div>
 <script type="text/javascript">
   function setData(db,act){
	  if(db!='' && act!=''){  
		 $.post( "{:url('admin/setdata')}", {'tables':db,'acts':act,'act':'setdata'},function(data){
			if(data==1){
				if(act=="opt"){
				  swal('数据表['+db+']优化完成！','','success');
				}else if(act=="repair"){
				  swal('数据表['+db+']修复完成！','','success');
				}else{
				  swal('非系统命令，无法执行','','error');
				}
			}else{
			  swal(data,'','error');
			}
		 },'json');
	  }else{
		swal('数据提交有误','','error');
	  }
	}
 </script>
</block>