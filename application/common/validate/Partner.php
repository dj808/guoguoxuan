<?php
namespace app\common\validate;

use think\Validate;

class Partner extends Validate
{
    protected $rule = [
        "logo|合作伙伴LOGO" => "require",
        "name|合作伙伴名称" => "require",
    ];
}
