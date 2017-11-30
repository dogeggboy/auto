<?php
/**
 * Created by PhpStorm.
 * User: qt
 * Date: 2017/11/29
 * Time: 23:38
 */

require ("dataapi.php");

function taskgroup ($url,$token) {
    $arr = explode('"', $token);
    $access_token = $arr[3];

// Create a stream
    $options = array(
        'http'=>array(
            'method'=>"GET",
            'header'=>"Accept-language: en\r\n" .
                "Cookie: foo=bar\r\n" .
                "Authorization: bearer $access_token"
        )
    );

    $context = stream_context_create($options);

// Open the file using the HTTP headers set above
    $result = file_get_contents($url, false, $context);

    return $result;
}

$taskgroup = taskgroup("http://dataapi.bazhuayu.com/api/taskgroup",$token);

echo $taskgroup."<br>";



function getdata ($url,$token) {
    $arr = explode('"', $token);
    $access_token = $arr[3];

// Create a stream
    $options = array(
        'http'=>array(
            'method'=>"GET",
            'header'=>"Accept-language: en\r\n" .
                "Cookie: foo=bar\r\n" .
                "Authorization: bearer $access_token"
        )
    );

    $context = stream_context_create($options);

// Open the file using the HTTP headers set above
    $result = file_get_contents($url, false, $context);

    return $result;
}

$taskId = "19f5081c-1668-4d0d-a756-08b8ca3da67e";
$size = 100;

$getdata = getdata("http://dataapi.bazhuayu.com/api/notexportdata/gettop?taskId=$taskId&size=$size",$token);


print_r($getdata);
$getdata = json_decode($getdata,true);


foreach ($getdata['data']['dataList'] as $row) {
    echo $row['name']."<br>";
}

