<?php
namespace app\admin\controller;

\think\Loader::import('controller/Controller', \think\Config::get('traits_path') , EXT);
use app\admin\Controller;
use think\exception\HttpException;
use think\Exception;
use think\Db;


class Liuyan extends Controller
{
    use \app\admin\traits\controller\Controller;

    public  function index(){
        $list= Db::name('liuyan')
            ->alias('a')
            ->field('b.nickname,a.*')
            ->join('__JOIN_NUM__ b','a.user_id=b.id')
            ->select();
        $this->view->assign('list',$list);
        return $this->view->fetch();
    }

    public function edit(){
      if($this->request->isPost()){
          $id=$this->request->param('id');
          $checkStatus=$this->request->param('check_status');
          $res=Db::name('liuyan')->where('id', $id)->setField('check_status', $checkStatus);
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
          $vo =  Db::name('liuyan')->where('id', $id)->find();

          if (!$vo) {
              throw new HttpException(404, '该记录不存在');
          }

          $this->view->assign('list', $vo);
          return $this->view->fetch();
      }


    }

}
