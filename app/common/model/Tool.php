<?php
namespace app\common\model;

use think\Model;
use think\Db;

class Tool
{
  
  //发送微信信息
	public function sendwxmsg($uid, $msg, $ispic = false)
	{
		if (!$uid || $msg == '') return false;
		$token = gettoken();
		if (!$token['statue']) return false;
		$token = $token['token'];
		$openid = getdata('user', $uid, 'weixinopenid');
		if (!$openid) return false;
		$data = "{\"touser\":\"" . $openid . "\",\"msgtype\":\"text\",\"text\":{\"content\":\"" . $msg . "\"}}";
		if ($ispic) {
			$pic = dirname(THINK_PATH) . '/uploads/images/' . $msg;
			if (!file_exists($pic)) return false;
			if (!$mediaid = cache('wx_pic_medid_' . md5($pic))) { //用过的素材就不要重复上传了
				if (class_exists('\CURLFile')) {
					$sdata = array('media' => new \CURLFile(realpath($pic)));
				} else {
					$sdata = array('media' => '@' . realpath($pic));
				}
				$url = "https://api.weixin.qq.com/cgi-bin/media/upload?access_token={$token}&type=image";
				$key = curl_init();
				curl_setopt($key, CURLOPT_URL, $url);
				curl_setopt($key, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($key, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($key, CURLOPT_POST, 1);
				curl_setopt($key, CURLOPT_POSTFIELDS, $sdata);
				curl_setopt($key, CURLOPT_RETURNTRANSFER, 1);
				$reslut = curl_exec($key);
				$res = json_decode($reslut);
				if (isset($res->errcode) && $res->errcode != '') return false;
				$mediaid = $res->media_id;
				cache('wx_pic_medid_' . md5($pic), $mediaid);
			}
			$data = "{\"touser\":\"" . $openid . "\",\"msgtype\":\"image\", \"image\":{\"media_id\": \"" . $mediaid . "\"}}";
		}
		$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$token}";
		$ckey = curl_init();
		curl_setopt($ckey, CURLOPT_URL, $url);
		curl_setopt($ckey, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ckey, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ckey, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ckey, CURLOPT_POST, 1);
		curl_setopt($ckey, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ckey, CURLOPT_RETURNTRANSFER, 1);
		$reslut = curl_exec($ckey);
		$res = json_decode($reslut);
		if ($ispic) $msg = '发送图片：' . $msg;
		$wxconf = wxconf();
		$sres = ($res->errcode == 0) ? 1 : $res->errcode;
		if (config('isrecord_msg')) Db::name('msghistory')->insert(['amount' => getdata('user', $uid, 'weixinname'), 'type' => 3, 'sysuser' => $wxconf['wxname'], 'msg' => $msg, 'successid' => $sres, 'date' => time()]);
		curl_close($ckey);
		return ($res->errcode == 0) ? true : false;
	}
 
  //微信模板消息
	public function tplmsg($data)
	{
		$openid = isset($data['openid']) ? $data['openid'] : '';
		$tempid = isset($data['tempid']) ? $data['tempid'] : '';
		$sdata = isset($data['sdata']) ? $data['sdata'] : '';
		$url = isset($data['url']) ? $data['url'] : '';
		$uid = isset($data['uid']) ? $data['uid'] : ''; //委托查找UID
		$tid = isset($data['tid']) ? $data['tid'] : ''; //委托查找模板ID
		$scene = isset($data['scene']) ? $data['scene'] : ''; //小程序
		$formid = isset($data['formid']) ? $data['formid'] : ''; //小程序发送
		if ($uid && $openid == '') $openid = getdata('user', $uid, 'weixinopenid');
		$tempArr = array(
			'PAY_SUCCESS' => 'AnM4bUmXALLjjKyvbi2b3QvEOlV4T2inzYC24xkplDg', //支付成功
			'ORDER_STATE' => 'o2HAGNDfi1z1TkJqhcRnkeYTt2UwVIlkpf1zKFUyqUo', //状态提醒
			'ORDER_REMIND' => 'JDWmZY67dofmCgYhGbKnRH4m8acRY-kvRA6B8nPU6p0', //下单通知提醒
		);
		$xcxTemp = array(); //小程序模板别表
		if ($tid && $tempid == '' && $scene == '') $tempid = isset($tempArr[$tid]) ? $tempArr[$tid] : '';
		if ($tid && $tempid == '' && $scene == 'mini') $tempid = isset($tempArr[$tid]) ? $xcxTemp[$tid] : '';
		if ($openid == '') return array('success' => 0, 'msg' => '微信用户未指定。');
		if ($tempid == '') return array('success' => 0, 'msg' => '模板ID为空。');
		if ($url == '') return array('success' => 0, 'msg' => '跳转URL为空。');
		if ($sdata == '') return array('success' => 0, 'msg' => '模板内容为空。');
		if ($scene == 'mini' && $formid == '') return array('success' => 0, 'msg' => 'formid不能为空。');
		foreach ($sdata as $skey => $sval) {
			$sdata[$skey] = array('value' => $sval);
		}
		$wxconf = wxconf();
		$token = gettoken();
		if ($token['statue'] == 0) {
			return array('success' => 0, 'msg' => $token['msg']);
		}
		$url = ($scene == '') ? $wxconf['companyurl'] . $url . '/openid/' . $openid : $url;
		$wxdata = array('touser' => $openid, 'template_id' => $tempid, 'url' => $url, 'data' => $sdata);
		$token = $token['token'];
		$wxdata = urldecode(json_encode($wxdata));
		$wxurl = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $token;
		if ($scene == 'mini') {
			$wxurl = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=' . $token;
			$wxdata = array('touser' => $openid, 'form_id' => $formid, 'template_id' => $tempid, 'page' => $url, 'data' => $sdata);
		}
		if ($wxdata != '' && $token != '') {
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $wxurl);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $wxdata);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$result = json_decode(curl_exec($curl));
			if (curl_errno($curl)) return array('success' => 0, 'msg' => curl_error($curl));
			curl_close($curl);
			if ($result->errmsg == 'ok') {
				$res = array('success' => 1, 'msg' => '');
			} else {
				$res = array('success' => 0, 'msg' => $result->errmsg);
			}
			$success = ($res['success']) ? 1 : $result->errmsg;
			$msg = '模板ID：' . $tempid . '内容：' . $wxdata;
			$uname = ($uid) ? getdata('user', $uid, 'weixinname') : $openid;
			if (config('isrecord_msg')) Db::name('msghistory')->insert(['amount' => $uname, 'type' => 5, 'sysuser' => $wxconf['wxname'], 'msg' => $msg, 'successid' => $success, 'date' => time()]);
		}
	}
 
  //发送邮件
	public function sendemail($conf = array())
	{
		$email = isset($conf['email']) ? $conf['email'] : ''; //接受邮件的邮箱
		$title = isset($conf['title']) ? $conf['title'] : ''; //邮件标题
		$msg = isset($conf['msg']) ? $conf['msg'] : ''; //邮件内容
		$file = isset($conf['file']) ? $conf['file'] : ''; //附件名称 
		$fname = isset($conf['fname']) ? $conf['fname'] : ''; //附件名称 
		$cname = isset($conf['cname']) ? $conf['cname'] : config('companyname');//来源
		$debug = isset($conf['debug']) ? $conf['debug'] : false; //debug
		$ssl = isset($conf['ssl']) ? $conf['ssl'] : false; //ssl
		if ($file != '') $file = dirname(THINK_PATH) . '/uploads/' . $file;
		if ($file != '' && !file_exists($file)) return false;
		if ($email == '' || $msg == '') return false;
		if (!$mset = cache('system_mail_config')) {
			$mset = Db::name("systemconfig")->field('mailsmtp,mailport,mailname,mailpass')->where('Id', 1)->find();
			cache('system_mail_config', $mset);
		}
		if (!$mset) return false;
		if ($mset['mailsmtp'] == '' || $mset['mailport'] == '' || $mset['mailname'] == '' || $mset['mailpass'] == '') return false;
		Vendor('PHPMailer.PHPMailerAutoload');
		$mail = new \PHPMailer();
		$mail->IsSMTP();
		$mail->Host = $mset['mailsmtp'];
		$mail->SMTPAuth = true;
		$mail->Username = $mset['mailname'];
		$mail->Password = bhmd5($mset['mailpass'], true); //需要解密
		$mail->From = $mset['mailname'];
		$mail->FromName = $cname;
		$mail->WordWrap = 50;
		if ($ssl) $mail->SMTPSecure = 'ssl';
		$mail->Port = $mset['mailport'];
		$mail->CharSet = 'utf-8';
		$mail->Subject = $title;
		$mail->Body = $msg;
		$mail->AltBody = '';
		$mail->IsHTML(true);
		if ($file != '') $mail->AddAttachment($file, $fname);
		$mail->AddAddress($email, "");
		$res = $mail->Send();
		if (config('isrecord_msg')) Db::name('msghistory')->insert(['amount' => $email, 'type' => 2, 'sysuser' => $mset['mailname'], 'msg' => $msg, 'successid' => ($res ? 1 : 0), 'date' => time()]);
		if ($debug) {
			dump('mailerror', $mail->ErrorInfo);
			dump('maildebug', $mail);
		}
		return $res ? true : false;
	}
 
  //快递查询 查询结果缓存 当返回state =1 时候返回 data ['time','context']
	public function kuaidi($exno = '', $id = 0, $act = '')
	{
		if ($exno == '' || !$id) return ['state' => 0, 'msg' => '快递单号或者快递公司不存在'];
		$code = getdata('delivery', $id, 'code');
		if ($code == '') return ['state' => 0, 'msg' => '快递公司不存在'];
		$conf = getconf('kuaidi');
		$cache = $conf['cache']; //缓存
		if ($cache && cache('kuaididata_' . $exno . '_' . $id) != '') return cache('kuaididata_' . $exno . '_' . $id);
		if ($act == '') $act = $conf['drive']; //驱动
		if ($act == 'kdpt') { //http://q.kdpt.net/  友情提供
			$kdid = $conf['kdpt_key'];
			$url = "http://q.kdpt.net/api?id={$kdid}&com={$code}&nu={$exno}&show=json&order=desc"; // asc
			$data = json_decode(file_get_contents($url, true), true);
			if ($data['message'] == 'ok') {
				$cdata = ['state' => 1, 'data' => $data['data'], 'msg' => '查询成功'];
			} else {
				$cdata = ['state' => 0, 'msg' => $data['message']];
			}
			if ($cache) cache('kuaididata_' . $exno . '_' . $id, $cdata, $cache);
			return $cdata;
		}
		if ($act == 'bird') { //快递鸟
			$kdid = $conf['bird_id'];
			$kdkey = $conf['bird_key'];;
			$rdata = "{'OrderCode':'','ShipperCode':'$code','LogisticCode':'$exno'}";
			$sdate = ['EBusinessID' => $kdid, 'RequestType' => '1002', 'RequestData' => urlencode($rdata), ''];
			$sdate['DataSign'] = urlencode(base64_encode(md5($rdata . $kdkey)));
			$url = 'http://api.kdniao.cc/Ebusiness/EbusinessOrderHandle.aspx';
			$temps = [];
			foreach ($sdate as $key => $value) {
				$temps[] = sprintf('%s=%s', $key, $value);
			}
			$post_data = implode('&', $temps);
			$url_info = parse_url($url);
			if (empty($url_info['port'])) $url_info['port'] = 80;
			$head = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
			$head .= "Host:" . $url_info['host'] . "\r\n";
			$head .= "Content-Type:application/x-www-form-urlencoded\r\n";
			$head .= "Content-Length:" . strlen($post_data) . "\r\n";
			$head .= "Connection:close\r\n\r\n";
			$head .= $post_data;
			$fd = fsockopen($url_info['host'], $url_info['port']);
			fwrite($fd, $head);
			$gets = "";
			$headerFlag = true;
			while (!feof($fd)) {
				if (($header = @fgets($fd)) && ($header == "\r\n" || $header == "\n")) {
					break;
				}
			}
			while (!feof($fd)) {
				$gets .= fread($fd, 128);
			}
			fclose($fd);
			$data = json_decode($gets, true);
			if ($data['Success']) {
				$rd = $data['Traces'];
				$nd = [];
				if ($rd) {
					foreach ($rd as $rk => $rv) {
						$nd[$rk]['time'] = $rv['AcceptTime'];
						$nd[$rk]['context'] = $rv['AcceptStation'];
					}
				}
				$cdata = ['state' => 1, 'msg' => '查询成功', 'data' => $this->Array_sort($nd, 'time')];
			} else {
				$cdata = ['state' => 0, 'msg' => $data['Reason']];
			}
			if ($cache) cache('kuaididata_' . $exno . '_' . $id, $cdata, $cache);
			return $cdata;
		}
		if ($act == 'kd100') {
			$kdid = $conf['kd100_key'];
			$url = "http://api.kuaidi100.com/api?id={$kdid}&com={$code}&nu={$exno}&show=0&muti=1&order=desc"; // asc
			$data = json_decode(file_get_contents($url, true), true);
			if ($data['message'] == 'ok') {
				$cdata = ['state' => 1, 'data' => $data['data'], 'msg' => '查询成功'];
			} else {
				$cdata = ['state' => 0, 'msg' => $data['message']];
			}
			if ($cache) cache('kuaididata_' . $exno . '_' . $id, $cdata, $cache);
			return $cdata;
		}
	}
 
  //排序
	public function Array_sort($arr, $keys, $type = 'desc')
	{
		$keysvalue = $new_array = array();
		if (count($arr) == 0) return false;
		foreach ($arr as $k => $v) {
			$keysvalue[$k] = $v[$keys];
		}
		if ($type == 'asc') {
			asort($keysvalue);
		} else {
			arsort($keysvalue);
		}
		reset($keysvalue);
		foreach ($keysvalue as $k => $v) {
			$new_array[$k] = $arr[$k];
		}
		return array_merge($new_array);
	}
 
  //下载到本地
	public function downpic($url = '', $folder = 'products')
	{
		if ($url == '') return false;
		$folder = ($folder != '') ? $folder : date('Ymd');
		$path = dirname(THINK_PATH) . '/uploads/images/' . $folder;
		if (!is_dir($path)) @mkdir($path, 0777, true);
		$file = substr(md5(substr(md5(time() . rand(0, 9999999)), 5, 15)), 8, 15) . '.jpg';
		$savepath = $path . '/' . $file;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_NOBODY, 0);    //只取body头
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$package = curl_exec($ch);
		$httpinfo = curl_getinfo($ch);
		curl_close($ch);
		if ($httpinfo['http_code'] == 200) {
			$local_file = fopen($savepath, 'w');
			if (false !== $local_file) {
				if (false !== fwrite($local_file, $package)) {
					fclose($local_file);
				}
			}
			if (file_exists($savepath)) {
				return $folder . '/' . $file;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
 
  //加密,解密函数 
	public function bhmd5($string, $operation = 'DECODE', $key = '', $expiry = 0)
	{
		$ckey_length = 4;
		$key = ($key == '') ? md5(config('md5key')) : md5($key);
		$keya = md5(substr($key, 0, 16));
		$keyb = md5(substr($key, 16, 16));
		if ($operation != 'ENCODE') {
			$string = str_replace('*-*', '+', $string);
			$string = str_replace('*_*', '/', $string);
		}

		$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';
		$cryptkey = $keya . md5($keya . $keyc);
		$key_length = strlen($cryptkey);
		$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
		$string_length = strlen($string);
		$result = '';
		$box = range(0, 255);
		$rndkey = array();
		for ($i = 0; $i <= 255; $i++) {
			$rndkey[$i] = ord($cryptkey[$i % $key_length]);
		}
		for ($j = $i = 0; $i < 256; $i++) {
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}
		for ($a = $j = $i = 0; $i < $string_length; $i++) {
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}
		if ($operation == 'DECODE') {
			if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
				return substr($result, 26);
			} else {
				return '';
			}
		} else {
			$string = $keyc . str_replace('=', '', base64_encode($result));
			$string = str_replace('+', '*-*', $string);
			$string = str_replace('/', '*_*', $string);
			return $string;
		}
	} 
 
  //xml解析
	public function toxml($arr)
	{
		$xml = "<xml>";
		foreach ($arr as $key => $val) {
			if (is_numeric($val)) {
				$xml .= "<" . $key . ">" . $val . "</" . $key . ">";
			} else {
				$xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
			}
		}
		$xml .= "</xml>";
		return $xml;
	}
 
  //xml转数组
	public function dwxml($xml)
	{
		$doc = new \DOMDocument();
		$doc->loadXML($xml);
		return $this->xmltoarr($doc->documentElement);
	}
 
  //转Arr
	private function xmltoarr($node)
	{
		$output = array();
		switch ($node->nodeType) {
			case XML_CDATA_SECTION_NODE:
			case XML_TEXT_NODE:
				$output = trim($node->textContent);
				break;
			case XML_ELEMENT_NODE:
				for ($i = 0, $m = $node->childNodes->length; $i < $m; $i++) {
					$child = $node->childNodes->item($i);
					$v = $this->xmltoarr($child);
					if (isset($child->tagName)) {
						$t = $child->tagName;
						if (!isset($output[$t])) {
							$output[$t] = array();
						}
						$output[$t][] = $v;
					} elseif ($v) {
						$output = (string)$v;
					}
				}
				if (is_array($output)) {
					if ($node->attributes->length) {
						$a = array();
						foreach ($node->attributes as $attrName => $attrNode) {
							$a[$attrName] = (string)$attrNode->value;
						}
						$output['@attributes'] = $a;
					}
					foreach ($output as $t => $v) {
						if (is_array($v) && count($v) == 1 && $t != '@attributes') {
							$output[$t] = $v[0];
						}
					}
				}
				break;
		}
		return $output;
	}
  
  //数据拷贝
	public function bhcopy($conf = array())
	{
		$tables = isset($conf['tables']) ? $conf['tables'] : '';
		$where = isset($conf['where']) ? $conf['where'] : '';
		$limit = isset($conf['limit']) ? $conf['limit'] : 1;
		if ($tables == '' || $where == '') return ['state' => 0, 'msg' => '未查询到可复制数据'];
		$count = Db::name($tables)->where($where)->count();
		if (!$count || $count == 0) return ['state' => 0, 'msg' => '可复制数据为0'];
		$tb = config('database.prefix') . $tables;
		if (!$fobj = cache('table_' . $tb)) {
			$fobj = db()->query("SHOW COLUMNS FROM `{$tb}`");
			cache('table_' . $tb, $fobj);
		}
		if (!$fobj) return ['state' => 0, 'msg' => '未找到有效的数据'];
		$fiels = '';
		foreach ($fobj as $fk => $fv) {
			$fiels .= ($fv['Extra'] != 'auto_increment') ? '`' . $fv['Field'] . '`,' : '';
		}
		$fiels = trim($fiels, ',');
		if ($fiels == '') return ['state' => 0, 'msg' => '未找到有效的数据结构'];
		$data = Db::name($tables)->field($fiels)->where($where)->limit($limit)->select();
		if (!$data) return ['state' => 0, 'msg' => '条件下无可复制内容'];
		$res = Db::name($tables)->insertAll($data);
		return ['state' => 1, 'msg' => '', 'count' => $res];
	}
  
  //缓存 缓存名称 缓存内容 组别 缓存时间
	public function bhcache($name, $data = '', $groupid = '', $time = 0)
	{
		if ($data == '') return cache($name);
		if ($groupid != '') {
			$groupname = 'bh_' . $groupid;
			$group = cache('?' . $groupname) ? cache($groupname) : [];
		}
		if ($data == null || $data == 'null') {
			cache($name, null);
			if ($groupid != '') { //删除同组
				if (count($group) > 0) {
					cache($groupname, null);
					foreach ($group as $gkey => $gval) {
						cache($gkey, null);
					}
				}
			}
			return true;
		}
		if ($groupid != '') {
			if (!isset($group[$name])) {
				$group[$name] = 1;
			}
			cache($groupname, $group);
		}
		cache($name, $data, $time);
		return true;
	}

  //标签
	public function bhtag($conf = array())
	{
		$tables = isset($conf['tables']) ? $conf['tables'] : '';
		$id = isset($conf['id']) ? $conf['id'] : 0;
		$bhtag = isset($conf['tag']) ? $conf['tag'] : '';
		$isdel = isset($conf['isdel']) ? $conf['isdel'] : false;//是否删除 ,方法 ['tag'=>'字段1,字段2','tables'=>'user','id'=>1,'isdel'=>1]
		$isget = isset($conf['isget']) ? $conf['isget'] : false;//是否获取,方法 ['tables'=>'user','id'=>1,'isget'=>1]
		if ($bhtag == '' && !$isget) return false;
		if (!is_array($bhtag) && !$isget) $bhtag = explode(",", $bhtag);
		if ($id && $tables != '') {
			$data = Db::name($tables)->field('bhtag')->where('Id', $id)->find();
			if ($isget) {
				return ($data && $data['bhtag']) ? json_decode($data['bhtag'], true) : '';
			}
			if ($data) {
				$tags = ($data['bhtag'] != '') ? json_decode($data['bhtag'], true) : '';
				if ($isdel && $tags != '') {
					foreach ($bhtag as $tv) {
						if (isset($tags[$tv])) unset($tags[$tv]);
					}
					return $tags;
				}
				if ($tags != '') {
					foreach ($tags as $key => $val) {
						if (isset($bhtag[$key])) {
							$tags[$key] = $bhtag[$key];
							unset($bhtag[$key]);
						}
					}
					$bhtag = array_merge($tags, $bhtag);
					return json_encode($bhtag);
				}
			}
		}
		return json_encode($bhtag);
	}

	//处理合成图片
	public function bhps($background, $filename = "", $config = array(),$imageDefault=array(), $textDefault=array())
	{
		if (empty($filename)) header("content-type: image/png");
		if (empty($imageDefault)) $imageDefault = ['left'=>0,'top'=>0,'right'=>0,'bottom'=>0,'stream'=>false,'width'=>100,'height'=>100,'opacity'=>100];
		if (empty($textDefault))  $textDefault  = ['text'=>'','left'=>0,'top'=>0,'fontSize'=>24,'fontColor'=>'0,0,0','iscenter'=>0,'angle'=>0,'fontPath'=> 'fonts/mzd.ttf'];
		$backgroundInfo   = getimagesize($background);
		$ext              = image_type_to_extension($backgroundInfo[2], false);
		$backgroundFun    = 'imagecreatefrom' . $ext;
		$background       = $backgroundFun($background);
		$backgroundWidth  = imagesx($background);  //背景宽度
		$backgroundHeight = imagesy($background);  //背景高度
		$imageRes         = imageCreatetruecolor($backgroundWidth, $backgroundHeight);
		$imgwidth         = isset($backgroundInfo[0]) ? $backgroundInfo[0] : 0;
		$color            = imagecolorallocate($imageRes, 0, 0, 0);
		imagefill($imageRes, 0, 0, $color);
		imagecopyresampled($imageRes, $background, 0, 0, 0, 0, imagesx($background), imagesy($background), imagesx($background), imagesy($background));
		if (!empty($config['image'])) {
			foreach ($config['image'] as $key => $val) {
				if ( $val['url'] !='' ) {
					$val = array_merge($imageDefault, $val);
					$info = getimagesize($val['url']);
					$function = 'imagecreatefrom' . image_type_to_extension($info[2], false);
					if ( $val['stream'] ) {   
						//如果传的是字符串图像流
						$info = getimagesizefromstring($val['url']);
						$function = 'imagecreatefromstring';
					}
					$res = $function($val['url']);
					$resWidth = $info[0];
					$resHeight = $info[1];
					//建立画板 ，缩放图片至指定尺寸
					$canvas = imagecreatetruecolor($val['width'], $val['height']);
					imagefill($canvas, 0, 0, $color);
					//关键函数，参数（目标资源，源，目标资源的开始坐标x,y, 源资源的开始坐标x,y,目标资源的宽高w,h,源资源的宽高w,h）
					imagecopyresampled($canvas, $res, 0, 0, 0, 0, $val['width'], $val['height'], $resWidth, $resHeight);
					$val['left'] = $val['left'] < 0 ? $backgroundWidth - abs($val['left']) - $val['width'] : $val['left'];
					$val['top'] = $val['top'] < 0 ? $backgroundHeight - abs($val['top']) - $val['height'] : $val['top'];
					//放置图像
					@imagecopymerge($imageRes, $canvas, $val['left'], $val['top'], $val['right'], $val['bottom'], $val['width'], $val['height'], $val['opacity']);//左，上，右，下，宽度，高度，透明度
				}
			}
		}
    	//处理文字
		if (!empty($config['text'])) {
			foreach ($config['text'] as $key => $val) {
				$val = array_merge($textDefault, $val);
				list($R, $G, $B) = explode(',', $val['fontColor']);
				$fontColor   = imagecolorallocate($imageRes, $R, $G, $B);
				$val['left'] = $val['left'] < 0 ? $backgroundWidth - abs($val['left']) : $val['left'];
				$val['top']  = $val['top'] < 0 ? $backgroundHeight - abs($val['top']) : $val['top'];
				$fontpath    = ROOT_PATH.'/public/'.$val['fontPath'];
				$left        = $val['left'];
				if ( $val['iscenter'] ) {
					$nameobj = imagettfbbox( $val['fontSize'], 0, $fontpath, $val['text']);
					$left    = ceil(($imgwidth - $nameobj[2]) / 2);
				}
				@imagettftext($imageRes, $val['fontSize'], $val['angle'], $val['left'], $val['top'], $fontColor, $fontpath, $val['text']);
			}
		}
		if (!empty($filename)) {
			$res = imagejpeg($imageRes, $filename, 90);
			imagedestroy($imageRes);
		} else {
			imagejpeg($imageRes);
			imagedestroy($imageRes);
		}
	}
  
    //生成圆角图片
  	public function bhreduis($imgpath,$outpath,$radius=200) {
		$info    = getimagesize($imgpath);
		if ( $info['mime'] == 'image/jpeg' ) {
			$src_img = imagecreatefromjpeg($imgpath);
		} else {
			$src_img = imagecreatefrompng($imgpath);
		}
        $wh = getimagesize($imgpath);
        $w  = $wh[0];
        $h  = $wh[1];
        // $radius = $radius == 0 ? (min($w, $h) / 2) : $radius;
        $img = imagecreatetruecolor($w, $h);
        //这一句一定要有
        imagesavealpha($img, true);
        //拾取一个完全透明的颜色,最后一个参数127为全透明
        $bg = imagecolorallocatealpha($img, 255, 255, 255, 127);
        imagefill($img, 0, 0, $bg);
        $r = $radius; //圆 角半径
        for ($x = 0; $x < $w; $x++) {
            for ($y = 0; $y < $h; $y++) {
                $rgbColor = imagecolorat($src_img, $x, $y);
                if (($x >= $radius && $x <= ($w - $radius)) || ($y >= $radius && $y <= ($h - $radius))) {
                    //不在四角的范围内,直接画
                    imagesetpixel($img, $x, $y, $rgbColor);
                } else {
                    //在四角的范围内选择画
                    //上左
                    $y_x = $r; //圆心X坐标
                    $y_y = $r; //圆心Y坐标
                    if (((($x - $y_x) * ($x - $y_x) + ($y - $y_y) * ($y - $y_y)) <= ($r * $r))) {
                        imagesetpixel($img, $x, $y, $rgbColor);
                    }
                    //上右
                    $y_x = $w - $r; //圆心X坐标
                    $y_y = $r; //圆心Y坐标
                    if (((($x - $y_x) * ($x - $y_x) + ($y - $y_y) * ($y - $y_y)) <= ($r * $r))) {
                        imagesetpixel($img, $x, $y, $rgbColor);
                    }
                    //下左
                    $y_x = $r; //圆心X坐标
                    $y_y = $h - $r; //圆心Y坐标
                    if (((($x - $y_x) * ($x - $y_x) + ($y - $y_y) * ($y - $y_y)) <= ($r * $r))) {
                        imagesetpixel($img, $x, $y, $rgbColor);
                    }
                    //下右
                    $y_x = $w - $r; //圆心X坐标
                    $y_y = $h - $r; //圆心Y坐标
                    if (((($x - $y_x) * ($x - $y_x) + ($y - $y_y) * ($y - $y_y)) <= ($r * $r))) {
                        imagesetpixel($img, $x, $y, $rgbColor);
                    }
                }
            }
        }
        imagepng($img,$outpath);
		imagedestroy($img);
    }

  	//生成二维码
	public function qrMk($linkurl, $savepath, $logo = '', $lev = 'H')
	{
		vendor("phpqrcode.phpqrcode");
		$qrobj = new \QRcode();
		$qrobj->png($linkurl, $savepath, $lev, 10, 2);
		$QR = imagecreatefromstring(file_get_contents($savepath));// 纠错级别：L、M、Q、H
		if ($logo != '') {
			$QR_width = imagesx($QR);
			$QR_height = imagesy($QR);
			$corner = file_get_contents(config('upload_path') . 'images/default/corner.png');
			$corner = imagecreatefromstring($corner);
			$corner_width = imagesx($corner);
			$corner_height = imagesy($corner);
			$corner_qr_width = ($QR_width / 5);
			$from_width = ($QR_width - $corner_qr_width) / 2;
			$scale = $corner_width / $corner_qr_width;
			$corner_qr_height = $corner_height / $scale;
			imagecopyresampled($QR, $corner, $from_width, $from_width, 0, 0, $corner_qr_width, $corner_qr_height, $corner_width, $corner_height);
			$logo = imagecreatefromstring(file_get_contents($logo));
			$QR_width = imagesx($QR);
			$QR_height = imagesy($QR);
			$logo_width = imagesx($logo);
			$logo_height = imagesy($logo);
			$logo_qr_width = $QR_width / 5 - 6;
			$scale = $logo_width / $logo_qr_width;
			$logo_qr_height = $logo_height / $scale;
			$from_width = ($QR_width - $logo_qr_width) / 2;
			imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
			imagepng($QR, $savepath);
		}
	}


}
