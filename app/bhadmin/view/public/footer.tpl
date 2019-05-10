<include file="public/pic" />
<script src="__js__/bootstrap.min.js"></script>
<script src="__js__/nifty.min.js"></script>
<notempty name="tag">
    <script src="__js__/tags.min.js"></script>
</notempty>
<script src="__js__/alert.min.js"></script>
<script src="__js__/common.js"></script>
<script src="__js__/zoom.js"></script>
<notempty name="upload">
    <link href="__css__/cropper.css" rel="stylesheet">
    <script src="__js__/jquery.form.js"></script>
    <script src="__js__/cropper.min.js"></script>
</notempty>
<notempty name="color">
    <script src="__js__/color.js"></script>
    <link href="__css__/color.css" rel="stylesheet">
    <script type="text/javascript">
    $(document).ready(function() {
        $('.colorselect').each(function() {
            $(this).minicolors({
                theme: 'bootstrap'
            });
        });
    });
    </script>
</notempty>
<script type="text/javascript">
var img = '__img__';
var abspath = '{$abspath}/bhadmin';
var upfile = '__upfile__';
$(function() {
    $('[data-toggle="tooltip"]').tooltip({ container: 'body' });
    $('[data-toggle="popover"]').popover({ html: true, container: 'html', trigger: 'focus', title: '', 'placement': 'right' });
    var mheight = $(window).height() - 240;
    $('.minheight').css({ 'min-height': mheight });
});
</script>
<notempty name="date">
    <link href="__js__/date/bootstrap-datepicker.css" rel="stylesheet">
    <script src="__js__/date/bootstrap-datepicker.js"></script>
    <link href="__js__/timepicker/bootstrap-timepicker.css" rel="stylesheet">
    <script src="__js__/timepicker/bootstrap-timepicker.js"></script>
    <script>
    $(document).ready(function(e) {

        var dt = new Date();
        var df = dt.getHours() + ':' + dt.getMinutes() + ':' + dt.getSeconds();
        $('.input-date').datepicker({
            format: "yyyy-mm-dd",
            todayBtn: "linked",
            orientation: "auto",
            autoclose: true,
            todayHighlight: true
        });
        $('.input-year').datepicker({
            language: 'zh-CN',
            startView: 'decade',  
            endView: 'decade',
            maxViewMode: 'decade',  
            minViewMode: 'decade',  
            format: 'yyyy',  
            autoclose: true,
            todayHighlight: true
        });
        $('.input-month').datepicker({
            language: 'zh-CN',
            startView: 'month',  
            endView: 'month',
            maxViewMode: 'year',  
            minViewMode: 'year',  
            format: 'mm',  
            autoclose: true,
            todayHighlight: true 
        });
        $('.boottimes').timepicker({});
        var dt = new Date();
        var df = dt.getHours() + ':' + dt.getMinutes() + ':' + dt.getSeconds();
        $('.input-time').datepicker({
            format: "yyyy-mm-dd",
            todayBtn: "linked",
            orientation: "auto",
            autoclose: true,
            todayHighlight: true
        });
    });
    </script>
</notempty>
<notempty name="editor">
    <include file="public/editor" />
</notempty>