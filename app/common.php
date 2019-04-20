<?php
 
  //获取根目录
  function root()
  {
	  $root = $phpfile = '';
	  $iscgi = (0 === strpos(PHP_SAPI, 'cgi') || false !== strpos(PHP_SAPI, 'fcgi')) ? 1 : 0;
	  if ($iscgi) {
		  $temp = explode('.php', $_SERVER['PHP_SELF']);
		  $phpfile = rtrim(str_replace($_SERVER['HTTP_HOST'], '', $temp[0] . '.php'), '/');
	  } else {
		  $phpfile = rtrim($_SERVER['SCRIPT_NAME'], '/');
	  }
	  $root = rtrim(dirname($phpfile), '/');
	  $root = (($root == '/' || $root == '\\') ? '' : $root);
	  return $root;
  }
	 
  //返回图片
  function upic($pic, $default = '')
  {
	  $path = root() . '/' . config('upload_path') . 'images/';
	  $default = ($default != '') ? $path . 'default/' . $default . '.png' : $path . 'default/default.png';
	  if ($pic == '') return $default;
	  return (file_exists(config('upload_path') . 'images/' . $pic)) ? $path . $pic : $default;
  }
	 
  //写入日志
  function writelog($name = "", $content = "")
  {
	  if (!$content || !$name) return false;
	  if ( is_array($content) ) $content = json_encode($content);
	  if ( !is_string($content) ) return false;
	  $base = dirname(THINK_PATH) . '/runtime/';
	  if (!is_dir($base . 'logs')) mkdir($base . 'logs', 0777, true);
	  $dir = $base . 'logs' . DIRECTORY_SEPARATOR . $name;
	  if (!is_dir($dir)) {
		  if (!mkdir($dir, 0777, true)) return false;
	  }
	  $fname  = $dir . DIRECTORY_SEPARATOR . date("YmdH", time()) . '.log';
	  $msg    = "[".date('Y-m-d H:i:s')."] ";
	  $msg   .= $content;
	  $msg   .= "\r\n";
	  error_log($msg, 3, $fname);
  }
 
  //手机端判断
  function ismobile()
  {
	  $mobile = input('param.mobile', '');
	  if ($mobile != '') {
		  cookie(md5('ismobile'), 1);
		  return true;
	  }
	  if (cookie(md5('ismobile'))) return true;
	  $host = isset($_SERVER['HTTP_HOST']) ? trim($_SERVER['HTTP_HOST']) : '';
	  if ($host != '') {
		  $host = explode(".", $host);
		  if (in_array('m', $host)) return true;
	  }
	  $mobile = array();
	  static $blist = 'Mobile|iPhone|Android|WAP|NetFront|JAVA|OperasMini|UC|WindowssCE|Symbian|Series|webOS|SonyEricsson|Sony|BlackBerry|Cellphone|dopod|Nokia|samsung|PalmSource|Xphone|Xda|Smartphone|PIEPlus|MEIZU|MIDP|CLDC';
	  if (preg_match("/{$blist}/i", $_SERVER['HTTP_USER_AGENT'], $mobile)) {
		  return true;
	  } else {
		  if (preg_match('/(mozilla|chrome|safari|opera|m3gate|winwap|openwave)/i', $_SERVER['HTTP_USER_AGENT'])) return false;
	  }
  }
	
  //iscli
  function iscli()
  {
	  return (strpos(php_sapi_name(), 'cli') !== false) ? true : false;
  }
	 
  //微信端判断
  function isweixin()
  {
	  return (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) ? true : false;
  }
	 
  //支付宝判断
  function isalipay()
  {
	  return (strpos($_SERVER['HTTP_USER_AGENT'], 'AlipayClient') !== false) ? true : false;
  }
	 
  //微信配置
  function wxconf()
  {
	  if (!$wxdata = cache('system_weixin_config')) {
		  $wxdata = db('baseconfig')->field('wxappid,wxsecret,companyurl,wxname')->where('Id', 1)->find();
		  cache('system_weixin_config', $wxdata);
	  }
	  return $wxdata;
  }
	 
  //获取tdk
  function gettdk($id, $tables = '')
  {
	  if ($id && $tables != '') {
		  $data = db('title')->field('title,keyword,metades')->where(['tables' => $tables, 'tid' => $id])->find();
	  } else {
		  $data = db('title')->field('title,keyword,metades')->where(['Id' => $id])->find();
	  }
	  return ($data) ? $data : ['title' => '', 'keyword' => '', 'metades' => ''];
  }
	 
  //获取数据
  function getdata($table, $id, $filed = 'topic', $default = false, $cache = true)
  {
	  if ($table == '' || !$id || $filed == '') return $default;
	  if ($table == 'user' && $filed == 'amount') $cache = false;
	  if ($cache && cache($table . '_' . $id . '_' . $filed)) return cache($table . '_' . $id . '_' . $filed);
	  $data = db($table)->field($filed)->where('Id', $id)->find();
	  $return = ($data) ? $data[$filed] : $default;
	  if ($cache) cache($table . '_' . $id . '_' . $filed, $return, 3600);
	  return $return;
  }
	 
  //获取地址
  function gaddress($id, $default = '')
  {
	  if (!$id) return $default;
	  return getdata('district', $id, 'name', $default);
  }
	 
  //发送邮件
  function sendemail($conf = array())
  {
	  return model('tool')->sendemail($conf);
  }
	 
  //发送短信
  function sendmsg($phone, $msgtxt)
  {
	  if ($phone == '' || $msgtxt == '') return ['state'=>0,'msg'=>'信息不全，无法发送'];
	  if (!$pset = cache('system_msg_config')) {
		  $pset = db("baseconfig")->field('msguser,msgpass,msgsuff')->where('Id', 1)->find();
		  cache('system_msg_config', $pset);
	  }
	  //短信单个号码限制条数
	  $cachename = 'system_msgcount_'.$phone.'_'.date('Ymd');
	  $sendcount = cache('?'.$cachename) ? cache($cachename) : 0;
	  if ( $sendcount >= config('sendmsglimit') ) return ['state'=>0,'msg'=>'当日发送短信达到上限，发送失败'];
	  if (!$pset) return ['state'=>0,'msg'=>'短信配置设置不全，发送失败'];
	  if ($pset['msguser'] != '' && $pset['msgpass'] != '' && $pset['msgsuff'] != '') {
		  $ch = curl_init();
		  $msgtxt = $msgtxt . '【' . $pset['msgsuff'] . '】';
		  $data = ['account' => $pset['msguser'], 'password' => $pset['msgpass'], 'destmobile' => $phone, 'msgText' => $msgtxt, 'sendDateTime' => ''];
		  curl_setopt($ch, CURLOPT_HEADER, false);
		  curl_setopt($ch, CURLOPT_POST, true);
		  curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		  curl_setopt($ch, CURLOPT_URL, 'http://www.jianzhou.sh.cn/JianzhouSMSWSServer/http/sendBatchMessage');
		  $res = curl_exec($ch);
		  curl_close($ch);
		  $successid = ($res > 1) ? 1 : $res;
		  if ( $res > 1 ) cache($cachename,$sendcount+1);
		  if (config('isrecord_msg')) db('msghistory')->insert(['amount' => $phone, 'type' => 1, 'sysuser' => $pset['msguser'], 'msg' => $msgtxt, 'successid' => $successid, 'date' => time()]);
		  if ( $res ) {
		  	return ['state'=>1,'msg'=>''];
		  } else {
		  	return ['state'=>0,'msg'=>'发送失败'];
		  }
	  } else {
		  return ['state'=>0,'msg'=>'短信配置不全，发送失败'];
	  }
  }
	 
  //发送私信
  function letter($data = array())
  {
	  $uid   = isset($data['uid'])   ? $data['uid']   : 0;  //用户Id
	  $msg   = isset($data['msg'])   ? $data['msg']   : ''; //短信名称
	  $act   = isset($data['act'])   ? $data['act']   : 1;  //1私信 2物流信息 3交流信息
	  $topic = isset($data['topic']) ? $data['topic'] : '系统通知'; //信息标题
	  $pic   = isset($data['pic'])   ? $data['pic']   : 'default/msg/default.png';
	  $para  = isset($data['para'])  ? $data['para']  : ''; //附带参数
	  $link  = isset($data['link'])  ? $data['link']  : ''; //跳转链接
	  if ( $para != '' && is_array($para) ) $para = serialize($para);
	  if ( !$uid || $msg == '' ) return false;
	  if ( !is_string($para) )   return false;
	  $res = db('letter')->insert(['uid' => $uid, 'msg' => $msg, 'act' => $act, 'linkurl' => $link, 'topic' => $topic, 'pic' => $pic, 'parameter' => $para, 'ip' => request()->ip(), 'date' => date('Y-m-d H:i:s')]);
	  return ($res) ? true : false;
  }
	 
  //发送模板消息,小程序模板
  function tplmsg($data = array())
  {
	  return model('tool')->tplmsg($data);
  }
	 
  //发送微信信息
  function sendwxmsg($uid, $msg, $ispic = false)
  {
	  return model('tool')->sendwxmsg($uid, $msg, $ispic);
  }
	  
  //通知管理员
  function notice($data = array())
  {
	  $uid = isset($data['uid']) ? $data['uid'] : 0;  //用户Id
	  $msg = isset($data['msg']) ? $data['msg'] : ''; //短信名称
	  if ($msg == '') return false;
	  $res = db('sysnotice')->insert(['uid' => $uid, 'content' => $msg, 'ip' => request()->ip(), 'date' => date('Y-m-d H:i:s')]);
	  return ($res) ? true : false;
  }
	 
  //获取token
  function gettoken()
  {
	  $wxconf = wxconf();
	  $data = db('weixintoken')->where('type=1')->field('token,expire,time,Id,type')->order('Id DESC')->find();
	  if ($data) {
		  if ($data['time'] + $data['expire'] - 60 > time()) {
			  return ['token' => $data['token'], 'msg' => '', 'statue' => 1];
		  } else {
			  db('weixintoken')->where('Id', $data['Id'])->delete(); //删除过期
		  }
	  }
	  $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $wxconf['wxappid'] . "&secret=" . $wxconf['wxsecret'];
	  $key = curl_init();
	  curl_setopt($key, CURLOPT_URL, $url);
	  curl_setopt($key, CURLOPT_RETURNTRANSFER, 1);
	  curl_setopt($key, CURLOPT_SSL_VERIFYPEER, false);
	  curl_setopt($key, CURLOPT_SSL_VERIFYHOST, false);
	  $reslut = curl_exec($key);
	  $reslut = json_decode($reslut);
	  if (curl_errno($key)) return ['token' => '', 'msg' => curl_error($key), 'statue' => 0];
	  if (isset($reslut->errcode) && $reslut->errcode != '') return ['token' => '', 'msg' => $reslut->errmsg, 'statue' => 0];
	  $token = $reslut->access_token;
	  $expire = intval($reslut->expires_in);
	  db('weixintoken')->insert(['token' => $token, 'expire' => $expire, 'type' => 1, 'time' => time()]);
	  curl_close($key);
	  return ['token' => $token, 'msg' => '', 'statue' => 1];
  }
	 
  //获取ticket
  function getticket()
  {
	  $token = gettoken();
	  if (!$token['statue']) return $token;
	  $data = db('weixintoken')->where('type=2')->field('token,expire,time,Id,type')->order('Id DESC')->find();
	  if ($data) {
		  if ($data['time'] + $data['expire'] - 60 > time()) {
			  return ['token' => $data['token'], 'msg' => '', 'statue' => 1];
		  } else {
			  db('weixintoken')->where('Id', $data['Id'])->delete(); //删除过期
		  }
	  }
	  $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=" . $token['token'] . "&type=jsapi";
	  $key = curl_init();
	  curl_setopt($key, CURLOPT_URL, $url);
	  curl_setopt($key, CURLOPT_RETURNTRANSFER, 1);
	  curl_setopt($key, CURLOPT_SSL_VERIFYPEER, false); //不验证证书
	  curl_setopt($key, CURLOPT_SSL_VERIFYHOST, false); //不验证证书 
	  $reslut = curl_exec($key);
	  $reslut = json_decode($reslut);
	  if (curl_errno($key)) return ['token' => '', 'msg' => curl_error($key), 'statue' => 0];
	  if ($reslut->errcode != 0) return ['token' => '', 'msg' => $reslut->errmsg, 'statue' => 0];
	  $token = $reslut->ticket;
	  $expire = intval($reslut->expires_in);
	  db('weixintoken')->insert(['token' => $token, 'expire' => $expire, 'type' => 2, 'time' => time()]);
	  curl_close($key);
	  return ['token' => $token, 'msg' => $reslut->errmsg, 'statue' => 1];
  }
  
  function sharesign($url = '')
  {
	  if ($url == '') return false;
	  $time = time();
	  $noncestr = substr(md5($time), 0, 6);
	  $wxconf = wxconf();
	  $ticket = getticket();
	  if (!$ticket['statue']) return false;
	  $signature = 'jsapi_ticket=' . $ticket['token'] . '&noncestr=' . $noncestr . '&timestamp=' . $time . '&url=' . $url;
	  return ['noncestr' => $noncestr, 'signature' => sha1($signature), 'timestamp' => $time, 'appId' => $wxconf['wxappid']];
  }
	
  //获取品牌
  function getadv($id = 0, $ctag = 0, $cachetime = 600)
  {
	  if (!$id && !$ctag) return false;
	  $data = false;
	  if ($cachetime && cache('?adv_' . $id . '_' . $ctag)) return cache('adv_' . $id . '_' . $ctag);
	  if ($id) {
		  $data = db('advdata')->field('topic,pic,linkurl,color')->where("enabled=1 AND ctag={$id}")->order('ord ASC')->find();
	  } else {
		  $data = db('advdata')->field('topic,pic,linkurl,color')->where("enabled=1 AND ctag={$ctag}")->order('ord ASC')->select();
	  }
	  if ($cachetime && $data) cache('adv_' . $id . '_' . $ctag, $data);
	  return ($data) ? $data : false;
  }

  //获取单号
  function mksn($mark='')
  {
	  return $mark.date('YmdHis') . rand(10000, 99999);
  }
	 
  //获取配置
  function getconf($name = '', $conf = '')
  {
	  if ($name == '') return false;
	  $name = (strstr($name, '.php')) ? $name : $name . '/config.php';
	  $path = dirname(THINK_PATH) . '/conf/' . $name;
	  if (!is_file($path)) return false;
	  $hash = md5($name);
	  $config = include($path);
	  if (!$config || $config == '') return false;
	  if ($conf != '') return isset($config[$conf]) ? $config[$conf] : false;
	  return $config;
  }
	 
  //用户行为
  function ub($data = array())
  {
	  return model('cuser')->ub($data);
  }
	 
  //加密
  function bhmd5($str = '', $type = false, $key = '', $time = 0)
  {
	  if ( $str == '' ) return false;
	  if ( is_array($str) ) $str = json_encode($str);
	  if ( is_string($str) || is_int($str) ) {
	 	 $type = ($type) ? 'DECODE' : 'ENCODE';
	 	 return model('tool')->bhmd5($str, $type, $key, $time);
	  } else {
	  	 return false; 
	  }
  }
	 
  //接口调用权限
  function apitoken()
  {
	  $conf = getconf('app');
	  if (cache('?apiToken_' . $conf['web_appid'])) return cache('apiToken_' . $conf['web_appid']);
	  $str = 'appid=' . $conf['web_appid'] . '&secret=' . $conf['web_secret'];
	  $res = apiget('token/getToken', $str, true);
	  if ($res && $res['success']) {
		  $token = $res['token'];
		  cache('apiToken_' . $conf['web_appid'], $token, ((int)$res['expires_in'] - 500));
		  return $token;
	  } else {
		  return $conf['web_token'];
	  }
  }
	 
  //接口调用get
  function apiget($uri, $data = '', $istoken = false)
  {
	  if ($uri == '') return false;
	  $uri   = (getconf('app', 'api_url') ? : config('companyurl') . '/api/') . $uri;
	  $token = (!$istoken) ? apitoken() : '';
	  $uri   = ($data != '') ? $uri . '?' . $data . '&token=' . $token : $uri . '?token=' . $token;
	  return json_decode(file_get_contents($uri, true), true);
  }
	 
  //接口调用post
  function apipost($uri, $data = array())
  {
	  if ($uri == '') return false;
	  $abs = (getconf('app', 'api_url') ? : config('companyurl') . '/api/');
	  $uri = $abs . $uri;
	  $head[] = 'Accept: application/json';
	  $head[] = 'Content-Type: application/json;application/x-www-form-urlencoded';
	  $head[] = 'Token: ' . apitoken();
	  $opts   = [
		  CURLOPT_TIMEOUT        => 1200,
		  CURLOPT_RETURNTRANSFER => 1,
		  CURLOPT_CUSTOMREQUEST  => 'POST',
		  CURLOPT_SSL_VERIFYPEER => false,
		  CURLOPT_SSL_VERIFYHOST => false,
		  CURLOPT_HTTPHEADER     => $head,
		  CURLOPT_URL            => $uri,
		  CURLOPT_POSTFIELDS     => json_encode($data)
	  ];
	  $ch = curl_init();
	  curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
	  curl_setopt_array($ch, $opts);
	  $res   = curl_exec($ch);
	  $error = curl_error($ch);
	  curl_close($ch);
	  return ($res) ? json_decode($res, true) : ['success'=>0,'msg'=>'','retCode'=>40004];
  }
  
  //接口调用post
  function wxpost($uri, $data = array())
  {
	  if ($uri == '') return false;
	  $abs = '';
	  $uri = $abs . $uri;
	  $head[] = 'Accept: application/json';
	  $head[] = 'Content-Type: application/json;application/x-www-form-urlencoded';
	  $head[] = 'Token: ' . apitoken();
	  $opts   = [
		  CURLOPT_TIMEOUT        => 1200,
		  CURLOPT_RETURNTRANSFER => 1,
		  CURLOPT_CUSTOMREQUEST  => 'POST',
		  CURLOPT_SSL_VERIFYPEER => false,
		  CURLOPT_SSL_VERIFYHOST => false,
		  CURLOPT_HTTPHEADER     => $head,
		  CURLOPT_URL            => $uri,
		  CURLOPT_POSTFIELDS     => json_encode($data)
	  ];
	  $ch = curl_init();
	  curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
	  curl_setopt_array($ch, $opts);
	  $res   = curl_exec($ch);
	  $error = curl_error($ch);
	  curl_close($ch);
	  return ($res) ? $res : '';
  }
  
  //获取小程序 路由
  function xcxdomain()
  {
	  $file   = dirname(THINK_PATH) . '/conf/app/xcx.json';
	  $urlstr = ( file_exists($file) ) ? file_get_contents($file,true) : false;
	  $domain = [];
	  if ( $urlstr ) {
		  $urlobj = json_decode($urlstr,true);
		  if ( $urlstr ) {
			  if ( isset($urlobj['pages']) ) {
				  $pages = $urlobj['pages'];
				  $mark  = isset($urlobj['mark']) ? $urlobj['mark'] : false;
				  foreach( $pages as $pk=>$pv ) {
					  $markstr = ($mark && isset($mark[$pk])) ? $mark[$pk] : '';
					  $domain[$pk] = ['url'=>$pv,'mark'=>$markstr];
				  }
			  }
		  }
	  }
  	  return $domain;
  }
	
  //获取头像
  function getface($uid = 0)
  {
	  if ( !$uid )   return upic('default/face.png');
	  if ( !$udata = cache('user_face_'.$uid) ) {
	  	$udata = db('user')->field('userface,weixinface,qqface')->where('Id', $uid)->find();
		cache('user_face_'.$uid,$udata);
	  }
	  if ( !$udata )              return upic('default/face.png');
	  if ( $udata['userface'] )   return upic($udata['userface']);
	  if ( $udata['weixinface'] ) return $udata['weixinface'];
	  if ( $udata['qqface'] )     return $udata['qqface'];
	  return upic('default/face.png');
  }
  
  function dwurl($string)
  {
	  if (is_string($string) && request()->method() == 'GET') {
		  $string = str_replace('+', ' ', $string);
		  return $string;
	  } else {
		  return $string;
	  }
  }
  
  function decimalfun($val)
  {
   	  return sprintf('%.2f',$val);
  }
  