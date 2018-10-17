<?php
namespace app\wechat\service;
class LoginService
{
    public static $API_JSCODE2SESSION = 'https://api.weixin.qq.com/sns/jscode2session';
    /**
     * 小程序登录
     * @param (appid,sercret,js_code,grant_type)
     */
    public static function code2Session($param){
        $httpCode=0;
        if(!isset($param['appid'])||!isset($param['secret'])){
            return info('appid and secret is required',-1);
        }
        if(!isset($param['grant_type'])){
            $param['grant_type']='authorization_code';
        }
        $url=static::$API_JSCODE2SESSION.'?'.http_build_query($param);
        $jsonData=curl_get($url,$httpCode);
        // errcode  -1系统繁忙，此时请开发者稍候再试 ,0 请求成功,40029 code无效,45011 频率限制，每个用户每分钟100次
        return [
            'httpCode'=>$httpCode,
            'data'=>$jsonData?json_decode($jsonData):''
        ];
    }

    /**
	 * 敏感数据检测
	 */
	public static function check_sign($encryptedData,$iv,$sessionKey,$appid){
        $pc = new \xcxlogin\WXBizDataCrypt($appid, $sessionKey);
        $errCode = $pc->decryptData($encryptedData, $iv, $data );
        return [
            'code'=>$errCode,
            'data'=>$data
        ];
    }
}