<?php
namespace app\common\validate;

use think\Validate;

class Agent extends Validate
{
    protected $rule = [
        "agent_type|代理类型" => "require",
        "agent_name|代理人姓名" => "require",
        "phone|联系电话" => "require",
    ];
}
