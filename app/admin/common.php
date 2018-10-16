<?php

function info($msg = '', $code = '', $url = '',  $data = '', $wait = 3 )
{
    if (is_numeric($msg)) {
        $code = $msg;
        $msg  = '';
    }
    if (is_null($url) && isset($_SERVER["HTTP_REFERER"])) {
        $url = $_SERVER["HTTP_REFERER"];
    } elseif ('' !== $url) {
        $url = preg_match('/^(https?:|\/)/', $url) ? $url : Url::build($url);
    }
	$result = [
        'code' => $code,
        'msg'  => $msg,
        'data' => $data,
        'url'  => $url,
        'wait' => $wait,
	];
	return $result;
}
/**
 * url处理
 * 返回模块+控制器
 */
function url_handle($url=''){
    $urlArr=explode('/',$url);
    if(count($urlArr)>1){
        return $urlArr[0].'-'.$urlArr[1];
    }
    return $url;
}

?>