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

echo $taskgroup;