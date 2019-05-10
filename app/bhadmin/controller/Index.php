<?php
namespace app\bhadmin\controller;

use think\Controller;
use think\Db;
use think\Request;

class Index extends Controller
{

	protected $req;
	protected $fix;
	public function _initialize()
	{
		$adminauth = session('adminauth');
		$this->req = Request::instance();
		$this->fix = config('database.prefix');
		$this->assign('abspath', $this->req->baseFile());
		$this->assign('title', config('DEVCOMPANYNAME') . '后台管理');
		$this->assign('adminauth', session('adminauth'));
		$topmenuid = 0;
		if (!$cmenu = cache('cmenu')) {
			$cmenu = Db::name('adminauth')->field('Id,title,icon,isext,linkurl')->where('tid', 0)->order('ord ASC')->select();
			cache('cmenu', $cmenu);
		}
		$topmenuid = ($cmenu) ? $cmenu[0]['Id'] : 0;
		$topmenuid = (session('?topmenuid')) ? session('topmenuid') : $topmenuid;
		$this->assign('topmenuid', $topmenuid);
		$this->assign('cmenu', $cmenu);
		$this->assign('myauth', getAuth());
		$this->assign('menu', getMenu($topmenuid));
		$this->assign('admindepname', ($adminauth) ? getdata('admindepartment', $adminauth['admindepid']) : '');
		$this->assign('authid', array('level' => 0));
	}
	
	private function cklogin()
	{
		$loginstatue = model('AdminUser')->AdminLogin();
		if (!$loginstatue['status']) $this->redirect('index/login');
	}

	public function loading()
	{
		$this->cklogin();
		return $this->fetch();
	}
	
	public function player()
	{
		$this->cklogin();
		return $this->fetch();
	}
	
	public function index()
	{
		if (session('lockuser') && session('lockuser') != '') {
			$this->redirect('Index/lockscreen');
		}
		$this->cklogin();
		$times = 150;
		$sys_info = array();
		$sys_info['os']           = PHP_OS;
		$sys_info['web_server']   = $_SERVER['SERVER_SOFTWARE'];
		$sys_info['php_ver']      = PHP_VERSION;
		$sys_info['mysql_ver']    = $this->mysql_version();
		$sys_info['zlib']         = function_exists('gzclose') ? '是' : '否';
		$sys_info['timezone']     = function_exists("date_default_timezone_get") ? date_default_timezone_get() : '无法检测';
		$sys_info['max_filesize'] = ini_get('upload_max_filesize');
		$sys_info['post_maxsize'] = ini_get('post_max_size');
		$gd = gd_info();
		$sys_info['gd']           = $gd['GD Version'];
		$sys_info['domain']       = $_SERVER['HTTP_HOST'];
		$sys_info['memory_limit'] = ini_get('memory_limit');
		$sys_info['max_time']     = @ini_get("max_execution_time") . 's';
		$sys_info['admin_ver']    = config('admin_version');
		$sys_info['admin_update'] = config('admin_update');
		$sys_info['language']     = 'ZH-CN';
		$sys_info['coding']       = 'UTF-8';
		$sys_info['onlinetoday']  = 0;
		$databackup               = getdataup(config("db_backup"));
		$sys_info['backupcount']  = count($databackup); //备份记录
		$sys_infoA = getSeting();
		$disk_size = '未知';
		if (!$disk_size = cache('system_disk_size')) {
			if (function_exists('disk_free_space')) {
				$disk_size = floor(disk_free_space('./') / (1024 * 1024));
				if ($disk_size > 1024) {
					$disk_size = round(floor($disk_size) / (1024), 2) . 'G';
				} else {
					$disk_size = round($disk_size, 2) . 'M';
				}
			}
			cache('system_disk_size', $disk_size);
		}
		$sys_info['disk_size'] = $disk_size;
		$sdata = array();
		if (count($databackup) > 0) {
			for ($i = 0; $i < count($databackup); $i++) {
				$sdata[$i]['time'] = date("Y-m-d H:i:s", filectime($databackup[$i]));
			}
		}
		$sys_info['backuptime'] = isset($sdata[count($databackup) - 1]['time']) ? $sdata[count($databackup) - 1]['time'] : '';
		
		$seting = getseting();
		return $this->fetch('', ['title' => '系统设置', 'sysInfo' => $sys_info,'seting'=>$seting]);
	}

	private function mysql_version()
	{
		if (!$ver = cache('sql_ver')) {
			$version = db()->query("select version() as ver");
			cache('sql_ver', $version[0]['ver']);
			return $version[0]['ver'];
		} else {
			return $ver;
		}
	}

	public function lockscreen()
	{
		$lockuser     = session('lockuser');
		$lockrealname = session('lockrealname');
		if (!$lockuser || $lockuser == '') $this->redirect('index/index');
		$lockrealname = ($lockrealname != '') ? $lockrealname : $lockuser;
		$gdata = $this->getscene();
		return $this->fetch('', ['title' => '系统锁屏', 'lockuser' => $lockuser, 'lockrealname' => $lockrealname,'bg'=>$gdata['bg'],'scene'=>$gdata['scene']]);
	}

	public function ajaxlock()
	{
		if ( !request()->isAjax() ) return json(array('state' => 0, 'msg' => '非法操作'));
		$user = input('post.user', '');
		$pass = input('post.pass', '');
		if ($user != '' && $pass != '') {
			$result = model('AdminUser')->login($user, $pass, 1);
			return json($result);
		} else {
			return json(array('state' => 0, 'msg' => '用户名或者密码为空，请输入。'));
		}
	}
	
	private function getscene()
	{
		// $month  = date('m');
		// $bg     = '';
		// $scene  = '';
		// if ( $month < 4 ) {$bg = 'spring.jpg'; $scene = '惊蛰,桃始华、仓庚鸣、鹰化为鸠';}
		// if ( $month > 3 && $month < 7 ) {$bg = 'summer.jpg';$scene = '夏至,鹿角解、蜩始鸣、半夏生';}
		// if ( $month > 6 && $month < 10 ) {$bg = 'fall.jpg';$scene = '秋分,雷始收声、蛰虫坯户、水始涸';}
		// if ( $month > 9 ){$bg = 'winter.jpg'; $scene = '立冬,水始冰、地始冻、雉入大水为蜃'; }
		$bg = 'summer.jpg';$scene = '';
		return ['bg'=>$bg,'scene'=>$scene];
	}

	public function login()
	{
		$loginstatue = model('AdminUser')->AdminLogin();
		if (!$loginstatue['status']) {
			if ( !$data = cache('system_adminpath') ) {
				$data = Db::name('systemconfig')->field('adminpath')->where('Id', 1)->find();
				cache('system_adminpath',$data);
			}
			$gdata = $this->getscene();
			return $this->fetch('login', ['data' => $data,'bg'=>$gdata['bg'],'scene'=>$gdata['scene']]);
		} else {
			$this->redirect('index/index');
		}
	}

	public function checklogin()
	{
		$user = input('post.user');
		$pass = input('post.pass', '', false);
		$code = input('post.code', '');
		$errorcount = cookie('?'.md5('errorcount')) ? cookie(md5('errorcount')) : 0;
		if ($errorcount >= config('login_error_max')) return json(['state'=>0,'msg'=>'您登录已经连续错误' . config('login_error_max') . '次，请过1小时在试吧！']);
		if ($user != '' && $pass != '' && $code != '') {
			$verify = new \verify\Verify();
			if ($verify->check($code)) {
				return json(model('AdminUser')->login($user, $pass));
			} else {
				return json(['state'=>0,'msg'=>'验证码有误，请重试']);
			}
		} else {
			return json(['state'=>0,'msg'=>'账号，密码，验证码不能为空']);
		}
	}

	public function logincode()
	{
		$config = array('length' => 4, 'useImgBg' => false, 'useNoise' => false, 'useCurve' => true, 'fontttf' => '7.ttf', 'bg' => array('255', '255', '255'), 'imageW' => '97', 'imageH' => '27', 'fontSize' => '13', 'useZh' => false);
		$verify = new \verify\Verify($config);
		ob_clean();
		$verify->entry();
	}

	public function cleancache()
	{
		$this->cklogin();
		if (session('lockuser') && session('lockuser') != '') {
			$this->redirect('Index/lockscreen');
		}
		$this->_rmdirr('./runtime/cache/');
		$this->_rmdirr('./runtime/temp/');
		if(!is_dir('./runtime')) @mkdir('./runtime', 0777, true);
		if(!is_dir('./runtime/logs')) @mkdir('./runtime/logs', 0777, true);
		cache(null);
		$this->success('系统缓存清除成功', url('index/index'), 2);
	}

	private function _rmdirr($dirname)
	{
		if (!file_exists($dirname)) {
			return false;
		}
		if (is_file($dirname) || is_link($dirname)) {
			return unlink($dirname);
		}
		$dir = dir($dirname);
		if ($dir) {
			while (false !== $entry = $dir->read()) {
				if ($entry == '.' || $entry == '..') {
					continue;
				}
				$this->_rmdirr($dirname . DIRECTORY_SEPARATOR . $entry);
			}
		}
		$dir->close();
		return rmdir($dirname);
	}

	public function logout()
	{
		$admin = session('adminauth');
		writelog('adminUser', '应用：账户退出 管理员：' . $admin['adminuser']);
		session('adminauth', null);
		session('loginWarning', null);
		session('passWarning', null);
		session('topmenuid', null);
		session('tabid', null);
		$this->success("账户已安全退出", url("index/login"));
	}

	public function modpass()
	{
		$this->cklogin();
		if (input('post.send') == "修改密码") {
			$oldpass = input('post.pass');
			$newpass = input('post.newpass');
			if ($oldpass != $newpass) {
				$adminauth = session('adminauth');
				if (model("AdminUser")->ckpass($oldpass, $adminauth['adminuid'])) {
					$result = model("AdminUser")->modpass($newpass, $adminauth['adminuid']);
					if ($result) {
						session('loginWarning', null);
						session('passWarning', null);
						$this->success('密码修改成功，下次登录有效', url('index/modpass'), 2);
					} else {
						$this->error('密码修改失败，请重试', url('index/modpass'), 2);
					}
				} else {
					$this->error('抱歉，您输入的旧密码有误，请重新输入', url('index/modpass'), 2);
				}
			} else {
				$this->error('新密码不能和原密码一致', url('index/modpass'), 2);
			}
		} else {
			return $this->fetch('', ['adminauth' => session('adminauth'), 'title' => '修改密码']);
		}
	}

	public function delmore()
	{
		$this->cklogin();
		$ck    = session('isdelmore');//验证
		$uri   = session('delmoreuri');
		$table = input('tables', '');
		$ids   = input('ids', '');
		$send  = input('post.send', '');
		if ($table == '') $this->error('页面失效，请重试');
		if ($ids == '')   $this->error('页面失效，请重试');
		if ($send == '') {
			if ($ck == $table) {
				return $this->fetch('', ['tables' => $table, 'ids' => $ids, 'deltips' => '','title'=>'删除数据提醒', 'uri' => $uri]);
			} else {
				$this->error('页面失效，请重试');
			}
		}
		if ($send != '') {
			$delisshow = input('post.delisshow', 0, 'intval');
			if ($delisshow) session('deltips', 1);
			if ($send == '删除') {
				$deldata = explode("_", $ids);
				$delcount = 0;
				foreach ($deldata as $val) {
					$result = Db::name($table)->where(array('Id' => $val))->limit(1)->delete();
					$delcount += ($result) ? 1 : 0;
				}
				return $this->fetch('', ['deltips' => '数据操作成功，影响数据' . $delcount . '条', 'uri' => $uri]);
			} else {
				header('Location:' . $uri);
				die;
			}
		}
	}

	public function showicon()
	{
		$this->cklogin();
		return $this->fetch();
	}

}
