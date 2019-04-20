<?php
namespace app\bhadmin\controller;

use think\Db;

class Admin extends Common
{

	public function switchtab()
	{
		if (request()->isAjax()) {
			$tabid = input('post.id', 1, 'intval');
			session('topmenuid', $tabid);
			return json(['state' => 1, 'msg' => '']);
		} else {
			return json(['state' => 0, 'msg' => '非法操作']);
		}
	}
	
	public function bhcopy()
	{
	    if ( !request()->isAjax() ) return json(['state'=>0,'msg'=>'非法操作']);
		$id = input('post.id',0,'intval');
		$tables = input('post.tables','');
		if ( !$id ) return json(['state'=>0,'msg'=>'数据不存在']);
		if ( $tables == '' ) return json(['state'=>0,'msg'=>'数据不存在']);
		$res = model('tool')->bhcopy(['tables'=>$tables,'where'=>'Id='.$id]);
		if ( $res['state'] == 1 ) {
		  return json(['state'=>1,'msg'=>'']);
		} else {
		  return json(['state'=>0,'msg'=>$res['msg']]);
		}
	}
	
	public function editicon()
	{
		if (!request()->isAjax()) return json(['state' => 0, 'msg' => '非法操作']);
		$id = input('post.id', 0, 'intval');
		$icon = input('post.icon', '');
		$type = input('post.type', 1, 'intval');
		if (!$id || $icon == '') return json(['state' => 0, 'msg' => '请选择图标操作吧']);
		$isext = ($type == 2) ? 1 : 0;
		$res = Db::name('adminauth')->where('Id', $id)->update(['icon' => $icon, 'isext' => $isext]);
		if ($res) {
			return json(['state' => 1, 'msg' => '']);
		} else {
			return json(['state' => 0, 'msg' => '修改失败']);
		}
	}
  
    //修改属性
	public function modattr()
	{
		$tables = input('post.tables', '');
		$field = input('post.field', '');
		$id = input('post.id', 0, 'intval');
		$val = input('post.val', '');
		if ($tables != '' && $field != '' && $id != 0) {
			$dobj = Db::name($tables);
			if ($val != '') {
				$val = intval($val);
				$result = $dobj->where(array('Id' => $id))->update(array($field => $val));
			} else {
				$data = $dobj->field($field)->where(array('Id' => $id))->find();
				if ($data[$field] == 1) {
					$result = $dobj->where(array('Id' => $id))->update(array($field => 0));
				} else {
					$result = $dobj->where(array('Id' => $id))->update(array($field => 1));
				}
			}
			return json($result);
		}
	} 
  
    //获取栏目
	public function getMenu()
	{
		if (request()->isAjax()) {
			$id = input('post.id', 0, 'intval');
			if ($id) {
				$data = Db::name('adminauth')->field('title,Id')->where('1=1 AND tid=' . $id)->order('ord ASC')->select();
				if ($data) {
					$str = '';
					foreach ($data as $key => $val) {
						$str .= '<a href="javascript:void(0)" class="btn-menu" data-id="' . $val['Id'] . '">' . btn(array('vals' => $val['title'], 'size' => 3, 'scene' => 'default')) . '</a>&nbsp;';
					}
					return json($str);
				} else {
					return json('');
				}
			}
		}
	}
  
    //修改字段
	public function modField()
	{
		if (request()->isAjax()) {
			$tables = input('post.tables', '');
			$field = input('post.field', '');
			$id = input('post.id', 0, 'intval');
			$val = input('post.val', '');
			if ($tables != '' && $field != '' && $id != 0) {
				if ($val != '') {
					$result = Db::name($tables)->where(array('Id' => $id))->update(array($field => $val));
					if($tables == 'leveldata'){
					    cache('m_leveldata',null);
					}
					return json($result);
				} else {
					return json(0);
				}
			} else {
				return json(0);
			}
		}
	}
  
    //搜索数据
	public function searchField()
	{
		if (request()->isAjax()) {
			$tables   = input('post.tables', '');
			$field    = input('post.field', '');
			$sfield   = input('post.sfield', '');
			$kwd      = input('post.key', '');
			$addshow  = input('post.addshow', '');
			$bwhere   = input('post.where','',false);
			$bwhere   = ($bwhere!='') ? $bwhere : '1=1';
			$addfield = ($addshow != '') ? ',' . $addshow : '';
			if ($tables == '' || $field == '') return json(0);
			if ($kwd != '') {
				if ($sfield == '') return json(0);
				$sArr = explode(",", $sfield);
				$where = '';
				foreach ($sArr as $k => $v) {
					$where .= " OR $v LIKE '%" . $kwd . "%'";
				}
				$where = ($where != '') ? $bwhere.' AND ('.substr($where, 3, strlen($where)).')' : '';
			} else {
				$where = $bwhere;
			}
			$data = Db::name($tables)->field("Id," . $field . $addfield)->where($where)->order('Id ASC')->limit(20)->select();
			if (!$data) return json(0);
			$str = '';
			foreach ($data as $key => $val) {
				$fields = ($addshow != '' && $val[$addshow] != '') ? ' | ' . $val[$addshow] : '';
				$sdata = ($kwd != '') ? str_replace($kwd, '<font color="red">' . $kwd . '</font>', $val[$field]) : $val[$field];
				$str .= '<li class="active-result" data-id="' . $val['Id'] . '">' . $sdata . $fields . '</li>';
			}
			return json($str);
		}
	}
  
    //修改排序
	public function modord()
	{
		$tables = input('post.tables', '');
		$ord = input('post.ord', 0, 'intval');
		$id = input('post.id', 0, 'intval');
		if ($tables != '' && $id != 0) {
			$result = Db::name($tables)->where("Id", $id)->update(array('ord' => $ord));
			return json($result);
		}
	}
  
    //修复 优化 数据表
	public function setdata()
	{
		$acts = input('post.acts', '');
		$tables = input('post.tables', '');
		$tables = ($tables != '') ? str_replace(config('database.prefix'), '', $tables) : '';
		if ($acts == 'opt') {
			Db::query("OPTIMIZE TABLE `$tables`"); //优化
			return json(1);
		} else if ($acts == 'repair') {
			Db::query("REPAIR TABLE `$tables`"); //修复
			return json(1);
		} else {
			return json(0);
		}
	}
  
    //检测用户是否存在
	public function ckuser()
	{
		$user = input('post.user', '');
		if ($user != '') return json(model("AdminUser")->ckuser($user));
	}
  
    //下拉联动
	public function droplinks()
	{
		$tables = input('post.tables', '');
		$tables2 = input('post.tables2', '');
		$field = input('post.field', '');
		$field2 = input('post.field2', '');
		$id = input('post.id', 0, 'intval');
		if ($tables != '' && $field != '' && $id != 0) {
			$data = Db::name($tables)->field('Id,topic')->where(array($field => $id))->order('ord ASC')->select();
			if ($data) {
				$str = '';
				foreach ($data as $key => $val) {
					$str .= '<li><a href="javascript:void(0)" data-id="' . $val['Id'] . '" data-tables="' . $tables2 . '" data-field="' . $field2 . '"" class="menu-li2">' . $val['topic'] . '</a></li>';
				}
				return json($str);
			} else {
				return json('<li><a href="javascript:void(0)">没有数据</a></li>');
			}
		}
	}
  
    //3级联动
	public function droplinks2()
	{
		$tables = input('post.tables', '');
		$field = input('post.field', '');
		$id = input('post.id', 0, 'intval');
		if ($tables != '' && $field != '' && $id != 0) {
			$data = Db::name($tables)->field('Id,topic')->where(array($field => $id))->order('ord ASC')->select();
			if ($data) {
				$str = '';
				foreach ($data as $key => $val) {
					$str .= '<li><a href="javascript:void(0)" data-id="' . $val['Id'] . '" class="menu-li3">' . $val['topic'] . '</a></li>';
				}
				return json($str);
			} else {
				return json('<li><a href="javascript:void(0)">没有数据</a></li>');
			}
		}
	}
  
  //裁剪
	public function croppic()
	{
		if (request()->isAjax()) {
			$w = input('post.w', 0, 'intval');
			$h = input('post.h', 0, 'intval');
			$x = input('post.x', 0, 'intval');
			$y = input('post.y', 0, 'intval');
			$r = input('post.r', 0, 'intval');
			$path = input('post.path', '');
			$iswater = input('post.iswater', 0, 'intval');
			$delpic = input('post.delpic', 0, 'intval');
			if ($path == '') return json(array('state' => 0, 'msg' => '请上传裁剪的图片'));
			if ($w == 0 || $h == 0) return json(array('state' => 0, 'msg' => '裁剪的宽度和高度不能为0px'));
			$rdata = model("File")->croppic(array('x' => $x, 'y' => $y, 'w' => $w, 'h' => $h, 'r' => $r, 'iswater' => $iswater, 'path' => $path, 'delpic' => $delpic));
			return json($rdata);
		}
	}

	public function getpiclist()
	{
		if (request()->isAjax()) {
			$page = input('post.page', 1, 'intval');
			$ispro = input('post.ispro', 0, 'intval');
			$path = input('post.path', '');
			$psize = ($ispro) ? 18 : 15;
			$data = model('File')->getpic($path, $page, $psize);
			$html = '';
			if ($data['count'] > 0) {
				foreach ($data['sdata'] as $pkey => $pval) {
					$html .= ($pval['spic'] != '') ? '<div class="picdiv picture-fname" data-path="' . $pval['spic'] . '"><img src="' . ispic($pval['spic']) . '" data-action="zooms"><p title="' . $pval['pic'] . '">' . $pval['pic'] . '</p><div class="pic-active"></div></div>' : '';
				}
			}
			return json(array('msg' => '', 'state' => 1, 'html' => $html, 'pagelist' => $data['pagelist']));
		} else {
			return json(array('msg' => '非法调用', 'state' => 0));
		}
	}

	public function lockscreen()
	{
		if (request()->isAjax()) {
			$adminAuth = session('adminauth');
			session('lockrealname', $adminAuth['adminrealname']);
			session('lockuser', $adminAuth['adminuser']);
			return json(1);
		} else {
			$this->error('非法操作');
		}
	}

	public function backtables()
	{
		if (request()->isAjax()) {
			$isbackup = model('Baksql')->backAuto();
			if ($isbackup) {
				return json(array('msg' => '', 'state' => 1));
			} else {
				return json(array('msg' => '自动备份失败，请点击系统设置->数据库备份手动备份数据吧~', 'state' => 0));
			}
		} else {
			return json(array('msg' => '非法调用', 'state' => 0));
		}
	}

	public function tabstate()
	{
		if (request()->isAjax()) {
			$tablist = model('Baksql')->getTables();
			$tab = array();
			if (count($tablist)) {
				foreach ($tablist as $tval) {
					if (cache('backtable' . $tval)) $tab[] = $tval;
				}
			}
			return json(array('msg' => '', 'state' => 1, 'tabdata' => $tab));
		} else {
			return json(array('msg' => '非法调用', 'state' => 0));
		}
	}
  
  //获取TDK
	public function ajaxTdk()
	{
		if (request()->isAjax()) {
			$id = input('post.id', 0, 'intval');
			$tables = input('post.tables', '');
			$data = Db::name('title')->field('*')->where(array('tid' => $id, 'tables' => $tables))->find();
			if ($data) {
				return json(array('msg' => '', 'state' => 1, 'data' => $data));
			} else {
				return json(array('msg' => '无相关数据。', 'state' => 0));
			}
		} else {
			return json(array('msg' => '非法调用', 'state' => 0));
		}
	}
  
  //更新TDK
	public function updateTdk()
	{
		if (request()->isAjax()) {
			$id = input('post.id', 0, 'intval');
			$tables = input('post.tables', '');
			$title = input('post.title', '');
			$keyword = input('post.keyword', '');
			$des = input('post.des', '');
			$data = Db::name('title')->field('*')->where(array('tid' => $id, 'tables' => $tables))->find();
			if ($data) {
				$result = Db::name('title')->where(array('Id' => $data['Id']))->update(array('title' => $title, 'keyword' => $keyword, 'metades' => $des, 'date' => dates()));
			} else {
				$result = Db::name('title')->insert(array('tid' => $id, 'tables' => $tables, 'title' => $title, 'keyword' => $keyword, 'metades' => $des, 'date' => dates()));
			}
			if ($result) {
				return json(array('msg' => '', 'state' => 1));
			} else {
				return json(array('msg' => '更新失败~', 'state' => 0));
			}
		} else {
			return json(array('msg' => '非法调用', 'state' => 0));
		}
	}
  
    //发送测试手机号码
	public function phonetest()
	{
		$phone = input('post.phone', '');
		if ($phone == '') return json('请输入接受短信的手机号码');
		$pset = Db::name("baseconfig")->field('msguser,msgpass,msgsuff')->where('Id', 1)->find();
		if ($pset['msguser'] != '' && $pset['msgpass'] != '' && $pset['msgsuff'] != '') {
			$res = sendmsg($phone, '收到此短信，表示后台短信类目可正常使用，_来自(百恒网络后台管理)');
			return json($res['state']);
		} else {
			return json('短信服务器设置未完全，请填写完全！');
		}
	}
  
    //发送测试邮件
	public function mailtest()
	{
		$mail = input('post.mail', '', '');
		$id = input('post.id', 0, 'intval');
		$topic = input('post.topic', '');
		if ($mail == '') return json('请输入接受邮件的邮箱');
		$mset = Db::name("systemconfig")->field('mailsmtp,mailport,mailname,mailpass')->where('Id', 1)->find();
		if ($mset['mailsmtp'] != '' && $mset['mailport'] != '' && $mset['mailname'] != '' && $mset['mailpass'] != '') {
			if ($id) {
				$data = Db::name('mailtpl')->field('topic,content')->where('Id', $id)->find();
				if (!$data) return json('暂无模板消息');
				$msg = $data['content'];
				$msg = str_ireplace(root() . '/public/kindedit/attached/', config('companyurl') . 'public/kindedit/attached/', $msg);
				$res = sendemail(['title' => $data['topic'], 'msg' => $msg, 'email' => $mail]);
			} else {
				$res = sendemail(['title' => config('companyname') . '邮件测试', 'msg' => '<div style=" border:solid 5px #3399e8;font-family:\'微软雅黑\'; padding:10px; box-sizing:border-box; max-width:640px;"><p style="text-align:center; font-size:20px;color:#379b35; line-height:60px;">邮件服务器配置成功！</p><p style=" color:#666; font-size:12px; text-align:right;">https://www.jxbh.cn</p></div>', 'email' => $mail]);
			}
			return json($res);
		} else {
			return json('邮件服务器设置未完全，请填写完全！');
		}
	}
  
   //查询手机
	public function searchuser()
	{
		$type = input('post.type', 1, 'intval');
		if ($type == 1) $where = '1=1';
		if ($type == 2) $where = '1=1 AND phone<>""';
		if ($type == 3) $where = '1=1 AND email<>""';
		if ($type == 4) $where = '1=1 AND weixinopenid<>""';
		if ($type == 5) $where = '1=1 AND qqopenid<>""';
		$udata = Db::name('user')->field('Id,user,realname,phone,email,weixinname,qqname')->where($where)->select();
		if (!$udata) return json(array('state' => 0, 'msg' => '没有任何数据'));
		$html = '';
		foreach ($udata as $key => $val) {
			$user = ($val['realname'] != '') ? $val['realname'] : $val['user'];
			if ($type == 1 || $type == 2) {
				$phone = ($val['phone'] != '') ? $val['phone'] : '无手机号码';
				$html .= '<div class="bh-uselect udata' . $val['Id'] . '" data-id="' . $val['Id'] . '">' . $user . '</div>';
			} else if ($type == 3) {
				$html .= '<div class="bh-uselect udata' . $val['Id'] . '" data-id="' . $val['Id'] . '" title="' . $user . $val['email'] . '">' . $user . ' : ' . $val['email'] . '</div>';
			} else if ($type == 4) {
				$html .= '<div class="bh-uselect udata' . $val['Id'] . '" data-id="' . $val['Id'] . '">' . $val['weixinname'] . '</div>';
			} else if ($type == 5) {
				$html .= '<div class="bh-uselect udata' . $val['Id'] . '" data-id="' . $val['Id'] . '">' . $val['qqname'] . '</div>';
			}
		}
		return json(array('state' => 1, 'msg' => '', 'html' => $html));
	}
  
    //发送消息
	public function ajaxmsg()
	{
		$type = input('post.type', 1, 'intval');
		$msg = input('post.msg', '');
		$pic = input('post.pic', '');
		$uid = input('post.uid', '');
		$topic = input('post.topic', '');
		if ($pic == '') {
			if ($msg == '') return json(array('state' => 0, 'msg' => '请输入您需要发送想讯息'));
		}
		if ($uid == '') return json(array('state' => 0, 'msg' => '发送对象为空，无法发送'));
		if (count(explode(',', $uid)) > 100 && $type == 2) return json(array('state' => 0, 'msg' => '一次性最多发送100条私信'));
		$udata = Db::name('user')->field('phone,Id,email,user')->where("1=1 AND Id IN($uid)")->order('Id ASC')->select();
		if (!$udata) return json(array('state' => 0, 'msg' => '无发送对象，无法发送'));
		$succ = 0;
		foreach ($udata as $key => $val) {
			if ($type == 1) {
				$res = letter(['msg' => $msg, 'uid' => $val['Id']]);
				$succ += ($res) ? 1 : 0;
			}
			if ($type == 2) {
				$res = sendmsg($val['phone'], $msg);
				$succ += ($res['state']) ? 1 : 0;
			}
			if ($type == 3) {
				$ispic = false;
				if ($pic != '') {
					$msg = $pic;
					$ispic = true;
				}
				$res = sendwxmsg($val['Id'], $msg, $ispic);
				$succ += ($res) ? 1 : 0;
			}
			if ($type == 4) {
				$topic = ($topic == '') ? '系统邮件' : $topic;
				$res = sendemail(['email' => $val['email'], 'title' => $topic, 'msg' => $msg]);
				$succ += ($res) ? 1 : 0;
			}
			if ($type == 5) {
				$res = jpush(['uid' => $val['Id'], 'user' => $val['user'], 'msg' => $msg]);
				$succ += ($res['state']) ? 1 : 0;
			}
		}
		if ($succ == 0) return json(array('state' => 0, 'msg' => '发送失败，请重试'));
		return json(array('state' => 1, 'msg' => '操作成功，本次选择用户 ' . count($udata) . ' 位，成功发送信息 ' . $succ . ' 条'));
	}
	
	
	public function weixintest()
	{
		$wxconf = db('baseconfig')->field('wxappid,wxsecret')->where('Id', 1)->find();
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $wxconf['wxappid'] . "&secret=" . $wxconf['wxsecret'];
		$key = curl_init();
		curl_setopt($key, CURLOPT_URL, $url);
		curl_setopt($key, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($key, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($key, CURLOPT_SSL_VERIFYHOST, false);
		$reslut = curl_exec($key);
		$reslut = json_decode($reslut);
		if (curl_errno($key)) return json(['msg' => curl_error($key), 'statue' => 0]);
		if (isset($reslut->errcode) && $reslut->errcode != '') return json(['msg' => $reslut->errmsg, 'statue' => 0]);
		return json(['state'=>1,'msg'=>'']);
	}
	
	public function ajaxdrops()
	{
	    if(!$this->req->isPost()) return json(array('success'=>0,'msg'=>'非法调用'));
	    $index = input('post.index',0,'intval');
	    $scene = input('post.scene','','strval');
	    $val   = input('post.val',0,'intval');
	    if($scene=='address'){
	        if($index==0){
	            $data = Db::name('district')->field('Id,name as topic')->where(array('level'=>2,'upid'=>$val))->cache(100)->select();
	        }else if($index==1){
	            $data = Db::name('district')->field('Id,name as topic')->where(array('level'=>3,'upid'=>$val))->cache(100)->select();
	        }else if($index==2){
	            $data = Db::name('district')->field('Id,name as topic')->where(array('level'=>4,'upid'=>$val))->cache(100)->select();
	        }else{
	            $data = array();
	        }
	        if(!$data) $data = array();
	        return json(array('success'=>1,'msg'=>'','data'=>$data));
	    }else {
	        return json(array('success'=>0,'msg'=>'非法调用'));
	    }
	}
	//设置会员等级
	public function setuserlevel(){
	    if(!$this->req->isPost()){return json(array('success'=>0,'msg'=>'非法调用'));}
	    $userid = input('post.userid',0,'intval');
	    $levelid = input('post.levelid',0,'intval');
	    $result = Db::name('user')->where(array('Id'=>$userid))->update(array('level'=>$levelid));
	    if($result){
	        return json(array('success'=>1,'msg'=>'设置成功'));
	    }else{
	        return json(array('success'=>0,'msg'=>'设置失败'));
	    }
	}


}