<?php
namespace app\common\model;

use think\Model;

class Wallet extends Model
{
    // 指定表名,不含前缀
    protected $name = 'wallet';
    // 开启自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    //获取提现类型
    public function getStatusType(){
        return   $statusType = [
            [
                'id'   => 0 ,
                'name' => '未提现'
            ] ,
            [
                'id'   => 1 ,
                'name' => '部分提现'
            ] ,
            [
                'id'   => 2 ,
                'name' => '全部提现'
            ]
        ];
    }
   /* public function getStatusType($value, $data){
        $get_data = [
            '0'=>'未付款',
            '1'=>'已付款'
        ];
        return $get_data[$data['is_pay']];
    }*/
}
