<?php
return [
    'app_debug'        => true,                                                       // 应用调试模式
    'app_trace'        => true,                                                       // 应用Trace
    'default_filter'   => 'addslashes,htmlspecialchars,trim',                   // 默认全局过滤方法 用逗号分隔多个
    'default_module'   => 'doc',                                                     // 默认模块名
    'url_html_suffix'  => 'html',                                                     // URL伪静态后缀
	'auto_bind_module' => false,                                                      // 入口自动绑定模块
    //'exception_tmpl'   => dirname(THINK_PATH).'/app/home/view/common/error.tpl',      // 异常页面的模板文件
	'template'         => ['view_suffix'=>'tpl','taglib_begin'=>'<','taglib_end'=>'>'],
	'upload_path'      => './uploads/',
	'illegalword_on'   => true,                                                       //是否开启敏感词匹配 vendor\topthink\think-illegalword
	'notbacktable'     => 'online',                                                   //不需要备份的数据表 多个用 , 隔开
	'backuptime'       => 3,                                                          //自动备份时间 单位天
	'sendmsglimit'     => 5,                                                          //每天短信发送最大值
	'companyname'      => '百恒网络',                                                   //公司名称
	'md5key'           => '.v2oa.',                                                  //加密的钥匙
	'companyurl'       => 'http://192.168.0.73:81/oa-device',
	'isrecord_msg'     => true,                                                        //是否记录邮件短信微信极光模板消息的发送记录
	'url_route_on'     => true,                                                        //是否开启路由
	'sql_opt'          => true,                                                        //数据库优化
	'is_time_limit'    => true,                                                        //是否开启
	'token_refresh'    => false,                                                       //刷新页面生成新的token
	'token_name'       => 'bh_token_name',                                             //tokenname
	'couponmode'       => 1,                                                           // 1.过期时间为设置时间 2.过期未领取多少天过期                                                          
	'log'              => [
	    'type'         => 'file',
        'apart_level'  => ['error'],
	],
	'normal_picpath'   => ['default', 'products'], //不需要检测文件夹内为冗余图片
];