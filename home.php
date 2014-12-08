<?php
/**
* PHP for wechat (using OAuth2)
*
* @author High Sea <admin@highsea90.com>
*
* home 页面 处理用户详细信息 更新数据库 填写报名其他信息
*
* 
*/
session_start();
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);

include_once 'include/common.php';//基础函数库
include_once 'plate/preach/function.php';
$backurl = 'index.php?back=home';


if ($_SESSION['nickname']=='') {
    newHeader($backurl);
}
//兼容 读取中文名称缓存文件
$userCacheName = "user_".iconv('UTF-8', 'GBK', $_SESSION['nickname']);

//验证 扫描的访客 是否是管理员；admin
$verifyadminSQL = "SELECT * FROM `hs_admin` WHERE name = '".$_SESSION['nickname']."' ";
$resultApplyName = sql_select($verifyadminSQL);
if (isset($resultApplyName)) {
    //管理员
    $userwellcom = '管理员';
    $iframeUrl = "plate/preach/admin.php";
} else {
    //访客
    $userwellcom = '同学';
    $iframeUrl = "plate/preach/index.php";
}

//获取设置显示的表单、简介，标题，详细介绍等 show

/*

switch ($_GET['show']){
case 'idacker':
  $iframeUrl = 'plate/idacker/index.php';
  break;  
case 'preach':
  $iframeUrl = 'plate/preach/index.php';
  break;
default:
  $iframeUrl = 'plate/preach/index.php';
  break;
}*/

?>
<!DOCTYPE html>
<html>
<head>
<title>已登录后操作</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--<link rel="stylesheet" href="http://<?=$_SERVER["HTTP_HOST"]?>/weixinsdk/plate/cssjs/jqmb1.0/jquery.mobile-1.0.min.css" />-->
<script src="http://<?=$_SERVER["HTTP_HOST"]?>/weixinsdk/plate/cssjs/jq1.7.1/jquery-1.7.1.min.js"></script> 
<!--<script src="http://<?=$_SERVER["HTTP_HOST"]?>/weixinsdk/plate/cssjs/jqmb1.0/jquery.mobile-1.0.min.js"></script> -->
<script type="text/javascript">
var getUserInfo = <?=getUserCache($userCacheName)?>,
    country = {
        "CN":"中国",
        "USA":"美国",
        "TW":"台湾"
    },
    province = {
        "Zhejiang":"浙江",
        "Shanxi":"陕西",
        "Anhui":"安徽",
        "Shanghai":"上海",
        "Henan":"河南"
    },
    city = {
        "Hangzhou":"杭州",
        "Hanzhong":"汉中",
        "Hefei":"合肥",
        "Zhengzhou":"郑州"
    },
    sex = {
        "1":"男",
        "2":"女",
        '0':'未知'
    };

</script>
</head>
<body>





<div id="page-1" data-role="page">
    <div data-role="header">
        <h1>请认真填写哦</h1>
    </div>
    <div data-role="content">
        


<h2 class="user_head"><?=$userwellcom?>您好：</h2>
<h2> <a href="<?=$backurl?>">退出</a> </h2>
<ul class="user_body"></ul>
<hr>


<?php
include_once $iframeUrl;
?>

        <div class="footer">
            <p>舟山数据客科技有限公司 © 2014 <a >idacker</a>. All rights resevered. <br><i>浙ICP备14019357号-1</i></p>
        </div>
    </div>
    <div data-role="footer" data-position="fixed">
        <div data-role="navbar">
            <ul>
                <li><a href="#page-1" data-role="tab" data-icon="grid" class="ui-btn-active">填写问卷</a></li>
                <li><a href="#page-2" data-role="tab" data-icon="grid">查看图表</a></li>               
            </ul>
        </div>
    </div>
</div>

<div id="page-2" data-role="page">
    <div data-role="header">

        <h1>查看统计图表</h1>
    </div>
    <div data-role="content">
        
<!--  -->

<h3>正在统计中……</h3>

     <!--  -->   
        <div class="divmark"></div>
        <div class="footer">
            <p>舟山数据客科技有限公司 © 2014 <a >idacker</a>. All rights resevered. <br><i>浙ICP备14019357号-1</i></p>
        </div>
    </div>
    <div data-role="footer" data-position="fixed">
        <div data-role="navbar">
            <ul>
                <li><a href="#page-1" data-role="tab" data-icon="grid">填写问卷</a></li>
                <li><a href="#page-2" data-role="tab" data-icon="grid" class="ui-btn-active">查看图表</a></li>
            </ul>
        </div>
    </div>
</div>













<script type="text/javascript">
$("a[data-role=tab]").each(function () {
    var anchor = $(this);
    anchor.bind("click", function () {
        $.mobile.changePage(anchor.attr("href"), {
            transition: "none",
            changeHash: true
        });
        return false;
    });
});

$("div[data-role=page]").bind("pagebeforeshow", function (e, data) {
    $.mobile.silentScroll(0);
    $.mobile.changePage.defaults.transition = 'slide';
});
//


    $('.user_head').append(getUserInfo.nickname).attr('data-openid',getUserInfo.openid).attr('data-unionid',getUserInfo.unionid);
    strUserBody = '<li>您的头像：<img src="'+getUserInfo.headimgurl+'" width="150"></li>'
                 +'<li>你的地理位置：'+country[getUserInfo.country]+province[getUserInfo.province]+city[getUserInfo.city]+'</li>'
                 +'<li>您的性别：'+sex[getUserInfo.sex]+'</li>'
                 +'<li>其他信息：暂无</li>';
    $('.user_body').append(strUserBody);



</script>

<!-- <iframe src="" width="500" height="500"></iframe> -->

</body>
</html>