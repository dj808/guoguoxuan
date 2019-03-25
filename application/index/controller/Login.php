<?php
namespace app\index\controller;


use think\Db;
use think\Exception;
use think\Request;
use think\Config;


/**
 * 前端首页控制器
 * Class Index
 * @package app\index\controller
 */
class Login extends Base
{


    //获取微信用户的信息
    public  function getWxUserInfo($openid,$access_token){
        $userinfo_url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid";
	  //  $userinfo_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL, $userinfo_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS,false);
        $result = curl_exec($ch);
        curl_close($ch);
        file_put_contents("log_wx.txt", $result);
        $info = json_decode(htmlspecialchars_decode($result), true);
   
        return $info;

    }

    // 用于请求微信接口获取数据
    public  function getOpenid($code){
        //获取微信配置参数
        $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxbf688d9278c13455&secret=97fd69794eaaf983c01a1ba83af83a76&code=$code&grant_type=authorization_code";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $tmpInfo=curl_exec($curl);

        curl_close($curl);
        file_put_contents("log32.log",$tmpInfo,FILE_APPEND);
        
        $openid = json_decode(htmlspecialchars_decode($tmpInfo), true);
        var_dump($openid);die;
        if(isset($openid['openid'])){
            session('opennewid',$openid['openid']);
            session('newaccess_token',$openid['access_token']);
            return $openid;
        }else{
            $newopenid['openid']=session('opennewid');
            $newopenid['access_token']=session('newaccess_token');
            return $newopenid;
        }
    }

    //获取access_token
    public function getAccesstoken()
    {
        //获取微信配置参数
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxbf688d9278c13455&secret=97fd69794eaaf983c01a1ba83af83a76";
        $ch = curl_init();  
        curl_setopt($ch, CURLOPT_POST, 1);  
        curl_setopt($ch, CURLOPT_HEADER, 0);  
        curl_setopt($ch, CURLOPT_URL, $url);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS,false);
        $result = curl_exec($ch);  
        curl_close($ch);
        file_put_contents("log.txt", $result);
        $access_token = json_decode(htmlspecialchars_decode($result), true);
	    
        return $access_token['access_token'];
    }

    //授权反馈
    public function getcodess()
    {
        //获取微信配置参数
        $url = "http://guoguo.loungwangtouzi.com/index/index/index";
        $url =rawurlencode($url);
        
       $s="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxbf688d9278c13455&redirect_uri=$url&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";
      
        header("Location:".$s."");exit;
    }



    /**
     * 验证手机号码
     * @param $phone
     * @return bool
     */
    public  function isValidaMobile($phone){
        return preg_match('/^1[3456789]{1}\d{9}$/',$phone) ? true :false;
    }



}
