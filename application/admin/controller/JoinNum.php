<?php
namespace app\admin\controller;

\think\Loader::import('controller/Controller', \think\Config::get('traits_path') , EXT);
use app\admin\Controller;


class JoinNum extends Controller
{
    use \app\admin\traits\controller\Controller;

}
