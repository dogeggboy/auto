<?php
/**
 * Created by PhpStorm.
 * User: qt
 * Date: 2017/11/12
 * Time: 22:52
 */

//屏蔽（Notice: Undefined variable）
ini_set("error_reporting","E_ALL & ~E_NOTICE");

//设置网页编码格式
//header("Content-type: text/html; charset=utf-8");

//手机不缩放
//echo '<meta name="viewport" content="initial-scale=1, maximum-scale=3, minimum-scale=1, user-scalable=no">';

//包含conn.php文件
require ('conn.php');

//建立数据库连接
$mysqli = new mysqli($host, $username, $passwd, $dbname);

//如果不能链接打印错误并退出
if ($mysqli->connect_errno) {

    printf("Connect failed: %s\n", $mysqli->connect_error);

    exit();

}

//设置编码为UTF8
$mysqli->query("set names 'utf8'");

$table = $_GET['table'];
$excolor = $_GET['excolor'];
$incolor = $_GET['incolor'];
$feature_1 = $_GET['feature_1'];
$feature_2 = $_GET['feature_2'];
$submit = $_GET['submit'];

//SQL语句
$query = "SELECT * FROM ".$table." WHERE sell = 0 AND excolor = '".$excolor."' AND incolor = '".$incolor."' AND feature LIKE '%".$feature_1."%' AND feature LIKE '%".$feature_2."%' ORDER BY price ASC";

if ($excolor == '' && $incolor == '' && $feature_1 == '' && $feature_2 =='') {

    $query = "SELECT * FROM ".$table." WHERE sell = 0 ORDER BY price ASC";

}elseif ($excolor == '' && $incolor == '') {

    $query = "SELECT * FROM ".$table." WHERE sell = 0 AND feature LIKE '%".$feature_1."%' AND feature LIKE '%".$feature_2."%' ORDER BY price ASC";

}elseif ($excolor == '') {

    $query = "SELECT * FROM ".$table." WHERE sell = 0 AND incolor = '".$incolor."' AND feature LIKE '%".$feature_1."%' AND feature LIKE '%".$feature_2."%' ORDER BY price ASC";

}elseif ($incolor == '') {

    $query = "SELECT * FROM ".$table." WHERE sell = 0 AND excolor = '".$excolor."' AND feature LIKE '%".$feature_1."%' AND feature LIKE '%".$feature_2."%' ORDER BY price ASC";

}

//echo $query."<br>";

if ($result = $mysqli->query($query)) {

    $i = 0;

//    echo "<b>";

    switch ($table) {

        case q7c:
//            echo "奥迪Q7 17款 3.0T 科技 加版";
            $title = "奥迪Q7 17款 3.0T 科技 加版";
            break;

        case x5m:
//            echo "宝马X5 18款 3.0T 基本 墨版";
            $title = "宝马X5 18款 3.0T 基本 墨版";
            break;

        case x6m:
//            echo "宝马X6 18款 3.0T 基本 墨版";
            $title = "宝马X6 18款 3.0T 基本 墨版";
            break;

        case g500m:
//            echo "奔驰G500 17款 墨版";
            $title = "奔驰G500 17款 墨版";
            break;

        case gle43m:
//            echo "奔驰GLE43 18款 Coupe 天窗 墨版";
            $title = "奔驰GLE43 18款 Coupe 天窗 墨版";
            break;

        case gls450c:
//            echo "奔驰GLS450 17款 豪华包 运动包 加版";
            $title = "奔驰GLS450 17款 豪华包 运动包 加版";
            break;

        case bfe:
//            echo "飞驰 17款 4.0T S 四座 欧版";
            $title = "飞驰 17款 4.0T S 四座 欧版";
            break;

        case rr3a:
//            echo "揽胜行政 17款 3.0 汽油 HSE 美版";
            $title = "揽胜行政 17款 3.0 汽油 HSE 美版";
            break;

        case rr5c:
//            echo "揽胜行政 17款 5.0 创世加长 加版";
            $title = "揽胜行政 17款 5.0 创世加长 加版";
            break;

    }

//    echo "</b><br><br>";

    while ($row = $result->fetch_assoc()) {

        $arr[$i] = array($row['make'],$row['year'],$row['trim'],$row['price'],$row['country'],$row['status'],$row['excolor'],$row['incolor'],$row['paper'],$row['vin'],$row['feature']);

        $i++;



        /*echo $i." ";
        if ($submit == "查询") {

            echo $row['make']." ";
            echo $row['year']."款 ";
            echo $row['trim']." ";
            echo $row['country']." ";

        }

        echo $row['price']."万 ";
        echo $row['status']." ";
        echo $row['excolor']." ";
        echo $row['incolor']." ";
        echo $row['paper']." ";
        echo $row['vin']." ";

        if ($submit == "查询") {

            echo $row['feature'];

        }
        echo "<br>";*/
    }

} else {

    printf("query error %s\n",$mysqli->error);

    exit();

}

/* close connection */
$mysqli->close();