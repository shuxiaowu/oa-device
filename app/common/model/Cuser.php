<?php
namespace app\common\model;

use think\Model;
use think\Db;

class Cuser{

	public function register($data = array())
	{
		$user      = isset($data['user'])      ? $data['user']      : '';
		$phone     = isset($data['phone'])     ? $data['phone']     : '';
		$pass      = isset($data['pass'])      ? $data['pass']      : '';
		$email     = isset($data['email'])     ? $data['email']     : '';
		$parentid  = isset($data['parentid'])  ? $data['parentid']  : 0;
		$scene     = isset($data['scene'])     ? $data['scene']     : 'pc';
		$openid    = isset($data['openid'])    ? $data['openid']    : '';
		$realname  = isset($data['realname'])  ? $data['realname']  : $user;
		$unionid   = isset($data['unionid'])   ? $data['unionid']   : '';
		$sex       = isset($data['sex'])       ? $data['sex']       : 0;
		$userface  = isset($data['userface'])  ? $data['userface']  : '';
		$phcode    = isset($data['phcode'])    ? $data['phcode']    : '';
		$pverify   = isset($data['pverify'])   ? $data['pverify']   : 0;
		$islogin   = isset($data['islogin'])   ? $data['islogin']   : 1;
		$identity  = isset($data['identity'])  ? $data['identity']  : 0;
		$source    = isset($data['source'])    ? $data['source']    : 'web';
		$qq        = isset($data['qq'])        ? $data['qq']        : '';
		$birthday  = isset($data['birthday'])  ? $data['birthday']  : '';
		$intro     = isset($data['intro'])     ? $data['intro']     : '';
		$issession = isset($data['issession']) ? $data['issession'] : 1; //是否生成session
		if ($pverify) {
			if ($phone == '')  return ['state' => 0, 'msg' => '请输入手机号码.'];
			if ($phcode == '') return ['state' => 0, 'msg' => '请输入短信验证码.'];
			if (md5(md5($phcode) . $phone) != cookie('phonecode')) return ['state' => 0, 'msg' => '抱歉，您输入的手机验证码有误.'];
		}
		if ($user != '' && !$this->ckOccupy($user))           return ['state' => 0, 'msg' => '抱歉，用户名被系统占用.'];
		if ($user != '' && !$this->ckField('user', $user))    return ['state' => 0, 'msg' => '抱歉，用户名被占用.'];
		if ($phone != '' && !$this->ckField('phone', $phone)) return ['state' => 0, 'msg' => '抱歉，手机号码被占用.'];
		if ($email != '' && !$this->ckField('email', $email)) return ['state' => 0, 'msg' => '抱歉，邮箱被占用.'];
		if ($scene == 'pc' || $scene == 'mobile') {
			if ($pass == '' || strlen($pass) < 6) return ['state' => 0, 'code' => '', 'msg' => '密码不得为空或者小于6位'];
		}
		$randcode = substr(sha1(date("His")), 4, 6);
		$pass     = ($pass != '') ? md5(md5($pass) . $randcode) : '';
		$ip       = request()->ip();
		$time     = date('Y-m-d H:i:s');
		$inData   = [];
		if ($scene == 'wx' || $scene == 'qq') {
			$user = ($user != '') ? $user : $scene . '_' . time();
			$pass = ($pass != '') ? $pass : md5(md5('123456') . $randcode);
			if ($openid == '') return ['state' => 0, 'msg' => 'OPENID未获取，无法快捷注册'];
		}
		if ($user == '') return ['state' => 0, 'msg' => '用户名不能为空'];
		$inData['user']       = $user;
		$inData['phone']      = $phone;
		$inData['phonecheck'] = ($phone != '') ? 1 : 0;
		$inData['email']      = $email;
		$inData['isactive']   = ($email) ? 1 : 0;
		$inData['password']   = $pass;
		$inData['realname']   = $realname;
		$inData['randcode']   = $randcode;
		$inData['parentid']   = (int)$parentid;
		$inData['sex']        = $sex;
		$inData['last_ip']    = $ip;
		$inData['unionid']    = $unionid;
		$inData['last_time']  = $time;
		$inData['reg_time']   = $time;
		if ($scene == 'wx') {
			$inData['weixinopenid'] = $openid;
			$inData['weixinname']   = $realname;
			$inData['weixinface']   = $userface;
		}
		if ($scene == 'qq') {
			$inData['qqopenid'] = $openid;
			$inData['qqname']   = $realname;
			$inData['qqface']   = $userface;
		}
		$inData['qq']       = $qq;
		$inData['intro']    = $intro;
		$inData['birthday'] = $birthday;
		$inData['source']   = $source;
		$inData['islogin']  = $islogin;
		$invitecode         = self::getinvitecode();
		$inData['invitecode'] = $invitecode;
		$insertid = Db::name('user')->insertGetId($inData);
		if ($insertid) {
			if ( $parentid ) userlevel($parentid);
			return ['state' => 1, 'regid' => $insertid,'invitecode'=>$invitecode, 'msg' => ''];
		} else {
			return ['state' => 0, 'msg' => '注册失败，请重新注册。'];
		}
	}
	
    private function getinvitecode()
	{
        $invitecode = '';
        $chars = "1234567890";
        for($i=0; $i<8;$i++){
            $invitecode .= substr($chars,mt_rand(0, strlen($chars)-1),1);
        }
        $result = Db::name('user')->field('Id')->where(array('invitecode'=>$invitecode))->find();
        if($result){return $this->getinvitecode();}else{return $invitecode;}
    }
  
    //登录
	public function login($data = array())
	{
		$pass   = isset($data['pass'])   ? $data['pass']    : '';
		$user   = isset($data['user'])   ? $data['user']    : '';
		$scene  = isset($data['scene'])  ? $data['scene']   : 'pc';
		$openid = isset($data['openid']) ? $data['openid']  : '';
		$issession = isset($data['issession']) ? $data['issession'] : 0; //是否生成session
		if ($scene == 'pc' || $scene == 'mobile') {
			if ($pass == '' || $user == '') return ['state' => 0, 'msg' => '账户和密码不得为空'];
			$udata = Db::name('user')->field("Id,user,realname,randcode,password,islogin,phone,visit_count")->where("user='$user' OR phone='$user'")->find();
			if (!$udata)            return ['state' => 0, 'msg' => '您输入的用户名不存在.'];
			if (!$udata['islogin']) return ['state' => 0, 'msg' => '抱歉，您的账号禁止登录.'];
			if ($udata['password'] != md5(md5($pass) . $udata['randcode'])) return ['state' => 0, 'code' => '', 'msg' => '抱歉，您输入的密码有误.'];
			$randcode = substr(sha1(time()), 4, 6);
			$date     = date("Y-m-d H:i:s");
			$id       = $udata['Id'];
			$vcount   = $udata['visit_count']+1;
			$ip       = request()->ip();
			Db::name('user')->where('Id', $id)->update(['last_time' => $date, 'last_ip' => $ip, 'randcode' => $randcode,'visit_count'=>$vcount, 'password' => md5(md5($pass) . $randcode)]);
			Db::name('loginrecord')->insert(['uid' => $id, 'ip' => $ip, 'type' => $scene, 'date' => $date]);
			$udata['deuid'] = bhmd5($id);
			unset($udata['randcode']);
			unset($udata['password']);
			unset($udata['islogin']);
			unset($udata['visit_count']);
			$this->ub(['uid' => $id,'name'=>'login', 'mark' => $udata['user'] . '在线登录，登录平台：' . $scene]);
			if ( $issession ) $this->LoginSession(['uid' => $id, 'name' => ($udata['realname']?:$udata['user']), 'scene' => $scene]);
			return ['state' => 1, 'msg' => '', 'data' => $udata];
		} else if ( $scene == 'xcx' ) {
			if ( $openid == '' ) return ['state' => 0, 'msg' => 'openid为空'];
			$udata = Db::name('user')->field("Id,islogin,user,invitecode,realname,phone,visit_count,weixinface")->where("weixinopenid='$openid'")->find();
			if (!$udata)            return ['state' => 0, 'msg' => '您输入的用户名不存在.'];
			if (!$udata['islogin']) return ['state' => 0, 'msg' => '抱歉，您的账号禁止登录.'];
			$udata['face'] = $udata['weixinface'];
			$date     = date("Y-m-d H:i:s");
			$id       = $udata['Id'];
			$vcount   = $udata['visit_count']+1;
			$ip       = request()->ip();
			unset($udata['weixinface']);
			unset($udata['islogin']);
			unset($udata['visit_count']);
			Db::name('user')->where('Id', $id)->update(['last_time' => $date, 'last_ip' => $ip,'visit_count'=>$vcount]);
			Db::name('loginrecord')->insert(['uid' => $id, 'ip' => $ip, 'type' => $scene, 'date' => $date]);
			return ['state' => 1, 'msg' => '', 'data' => $udata];
		}
		return ['state' => 0, 'msg' => '非法登录'];
	}
  
    //生成cookie
	public function LoginSession($data = array())
	{
		$uid    = isset($data['uid'])    ? intval($data['uid']) : 0;
		$name   = isset($data['name'])   ? $data['name']        : '';
		$scene  = isset($data['scene'])  ? $data['scene']       : 'pc';
		$openid = isset($data['openid']) ? $data['openid']      : '';
		cookie(md5('userauth'), bhmd5(['userid' => $uid, 'user' => $name, 'logintype' => $scene, 'openid' => $openid]));
	}
  
    //占用
	public function ckField($field = '', $val = '')
	{
		if ($field != '' && $val != '') {
			$udata = Db::name('user')->field($field)->where([$field => $val])->find();
			return ($udata) ? false : true;
		} else {
			return false;
		}
	}
  
    //验证本占用
	private function ckOccupy($user = '')
	{
		if ($user == '') return false;
		if ( !$data = cache('system_userset') ) {
		  $data = Db::name('systemconfig')->field('userset')->where('Id', 1)->find();
   	      cache('system_userset',$data);
		}
		if (!$data) return true;
		if ( $data['userset'] == '') return true;
		$occ = explode(",", $data['userset']);
		return in_array($user, $occ) ? false : true;
	}
  
    //用户行为 user_behavior
	public function ub($data = array())
	{
		$uid  = isset($data['uid'])  ? $data['uid']  : 0;
		$name = isset($data['name']) ? $data['name'] : ''; //行为方法
		$mark = isset($data['mark']) ? $data['mark'] : ''; //备注
		$uri  = isset($data['uri'])  ? $data['uri']  : ''; //访问的链接
		$pid  = isset($data['pid'])  ? $data['pid']  : 0;  //推荐人
		$cs   = isset($data['cs'])   ? $data['cs']   : ''; //参数
		$auth = cookie('?'.md5('userauth')) ? bhmd5(cookie(md5('userauth')),true) : '';
		$uid  = (!$uid && $auth != '') ? $auth['userid'] : $uid;
		if ($cs != '' && (is_array($cs) || is_object($cs))) $cs = serialize($cs);
		if (!$uid) return $data;
		$uri = ($uri == '') ? request()->url(true) : $uri;
		$name = ($name == '') ? request()->controller() . '/' . request()->action() : $name;
		$refer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
		if ( !is_string($cs) ) return false;
		$res = Db::name('userbehavior')->insert(['uid' => $uid, 'mark' => $mark, 'name' => $name, 'uri' => $uri, 'refer' => $refer, 'parent_id' => $pid, 'parameter' => $cs, 'date' => time()]);
		return ($res) ? true : false;
	}
	
	//消费 $uconf[] 
	public function payrecode($conf)
	{
		$mark    = isset($conf['mark'])     ? $conf['mark']      : '';
		$sn      = isset($conf['sn'])       ? $conf['sn']	     : '';
		$price   = isset($conf['price'])    ? $conf['price']	 : 0; //消费金额
		$amount  = isset($conf['amount'])   ? $conf['amount']	 : 0;
		$uid	 = isset($conf['uid'])      ? $conf['uid']	     : 0; //uid
		$type    = isset($conf['type'])     ? $conf['type']	     : 1; //1消费 2获取
		$payment = isset($conf['payment'])  ? $conf['payment']	 : 1; //1余额 2微信 3支付宝？
		$isdk    = isset($conf['isdk']) 	? $conf['isdk']	     : 0; //是否代扣
		$isadd   = isset($conf['isadd']) 	? $conf['isadd']	 : 0; //是否代加
		$title   = isset($conf['title']) 	? $conf['title']	 : '在线消费';
		$lev     = isset($conf['lev']) 		? $conf['lev']	     : 1; //1.产品消费 2.充值3.退款 4.提现5.分享提成
		if ( !$uid ) return ['state'=>0,'msg'=>'操作UID为空'];
		if ( $price == 0 || $price < 0 ) return ['state'=>0,'msg'=>'操作金额为空'];
		$udata   = Db::name('user')->field('amount')->where('Id',$uid)->find();
		if ( !$udata )  return ['state'=>0,'msg'=>'用户信息不存在'];
		$balance = ($type==1) ? $udata['amount'] - $price : $udata['amount'] + $price;
		if ( $isdk == 1 ) {
			if ( $price > $udata['amount'] ) return ['state'=>0,'msg'=>'您的余额不足.'];
			$res = Db::name('user')->where('Id',$uid)->setDec('amount',$price);
		}
		if ( $isadd == 1 ) {
			$res = Db::name('user')->where('Id',$uid)->setInc('amount',$price);
		}
		$indata = ['payment'=>$payment,'type'=>$type,'uid'=>$uid,'price'=>$price,'lev'=>$lev,'balance'=>$balance,'gaintitle'=>$title,'ordersn'=>$sn,'mark'=>$mark,'date'=>date('Y-m-d H:i:s')];
		$res = Db::name('payrecord')->insert($indata);
		if ( $res ) {
			return ['state'=>1,'msg'=>''];
		} else {
			return ['state'=>0,'msg'=>'记录新增失败，请重试'];
		}
	}

}
