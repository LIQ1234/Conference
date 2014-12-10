<?php

//调试
/*session_start();
include_once 'function.php';
include_once '../../include/common.php';
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
?>
<script src="http://<?=$_SERVER["HTTP_HOST"]?>/weixinsdk/plate/cssjs/jq1.7.1/jquery-1.7.1.min.js"></script> 
<?php*/
//调试结束


//增加管理员：
$disPlay = 'none';
$applydis = 'none';
$adminname = '';
$applydis_c = 'none';

if (isset($_POST['adminaction'])) {
    $disPlay = 'block';
    $adminaction = $_POST['adminaction'];
    //账号属性
    $adminname = $_POST['adminname'];
    $admindate =  date("Y-m-d H:i:s",time());
    //执行插入
    $sql = "INSERT INTO `hs_admin` (`name`, `date`)";
    $sql .= "VALUES ('".$adminname."', '".$admindate."')";

    $row = sql_insert_update_delete($sql);
}

//保存表单设置
if (isset($_POST['newapplyaction'])) {
    
    $newapplyaction = $_POST['newapplyaction'];
    //表格属性
    $newapplyname = iconv('UTF-8', 'GBK', $_POST['newapplyname']);
    $applydate =  date("Y-m-d H:i:s",time());
    //前台表格属性：
    $name           = $_POST['name'];
    $sex            = $_POST['sex'];
    $age            = $_POST['age'];
    $qq             = $_POST['qq'];
    $email          = $_POST['email'];
    $site           = $_POST['site'];
    $job            = $_POST['job'];
    $info           = $_POST['info'];
    $constellation  = $_POST['constellation'];
    $bd_y           = $_POST['bd_y'];
    $bd_m           = $_POST['bd_m'];
    $bd_d           = $_POST['bd_d'];

    //选择数据库表 hs_setform 的 formname 判断是否重名
    $sqlApplyName = "SELECT * FROM `hs_setform` WHERE formname = '".$newapplyname."' ";
    $resultApplyName = sql_select($sqlApplyName);

    //有重名更新
    if (isset($resultApplyName)) {

        $updateApplyForm = "UPDATE hs_setform SET name = '".$name."', sex = '".$sex."', age = '".$age."', qq = '".$qq."', email = '".$email."', site = '".$site."', job = '".$job."', info = '".$info."', constellation = '".$constellation."', bd_y = '".$bd_y."', bd_m = '".$bd_m."', bd_d = '".$bd_d."' WHERE formname = '".$newapplyname."' ";
        sql_insert_update_delete($updateApplyForm);
        //操作提示
        $applydis_c = 'block';
        $applydis = 'none';

    }else{
        //没有重名执行插入
        $applysql = "INSERT INTO `hs_setform` (`formname`, `name`, `sex`, `age`, `qq`, `email`, `site`, `job`, `info`, `constellation`, `bd_y`, `bd_m`, `bd_d`, `date`)";
        $applysql .= "VALUES ('".$newapplyname."', '".$name."', '".$sex."', '".$age."', '".$qq."', '".$email."', '".$site."', '".$job."','".$info."', '".$constellation."', '".$bd_y."', '".$bd_m."', '".$bd_d."', '".$applydate."')";

        $applyrow = sql_insert_update_delete($applysql);
        //操作提示
        $applydis = 'block';
    }


}


?>



<style type="text/css">
.none{display: none;}
.block{display: block;}
</style> 

<h2>增加管理员</h2>
<form id="addadmin" name="addadmin" method="post" action="" onSubmit="return checkadmin()">
    <input name="adminaction" type="hidden" value="adminaction" />
    <p>用户名：
        <input type="text" name="adminname" value="">    
        <input type="submit" name="button" id="button" value=" 提 交 " />
        <em>注：一定要确保该管理员的微信号正确</em>
    </p>
    <p style="display:<?=$disPlay?>">已经增加管理员：<?=$adminname?>，操作时间：<?=$admindate?></p>
</form>


    
<h2>设置前台显示的表单、简介，标题，详细介绍等</h2>

<h4>表单设置</h4>
<p>当前已有 <b class="allformNum"> </b>份表单的设置，请选择，你需要的表单展示，或者重新创建表单</p>
<form id="allform" name="allform" >
    <div>
        <p>已有表单：</p>
        <select name="allformshow">
            <option value="0">载入中……</option>
        </select>
        
        <span> 即：访客扫描二维码后 看到需要填写的表单</span>
    </div>
    
    <div>
        <p>当前选中的表单功能：</p>
        <table border="1" class="showcurrent">
            <tr>
                <td>姓名</td>
                <td>性别</td>
                <td>年龄</td>
                <td>qq</td>                
                <td>邮箱</td>       
                <td>座位</td>
                <td>工作</td>
                <td>格言</td>
                <td>星座</td>
                <td>出生年</td>
                <td>出生月</td>
                <td>出生日</td>
            </tr>

        </table>
    </div> 

</form>
<hr>
<h4>当前设置的表单：<i class="nowForm"></i></h4>

<span>更改当前设置的表单请到 已有的表单中选择一个 表单即可</span>
<hr>

<h4>标题</h4>

<textarea rows="3" cols="20" class="title"></textarea>
<hr>
<h4>简介设置</h4>

<textarea rows="3" cols="20" class="showtext"></textarea>

<hr>
<h4>详细介绍</h4>

<textarea rows="3" cols="20" class="intro"></textarea>

<hr>

<input type="button" value="设置它们在前台展示" class="setShowAll">
<span class="resultSetShowAll"></span>

<h2>创建或者更新已有表单</h2>
<form id="newapply" name="newapply" method="post" action="" onSubmit="return checkapply()">
    <input name="newapplyaction" type='hidden' value="newapplyaction" />
    
    <ol>
        <li>
            <h4>用户名：</h4>
            显示<input type="radio" name="name" value="1" checked>
            不用<input type="radio" name="name" value="0" >
            <p>举例：用户名<input type="text" value="张三(或者：Mike)"></p>
        </li>
        <li>
            <h4>性别：</h4>
            显示<input type="radio" name="sex" value="1" checked>
            不用<input type="radio" name="sex" value="0" >
            <p>举例：
                您的性别：男<input type="radio" value="1" name="e_sex" checked>
                女<input type="radio" name="e_sex" value="0"></p>
        </li>
        <li>
            <h4>年龄：</h4>
            显示<input type="radio" name="age" value="1" checked>
            不用<input type="radio" name="age" value="0" >
            <p>举例：您的年龄<input type="text" value="25">岁</p>
        </li>
        <li>
            <h4>QQ号：</h4>
            显示<input type="radio" name="qq" value="1" checked>
            不用<input type="radio" name="qq" value="0" >
            <p>举例：您的qq号<input type="text" value="644494365"></p>
        </li>
        <li>
            <h4>邮箱：</h4>
            显示<input type="radio" name="email" value="1" checked>
            不用<input type="radio" name="email" value="0" >
            <p>举例：您的邮箱<input type="text" value="admin@highsea90.com"></p>
        </li>
        <li>
            <h4>班级或者社团职务(座位)：</h4>
            显示<input type="radio" name="site" value="1" checked>
            不用<input type="radio" name="site" value="0" >
            <p>举例：班级或者社团职务(座位)<input type="text" value="a101">号</p>
        </li>
        <li>
            <h4>工作：</h4>
            显示<input type="radio" name="job" value="1" checked>
            不用<input type="radio" name="job" value="0" >
            <p>举例：您的喜欢的工作<input type="text" value="WEB前端开发工程师"></p>
        </li>
        <li>
            <h4>格言：</h4>
            显示<input type="radio" name="info" value="1" checked>
            不用<input type="radio" name="info" value="0" >
            <p>举例：您的格言<input type="text" value="我是一只小前端"></p>
        </li>
        <li>
            <h4>星座：</h4>
            显示<input type="radio" name="constellation" value="1" checked>
            不用<input type="radio" name="constellation" value="0" >
            <p>举例：选择您的星座 
                <select name="e_constellation">
                    <option value="1">白羊座</option>
                    <option value="2">金牛座</option>
                    <option value="3">双子座</option>
                    <option value="4">巨蟹座</option>
                    <option value="5">狮子座</option>
                    <option value="6">处女座</option>
                    <option value="7">天秤座</option>
                    <option value="8">天蝎座</option>
                    <option value="9">射手座</option>
                    <option value="10">摩羯座</option>
                    <option value="11">水瓶座</option>
                    <option value="12">双鱼座</option>
                </select>
            </p>
        </li>
        <li>
            <h4>出生年：</h4>
            显示<input type="radio" name="bd_y" value="1" checked>
            不用<input type="radio" name="bd_y" value="0" >
            <p>举例：您的出生年份<input type="text" value="1990">年</p>
        </li>
        <li>
            <h4>出生月：</h4>
            显示<input type="radio" name="bd_m" value="1" checked>
            不用<input type="radio" name="bd_m" value="0" >
            <p>举例：您的出生月份<input type="text" value="3">月</p>
        </li>
        <li>
            <h4>出生日：</h4>
            显示<input type="radio" name="bd_d" value="1" checked>
            不用<input type="radio" name="bd_d" value="0" >
            <p>举例：您的出生日子<input type="text" value="17">日</p>
        </li>      
    </ol>

    <p>填写你要创建或者更新的表单名称：取名
        <input name="newapplyname" type='text' value="">
        <em>名称仅限于中英文以及数字</em> 
        <input type="submit" name="applybutton" id="applybutton" value="保存设置">
    </p>
    <p style="display:<?=$applydis?>">你新建了 <?=iconv("GBK", 'UTF-8', $newapplyname)?> 表单，设置已经保存，操作时间：<?=$applydate?></p>
    <p style="display:<?=$applydis_c?>">你更新了 <?=iconv("GBK", 'UTF-8', $newapplyname)?> 表单，设置已经覆盖，操作时间：<?=$applydate?></p>
</form>

<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

<script src="http://<?=$_SERVER["HTTP_HOST"]?>/weixinsdk/plate/preach/cssjs/common.js"></script>
<script type="text/javascript">
var adminname = $('[name=adminname]'),
    newapplyname = $('[name=newapplyname]'),
    allformshow = $('[name=allformshow]'),
    showcurrent = $('.showcurrent'),
    setShowAll = $('.setShowAll'),
    showtext = $('.showtext'),
    title = $('.title'),
    intro = $('.intro');

var showText = {
    "0":"<b>不用</b>",
    "1":"<i>显示</i>"
}


function checkadmin(){

    if (adminname.val()=='') {

        alert('您还没填写管理员账号');
        return false;
    };

}

function checkapply(){

    if (newapplyname.val()=='') {

        alert('您还没填写表单名称');
        return false;
    };

}
//获取 简介设置，标题，详细介绍  getshow
//ajax2();


//获取 数据库中 所有设置的表单状况 allform
jQuery.ajax({
    type  : "get",
    async : true,
    url : 'http://<?=$_SERVER["HTTP_HOST"]?>/weixinsdk/plate/preach/api.php',
    dataType : "jsonp",
    jsonp : "callback",
    data : {
        verify:"allform"
    },
    jsonpCallback : "dataList",
    success : function(dataList){
        //console.log(dataList);
        if (dataList.code==200) {
            var a =dataList.data;
            allformshow.html('');
            $('.allformNum').html(a.length);
            for (var i = 0; i < a.length; i++) {
                var id = a[i].id,
                    formname = a[i].formname,
                    name = a[i].name,
                    sex = a[i].sex,
                    age = a[i].age,
                    qq = a[i].qq,
                    email = a[i].email,
                    site = a[i].site,
                    job = a[i].job,
                    info = a[i].info,
                    constellation = a[i].constellation,
                    bd_y = a[i].bd_y,
                    bd_m = a[i].bd_m,
                    bd_d = a[i].bd_d,
                    date = a[i].date,
                    str1 = '<option value="'+id+'" class="option'+id+'">'+formname+'</option>',
                    str2 = '<tr class="none" id="tr'+id+'" data-time="'+date+'"><td>'+showText[name]+'</td><td>'+showText[sex]+'</td><td>'+showText[age]+'</td><td>'+showText[qq]+'</td><td>'+showText[email]+'</td><td>'+showText[site]+'</td><td>'+showText[job]+'</td><td>'+showText[info]+'</td><td>'+showText[constellation]+'</td><td>'+showText[bd_y]+'</td><td>'+showText[bd_m]+'</td><td>'+showText[bd_d]+'</td></tr>';
                allformshow.append(str1);
                showcurrent.children('tbody').append(str2);
            };

            $('.showcurrent').find('#tr'+allformshow.val()).toggleClass('none');

            currentTR();
            ajaxGetshow();
        };
            
    },
    error : function(){
        console.log('allform,网络故障请刷新，或重试');
    }
    
});


function currentTR(){
    allformshow.on('click',function(){

        if (allformshow.val!='47') {
            $('.showcurrent').find('#tr'+allformshow.val()).toggleClass('none');
        };

    })
}

//设置设置前台显示的表单、简介，标题，详细介绍等 show
//参数 showform 将表格 名称 改成表格 id ？
//$('.option'+allformshow.val()).text()
//$('.option'+allformshow.val()).attr('value')
setShowAll.on('click',function(){
    jQuery.ajax({
        type  : "get",
        async : true,
        url : 'http://<?=$_SERVER["HTTP_HOST"]?>/weixinsdk/plate/preach/api.php',
        dataType : "jsonp",
        jsonp : "callback",
        data : {
            verify:"show",
            showform:escape($('.option'+allformshow.val()).text()),
            showtext:escape(showtext.val()),
            title:escape(title.val()),
            intro:escape(intro.val()),
            date:'<?=date("Y-m-d H:i:s",time())?>',
            md5:'<?=getAwardCheckCode("sjk2014")?>'
        },
        jsonpCallback : "dataList",
        success : function(dataList){
            if (dataList.code=='200') {
                $('.resultSetShowAll').html('更新成功啦！');
                ajaxGetshow();
            }else if(dataList.code == '401'){
                $('.resultSetShowAll').html('认证失败');
            }else{
                $('.resultSetShowAll').html('错误，请重试');
            };
                
        },
        error : function(){
            console.log('show,网络故障请刷新，或重试');
        }
    
    });
})

</script>
