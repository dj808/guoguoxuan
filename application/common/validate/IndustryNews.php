<?php
namespace app\common\validate;

use think\Validate;

class IndustryNews extends Validate
{
    protected $rule = [
        "title|资讯标题" => "require",
        "content|资讯内容" => "require",
        "img|资讯图片" => "require",
    ];
}
