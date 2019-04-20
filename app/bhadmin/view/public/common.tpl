<!DOCTYPE html>
<html>
<head>
<include file="public/meta" />
 <link href="__css__/skin.css" rel="stylesheet">
</head>
<body>
<div class="u-container">
  <div class="u-sidebar">
    <div class="u-logo"><a href="{:url('bhadmin/index/index')}"><img src="__img__/logo/adminface.png" alt="百恒后台管理系统"></a></div>
    <ul class="u-siderbar-ul">
      <volist name="cmenu" id="cobj">
        <in name="cobj['Id']" value="$myauth">
         <li <if condition="$topmenuid eq $cobj['Id']">class="u-li-active"</if>>
          <a href="javascript:void(0)" class="u-nav-li" data-id="{$cobj['Id']}" data-uri="{:tplUrl($cobj['linkurl'])}">
          <if condition="$cobj['icon'] neq ''">{$cobj['isext']?faicon($cobj['icon'],'span'):icon($cobj['icon'],'span')}<else/>{:icon('user','span')}</if>
          <font>{$cobj['title']}</font>
          </a>
          </li>
        </in>
      </volist>
    </ul>
    <div class="u-sidebar-bottom"><div style="text-align:center; width:100%;">{$adminauth['adminuser']?:'--'}</div>
      <div class="u-adminuser">
        <h1>{$adminauth['adminuser']}</h1>
        <ul>
          <li><a href="{:url('bhadmin/index/index')}">系统首页</a></li>
          <li><a href="{:url('bhadmin/index/modpass')}">修改密码</a></li>
          <li><a href="http://www.jxbh.cn" target="_blank">关于百恒</a></li>
          <li><a href="javascript:void(0)" class="lockscreen">系统锁屏</a></li>
          <li><a href="{:url('bhadmin/index/logout')}">安全退出</a></li>
        </ul>
      </div>
      <div class="u-arrow-b"></div>
    </div>
  </div>
  <div class="u-siderbar-two">
     <!--<div class="u-siderbar-title">栏目管理</div>-->
     <volist name="menu" id="io">
       <in name="io['Id']" value="$myauth">
         <dl>
           <dt><if condition="$io['icon'] neq ''">{$io['isext']?faicon($io['icon'],'i'):icon($io['icon'],'i')}</if><a href="{:tplUrl($io['linkurl'])}">{$io['title']}</a></dt>
           <if condition="$io['menu'] neq ''">
             <volist name="io['menu']" id="im">
               <in name="im['Id']" value="$myauth">
                 <dd class="u-dd-{$im['Id']}"><a href="{:tplUrl($im['linkurl'])}">{$im['title']}</a></dd>
               </in>
             </volist>
           </if>
         </dl>
       </in>
     </volist>
  </div>
  <div class="u-title">
    <?php 
    if( isset($title) ) {
      if ( is_array($title) ) {
        echo '<dl class="u-title-dl">';
        foreach( $title as $tk=>$tv ) {
          $tactive = (isset($tv['active']) && $tv['active'] == 1) ? 'active' : '';
          echo '<dd class="'.$tactive.'"><a href="'.$tv['url'].'">'.$tv['topic'].'</a></dd>';
        }
        echo '</dl>';
      } else {
        echo $title;
      }
    } else {
      echo '系统设置';
    }
    ?>
    <li><a href="http://www.jxbh.cn" target="_blank"><i class="pli-home"></i> 关于百恒</a></li>
    <li><a href="{:url('bhadmin/index/cleancache')}"><i class="pli-recycling"></i> 清除缓存</a></li>
  </div>
  <div class="u-main"><block name="main"></block></div>
</div>


<block name="bootstrap"></block>
<include file="public/footer" />
<iframe name="{:url('bhadmin/index/loading')}" id="hideframe" width="0" height="0" style="display:none;"></iframe>
<script type="text/javascript">
  window.noread = 0;
  var uadmin = {
    init : function(){
      var w  = $(window).width();
	  var h  = $(window).height();
	  var bw = $('.u-sidebar').width() + $('.u-siderbar-two').width();
	  var bh = $('.u-title').height();
	  $('.u-title,.u-main').width(w-bw-20);
	  $('.u-main').height(h-bh-25);
	  $('.u-title,.u-main').show();
	  window.onresize = function(){ uadmin.init()};
	  $('body').on('click','.u-siderbar-ul li a',function(e){
	    var id  = $(this).data('id');
		var uri = $(this).data('uri');
		if ( uri == 'javascript:void(0)' ) uri = '{:url("bhadmin/index/index")}';
		if ( id ) {
		   $.post('{:url("bhadmin/admin/switchtab")}',{'id':id},function(data){
			 if ( data.state == 1 ) {
			   window.location.href = uri;
			 } else {
			   swal(data.msg,'','error');
			 }
		   },'json');
		}
	  });
	  $('.u-sidebar-bottom').hover(function(){
	    $('.u-adminuser,.u-arrow-b').show();
	  },function(){
	    $('.u-adminuser,.u-arrow-b').hide();
	  });
	  $(".lockscreen").click(function(e) {
		 var $this = $(this);
		 $this.html('<span class="fa fa-spinner fa-spin"></span> 锁屏中..');
		 $.post('{:url("Admin/lockscreen")}',{'act':'lock'},function(data){
		   $this.html('<span class="fa fa-lock"></span> 锁屏');
		   if ( data == 1 ) {
			 window.location.reload();
		   } else {
			 swal(data,'','error');
		   }
		 },'json');
	  });
	  if ( $(".middle-page").length > 0 ) {
	    var pw = $(".middle-page .mypage").width() + 30;
	    $(".middle-page .m-page").show().width(pw).css({'margin':'0px auto','clear':'both','opacity':1});
	  }
	},
	immsg  : function(){
	},
	active : function(){
	  <notempty name="activeid">
        var activeid = {$activeid};
        $(".u-dd-"+activeid).addClass('active');
	  <else/> 
	    var authid = {:json_encode($authid)};
	    if ( authid['level'] == 2 ) {
	      var id = authid['id'];
	      $(".u-dd-"+id).addClass('active-link');
	    } else if ( authid['level'] == 3 ) {
	      var id = authid['id'];
	      $(".u-dd-"+id).addClass('active');
	    }
      </notempty>
	},
  }
  uadmin.init();
  uadmin.active();
</script>
</body>
</html>