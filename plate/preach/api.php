<?php
include_once '../../include/common.php';
include_once 'function.php';
//error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);

$callback = isset($_GET['callback']) ? $_GET['callback'] : 'callback';
/*
//是否存在 verify newapplyname
if (!isset($_GET['verify'])||!isset($_GET['newapplyname'])) {
    customJsonRes('203', '非授权信息！', 'null');
}
//获取
$ajaxGET = $_GET['verify'];

$ajaxApplyName = $_GET['newapplyname'];
//参数是否传正确
if ($ajaxGET!='verify'||$ajaxApplyName=='') {
    customJsonRes('400', 'Bad Request：请求参数不合法！', 'null');
}

//查询数据库
$sqlApplyName = "SELECT * FROM `hs_setform` WHERE formname = '".$ajaxApplyName."' ";

$resultApplyName = sql_select($sqlApplyName);

if (isset($resultApplyName)) {

    customJsonRes('205', '请重置内容', 'null');
    //debugPre($resultApplyName,0);

}else{
    customJsonRes('404', '找不到', 'null');
}
*/
//form calss

//获取所有表单状态
class Form{
    public $id ;
    public $formname ;
    public $name ;
    public $sex ;
    public $age ;
    public $qq ;
    public $email ;
    public $site;
    public $job;
    public $info;
    public $constellation;
    public $bd_y;
    public $bd_m;
    public $bd_d;
    public $date;
}
//获取 设置的前台表单名称，文字等展示信息
class Content{
    public $id ;
    public $showform ;
    public $showtext ;
    public $title ;
    public $intro ;
    public $date ;
}
//获取 设置的前台表单的内容-根据名称来获取
/*class Currentform{
    public $id ;
    public $name ;
    public $sex ;
    public $age ;
    public $qq ;
    public $email ;
    public $site;
    public $job;
    public $info;
    public $constellation;
    public $bd_y;
    public $bd_m;
    public $bd_d;
    public $date;
}*/
//

if (!isset($_GET['verify'])) {
    customJsonRes('203', '非授权信息！', 'null');
}

$variable = $_GET['verify'];
switch ($variable) {
//验证表单名称，管理员名称，前台展示内容等（未完成）
    case 'verify':
        customJsonRes('200', 'success', 'null');
        break;
//获取所有表单状态
    case 'allform':
        $allformSql = "SELECT * FROM `hs_setform`";
        $resultall = sql_select($allformSql);

        //debugPre($resultall,0);
        //填写字段
        $data = formField ($resultall);

        customJsonRes('200', 'success', $data);
        
        break;
//设置 前台表单，文字等展示信息
    case 'show':

        if (!isset($_GET['showform'])||!isset($_GET['showtext'])||!isset($_GET['title'])||!isset($_GET['intro'])||!isset($_GET['date'])||!isset($_GET['md5'])) {
            customJsonRes('203', '非授权信息！', 'null');
        }


        $showform = iconv('UTF-8', 'GBK', unescape($_GET['showform']));

        $showtext = iconv('UTF-8', 'GBK', unescape($_GET['showtext']));
        $title = iconv('UTF-8', 'GBK', unescape($_GET['title']));
        $intro = iconv('UTF-8', 'GBK', unescape($_GET['intro']));
        $date = $_GET['date'];
        $md5 = $_GET['md5'];

        if ($_GET['md5']==md5('sjk2014')) {

            //执行更新
            //若 表格名称改成 表格id ……
            $updatecontent = "UPDATE hs_content SET showform = '".$showform."', showtext = '".$showtext."', title = '".$title."', intro = '".$intro."', date = '".$date."' WHERE id = '0' ";
            sql_insert_update_delete($updatecontent);
            //echo $updatecontent;
            customJsonRes('200', 'success', 'null');

        } else{
            customJsonRes('401', '需要认证', 'null');
        }


        break;
//获取 设置的前台表单名称，文字等展示信息
    case 'getshow':
            $sqlApplyName = "SELECT * FROM `hs_content`";
            $resultApplyName = sql_select($sqlApplyName);

        foreach ($resultApplyName as $i => $row){

            $show = new Content();
            $show->id            = $row[0];
            $show->showform      = $row[1];
            $show->showtext      = $row[2];
            $show->title         = $row[3];
            $show->intro         = $row[4];
            $show->date          = $row[5];
            $data[]=$show;
        }
            //var_dump($resultApplyName);
            customJsonRes('200', 'success', $data);

        break;
//获取 设置的前台表单的内容-根据名称来获取

    case 'getcurrentform':
        
        if (isset($_GET['formname'])) {
            //自定义的 unescape 见 common.php
            $_GET_formname = unescape($_GET['formname']);
            //iconv('UTF-8', 'GBK', unescape($_GET['formname']))
            //iconv('GBK', 'UTF-8', )

            $getcurrentformSQL = "SELECT * FROM `hs_setform` WHERE formname = '".$_GET_formname."' ";
            //echo $getcurrentformSQL;
            $resultCurr = sql_select($getcurrentformSQL);
            //var_dump($data);
            //填写字段
            $data = formField ($resultCurr);
            customJsonRes('200', 'success', $data);

        } else {
            customJsonRes('203', '非授权信息！', 'null');
        }
        
        break;
    default:
        customJsonRes('204', '没有内容！', 'null');
        break;
}
?>