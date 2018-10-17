<?php
namespace app\wechat\service;
class AccessTokenService
{
    public static $URL = 'https://api.weixin.qq.com/cgi-bin/token';
    /**
     * 获取access_token
     * @param (grant_type,appid,secret)
     * @return {"access_token":"ACCESS_TOKEN","expires_in":7200}
     */
    public static function refreshToken($param){
        if(!isset($param['appid'])||!isset($param['secret'])){
            return info('appid and secret is required',-1);
        }
        if(!isset($param['grant_type'])){
            $param['grant_type']='client_credential';
        }
        $url=static::$URL.'?'.http_build_query($param);
        $jsonData=curl_get($url,$httpCode);
        // errcode  -1系统繁忙，此时请开发者稍候再试 ,0 请求成功,40001	AppSecret错误或者AppSecret不属于这个公众号，请开发者确认AppSecret的正确性
        // 40002	请确保grant_type字段值为client_credential
        // 40164	调用接口的IP地址不在白名单中，请在接口IP白名单中进行设置。（小程序及小游戏调用不要求IP地址在白名单内。）
        return [
            'httpCode'=>$httpCode,
            'data'=>$jsonData?json_decode($jsonData):''
        ];
    }
}