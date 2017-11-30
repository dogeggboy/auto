<?php
/**
 * Created by PhpStorm.
 * User: qt
 * Date: 2017/11/30
 * Time: 23:59
 */

//屏蔽（Notice: Undefined variable）
ini_set("error_reporting","E_ALL & ~E_NOTICE");

//设置网页编码格式
//header("Content-type: text/html; charset=utf-8");

//手机不缩放
//echo '<meta name="viewport" content="initial-scale=1, maximum-scale=3, minimum-scale=1, user-scalable=no">';

//包含conn.php文件
require ('conn.php');
require ('dataapi.php');

//建立数据库连接
$mysqli = new mysqli($host, $username, $passwd, $dbname);

//如果不能链接打印错误并退出
if ($mysqli->connect_errno) {

    printf("Connect failed: %s\n", $mysqli->connect_error);

    exit();

}

//设置编码为UTF8
$mysqli->query("set names 'utf8'");

$table = "000".$_GET['table'];
$taskId = $_GET['taskId'];
$size = 1000;

$exdata = exdata("http://dataapi.bazhuayu.com/api/notexportdata/gettop?taskId=$taskId&size=$size",$access_token);

$exdata = json_decode($exdata,true);
$i = 0;
foreach ($exdata['data']['dataList'] as $row) {
    $name = $row['name'];
    $price = $row['price'];
    $info = $row['info'];
    $feature = $row['feature'];
    $query = "INSERT INTO $table (id,name,price,info,feature) VALUES (NULL,'$name','$price','$info','$feature')";
    if (!$mysqli->query($query)) {
        echo $mysqli->error;
    }
    $i++;
}
echo "入库数据".$i;

/* close connection */
$mysqli->close();