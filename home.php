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
include 'include/common.php';//基础函数库

$backurl = 'index.php?back=home';

if ($_SESSION['nickname']=='') {
    newHeader($backurl);
}
//兼容 读取中文名称缓存文件
$userCacheName = "user_".iconv('UTF-8', 'GBK', $_SESSION['nickname']);




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
        "2":"女",
        '0':'未知'
    };

</script>
</head>
<body>

<h1 class="user_head">您好：</h1>
<h2> <a href="<?=$backurl?>">退出</a> </h2>
<ul class="user_body"></ul>


<script type="text/javascript">
$(document).ready(function(){
    $('.user_head').append(getUserInfo.nickname).attr('data-openid',getUserInfo.openid).attr('data-unionid',getUserInfo.unionid);
    strUserBody = '<li>您的头像：<img src="'+getUserInfo.headimgurl+'" width="150"></li>'
                 +'<li>你的地理位置：'+country[getUserInfo.country]+province[getUserInfo.province]+city[getUserInfo.city]+'</li>'
                 +'<li>您的性别：'+sex[getUserInfo.sex]+'</li>'
                 +'<li>其他信息：暂无</li>';
    $('.user_body').append(strUserBody);
});


function checkform(){
    if ($('#company').val()=='') {
        alert('请填写公司名称');
         return false;
    };
    if($('#username').val()==''){
        alert('请填写姓名');
        return false;
    }
    if($('#email').val()==''){
        alert('请填写邮件地址');
        return false;
    }
    if($('#tel').val()==''){
        alert('请填写手机号码');
        return false;
    }
}
</script>
<h1>报名信息</h1>
<form id="form1" name="form1" method="post" action="api.php" onSubmit="return checkform()">
  <input name="action" type="hidden" value="sendaction" />
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >

    <tr>
      <td>公司：<input name="company" type="text" id="company" /><span class="red"> *</span></td>
    </tr>
    <tr>
      <td>姓名：<input name="username" type="text" id="username" />
       <span class="red"> *</span></td>
    </tr>
    <tr>
      <td>邮件：<input name="email" type="text" id="email" /><span class="red"> *</span></td>
    </tr>
    <tr>
      <td>电话：<input name="tel" type="text" id="tel" /><span class="red"> *</span></td>
    </tr>
    <tr>
      <td >交流会：
        <input style="width:8%" type="radio" name="sex" value="参加" checked>
        参加
        <input style="width:8%" width="8%" type="radio" name="sex"   value="不参加">
        不参加</td>
    </tr>

    <tr>
      <td align="center"><input type="submit" name="button" id="button" value="提交信息" /></td>
    </tr> 

    <tr>
        <td>若您无法填写以上报名信息，请发邮件到：reg@idacker.com，参阅邮件的指导，完成会议注册。</td>
    </tr>
  </table>
</form>


</body>
</html>
<?php


?>