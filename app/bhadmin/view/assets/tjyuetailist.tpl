<extend name="public/common" />
<block name="main">
    <div class="pubmain" style="min-width:1800px;">
        <div class="panel-body">
            <div class="search">
                <form name="pubserch" method="get" action="{:url('assets/tjyuetailist')}">
                    单位：{:dropdown($droptype,$danwei,gtopic('adminuser',$danwei,'realname'),'danwei','realname')}
                    
                    &nbsp;时间：{:inputs(array('cname'=>'text','name'=>'year','add'=>'input-year','place'=>'年','val'=>$year,'width'=>'5','autocomplete'=>'off'))}年
                    {:inputs(array('cname'=>'text','name'=>'month','add'=>'input-month','place'=>'月','width'=>'5','val'=>$month,'autocomplete'=>'off'))}月
                    &nbsp;{:btn(array('vals'=>'查询','type'=>'submit','icon'=>'search','name'=>'searchdata','round'=>1,'scene'=>'primary'))}
                </form>
            </div>
            <div class="ui-block"></div>
            <table width="99%" border="0" cellspacing="0" cellpadding="0" align="center" class="{:tabstyle()}">
                <tr class="active">
                    <td width="100" align="center" valign="middle">车号</td>
                    <td width="100" align="center" valign="middle">公里数(公里)</td>
                    <td width="100" align="center" valign="middle">累积公里数(公里)</td>
                    <td width="100" align="center" valign="middle">油耗(升)</td>
                    <td width="100" align="center" valign="middle">油卡用油数量(升)</td>
                    <td width="100" align="center" valign="middle">油卡用油金额(元)</td>
                    <td width="100" align="center" valign="middle">赣通卡通行费(元)</td>
                    <td width="100" align="center" valign="middle">保养修理费(元)</td>
                    <td width="100" align="center" valign="middle">停车费(元)</td>
                    <td width="100" align="center" valign="middle">保险费(元)</td>
                    <td width="100" align="center" valign="middle">年检费(元)</td>
                    <td width="100" align="center" valign="middle">合计费用(元)</td>
                </tr>
            <volist name="datas" id="obj">
                <tr class="active">
                    <td width="100" align="center" valign="middle">{$obj.licensenum}</td>
                    <td width="100" align="center" valign="middle">{$obj['distance']['distance']==''? '--':$obj['distance']['distance']}</td>
                    <td width="100" align="center" valign="middle">{$obj['distance']['distance']==''? '--':$obj['distance']['distance']+$obj['alldistance']}</td>
                    <td width="100" align="center" valign="middle">{$obj['gas']['gasvolum'] ==''? '--':$obj['gas']['gasvolum']}</td>
                    <td width="100" align="center" valign="middle"></td>
                    <td width="100" align="center" valign="middle">{$obj['gas']['price'] ==''? '--':$obj['gas']['price']}</td>
                    <td width="100" align="center" valign="middle"></td>
                    <td width="100" align="center" valign="middle">{$obj['mtprice']['mtprice'] ==''? '--':$obj['mtprice']['mtprice']}</td>
                    <td width="100" align="center" valign="middle"></td>
                    <td width="100" align="center" valign="middle"></td>
                    <td width="100" align="center" valign="middle"></td>
                    <td width="100" align="center" valign="middle"></td>
                </tr>
            </volist>
            </table>
        </div>
    </div>
    <script type="text/javascript">
    $('.dropdown-menu>li>a').click(function() {
        console.log($(this).data('id'));
    })
    </script>
</block>