
<i class="nowForm" style="display:none"></i>
<h4 class="title"></h4>
<i class="showtext"></i>
<hr>

<p class="intro"></p>

<hr>

<div class="newuserform">
<table border="1" id="fillform">
    <tbody></tbody>
</table>
<input type="button" value="确认提交" id="submitUserForm">
</div>

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

               submitUserForm();
        },
        error : function(){
            alert('getcurrentform,网络故障请刷新，或重试');
        }

    });
}

//不想写js模板的结果
function strTable(o,s){

    var required = o =="style='display:block'" ? "required" : "unreq";
       
    return '<tr '+o+'><td class="td'+s+'">'+formTitleNameArray[s]+'：<input type="text" class="'+required+' val'+s+'" /></td></tr>';
}


//表格验证
function submitUserForm(){

    var submitUserform = $("#submitUserForm"),
        required = $('.required');

    submitUserform.on('click', function(e){

        e.preventDefault();
        if (required.val()=='') {
           
            alert('您还没有填完哦！');
        }else{

            ajaxSubmitUserForm();

        };

    });
    
}

//输入的数据必须包含 @ 符号和点号(.)。同时，@ 不可以是邮件地址的首字符，并且 @ 之后需有至少一个点号：
//email 验证
function validate_email(field,alerttxt){
    with (field){
        apos = value.indexOf("@");
        dotpos = value.lastIndexOf(".");

        if (apos<1||dotpos-apos<2) {
            alert(alerttxt);
            return false;
        }
        else {
            return true;
        }
    }
}

function validate_form(thisform){
    with (thisform){
        if (validate_email(email,"Not a valid e-mail address!")==false){
            email.focus();
            return false;
        }
    }
}

//validator






//validator
function ajaxSubmitUserForm(){
    jQuery.ajax({
        type  : "get",
        async : true,
        url : 'http://<?=$_SERVER["HTTP_HOST"]?>/weixinsdk/plate/preach/api.php',
        dataType : "jsonp",
        jsonp : "callback",
        data : {
            verify:"adduserform",
            name:escape($('.valname').val()),
            sex:$('.valsex').val(),
            age:$('.valage').val(),
            qq:$('.valqq').val(),
            email:$('.valemail').val(),
            site:$('.valsite').val(),
            job:$('.valjob').val(),
            info:$('.valinfo').val(),
            constellation:$('.valconstellation').val(),
            bd_y:$('.valbd_y').val(),
            bd_m:$('.valbd_m').val(),
            bd_d:$('.valbd_d').val(),
            md5:''
        },
        jsonpCallback : "dataList",
        success : function(dataList){
           if (dataList.code=='200') {
                $('.newuserform').html('<h1>提交成功！</h1>')
           };

        },
        error : function(){
            alert('ajaxSubmitUserForm,网络故障请刷新，或重试');
        }

    });
}

</script>



