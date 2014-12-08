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
class Content{
    public $id ;
    public $showform ;
    public $showtext ;
    public $title ;
    public $intro ;
    public $date ;
}

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

        customJsonRes('200', 'success', $data);
        
        break;
//设置 前台表单，文字等展示信息
    case 'show':

        if (!isset($_GET['showform'])||!isset($_GET['showtext'])||!isset($_GET['title'])||!isset($_GET['intro'])||!isset($_GET['date'])||!isset($_GET['md5'])) {
            customJsonRes('203', '非授权信息！', 'null');
        }


        $showform = $_GET['showform'];
        $showtext = $_GET['showtext'];
        $title = $_GET['title'];
        $intro = $_GET['intro'];
        $date = $_GET['date'];
        $md5 = $_GET['md5'];

        if ($_GET['md5']==md5('sjk2014')) {

            //执行更新
            $updatecontent = "UPDATE hs_content SET showform = '".$showform."', showtext = '".$showtext."', title = '".$title."', intro = '".$intro."', date = '".$date."' WHERE id = '0' ";
            sql_insert_update_delete($updatecontent);

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
        $getcurrentformSQL = "SELECT * FROM `hs_setform` WHERE formname = '".$_GET['formname']."' ";
        # code...
        break;
    default:
        customJsonRes('204', '没有内容！', 'null');
        break;
}
?>