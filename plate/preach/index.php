
<i class="nowForm" style="display:none"></i>
<h4 class="title"></h4>
<i class="showtext"></i>
<hr>

<p class="intro"></p>

<hr>

<table border="1">
    <tbody>
        <tr class="header"></tr>
        

    </tbody>
</table>
<script src="http://<?=$_SERVER["HTTP_HOST"]?>/weixinsdk/plate/cssjs/jq2.1.1/jquery-2.1.1.min.js"></script> 
<script src="http://<?=$_SERVER["HTTP_HOST"]?>/weixinsdk/plate/preach/cssjs/common.js"></script>
<script type="text/javascript">
var setShowAll = $('.setShowAll'),
    showtext = $('.showtext'),
    title = $('.title'),
    intro = $('.intro');
var formTitleNameArray={
    'formname':"表格名称",
    'name':'姓名',
    'sex':'性别',
    'age':'年龄',
    'qq':'QQ',
    'email':'邮箱',
    'site':'班级或社团职务',
    'job':'向往的工作',
    'info':'对它的了解',
    'constellation':'星座',
    'bd_y':'出生年',
    'bd_m':'出生月',
    'bd_d':'出生日'
}
//获取 简介设置，标题，详细介绍  getshow
ajaxGetshow(getcurrentform);

//回调，获取管理员设置的 表单详情
function ajaxGetcurrentform(){
    jQuery.ajax({
        type  : "get",
        async : true,
        url : 'http://<?=$_SERVER["HTTP_HOST"]?>/weixinsdk/plate/preach/api.php',
        dataType : "jsonp",
        jsonp : "callback",
        data : {
            verify:"getcurrentform",
           
        },
        jsonpCallback : "dataList",
        success : function(dataList){
           
        },
        error : function(){
            alert('网络故障请刷新，或重试');
        }

    });
}
</script>


