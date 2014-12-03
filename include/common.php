<?php
/**
* PHP for wechat (using OAuth2)
*
* @author High Sea <admin@highsea90.com>
*/

/**
* @param curlAPI 发送请求
* @param $url 设置请求
*/
function curlAPI($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    //解决报错 SSL certificate problem: unable to get local issuer certificate
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

    $result = json_decode(curl_exec($ch), true);
    if ($result === FALSE) {
        return "cURL Error: " . curl_error($ch);
        curl_close($ch);
        die();
    }
    curl_close($ch);
    return $result;
}
/**
* @param newHeader 跳转
* @param $fileName 跳转的文件名
*/
function newHeader($fileName){
    return header("Location: http://".$_SERVER['HTTP_HOST']."/weixinsdk/".$fileName); 
}
/**
* @param debugPre 调试
* @param $a array
* @param $num is_numeric
*/
function debugPre ($a,$num){
    switch ($num) {
        case '1':
            echo json_encode($a);
            break;
        
        default:
            echo "<pre>";
            var_dump($a);
            echo "</pre>";
            break;
    }

}
/**
* @param userCache 用户信息缓存
* @param $p 用户昵称，文件名
* @param $data 封装的数据
*/
//定时缓存
function userCache($p, $data){

    $file = new File();
    $file->cacheData($p, $data);
}

/**
* @param getUserCache 读取用户信息缓存
* @param $fileName 用户昵称，文件名
*/
//读取缓存
function getUserCache($fileName){
    

    $cacheDir = "./cache/";

    if(isset($fileName)){

        return $cacheDataJson = file_get_contents($cacheDir.$fileName.".json");

    }else{
        //echo "警告：您的操作未授权，请登录！";
        newHeader('index.php');

    }
}

/**
* @param backCode 提示信息
* @param $code back参数
*/
//读取缓存
function backCode($code){
    
    switch ($code) {
        case 'warning':
            return '禁止操作！请先登陆！';
            break;

        case 'home':
            return '扫描登录后可以查看个人首页，报名信息';
            break;

        case 'main':
            return '请先登陆！';
            break;

        default:
            return '';
            break;
    }
}

//尝试加密
function getAwardCheckCode() {
    $time = time();
    $key = "12345";
    $secret = md5($time.$key);
    return "&time=".$time."&secret=".$secret;
}

function get_password( $length = 8 ){
    $str = substr(md5(time()), 0, 6);
    return $str;
}

?>