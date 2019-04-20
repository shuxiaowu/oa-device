<extend name="public/common" />
<block name="main">
  <div class="pubmain">
    <div class="panel-body">
      <div class="ui-block"></div>
      <form name="sqlform" method="post" action="" onSubmit="return cksql(document.sqlform)">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="{:tabstyle()}">
          <tr>
            <td width="15%" height="30" align="left" valign="middle">参数说明</td>
            <td height="30" align="left" valign="middle">参数值</td>
          </tr>
          <tr>
            <td height="25" align="left" valign="middle"> 执行语法<br/>
              <span class="full999" style="font-size:11px;">屏蔽字段 DELETE（删除数据操作） UPDATE（更改数据操作） TRUNCATE（清空表操作） DROP TABLE（删除表操作） 建议在导入表语法中 DROP TABLE IF EXISTS 'xx' 字样删除，查询数据时建议加上LIMIT 字样</span></td>
            <td height="25" align="left" valign="middle"><textarea class="sqltext form-control" name="sqltext" style="width:80% !important; min-height:300px !important;">{$sql}</textarea></td>
          </tr>
          <if condition="$sql neq ''">
            <tr class="info">
              <td height="25" align="left" valign="middle"> 执行结果<br/></td>
              <td height="25" align="left" valign="middle">{:dump($sqlres)}</td>
            </tr>
          </if>
          <tr>
            <td height="25" align="left" valign="middle"></td>
            <td height="35" align="left" valign="middle">{:btn(array('vals'=>'确定执行','size'=>3,'type'=>'submit','icon'=>'cog','scene'=>'primary'))}</td>
          </tr>
        </table>
      </form>
    </div>
  </div>
  <script type="text/javascript">
   function cksql( td ){
     if ( td.sqltext.value == '' ) { swal('请输入您需要执行的语法','','error'); return false; }
   }
 </script> 
</block>
