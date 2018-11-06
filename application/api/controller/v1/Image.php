<?php
/**
 * Created by PhpStorm.
 * User: hongshao
 * Date: 18/11/2
 * Time: 下午4:35
 */
namespace app\api\controller\v1;

use app\api\controller\Common;
use think\Controller;
use app\common\lib\exception\ApiException;
use app\common\lib\Aes;
use app\common\lib\Upload;

class Image extends AuthBase {

    public function save() {
        //print_r($_FILES);
        $image = Upload::image();
        if($image) {
           return show(config('code.success'), 'ok', config('qiniu.image_url').'/'.$image);
        }
    }
}