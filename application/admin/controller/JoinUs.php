<?php
namespace app\admin\controller;

\think\Loader::import('controller/Controller', \think\Config::get('traits_path') , EXT);
use app\admin\Controller;
use think\exception\HttpException;
use think\Exception;
use think\Db;


class JoinUs extends Controller
{
    use \app\admin\traits\controller\Controller;


    public function edit(){
      if($this->request->isPost()){
          $id=$this->request->param('id');
          $checkStatus=$this->request->param('check_status');
          $res=Db::name('join_us')->where('id', $id)->setField('check_status', $checkStatus);
          if($res){
              return ajax_return_adv('修改成功');
          }else{
              return ajax_return_adv('修改失败');
          }
      }else{
          //获取到该数据的值
          $id = $this->request->param('id');
          if (!$id) {
              throw new Exception("缺少参数ID");
          }
          $vo =  Db::name('join_us')->where('id', $id)->find();
          // print_r($vo);die;
          if (!$vo) {
              throw new HttpException(404, '该记录不存在');
          }

          $this->view->assign('list', $vo);
          return $this->view->fetch();
      }


    }

}
