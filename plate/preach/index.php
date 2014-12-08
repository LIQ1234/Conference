
<i class="nowForm" style="display:none"></i>
<h4 class="title"></h4>
<i class="showtext"></i>
<hr>

<p class="intro"></p>

<hr>

<table border="1" id="fillform">
    <tbody>
        
        

    </tbody>
</table>
<script src="http://<?=$_SERVER["HTTP_HOST"]?>/weixinsdk/plate/cssjs/jq2.1.1/jquery-2.1.1.min.js"></script> 
<script src="http://<?=$_SERVER["HTTP_HOST"]?>/weixinsdk/plate/preach/cssjs/common.js"></script>
<script type="text/javascript">
var setShowAll = $('.setShowAll'),
    showtext = $('.showtext'),
    title = $('.title'),
    intro = $('.intro'),
    fillform = $('#fillform');
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
};
var showTRArray = {
    "1":"style='display:block'",
    "0":"style='display:none'"
};

//获取 简介设置，标题，详细介绍  getshow
ajaxGetshow(ajaxGetcurrentform);

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
            formname:escape($('.nowForm').html())
        },
        jsonpCallback : "dataList",
        success : function(dataList){
           var a = dataList.data[0];
           console.log(a);

           var id = a.id,
               formname = a.formname,
               name = a.name,
               sex = a.sex,
               age = a.age,
               qq = a.qq,
               email = a.email,
               site = a.site,
               job = a.job,
               info = a.info,
               constellation = a.constellation,
               bd_y = a.bd_y,
               bd_m = a.bd_m,
               bd_d = a.bd_d,
               date = a.date,
               str = strTable(showTRArray[name],'name')
                   +strTable(showTRArray[sex],'sex')
                   +strTable(showTRArray[age],'age')
                   +strTable(showTRArray[qq],'qq')
                   +strTable(showTRArray[email],'email')
                   +strTable(showTRArray[site],'site')
                   +strTable(showTRArray[job],'job')
                   +strTable(showTRArray[info],'info')
                   +strTable(showTRArray[constellation],'constellation')
                   +strTable(showTRArray[bd_y],'bd_y')
                   +strTable(showTRArray[bd_m],'bd_m')
                   +strTable(showTRArray[bd_d],'bd_d');


               fillform.children('tbody').append(str);
               fillform.attr('data-formname', formname);
               fillform.attr('data-date', date);


        },
        error : function(){
            alert('getcurrentform,网络故障请刷新，或重试');
        }

    });
}


function strTable(o,s){
return '<tr '+o+'><td>'+formTitleNameArray[s]+'：<input type="text" /></td></tr>';
}
</script>


