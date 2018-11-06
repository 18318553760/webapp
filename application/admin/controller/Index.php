<?php
namespace app\admin\controller;
use think\Db;
use think\Controller;

class Index extends Base
{
    public function index()
    {
        //halt(session(config('admin.session_user'), '', config('admin.session_user_scope')));
        $admin_info = session(config('admin.session_user'),'',config('admin.session_user_scope'));  
        return $this->fetch('',[
            'admin_info'=>$admin_info
            ]);
    }

    public function welcome() {
    	$this->assign('system_info',$this->get_system_info());   	
        //print(session(config('admin.session_act_list'), '', config('admin.session_user_scope')));die;	
        return $this->fetch();
    }
     /**
     * 系统信息
     */   
    public function get_system_info(){
        $system['os']             = PHP_OS;
        $system['zlib']           = function_exists('gzclose') ? 'YES' : 'NO';//zlib
        $system['ip']             = GetHostByName($_SERVER['SERVER_NAME']);
        $system['fileupload']     = @ini_get('file_uploads') ? ini_get('upload_max_filesize') :'unknown';
        $system['max_ex_time']    = @ini_get("max_execution_time").'s'; //脚本最大执行时间
        $system['set_time_limit'] = function_exists("set_time_limit") ? true : false;
        $system['php_version']           = phpversion();
        $system['domain']         = $_SERVER['HTTP_HOST'];
        $system['memory_limit']   = ini_get('memory_limit');  
        $system['timezone']       = function_exists("date_default_timezone_get") ? date_default_timezone_get() : "no_timezone";
        $system['curl']           = function_exists('curl_init') ? 'YES' : 'NO';  
        $system['web_server']     = $_SERVER['SERVER_SOFTWARE'];
        $mysqlinfo = Db::query("SELECT VERSION() as version");
        $system['mysql_version']  = $mysqlinfo[0]['version'];
        if(function_exists("gd_info")){
            $gd = gd_info();
            $system['gdinfo']     = $gd['GD Version'];
        }else {
            $system['gdinfo']     = "未知";
        }
        return $system;
    }
}
