<?php
/**
* PHP for wechat (using OAuth2)
*
* @author High Sea <admin@highsea90.com>
*/
session_start();
require_once('./file/file.php');//文件夹操作
require_once('./res/response.php');//综合接口封装
include 'include/common.php';//基础函数库


$code = isset($_GET['code']) ? $_GET['code'] : '';
$state = isset($_GET['state']) ? $_GET['state'] : '';

$_SESSION["code"] = $code;
$_SESSION["state"] = $state;

$appid = 'wx70a2b1aa7fed4cc9';//
$secret = 'ee61194ac1a378ab971f56081756f561';//

/**
//验证 非法操作，跳转
*/
if ($code!=''&&$state===md5('idacker')) {
    $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$secret.'&code='.$code.'&grant_type=authorization_code';

}else{

    newHeader('index.php');
    //确保重定向后，后续代码不会被执行 
    die();
}


/**
//获取 access_token
*/
$outputAPI = curlAPI($url);
if (isset($outputAPI["access_token"])) {
    //存入session
    $_SESSION["access_token"] = $outputAPI['access_token'];
    $_SESSION["refresh_token"] = $outputAPI['refresh_token'];
    $_SESSION["scope"] = $outputAPI['scope'];
    $_SESSION["openid"] = $outputAPI['openid'];
    
} else{
    //debugPre($outputAPI, 0);
}
/**
//获取 页面刷新后 refresh_token
*/

$refresh_url = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?appid='.$appid.'&grant_type=refresh_token&refresh_token='.$_SESSION["refresh_token"];
$refresh_API = curlAPI($refresh_url);

if (isset($refresh_API["access_token"])) {
    //更新session token
    $_SESSION["access_token"] = $refresh_API['access_token'];
    $_SESSION["refresh_token"] = $refresh_API['refresh_token'];
    $_SESSION["scope"] = $refresh_API['scope'];
    $_SESSION["openid"] = $refresh_API['openid'];

}else{
    //debugPre($refresh_API, 0);
}
/**
//验证授权凭证 access_token
*/
$verify_url = 'https://api.weixin.qq.com/sns/auth?access_token='.$_SESSION["access_token"].'&openid='.$_SESSION["openid"];
$verify_API = curlAPI($verify_url);


if ($verify_API['errmsg']==='ok') {
    /**
    //获取登陆用户个人信息
    */
    $user_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$_SESSION["access_token"].'&openid='.$_SESSION["openid"];
    $user_API = curlAPI($user_url);

    if (isset($user_API['nickname'])) {
        $_SESSION['nickname'] = $user_API['nickname'];

        $resultCacheDataJson = array(
            'openid'     => $user_API['openid'],
            'nickname'   => $user_API['nickname'],
            'sex'        => $user_API['sex'],
            'province'   => $user_API['province'],
            'city'       => $user_API['city'],
            'country'    => $user_API['country'],
            'headimgurl' => $user_API['headimgurl'],
            'privilege'  => $user_API['privilege'],
            'unionid'    => $user_API['unionid']
        );

        userCache($user_API['nickname'], $resultCacheDataJson);
        newHeader('home.php');

    }else{

        //debugPre($user_API, 0);
    }

}else{
    // access_token 过期
    //
    //debugPre($verify_API, 1);
    newHeader('index.php');
    die();
}



?>




