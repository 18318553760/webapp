<?php
/**
 * Created by PhpStorm.
 * User: hongshao
 * Date: 18/11/2
 * Time: 下午4:35
 */
namespace app\common\validate;

use think\Validate;
class Identify extends Validate {

    protected $rule = [
        'id' => 'require|number|length:11',
    ];
}