<?php
/**
 * Created by PhpStorm.
 * User: hongshao
 * Date: 18/11/2
 * Time: 下午4:35
 */
namespace app\common\validate;

use think\Validate;
class AdminUser extends Validate {

    protected $rule = [
        'username' => 'require|max:20',
        'password' => 'require|max:20',
    ];
    protected $message = [
	    'username.require' => '用户名不能为空',
	    'username.max'     => '用户名最多不能超过20个字符',
	    'password.require' => '密码不能为空',
	    'password.max'     => '密码最多不能超过20个字符',	
	];
}