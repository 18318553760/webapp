<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use app\common\logic\ModuleLogic;
use app\common\logic\AdminLogic;
class Admin extends Base
{
    public function index() {
        $data = input('param.');
        $query = http_build_query($data);
        //halt($data);
        $whereData = [];
        // 转换查询条件   
        if(!empty($data['username'])) {
             $whereData['username|email'] = ['like', '%'.$data['username'].'%'];           
        }
        // 获取数据 然后数据 填充到模板  
        $this->getPageAndSize($data);
        // 获取表里面的数据
        $user = model('Admin_user')->getUserByCondition($whereData, $this->from, $this->size);
        // 获取满足条件的数据总数 =》 有多少页
        $total = model('Admin_user')->getUserCountByCondition($whereData);

        return $this->fetch('', [    
            'user' => $user['list'],
            'total' => $total?$total:0,                
            'username' => empty($data['username']) ? '' : $data['username'],   
            'page'=>$user['page']
        ]);
    }
     /**
     * 权限列表操作
     * 1、添加管理者
     * 2、 编辑管理者
     */
    public function handle()
    {
        // 判定是否是post提交
        if(request()->isPost()) {          
            $data = input('post.');
            $act=$data['act'];
            unset($data['act']);
            // validate
            $validate = validate('AdminUser');
            if(!$validate->check($data)) {
                $this->error($validate->getError());                      
            }          
            $data['password'] = md5($data['password'].config('app.password_pre_halt'));
            $data['status'] = 1;       
            // 1 exception
            // 2 handle data
            if($act == 'add'){
                unset($data['id']);           
                $data['create_time'] = time();
                if(model('AdminUser')->where(["username"=>$data['username']])->count()){
                    $this->error("此用户名已被注册，请更换",'Admin/handle');
                }else{
                    try {
                        $result = model('AdminUser')->add($data);
                    }catch (\Exception $e) {
                        $this->error($e->getMessage());
                    }
                }
            }            
            if($act == 'edit'){
                try {
                    $result = model('AdminUser')->save($data,['id'=>$data['id']]);
                }catch (\Exception $e) {
                    $this->error($e->getMessage());   
                }
            }  
            if($result) {
                $this->success('操作成功',url('Admin/index'));      
            }else {
                $this->error('操作失败');           
            }
        }else {
            $id = input('id/d');            
            if($id){
                $info = model('AdminUser')->where("id", $id)->find();
                $info['password'] =  "";
                $this->assign('info',$info);
            }
            $act = empty($id) ? 'add' : 'edit';
            $this->assign('act',$act);         
            $role = Db::name('admin_role')->select();
            $this->assign('role',$role);
            return $this->fetch();
        }        
    }
   
    /**
     * 删除管理员
     */
    public function delete(){
        $data=input('param.'); 
        //批量删除
        if ($data['batchFlag']) {
            return $this->delBatch($data);           
        }          
        if($data['id']>1){
            try {
                $result = model('AdminUser')->where('id', $data['id'])->delete();
            }catch (\Exception $e) {
                $this->error($e->getMessage());   
            }
            if($result) {
                // $this->ajaxReturn(['code'=>'1']);
                return $this->result(['url' => $_SERVER['HTTP_REFERER']], 1, 'OK');
            }else {
                return $this->result('', 0, '删除失败');          
            }            
        }else{
           return $this->result('', 0, '删除失败');  
        }  
    }
     /**
     * 批量彻底删除
     */
   
    public function delBatch($data){
        $idArr = $data['ids'];  
        if (!is_array($idArr)) {
            return $this->result('', 0, '请选择要删除的项');          
        }
        if(in_array('1',$idArr)){
            unset($idArr[array_search(1,$idArr)]);// 利用unset删除为1的管理员
        }  
        $where = array('id' => array('in', $idArr));
        if (model('AdminUser')->where($where)->delete()) {
            return $this->result(['url' => $_SERVER['HTTP_REFERER']], 1, 'OK');
        } else {
           return $this->result('', 0, '删除失败');  
        }
    }
    /**
     * 角色列表   
     */
    public function role(){
        $data = input('param.');        
        //halt($data);
        $whereData = [];
        // 转换查询条件   
        if(!empty($data['role_name'])) {
            $whereData['role_name'] = ['like', '%'.$data['role_name'].'%'];           
        }
        // 获取数据 然后数据 填充到模板  
        $this->getPageAndSize($data);
        $result=model('AdminRole')->getRoleByCondition($whereData,$this->size);
        $total = model('AdminRole')->getRoleCountByCondition($whereData);     
        return $this->fetch('', [    
            'role' => $result,
            'total' => $total?$total:0,                
            'role_name' => empty($data['role_name']) ? '' : $data['role_name'],   
            'page'=>$result->render()
        ]);       
    }
    /**
     * 角色列表操作
     * 1、添加管理者
     * 2、 编辑管理者
     */
    public function role_handle(){
        // 判定是否是post提交
        if(request()->isPost()) {          
            $data = input('post.');
            $this->roleSave($data);
        }else {
            $role_id = input('role_id/d'); 
            $actlist = array();
            if($role_id){
                $actlist = model('AdminRole')->get(['role_id' => $role_id]);
                $actlist['act_list'] = explode(',', $actlist['act_list']);
                $this->assign('actlist',$actlist);
            }  
            $right = Db::name('system_menu')->order('id')->select();
            foreach ($right as $key => $val) {
               if(!empty($actlist)){
                    $val['enable'] = in_array($val['id'], $actlist['act_list']);
                }
                $modules[$val['group']][] = $val;// 数组分类，同进栈
            }
            //admin权限组
            $group = (new ModuleLogic)->getPrivilege(0);
            $this->assign('group',$group);
            $this->assign('modules',$modules);
            return $this->fetch();
        }   
    }
    /**
     * 编辑角色操作
     */
    public function roleSave($data){       
        $res = $data['data'];
        if(empty($res['role_name']))
            $this->error("请输入您注册时所填的角色名称!"); 
        $res['act_list'] = is_array($data['right']) ? implode(',', $data['right']) : '';
        if(empty($res['act_list']))
            $this->error("请选择权限!");        
        if(empty($data['role_id'])){
            $admin_role = model('AdminRole')->get(['role_name' => $res['role_name']]);
            // $admin_role = Db::name('admin_role')->where(['role_name'=>$res['role_name']])->find();
            if($admin_role){
                $this->error("已存在相同的角色名称!");
            }else{
                try {
                    model('AdminRole')->insert($res);
                    // Db::name('admin_role')->insert($res);
                }catch (\Exception $e) {
                    $this->error($e->getMessage());
                }               
            }
        }else{
            $admin_role = model('AdminRole')->where(['role_name'=>$res['role_name'],'role_id'=>['neq',$data['role_id']]])->find();
            if($admin_role){
                $this->error("已存在相同的角色名称!");
            }else{
                try {
                    model('AdminRole')->where('role_id', $data['role_id'])->update($res);
                    // Db::name('admin_role')->where('role_id', $data['role_id'])->update($res);
                }catch (\Exception $e) {
                    $this->error($e->getMessage());
                } 
            }
        }        
        (new AdminLogic)->adminLog('管理角色');
        $this->success("操作成功!",url('Admin/role'));
       
    }
    /**
     * 删除角色
     */
    public function role_delete(){
        $this->model='AdminRole';
        $this->nomaldelete('role_id');die;
        $data=input('param.');        
        // 批量删除
        if ($data['batchFlag']) {
            return $this->role_delBatch($data);           
        }  
        try {
            $result = Db::name('admin_role')->where(array('role_id'=>$data['role_id']))->delete();
        }catch (\Exception $e) {
            $this->error($e->getMessage());   
        }
        if($result) {         
            return $this->result(['url' => $_SERVER['HTTP_REFERER']], 1, '删除成功');  
        }else {
            return $this->result('', 0, '删除失败');           
        }            
    
    }
     /**
     * 批量彻底删除角色
     */   
    public function role_delBatch($data){
        $idArr = $data['ids'];  
        if (!is_array($idArr)) {
            $this->error('请选择要删除的项');
        }        
        $where = array('role_id' => array('in', $idArr));
        if (Db::name('admin_role')->where($where)->delete()) {
            return $this->result(['url' => $_SERVER['HTTP_REFERER']], 1, '删除成功'); 
        } else {
            return $this->result('', 0, '删除失败'); 
        }
    }
    /**
    * 权限列表
    */ 
    public function privilege(){
        $data = input('param.'); 
        // halt($data);
        $type=$data['type']?$data['type']:0;
        $moduleLogic = new ModuleLogic;
        if (!$moduleLogic->isModuleExist($type)) {
            $this->error('权限类型不存在');
        } 
        $whereData = array();
        $modules = $moduleLogic->getModules();

        $group = $moduleLogic->getPrivilege($type);

        $whereData['type'] = $type; 
        // 转换查询条件   
        if(!empty($data['name'])) {
            $whereData['name|right'] = ['like', '%'.$data['name'].'%'];           
        }        
        // 获取数据 然后数据 填充到模板  
        $this->getPageAndSize($data);
        $total=Db::name('system_menu')->where($whereData)->count();
        $list = Db::name('system_menu')->where($whereData)->order('id desc')->paginate($this->size,false,[        
            // 使用函数助手传入参数
            'query' => request()->param(),
            ]);
        return $this->fetch('', [    
            'list' => $list,
            'total' => $total?$total:0,                
            'name' => empty($data['name']) ? '' : $data['name'],   
            'page'=>$list->render(),
            'group'=>$group,
            'modules'=>$modules
        ]); 
    }
    /**
    * 权限列表
    */ 
    public function privilegehandle(){
        $type = input('type',0);  //0:平台权限资源;1:商家权限资源           
        $moduleLogic = new ModuleLogic;
        if (!$moduleLogic->isModuleExist($type)) {
            $this->error('模块不存在或不可见');
        }
        // 判定是否是post提交
        if(request()->isPost()) {          
            $data = input('post.');         
            $data['right'] = implode(',',$data['right']);           
            if(!empty($data['id'])){
                try {
                     Db::name('system_menu')->where('id',$data['id'])->update($data);
                }catch (\Exception $e) {
                    $this->error($e->getMessage());   
                }               
            }else{
                if(Db::name('system_menu')->where(array('type'=>$data['type'],'name'=>$data['name']))->count()>0){
                    $this->error('该权限名称已添加，请检查',url('Admin/privilege'));
                }
                unset($data['id']);
                try {
                    Db::name('system_menu')->insert($data);
                }catch (\Exception $e) {
                    $this->error($e->getMessage());   
                } 
            }
            $this->success('操作成功',url('Admin/privilege',array('type'=>$data['type'])));              
        }else {            
            $id = input('id',0);
            if($id){
                $info = Db::name('system_menu')->where(array('id'=>$id))->find();
                $info['right'] = explode(',', $info['right']);
                $this->assign('info',$info);
            }
            $modules = $moduleLogic->getModules();
            $group = $moduleLogic->getPrivilege($type);
            $planPath = APP_PATH.$modules[$type]['name'].'/controller';
            $planList = array();
            $dirRes   = opendir($planPath);
            while($dir = readdir($dirRes))
            {
                if(!in_array($dir,array('.','..','.svn')))
                {
                    $planList[] = basename($dir,'.php');
                }
            }
            return $this->fetch('', [    
                'modules' => $modules,
                'planList' => $planList,  
                'group'=>$group,
                'modules'=>$modules,
                'type'=>$type
            ]);
        }   
    }
    /**
     * 删除权限
     */
    public function privilege_delete(){  
        $data=input('param.');        
        // 批量删除
        if ($data['batchFlag']) {
            return $this->privilege_delBatch($data);           
        }  
        try {
            $result = Db::name('system_menu')->where(array('id'=>$data['id']))->delete();
        }catch (\Exception $e) {
            $this->error($e->getMessage());   
        }
        if($result) {  
            return $this->result(['url' => $_SERVER['HTTP_REFERER']], 1, '删除成功');       
             
        }else {
            return $this->result('', 0, '删除失败');     
        }            
    
    }
     /**
     * 批量彻底删除权限
     */   
    public function privilege_delBatch($data){
        $idArr = $data['ids'];  
        if (!is_array($idArr)) {
            $this->error('请选择要删除的项');
        }        
        $where = array('id' => array('in', $idArr));
        if (Db::name('system_menu')->where($where)->delete()) {
            return $this->result(['url' => $_SERVER['HTTP_REFERER']], 1, '删除成功'); 
        } else {
            $this->error('删除失败');
        }
    }
    public function get_action()
     {
        $control = input('controller');
        $type = input('type',0);
        $module = (new ModuleLogic)->getModule($type);
        if (!$module) {
             exit('模块不存在或不可见');
        }

        $selectControl = [];
        $className = "app\\".$module['name']."\\controller\\".$control;
        $methods = (new \ReflectionClass($className))->getMethods(\ReflectionMethod::IS_PUBLIC);
        foreach ($methods as $method) {
            if ($method->class == $className) {
                if ($method->name != '__construct' && $method->name != '_initialize') {
                    $selectControl[] = $method->name;
                }
            }
        }
        $html = '';
        foreach ($selectControl as $val){
            $html .= "<li class='checkbox' style='display: inline-block;padding:0 10px;'><label class='checkbox'><input class='input-mini' value=".$val." type='checkbox'>".$val."</label></li>";
            if($val && strlen($val)> 18){
                $html .= "<li></li>";
            }
        }
        exit($html);
     }
    public function role_log(){
        $data = input('param.');      
        //halt($data);
        $whereData = [];
        // 转换查询条件   
        if(!empty($data['log_info'])) {
            $whereData['log_info'] = ['like', '%'.$data['log_info'].'%'];           
        }
        // 获取数据 然后数据 填充到模板  
        $this->getPageAndSize($data);
        $result = model('AdminLog')->getLogByCondition($whereData,$this->size);
        $total = model('AdminLog')->getLogCountByCondition($whereData);    
        return $this->fetch('', [    
            'list' => $result,
            'total' => $total?$total:0,                
            'log_info' => empty($data['log_info']) ? '' : $data['log_info'],   
            'page'=>$result->render(),           
        ]); 
    }
    /**
     * 删除日记
     */
    public function log_delete(){     
        $this->model='AdminLog';
        $this->nomaldelete('log_id');die;
        $data=input('param.');        
        // 批量删除
        if ($data['batchFlag']) {
            return $this->log_delBatch($data);           
        }  
        try {
            $result = model('AdminLog')->where('log_id', $data['log_id'])->delete();
        }catch (\Exception $e) {
            $this->error($e->getMessage());   
        }
        if($result) {         
            return $this->result(['url' => $_SERVER['HTTP_REFERER']], 1, '删除成功');
        }else {
            return $this->result('', 0, '删除失败');        
        }            
    
    }
    /**
     * 批量彻底删除日记
     */   
    public function log_delBatch($data){
        $idArr = $data['ids'];  
        if (!is_array($idArr)) {
            $this->error('请选择要删除的项');
        }        
        $where = array('log_id' => array('in', $idArr));
        if (model('AdminLog')->where($where)->delete()) {
            return $this->result(['url' => $_SERVER['HTTP_REFERER']], 1, '删除成功');
        } else {
           return $this->result('', 0, '删除失败'); 
        }
    }
}
