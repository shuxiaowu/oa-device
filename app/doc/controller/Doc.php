<?php
namespace app\doc\controller;
use think\Controller;

class Doc extends Controller
{

  protected function _initialize()
  {
	$auth = cookie('?'.md5('doc_auth_apier')) ? cookie(md5('doc_auth_apier')) : '';
	if ( $auth == '' || bhmd5($auth,true) != md5(config('md5key').'-auth') ) { 
	  $this->redirect('doc/auth/index');
	}
    $this->assign('base', root() . '/public/doc');
  }

}
