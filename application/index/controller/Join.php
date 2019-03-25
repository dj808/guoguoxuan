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
class Join extends Base
{
    /**
     * 加盟中心
     */
    public function index()
    {
        return  $this->view->fetch();

    }

    /**
     * 加入我们的逻辑
     * @throws Exception
     */
    public function join(){
     $request=Request::instance();
     if($request->isPost()){
          $companyName=trim($request->param('company_name'));
          if(!$companyName){
              return $this->no('-1','公司名称不能为空');
          }
          $userName=trim($request->param('user_name'));
          if(!$userName){
              return $this->no('-1','用户姓名不能为空');
          }
          $phone=trim($request->param('phone'));
          if(!$phone){
              return $this->no('-1','电话号码不能为空');
          }
          if(false===$this->isValidaMobile($phone)){
              return $this->no('-1','手机号码不正确');
          }
         try{
             $data=$request->post();
             $data['create_time']=time();
            
             $res=Db::name('join_us')->insert($data);
             if($res){
                 return  $this->ok('1','加盟成功');
             }else{
                 return   $this->no('-1','系统繁忙,请重试');

             }
         }catch (\Exception $e){
             throw new Exception($e->getMessage());
         }
     }

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
