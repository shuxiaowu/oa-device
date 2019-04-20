<?php
namespace app\bhadmin\controller;

use think\Db;

class System extends Common
{

	public function index()
	{
		return false;
	}

	public function sysmod()
	{
		$save = input('post.send', '');
		$data = Db::name("systemconfig")->field('*')->where("Id", 1)->find();
		if (!$data) $this->error('资料不存在！');
		if ($save == '') {
			return $this->fetch('', ['activeid' => 12, 'title' => '系统设置', 'data' => $data]);
		} else if ($save == '确定保存') {
			$metatitle = input('post.metatitle', '');
			$icpnote = input('post.icpnote', '');
			$metades = input('post.metades', '');
			$metakey = input('post.metakey', '');
			$sys_notice = input('post.sys_notice', '');
			$sys_code = cg('sys_code');
			$c_site = input('post.c_site', 0, 'intval');
			$c_text = input('post.c_text', '');
			$isonline = input('post.isonline', 0, 'intval');
			$isqq = input('post.isqq', 0, 'intval');
			$adminpage = input('post.adminpage', 15, 'intval');
			$adminpage = ($adminpage < 1) ? 1 : $adminpage;
			$result = Db::name("systemconfig")->where("Id", 1)->update(array('metatitle' => $metatitle, 'icpnote' => $icpnote, 'metades' => $metades, 'metakey' => $metakey, 'sys_notice' => $sys_notice, 'sys_code' => $sys_code, 'c_site' => $c_site, 'c_text' => $c_text, 'isonline' => $isonline, 'isqq' => $isqq, 'adminpage' => $adminpage));
			if ($result) {
				cache('sysconfig',null);
				$this->success('资料更新成功');
			} else {
				$this->error('资料更新失败，请重新试试吧');
			}
		}
	}
	
	public function tosafty(){
	    $send = input('post.send','');
		$act  = input('act','');
		if ( $send == '' ) {
	      return $this->fetch('',['act'=>$act,'title'=>'安全验证']); 
		} else {
		  $pass   = input('post.pass','');
		  if ( $pass == '' ) $this->error('请输入安全验证码');
		  if ( md5( $pass ) != md5(config('md5key').'-auth') ) { $this->error('权限验证失败，请重新输入您的授权码'); }
		  session('saftyauth',md5($pass));
		  $url = '';
		  if ( $act == 'tb' )   $url = url('system/databackup');
		  if ( $act == 'sql' )  $url = url('system/tosql');
		  if ( $act == 'tool' ) $url = url('system/tool');
		  $this->success('权限验证通过',$url);
		}
	}
	
	public function cksafty()
	{
	    if ( !session('?saftyauth') ) return false;
		if ( session('saftyauth') != md5(config('md5key').'-auth') ) return false;
		return true;
	}

	public function sysmsg()
	{
		$save = input('post.send', '');
		$data = Db::name("baseconfig")->field('*')->where("Id", 1)->find();
		if (!$data) $this->error('资料不存在！');
		if ($save == '') {
			$tips = '<span class="sysmsg-tips"><span class="fa fa-spinner fa-spin"></span> 获取中...</span>';
			return $this->fetch('', ['activeid' => 12, 'title' => '短信设置', 'data' => $data, 'msgtips' => $tips]);
		} else if ($save == '确定保存') {
			$msguser = input('post.msguser', '');
			$msgpass = input('post.msgpass', '');
			$msgsuff = input('post.msgsuff', '');
			$result = Db::name("baseconfig")->where("Id", 1)->update(array('msguser' => $msguser, 'msgpass' => $msgpass, 'msgsuff' => $msgsuff, 'date' => dates()));
			if ($result) {
				cache('system_msg_config', null);
				$this->success('资料更新成功');
			} else {
				$this->error('资料更新失败，请重新试试吧');
			}
		}
	}

	public function getmsgcount()
	{
		$data = Db::name("baseconfig")->field('msguser,msgpass')->where("Id", 1)->find();
		if (!$data) return json('未知');
		if ($data['msguser'] == '' || $data['msgpass'] == '') return json('未配置服务器');
		$ch = curl_init();
		if (cache('msg_tips_' . $data['msguser'] . '_' . $data['msgpass'])) return json(cache('msg_tips_' . $data['msguser'] . '_' . $data['msgpass']));
		$sdata = ['account' => $data['msguser'], 'password' => md5($data['msgpass'])];
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($sdata));
		curl_setopt($ch, CURLOPT_URL, 'http://www.jianzhou.sh.cn/JianzhouSMSWSServer/http/getUserInfo');
		$res = curl_exec($ch);
		curl_close($ch);
		$tres = model('tool')->dwxml($res);
		$tips = isset($tres['remainFee']) ? '剩余：' . $tres['remainFee'] . '条' : '未知';
		cache('msg_tips_' . $data['msguser'] . '_' . $data['msgpass'], $tips, 300);
		return json($tips);
	}

	public function sysweixin()
	{
		$save = input('post.send', '');
		$data = Db::name("baseconfig")->field('*')->where("Id", 1)->find();
		if (!$data) $this->error('资料不存在！');
		if ($save == '') {
			return $this->fetch('', ['activeid' => 12, 'title' => '微信设置', 'data' => $data]);
		} else if ($save == '确定保存') {
			$wxappid = input('post.wxappid', '');
			$wxsecret = input('post.wxsecret', '');
			$companyurl = input('post.companyurl', '');
			$wxname = input('post.wxname', '');
			$result = Db::name("baseconfig")->where("Id", 1)->update(array('wxappid' => $wxappid, 'wxsecret' => $wxsecret, 'companyurl' => $companyurl, 'wxname' => $wxname, 'date' => dates()));
			if ($result) {
				cache('system_weixin_config',null);
				$this->success('资料更新成功');
			} else {
				$this->error('资料更新失败，请重新试试吧');
			}
		}
	}

	public function sysaddress()
	{
		$lev = input('lev', 1, 'intval');
		$did = input('did', 0, 'intval');
		$where = '1=1 AND level=' . $lev;
		$name = input('name', '');
		if ($did != 0) $where .= ' AND upid=' . $did;
		if ($name != '') $where = "name LIKE'%{$name}%'";
		$this->pageDisplay(array('where' => $where, 'tables' => 'district','title'=>'地址库管理', 'order' => 'enabled DESC,Id ASC'));
		return view('', ['name' => $name]);
	}

	public function addressmod()
	{
		$save = input('post.send', '');
		$tables = 'district';
		$id = input('id', 0, 'intval');
		if (!$id) $this->error('ID未指定,无法获取任何数据');
		$data = Db::name($tables)->field('*')->where("Id", $id)->find();
		if (!$data) $this->error('资料不存在，请重新操作！');
		if ($save == '') {
			return $this->fetch('', ['data' => $data, 'activeid' => 118, 'title' => '编辑地址']);
		} else if ($save == '提交') {
			$name = input('post.name', '');
			if ($name == '') $this->error('请填写地址名称');
			$result = Db::name($tables)->where('Id', $id)->update(['name' => $name]);
			if ($result) {
				$this->success('地址修改成功');
			} else {
				$this->error('地址修改失败');
			}
		}
	}

	public function addressadd()
	{
		$tables = 'district';
		$send = input('post.send', '');
		$did = input('did', 0, 'intval');
		$lev = input('lev', 0, 'intval');
		if ($send == '') {
			return $this->fetch('', ['did' => $did, 'lev' => $lev, 'activeid' => 118, 'title' => '添加地址']);
		} else if ($send == '提交') {
			$name = input('post.name', '');
			$level = input('post.level', 0, 'intval');
			$did = input('post.did', 0, 'intval');
			if ($name == '') $this->error('请填写地址名称');
			$result = Db::name($tables)->insert(['name' => $name, 'upid' => $did, 'level' => $level]);
			if ($result) {
				$this->success('添加成功');
			} else {
				$this->error('添加失败，请重新试试吧');
			}
		}

	}

	public function sysmail()
	{
		$save = input('post.send', '');
		$act  = input('act','');
		$data = Db::name("systemconfig")->field('*')->where("Id", 1)->find();
		if (!$data) $this->error('资料不存在！');
		if ($save == '') {
			$ismail = (function_exists("mail")) ? 1 : 0;
			return $this->fetch('', ['activeid' => 144, 'title' => '邮件服务器设置', 'ismail' => $ismail,'act'=>$act, 'data' => $data]);
		} else if ($save == '确定保存') {
			$mailsmtp = input('post.mailsmtp', '');
			$mailport = input('post.mailport', '');
			$mailname = input('post.mailname', '');
			$mailpass = input('post.mailpass', '');
			if ( $mailpass != $data['mailpass'] ) {
			  $mailpass = ($mailpass!='') ? bhmd5($mailpass) : '';
			}
			cache('system_mail_config',null);
			$result = Db::name("systemconfig")->where("Id", 1)->update(array('mailsmtp' => $mailsmtp, 'mailport' => $mailport, 'mailname' => $mailname, 'mailpass' => $mailpass));
			if ($result) {
				$this->success('资料更新成功');
			} else {
				$this->error('资料更新失败，请重新试试吧');
			}
		}
	}

	public function mailtpl()
	{
		$tables = 'mailtpl';
		$where = "1=1";
		$this->pageDisplay(array('where' => $where, 'tables' => $tables));
		return view('',['title'=>'邮件模板列表']);
	}

	public function mailtpladd()
	{
		$send = input('post.send', '');
		$tables = 'mailtpl';
		if ($send == '') {
			return $this->fetch('', ['tables' => $tables, 'editor' => true, 'title' => '添加模板', 'activeid' => 143]);
		} else {
			if ($send == '提交') {
				$result = Db::name($tables)->insert($this->fieldArr('content,tplname'));
				if ($result) {
					$this->success('资料添加成功', url('system/mailtpl'));
				} else {
					$this->error('资料添加失败，请重新试试吧', url('system/mailtpladd'));
				}
			}
		}
	}

	public function mailtplmod()
	{
		$save = input('post.send', '');
		$id = input('id', 0, 'intval');
		$tables = 'mailtpl';
		if (!$id) $this->error('ID未指定,无法获取任何数据');
		$data = Db::name($tables)->field('*')->where("Id", $id)->find();
		if (!$data) $this->error('资料不存在，请重新操作！');
		if ($save == '') {
			return $this->fetch('', ['data' => $data, 'tables' => $tables, 'editor' => true, 'title' => '编辑模板', 'activeid' => 143]);
		} else if ($save == '确定修改') {
			$result = Db::name($tables)->where("Id", $id)->update($this->fieldArr('content,tplname'));
			if ($result) {
				$this->success('数据更新成功', url('system/mailtpl'));
			} else {
				$this->error('数据更新失败，请重新试试吧', url('system/mailtplmod', 'id=' . $id));
			}
		}
	}

	public function syscompany()
	{
		$save = input('post.send', '');
		$data = Db::name("systemconfig")->field('*')->where("Id", 1)->find();
		if (!$data) $this->error('资料不存在！');
		if ($save == '') {
			return $this->fetch('', ['activeid' => 12, 'upload' => true, 'title' => '公司设置', 'data' => $data]);
		} else if ($save == '确定保存') {
			$companyname = input('post.companyname', '');
			$address = input('post.address', '');
			$weibourl = input('post.weibourl', '');
			$tel = input('post.tel', '');
			$fax = input('post.fax', '');
			$qq = input('post.qq', '');
			$email = input('post.email', '');
			$mobile = input('post.mobile', '');
			$contact = input('post.contact', '');
			$weixinpic = input('post.pic', '');
			$result = Db::name("systemconfig")->where("Id", 1)->update(array('weixinpic' => $weixinpic, 'companyname' => $companyname, 'address' => $address, 'weibourl' => $weibourl, 'tel' => $tel, 'fax' => $fax, 'mobile' => $mobile, 'contact' => $contact, 'email' => $email, 'qq' => $qq));
			if ($result) {
				cache('sysconfig',null);
				$this->success('资料更新成功');
			} else {
				$this->error('资料更新失败，请重新试试吧');
			}
		}
	}

	public function syswater()
	{
		$save = input('post.send', '');
		$data = Db::name("systemconfig")->field('*')->where("Id", 1)->find();
		if (!$data) $this->error('资料不存在，请重新操作！');
		if ($save == '') {
			$facearr = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H','I');
			return $this->fetch('', ['activeid' => 12, 'facetitle' => '字体' . $facearr[$data['facetype']], 'upload' => true, 'color' => true, 'title' => '水印设置', 'data' => $data]);
		} else if ($save == '确定保存') {
			$pic = input('post.pic', '');
			$waterpos = input('post.waterpos', 9, 'intval');
			$fonttext = input('post.fonttext', '');
			$fontsize = input('post.fontsize', 20, 'intval');
			$fontcolor = input('post.fontcolor', '');
			$wateralpha = input('post.wateralpha', 1, 'intval');
			$fontpos = input('post.fontpos', 9, 'intval');
			$iswater = input('post.iswater', 0, 'intval');
			$facetype = input('post.facetype', 0, 'intval');
			$facetype = ($facetype > 8) ? 8 : $facetype;
			$result = Db::name("systemconfig")->where("Id", 1)->update(array('waterpos' => $waterpos, 'wateralpha' => $wateralpha, 'fonttext' => $fonttext, 'fontsize' => $fontsize, 'fontcolor' => $fontcolor, 'facetype' => $facetype, 'fontpos' => $fontpos, 'iswater' => $iswater, 'waterpic' => $pic));
			if ($result) {
				cache('system_uploads',null);
				$this->success('数据更新成功');
			} else {
				$this->error('数据更新失败，请重新试试吧');
			}
		}
	}

	public function sysupload()
	{
		$save = input('post.send', '');
		$data = Db::name("systemconfig")->field('*')->where("Id", 1)->find();
		if (!$data) $this->error('资料不存在，请重新操作！');
		if ($save == '') {
			return $this->fetch('', ['activeid' => 12, 'title' => '上传设置', 'data' => $data]);
		} else if ($save == '确定保存') {
			$picsuffix = input('post.picsuffix', '', null);
			$filesuffix = input('post.filesuffix', '', null);
			$picsize = input('post.picsize', 0, 'intval');
			$filesize = input('post.filesize', 0, 'intval');
			$picmaxwidth = input('post.picmaxwidth', 0, 'intval');
			$cropwidth = input('post.cropwidth', 0, 'intval');
			$picmaxsize = input('post.picmaxsize', 0, 'intval');
			$result = Db::name("systemconfig")->where('Id', 1)->update(array('picsuffix' => $picsuffix, 'filesuffix' => $filesuffix, 'filesize' => $filesize, 'picmaxwidth' => $picmaxwidth, 'cropwidth' => $cropwidth, 'picsize' => $picsize, 'picmaxsize' => $picmaxsize));
			if ($result) {
				cache('system_uploads',null);
				$this->success('上传设置更新成功');
			} else {
				$this->error('上传设置更新失败，请重新试试吧');
			}
		}
	}

	public function ipfilter()
	{
		$save = input('post.send', '');
		if ($save == '') {
			$data = Db::name("systemconfig")->field('shieldip,iptips')->where('Id', 1)->find();
			if (!$data) $this->error('资料不存在，请重新操作！');
			return $this->fetch('', ['title' => 'IP过滤设置', 'data' => $data]);
		} else if ($save == '确定保存') {
			$shieldip = input('post.shieldip', '');
			$iptips   = input('post.iptips', '');
			$dobj     = Db::name("systemconfig")->where('Id', 1)->update(array('shieldip' => $shieldip, 'iptips' => $iptips));
			if ($dobj) {
				$this->success('数据更新成功');
			} else {
				$this->error('数据更新失败，请重新试试吧');
			}
		}
	}

	public function admindepartment()
	{
		$this->pageDisplay(array('title' => '部门管理列表', 'tables' => 'admindepartment', 'order' => 'ord ASC'));
		return view();
	}

	public function admindepartmentadd()
	{
		$topmenu = Db::name('adminauth')->field('Id,title,isimportant')->where('1=1 AND tid=0')->order('ord ASC')->select();
		if ($topmenu) {
			foreach ($topmenu as $key => $val) {
				$topmenu[$key]['mdata'] = Db::name('adminauth')->field('Id,title,isimportant')->where('1=1 AND tid=' . $val['Id'])->order('ord ASC')->select();
			}
		}
		return $this->fetch('', ['activeid' => 77, 'title' => '添加管理部门', 'adminauths' => $topmenu]);
	}

	public function createdepartment()
	{
		$topic = input('post.topic', '');
		$ord = input('post.ord', '');
		$auth = isset($_POST['auth']) ? $_POST['auth'] : array();
		$userauth = '';
		if (count($auth) > 0) {
			foreach ($auth as $key => $val) {
				$userauth .= $val . ',';
			}
		}
		$userauth = ($userauth != '') ? trim($userauth, ',') : '';
		if ($topic != '') {
			$res = Db::name('admindepartment')->insert(array('topic' => $topic, 'auth' => $userauth, 'ord' => $ord, 'date' => dates()));
			if ($res) {
				$this->success('部门添加成功', url('system/admindepartment'));
			} else {
				$this->success('部门添加失败，请重试', url('system/admindepartmentadd'));
			}
		} else {
			$this->error('请先完善部门信息', url('system/admindepartmentadd'));
		}
	}

	public function admindepartmentmod()
	{
		$id = input('id', 0, 'intval');
		$save = input('post.send', '');
		if (!$id) $this->error('ID未指定,无法获取任何数据');
		if ($save == '') {
			$data = Db::name("admindepartment")->field('*')->where(array('Id' => $id))->find();
			if (!$data) $this->error('资料不存在，请重新操作！');
			$topmenu = Db::name('adminauth')->field('Id,title,isimportant')->where('1=1 AND tid=0')->order('ord ASC')->select();
			if ($topmenu) {
				foreach ($topmenu as $key => $val) {
					$topmenu[$key]['mdata'] = Db::name('adminauth')->field('Id,title,isimportant')->where('1=1 AND tid=' . $val['Id'])->order('ord ASC')->select();
				}
			}
			return $this->fetch('', ['activeid' => 77, 'title' => '部门编辑', 'data' => $data, 'adminauths' => $topmenu]);
		} else if ($save == '确定修改') {
			$topic = input('post.topic', '');
			$ord = input('post.ord', '');
			$auth = isset($_POST['auth']) ? $_POST['auth'] : array();
			$userauth = '';
			if (count($auth) > 0) {
				foreach ($auth as $key => $val) {
					$userauth .= $val . ',';
				}
			}
			$userauth = ($userauth != '') ? trim($userauth, ',') : '';
			$result = Db::name("admindepartment")->where(array('Id' => $id))->update(array('ord' => $ord, 'topic' => $topic, 'auth' => $userauth, 'date' => dates()));
			if ($result) {
				cache('admintopmenu', null);
				$this->success('数据更新成功');
			} else {
				$this->error('数据更新失败，请重新试试吧');
			}
		}
	}


	public function sysapi()
	{
		$this->pageDisplay(array('title' => 'APP接口管理', 'tables' => 'token', 'order' => 'Id ASC'));
		return view();
	}

	public function apiadd()
	{
		$send = input('post.send', '');
		if ($send == '') {
			return $this->fetch('', ['title' => '添加TOKEN', 'activeid' => 106]);
		} else {
			if ($send == '提交') {
				$type = input('post.type', '');
				$appid = input('post.appid', '');
				$remark = input('post.remark', '');
				if ($type == '' || $appid == '') $this->error('请输入身份及APPID');
				$secret = md5('bh_' . $appid . '_' . time());
				$isone = Db::name('token')->where(array('appid' => $appid))->find();
				if ($isone) $this->error('appid被占用');
				$result = Db::name('token')->insert(['type' => $type, 'appid' => $appid, 'remark' => $remark, 'secret' => $secret, 'date' => dates()]);
				if ($result) {
					$this->success('资料添加成功', url('system/sysapi'));
				} else {
					$this->error('资料添加失败，请重新试试吧', url('system/apiadd'));
				}
			}
		}
	}

	public function versionlist()
	{
		$this->pageDisplay(array('title' => '版本管理', 'tables' => 'version', 'order' => 'versioncode DESC'));
		return view();
	}

	public function versionadd()
	{
		$send = input('post.send', '');
		if ($send == '') {
			return $this->fetch('', ['title' => '添加APP版本', 'activeid' => 107]);
		} else {
			if ($send == '提交') {
				$version = input('post.version', '');
				$versioncode = input('post.versioncode', '');
				$url = input('post.url', '');
				$intro = input('post.intro', '');
				$isforce = input('post.isforce', 0, 'intval');
				$enabled = input('post.enabled', 0, 'intval');
				if ($version == '' || $versioncode == '') $this->error('请输入版本号，或者版本码');
				$isone = Db::name('version')->where(array('version' => $version))->find();
				if ($isone) $this->error('版本已经存在');
				$result = Db::name('version')->insert(['version' => $version, 'versioncode' => $versioncode, 'url' => $url, 'intro' => $intro, 'isforce' => $isforce, 'enabled' => $enabled, 'date' => dates()]);
				if ($result) {
					$this->success('资料添加成功', url('system/versionlist'));
				} else {
					$this->error('资料添加失败，请重新试试吧', url('system/versionadd'));
				}
			}
		}
	}

	public function versionmod()
	{
		$save = input('post.send', '');
		$tables = 'version';
		$id = input('id', 0, 'intval');
		if (!$id) $this->error('ID未指定,无法获取任何数据');
		$data = Db::name($tables)->field('*')->where("Id", $id)->find();
		if (!$data) $this->error('资料不存在，请重新操作！');
		if ($save == '') {
			return $this->fetch('', ['data' => $data, 'activeid' => 107, 'title' => '编辑信息']);
		} else {
			if ($save == '确定修改') {
				$version = input('post.version', '');
				$versioncode = input('post.versioncode', '');
				$url = input('post.url', '');
				$intro = input('post.intro', '');
				$isforce = input('post.isforce', 0, 'intval');
				$enabled = input('post.enabled', 0, 'intval');
				if ($version == '' || $versioncode == '') $this->error('请输入版本号，或者版本码');
				$isone = Db::name('version')->where(array('version' => $version, 'Id' => array('neq', $id)))->find();
				if ($isone) $this->error('版本已经存在');
				$result = Db::name($tables)->where("Id", $id)->update(['version' => $version, 'versioncode' => $versioncode, 'url' => $url, 'intro' => $intro, 'isforce' => $isforce, 'enabled' => $enabled, 'date' => dates()]);
				if ($result) {
					$this->success('数据更新成功', url('system/versionlist'));
				} else {
					$this->error('数据更新失败，请重新试试吧', url('system/versionmod', 'id=' . $id));
				}
			}
		}
	}

	public function userlist()
	{
		$this->pageDisplay(array('title' => '管理员列表', 'tables' => 'adminuser', 'order' => 'last_time DESC'));
		return view();
	}

	public function msghistory()
	{
		$sday      = input('sday', '');
		$eday      = input('eday', '');
		$amount    = input('amount', '');
		$issuccess = input('issuccess', 0, 'intval');
		$type      = input('type', 0, 'intval');
		$where     = '1=1';
		if ($amount != '') $where .= " AND amount LIKE '%{$amount}%'";
		if ($sday != '' && $eday != '') {
			$sdays = strtotime(date('Y-m-d 00:00:00', strtotime($sday)));
			$edays = strtotime(date('Y-m-d 24:00:00', strtotime($eday)));
			$where .= " AND date>='{$sdays}' AND date<='{$edays}'";
		}
		if ($type) $where .= " AND type='{$type}'";
		if ($issuccess == 1) $where .= " AND successid=1";
		if ($issuccess == 2) $where .= " AND successid<>1";
		$this->pageDisplay(array('title' => '短信，邮件，微信，极光，模板消息 发送记录', 'where' => $where, 'tables' => 'msghistory', 'order' => 'Id DESC'));
		return $this->fetch('',['sday'=>$sday,'eday'=>$eday,'date'=>true]);
	}

	public function apirecord()
	{
		$sday = input('sday', '');
		$eday = input('eday', '');
		$url = input('url', '');
		$apitype = input('apitype', '');
		$where = '1=1';
		if ($url != '') $where .= " AND url LIKE '%{$url}%'";
		if ($sday != '' && $eday != '') {
			$sdays = strtotime($sday);
			$edays = strtotime($eday);
			$where .= " AND date>='{$sdays}' AND date<='{$edays}'";
		}
		if ($apitype != '') $where .= " AND apitype='{$apitype}'";
		$this->assign('sday', $sday);
		$this->assign('eday', $eday);
		$this->assign('apitype', $apitype);
		$this->assign('date', true);
		$this->pageDisplay(array('title' => 'API调用记录', 'where' => $where, 'tables' => 'apirecord', 'order' => 'Id DESC'));
		return view();
	}

	public function ajaxrecord()
	{
		$id = input('post.id', 0, 'intval');
		if ($id) {
			$data = Db::name('apirecord')->field('*')->where('Id', $id)->find();
			if ($data) {
				$html = '<div class="alert-apirecord">';
				$html .= '<dd>请求链接：' . $data['url'] . '</dd>';
				$html .= '<dd>请求日期：' . date('Y-m-d H:i:s', $data['date']) . '</dd>';
				$redata = unserialize($data['data']);
				$html .= '<table class="table table-bordered table-hover" style="margin:10px auto;">';
				$html .= '<tr><td>参数</td><td>值</td></tr>';
				foreach ($redata as $key => $val) {
					$html .= '<tr><td>' . $key . '</td><td>' . $val . '</td></tr>';
				}
				$html .= '</div>';
				return json(array('state' => 1, 'msg' => '', 'html' => $html));
			} else {
				$html = '<div class="alert alert-danger">暂无数据</div>';
				return json(array('state' => 0, 'msg' => '', 'html' => $html));
			}
		}
	}

	public function usermod()
	{
		$id = input('id', 0, 'intval');
		$save = input('post.send', '');
		if (!$id) $this->error('ID未指定,无法获取任何数据');
		$data = Db::name("adminuser")->field('*')->where(array('Id' => $id))->find();
		if (!$data) $this->error('资料不存在，请重新操作！');
		if ($save == '') {
			return $this->fetch('', ['activeid' => 20, 'title' => '用户编辑', 'data' => $data, 'admindep' => $this->getSelect('admindepartment')]);
		} else if ($save == '确定修改') {
			$pass = input('post.pass', '');
			$name = input('post.name', '');
			$depid = input('post.depid', 0, 'intval');
			$result = Db::name("adminuser")->where(array('Id' => $id))->update(array('realname' => $name, 'depid' => $depid, 'last_time' => dates()));
			if ($result) {
				if ($pass != '') model('AdminUser')->modpass($pass, $id);
				$this->success('数据更新成功');
			} else {
				$this->error('数据更新失败，请重新试试吧');
			}
		}
	}

	public function useradd()
	{
		return $this->fetch('', ['activeid' => 20, 'title' => '添加管理员', 'admindep' => $this->getSelect('admindepartment')]);
	}

	public function createuser()
	{
		$user = input('post.user', '');
		$pass = input('post.pass', '');
		$name = input('post.name', '');
		$depid = input('post.depid', 0, 'intval');
		if ($user != '' && $pass != '' && $name != '') {
			if (model("AdminUser")->adduser($user, $pass, $name, $depid)) {
				$this->success('管理员添加成功', url('system/userlist'));
			} else {
				$this->success('管理员添加失败，请重试', url('system/useradd'));
			}
		} else {
			$this->error('请先完善管理员信息', url('system/useradd'));
		}
	}

	public function adminauth()
	{
		$this->pageDisplay(array('title' => '系统栏目管理', 'tables' => 'adminauth', 'where' => '1=1 AND tid=0', 'order' => 'isimportant DESC,ord ASC,Id DESC'));
		return view();
	}

	public function adminauthadd()
	{
		$send = input('post.send', '');
		if ($send == "") {
			$menu = Db::name('adminauth')->field('Id,title AS topic')->where('tid=0')->select();
			return $this->fetch('', ['activeid' => 19, 'title' => '添加控制权限', 'topmenu' => $menu]);
		} else if ($send == "添加栏目") {
			$title = input('post.title', '');
			$icon = input('post.icon', '');
			$linkurl = isset($_POST['linkurl']) ? trim($_POST['linkurl']) : '';
			$pid = input('post.pid', 0, 'intval');
			$mpid = input('post.mpid', 0, 'intval');
			$ord = input('post.ord', 0, 'intval');
			$isopen = input('post.isopen', 0, 'intval');
			$isext = input('post.isext', 0, 'intval');
			$isspecial = input('post.isspecial', 0, 'intval');
			$isimportant = input('post.isimportant', 0, 'intval');
			if ($mpid == 2) $pid = input('post.lid', 0, 'intval');
			$name = $martables = $tables = '';
			$sty = 1;
			if ($linkurl != '') {
				$mlink = explode(",", $linkurl);
				$name = (isset($mlink[0]) && $mlink[0] != '') ? $mlink[0] : '';
				$fields = (isset($mlink[1]) && $mlink[1] != '') ? $mlink[1] : '';
				if ($fields != '') {
					$fields = explode("&", $fields);
					if (count($fields) > 0) {
						foreach ($fields as $mval) {
							if ($mval != '') {
								$vArr = explode("=", $mval);
							}
							if ($vArr[0] == 'martables') {
								$martables = (isset($vArr[1]) && $vArr[1] != '') ? trim($vArr[1]) : '';
							}
							if ($vArr[0] == 'tables') {
								$tables = (isset($vArr[1]) && $vArr[1] != '') ? trim($vArr[1]) : '';
							}
							if ($vArr[0] == 'sty') {
								$sty = (isset($vArr[1]) && $vArr[1] != '') ? intval($vArr[1]) : 1;
							}
						}
					}
				}
			}
			$result = Db::name("adminauth")->insert(array('title' => $title, 'name' => $name, 'icon' => $icon, 'isext' => $isext, 'sty' => $sty, 'isopen' => $isopen, 'isspecial' => $isspecial, 'martables' => $martables, 'tables' => $tables, 'linkurl' => $linkurl, 'ord' => $ord, 'isimportant' => $isimportant, 'tid' => $pid, 'date' => dates()));
			if ($result) {
				$this->success('权限添加成功');
			} else {
				$this->error('权限添加失败，请重新试试吧');
			}
		}
	}
  
  //编辑权限
	public function adminauthmod()
	{
		$id = input('id', 0, 'intval');
		$save = input('post.send', '');
		if (!$id) $this->error('ID未指定,无法获取任何数据');
		if ($save == "") {
			$data = Db::name("adminauth")->field('*')->where(array('Id' => $id))->find();
			if (!$data) $this->error('资料不存在，请重新操作！');
			$mpid = 1;
			$lid = 0;
			$mtopic = '';
			$mlist = '';
			$topmenu = Db::name('adminauth')->field('Id,title AS topic')->where('tid=0')->select();
			if ($data['tid'] == 0) {
				$mpid = 1;
			} else {
				$mtopic = $this->gettopic('adminauth', $data['tid'], 'title');
				if ($topmenu) {
					foreach ($topmenu as $t => $v) {
						if ($v['Id'] == $data['tid']) $mpid = 2;
					}
				}
				$lid = $data['tid'];
				if ($mpid != 2) $mpid = 3;
				if ($mpid == 3) {
					$mlist = '';
					$tid = $this->gettopic('adminauth', $data['tid'], 'tid');
					$mtopic = $this->gettopic('adminauth', $tid, 'title');
					$lid = $tid;
					$mdata = Db::name('adminauth')->field('title,Id')->where('1=1 AND isspecial=0 AND tid=' . $tid)->order('ord ASC')->select();
					if ($data) {
						foreach ($mdata as $key => $val) {
							$scene = ($val['Id'] == $data['tid']) ? 'success' : 'default';
							$mlist .= '<a href="javascrupt:void(0)" class="btn-menu" data-id="' . $val['Id'] . '">' . btn(array('vals' => $val['title'], 'size' => 3, 'scene' => $scene)) . '</a>&nbsp;';
						}
					}
				}
			}
			return $this->fetch('', ['activeid' => 19, 'mtopic' => $mtopic, 'lid' => $lid, 'mpid' => $mpid, 'title' => '编辑权限信息', 'data' => $data, 'mlist' => $mlist, 'topmenu' => $topmenu]);
		}
		if ($save == '保存栏目') {
			$title = input('post.title', '');
			$icon = input('post.icon', '');
			$linkurl = isset($_POST['linkurl']) ? trim($_POST['linkurl']) : '';
			$pid = input('post.pid', 0, 'intval');
			$mpid = input('post.mpid', 0, 'intval');
			$ord = input('post.ord', 0, 'intval');
			$isopen = input('post.isopen', 0, 'intval');
			$isext = input('post.isext', 0, 'intval');
			$isspecial = input('post.isspecial', 0, 'intval');
			$isimportant = input('post.isimportant', 0, 'intval');
			if ($mpid == 2) $pid = input('post.lid', 0, 'intval');
			$name = $martables = $tables = '';
			$sty = 1;
			if ($linkurl != '') {
				$mlink = explode(",", $linkurl);
				$name = (isset($mlink[0]) && $mlink[0] != '') ? $mlink[0] : '';
				$fields = (isset($mlink[1]) && $mlink[1] != '') ? $mlink[1] : '';
				if ($fields != '') {
					$fields = explode("&", $fields);
					if (count($fields) > 0) {
						foreach ($fields as $mval) {
							if ($mval != '') {
								$vArr = explode("=", $mval);
								if ($vArr[0] == 'martables') {
									$martables = (isset($vArr[1]) && $vArr[1] != '') ? trim($vArr[1]) : '';
								}
								if ($vArr[0] == 'tables') {
									$tables = (isset($vArr[1]) && $vArr[1] != '') ? trim($vArr[1]) : '';
								}
								if ($vArr[0] == 'sty') {
									$sty = (isset($vArr[1]) && $vArr[1] != '') ? intval($vArr[1]) : 0;
								}
							}
						}
					}
				}
			}
			$result = Db::name("adminauth")->where('Id=' . $id)->update(array('title' => $title, 'name' => $name, 'sty' => $sty, 'icon' => $icon, 'isext' => $isext, 'isopen' => $isopen, 'isspecial' => $isspecial, 'martables' => $martables, 'tables' => $tables, 'linkurl' => $linkurl, 'ord' => $ord, 'isimportant' => $isimportant, 'tid' => $pid, 'date' => dates()));
			if ($result) {
				$this->success('数据更新成功');
			} else {
				$this->error('数据更新失败，请重新试试吧');
			}
		}
	}

	public function history()
	{
		$this->pageDisplay(array('title' => '系统登录日志', 'tables' => 'adminrecord', 'order' => 'Id DESC'));
		return $this->fetch();
	}

	public function advlist()
	{
		$ctag = input('ctag', 0, 'intval');
		$enabled = input('enabled', 0, 'intval');
		$topic = input('topic', '');
		$where = '1=1';
		if ($ctag) $where .= ' AND ctag=' . $ctag;
		if ($topic != '') $where .= " AND topic like'%$topic%'";
		if ($enabled == 1) $where .= ' AND enabled=0';
		if ($enabled == 2) $where .= ' AND enabled=1';
		$this->assign('advtype', $this->getSelect('advtype'));
		$this->pageDisplay(array('title' => '广告管理', 'tables' => 'advdata', 'where' => $where, 'order' => 'ctag ASC,ord ASC'));
		return $this->fetch();
	}

	public function advadd()
	{
		$send = input('post.send', '');
		if ($send == "") {
			return $this->fetch('', ['title' => '广告添加', 'activeid' => 97, 'upload' => true,'color'=>true, 'advtype' => $this->getSelect('advtype')]);
		} else if ($send == "提交") {
			$result = Db::name("advdata")->insert($this->fieldArr(array('linkurl', 'pic', 'ctag', 'remark','color', 'picwidth','opentype', 'picheight')));
			if ($result) {
				$this->success('广告添加成功');
			} else {
				$this->error('广告添加失败，请重新试试吧');
			}
		}
	}

	public function advmod()
	{
		$id = input('id', 0, 'intval');
		$save = input('post.send', '');
		if (!$id) $this->error('ID未指定,无法获取任何数据');
		$data = Db::name("advdata")->field('*')->where(array('Id' => $id))->find();
		if (!$data) $this->error('资料不存在，请重新操作！');
		if ($save == '') {
			return $this->fetch('', ['title' => '编辑广告信息', 'activeid' => 97, 'upload' => true,'color'=>true, 'data' => $data, 'advtype' => $this->getSelect('advtype')]);
		} else if ($save == '确定修改') {
			$result = Db::name("advdata")->where('Id', $id)->update($this->fieldArr(array('linkurl', 'ctag', 'color' , 'pic', 'remark','opentype', 'picwidth', 'picheight')));
			if ($result) {
				$this->success('数据更新成功');
			} else {
				$this->error('数据更新失败，请重新试试吧');
			}
		}
	}
	
	public function tdatalist()
	{
		if ( !$this->cksafty() ) $this->redirect('system/tosafty','act=tb');
	    $tb    = input('param.tb','');
		$where = input('param.where','');
		$order = input('param.order','');
		if ( $tb == '' ) $this->error('数据表不存在');
		$tb = str_replace(config('database.prefix'),'',$tb);
		$where = ($where!='') ? $where : '1=1';
		$order = ($order!='') ? $order : 'Id DESC';
		$this->pageDisplay(array('where' => $where, 'tables' => $tb,'order'=>$order,'isdw'=>true));
		return $this->fetch('',['tables'=>$tb,'where'=>$where,'title'=>$tb.'- 资料管理','activeid'=>22,'order'=>$order]);
	}
	
	
	public function struct()
	{
		if ( !$this->cksafty() ) $this->redirect('system/tosafty','act=struct');
	    $tb    = input('param.tb','');
		if ( $tb == '' ) $this->error('数据表不存在');
		$data  = db()->query("SHOW COLUMNS FROM `{$tb}`");
		return $this->fetch('',['tables'=>$tb,'data'=>$data,'title'=>$tb.' 数据结构','activeid'=>22]);
	}
	
	public function tosql()
	{
		$this->assign('title','SQL语法执行器');
		if ( !$this->cksafty() ) $this->redirect('system/tosafty','act=sql');
		if ( $this->req->method() == 'POST' ) {
		  error_reporting(0);
		  $sql = isset( $_POST['sqltext'] ) ? trim($_POST['sqltext']) : '';
		  $sql = str_ireplace('DELETE','[删除]',$sql);
		  $sql = str_ireplace('UPDATE','[更新]',$sql);
		  $sql = str_ireplace('DROP','[删除表]',$sql);
		  if ( $sql == '' ) { $this->error('请输入你需要输入的语法'); die; }
		  $res = @Db::query($sql);
		  return $this->fetch('',['sql'=>$sql,'sqlres'=>$res]);
		} else {
		  return $this->fetch('',['sql'=>'','sqlres'=>'']);
		}
	}
	
	public function tool()
	{
		if ( !$this->cksafty() ) $this->redirect('system/tosafty','act=tool');
		$this->assign('title','在线HTTP POST/GET接口测试工具');
		if ( $this->req->method() == 'POST' ) {
		  $methods = input('post.methods','POST');
		  $url     = input('post.url','');
		  $csm     = isset($_POST['csm']) ? $_POST['csm'] : '';
		  $csz     = isset($_POST['csz']) ? $_POST['csz'] : '';
		  $headcsm = isset($_POST['headcsm']) ? $_POST['headcsm'] : '';
		  $headcsz = isset($_POST['headcsz']) ? $_POST['headcsz'] : '';
		  if ( $methods == '' || $url == '' ) $this->error('参数有误');
		  $postdata = $head = $sheader = [];
		  $str      = '';
		  if ( $csm !='' ) {
		    for( $c=0;$c<count($csm);$c++ ) {
			  $cszz = isset($csz[$c]) ? $csz[$c] : '';
			  $postdata[$csm[$c]] = $cszz;
			  $str .= "&".$csm[$c].'='.$cszz;
			}
		  }
		  $str = ($str!='') ? trim($str,"&") : '';
		  if ( $headcsm !='' ) {
		    for( $h=0;$h<count($headcsm);$h++ ) {
			  $hdz  = isset($headcsz[$h]) ? $headcsz[$h] : '';
			  $head[$headcsm[$h]] = $hdz;
			  $sheader[] = "".$headcsm[$h].": ".$hdz;
			}
		  }
		  $res = '';
		  if ( $methods == 'POST' ) {
			$opts   = [
			  CURLOPT_TIMEOUT        => 1200,
			  CURLOPT_RETURNTRANSFER => 1,
			  CURLOPT_SSL_VERIFYPEER => false,
			  CURLOPT_SSL_VERIFYHOST => false,
			  CURLOPT_HTTPHEADER     => $sheader,
			  CURLOPT_URL            => $url,
			  CURLOPT_POST           => 1,
			  CURLOPT_POSTFIELDS     => json_encode($postdata)
			];
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
			curl_setopt_array($ch, $opts);
			$res   = curl_exec($ch);
			$error = curl_error($ch);
			curl_close($ch);
			$res = json_decode($res, true);
		  } else if ( $methods == 'GET' ) {
			$sendurl = $url .= '?'.$str;
		    $res     = json_decode(file_get_contents($sendurl, true), true);
		  }
		  $resjson = ($res!='' && is_array($res)) ? json_encode($res) : $res;
		  return $this->fetch('',['url'=>$url,'postdata'=>$postdata,'res'=>$res,'resjson'=>$resjson,'head'=>$head,'activeid'=>108,'methods'=>$methods,'sheader'=>$sheader]);
		} else {
		  $id = input('id',0,'intval');
		  $url = '';
		  $postdata = [];
		  $head['Accept'] = 'application/json';
		  $head['Content-Type'] = 'application/json;application/x-www-form-urlencoded';
		  if ( $id ) {
		    $data = Db::name('apirecord')->field('*')->where('Id',$id)->find();
			if ( !$data ) $this->error('无效的接口数据');
			$postdata = ($data['data']!='') ? unserialize($data['data']) : [];
			if ( isset($postdata['token']) ) {
			  $head['Token'] = $postdata['token'];
			  unset($postdata['token']);
			}
			$url  = $data['url'];
		  }
		  return $this->fetch('',['methods'=>'POST','res'=>'','resjson'=>'','url'=>$url,'activeid'=>108,'postdata'=>$postdata,'head'=>$head]);
		}
	}
	
	
  //数据库管理
	public function databackup()
	{
		$send = input('post.send', '');
		if ($send == '') {
			$this->assign('title', '数据库备份');
			if (!$tabarr = cache('tabarr')) {
				$dataArr = array();
				$data = model('Baksql')->getTables();
				if (count($data) > 0) {
					for ($i = 0; $i < count($data); $i++) {
						$tables = $data[$i];
						$dataArr[$i]['table'] = $tables;
						$dataArr[$i]['count'] = Db::name(str_replace(config('database.prefix'), '', $tables))->cache(true, $this->slight)->count();
					}
				}
				$tabarr = $dataArr;
				cache('tabarr', $dataArr, 3600); //缓存字段信息
			}
			if ( !$sdata = cache('table_sdata') ) {
			  $sdata = db()->query("select TABLE_SCHEMA AS tables, concat(truncate(sum(data_length)/1024/1024,2),' MB') as data_size,concat(truncate(sum(index_length)/1024/1024,2),'MB') as index_size from information_schema.tables  where TABLE_SCHEMA = '".config('database.database')."' group by TABLE_SCHEMA order by data_length desc");
			  cache('table_sdata',$sdata);
			}
			return $this->fetch('', ['data' => $tabarr,'sdata'=>$sdata]);
		} else if ($send == "优化") {
			$table = isset($_POST['datebasename']) ? $_POST['datebasename'] : array();
			if (count($table) > 0) {
				foreach ($table as $val) {
					$val = ($val != '') ? str_replace(config('database.prefix'), '', $val) : '';
					Db::query("OPTIMIZE TABLE `$val`");
				}
				$this->success('数据表优化成功！', '', 1);
			} else {
				$this->error('请至少选择一条数据进行操作', url('system/databackup'), 2);
			}
		} else if ($send == "修复") {
			$table = isset($_POST['datebasename']) ? $_POST['datebasename'] : array();
			if (count($table) > 0) {
				foreach ($table as $val) {
					$val = ($val != '') ? str_replace(config('database.prefix'), '', $val) : '';
					Db::query("REPAIR TABLE `$val`");
				}
				$this->success('数据表修复成功！', '', 1);
			} else {
				$this->error('请至少选择一条数据进行操作', url('system/databackup'), 2);
			}
		} else if ($send == "备份") {
			$table = isset($_POST['datebasename']) ? $_POST['datebasename'] : array();
			if (count($table) > 0) {
				$result = model('Baksql')->backtables($table); //备份全部
				if ($result) {
					$this->success('数据库备份成功', url('system/databackup'), 2);
				} else {
					$this->error('数据库备份失败，请重试', url('system/databackup'), 2);
				}
			} else {
				$this->error('请至少选择一个数据表备份', url('system/databackup'), 2);
			}
		}
	}

	public function sysadmin()
	{
		$save = input('post.send', '');
		$protectedPath = array('About', 'App', 'Article', 'BaiHeng', 'Case', 'Contact', 'Index', 'Knowledge', 'News', 'Promotion', 'Qrcode', 'Remittances', 'Service', 'Website', 'bhAdmin');
		if ($save == '') {
			$data = Db::name("systemconfig")->field('adminpath')->where('Id', 1)->find();
			$domain = 'http://' . $_SERVER['HTTP_HOST'] . '/';
			return $this->fetch('', ['title' => '后台目录设置', 'activeid' => 12, 'domain' => $domain, 'data' => $data, 'protectedPath' => $protectedPath]);
		} else if ($save == '确定保存') {
			$adminpath = input('post.adminpath', '');
			$oldadminpath = input('post.oldadminpath', '');
			if ($adminpath == '') $this->error('请填写后台目录保护，必须是英文');
			if ($adminpath == $oldadminpath) $this->error('设置后台目录保护不得和上一次设置目录一致');
			if (in_array($adminpath, $protectedPath)) $this->error($adminpath . '是系统目录，请重新设置');
			$result = Db::name("systemconfig")->where('Id', 1)->update(array('adminpath' => $adminpath));
			if ($result) {
				cache('system_adminpath',null);
				$this->CreateAdmin($adminpath, $oldadminpath);
				$this->success('后台目录设置更新成功');
			} else {
				$this->error('后台目录设置更新失败，请重新试试吧');
			}
		}
	}

	public function clearadmin()
	{
		$data = Db::name("systemconfig")->field('adminpath')->where('Id', 1)->find();
		if ($data['adminpath'] != '') {
			Db::name("systemconfig")->where('Id', 1)->update(array('adminpath' => ''));
			cache('system_adminpath',null);
			unlink(APP_PATH . 'home/Controller/' . ucwords($data['adminpath']) . '.php');
		}
		$this->success('后台目录设置还原成功');
	}


	public function databackuplist()
	{
		$data = $this->getarrays(config("db_backup"));
		$sdata = array();
		if (count($data) > 0) {
			for ($i = 0; $i < count($data); $i++) {
				$sdata[$i]['size'] = (file_exists($data[$i])) ? $this->size(filesize($data[$i])) : 0;
				$sdata[$i]['time'] = date("Y-m-d H:i:s", filectime($data[$i]));
				$sdata[$i]['path'] = str_replace(config("db_backup") . '/', '', $data[$i]);
			}
		}
		krsort($sdata);
		$datauparr = array('isdel' => 1, 'isre' => 0);
		return view('',['title'=>'数据库备份管理','data'=>$sdata,'datasys'=>$datauparr]);
	}

	public function deldataup()
	{
		$delpath = input('delpath', '', false);
		if ($delpath != '') {
			@unlink(config('db_backup') . '/' . $delpath);
			$this->success('数据删除成功', url('system/databackuplist'), 2);
		} else {
			$this->error('数据删除失败，数据不存在，请检查', url('system/databackuplist'), 2);
		}
	}

	public function downdataup()
	{
		$downpath = input('downpath', '', false);
		if ($downpath != '') {
			model('Baksql')->downloadBak(config('db_backup') . '/' . $downpath);
		} else {
			$this->error('数据下载失败，数据不存在，请检查', url('system/databackuplist'), 2);
		}
	}

	public function redataup()
	{
		$repath = input('repath', '', false);
		if ($repath != '') {
			$result = model('Baksql')->recover($repath);
			if ($result) {
				$this->success('备份还原成功', url('bhadmin/index/index'), 2);
			} else {
				$this->error('备份还原失败，请重试', url('bhadmin/index/index'), 2);
			}
		} else {
			$this->error('数据还原失败，数据不存在，请检查', url('bhadmin/system/databackuplist'), 2);
		}
	}

	public function syslogs()
	{
		$pm  = input('param.pm',1,'intval');
		$paths = 'logs'; 
		if ( $pm == 2 ) $paths = 'log'; 
		if (!is_dir('./runtime/'.$paths)) mkdir('./runtime/'.$paths, 0777);
		$upTotal = getAppSize('./runtime/'.$paths.'/');
		$upTotal['size'] = $this->size($upTotal['size']);
		$act   = input('act', 2, 'intval');
		$path  = input('path', '');
		if ( $path !='' ) $act = 1;
		$path  = './runtime/'.$paths.'/' . $path;
		$act   = ($act < 1 || $act > 2) ? 1 : $act;
		$page  = input('page', 1, 'intval');
		if ($act == 1) $scene = array('primary', 'default');
		if ($act == 2) $scene = array('default', 'primary');
		$data  = $this->getarrays($path);
		$count = count($data);
		$pageS = ($act == 2) ? config('adminpage') * 2 : config('adminpage');
		$sdata = array();
		if ($act == 1) {
			$pobj = new \page\AdminPage($count, $pageS);
			$start = explode(",", $pobj->limit);
			$start = isset($start[0]) ? $start[0] : 0;
			$pagesize = ($count >= $pageS * $page) ? $pageS * $page : $count;
			for ($i = $start; $i < $pagesize; $i++) {
				$sdata[$i]['size'] = (file_exists($data[$i])) ? $this->size(filesize($data[$i])) : 0;
				$sdata[$i]['time'] = (file_exists($data[$i])) ? date("Y-m-d H:i:s", filectime($data[$i])) : 0;
				$sdata[$i]['file'] = ($path == './runtime/'.$paths.'/') ? str_replace('./runtime/'.$paths.'//', "", $data[$i]) : str_replace('./runtime/'.$paths.'/', "", $data[$i]);
			}
		}
	    //文件夹模式
		$objfile = array();
		if ($act == 2) {
			$handle = opendir($path);
			$dwsArr = array('.', '..');
			$j = 0;
			while (($file = readdir($handle)) !== false) {
				if (!in_array($file, $dwsArr)) {
					$objfile[$j]['file'] = $file;
					$objfile[$j]['count'] = $this->filecount($path . $file . '/');
					$j++;
				}
			}
			closedir($handle);
		}
	    //ending
		krsort($sdata);
		if (  $pm == 2 ) {
		  $title = [['topic'=>'人工日志','url'=>url('bhadmin/system/syslogs')],['topic'=>'系统日志','url'=>url('bhadmin/system/syslogs','pm=2'),'active'=>1]];
		} else {
		  $title = [['topic'=>'人工日志','active'=>1,'url'=>url('bhadmin/system/syslogs')],['topic'=>'系统日志','url'=>url('bhadmin/system/syslogs','pm=2')]];
		}
		
		$datashow['pageshow'] = ($count > $pageS && $act != 2) ? $pobj->showpage() : '';
		return $this->fetch('', ['dshow' => $datashow, 'file' => $objfile,'title'=>'日志管理', 'data' => $sdata,'pm'=>$pm,'path'=>$path, 'act' => $act, 'upTotal' => $upTotal, 'scene' => $scene,'title'=>$title]);
	}

	public function showlog()
	{
		if ( !request()->isAjax() ) return json('非法操作');
		$path  = isset($_POST['path']) ? $_POST['path'] : '';
		$pm    = input('post.pm',1,'intval');
		$paths = 'logs'; 
		if ( $pm == 2 ) $paths = 'log'; 
		if ($path == '') return json(0);
		if (!file_exists('./runtime/'.$paths.'/' . $path)) return json('文件不存在');
		$fobj    = fopen('./runtime/'.$paths.'/' . $path, 'r');
		$content = '';
		if ($fobj) {
			while (!feof($fobj)) {
				$str = htmlspecialchars(fgets($fobj, 4096));
				$content .= $str;
			}
			fclose($fobj);
			return json($content);
		} else {
			return json('日志打开失败');
		}
	}

	public function syspic()
	{
		$upTotal = getAppSize(config("upload_path"));
		$upTotal['size'] = $this->size($upTotal['size']);
		$act  = input('act', 3, 'intval');
		$path = input('path', '');
		$path = config("upload_path") . 'images/' . $path;
		$act  = ($act < 1 || $act > 4) ? 1 : $act;
		$page = input('page', 1, 'intval');
		if ($act == 1) $scene = array('primary', 'default', 'default');
		if ($act == 2) $scene = array('default', 'primary', 'default');
		if ($act == 3 || $act == 4) $scene = array('default', 'default', 'primary');
		$data  = ($act!=3) ? $this->getarrays($path) : [];
		$count = count($data);
		$pageS = ($act == 2 || $act == 4) ? config('adminpage') * 2 : config('adminpage');
		$sdata = array();
		if ($act != 3) {
			$pobj  = new \page\AdminPage($count, $pageS);
			$start = explode(",", $pobj->limit);
			$start = isset($start[0]) ? $start[0] : 0;
			$pagesize  = ($count >= $pageS * $page) ? $pageS * $page : $count;
			$normalpic = $this->normalpic(array(1 => array('tables' => 'systemconfig', 'field' => 'waterpic,weixinpic')), config('normal_picpath'));
			for ($i = $start; $i < $pagesize; $i++) {
				$sdata[$i]['size'] = (file_exists($data[$i])) ? $this->size(filesize($data[$i])) : 0;
				$sdata[$i]['time'] = date("Y-m-d H:i:s", filectime($data[$i]));
				$sdata[$i]['spic'] = str_replace($path . '/', "", $data[$i]);
				$sdata[$i]['pic']  = $data[$i];
				$rep               = (input('path', '') == '') ? 'images//' : 'images/';
				$sdata[$i]['isou'] = (in_array(str_replace(config("upload_path") . $rep, "", $data[$i]), $normalpic)) ? 1 : 0;
			}
		}
		$objfile = array();
		if ($act == 3) {
			$handle = opendir($path);
			$dwsArr = array('.', '..');
			$j = 0;
			while (($file = readdir($handle)) !== false) {
				if (!in_array($file, $dwsArr)) {
					$objfile[$j]['file'] = $file;
					$objfile[$j]['count'] = $this->filecount($path . $file . '/');
					$j++;
				}
			}
			closedir($handle);
		}
		krsort($sdata);
		$datashow['pageshow'] = ($count > $pageS && $act != 3) ? $pobj->showpage() : '';
		return $this->fetch('', ['dshow' => $datashow, 'file' => $objfile, 'data' => $sdata, 'title' => '图片管理', 'act' => $act, 'upTotal' => $upTotal, 'scene' => $scene]);
	}

	public function sysdelpic()
	{
		$send = input('post.deldata');
		if ($send == "删除" || $send == "选中删除") {
			$delpic = isset($_POST['pubbox']) ? $_POST['pubbox'] : array();
			$succ = 0;
			if (count($delpic) > 0) {
				for ($i = 0; $i < count($delpic); $i++) {
					if (file_exists($delpic[$i])) {
						$succ = @unlink($delpic[$i]) ? $succ + 1 : $succ + 0;
					}
				}
				cache("fileArr", null);
				cache("normalPic", null);
				$this->success('图片操作成功，共计删除图片 ' . $succ . ' 张');
			} else {
				$this->error('请至少选择一条数据操作');
			}
		}
	}

	public function sysdellogs()
	{
		$send = input('post.deldata');
		$type = input('post.type',1,'intval'); //1 logs 2 log系统日志 
		$path = input('post.path','');
		if ($send == "删除") {
			$dellog = isset($_POST['pubbox']) ? $_POST['pubbox'] : array();
			$succ   = 0;
			$dir    = ($type == 1) ? 'logs' : 'log';
			if (count($dellog) > 0) {
				for ($i = 0; $i < count($dellog); $i++) {
					if (file_exists('./runtime/'.$dir.'/' . $dellog[$i])) {
						$succ = @unlink('./runtime/'.$dir.'/' . $dellog[$i]) ? $succ + 1 : $succ + 0;
					}
				}
				cache('system_pic_list'.md5($path).date('Ymd'),null);
				$this->success('日志删除成功，共计删除日志 ' . $succ . ' 篇');
			} else {
				$this->error('请至少选择一条数据操作');
			}
		}
	}

	private function normalpic($addField = array(), $clernArr = array())
	{
		if (cache('normalPic')) return cache('normalPic');
		$tables = model('Baksql')->getTables();
		$normal = array();
		if (count($tables) > 0) {
			foreach ($tables as $val) {
				if ($this->ckfields($val)) {
					$obj = Db::name(str_replace(config('database.prefix'), '', $val));
					$odata = $obj->field('pic')->select();
					if ($odata) {
						foreach ($odata as $okey => $oval) {
							if ($oval['pic'] != '') {
								$normal[] = $oval['pic'];
							}
						}
					}
				}
			}
		}
		if (count($addField) > 0) {
			foreach ($addField as $key => $val) {
				$obj = Db::name($val['tables'])->field($val['field'])->select();
				if ($obj) {
					foreach ($obj as $mkey => $mval) {
						$fieldArr = explode(',', $val['field']);
						if (isset($val['spc']) && $val['spc']) {
							for ($i = 0; $i < count($fieldArr); $i++) {
								$picArr = ($mval[$fieldArr[$i]] != '') ? unserialize($mval[$fieldArr[$i]]) : array();
								if (count($picArr) > 0) {
									for ($j = 0; $j < count($picArr); $j++) {
										$normal[] = $picArr[$j];
									}
								}
							}
						} else {
							for ($i = 0; $i < count($fieldArr); $i++) {
								$normal[] = $mval[$fieldArr[$i]];
							}
						}
					}
				}
			}
		}
		 //文件夹下为非冗余
		if (count($clernArr)) {
			for ($c = 0; $c < count($clernArr); $c++) {
				$folderArr = piclist(config("upload_path") . 'images/' . $clernArr[$c]);
				if (count($folderArr) > 0) {
					for ($j = 0; $j < count($folderArr); $j++) {
						if ($folderArr[$j] != '') {
							$normal[] = str_replace(config("upload_path") . 'images/', "", $folderArr[$j]);
						}
					}
				}
			}
		}
		cache('normalPic', $normal, 3600 * 24);
		return $normal;
	}

	private function ckfields($table, $field = 'pic')
	{
		if ($table == '') return false;
		$fdata = Db::query("SHOW COLUMNS FROM `$table`");
		$fieldarr = array();
		foreach ($fdata as $key => $val) {
			$fieldarr[] = $val['Field'];
		}
		return (in_array($field, $fieldarr)) ? true : false;
	}

}