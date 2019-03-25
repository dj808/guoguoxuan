<?php
namespace app\admin\controller;

\think\Loader::import('controller/Controller', \think\Config::get('traits_path') , EXT);
use app\admin\Controller;
use think\Db;


class ShareNum extends Controller
{
    use \app\admin\traits\controller\Controller;
    public  function index(){
        $list= Db::name('share_num')
            ->alias('a')
            ->field('b.nickname,a.*')
            ->join('__JOIN_NUM__ b','a.user_id=b.id')
            ->select();
        $this->view->assign('list',$list);
        return $this->view->fetch();
    }
}
