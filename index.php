<?php
/**
* PHP for wechat (using OAuth2)
*
* @author High Sea <admin@highsea90.com>
* 
* 该页面 显示 二维码
*/
session_start();
include_once 'include/common.php';
$_SESSION['nickname'] = '';
$_SESSION["access_token"] = "none";
$_SESSION["refresh_token"] = 'none';
$_SESSION["scope"] = 'none';
$_SESSION["openid"] = 'none';
$_SESSION["code"] = '';
$_SESSION["state"] = '';

$backcode = isset($_GET['back']) ? $_GET['back'] : '';

?>
<!DOCTYPE html>
<html>
<head>
<title>微信 登陆</title>
<meta charset="utf-8">
<script src="http://res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js"></script>

</head>
<body>
<?php
if (!$backcode=='') {
    echo '<h1>'.backCode($backcode).'</h1>';
}
?>

<h1>微信二维码登陆</h1>
<div id="login_container"></div>

<script type="text/javascript">
var obj = new WxLogin({

    id:"login_container", 
    appid: "wx70a2b1aa7fed4cc9", 
    scope: "snsapi_login", 
    redirect_uri:"<?=UrlEncode('http://idacker.com/weixinsdk/main.php')?>",
    state: "<?=md5('idacker');?>",
    style: "black",
    href: ""//自定义样式css链接
});                  
</script>
</body>
</html>