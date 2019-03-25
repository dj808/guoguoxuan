<?php
namespace app\common\model;

use think\Model;

class Order extends Model
{
    // 指定表名,不含前缀
    protected $name = 'order';
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    //获取订单状态类型
    public function getOrderStatus(){
        return   $statusType = [
            [
                'id'   => 0 ,
                'name' => '待付款'
            ] ,
            [
                'id'   => 1 ,
                'name' => '待配送'
            ] ,
            [
                'id'   => 2 ,
                'name' => '已完成'
            ]
        ];
    }
    //获取订单状态类型
    public function getPayMode(){
        return   $statusType = [
            [
                'id'   => 1 ,
                'name' => '微信支付'
            ] ,
            [
                'id'   => 2 ,
                'name' => '支付宝支付'
            ] ,
            [
                'id'   => 3 ,
                'name' => '银联支付'
            ],
            [
                'id'   => 4 ,
                'name' => '其他'
            ]
        ];
    }
}
