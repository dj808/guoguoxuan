<?php
namespace app\index\controller;


use think\Db;
use think\Exception;
use think\Request;
use think\Response;
use think\Controller;

/**
 * 前端首页控制器
 * Class Index
 * @package app\index\controller
 */
class Liuyan extends Base
{
    /**
     * 加盟中心
     */
    public function index()
    {
        $request=Request::instance();
        $user_id=$request->param();

        $this->view->assign('user_id',$user_id['user_id']);
        return  $this->view->fetch();

    }

    /**
     * 加入我们的逻辑
     * @throws Exception
     */
    public function liuyan(){
     $request=Request::instance();
     if($request->isPost()){
          $liuyan=trim($request->param('liuyan'));
          if(!$liuyan){
              return $this->no('-1','留言不能为空');
          }
         try{


             $data=$request->post();
             $data['create_time']=time();
             $userId=Db::name('liuyan')->where('user_id',$data['user_id'])->find();
             if($userId){
                 $res=Db::name('liuyan')->where('user_id',$data['user_id'])->update($data);
             }else{
                 $res=Db::name('liuyan')->insert($data);
             }

             
             if($res){
                 return  $this->ok('1','留言成功');
             }else{
                 return   $this->no('-1','系统繁忙,请重试');

             }
         }catch (\Exception $e){
             throw new Exception($e->getMessage());
         }
     }

  }

}
