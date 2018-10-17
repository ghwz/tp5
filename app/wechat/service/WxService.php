<?php
namespace app\wechat\service;
class WxService
{
    /**
     * 验证连接性
     */
    public function checkSignature($signature,$timestamp,$nonce,$token){
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
    /**
     * 回复响应
     */
    public function responseMsg($param){
        $encodingAesKey = "xxxxx";  //服务器配置中的消息加解密密钥(EncodingAESKey)
        $token = "xxxxx"; //服务器配置中的令牌(Token)
        $appId = "xxxxx";  //你的appid

        $msgSignature = $_GET['msg_signature'];
        $timestamp = $_GET['timestamp'];
        $nonce = $_GET['nonce'];
        $xml = file_get_contents('php://input');
        $pc = new \weixin\WXBizMsgCrypt($token, $encodingAesKey, $appId);
        $msg='';
        $errCode = $pc->decryptMsg($msgSignature, $timestamp, $nonce, $xml, $msg);//开始解密
        /**
         * 解密后：SimpleXMLElement Object
         *  (
         *     [ToUserName] => gh_ccd0831e3278
         *     [FromUserName] => oruGLxFbHnKMfpObLqPhcUpQxSeM
         *     [CreateTime] => 1535118118
         *     [MsgType] => text
         *     [Content] => 你好
         *     [MsgId] => 6593282112790573815
         * )
         */
        if ($errCode==0&&!empty($msg)){
            $RX_TYPE = trim($postObj->MsgType);
            //用户发送的消息类型判断
            $result="";
            switch ($RX_TYPE)
            {
                case "text":    //文本消息
                    break;
                case "image":   //图片消息
                    break;
                case "voice":   //语音消息
                    break;
                case "video":   //视频消息
                    break;
                case "location"://位置消息
                    break;
                case "link":    //链接消息
                    break;
                default:
                    $result = "unknow msg type: ".$RX_TYPE;
                    break;
            }
            echo $result;
        }else{
           //解密失败
        }
    }
}
?>