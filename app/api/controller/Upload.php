<?php
namespace app\api\controller;

use think\Controller;
use think\Request;
use think\Db;

class Upload extends Api
{
   
    //上传图片
	public function uploadPic()
	{
		$sformat = input('post.pic', '');
		if ($sformat == '') $this->apiReturn('', 0, '图片为空，无法保存');
		$pic = explode("#", $sformat);
		$piclist = '';
		if (count($pic)) {
			foreach ($pic as $val) {
				$res = $this->savePic($val);
				if ($res['state']) $piclist .= $res['file'] . ',';
			}
		}
		$piclist = ($piclist != '') ? trim($piclist, ",") : '';
		$this->apiReturn(['pic' => $piclist]);
	}
   
    //上传
	public function uploadFormPic()
	{
		$data       = $this->uploadSet();
		$exts       = ($data['picsuffix'] != '') ? $data['picsuffix'] : 'jpg,gif,png,jpeg';
		$maxSize    = ($data['picsize']) ? intval($data['picsize']) * 1024 : 1024 * 1024 * 1024 * 10;
		$uploadname = 'Filedata';
		$file = request()->file($uploadname);
		$validate = array('size' => $maxSize, 'ext' => $exts);
		$movepath = '';
		$dpath = date('Ymd');
		$movepath = ROOT_PATH . config('upload_path') . 'images';
		$movepaths = $movepath . '/' . $dpath;
		$info = $file->rule('uniqid')->validate($validate)->move($movepaths);
		if ($info) {
			$imgPath = $dpath . '/' . $info->getSaveName();
			$this->apiReturn(['pic' => $imgPath]);
		} else {
			$this->apiReturn('', 0, $file->getError());
		}
	}
   
    //获取配置
	private function uploadSet()
	{
		if (!$data = cache('systemconfig_upload')) {
			$data = Db::name('systemconfig')->field('iswater,fontpos,waterpos,waterpic,fonttext,fontsize,fontcolor,facetype,rotation,wateralpha,picsuffix,filesuffix,picsize,filesize,picmaxwidth,picmaxsize,cropwidth')->where('Id', 1)->find();
			cache('systemconfig_upload', $data);
		}
		return $data;
	}

}
