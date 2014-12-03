<?php
/**
* PHP for wechat (using OAuth2)
*
* @author High Sea <admin@highsea90.com>
*/
session_start();
include 'include/common.php';//基础函数库
$userCacheName = $_SESSION['nickname'];

?>
<!DOCTYPE html>
<html>
<head>
<title>已登录后操作</title>
<meta charset="utf-8">
<script src="https://a.alipayobjects.com/u/js/201204/2S07Fhc1TN.js"></script> 
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
        "0":"女",
        '':'未知'
    };

</script>
</head>
<body>

<h1 class="user_head">您好：</h1>
<ul class="user_body"></ul>
<script type="text/javascript">
$(document).ready(function(){
    $('.user_head').append(getUserInfo.nickname).attr('data-openid',getUserInfo.openid).attr('data-unionid',getUserInfo.unionid);
    strUserBody = '<li>您的头像：<img src="'+getUserInfo.headimgurl+'" width="150"></li>'
                 +'<li>你的地理位置：'+country[getUserInfo.country]+province[getUserInfo.province]+city[getUserInfo.city]+'</li>'
                 +'<li>您的性别：'+sex[getUserInfo.sex]+'</li>'
                 +'<li>其他信息：暂无</li>'
    $('.user_body').append(strUserBody);
})

</script>
</body>
</html>
<?php
include 'db/db.php';


?>