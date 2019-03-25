<?php
namespace app\common\model;

use think\Model;

class Agent extends Model
{
    // 指定表名,不含前缀
    protected $name = 'agent';
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    //获取代理类型
    public function getAgentType(){
          return   $agentType = [
                [
                    'id'   => 0 ,
                    'name' => '代理人'
                ] ,
                [
                    'id'   => 1 ,
                    'name' => '查勘员'
                ] ,
                [
                    'id'   => 2 ,
                    'name' => '车行'
                ] ,
                [
                    'id'   => 3 ,
                    'name' => '保险公司'
                ] ,
                [
                    'id'   => 4 ,
                    'name' => '其他'
                ]
            ];
    }
    //获取审核类型
    public function getStatusType(){
          return   $statusType = [
                [
                    'id'   => 0 ,
                    'name' => '待审核'
                ] ,
                [
                    'id'   => 1 ,
                    'name' => '审核中'
                ] ,
                [
                    'id'   => 2 ,
                    'name' => '审核通过'
                ] ,
                [
                    'id'   => 3 ,
                    'name' => '审核失败'
                ]
            ];
    }

}
