<?php
namespace app\common\validate;

use think\Validate;

class User extends Validate
{
    protected $rule = [
        "mobile|手机号码" => "require",
        "password|密码" => "require",
        "username|姓名" => "require",
        "nickname|昵称" => "require",
    ];
}
