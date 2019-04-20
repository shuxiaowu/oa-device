<?php
namespace app\doc\controller;

use think\Controller;
use think\Cookie;

class Auth extends Controller
{

  protected function _initialize()
  {
	$auth = cookie('?'.md5('doc_auth_apier')) ? cookie(md5('doc_auth_apier')) : '';
	if ( $auth != '' && bhmd5($auth,true) == md5(config('md5key').'-auth') ) { 
	  $this->redirect('doc/index/index');
	}
	$this->assign('base', root() . '/public/doc');
  }
  
  public function index()
  {
    return $this->fetch('',['mark'=>'auth']);
  }
  
  public function ajaxauth()
  {
    if ( !request()->isAjax() ) return json(['state'=>0,'msg'=>'非法操作']); 
	$code = input('post.code','');
	if ( $code == '' ) return json(['state'=>0,'msg'=>'请输入授权码']); 
	if ( md5( $code ) != md5(config('md5key').'-auth') ) return json(['state'=>0,'msg'=>'授权码有误']);
	Cookie::forever(md5('doc_auth_apier'), bhmd5( md5($code) ));
	return json(['state'=>1,'msg'=>'']);
  }
  
}
