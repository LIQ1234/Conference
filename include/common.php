<?php
/**
* PHP for wechat (using OAuth2)
*
* @author High Sea <admin@highsea90.com>
*
* 该页面 包含 curlAPI newHeader debugPre userCache getUserCache backCode 等函数
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
/**
* @param customJsonRes 
* @param $code back参数
*/
//自定义生成 json 数据
function customJsonRes($code, $message, $customJson){

    $callback = isset($_GET['callback']) ? $_GET['callback'] : 'callback'; 

    $resultCacheDataJson = array(
        'code' => $code,
        'message' => $message,
        'data' => $customJson
    );

    echo $callback.'('.json_encode($resultCacheDataJson).')';
    exit;

}


function unescape($escstr){
    preg_match_all("/%u[0-9A-Za-z]{4}|%.{2}|[0-9a-zA-Z.+-_]+/", $escstr, $matches);
    $ar = &$matches[0];
    $c = "";
    foreach($ar as $val){
        if (substr($val, 0, 1) != "%"){
            $c .= $val;
        } elseif (substr($val, 1, 1) != "u"){
            $x = hexdec(substr($val, 1, 2));
            $c .= chr($x);
        }else{
            $val = intval(substr($val, 2), 16);
            if ($val < 0x7F) {
                $c .= chr($val);
            } elseif ($val < 0x800){
                $c .= chr(0xC0 | ($val / 64));
                $c .= chr(0x80 | ($val % 64));
            }else {
                $c .= chr(0xE0 | (($val / 64) / 64));
                $c .= chr(0x80 | (($val / 64) % 64));
                $c .= chr(0x80 | ($val % 64));
            }
        }
    }
    return $c;
} 

//尝试加密
function getAwardCheckCode($key) {
    $time = time();
    $secret = md5($key);
    return $secret;
}

function get_password( $length = 8 ){
    $str = substr(md5(time()), 0, 6);
    return $str;
}



/**

*/
function formField ($resultall){
    foreach ($resultall as $i => $row){

        $form = new Form();
        $form->id            = $row[0];
        $form->formname      = $row[1];
        $form->name          = $row[2];
        $form->sex           = $row[3];
        $form->age           = $row[4];
        $form->qq            = $row[5] ;
        $form->email         = $row[6];
        $form->site          = $row[7];
        $form->job           = $row[8];
        $form->info          = $row[9];
        $form->constellation = $row[10];
        $form->bd_y          = $row[11];
        $form->bd_m          = $row[12];
        $form->bd_d          = $row[13];
        $form->date          = $row[14];

        $data[]=$form;
    }
    return $data;
}

/*$con = mysql_connect("hdm-116.hichina.com","hdm1160443","mining20140310");

if (!$con){
    die('Could not connect: ' . mysql_error());
}

mysql_select_db("hdm1160443_db", $con);

$result = mysql_query($sqlApplyName, $con);

while($row = mysql_fetch_array($result)){
    echo "<pre>";
  var_dump($row);
}*/

/*$serverArry = {
    '100':'继续',
    '101':'交换协议',
    '200':'正常', success 正常
    '201':'创建',
    '202':'接受',
    '203':'非授权信息', 参数不存在
    '204':'没有内容',
    '205':'重置内容',
    '206':'部分内容',
    '300':'多选',
    '301':'永久移动',
    '302':'发现缓存', cache 缓存
    '303':'请参阅其他',
    '304':'未修改', 
    '305':'使用代理',
    '306':'未使用',
    '307':'临时重定向',
    '400':'错误的请求',Bad Request：请求参数不合法！
    '401':'需要认证',
    '402':'需要付款',
    '403':'禁止访问',
    '404':'找不到资源', not found：没找到数据！
    '405':'不允许的方法',
    '406':'不接受',
    '407':'需要代理身份验证',
    '408':'请求超时',
    '409':'冲突',
    '410':'过去的',
    '411':'需要长度',
    '412':'前提条件失败',
    '413':'请求实体太大',
    '414':'请求URI太长',
    '415':'不支持的媒体类型',
    '416':'请求的范围无法满足',
    '417':'预期失败',
    '500':'内部服务器错误',
    '501':'未实现',
    '502':'错误的网络', Bad Gateway：服务器连接失败！
    '503':'暂停服务',
    '504':'网络超时',
    '505':'HTTP的版本没有支持'
}*/


?>

