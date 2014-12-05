
<?php
include_once('function.php');

$sql = "select * from preach";

$row = sql_select($sql);//执行查询

if($_GET['style']==1)
{
        $page = 'page1.html';
}
else
{
        $page = 'page2.html';
}

//把从数据库里取出的数据存到$array这个数组里
$array['{name}'] = $row[0][0];
$array['{sex}'] = $row[0][1];
$array['{age}'] = $row[0][2];
$array['{qq}'] = $row[0][3];
$array['{email}'] = $row[0][4];
$array['{info}'] = $row[0][5];

$output = read_and_parser($page,$array);//用自定义函数替换内容

echo $output;//显示页面

?>
