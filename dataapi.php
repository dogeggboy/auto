<?php
/**
 * Created by PhpStorm.
 * User: qt
 * Date: 2017/11/29
 * Time: 20:26
 */

/**
 * 发送post请求
 * @param string $url 请求地址
 * @param array $post_data post键值对数据
 * @return string
 */

//获取TOKEN
function send_post($url, $post_data) {

    $postdata = http_build_query($post_data);
    $options = array(
        'http' => array(
            'method' => 'POST',
            'header' => 'Content-type:application/x-www-form-urlencoded',
            'content' => $postdata,
            'timeout' => 15 * 60 // 超时时间（单位:s）
        )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $result = json_decode($result,true);
    $result = $result['access_token'];
    return $result;
}

//使用方法
$post_data = array(
    'username' => 'wizardqt',
    'password' => 'wscaomin2',
    'grant_type' => 'password'
);

$access_token = send_post('http://dataapi.bazhuayu.com/token', $post_data);

/*//获取任务组
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

$taskgroup = taskgroup("http://dataapi.bazhuayu.com/api/taskgroup",$token);*/

//导出数据
function exdata ($url,$access_token) {
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


/*function aexdata($url, $post_data) {

    $options = array(
        'http' => array(
            'method' => 'GET',
            'header' => 'Content-type:application/x-www-form-urlencoded',
            'content' => $post_data,
            'timeout' => 15 * 60 // 超时时间（单位:s）
        )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    return $result;
}*/
