<?php
namespace app\bhadmin\controller;

class Files extends Common
{

	public function picupload()
	{
		return json(model('File')->picupload());
	}

	public function fileupload()
	{
		return json(model('File')->fileupload());
	}

	public function editorupload()
	{
		return json(model('File')->editorUpload());
	}

	public function meituxiuxiu()
	{
		$act = input('act', '');
		$pic = input('pic', '');
		$uploadurl = url('bhadmin/files/picupload','','.html',true);
		if ( $pic!='' ) {
		   $pic = request()->domain().root().'/uploads/images/'.$pic;
		   return $this->fetch('mtxiuxiu', ['act' => $act,'pic'=>$pic, 'uploadurl' => $uploadurl]);
		}
		return $this->fetch('meituxiuxiu', ['act' => $act, 'uploadurl' => $uploadurl]);
	}

	public function bhmap()
	{
		return $this->fetch('', ['title' => '百度地图在线制作']);
	}

	public function bhtpl()
	{
		if (!request()->isAjax()) return json(array('state' => 0, 'msg' => '非法操作'));
		$type = input('post.id', 1, 'intval');
		return json(array('state' => 1, 'html' => model('Bhtpl')->gettpl($type)));
	}

	public function wxarticle()
	{
		if (!request()->isAjax()) return json(array('state' => 0, 'msg' => '非法操作'));
		$uri = input('post.url', '');
		if ($uri == '') return json(array('state' => 0, 'topic' => '', 'content' => ''));
		$html = file_get_contents($uri); //
		$html = str_replace("<!--headTrap<body></body><head></head><html></html>-->", "", $html);
		$title = $content = $author = '';
		$state = true;
		if ($html != '') {
			$ql = new \ql\QueryList;
			$data = $ql::Query($html, array('titleTag' => array('title', 'text'), 'author' => array('#post-user', 'text'), 'contentWx' => array('#js_content', 'html'), 'imageWx' => array('img', 'data-src')))->data;
			$title = ($data != '' && isset($data[0]['titleTag'])) ? $data[0]['titleTag'] : '';
			$content = ($data != '' && isset($data[0]['contentWx'])) ? $data[0]['contentWx'] : '';
			$author = ($data != '' && isset($data[0]['author'])) ? $data[0]['author'] : '';
			foreach ($data as $key => $val) {
				if ($val['imageWx'] != '') {
					$pic = $this->downpic($val['imageWx']);
					if ($pic != '') {
						$pic = root() . '/public/kindedit/attached/image/' . $pic;
						$content = str_replace('data-src="' . $val['imageWx'] . '"', 'src="' . $pic . '" class="kind-one-img"', $content);
					}
					$content = str_replace('width: 100%; ', "", $content);
				}
			}
		} else {
			$state = false;
		}
		return json(array('state' => $state, 'topic' => $title, 'content' => $content, 'author' => $author));
	}
  
    //检测敏感词
	public function ckillegalword()
	{
		if (!request()->isAjax()) return json(array('state' => 0, 'msg' => '非法操作'));
		$content = input('post.content', '');
		if ($content == '') return json(array('state' => 0, 'msg' => '请输入检测内容！'));
		$content = strip_tags($content);
		vendor("topthink.think-illegalword.illegalword");
		$word = BH_ILLEGALWORD;
		if ($word == '') return json(array('state' => 0, 'msg' => '无敏感词词库，请完善敏感词库！'));
		$ill = '';
		$illarr = array();
		$word = explode('|', $word);
		foreach ($word as $wv) {
			$content = str_ireplace($wv, '<a href="#">' . $wv . '</a>', $content);
		}
		$illreg = "/<a .*?>.*?<\/a>/";
		preg_match_all($illreg, $content, $illarr);
		if (count($illarr[0]) > 0) {
			foreach ($illarr[0] as $ikey => $ival) {
				$illstr = $ival;
				$illstr = str_ireplace('<a href="#">', '[', $illstr);
				$illstr = str_ireplace('</a>', ']', $illstr);
				$ill .= $illstr;
			}
			return json(array('state' => 2, 'msg' => '检测到' . count($illarr[0]) . '个敏感词，' . $ill));
		} else {
			return json(array('state' => 1, 'msg' => '检测成功，未检测到任何敏感词！'));
		}
	}
  
    //删除敏感词
	public function illegalword()
	{
		if (!request()->isAjax()) return json(array('state' => 0, 'msg' => '非法操作'));
		$content = isset($_POST['content']) ? trim($_POST['content']) : '';
		if ($content == '') return json(array('state' => 0, 'msg' => '请输入检测内容！'));
		vendor("topthink.think-illegalword.illegalword");
		$word = BH_ILLEGALWORD;
		if ($word == '') return json(array('state' => 0, 'msg' => '无敏感词词库，请完善敏感词库！'));
		$word = explode('|', $word);
		foreach ($word as $wv) {
			$content = str_ireplace($wv, '**', $content);
		}
		return json(array('state' => 1, 'html' => $content));
	}

	public function downpic($url = '')
	{
		if ($url == '') return false;
		$path = dirname(THINK_PATH) . '/public/kindedit/attached/';
		$date = date('Ymd');
		if (!is_dir($path . 'image')) {
			@mkdir($path . 'image', 0777, true);
		}
		if (!is_dir($path . 'image/' . $date)) @mkdir($path . 'image/' . $date, 0777, true);
		$file = substr(md5(substr(md5(time() . rand(0, 9999999)), 5, 15)), 8, 15) . '.jpg';
		$savepath = $path . 'image/' . $date . '/' . $file;
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
				return $date . '/' . $file;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	public function filemanger()
	{
		$php_path  = dirname(THINK_PATH) . '/';
		$php_url   = root().'/public/kindedit/';
		$root_path = $php_path . 'public/kindedit/attached/';
		$root_url  = $php_url . 'attached/';
		$ext_arr   = array('gif', 'jpg', 'jpeg', 'png', 'bmp');
		$dir_name  = input('get.dir','');
		$order     = input('get.order','name','strtolower');
		$path      = input('get.path','');
		if (!in_array($dir_name, array('', 'image', 'flash', 'media', 'file'))) {
			echo "Invalid Directory name.";
			exit;
		}
		if ($dir_name !== '') {
			$root_path .= $dir_name . "/";
			$root_url .= $dir_name . "/";
			if (!file_exists($root_path)) {
				mkdir($root_path);
			}
		}
		if ($path == '') {
			$current_path = realpath($root_path) . '/';
			$current_url = $root_url;
			$current_dir_path = '';
			$moveup_dir_path = '';
		} else {
			$current_path = realpath($root_path) . '/' . $_GET['path'];
			$current_url = $root_url . $_GET['path'];
			$current_dir_path = $_GET['path'];
			$moveup_dir_path = preg_replace('/(.*?)[^\/]+\/$/', '$1', $current_dir_path);
		}
		if (preg_match('/\.\./', $current_path)) {
			echo 'Access is not allowed.';
			exit;
		}
		if (!preg_match('/\/$/', $current_path)) {
			echo 'Parameter is not valid.';
			exit;
		}
		if (!file_exists($current_path) || !is_dir($current_path)) {
			echo 'Directory does not exist.';
			exit;
		}
		$file_list = array();
		if ($handle = opendir($current_path)) {
			$i = 0;
			while (false !== ($filename = readdir($handle))) {
				if ($filename{0} == '.') continue;
				$file = $current_path . $filename;
				if (is_dir($file)) {
					$file_list[$i]['is_dir'] = true; //是否文件夹
					$file_list[$i]['has_file'] = (count(scandir($file)) > 2); //文件夹是否包含文件
					$file_list[$i]['filesize'] = 0; //文件大小
					$file_list[$i]['is_photo'] = false; //是否图片
					$file_list[$i]['filetype'] = ''; //文件类别，用扩展名判断
				} else {
					$file_list[$i]['is_dir'] = false;
					$file_list[$i]['has_file'] = false;
					$file_list[$i]['filesize'] = filesize($file);
					$file_list[$i]['dir_path'] = '';
					$file_ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
					$file_list[$i]['is_photo'] = in_array($file_ext, $ext_arr);
					$file_list[$i]['filetype'] = $file_ext;
				}
				$file_list[$i]['filename'] = $filename; //文件名，包含扩展名
				$file_list[$i]['datetime'] = date('Y-m-d H:i:s', filemtime($file)); //文件最后修改时间
				$i++;
			}
			closedir($handle);
		}
		$result = array();
		$result['moveup_dir_path'] = $moveup_dir_path;
		$result['current_dir_path'] = $current_dir_path;
		$result['current_url'] = $current_url;
		$result['total_count'] = count($file_list);
		$result['file_list'] = $file_list;
		return json($result);
	}
	
	//
	public function picmanger()
	{
		$filelist = model('File')->getfilepath();
		$sidebar  = '';
		if ( $filelist ) {
			foreach( $filelist as $fkey=>$fval ) {
				$active = ($fkey == 0) ? 'active' : '';
				$sidebar .= '<a href="javascript:void(0)" class="list-group-item picture-litype '.$active.'" data-path="'.$fval['file'].'">'.$fval['file'].' <span class="badge">'.$fval['count'].'</span></a>';	
			}
		}
		$main = '';
		$file = ($filelist) ? $filelist[0]['file'] : '';
		$piclist  = model('File')->getpic($file);
		 if ( $piclist !='' && count($piclist['sdata']) > 0 ) {
		   foreach( $piclist['sdata'] as $pkey=>$pval ) {
			 $main .=  ($pval['spic']!='') ? '<div class="picdiv picture-fname" data-path="'.$pval['spic'].'"><img src="'.ispic($pval['spic']).'" data-action="zooms"><p title="'.$pval['pic'].'">'.$pval['pic'].'</p><div class="pic-active"></div></div>' : '';
		   }
		}
		$list = $piclist['pagelist'];
		return json(['sidebar'=>$sidebar,'main'=>$main,'file'=>$file,'list'=>$list]);
	}
	

}