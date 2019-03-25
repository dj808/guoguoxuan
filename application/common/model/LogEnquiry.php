<?php
namespace app\common\model;

use think\Model;

class LogEnquiry extends Model
{
    // 指定表名,不含前缀
    protected $name = 'log_enquiry';
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    //获取车辆类型
    public function getCarType(){
        return   $agentType = [
            [
                'id'   => 1 ,
                'name' => '公车'
            ] ,
            [
                'id'   => 2 ,
                'name' => '私车'
            ] ,
            [
                'id'   => 3 ,
                'name' => '公私车'
            ]
        ];
    }
    //获取车辆类型
    public function getInsureType(){
        return   $agentType = [
            [
                'id'   => 1 ,
                'name' => '公车'
            ] ,
            [
                'id'   => 2 ,
                'name' => '私车'
            ] ,
            [
                'id'   => 3 ,
                'name' => '公私车'
            ] ,
            [
                'id'   => 4 ,
                'name' => '保险公司'
            ] ,
            [
                'id'   => 5 ,
                'name' => '其他'
            ]
        ];
    }
}
