<?php
namespace app\api\controller;

use think\Controller;
use think\Db;

class Token extends Api
{

	protected $appid;
	protected $secret;
	protected $expires_in;
	public function _initialize()
	{
		header('Access-Control-Allow-Origin:*');
		if (!request()->isGet()) $this->ApiReturn('', 0, '	请求方式无效', '400031');
		$appid            = input('get.appid', '', '');
		$secret           = input('get.secret', '');
		$this->appid      = $appid;
		$this->secret     = $secret;
		$this->expires_in = 7200;
		if ($appid == '')  $this->ApiReturn('', 0, 'appid为空', '40001');
		if ($secret == '') $this->ApiReturn('', 0, 'secret为空', '40001');
	}
   
    //获取token
	public function getToken()
	{
		$data = Db::name('token')->field('enabled,Id,type')->where(['appid' => $this->appid, 'secret' => $this->secret])->cache(true, $this->slighttime)->find();
		if (!$data) $this->ApiReturn('', 0, 'appid或者secret错误，请开发者确认appid 或者 secret的正确性', '400035');
		if (!$data['enabled']) $this->ApiReturn('', 0, '该账号无法使用，请更换您的账户名', '400035');
		$token = md5($this->appid . '_' . $this->secret . '_' . time().rand(10000,99999));
		$result = Db::name('tokendata')->insert(['token' => $token, 'tid' => $data['Id'], 'type' => $data['type'], 'extime' => $this->expires_in, 'time' => time()]);
		return json(['token' => $token, 'expires_in' => $this->expires_in, 'success' => 1, 'retCode' => 200, 'msg' => '']);
	}
	
	//获取IMToken
	public function imToken()
	{
		$token = imtoken();
		return json(['token' => $token, 'success' => 1, 'retCode' => 200, 'msg' => '']);
	}
	
	
}
