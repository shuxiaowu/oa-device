<?php
namespace app\bhadmin\controller;

use think\Db;

class Assets extends Common
{

	public function assetslist()
	{
		$keyword = input('keyword','');
		$where = '1=1';
		if($this->adminuid!=1)$where .= ' AND adminuid='.$this->adminuid;
		if($keyword!='')$where .=" AND licensenum LIKE '%$keyword%' OR brand LIKE '%$keyword%'";
		// if($keyword!='')$where .="  AND licensenum|brand like '%$keyword'";
		// echo $where;exit;
		$this->pageDisplay(['title'=>'车辆登记','tables'=>'usecar','order'=>'Id DESC','where'=>$where]);
		return $this->fetch();
	}
	
	public function assetsadd()
	{
		$send = input('post.send', '');
		$licensenum = input('post.licensenum', '');
		if ($send == '') {
			return $this->fetch('', ['upload' => true, 'title' => '添加车辆登记','date'=>true,'activeid'=>196]);
		} else {
			if ($send == '确定添加'){
				$islic = Db::name('usecar')->field('Id')->where("licensenum LIKE '%$licensenum%'")->find();
				if($islic){$this->error('添加失败,该车牌已被集团登记', url('assets/assetsadd'));}
				$indata = $this->fieldArr('licensenum,brand,displacement,cartype,seat,price,distance,alldistance,jiayouc,gantongc,safedate,safeprice,purpose,remark',[],false);
				$indata['addtime']  = date('Y-m-d h-i-s',time());
				$indata['adminuid'] = $this->adminuid;//操作人id
				$indata['adminuser'] = $this->adminuser;//用户名
				$indata['adminrealname'] = $this->adminname;//操作人名称
				$indata['admindepid']	= $this->admindepid;//部门id
				$indata['adminip'] = $this->adminip;//ip
				unset($indata['date']);
				$result = Db::name('usecar')->insert($indata);
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
		$tables = 'usecar';
		$id = input('id', 0, 'intval');
		if (!$id) $this->error('ID未指定,无法获取任何数据');
		$data = Db::name($tables)->field('*')->where("Id", $id)->find();
		if (!$data) $this->error('资料不存在，请重新操作！');
		if ($save == '') {
			return $this->fetch('', ['data' => $data,'upload' => true, 'activeid' => 196,'date'=>true, 'title' => '编辑车辆登记']);
		} else if ($save == '确定修改') {
			$indata = $this->fieldArr('licensenum,brand,displacement,cartype,seat,price,distance,alldistance,jiayouc,gantongc,safedate,safeprice,purpose,remark',[],false);
			unset($indata['date']);
			$indata['modtime']  = date('Y-m-d h-i-s',time());
			$result = Db::name($tables)->where("Id", $id)->update($indata);
			if ($result) {
				$this->success('数据更新成功', url('assets/assetslist'));
			} else {
				$this->error('数据更新失败，请重新试试吧', url('assets/assetsmod', 'id=' . $id));
			}
		}
	}
	// 车辆出行
	public function travellist()
	{	$keyword = input('keyword','');
		$licensenum = input('licensenum','');
		$where = '1=1';
		if($this->adminuid!=1)$where .= ' AND adminuid='.$this->adminuid;
		if($keyword!='')$where .=" AND driver LIKE '%$keyword%'";
		if($licensenum !=0) $where .=" AND licensenum=".$licensenum;
		$this->pageDisplay(['title'=>'车辆出行','tables'=>'travel','order'=>'Id DESC','where'=>$where]);
		return $this->fetch();
	}
	
	public function traveladd()
	{
		$send = input('post.send', '');
		$tables = 'travel';
		if ($send == '') {
			return $this->fetch('', ['upload' => true, 'title' => '添加车辆出行','date'=>true,'activeid'=>209]);
		} else {
			if ($send == '确定添加') {
				$indata = $this->fieldArr('licensenum,brand,cartype,driver,diaodu,leavedate,reason,route,distance,enddate,usedep,status,useman,usecount,paichenum,officer',[],false);
				$indata['addtime']  = date('Y-m-d h-i-s',time());
				$indata['adminuid'] = $this->adminuid;//操作人id
				$indata['adminuser'] = $this->adminuser;//用户名
				$indata['adminrealname'] = $this->adminname;//操作人名称
				$indata['admindepid']	= $this->admindepid;//部门id
				$indata['adminip'] = $this->adminip;//ip
				unset($indata['date']);
				$result = Db::name($tables)->insert($indata);
				if ($result) {
					$this->success('添加成功', url('assets/travellist'));
				} else {
					$this->error('添加失败，请重新试试吧', url('assets/traveladd'));
				}
			}
		}
	}
	
	public function travelmod()
	{
		$save = input('post.send', '');
		$tables = 'travel';
		$id = input('id', 0, 'intval');
		if (!$id) $this->error('ID未指定,无法获取任何数据');
		$data = Db::name($tables)->field('*')->where("Id", $id)->find();
		if (!$data) $this->error('资料不存在，请重新操作！');
		if ($save == '') {
			return $this->fetch('', ['data' => $data,'upload' => true, 'activeid' => 209,'date'=>true, 'title' => '编辑车辆出行']);
		} else if ($save == '确定修改') {
			$indata = $this->fieldArr('licensenum,driver,brand,cartype,diaodu,leavedate,reason,route,distance,enddate,usedep,status,useman,usecount,paichenum,officer',[],false);
			unset($indata['date']);
			$indata['modtime']  = date('Y-m-d h-i-s',time());
			$result = Db::name($tables)->where("Id", $id)->update($indata);
			if ($result) {
				$this->success('数据更新成功', url('assets/travellist'));
			} else {
				$this->error('数据更新失败，请重新试试吧', url('assets/travelmod', 'id=' . $id));
			}
		}
	}
		// 车辆维修记录
	public function maintainlist()
	{	$keyword = input('keyword','');
		$licensenum = input('licensenum','');
		$where = '1=1';
		if($this->adminuid!=1)$where .= ' AND adminuid='.$this->adminuid;
		if($licensenum !=0) $where .=" AND licensenum=".$licensenum;
		if($keyword!='')$where .=" AND driver LIKE '%$keyword%'";
		$this->pageDisplay(['title'=>'车辆维修记录','tables'=>'maintain','order'=>'Id DESC','where'=>$where]);
		return $this->fetch();
	}
	
	public function maintainadd()
	{
		$send = input('post.send', '');
		$tables = 'maintain';
		if ($send == '') {
			return $this->fetch('', ['upload' => true, 'title' => '添加车辆维修记录','date'=>true,'activeid'=>210]);
		} else {
			if ($send == '确定添加') {
				$indata = $this->fieldArr('licensenum,driver,brand,cartype,recorder,mtdate,mtproject,mtprice',[],false);
				$indata['addtime']  = date('Y-m-d h-i-s',time());
				$indata['adminuid'] = $this->adminuid;//操作人id
				$indata['adminuser'] = $this->adminuser;//用户名
				$indata['adminrealname'] = $this->adminname;//操作人名称
				$indata['admindepid']	= $this->admindepid;//部门id
				$indata['adminip'] = $this->adminip;//ip
				unset($indata['date']);
				$result = Db::name($tables)->insert($indata);
				if ($result) {
					$this->success('添加成功', url('assets/maintainlist'));
				} else {
					$this->error('添加失败，请重新试试吧', url('assets/maintainadd'));
				}
			}
		}
	}
	
	public function maintainmod()
	{
		$save = input('post.send', '');
		$tables = 'maintain';
		$id = input('id', 0, 'intval');
		if (!$id) $this->error('ID未指定,无法获取任何数据');
		$data = Db::name($tables)->field('*')->where("Id", $id)->find();
		if (!$data) $this->error('资料不存在，请重新操作！');
		if ($save == '') {
			return $this->fetch('', ['data' => $data,'upload' => true, 'activeid' => 210,'date'=>true, 'title' => '编辑车辆维修记录']);
		} else if ($save == '确定修改') {
			$indata = $this->fieldArr('licensenum,driver,recorder,brand,cartype,mtdate,mtproject,mtprice',[],false);
			unset($indata['date']);
			$indata['modtime']  = date('Y-m-d h-i-s',time());
			$result = Db::name($tables)->where("Id", $id)->update($indata);
			if ($result) {
				$this->success('数据更新成功', url('assets/maintainlist'));
			} else {
				$this->error('数据更新失败，请重新试试吧', url('assets/maintainmod', 'id=' . $id));
			}
		}
	}
			// 车辆加油记录
	public function gasrecordlist()
	{	$keyword = input('keyword','');
		$licensenum = input('licensenum','');
		$where = '1=1';
		if($this->adminuid!=1)$where .= ' AND adminuid='.$this->adminuid;
		if($keyword!='')$where .=" AND driver LIKE '%$keyword%'";
		if($licensenum !=0) $where .=" AND licensenum=".$licensenum;
		$this->pageDisplay(['title'=>'车辆登记','tables'=>'gasrecord','order'=>'Id DESC','where'=>$where]);
		return $this->fetch();
	}
	
	public function gasrecordadd()
	{
		$send = input('post.send', '');
		$tables = 'gasrecord';
		if ($send == '') {
			return $this->fetch('', ['upload' => true, 'title' => '添加车辆登记','date'=>true,'activeid'=>213]);
		} else {
			if ($send == '确定添加') {
				$indata = $this->fieldArr('licensenum,driver,brand,cartype,adddate,gastype,gasvolum,address,price,checkman',[],false);
				$indata['addtime']  = date('Y-m-d h-i-s',time());
				$indata['adminuid'] = $this->adminuid;//操作人id
				$indata['adminuser'] = $this->adminuser;//用户名
				$indata['adminrealname'] = $this->adminname;//操作人名称
				$indata['admindepid']	= $this->admindepid;//部门id
				$indata['adminip'] = $this->adminip;//ip
				unset($indata['date']);
				$result = Db::name($tables)->insert($indata);
				if ($result) {
					$this->success('添加成功', url('assets/gasrecordlist'));
				} else {
					$this->error('添加失败，请重新试试吧', url('assets/gasrecordadd'));
				}
			}
		}
	}
	
	public function gasrecordmod()
	{
		$save = input('post.send', '');
		$tables = 'gasrecord';
		$id = input('id', 0, 'intval');
		if (!$id) $this->error('ID未指定,无法获取任何数据');
		$data = Db::name($tables)->field('*')->where("Id", $id)->find();
		if (!$data) $this->error('资料不存在，请重新操作！');
		if ($save == '') {
			return $this->fetch('', ['data' => $data,'upload' => true, 'activeid' => 213,'date'=>true, 'title' => '编辑加油记录']);
		} else if ($save == '确定修改') {
			$indata = $this->fieldArr('licensenum,driver,brand,cartype,gastype,gasvolum,adddate,address,price,checkman',[],false);
			unset($indata['date']);
			$indata['modtime']  = date('Y-m-d h-i-s',time());
			$result = Db::name($tables)->where("Id", $id)->update($indata);
			if ($result) {
				$this->success('数据更新成功', url('assets/gasrecordlist'));
			} else {
				$this->error('数据更新失败，请重新试试吧', url('assets/gasrecordmod', 'id=' . $id));
			}
		}
	}
	// 车辆违章记录
	public function breaklist()
	{	$keyword = input('keyword','');
		$licensenum = input('licensenum','');
		$where = '1=1';
		if($this->adminuid!=1)$where .= ' AND adminuid='.$this->adminuid;
		if($keyword!='')$where .=" AND driver LIKE '%$keyword%'";
		if($licensenum !=0) $where .=" AND licensenum=".$licensenum;
		$this->pageDisplay(['title'=>'车辆违章记录','tables'=>'break','order'=>'Id DESC','where'=>$where]);
		return $this->fetch();
	}
	
	public function breakadd()
	{
		$send = input('post.send', '');
		$tables = 'break';
		if ($send == '') {
			return $this->fetch('', ['upload' => true, 'title' => '添加车辆违章记录','date'=>true,'activeid'=>214,'date'=>true,]);
		} else {
			if ($send == '确定添加') {
				dump($_POST);exit;
				$indata = $this->fieldArr('licensenum,driver,brand,cartype,diaodu,leavedate,reason,route,distance,enddate,usedep,useman,usecount,paichenum,officer',[],false);
				$indata['addtime']  = date('Y-m-d h-i-s',time());
				$indata['adminuid'] = $this->adminuid;//操作人id
				$indata['adminuser'] = $this->adminuser;//用户名
				$indata['adminrealname'] = $this->adminname;//操作人名称
				$indata['admindepid']	= $this->admindepid;//部门id
				$indata['adminip'] = $this->adminip;//ip
				unset($indata['date']);
				$result = Db::name($tables)->insert($indata);
				if ($result) {
					$this->success('添加成功', url('assets/breaklist'));
				} else {
					$this->error('添加失败，请重新试试吧', url('assets/breakadd'));
				}
			}
		}
	}
	
	public function breakmod()
	{
		$save = input('post.send', '');
		$tables = 'break';
		$id = input('id', 0, 'intval');
		if (!$id) $this->error('ID未指定,无法获取任何数据');
		$data = Db::name($tables)->field('*')->where("Id", $id)->find();
		if (!$data) $this->error('资料不存在，请重新操作！');
		if ($save == '') {
			return $this->fetch('', ['data' => $data,'upload' => true, 'activeid' => 214,'date'=>true, 'title' => '编辑车辆违章记录']);
		} else if ($save == '确定修改') {
			$indata = $this->fieldArr('licensenum,driver,brand,cartype,diaodu,leavedate,reason,route,distance,enddate,usedep,useman,usecount,paichenum,officer',[],false);
			unset($indata['date']);
			$indata['modtime']  = date('Y-m-d h-i-s',time());
			$result = Db::name($tables)->where("Id", $id)->update($indata);
			if ($result) {
				$this->success('数据更新成功', url('assets/breaklist'));
			} else {
				$this->error('数据更新失败，请重新试试吧', url('assets/breakmod', 'id=' . $id));
			}
		}
	}
	//保险记录
	public function bxlist()
	{	$keyword = input('keyword','');
		$licensenum = input('licensenum','');
		$where = '1=1';
		if($this->adminuid!=1)$where .= ' AND adminuid='.$this->adminuid;
		if($keyword!='')$where .=" AND driver LIKE '%$keyword%'";
		if($licensenum !=0) $where .=" AND licensenum=".$licensenum;
		$this->pageDisplay(['title'=>'车辆保险记录','tables'=>'baoxian','order'=>'Id DESC','where'=>$where]);
		return $this->fetch();
	}
	
	public function bxadd()
	{
		$send = input('post.send', '');
		$tables = 'baoxian';
		if ($send == '') {
			return $this->fetch('', ['upload' => true, 'title' => '添加车辆保险记录','date'=>true,'activeid'=>218,'date'=>true,]);
		} else {
			if ($send == '确定添加') {
				$indata = $this->fieldArr('licensenum,driver,deadlinestart,deadlineend,price,bxnum,bxname,isaccident,ratio,payloss,remark',[],false);
				$indata['addtime']  = date('Y-m-d h-i-s',time());
				$indata['adminuid'] = $this->adminuid;//操作人id
				$indata['adminuser'] = $this->adminuser;//用户名
				$indata['adminrealname'] = $this->adminname;//操作人名称
				$indata['admindepid']	= $this->admindepid;//部门id
				$indata['adminip'] = $this->adminip;//ip
				unset($indata['date']);
				$result = Db::name($tables)->insert($indata);
				if ($result) {
					$this->success('添加成功', url('assets/bxlist'));
				} else {
					$this->error('添加失败，请重新试试吧', url('assets/bxadd'));
				}
			}
		}
	}
	
	public function bxmod()
	{
		$save = input('post.send', '');
		$tables = 'baoxian';
		$id = input('id', 0, 'intval');
		if (!$id) $this->error('ID未指定,无法获取任何数据');
		$data = Db::name($tables)->field('*')->where("Id", $id)->find();
		if (!$data) $this->error('资料不存在，请重新操作！');
		if ($save == '') {
			return $this->fetch('', ['data' => $data,'upload' => true, 'activeid' => 218,'date'=>true, 'title' => '编辑车辆保险记录']);
		} else if ($save == '确定修改') {
			$indata = $this->fieldArr('licensenum,driver,deadlinestart,deadlineend,price,bxnum,bxname,isaccident,ratio,payloss,remark',[],false);
			unset($indata['date']);
			$indata['modtime']  = date('Y-m-d h-i-s',time());
			$result = Db::name($tables)->where("Id", $id)->update($indata);
			if ($result) {
				$this->success('数据更新成功', url('assets/bxlist'));
			} else {
				$this->error('数据更新失败，请重新试试吧', url('assets/bxmod', 'id=' . $id));
			}
		}
	}
		//车辆年检记录
	public function aslist()
	{	$keyword = input('keyword','');
		$licensenum = input('licensenum','');
		$where = '1=1';
		if($this->adminuid!=1)$where .= ' AND adminuid='.$this->adminuid;
		if($keyword!='')$where .=" AND driver LIKE '%$keyword%'";
		if($licensenum !=0) $where .=" AND licensenum=".$licensenum;
		$this->pageDisplay(['title'=>'车辆年检记录','tables'=>'as','order'=>'Id DESC','where'=>$where]);
		return $this->fetch();
	}
	
	public function asadd()
	{
		$send = input('post.send', '');
		$tables = 'as';
		if ($send == '') {
			return $this->fetch('', ['upload' => true, 'title' => '添加车辆年检记录','date'=>true,'activeid'=>219,'date'=>true,]);
		} else {
			if ($send == '确定添加') {
				$indata = $this->fieldArr('licensenum,driver,post,address,name,phone,agent',[],false);
				$indata['addtime']  = date('Y-m-d h-i-s',time());
				$indata['adminuid'] = $this->adminuid;//操作人id
				$indata['adminuser'] = $this->adminuser;//用户名
				$indata['adminrealname'] = $this->adminname;//操作人名称
				$indata['admindepid']	= $this->admindepid;//部门id
				$indata['adminip'] = $this->adminip;//ip
				unset($indata['date']);
				$result = Db::name($tables)->insert($indata);
				if ($result) {
					$this->success('添加成功', url('assets/aslist'));
				} else {
					$this->error('添加失败，请重新试试吧', url('assets/asadd'));
				}
			}
		}
	}
	
	public function asmod()
	{
		$save = input('post.send', '');
		$tables = 'as';
		$id = input('id', 0, 'intval');
		if (!$id) $this->error('ID未指定,无法获取任何数据');
		$data = Db::name($tables)->field('*')->where("Id", $id)->find();
		if (!$data) $this->error('资料不存在，请重新操作！');
		if ($save == '') {
			return $this->fetch('', ['data' => $data,'upload' => true, 'activeid' => 219,'date'=>true, 'title' => '编辑车辆年检记录']);
		} else if ($save == '确定修改') {
			$indata = $this->fieldArr('licensenum,driver,post,addtrss,name,phone,agent',[],false);
			unset($indata['date']);
			$indata['modtime']  = date('Y-m-d h-i-s',time());
			$result = Db::name($tables)->where("Id", $id)->update($indata);
			if ($result) {
				$this->success('数据更新成功', url('assets/aslist'));
			} else {
				$this->error('数据更新失败，请重新试试吧', url('assets/asmod', 'id=' . $id));
			}
		}
	}
		//车辆节假日封存
	public function seallist()
	{	$keyword = input('keyword','');
		$licensenum = input('licensenum','');
		$where = '1=1';
		if($this->adminuid!=1)$where .= ' AND adminuid='.$this->adminuid;
		if($keyword!='')$where .=" AND driver LIKE '%$keyword%'";
		if($licensenum !=0) $where .=" AND licensenum=".$licensenum;
		$this->pageDisplay(['title'=>'车辆节假日封存','tables'=>'seal','order'=>'Id DESC','where'=>$where]);
		return $this->fetch();
	}
	
	public function sealadd()
	{
		$send = input('post.send', '');
		$tables = 'seal';
		if ($send == '') {
			return $this->fetch('', ['upload' => true, 'title' => '添加车辆节假日封存','date'=>true,'activeid'=>220,'date'=>true,]);
		} else {
			if ($send == '确定添加') {
				$indata = $this->fieldArr('licensenum,fcreson,addtime,fcdatestart,fcdateend,fcpic,agent',[],false);
				$indata['adminuid'] = $this->adminuid;//操作人id
				$indata['adminuser'] = $this->adminuser;//用户名
				$indata['adminrealname'] = $this->adminname;//操作人名称
				$indata['admindepid']	= $this->admindepid;//部门id
				$indata['adminip'] = $this->adminip;//ip
				unset($indata['date']);
				$result = Db::name($tables)->insert($indata);
				if ($result) {
					$this->success('添加成功', url('assets/seallist'));
				} else {
					$this->error('添加失败，请重新试试吧', url('assets/sealadd'));
				}
			}
		}
	}
	
	public function sealmod()
	{
		$save = input('post.send', '');
		$tables = 'seal';
		$id = input('id', 0, 'intval');
		if (!$id) $this->error('ID未指定,无法获取任何数据');
		$data = Db::name($tables)->field('*')->where("Id", $id)->find();
		if (!$data) $this->error('资料不存在，请重新操作！');
		if ($save == '') {
			return $this->fetch('', ['data' => $data,'upload' => true, 'activeid' => 220,'date'=>true, 'title' => '编辑车辆节假日封存']);
		} else if ($save == '确定修改') {
			$indata = $this->fieldArr('licensenum,fcreson,addtime,fcdatestart,fcdateend,fcpic,agent',[],false);
			unset($indata['date']);
			$indata['modtime']  = date('Y-m-d h-i-s',time());
			$result = Db::name($tables)->where("Id", $id)->update($indata);
			if ($result) {
				$this->success('数据更新成功', url('assets/seallist'));
			} else {
				$this->error('数据更新失败，请重新试试吧', url('assets/sealmod', 'id=' . $id));
			}
		}
	}
		//启封申请
	public function qifenglist()
	{	$keyword = input('keyword','');
		$licensenum = input('licensenum','');
		$where = '1=1';
		if($this->adminuid!=1)$where .= ' AND adminuid='.$this->adminuid;
		if($keyword!='')$where .=" AND driver LIKE '%$keyword%'";
		if($licensenum !=0) $where .=" AND licensenum=".$licensenum;
		$this->pageDisplay(['title'=>'车辆启封申请','tables'=>'qifeng','order'=>'Id DESC','where'=>$where]);
		return $this->fetch();
	}
	
	public function qifengadd()
	{
		$send = input('post.send', '');
		$tables = 'qifeng';
		if ($send == '') {
			return $this->fetch('', ['upload' => true, 'title' => '添加启封申请','date'=>true,'activeid'=>221,'date'=>true,]);
		} else {
			if ($send == '确定添加') {
				$indata = $this->fieldArr('licensenum,qfreson,addtime,agent',[],false);
				$indata['adminuid'] = $this->adminuid;//操作人id
				$indata['adminuser'] = $this->adminuser;//用户名
				$indata['adminrealname'] = $this->adminname;//操作人名称
				$indata['admindepid']	= $this->admindepid;//部门id
				$indata['adminip'] = $this->adminip;//ip
				unset($indata['date']);
				$result = Db::name($tables)->insert($indata);
				if ($result) {
					$this->success('添加成功', url('assets/qifenglist'));
				} else {
					$this->error('添加失败，请重新试试吧', url('assets/qifengadd'));
				}
			}
		}
	}
	
	public function qifengmod()
	{
		$save = input('post.send', '');
		$tables = 'qifeng';
		$id = input('id', 0, 'intval');
		if (!$id) $this->error('ID未指定,无法获取任何数据');
		$data = Db::name($tables)->field('*')->where("Id", $id)->find();
		if (!$data) $this->error('资料不存在，请重新操作！');
		if ($save == '') {
			return $this->fetch('', ['data' => $data,'upload' => true, 'activeid' => 221,'date'=>true, 'title' => '编辑启封申请']);
		} else if ($save == '确定修改') {
			$indata = $this->fieldArr('licensenum,qfreson,addtime,agent',[],false);
			unset($indata['date']);
			$indata['modtime']  = date('Y-m-d h-i-s',time());
			$result = Db::name($tables)->where("Id", $id)->update($indata);
			if ($result) {
				$this->success('数据更新成功', url('assets/qifenglist'));
			} else {
				$this->error('数据更新失败，请重新试试吧', url('assets/qifengmod', 'id=' . $id));
			}
		}
	}
	// 车辆月台账记录
	public function tjyuetailist(){
		$danwei = input('danwei',0,'intval');
		$year = input('year','');
		$month = input('month','');
		$checkdate =['1970-10-1',date('Y-m-d H:i:s',time())];
		if($year =='' && $month !=''){
			$checkdate = [date('Y-m-d H:i:s',strtotime(date('Y',time()).'-'.$month.'-01')),date('Y-m-d 24:00:00',strtotime('+1 months',strtotime(date('Y',time()).'-'.$month.'-01')))];
		}
		if($year !='' && $month =='' ){
			$checkdate = [date('Y-m-d H:i:s',strtotime($year.'-01-01')),date('Y-m-d 24:00:00',strtotime('+1 years',strtotime($year.'-01-01')))];
		}
		if($year !='' && $month !=''){
			$checkdate = [date('Y-m-d H:i:s',strtotime($year.'-'.$month)),date('Y-m-d 24:00:00',strtotime('+1 months',strtotime($year.'-'.$month)))];
		}
		$droptype = Db::name('adminuser')->field('Id,realname')->where("1=1 AND depid!=1")->select();
		$where = '1=1';
		if($danwei !=0) $where .=' AND adminuid='.$danwei;
		if($this->adminuid!=1)$where .= ' AND adminuid='.$this->adminuid;
		$datas = DB::name('usecar')->field('*')->where($where)->select();
		foreach ($datas as $key => $value) {
			$datas[$key]['distance'] = Db::name('travel')->field('Id,distance')->whereTime('addtime',$checkdate)->where('1=1 AND licensenum='.$value['Id'])->find();//公里数
			$datas[$key]['mtprice'] = Db::name('maintain')->field('Id,mtprice')->whereTime('addtime',$checkdate)->where('1=1 AND licensenum='.$value['Id'])->find();//保养修理费
			$datas[$key]['gas'] = Db::name('gasrecord')->field('Id,price,gasvolum')->whereTime('addtime',$checkdate)->where('1=1 AND licensenum='.$value['Id'])->find();//用油量
		}
		return $this->fetch('',['danwei'=>$danwei,'year'=>$year,'month'=>$month,'date'=>true,'datas'=>$datas,'upload' => true,'title' => '车辆月台账记录','droptype'=>$droptype]);
	}

}