<extend name="public/common" />
<block name="main">
    <script src="__js__/highcharts.js"></script>
    <style>
    .panel-body {
        min-height: 300px;
    }

    .alert a {
        color: #f60;
    }
    </style>
    <div class="pubmain">
        <div class="panel-body">
            <div class="chart-group" style="margin-bottom:10px;">
                <div class="chart-div" onClick="window.location='{:url(" licai/tzlist")}'"> <div class="chart-icon">{:faicon('clipboard')}</div>
                <div class="chart-topic">
                    <b></b>
                    <span title=""></span>
                </div>
            </div>
            <div class="chart-div sence2" onClick="window.location='{:url(" licai/jklist")}'"> <div class="chart-icon">{:faicon('clipboard')}</div>
            <div class="chart-topic">
                <b></b>
                <span title=""></span>
            </div>
        </div>
        <div class="chart-div sence3" onClick="window.location='{:url(" licai/tzcheck")}'"> <div class="chart-icon">{:faicon('pencil')}</div>
        <div class="chart-topic">
            <b></b>
            <span></span>
        </div>
    </div>
    <div class="chart-div sence5" onClick="window.location='{:url(" licai/jkcheck")}'"> <div class="chart-icon">{:faicon('pencil')}</div>
    <div class="chart-topic">
        <b></b>
        <span></span>
    </div>
    </div>
    <div class="chart-div sence4" onClick="window.location='{:url(" user/userlist")}'"> <div class="chart-icon">{:picon('male-female')}</div>
    <div class="chart-topic">
        <b></b>
        <span></span>
    </div>
    </div>
    </div>
    <div class="alert alert-primary">
        <p>&nbsp;{:icon('cog')}&nbsp;&nbsp;系统提示：如果您长时间不使用系统，但是又不想退出系统，您可以点击 <a href="javascript:void(0)" class="lockscreen">{:faicon('lock')} 锁屏</a> 锁定屏幕！</p>
        <p>&nbsp;{:icon('cog')}&nbsp;&nbsp;系统提示：当您新增或者修改了数据信息时，请点击 <a href="{:url('index/cleancache')}" style="color:#000">{:icon('trash')} 清除缓存</a> ，删除掉系统缓存，保证前台显示最新的数据。</p>
        <if condition="$sysInfo['backupcount'] gt 0">
            <p>&nbsp;{:icon('info-sign')}&nbsp;&nbsp;您有 {$sysInfo['backupcount']} 条数据库备份信息，建议您定时<a href="{:url('system/databackup')}">{:icon('trash')} 备份</a> 您的数据库信息，您上次备份数据的时间为 {$sysInfo['backuptime']}。</p>
        </if>
    </div>
    <div class="modal fade" id="useit">
        <div class="modal-dialog modal-md">
            <div class="modal-content" style="border-radius:0;">
                <div class="modal-body">
                    <!----->
                    <div>
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#updatelog" aria-controls="updatelog" role="tab" data-toggle="tab">{:icon('list-alt')} 更新日志</a></li>
                            <li role="presentation"><a href="#contact" aria-controls="contact" role="tab" data-toggle="tab">{:icon('map-marker')} 联系我们</a></li>
                        </ul>
                    </div>
                    <!---->
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="eq-height" style="margin-top:10px;">
            <div class="col-md-4 col-lg-4 eq-box-lg" style="padding:0px 0px 0 10px">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="panel-control panel-control-component"> <span class="text-muted"></span> </div>
                        <h3 class="panel-title">车辆保险年检提醒</h3>
                    </div>
                    <div class="panel-body">
                        <table class="tablev table-bordered table-hover" style="width:100%">
                            <tr height="50">
                                <td align="center">上月应年检(辆)</td>
                                <td align="center" width="100">20</td>
                            </tr>
                            <tr height="50">
                                <td align="center">本月应交保险(辆)</td>
                                <td align="center">30</td>
                            </tr>
                            <tr height="50">
                                <td align="center" colspan="2"><a href="javascript:void(0)">查看</a></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-lg-8 eq-box-lg" style="padding:0px 0px 0 10px">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="panel-control panel-control-component">
                            <span class="text-muted"><a href="javascript:void(0)">查看</a></span>
                        </div>
                        <h3 class="panel-title">车况信息表</h3>
                    </div>
                    <div class="panel-body">
                        <div id="userz" style="width: 100%;height: 277px; margin:0px; overflow:hidden;">
                            数据加载中..
                        </div>
                        <script>
                        $(function() {
                            $('#userz').highcharts({
                                chart: { type: 'column' }, //column
                                title: { text: '最近4个月车辆统计信息图', x: -20 },
                                subtitle: { text: '', x: -20 },
                                xAxis: { categories: ['1月', '2月', '3月', '4月'] },
                                yAxis: { title: { text: '车辆数(辆)' }, plotLines: [{ value: 0, width: 1, color: '#808080' }] },
                                tooltip: { valueSuffix: '辆' },
                                legend: { layout: 'vertical', align: 'right', verticalAlign: 'middle', borderWidth: 0 },
                                series: [{
                                    name: '新增',
                                    data: [5, 6, 7, 3]
                                }, {
                                    name: '报废',
                                    data: [3, 5, 2, 4]
                                }, {
                                    name: '拍卖',
                                    data: [2, 3, 1, 2]
                                }, {
                                    name: '在用',
                                    data: [25, 20, 23, 24]
                                }]
                            });
                        });
                        </script>
                    </div>
                </div>
            </div>
                    <div class="col-md-4 col-lg-4 eq-box-lg" style="padding:0px 0px 0 10px">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-control panel-control-component"> <span class="text-muted"></span> </div>
                    <h3 class="panel-title">车辆出行记录</h3>
                </div>
                <div class="panel-body">
                    <table class="tablev table-bordered table-hover" style="width:100%">
                        <tr height="50">
                            <td align="center">本月出行(次)</td>
                            <td align="center" width="100">50</td>
                        </tr>
                        <tr height="50">
                            <td align="center">上月出行(次)</td>
                            <td align="center" width="100">20</td>
                        </tr>
                        <tr height="50">
                            <td align="center">本年出行(次)</td>
                            <td align="center">15</td>
                        </tr>
                        <tr height="50">
                            <td align="center">累积出行(次)</td>
                            <td align="center">85</td>
                        </tr>
                        <tr height="50">
                            <td align="center" colspan="2"><a href="javascript:void(0)">查看</a></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </div>
    <hr>
    <div class="row">
                 <div class="col-md-4 col-lg-4 eq-box-lg" style="padding:0px 0px 0 10px">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-control panel-control-component"> <span class="text-muted"></span> </div>
                <h3 class="panel-title">车辆违章记录</h3>
            </div>
            <div class="panel-body">
                <table class="tablev table-bordered table-hover" style="width:100%">
                    <tr height="50">
                        <td align="center"></td>
                        <td align="center" width="100">次数</td>
                        <td align="center" width="100">金额</td>
                    </tr>
                    <tr height="50">
                        <td align="center">本月违章</td>
                        <td align="center" width="100">50</td>
                        <td align="center" width="100">50</td>
                    </tr>
                    <tr height="50">
                        <td align="center">上月违章</td>
                        <td align="center" width="100">20</td>
                        <td align="center" width="100">50</td>
                    </tr>
                    <tr height="50">
                        <td align="center">本年违章</td>
                        <td align="center">15</td>
                        <td align="center" width="100">50</td>
                    </tr>
                    <tr height="50">
                        <td align="center">累积违章</td>
                        <td align="center">85</td>
                        <td align="center" width="100">50</td>
                    </tr>
                    <tr height="50">
                        <td align="center" colspan="4"><a href="javascript:void(0)">查看</a></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
         <div class="col-md-4 col-lg-4 eq-box-lg" style="padding:0px 0px 0 10px">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-control panel-control-component"> <span class="text-muted"></span> </div>
                <h3 class="panel-title">车辆维修记录</h3>
            </div>
            <div class="panel-body">
                <table class="tablev table-bordered table-hover" style="width:100%">
                    <tr height="50">
                        <td align="center"></td>
                        <td align="center" width="100">次数</td>
                        <td align="center" width="100">金额</td>
                    </tr>
                    <tr height="50">
                        <td align="center">本月维修(次)</td>
                        <td align="center" width="100">50</td>
                        <td align="center" width="100">50</td>
                    </tr>
                    <tr height="50">
                        <td align="center">上月维修(次)</td>
                        <td align="center" width="100">20</td>
                        <td align="center" width="100">50</td>
                    </tr>
                    <tr height="50">
                        <td align="center">本年维修(次)</td>
                        <td align="center">15</td>
                        <td align="center" width="100">50</td>
                    </tr>
                    <tr height="50">
                        <td align="center">累积出行(次)</td>
                        <td align="center">85</td>
                        <td align="center" width="100">50</td>
                    </tr>
                    <tr height="50">
                        <td align="center" colspan="3"><a href="javascript:void(0)">查看</a></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
     <div class="col-md-4 col-lg-4 eq-box-lg" style="padding:0px 0px 0 10px">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-control panel-control-component"> <span class="text-muted"></span> </div>
                <h3 class="panel-title">车辆加油记录</h3>
            </div>
            <div class="panel-body">
                <table class="tablev table-bordered table-hover" style="width:100%">
                    <tr height="50">
                        <td align="center"></td>
                        <td align="center" width="100">次数</td>
                        <td align="center" width="100">油量(升)</td>
                        <td align="center" width="100">金额</td>
                    </tr>
                    <tr height="50">
                        <td align="center">本月加油</td>
                        <td align="center" width="100">50</td>
                        <td align="center" width="100">50</td>
                        <td align="center" width="100">50</td>
                    </tr>
                    <tr height="50">
                        <td align="center">上月加油</td>
                        <td align="center" width="100">20</td>
                        <td align="center" width="100">50</td>
                        <td align="center" width="100">50</td>
                    </tr>
                    <tr height="50">
                        <td align="center">本年加油</td>
                        <td align="center">15</td>
                        <td align="center" width="100">50</td>
                        <td align="center" width="100">50</td>
                    </tr>
                    <tr height="50">
                        <td align="center">累积加油</td>
                        <td align="center">85</td>
                        <td align="center" width="100">50</td>
                        <td align="center" width="100">50</td>
                    </tr>
                    <tr height="50">
                        <td align="center" colspan="4"><a href="javascript:void(0)">查看</a></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    </div>

    </div>
    </div>
</block>
<block name="bootstrap">
</block>