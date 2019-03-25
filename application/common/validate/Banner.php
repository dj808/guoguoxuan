<?php
namespace app\common\validate;

use think\Validate;

class Banner extends Validate
{
    protected $rule = [
        "logo|轮播图片" => "require",
    ];
}
