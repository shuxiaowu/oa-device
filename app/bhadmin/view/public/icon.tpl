 <?php
  $iconlist  = getconf('icon');
  $sysicon   = array_unique($iconlist['icon']);
  $sysfaicon = array_unique($iconlist['faicon']);
 ?>
 <div class="modal fade" id="iconmodal" tabindex="-1" role="dialog" data-backdrop="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header"><button type="button" class="close btn-bhmap-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title">选择图标</h4></div>
      <div class="modal-body">
        <div>
         <ul class="nav nav-tabs" role="tablist" style="margin-bottom:15px;">
          <li role="presentation" class="active"><a href="#icon1" aria-controls="icon1" role="tab" data-toggle="tab">默认图标库</a></li>
          <li role="presentation"><a href="#icon2" aria-controls="icon2" role="tab" data-toggle="tab">扩展图标库</a></li>
         </ul>
         <div class="tab-content" style="height:400px; overflow:auto;">
           <div role="tabpanel" class="tab-pane active" id="icon1" style="margin:0; padding:0">
             <ul class="tab-icon">
             <volist name="sysicon" id="ic">
               <li data-icon="{$ic}" data-type="1">{:icon($ic)}</li>
             </volist>
             </ul>
           </div>
           <div role="tabpanel" class="tab-pane" id="icon2" style="margin:0; padding:0;height:400px; overflow:auto;">
             <ul class="tab-icon">
             <volist name="sysfaicon" id="fa">
               <li data-icon="{$fa}" data-type="2">{:faicon($fa)}</li>
             </volist>
             </ul>
           </div>
         </div>
        </div>
      </div>
    </div>
  </div>
 </div>
