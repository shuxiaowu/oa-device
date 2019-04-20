<?php
namespace app\bhadmin\controller;

use think\Db;

class Assets extends Common
{

	public function assetslist()
	{
		$this->pageDisplay(['title'=>'资产入库','tables'=>'assets','order'=>'Id DESC']);
		return $this->fetch();
	}
	
	public function assetsadd()
	{
		$send = input('post.send', '');
		if ($send == '') {
			return $this->fetch('', ['upload' => true, 'title' => '资产入库','date'=>true,'activeid'=>196]);
		} else {
			if ($send == '确定添加') {
				$indata = $this->fieldArr('devno,devname,devtype,rkdate,devxh,units,source,channel,price,brand,buydate,uselimit,sn,bxsdate,bxedate,pic,remark,devsetup,devsetup2',[],false);
				$indata['addtime']  = time();
				$indata['adminuid'] = $this->adminuid;
				$indata['addtype']	= 1;
				unset($indata['date']);
				$result = Db::name('assets')->insert($indata);
				if ($result) {
					$this->success('添加成功', url('assets/assetslist'));
				} else {
					$this->error('添加失败，请重新试试吧', url('assets/assetsadd'));
				}
			}
		}
	}
	
	public function assetsmod()
	{
		$save = input('post.send', '');
		$tables = 'assets';
		$id = input('id', 0, 'intval');
		if (!$id) $this->error('ID未指定,无法获取任何数据');
		$data = Db::name($tables)->field('*')->where("Id", $id)->find();
		if (!$data) $this->error('资料不存在，请重新操作！');
		if ($save == '') {
			return $this->fetch('', ['data' => $data,'upload' => true, 'activeid' => 196,'date'=>true, 'title' => '编辑资产']);
		} else if ($save == '确定修改') {
			$indata = $this->fieldArr('devno,devname,devtype,rkdate,devxh,units,source,channel,price,brand,buydate,uselimit,sn,bxsdate,bxedate,pic,remark,devsetup,devsetup2',[],false);
			unset($indata['date']);
			$indata['modtime']  = time();
			$result = Db::name($tables)->where("Id", $id)->update($indata);
			if ($result) {
				$this->success('数据更新成功', url('assets/assetslist'));
			} else {
				$this->error('数据更新失败，请重新试试吧', url('assets/assetsmod', 'id=' . $id));
			}
		}
	}
	
	public function pdlist()
	{
		$this->pageDisplay(['title'=>'资产盘点','tables'=>'assetspd','order'=>'Id DESC']);
		return $this->fetch();
	}
	
	public function pdadd()
	{
		$send = input('post.send', '');
		if ($send == '') {
			return $this->fetch('', ['title' => '新建盘点任务','date'=>true,'activeid'=>202]);
		} else {
			if ($send == '提交') {
				$indata = $this->fieldArr('topic,adminuid,sdate,edate,remark',[],false);
				$indata['sn'] = mksn('PD');
				$result = Db::name('assetspd')->insert($indata);
				if ($result) {
					$this->success('添加成功', url('assets/pdlist'));
				} else {
					$this->error('添加失败，请重新试试吧', url('assets/pdlist'));
				}
			}
		}
	}
	
	public function pdmod()
	{
		$save = input('post.send', '');
		$tables = 'assetspd';
		$id = input('id', 0, 'intval');
		if (!$id) $this->error('ID未指定,无法获取任何数据');
		$data = Db::name($tables)->field('*')->where("Id", $id)->find();
		if (!$data) $this->error('资料不存在，请重新操作！');
		if ($save == '') {
			return $this->fetch('', ['data' => $data,'activeid' => 202,'date'=>true, 'title' => '编辑资产']);
		} else if ($save == '确定修改') {
			$indata = $this->fieldArr('topic,adminuid,sdate,edate,remark',[],false);
			$result = Db::name($tables)->where("Id", $id)->update($indata);
			if ($result) {
				$this->success('数据更新成功', url('assets/pdlist'));
			} else {
				$this->error('数据更新失败，请重新试试吧', url('assets/pdmod', 'id=' . $id));
			}
		}
	}
	
	//盘点结果
	public function pdresult()
	{
		$sn = input('sn','');
		if ( $sn == '' ) $this->error('请选择盘点任务！');
		$this->pageDisplay(['title'=>'资产盘点-单号：'.$sn,'where'=>['pdsn'=>$sn],'tables'=>'pdrecord','order'=>'Id DESC']);
		return $this->fetch('',['activeid'=>202]);
	}
	//资产统计
	public function tjlist()
	{
		$this->pageDisplay(['title'=>'资产统计','tables'=>'assetspd','order'=>'Id DESC']);
		return $this->fetch();
	}
	//资产查询
	public function querylist()
	{
		$this->pageDisplay(['title'=>'资产查询','tables'=>'','order'=>'Id DESC']);
		return $this->fetch();
	}
	//出库领用
	public function chukulist()
	{
		$this->pageDisplay(['title'=>'出库领用','tables'=>'chuku','order'=>'Id DESC']);
		return $this->fetch();
	}
	public function chukuadd()
	{
		$send = input('post.send', '');
		if ($send == '') {
			return $this->fetch('', ['title' => '新建领用出库','date'=>true,'activeid'=>198]);
		} else {
			if ($send == '确定添加') {
				$indata = $this->fieldArr('branch,recipient,applydate,remark,state,lingdate,guihuan',[],false);
				$indata['danhao'] = mksn('DH');
				$result = Db::name('chuku')->insert($indata);
				if ($result) {
					$this->success('添加成功', url('assets/chukulist'));
				} else {
					$this->error('添加失败，请重新试试吧', url('assets/chukulist'));
				}
			}
		}
	}
	public function chukumod()
	{
		$save = input('post.send', '');
		$tables = 'chuku';
		$id = input('id', 0, 'intval');
		if (!$id) $this->error('ID未指定,无法获取任何数据');
		$data = Db::name($tables)->field('*')->where("Id", $id)->find();
		if (!$data) $this->error('资料不存在，请重新操作！');
		if ($save == '') {
			return $this->fetch('', ['data' => $data,'activeid' => 198,'date'=>true, 'title' => '编辑']);
		} else if ($save == '确定添加') {
			$indata = $this->fieldArr('danhao,branch,recipient,applydate,remark,state,lingdate,guihuan',[],false);
			$result = Db::name($tables)->where("Id", $id)->update($indata);
			if ($result) {
				$this->success('数据更新成功', url('assets/chukulist'));
			} else {
				$this->error('数据更新失败，请重新试试吧', url('assets/chulumod', 'id=' . $id));
			}
		}
	}
	//转移管理
	public function movelist()
	{
		// $this->pageDisplay(['title'=>'转移管理','tables'=>'','order'=>'Id DESC']);
		return $this->fetch();
	}
	public function moveadd()
	{
		$save = input('post.send', '');
		if ($save == '') {
			return $this->fetch('', ['activeid' => 199,'date'=>true, 'title' => '编辑']);
		}
	}
	//调拨管理
	public function tiaobolist()
	{
		// $this->pageDisplay(['title'=>'调拨管理','tables'=>'','order'=>'Id DESC']);
		return $this->fetch();
	}
	public function tiaoboadd()
	{
		$save = input('post.send', '');
		if ($save == '') {
			return $this->fetch('', ['activeid' => 200,'date'=>true, 'title' => '编辑']);
		}
	}
	//报修管理
	public function baoxiulist()
	{
		// $this->pageDisplay(['title'=>'报修管理','tables'=>'','order'=>'Id DESC']);
		return $this->fetch();
	}
	public function baoxiuadd()
	{
		$save = input('post.send', '');
		if ($save == '') {
			return $this->fetch('', ['activeid' => 201,'date'=>true, 'title' => '编辑']);
		}
	}
	//折旧管理
	public function zhejiulist()
	{
		// $this->pageDisplay(['title'=>'折旧管理','tables'=>'','order'=>'Id DESC']);
		return $this->fetch();
	}
	public function zhejiuadd()
	{
		$save = input('post.send', '');
		if ($save == '') {
			return $this->fetch('', ['activeid' => 203,'date'=>true, 'title' => '编辑']);
		}
	}
	//车辆管理
	public function cheguanlist()
	{
		// $this->pageDisplay(['title'=>'车辆管理','tables'=>'','order'=>'Id DESC']);
		return $this->fetch();
	}
	public function cheguanadd()
	{
		$save = input('post.send', '');
		if ($save == '') {
			return $this->fetch('', ['activeid' => 204,'date'=>true, 'title' => '编辑']);
		}
	}
	//报废管理
	public function baofeilist()
	{
		// $this->pageDisplay(['title'=>'报废管理','tables'=>'','order'=>'Id DESC']);
		return $this->fetch();
	}
	public function baofeiadd()
	{
		$save = input('post.send', '');
		if ($save == '') {
			return $this->fetch('', ['activeid' => 205,'date'=>true, 'title' => '编辑']);
		}
	}
	//设备列表
	public function equiplist()
	{
		// $this->pageDisplay(['title'=>'报废管理','tables'=>'','order'=>'Id DESC']);
		return $this->fetch();
	}
	public function equipadd()
	{
		$save = input('post.send', '');
		if ($save == '') {
			return $this->fetch('', ['activeid' => 205,'date'=>true, 'title' => '编辑']);
		}
	}
	//保养记录
	public function baoyanglist()
	{
		// $this->pageDisplay(['title'=>'报废管理','tables'=>'','order'=>'Id DESC']);
		return $this->fetch();
	}
	public function baoyangadd()
	{
		$save = input('post.send', '');
		if ($save == '') {
			return $this->fetch('', ['activeid' => 205,'date'=>true, 'title' => '编辑']);
		}
	}
}