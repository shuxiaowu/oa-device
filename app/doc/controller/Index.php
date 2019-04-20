<?php
namespace app\doc\controller;
use think\Db;

class Index extends Doc
{

	public function index()
	{
		$conf = getconf('app');
		$appid = ['ios' => md5($conf['api_base'] . '-ios'), 'android' => md5($conf['api_base'] . '-android'), 'xcx' => md5($conf['api_base'] . '-xcx'), 'web' => md5($conf['api_base'] . '-web')];
		if ( !$tdata = cache('doc_token_list') ) {
			$tdata     = Db::name('token')->field('*')->where('enabled',1)->select();
			cache('doc_token_list',$tdata);
		}
		$uri = $conf['api_url'] ? : config('companyurl') . '/';
		return $this->fetch('', ['apiname' => $conf['j_topic'],'mark'=>'index', 'appid' => $appid, 'onlineUrl' => '<font color="green"></font><font color="red">[未上线]</font>', 'loacUrl' => $uri, 'androidName' => '', 'appleName' => '', 'tlist' => $tdata]);
	}
	
	public function upgrade()
	{
		return $this->fetch('',['mark'=>'upgrade']);
	}
	
	//退出
	public function logout()
	{
		cookie(md5('doc_auth_apier'),null);
		$this->redirect('index/index');
	}
	
	public function download()
	{
		return $this->fetch('',['mark'=>'download','domain'=>xcxdomain(),'abspath'=>config('companyurl').'/']);
	}
	
	public function im()
	{
		return $this->fetch('',['mark'=>'im']);
	}
	
	public function record()
	{
		$token   = input('param.token','');
		$type    = input('param.type','');
		$apiname = input('param.apiname','');
		$date    = input('param.date','');
	    $pagesize  = 18;
		$page      = input('param.page',1,'intval');
		if ( !$page || $page < 0 ) $page = 1;
	    $pno       = ($page-1)*$pagesize;
	    $where     = "1=1";
	    if ( $apiname !='' ) $where .= " AND url LIKE '%$apiname%'";
		if ( $type !='' )    $where .= " AND apitype='{$type}'";
	    if ( $date!='' ) {
		  $stime = strtotime(date('Y-m-d 00:00:00',strtotime($date)));
		  $etime = strtotime(date('Y-m-d 24:00:00',strtotime($date)));
		  if ( $stime !='' && $etime!='' ) $where .= " AND date>='$stime' AND date<'$etime'";
	    }
	    $count     = Db('apirecord')->where($where)->count();
	    $page      = new \page\HomePage($count,$pagesize);
	    $data      = Db('apirecord')->field('*')->where($where)->order('Id DESC')->limit($page->limit)->select();
		if ( !$tdata = cache('doc_token_list') ) {
			$tdata     = Db::name('token')->field('*')->where('enabled',1)->select();
			cache('doc_token_list',$tdata);
		}
		$pagelist  = ($count > $pagesize) ? $page->showpage() : '';
		return $this->fetch('',['pno'=>$pno,'mark'=>'record','token'=>$token,'type'=>$type,'data'=>$data,'date'=>$date,'apiname'=>$apiname,'pagelist'=>$pagelist,'tdata'=>$tdata]);
	}
	
	public function ajaxrecord()
	{
		$id = input('post.id', 0, 'intval');
		if ($id) {
			if ( !$data = cache('doc_apirecord'.$id) ) {
				$data = Db::name('apirecord')->field('*')->where('Id', $id)->find();
				cache('doc_apirecord'.$id,$data);
			}
			if ($data) {
				$html = '<div class="alert-apirecord">';
				$html .= '<dd>请求链接：' . $data['url'] . '</dd>';
				$html .= '<dd>请求日期：' . date('Y-m-d H:i:s', $data['date']) . '</dd>';
				$redata = unserialize($data['data']);
				$html .= '<table class="table table-bordered table-hover" style="margin:10px auto 0px auto;">';
				$html .= '<tr class="active"><td>参数</td><td>值</td></tr>';
				foreach ($redata as $key => $val) {
					$html .= '<tr><td>' . $key . '</td><td><div style="width:480px;word-wrap:break-word">' . $val . '</span></td></tr>';
				}
				$html .= '</div>';
				return json(array('state' => 1, 'msg' => '', 'html' => $html));
			} else {
				$html = '<div class="alert alert-danger">暂无数据</div>';
				return json(array('state' => 0, 'msg' => '', 'html' => $html));
			}
		}
	}
	
	public function tool()
	{	
		if ( !$tdata = cache('doc_token_list') ) {
			$tdata     = Db::name('token')->field('*')->where('enabled',1)->select();
			cache('doc_token_list',$tdata);
		}
		if ( request()->method() == 'POST' ) {
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
			$res   = json_decode($res, true);
		  } else if ( $methods == 'GET' ) {
			$sendurl = $url .= '?'.$str;
		    $res     = json_decode(file_get_contents($sendurl, true), true);
		  }
		  $resjson = ($res!='' && is_array($res)) ? json_encode($res) : $res;
		  return $this->fetch('',['url'=>$url,'postdata'=>$postdata,'res'=>$res,'resjson'=>$resjson,'tdata'=>$tdata,'head'=>$head,'methods'=>$methods,'mark'=>'record','sheader'=>$sheader]);
		} else {
		  $id = input('param.id',0,'intval');
		  $url = '';
		  $postdata = [];
		  $head['Accept'] = 'application/json';
		  $head['Content-Type'] = 'application/json;application/x-www-form-urlencoded';
		  if ( $id ) {
		    $data = Db::name('apirecord')->field('*')->where('Id',$id)->cache(true,3600*24*7)->find();
			if ( !$data ) $this->error('无效的接口数据');
			$postdata = ($data['data']!='') ? unserialize($data['data']) : [];
			if ( isset($postdata['token']) ) {
			  $head['Token'] = $postdata['token'];
			  unset($postdata['token']);
			}
			$url  = $data['url'];
		  }
		  return $this->fetch('',['methods'=>'POST','res'=>'','resjson'=>'','url'=>$url,'tdata'=>$tdata,'postdata'=>$postdata,'mark'=>'record','head'=>$head]);
		}
	}

}
