<extend name="public/common" />
<block name="main">
    <div class="pubmain" style="min-width:1200px;">
        <div class="panel-body">
            <div class="u-plus btn-group">
                {:btn(array('vals'=>'新建转移单','size'=>3,'scene'=>'primary','url'=>url('assets/tiaoboadd')))}
            </div>
            <form name="pubserch" method="get" action="{:url('assets/movelist')}">
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
                        <td width="100" align="center" valign="middle">调拨管理</td>
                        <td width="100" align="center" valign="middle">调拨单号</td>
                        <td width="100" align="center" valign="middle">调入单位</td>
                        <td width="100" align="center" valign="middle">调入部门</td>
                        <td width="100" align="center" valign="middle">接收人</td>
                        <td width="100" align="center" valign="middle">备注</td>
                        <td width="100" align="center" valign="middle">申请时间</td>
                        <td width="100" align="center" valign="middle">状态</td>
                        <td width="100" align="center" valign="middle">是否完成</td>
                        <td width="100" align="center" valign="middle">调拨时间</td>
                        <!-- <td width="140" align="center" valign="middle">操作</td> -->
                    </tr>
                    <tr class="maintr">
                        <td align="center" valign="middle" height="37">{:ckbox(1,$i-1)}</td>
                        <td align="center" valign="middle">调拨管理</td>
                        <td align="center" valign="middle">54534634</td>
                        <td align="center" valign="middle">调入单位</td>
                        <td align="center" valign="middle">调入部门</td>
                        <td align="center" valign="middle">接收人</td>
                        <td align="center" valign="middle">备注</td>
                        <td align="center" valign="middle">2019-04-16</td>
                        <td align="center" valign="middle">状态</td>
                        <td align="center" valign="middle">是</td>
                        <td align="center" valign="middle">2019-04-16</td>
                    </tr>
                    <tr class="maintr">
                        <td align="center" valign="middle" height="37">{:ckbox(1,$i-1)}</td>
                        <td align="center" valign="middle">调拨管理</td>
                        <td align="center" valign="middle">54534634</td>
                        <td align="center" valign="middle">调入单位</td>
                        <td align="center" valign="middle">调入部门</td>
                        <td align="center" valign="middle">接收人</td>
                        <td align="center" valign="middle">备注</td>
                        <td align="center" valign="middle">2019-04-16</td>
                        <td align="center" valign="middle">状态</td>
                        <td align="center" valign="middle">是</td>
                        <td align="center" valign="middle">2019-04-16</td>
                    </tr>
                    <tr class="maintr">
                        <td align="center" valign="middle" height="37">{:ckbox(1,$i-1)}</td>
                        <td align="center" valign="middle">调拨管理</td>
                        <td align="center" valign="middle">54534634</td>
                        <td align="center" valign="middle">调入单位</td>
                        <td align="center" valign="middle">调入部门</td>
                        <td align="center" valign="middle">接收人</td>
                        <td align="center" valign="middle">备注</td>
                        <td align="center" valign="middle">2019-04-16</td>
                        <td align="center" valign="middle">状态</td>
                        <td align="center" valign="middle">是</td>
                        <td align="center" valign="middle">2019-04-16</td>
                    </tr>
                    <tr class="maintr">
                        <td align="center" valign="middle" height="37">{:ckbox(1,$i-1)}</td>
                        <td align="center" valign="middle">调拨管理</td>
                        <td align="center" valign="middle">54534634</td>
                        <td align="center" valign="middle">调入单位</td>
                        <td align="center" valign="middle">调入部门</td>
                        <td align="center" valign="middle">接收人</td>
                        <td align="center" valign="middle">备注</td>
                        <td align="center" valign="middle">2019-04-16</td>
                        <td align="center" valign="middle">状态</td>
                        <td align="center" valign="middle">是</td>
                        <td align="center" valign="middle">2019-04-16</td>
                    </tr>
                    <tr class="maintr">
                        <td align="center" valign="middle" height="37">{:ckbox(1,$i-1)}</td>
                        <td align="center" valign="middle">调拨管理</td>
                        <td align="center" valign="middle">54534634</td>
                        <td align="center" valign="middle">调入单位</td>
                        <td align="center" valign="middle">调入部门</td>
                        <td align="center" valign="middle">接收人</td>
                        <td align="center" valign="middle">备注</td>
                        <td align="center" valign="middle">2019-04-16</td>
                        <td align="center" valign="middle">状态</td>
                        <td align="center" valign="middle">是</td>
                        <td align="center" valign="middle">2019-04-16</td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</block>