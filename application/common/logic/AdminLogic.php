<?php
/**
 * Created by PhpStorm.
 * User: hongshao
 * Date: 18/11/1
 * Time: 下午5:25
 */

namespace app\common\logic;
use app\common\validate\AdminUser;
use app\common\lib\IAuth;
use think\Db;
class AdminLogic
{
    public function login($username, $password)
    {
        if (empty($username) || empty($password)) {
            return ['status' => 0, 'msg' => '请填写账号密码'];
        }
        // validate机制

        try {
            // username  username+password
            $user = model('AdminUser')->get(['username' => $username]);
        }catch (\Exception $e) {
            return ['status' => 0, 'msg' => $e->getMessage()];
        }

        if (!$user || $user->status != config('code.status_normal')) {
            return ['status' => 0, 'msg' => '用户不存在'];
        }      
        // 再对密码进行校验
        if (IAuth::setPassword($password) != $user['password']) {
            return ['status' => 0, 'msg' => '密码不正确'];
        }
        try {
            $admin = Db::name('admin_user')
                ->alias([config('database.prefix').'admin_user' => 'a', config('database.prefix').'admin_role' => 'b'])
                ->join(config('database.prefix').'admin_role', 'a.role_id=b.role_id')
                ->where('a.id',$user['id'])
                ->find();
        } catch (Exception $e) {
              return ['status' => 0, 'msg' => $e->getMessage()];
        } 
        $this->handleLogin($admin,$admin['act_list']);
        $url = session('from_url') ? session('from_url') : url('index/index');
        return ['status' => 1, 'url' => $url];       
    }

    public function handleLogin($user,$act_list){    
        // 1 更新数据库 登录时间 登录ip
        
        $udata = [
            'last_login_time' => time(),
            'last_login_ip' => request()->ip(),
        ];
        try {
            model('AdminUser')->save($udata, ['id' => $user->id]);
        }catch (\Exception $e) {
            return ['status' => 0, 'msg' => $e->getMessage()];
        }
        // 2 session
        session(config('admin.session_act_list'),$act_list,config('admin.session_user_scope')); 
        session(config('admin.session_admin_id'), $user['id'], config('admin.session_user_scope')); 
        session(config('admin.session_user'), $user, config('admin.session_user_scope'));  
        $this->adminLog('后台登录');       
    }



    public function logout()
    {
        session(null, config('admin.session_user_scope'));       

    }
    /**
     * 管理员操作记录
     * @param $log_info string 记录信息
     */
    public function adminLog($log_info){
        $add['log_time'] = time();
        $add['admin_id'] =  session(config('admin.session_admin_id'), '', config('admin.session_user_scope'));
        $add['log_info'] = $log_info;
        $add['log_ip'] = request()->ip();
        $add['log_url'] = request()->baseUrl();   
        try {
            Db::name('admin_log')->insert($add);
        }catch (\Exception $e) {           
        }
     
    }

}






