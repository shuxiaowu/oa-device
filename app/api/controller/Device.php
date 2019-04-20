<?php
namespace app\api\controller;

use think\Controller;
use think\Db;

class Device extends Api
{
	
	//上报设备信息
	public function report()
	{
		$name  = input('post.name','');
		$devno = input('post.devno','');
		$sn    = input('post.sn','');
		if ( $sn == '' ) $sn = 'PD2019040916125785352';
		if ( $devno == '' )  $this->ApiReturn('', 0, '请上报设备编号');
		$isone = Db::name('pdrecord')->where(['pdsn'=>$sn,'devno'=>$devno])->find();
		if ( !$isone ) {
			$inres = Db::name('pdrecord')->insert(['pdsn'=>$sn,'devno'=>$devno,'pdtime'=>time(),'adminuid'=>0]);
			if ($inres) {
				$this->ApiReturn();
			} else {
				$this->ApiReturn('', 0, '请上报设备编号');
			}
		}
		$this->ApiReturn();
	}	
	
	public function task(){
		$list = Db::name('assetspd')->field('topic,sn')->select();
		$this->ApiReturn($list);
	}
3
}
