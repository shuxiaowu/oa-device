<extend name="public/common" />
<block name="main">
    <div class="pubmain">
        <div class="panel-body">
            <div class="u-plus btn-group">
                <if condition="$userid neq 1">
                    {:btn(array('vals'=>'新增','size'=>3,'scene'=>'primary','url'=>url('assets/gasrecordadd')))}
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
            </div>
            <form name="pubserch" method="get" action="{:url('assets/gasrecordlist')}">
               <div class="search"> 关键词：
                    <input type="text" class="text" name="keyword" placeholder="驾驶员" style="width:180px;">
                    {:dropdown($dengji,0,'请选择车牌号','licensenum','licensenum')}
                    &nbsp;{:btn(array('vals'=>'查询','type'=>'submit','icon'=>'search','name'=>'searchdata','round'=>1,'scene'=>'primary'))}
                </div>
            </form>
            <div class="ui-block"></div>
            <form name="publist" method="post" action="" onSubmit="return pubdel(document.publist)">
                <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center" class="{:tabstyle()}">
                    <tr class="active">
                        <td align="center" valign="middle" height="37">{:ckall()}</td>
                        <td align="center" valign="middle">车牌号码</td>
                        <td align="center" valign="middle">驾驶员</td>
                         <td width="100" align="center" valign="middle">品牌型号</td>
                          <td width="100" align="center" valign="middle">车辆类型</td>
                        <td align="center" valign="middle">加油类型</td>
                        <td align="center" valign="middle">加油量(升)</td>
                        <td align="center" valign="middle">日期</td>
                        <td align="center" valign="middle">加油地点</td>
                        <td align="center" valign="middle">费用(元)</td>
                         <if condition="$userid eq 1">
                            <td width="100" align="center" valign="middle">添加人名称</td>
                        </if>
                        <td align="center" valign="middle">操作</td>
                    </tr>
                    <volist name="data" id="obj">
                        <tr class="maintr">
                            <td align="center" valign="middle" height="37">{:ckbox($obj['Id'],$i-1)}</td>
                            <td align="center" valign="middle">{:gtopic('usecar',$obj['licensenum'],'licensenum')}</td>
                            <td align="center" valign="middle">{$obj['driver']}</td>
                             <td align="center" valign="middle">{:gtopic('usecar',$obj['licensenum'],'brand')}</td>
                            <td align="center" valign="middle">{:gtopic('usecar',$obj['licensenum'],'cartype')}</td>
                            <td align="center" valign="middle">{$obj['gastype']}</td>
                            <td align="center" valign="middle">{$obj['gasvolum']}</td>
                            <td align="center" valign="middle">{:showdate($obj['adddate'])}</td>
                            <td align="center" valign="middle">{$obj['address']}</td>
                            <td align="center" valign="middle">{$obj['price']}</td>
                            <if condition="$userid eq 1">
                                <td align="center" valign="middle">{$obj['adminrealname']}</td>
                            </if>
                            <td align="center" valign="middle">
                                {:btn(array('vals'=>'编辑','icon'=>'edit','round'=>1,'tips'=>'点击编辑数据','url'=>url('assets/gasrecordmod','id='.$obj['Id'])))}
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