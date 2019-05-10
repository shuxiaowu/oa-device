<extend name="public/common" />
<block name="main">
    <div class="pubmain" style="min-width:2800px;">
        <div class="panel-body">
            <div class="u-plus btn-group">
            	<if condition="$userid neq 1">
                 {:btn(array('vals'=>'新增','size'=>3,'scene'=>'primary','url'=>url('assets/assetsadd')))}
             </if>
             <div class="dropdown pull-left">
                <button id="dLabel" type="button" class="btn btn-default btn-sm printzc" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    导入
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dLabel">
                    <li><a href="" data-toggle="modal" data-target="#myModals">批量导入</a></li>
                    <li><a href="">下载模板</a></li>
                </ul>
            </div>
<!-- {:btn(array('vals'=>'导出全部资产','size'=>3,'scene'=>'default','add'=>'printzc'))}
   {:btn(array('vals'=>'打印资产标签','size'=>3,'scene'=>'default','add'=>'printzc'))} -->
</div>
<form name="pubserch" method="get" action="{:url('assets/assetslist')}">
    <div class="search"> 关键词：
        <input type="text" class="text" name="keyword" placeholder="车牌号/品牌号码" style="width:180px;">
        <!--         资产类目：{:dropdown([['Id'=>1,'topic'=>'闲置资产'],['Id'=>2,'topic'=>'维护资产'],['Id'=>3,'topic'=>'报废资产']],0,'请选择','state')} -->
        &nbsp;{:btn(array('vals'=>'查询','type'=>'submit','icon'=>'search','name'=>'searchdata','round'=>1,'scene'=>'primary'))}
    </div>
</form>
<div class="ui-block"></div>
<form name="publist" method="post" action="" onSubmit="return pubdel(document.publist)">
    <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center" class="{:tabstyle()}">
        <tr class="active">
            <td width="45" align="center" valign="middle" height="37">{:ckall()}</td>
            <td width="100" align="center" valign="middle">车牌号码</td>
            <td width="100" align="center" valign="middle">品牌号码</td>
            <td width="100" align="center" valign="middle">排气量(升)</td>
            <td width="100" align="center" valign="middle">车辆类型</td>
            <td width="100" align="center" valign="middle">座位数</td>
            <td width="100" align="center" valign="middle">购车净价(万元)</td>
            <td width="100" align="center" valign="middle">行驶里程(公里)</td>
            <td width="100" align="center" valign="middle">累积行驶里程(公里)</td>
            <td width="100" align="center" valign="middle">加油卡号</td>
            <td width="100" align="center" valign="middle">赣通卡号</td>
            <td width="100" align="center" valign="middle">上次保险日期</td>
            <td width="100" align="center" valign="middle">年保险金额</td>
            <td width="100" align="center" valign="middle">用途</td>
            <td width="100" align="center" valign="middle">备注</td>
            <if condition="$userid eq 1">
                <td width="100" align="center" valign="middle">添加人名称</td>
            </if>
            <td width="140" align="center" valign="middle">操作</td>
        </tr>
        <volist name="data" id="obj">
            <tr class="maintr">
                <td align="center" valign="middle" height="37">{:ckbox($obj['Id'],$i-1)}</td>
                <td align="center" valign="middle">{$obj['licensenum']}</td>
                <td align="center" valign="middle">{$obj['brand']}</td>
                <td align="center" valign="middle">{$obj['displacement']}</td>
                <td align="center" valign="middle">{$obj['cartype']}</td>
                <td align="center" valign="middle">{$obj['seat']}</td>
                <td align="center" valign="middle">{$obj['price']}</td>
                <td align="center" valign="middle">{$obj['distance']}</td>
                <td align="center" valign="middle">{$obj['alldistance']}</td>
                <td align="center" valign="middle">{$obj['jiayouc']}</td>
                <td align="center" valign="middle">{$obj['gantongc']}</td>
                <td align="center" valign="middle">{:showdate($obj['safedate'])}</td>
                <td align="center" valign="middle">{$obj['safeprice']}</td>
                <td align="center" valign="middle">{$obj['purpose']}</td>
                <td align="center" valign="middle">{$obj['remark']}</td>
                <if condition="$userid eq 1">
                 <td align="center" valign="middle">{$obj['adminrealname']}</td>
             </if>
             <td align="center" valign="middle">
                {:btn(array('vals'=>'编辑','icon'=>'edit','round'=>1,'tips'=>'点击编辑数据','url'=>url('assets/assetsmod','id='.$obj['Id'])))}
            </td>
        </tr>
    </volist>
    <tr>
        <td height="35" colspan="2" align="left" valign="middle">
            <if condition="$userid eq 1">
                {:btn(array('vals'=>'删除','type'=>'submit','round'=>1,'name'=>'deldata','icon'=>'trash','scene'=>'danger'))}
                {$dshow['pageshow']}
                <else />
                {:btn(array('vals'=>'删除','type'=>'submit','round'=>1,'name'=>'deldata','icon'=>'trash','scene'=>'danger','ban'=>1,'tips'=>'该账号删除没有权限'))}
                <span class="glyphicon glyphicon-warning-sign"></span> 该账号没有删除权限！
            </if>
        </td>
        <td height="35" colspan="22" align="left" valign="middle">{$dshow['pageshow']} </td>
    </tr>
</table>
</form>
</div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModals" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="z-index: 99999">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">批量导入</h4>
            </div>
            <div class="modal-body" style="padding:40px;">
                <div style="width:100%; margin:0 0 10px auto; overflow:hidden;">
                    <label style="float:left;padding-top:5px;">Excel表格：</label>
                    <form id="addform" action="{:url('Excel/savestudentImport')}" method="post" enctype="multipart/form-data">
                        <div class="box">
                            <input type="text" name="copyFile" class="textbox" id="textName" />
                            <a href=""  class="link">上传</a>
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