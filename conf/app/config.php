<?php
return [
     'j_appkey'       => '', //极光 AppKey
     'j_mastersecret' => '', //极光 Master Secre
	 'j_apn'          => true,                       //false开发环境，true生产环境。
	 'j_topic'        => '百恒网络',                   //推送默认标题
	 'api_base'       => 'bhoa',                     //默认apitoken前缀
	 'api_record'     => true,                       //记录api访问记录
	 'api_url'        => '',                         //接口地址
	 'api_ckdomain'   => false,                      //开启域名验证
	 'api_urlrule'    => '',                         //域名下可以调用接口
	 'web_token'      => '',                         //默认token
	 'web_appid'      => '001003',                   //web专用调用id
	 'web_secret'     => 'e08392bb89dedb8ed6fb298f8e729c15', //web专用调用secret
];