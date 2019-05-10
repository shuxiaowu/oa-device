<?php
namespace app\bhadmin\controller;

use think\Controller;
use think\Db;
use think\Request;

class Common extends Controller
{

	protected $req;
	protected $slight;
	protected $adminuid;
	protected $fix;
	public function _initialize()
	{
		if (session('lockuser') && session('lockuser') != '') {
			$this->redirect('Index/lockscreen');
		}
		$this->slight = 30;
		$request = Request::instance();
		$loginstatue = model('AdminUser')->AdminLogin();
		if (!$loginstatue['status']) {
			$this->redirect('index/login');
		} 
		$adminauth  = session('adminauth');
		if (!$admin_conf = cache('admin_conf')) {
			$admin_conf = Db::name("systemconfig")->field('adminpage')->where('Id', 1)->find();
			cache('admin_conf', $admin_conf);
		}
		config('adminpage', $admin_conf['adminpage']);
		if ( !$userAuth = cache('userAuth'.$adminauth['admindepid']) ) {
			$userAuth   = Db::name('admindepartment')->field('auth')->where(array('Id' => $adminauth['admindepid']))->find();
			cache('userAuth'.$adminauth['admindepid'],$userAuth);
		}
		$userAuth   = ($userAuth) ? $userAuth['auth'] : '';
		$actionName = $request->controller() . '/' . $request->action();
		$sty        = input('sty', 1, 'intval');
		$tables     = input('tables', '');
		$martables  = input('martables', '');
		$aid        = $this->isAuth($actionName, $sty, $tables, $martables, $userAuth);
		$topmenuid  = 0;
		if (!$cmenu = cache('cmenu')) {
			$cmenu = Db::name('adminauth')->field('Id,title,icon,isext,linkurl')->where('tid', 0)->order('ord ASC')->select();
			cache('cmenu', $cmenu);
		}
		$topmenuid = ($cmenu) ? $cmenu[0]['Id'] : 0;
		$topmenuid = (session('?topmenuid')) ? session('topmenuid') : $topmenuid;
		
		$this->req = $request;
		$this->fix = config('database.prefix');
		// dump($adminauth);exit;
		$this->adminuid = $adminauth['adminuid'];//id
		$this->adminuser = $adminauth['adminuser'];//用户名
		$this->adminname = $adminauth['adminrealname'];//管理员名字
		$this->admindepid = $adminauth['admindepid'];//部门id
		$this->adminip = $adminauth['adminip'];//管理员ip
		$check = '1=1';
		if($this->admindepid !=1)$check .=' AND adminuid='.$this->adminuid;
		$dengji = Db::name('usecar')->field('Id,licensenum')->where($check)->select();
		$this->assign('dengji',$dengji);
		$this->assign('userid',$this->adminuid);
		$this->assign('topmenuid',$topmenuid);
		$this->assign('cmenu', $cmenu);
		$this->assign('abspath', $this->req->baseFile());
		$this->assign('authid', $this->getMenuId($aid));
		$this->assign('menu', getmenu($topmenuid));
		$this->assign('myauth', getAuth());
		$this->assign('userAuth', $userAuth);
		$this->assign('admindepname', ($adminauth) ? getdata('admindepartment', $adminauth['admindepid']) : '');
		$this->assign('title', config('devcompanyname') . '后台管理');
		$this->assign('adminauth', $adminauth);
	}

	private function isAuth($actionName, $sty = 1, $tables = '', $martables = '', $userAuth = '')
	{
		$cachename = md5($actionName.$sty.$tables.$martables.$userAuth);
		if ( !$adminAuth = cache('adminAuth') ) {
			$adminAuth = Db::name('adminauth')->field('name,Id')->order('Id DESC')->select();	
			cache('adminAuth',$adminAuth);
		}
		if (count($adminAuth) > 0) {
			$auth = array();
			foreach ($adminAuth as $key => $val) {
				if ($val['name'] != '') {
					$auth[] = ucfirst($val['name']);
				}
			}
			if (in_array($actionName, $auth)) {
				$map['name']      = lcfirst($actionName);
				$map['sty']       = $sty;
				$map['tables']    = ($tables == '') ? '' : $tables;
				$map['martables'] = ($martables == '') ? '' : $martables;
				$map['tid'] = array('neq',0);
				if ( !$authId = cache($cachename) ) {
					$authId = Db::name('adminauth')->field('Id,title')->where($map)->find();
					cache($cachename,$authId);
				}
				if ($authId) {
					$id = $authId['Id'];
					if ($id) {
						if ($userAuth == '') $this->error('抱歉，您没有权限浏览 ' . $authId['title'] . ' 栏目', url('index/index'));
						$userAuth = explode(",", $userAuth);
						if (!in_array($id, $userAuth)) $this->error('抱歉，您没有权限浏览 ' . $authId['title'] . ' 栏目', url('index/index'));
						return $id;
					} else {
						return true;
					}
				} else {
					return true;
				}
			} else {
				return true;
			}
		} else {
			return true;
		}
	}

	private function getMenuId($id = 0)
	{
		if ( cache('?sysmenuid'.$id) ) return cache('sysmenuid'.$id);
		$res = array('level' => 0);
		if ($id) {
			$auth = Db::name('adminauth')->field('Id,title,tid')->where(array('Id' => $id))->find();
			if ($auth) {
				if ($auth['tid']) {
					$auth2 = Db::name('adminauth')->field('Id,title,tid')->where(array('Id' => $auth['tid']))->find();
					if ($auth2) {
						if ($auth2['tid']) {
							$auth3 = Db::name('adminauth')->field('Id,title,tid')->where(array('Id' => $auth2['tid']))->find();
							if ($auth3) $res = array('level' => 3, 'id' => $id, 'name' => $auth['title'], 'tname' => $auth2['title'], 'tid' => $auth2['Id'], 'ttname' => $auth3['title'], 'ttid' => $auth3['Id']);
						} else {
							$res = array('level' => 2, 'id' => $id, 'name' => $auth['title'], 'ttname' => $auth2['title'], 'ttid' => $auth2['Id']);
						}
					}
				}
			}
		} else {
			$res = array('level' => 0);
		}
		cache('sysmenuid'.$id,$res);
		return $res;
	}

	protected function delbyid($tables, $id)
	{
		if ($tables != '' && $id != '') {
			$data = Db::name($tables)->where('Id', $id)->find();
			return ($data) ? Db::name($tables)->delete($id) : false;
		}
	}

	protected function gettopic($tables, $id, $field = 'topic')
	{
		if ($tables != '' && $id != 0) {
			$dobj = Db::name($tables)->field($field)->where(array('Id' => $id))->find();
			return ($dobj) ? $dobj[$field] : '--';
		} else {
			return '--';
		}
	}

	protected function getSelect($tables, $sty = 0)
	{
		if ($tables != '') {
			$where = ($sty) ? array('sty' => $sty) : '1=1';
			return Db::name($tables)->field('Id,topic')->where($where)->order('ord ASC')->select();
		} else {
			return false;
		}
	}
    //组合字段 $model 1表示新增2表示修改 action 1表示post 2表示get common 表示导入常用的数据 $add 表示组合数据
	protected function fieldArr($field, $add = array(), $common = true, $model = 1, $action = 1)
	{
		if (count($field) > 0) {
			$data     = array();
			$intArr   = array('ord', 'enabled', 'picwidth', 'picheight', 'istop', 'sty', 'inftype', 'ctag', 'mtag', 'stag', 'isstrong', 'Id', 'ishot', 'hit', 'showtype', 'isimportant'); //表示INT 类型的数据
			$floatArr = array('price'); //表示浮点 类型的数据
			$textArr  = array('content');
			$ival     = ($action == 1) ? input('post.') : input('get.');
			if (!is_array($field)) $field = explode(",", $field);
			foreach ($field as $key => $val) {
				if (in_array($val, $intArr)) {
					$data[$val] = (isset($ival[$val])) ? intval($ival[$val]) : 0;
				} else if (in_array($val, $floatArr)) {
					$data[$val] = (isset($ival[$val])) ? floatval($ival[$val]) : 0;
				} else if (in_array($val, $textArr)) {
					$data[$val] = (isset($ival[$val])) ? cg($val) : '';
				} else {
					$data[$val] = (isset($ival[$val])) ? $ival[$val] : '';
				}
			}
			if ($model == 1 && !in_array('date', $field)) $data['date'] = dates();
			if ($common) {
				if (!in_array('topic', $field)) {
					$data['topic'] = isset($ival['topic']) ? $ival['topic'] : '';
				}
				if (!in_array('ord', $field)) {
					$data['ord'] = isset($ival['ord']) ? intval($ival['ord']) : 0;
				}
				if (!in_array('enabled', $field)) {
					$data['enabled'] = isset($ival['enabled']) ? intval($ival['enabled']) : 0;
				}
			}
			if ($add != '' && count($add) > 0) {
				foreach ($add as $akey => $aval) {
					$data[$akey] = $aval;
				}
			}
			if (in_array('intro', $field) && in_array('content', $field)) {
				$content = ($data['content'] != '') ? mb_substr(strip_tags(trim($data['content'])), 0, 120, 'utf-8') . '...' : '';
				$content = ($content != '') ? str_replace(array("\r\n", "\r", "\n", " ", "&nbsp;", "	"), "", $content) : '';
				if ($data['intro'] == '') {
					$data['intro'] = $content;
				}
			}
			return $data;
		} else {
			return array();
		}
	}

	protected function pageDisplay($conf = array())
	{
		$tables    = isset($conf['tables'])   ? $conf['tables']   : input('param.tables', '');
		$martables = isset($conf['martables'])? $conf['martables'] : input('param.martables', '');
		$mtables   = isset($conf['mtables'])  ? $conf['mtables']  : '';        //二级表
		$stables   = isset($conf['stables'])  ? $conf['stables']  : '';        //3级表
		$where     = isset($conf['where'])    ? $conf['where']    : '1=1';
		$order     = isset($conf['order'])    ? $conf['order']    : 'ord ASC,date DESC';
		$title     = isset($conf['title'])    ? $conf['title']    : '资料管理';
		$sty       = isset($conf['sty'])      ? $conf['sty']      : 0;
		$delid     = isset($conf['delid'])    ? $conf['delid']    : array();
		$ctag      = isset($conf['ctag'])     ? $conf['ctag']     : 'inftype'; //分类字段
		$mtag      = isset($conf['mtag'])     ? $conf['mtag']     : 'mtag';    //二类字段
		$stag      = isset($conf['stag'])     ? $conf['stag']     : 'stag';    //三类字段
		$ctagAs    = isset($conf['ctagAs'])   ? $conf['ctagAs']   : 'inftopic';//分类字段
		$mtagAs    = isset($conf['mtagAs'])   ? $conf['mtagAs']   : 'mtopic';  //分类字段
		$stagAs    = isset($conf['stagAs'])   ? $conf['stagAs']   : 'stopic';  //分类字段
		$systitle  = isset($conf['systitle']) ? $conf['systitle'] : '';        //管理标题
		$subtitle  = isset($conf['subtitle']) ? $conf['subtitle'] : '';        //副标题
		$isdw      = isset($conf['isdw'])     ? $conf['isdw']     : false;     //处理
		$page      = input('page', 1, 'intval');
		$send      = input('post.deldata', '');
		if ($page < 1) $page = 1;
		if ($tables == '') {
			$this->error('数据表为空，无法获取数据', url('index/index'), 2);
			return false;
		} else {
			if ($send == '') {
				$count = Db::name($tables)->where($where)->count();
				$pobj = new \page\AdminPage($count, config('adminpage'));
				$data = Db::name($tables)->where($where)->order($order)->limit($pobj->limit)->select();
				if ($data && $martables != '') {
					foreach ($data as $key => $val) {
						$data[$key][$ctagAs] = $this->gettopic($martables, $val[$ctag]);
						if ($mtables != '' && isset($val[$mtag])) $data[$key][$mtagAs] = $this->gettopic($mtables, $val[$mtag]);
						if ($stables != '' && isset($val[$stag])) $data[$key][$stagAs] = $this->gettopic($stables, $val[$stag]);
					}
				}
				if ($tables == 'adminauth' && !$isdw) {
					if ($data) {
						foreach ($data as $key => $val) {
							$data[$key]['mdata'] = Db::name('adminauth')->field("*")->where('tid=' . $val['Id'])->order('ord ASC')->select();
						}
					}
				}
				$datashow             = array();
				$datashow['pageno']   = ($page - 1) * $pobj->pagesize;
				$datashow['pageshow'] = ($count > config('adminpage')) ? $pobj->showpage() : '';
				$datashow['table']    = $tables;
				$datashow['mdata']    = ($martables != '') ? $this->getSelect($martables, $sty) : '';
				$datashow['martable'] = $martables;
				$this->assign('dshow', $datashow);
				$this->assign('sty', $sty);
				$this->assign('data', $data);
				$this->assign('title', $title);
				$this->assign('systitle', $systitle);
				$this->assign('subtitle', $subtitle);
			} else if ($send == '回收') {
				$deldata = isset($_POST['pubbox']) ? $_POST['pubbox'] : array();
				if (count($deldata) > 0) {
					$delcount = 0;
					foreach ($deldata as $val) {
						$tres = Db::name($tables)->where('Id', $val)->update(['trash' => 1]);
						$delcount += ($tres) ? 1 : 0;
					}
					$this->success('数据操作成功，影响数据' . $delcount . '条');
				} else {
					$this->error('请至少选择一条数据进行操作');
				}
			} else if ($send == '还原') {
				$deldata = isset($_POST['pubbox']) ? $_POST['pubbox'] : array();
				if (count($deldata) > 0) {
					$delcount = 0;
					foreach ($deldata as $val) {
						$tres = Db::name($tables)->where('Id', $val)->update(['trash' => 0]);
						$delcount += ($tres) ? 1 : 0;
					}
					$this->success('数据操作成功，影响数据' . $delcount . '条');
				} else {
					$this->error('请至少选择一条数据进行操作');
				}
			} else if ($send == '删除') {
				$deldata = isset($_POST['pubbox']) ? $_POST['pubbox'] : array();
				if (count($deldata) > 0) {
					$nodelArr = $delid;
					$delcount = 0;
					if ($tables == 'adminuser') {
						$admincount = Db::name($tables)->where('1=1')->count();
						if ($admincount == 1) $this->error('系统检测到您的管理员只有一个，暂不支持删除，请先添加一个管理员吧！');
						if ($admincount == count($deldata)) $this->error('请至少保留一位系统管理用户');
					}
					if (session('deltips') != 1) {
						if (count($deldata) >= config('delmore')) {
							session('isdelmore', $tables);
							session('delmoreuri', $_SERVER['REQUEST_URI']);
							$this->redirect('Index/delmore?tables=' . $tables . '&ids=' . implode('_', $deldata));
							die;
						}
					}
					foreach ($deldata as $val) {
						if (!in_array($val, $nodelArr)) {
							$del = $this->delbyid($tables, $val);
							$delcount += ($del) ? 1 : 0;
						} else {
							$delcount += 0;
						}
					}
					$this->success('数据操作成功，影响数据' . $delcount . '条');
				} else {
					$this->error('请至少选择一条数据进行操作');
				}
		      //删除
			}
		}
	}

	protected function upattr($table, $id, $field, $val)
	{
		if ($table != '' && $id != 0 && $field != '') {
			return (Db::name($table)->where('Id=' . $id)->limit(1)->update(array($field => $val))) ? true : false;
		} else {
			return false;
		}
	}

	protected function dropdown($table)
	{
		if ($table != '') {
			return Db::name($table)->field('topic,Id')->order('ord ASC')->select();
		} else {
			return false;
		}
	}

	protected function CreateAdmin($name, $delname = '')
	{
		$delname  = ($delname != '') ? ucwords($delname) . '.php' : '';
		$filename = ucwords($name) . '.php';
		$filename = APP_PATH . 'home/controller/' . $filename;
		$month  = date('m');
		$bg     = '';
		$scene  = '';
		if ( $month < 4 ) {$bg = 'spring.jpg'; $scene = '惊蛰,桃始华、仓庚鸣、鹰化为鸠';}
		if ( $month > 3 && $month < 7 ) {$bg = 'summer.jpg';$scene = '夏至,鹿角解、蜩始鸣、半夏生';}
		if ( $month > 6 && $month < 10 ) {$bg = 'fall.jpg';$scene = '秋分,雷始收声、蛰虫坯户、水始涸';}
		if ( $month > 9 ){$bg = 'winter.jpg'; $scene = '立冬,水始冰、地始冻、雉入大水为蜃'; }
		$content  = '<?php
				  namespace app\home\controller;
				  use think\Controller;
				  class ' . ucwords($name) . ' extends Controller {
					   public function index(){ 
						 $this->assign("data",array("adminpath"=>""));
						 $this->assign("bg","'.$bg.'");
						 $this->assign("scene","'.$scene.'");
						 return $this->fetch("bhadmin@index/login",[],["__css__"  => "' . root() . '/public/bhadmin/css","__js__"   => "' . root() . '/public/bhadmin/js","__img__"  => "' . root() . '/public/bhadmin/images"]);
					   }
				  }';
		if (!file_exists($filename)) {
			if (file_put_contents($filename, $content)) {
				if ($delname != '') unlink(APP_PATH . 'home/controller/' . $delname);
				return true;
			} else {
				return false;
			}
		}
	}
	
	protected function size($_size)
	{
		$_rand = ceil(($_size / 1024));
		if ($_rand < 1) return $_size . "bit";
		if ($_rand > 1 && $_rand < 1024) return $_rand . "KB";
		if ($_rand > 1024) return ceil(($_rand / 1024)) . "MB";
		if ($_rand == 1) return $_rand . "KB";
		if ($_rand == 1024) return $_rand . "MB";
	}
	
	protected function filecount($path)
	{  
		$handle = opendir($path);
		$f      = 0;
		$dwsArr = array('.', '..');
		while (($file = readdir($handle)) !== false) {
		   if (!in_array($file, $dwsArr)) $f++;
		}
		closedir($handle);
		($f == 0) ? @rmdir($path) : '';
		return $f;
	}
	
	protected static $filepath = array();
	protected function getfile($path)
	{
		global $filepath;
		if ($path == '' || !file_exists($path)) return false;
		foreach (scandir($path) as $afile) {
			if ($afile == '.' || $afile == '..') continue;
			if (is_dir($path . '/' . $afile)) {
				$this->getfile($path . '/' . $afile);
			} else {
				$filepath[] = $path . '/' . $afile;
			}
		}
	}

	protected function getarrays($path)
	{
		if ( cache('system_pic_list'.md5($path).date('Ymd')) ) return cache('system_pic_list'.md5($path).date('Ymd'));
		global $filepath;
		$this->getfile($path);
		cache('system_pic_list'.md5($path).date('Ymd'),$filepath);
		return $filepath;
	}

}