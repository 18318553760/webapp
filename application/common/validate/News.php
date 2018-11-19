<?php
/**
 * Created by PhpStorm.
 * User: hongshao
 * Date: 18/11/2
 * Time: 下午4:35
 */
namespace app\common\validate;

use think\Validate;
class News extends Validate {

    protected $rule = [
        'title' => 'require',
        'catid' => 'require',
    ];
    protected $message = [
	    'title.require' => '标题不能为空',
	    'catid.require'     => '分类不能为空',	   
	];
}