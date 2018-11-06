<?php
namespace app\admin\controller;

use app\common\validate\AdminUser;
use think\Controller;
use app\common\lib\IAuth;
use think\Db;
use app\common\logic\AdminLogic;

class Login extends Base
{

    public function _initialize() {
    }
    public function index()
    {
        $isLogin = $this->isLogin();
        if($isLogin) {
            return $this->redirect('index/index');
        }else {
            // 如果后台用户已经登录了， 那么我们需要跳到后台页面
            return $this->fetch();
        }
    }

    /**
     * 登录相关业务
     */
    public function check() {
        if(request()->isPost()) {
            $data = input('post.');
            if (!captcha_check($data['code'])) {
                $this->ajaxReturn(['status' => 0, 'msg' => '验证码不正确']);        
            }           
            $adminLogic = new AdminLogic;
            $return = $adminLogic->login($data['username'], $data['password']);                   
            $this->ajaxReturn($return);      
            //halt($user);
        }else {
            $this->ajaxReturn(['status' => 0, 'msg' => '请求不合法']);            
        }
    }    

    /**
     * 退出登录的逻辑
     * 1、清空session
     * 2、 跳转到登录页面
     */
    public function logout() {
        $adminLogic = new AdminLogic;
        $adminLogic->logout();
         // 跳转
        $this->redirect('login/index');
    }
}
