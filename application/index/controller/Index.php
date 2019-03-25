<?php
namespace app\index\controller;


use think\Db;
use think\Exception;
use think\Request;
use think\Response;
use think\Controller;
use think\Config;



/**
 * 前端首页控制器
 * Class Index
 * @package app\index\controller
 */
class Index extends Controller
{

   /* public function login(){
         $uid=$this->request->param('id');
           session('userpid',$uid);
            $s="http://guoguo.loungwangtouzi.com/index/index/index";
            header("Location:".$s."");exit;

    }*/

    //首页
    public function index(){
        //微信授权获取基本信息

        if ($this->request->param('code')==''){//没有code，去微信接口获取code码

              $this->getcodess();
            file_put_contents("log322.log",2);
        } else {//获取code后跳转回来到这里了
            $code=$this->request->param('code');
            $openid = $this->getOpenid($code);
            $access_token=$this->getAccesstoken();
            $wxUserInfo=$this->getWxUserInfo(session('opennewid'),session('newaccess_token'));

            $user_openid = $wxUserInfo['openid'];
            session('useropenid',$user_openid);
            // 判断用户是否存在
            $data_user = Db::name('join_num')->where('open_id',$user_openid)->find();
            if(empty($data_user)){
                $data['open_id'] = $user_openid;
                $data['nickname']=substr($wxUserInfo['nickname'],0,6);;
                $data['avatar']=$wxUserInfo['headimgurl'];
                $data['create_time']=time();
                Db::name('join_num')->insert($data);
            }else{
                $data['nickname']=substr($wxUserInfo['nickname'],0,6);;
                $data['avatar']=$wxUserInfo['headimgurl'];
                $data['update_time']=time();
                Db::name('join_num')->where('open_id',$user_openid)->update($data);
            }
        }



        // 判断用户是否存在
        $userId = Db::name('join_num')->field('id')->where('open_id',session('useropenid'))->find();
        $this->view->assign('userId',$userId['id']);

        //获取分享人的信息
        $shareNum=Db::name('share_num')
            ->alias('a')
            ->field('a.share_money,b.nickname,b.avatar')
            ->join('__JOIN_NUM__ b','a.user_id=b.id')
            ->select();
        $this->view->assign('shareNum',$shareNum);

        $shareCount=Db::name('share_num')->count('id');
        $this->view->assign('shareCount',$shareCount);
        //相关信息

        $about=Db::name('about')->find();
        $this->view->assign('about',$about);


        //金句排行版
        $liuyan=Db::name('liuyan')
            ->alias('a')
            ->field('a.liuyan,a.create_time,b.nickname,b.avatar')
            ->join('__JOIN_NUM__ b','a.user_id=b.id')
            ->select();
        $this->view->assign('liuyan',$liuyan);


        return   $this->view->fetch();
    }



    //获取微信用户的信息
    public  function getWxUserInfo($openid,$access_token){
        $userinfo_url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid";
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
        curl_setopt($curl, CURLOPT_URL,$url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $tmpInfo=curl_exec($curl);

        curl_close($curl);
        file_put_contents("log_openid.log",$tmpInfo,FILE_APPEND);
        $openid = json_decode(htmlspecialchars_decode($tmpInfo), true);
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
        $wxConfig = Config::get('wechat');
        $appId=$wxConfig['AppId'];
        $appSecret=$wxConfig['AppSecret'];
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appId&secret=$appSecret";
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
        file_put_contents("log_accesstoken.txt", $result);
        $access_token = json_decode(htmlspecialchars_decode($result),true);
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
