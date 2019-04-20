<extend name="public/common" />
<block name="main">
  <div class="pubmain" style="min-width:2800px;">
    <div class="panel-body">
      <div class="u-plus btn-group">
        {:btn(array('vals'=>'新增资产','size'=>3,'scene'=>'primary','url'=>url('assets/assetsadd')))}
        <div class="dropdown pull-left" >
          <button id="dLabel" type="button" class="btn btn-default btn-sm printzc" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           批量导入
           <span class="caret"></span>
         </button>
         <ul class="dropdown-menu" aria-labelledby="dLabel">
           <li><a href="" data-toggle="modal" data-target="#myModals">上传入库</a></li>
           <li><a href="">下载模板</a></li>
         </ul>
       </div>
       {:btn(array('vals'=>'导出全部资产','size'=>3,'scene'=>'default','add'=>'printzc'))}
       {:btn(array('vals'=>'打印资产标签','size'=>3,'scene'=>'default','add'=>'printzc'))}
     </div>
     <form name="pubserch" method="get" action="{:url('assets/assetslist')}">
      <div class="search"> 资产编码/名称：
        <input type="text" class="text" name="name" placeholder="资产编码/名称/SN号" style="width:180px;">
        资产类目：{:dropdown([['Id'=>1,'topic'=>'闲置资产'],['Id'=>2,'topic'=>'维护资产'],['Id'=>3,'topic'=>'报废资产']],0,'请选择','state')}
        &nbsp;{:btn(array('vals'=>'查询','type'=>'submit','icon'=>'search','name'=>'searchdata','round'=>1,'scene'=>'primary'))}
      </div>
    </form>
    <div class="ui-block"></div>
    <form name="publist" method="post" action="" onSubmit="return pubdel(document.publist)">
      <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center" class="{:tabstyle()}">
        <tr class="active">
          <td width="45" align="center" valign="middle" height="37">{:ckall()}</td>
          <td width="100" align="center" valign="middle">资产状态</td>
          <td width="100" align="center" valign="middle">资产编码</td>
          <td width="100" align="center" valign="middle">资产名称</td>
          <td width="100" align="center" valign="middle">资产类别</td>
          <td width="100" align="center" valign="middle">入库时间</td>
          <td width="100" align="center" valign="middle">品牌</td>
          <td width="100" align="center" valign="middle">来源</td>
          <td width="100" align="center" valign="middle">型号</td>
          <td width="100" align="center" valign="middle">渠道</td>
          <td width="100" align="center" valign="middle">金额</td>
          <td width="100" align="center" valign="middle">购入时间</td>
          <td width="100" align="center" valign="middle">使用期限</td>
          <td width="100" align="center" valign="middle">SN号</td>
          <td width="100" align="center" valign="middle">保修起始时间</td>
          <td width="100" align="center" valign="middle">过保时间</td>
          <td width="100" align="center" valign="middle">图片</td>
          <td width="100" align="center" valign="middle">使用人</td>
          <td width="100" align="center" valign="middle">使用部门</td>
          <td width="100" align="center" valign="middle">使用地</td>
          <td width="100" align="center" valign="middle">领用时间</td>
          <td width="100" align="center" valign="middle">计量单位 </td>
          <td width="140" align="center" valign="middle">操作</td>
        </tr>
        <volist name="data" id="obj">
          <tr class="maintr">
            <td align="center" valign="middle" height="37">{:ckbox($obj['Id'],$i-1)}</td>
            <td align="center" valign="middle">
             <if condition="$obj['state'] eq 1"><font color="green">闲置</font></if>
             <if condition="$obj['state'] eq 2"><font color="#ff6600">维修</font></if>
             <if condition="$obj['state'] eq 3"><font color="red">报废</font></if>
           </td>
           <td align="center" valign="middle">{$obj['devno']}</td>
           <td align="center" valign="middle">{$obj['devname']}</td>
           <td align="center" valign="middle">{:getdata('assetstype',$obj['devtype'])}</td>
           <td align="center" valign="middle">{$obj['rkdate']}</td>
           <td align="center" valign="middle">{$obj['brand']}</td>
           <td align="center" valign="middle">{:getdata('assetssource',$obj['source'])}</td>
           <td align="center" valign="middle">{$obj['devxh']}</td>
           <td align="center" valign="middle">{$obj['channel']}</td>
           <td align="center" valign="middle">{$obj['price']}</td>
           <td align="center" valign="middle">{$obj['buydate']}</td>
           <td align="center" valign="middle">{$obj['uselimit']}月</td>
           <td align="center" valign="middle">{$obj['sn']}</td>
           <td align="center" valign="middle">{$obj['bxsdate']}</td>
           <td align="center" valign="middle">{$obj['bxedate']}</td>
           <td align="center" valign="middle"><if condition="$obj['pic'] neq ''"><img src="{:ispic($obj['pic'])}" data-action="zoom" height="20"><else/>无</if></td>
           <td align="center" valign="middle">--</td>
           <td align="center" valign="middle">--</td>
           <td align="center" valign="middle">--</td>
           <td align="center" valign="middle">--</td>
           <td align="center" valign="middle">{$obj['units']} </td>
           <td align="center" valign="middle">
            {:btn(array('vals'=>'编辑','icon'=>'edit','round'=>1,'tips'=>'点击编辑数据','url'=>url('assets/assetsmod','id='.$obj['Id'])))}
            {:btn(array('vals'=>'删除','icon'=>'trash','round'=>1,'tips'=>'点击删除数据','scene'=>'danger'))}
          </td>
        </tr>
      </volist>
      <tr>
        <td height="37" align="center" valign="middle">{:ckall(2)}</td>
        <td height="35" colspan="22" align="left" valign="middle">{$dshow['pageshow']} </td>
      </tr>
    </table>
  </form>

</div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModals" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document"  style="z-index: 99999">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">批量导入</h4>
      </div>
      <div class="modal-body" style="padding:40px;">
        <div style="width:100%; margin:0 0 10px auto; overflow:hidden;">
          <label style="float:left;padding-top:5px;">Excel表格：</label>
          <form id="addform" action="" method="post" enctype="multipart/form-data">
            <div class="box">
              <input type="text" name="copyFile"   class="textbox" id="textName"/>
              <a href="javascript:void(0);"  class="link">上传</a>
              <input type="file" name="excelData" class="uploadFile" value="" datatype="*4-50" nullmsg="请填写产品！" errormsg="不能少于4个字符大于50个汉字" onchange="document.getElementById('textName').value=this.value" />
              <input type="submit" class="btn btn-xs" value="点击导入" style="margin-left:20px; background:#0099ff;color: #fff;padding: 4px 6px; " />
            </div>
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
</block>
