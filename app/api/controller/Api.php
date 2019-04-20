<?php
namespace app\api\controller;

use think\Controller;
use think\Db;
use think\Request;

class Api extends Controller
{

	protected $apitype, $absurl, $isrecord, $apitoken, $apibasename, $slighttime, $method, $apimode , $uid, $pid ,$cid ,$inviteuid;
	public function _initialize()
	{
		header('Access-Control-Allow-Origin :*');
		header('Content-type: text/html; charset=utf-8');
		$apitype   = '';
		$token     = input('token', '');
		$version   = input('version','');
		$sleep 	   = input('sleep', 0, 'intval');
		$uid       = input('post.uid','');
		$inviteuid = input('post.inviteuid','0','intval');
		if ($token == '') $token     = $this->getHeader('token');
		if ($version=='') $version   = $this->getHeader('version');
		if ($uid == '')   $uid       = $this->getHeader('uid');
		$appconf  = getconf('app');
		$apiname  = $appconf['api_base'];
		$appidArr = ['ios' => md5($apiname . '-ios'), 'android' => md5($apiname . '-android'), 'web' => md5($apiname . '-web'), 'xcx' => md5($apiname . '-xcx')];
		if ($token == '') $this->ApiReturn('', 0, '请求TOKEN为空', '40005');
		foreach ($appidArr as $akey => $aval) {
			if ($token == $aval) {
				$apitype = $akey;
				break;
			}
		}
		if ($apitype == '') {
			$ckres = $this->ckToken($token);
			$apitype = isset($ckres['type']) ? $ckres['type'] : $apitype;
			if ($apitype == '') $this->ApiReturn('', 0, '无效的请求TOKEN', '40005');
		}
		if ( $sleep > 10 ) $sleep = 10;
		if ( $sleep ) sleep($sleep);
		$url = request()->url(true);
		$this->absurl     = config('companyurl');
		$this->apitype    = $apitype;
		$this->isrecord   = $appconf['api_record'];
		$this->apitoken   = $token;
		$this->slighttime = 15;
		$this->uid        = $this->ckuid($uid);
		$this->ApiRecord($token, $apitype, $url);
	}

	//是否手机认证
	protected function isauth($uid = 0)
	{
		if ( !$uid ) return false;
		$ud = Db::name('user')->field('Id,phone')->where('Id', $uid)->cache('api_auth_'.$uid)->find();
		if ( !$ud ) return false;
		return ($ud['phone']!='') ? true : false;
	}
 
    //检测用户
	protected function ckuid($uid = '')
	{
		if ($uid == '') return false;
		if ($this->apitype != 'web') {
			$uid = bhmd5($uid, true);
			if (!$uid) return false;
		}
		$ud = Db::name('user')->field('Id,islogin')->where('Id', $uid)->cache('api_check_'.$uid)->find();
		if (!$ud) return false;
		if (!$ud['islogin']) return false;
		return $ud['Id'];
	}
 
    //获取头信息
	protected function getHeader($name = 'token')
	{	
		if ( !function_exists('getallheaders') ) {
			$headers = [];
			foreach ($_SERVER as $sname => $value) {
				if (substr($sname, 0, 5) == 'HTTP_') {
					$headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($sname, 5)))))] = $value;
				}
			}
			if ( count( $headers > 0 ) ) {
				foreach( $headers as $key => $val ) {
					if ( $key == $name || $key == ucfirst($name) ) {
						return $val;
						break;
					}
				}
			}
		} else {
			foreach (getallheaders() as $key => $val) {
				if ($key == $name || $key == ucfirst($name)) {
					return $val;
					break;
				}
			}	
		}
	}
 
    //返回数据
	protected function ApiReturn($data = '', $success = 1, $msg = '', $msgcode = '')
	{
		if ($success == 1) $msgcode = 200;
		if ($success == 0 && $msgcode == '') $msgcode = '000';
		if ($data == '') {
			echo json_encode(['success' => $success, 'msg' => $msg, 'retCode' => $msgcode]);
			die;
		} else {
			echo json_encode(['data' => $data, 'success' => $success, 'msg' => $msg, 'retCode' => $msgcode]);
			die;
		}
	}
 
    //记录调用时间及函数
	protected function ApiRecord($token = '', $apitype = '', $url = '')
	{
		if (!$this->isrecord) return false;
		$data = input('post.', '');
		$get  = input('request.', '');
		if ($token != '' && $apitype != '' && $url != '') {
			$data = ($data != '' && $get != '') ? array_merge($data, $get) : $data;
			if (!isset($data['token']))		  $data['token'] = $this->apitoken;
			$data = ($data != '') ? serialize($data) : '';
			if ( !is_string( $data ) ) return false;
			if ($data != '') Db::name('apirecord')->insert(['apitype' => $apitype, 'token' => $token, 'url' => $url, 'data' => $data, 'action' => md5($url), 'date' => time()]);
		}
	}
 
    //返回图片
	protected function Pic($pic = '', $act = 'news')
	{
		$url = config('companyurl').'/uploads/images/';
		if ($pic == '') return $url . 'default/' . $act . '.png';
		if (file_exists(config('upload_path') . 'images/' . $pic)) return $url . $pic;
		return $url . 'default/' . $act . '.png';
	}
 
    //检测token值
	protected function ckToken($token)
	{
		if ($token == '') $this->ApiReturn('', 0, '请求ID为空', '40005');
		$data = Db::name('tokendata')->field('type,tid,extime,time')->where(['token' => $token])->cache($token,60*30)->find(); //验证结果缓存 1分钟
		if (!$data) $this->ApiReturn('', 0, '非法的请求ID', '40005');
		if (time() > ($data['time'] + $data['extime'])) {
			$this->ApiReturn('', 0, '凭证值已经过期，请重新获取.', '40005');
		} else {
			return ['type' => $data['type'], 'token' => $token];
		}
	}
 
    //上传图片
	protected function savePic($sformat = '', $uid = 0, $folder = '')
	{
		if ($sformat == '') return ['state' => 0, 'msg' => '图片为空，无法保存'];
		if ($folder == '') $folder = date('Ymd');
		$basePath = config('upload_path');
		if (!file_exists($basePath . 'images/' . $folder)) mkdir($basePath . 'images/' . $folder);
		$picname = substr(md5(time() . rand(1, 999)), 0, 15) . '.png';
		$sformat = str_replace('data:image/png;base64,', '', $sformat);
		$sformat = str_replace('data:image/jpg;base64,', '', $sformat);
		$sformat = str_replace('data:image/jpeg;base64,', '', $sformat);
		$ifp = fopen($basePath . 'images/' . $folder . '/' . $picname, "wb");
		fwrite($ifp, base64_decode($sformat));
		fclose($ifp);
		return ['state' => 1, 'msg' => '', 'file' => $folder . '/' . $picname];
	}
 
    //处理NULL值
	protected function dwnull($string = '')
	{
		if ($string == '' || $string == null || $string == null || $string == 'null') return '';
		return $string;
	}
	
	//删除下标数组
	protected function delkey($data,$key)
	{
		if ( $key == '' ) return $data;
		$key = explode(',',$key);
		foreach( $key as $sk ) {
			if ( isset( $data[$sk] ) )  unset($data[$sk]);
		}
		return $data;
	}
	
	//处理日期
	protected function dwdate($time=0)
	{
		if ( !$time ) return 0;
		$year   = date('Y',$time);
		$month  = date('m',$time);
		$day    = date('d',$time);
		$week   = date('w',$time); 
		$nyear  = date('Y');
		$nmonth = date('m');
		$nday   = date('d');
		$weekarr = array('天','一','二','三','四','五','六');
		if( $year == $nyear ) {
		  if ( $month == $nmonth ) {
		    $sday = $nday - $day;
			if ( $sday == 0 ) return date('H:i',$time);
			if ( $sday == 1 ) return '昨天'.date('H:i',$time);
			if ( $sday == 2 ) return '前天'.date('H:i',$time);
			if ( $sday > 2 && $sday < 8 ) {
			   return '星期'.$weekarr[$week].' '.date('H:i',$time);
			}
			return date('d H:i',$time);
		  } else {
		    return date('m月d H:i',$time);
		  }
		} else {
		  return date('Y/m/d H:i',$time);
		}
	}
	
	//是否json格式
	protected function isjson($str)
	{
		json_decode($str);
		return (json_last_error() == JSON_ERROR_NONE) && !is_numeric($str);
	}
	
	//解析content
	protected function dwcontent($content = '')
	{
		if ( $content == '' ) return '';
		$content = str_replace("/lmzf/public/kindedit/attached",config('companyurl').'/public/kindedit/attached',$content);
		return $content;
	}
	
	//下载微信face
	protected function dwface($uid=0,$pic = '')
	{
		if ( !$uid || $pic == '' ) return false;
		$path   = config('upload_path').'images/';
		$pname  = 'wxface/wxface'.$uid.'.png';
		if ( !is_dir($path.'wxface') ) mkdir($path.'wxface');
		if ( file_exists($path.$pname) ) return $path.$pname;
		$ch 	= curl_init($pic);
		curl_setopt($ch, CURLOPT_HEADER, 0);    
		curl_setopt($ch, CURLOPT_NOBODY, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$pckage = curl_exec($ch);
		$hinfo  = curl_getinfo($ch);
		curl_close($ch);
		if( $hinfo['http_code'] != 200 ) return $pic;
		$lf = fopen($path.$pname, 'w');
		if( false !== $lf ){
		   if( false !== fwrite($lf,$pckage) ) fclose($lf);
		   return $path.$pname;
		}
	}

}
