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
class Base extends Controller
{
    public function no($code, $message, $data = '')
    {
        if ($data == '') {
            $result = array(
                "code" => $code,
                "message" => $message,
                "data" => $data
            );
        } else {
            $result = array(
                "code" => $code,
                "message" => $message,
                "data" => $data
            );
        }
        return json($result);
    }

    public function ok($code, $message, $data = '')
    {
        if ($data == '') {
            $result = array(
                "code" => $code,
                "message" => $message,
            );
        } else {
            $result = array(
                "code" => $code,
                "message" => $message,
                "data" => $data
            );
        }

        return json($result);
    }
    /**
     * 返回标准错误json信息
     */
     function ajax_return_error($msg = "出现错误", $code = 1, $data = [], $extend = [])
     {
         return ajax_return($data, $msg, $code, $extend);
     }




}