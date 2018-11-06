<?php
/**
 * Created by PhpStorm.
 * User: hongshao
 * Date: 18/11/2
 * Time: 下午4:35
 */
namespace app\api\controller;

use think\Controller;
use app\common\lib\exception\ApiException;
use app\common\lib\Aes;

class Time extends Controller {

    public function index() {
        return show(1, 'OK', time());
    }
}