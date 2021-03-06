<?php
return [
    'type'        => 'mysql',       // 数据库类型
    'hostname'    => '127.0.0.1',   // 服务器地址
    'database'    => 'cheliang',   // 数据库名
    'username'    => 'root',        // 用户名
    'password'    => '123456',            // 密码
    'hostport'    => '3306',        // 端口
    'charset'     => 'utf8',        // 数据库编码默认采用utf8
    'prefix'      => 'bh_',         // 数据库表前缀
	'debug'       => true,          // bebug 开启将记录log
	'sql_explain' => false,          //SQL性能分析
];