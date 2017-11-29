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
header("Content-type: text/html; charset=utf-8");

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

//表名
$table = $_GET['table'];

//SQL语句
$query = "SELECT * FROM 000".$table;

//如果得到查询数据
if ($result = $mysqli->query($query)) {

    //临时表里的数据行数
    $z = $mysqli->affected_rows;

    //好玩
    $i = 0;
    $j = 0;

    //循环处理数据
    while ($row = $result->fetch_assoc()) {

        //检测INFO数据是否含有车架号三个字
        $str = $row["info"];
        $findme = '车架号';
        $pos = strpos($str, $findme);

        //如果INFO数据有车架号三个字
        if ($pos !== false) {

            //处理字符串
            $arr = explode('车架号', $str);

            //从字符串里提取出数字做为车架号。
            preg_match_all('/\d+/',$arr[1],$vin);

            $vin = $vin[0][0];

            //判断车架号是否大于四位，如果字符串里存在两个及以上车架号，只取第一个，第二个及之后没做处理。
            if (strlen($vin) >= 4) {

                $vin = substr($vin,-4);

            } else {

                continue;

            }

        } else {

            continue;

        }

        $query = "SELECT * FROM ".$table." WHERE vin = ".$vin."";

        if (!$result_1 = $mysqli->query($query)) {

            //打印错误
            printf("Query vin Error: %s\n", $mysqli->error);

            exit();

        }

        $str = $row["price"];
        $arr = explode('万', $str);
        $price = $arr[0];

        //如果数据库存在相同车架号数据
        if ($mysqli->affected_rows) {

            $row_1 = $result_1->fetch_assoc();

            //如果该车标识为已售更新为未售
            if ($row_1['sell'] == 1) {

                $update = "UPDATE ".$table." SET sell = 0 WHERE vin = ".$vin;

                if (!$mysqli->query($update)) {

                    //打印错误
                    printf("Update price Error: %s\n", $mysqli->error);

                    exit();

                }

            }

            if ($row_1['price'] <= $price) {

                continue;

            } else {

                //设置时区
                date_default_timezone_set('PRC');
                $time = time();

                $update = "UPDATE ".$table." SET price = ".$price.",time = ".$time." WHERE vin = ".$vin;

                if (!$mysqli->query($update)) {

                    //打印错误
                    printf("Update price Error: %s\n", $mysqli->error);

                    exit();

                }

                $j++;

            }

            continue;

        }

        $str = $row["name"];
        $arr = explode(' ', $str);

        $make = $arr[0];

        $arr = explode('款', $arr[1]);
        $year = $arr[0];

        $arr = explode($year.'款 ', $str);
        $trim = $arr[1];

        $feature = $row["feature"];

        $str = $row["info"];
        $arr = explode('|', $str);

        $str = $arr[0];
        $arr_1 = explode('版', $str);

        $country = $arr_1[0];
        $status = $arr_1[1];

        $str = $arr[1];
        $arr_1 = explode('/', $str);

        $excolor = $arr_1[0];
        $incolor = $arr_1[1];

        if ($arr[3]) {

            $paper = $arr[2];

        } else {

            $paper = "";

        }

        $location = "";
        $cell = "";
        $photo = "";

        $sell = 0;

        //设置时区
        date_default_timezone_set('PRC');
        $time = time();
        $date = date('Y-m-d');

        //插入数据库
        $insert = "INSERT INTO ".$table." (id,make,year,trim,price,country,status,excolor,incolor,paper,vin,feature,location,cell,photo,sell,time,date) VALUES (NULL,'".$make."','".$year."','".$trim."','".$price."','".$country."','".$status."','".$excolor."','".$incolor."','".$paper."','".$vin."','".$feature."','".$location."','".$cell."','".$photo."',".$sell.",".$time.",'".$date."');";

        //插入数据
        if (!$mysqli->query($insert)) {

            //打印错误
            printf("Insert Error: %s\n", $mysqli->error);

            exit();

        } else {

            $i++;
            echo $i." ";

        }

    }

    /* free result set */
    $result->free();

} else {

    printf("Query table Error: %s\n", $mysqli->error);

    exit();

}

//如果临时表有数据
if ($z != 0) {

    //更新是否已售（查询已有车架号在新数据里是否存在，如果不存在说明该车已售）
    $query = "SELECT * FROM ".$table." WHERE sell = 0";

    if ($result = $mysqli->query($query)) {

        while ($row = $result->fetch_assoc()) {

            $vin = $row['vin'];

            $query = "SELECT * FROM 000".$table." WHERE info LIKE '%".$vin."%'";

            $mysqli->query($query);

            if ($mysqli->affected_rows) {

                continue;

            } else {

                //设置时区
                date_default_timezone_set('PRC');
                $time = time();

                $update = "UPDATE ".$table." SET sell = 1,time = ".$time." WHERE vin = ".$vin;

                if (!$mysqli->query($update)) {

                    //打印错误
                    printf("Update sell Error: %s\n", $mysqli->error);

                    exit();

                }

            }

        }

    } else {

        printf("Query table Error: %s\n", $mysqli->error);

        exit();

    }

    //清空临时数据表
    $Truncate = "TRUNCATE TABLE 000".$table;

    if (!$mysqli->query($Truncate)) {

        //打印错误
        printf("Truncate Error: %s\n", $mysqli->error);

        exit();

    }

    echo "清空临时数据表 ";

}

if ($i === 0) {

    echo "没有新数据 ";

}

if ($j !== 0) {

    echo "更新数据".$j;

}

/* close connection */
$mysqli->close();