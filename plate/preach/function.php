<?php
//账号与密码设定
$host = 'hdm-116.hichina.com';
$user = 'hdm1160443';
$pass = 'mining20140310';
$database = 'hdm1160443_db';

//mysql_db_query() 新版换成 mysql_query()
//sql查询A(用于insert update delete)
function sql_insert_update_delete($query)
{
        global $host,$user,$pass,$database;

        $conn = @mysql_connect($host,$user,$pass);
        if (!$conn){
                die('链接数据库失败: ' . mysql_error());
        }
        @mysql_select_db($database,$conn);

        if (!mysql_query($query,$conn)){

            die('Error: ' . mysql_error());
        }
        return "add success";

        mysql_close($conn);
}




//sql查询B(用于select)
function sql_select($query){

    global $host,$user,$pass,$database;

    $conn = @mysql_connect($host,$user,$pass);
    if (!$conn){
            die('链接数据库失败: ' . mysql_error());
    }
    @mysql_query("set names utf8"); 
    @mysql_select_db($database,$conn);
    //$conn 参数可选
    $result = @mysql_query($query,$conn);
    if (!$result) {
        die('null');
    }
    @mysql_data_seek($result,0);
    while($row = @mysql_fetch_array($result)){
        $output[] = $row;
    }
/*    if(!is_array(@$output)){
        $output=array();
    } */
    @mysql_free_result($result);
    @mysql_close($conn);

    return $output;
}



//sql查询C(用于insert 且自动产生编号)
function sql_c($query)
{
        global $host,$user,$pass,$database;
        
        $conn = @mysql_connect($host,$user,$pass);
        @mysql_select_db($database,$conn);
        $result = @mysql_query($query);
        $result = @mysql_insert_id();
        @mysql_close($conn);

        return $result;
}


//解析网页，并且替换输出
//$parser_array格式为：$array['key'] = value;
function read_and_parser($filename,$parser_array)
{
        $handle = fopen($filename,'r');
        $buffer = fread($handle,filesize($filename));
        @fclose($buffer);

        //开始查找替换
        while(list($key,$value)=each($parser_array))
        {
                $buffer = str_replace($key,$value,$buffer);//这一句是重点，把指定内容替换
        }
        
        return $buffer;
}

?>
