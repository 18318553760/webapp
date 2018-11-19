<?php
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Tree;
use think\Request;
use think\Session;
/**
 * 后台基础类库
 * Class Base
 * @package app\admin\controller
 */
class Base extends Controller
{
    /**
     * page
     * @var string
     */
    public $page = '';

    /**
     * 每页显示多少条
     * @var string
     */
    public $size = '';
    /**
     * 查询条件的起始值
     * @var int
     */
    public $from = 0;

    /**
     * 定义model
     * @var string
     */
    public $model = '';

    /**
     * 初始化的方法
     */
    public function _initialize() {
        // 判定用户是否登录
        $isLogin = $this->isLogin();        
        if(!$isLogin) {

            return $this->redirect('login/index');
        }        
        $this->getLeftMenu();

        $this->check_priv();
    }

    /**
     * 判定是否登录
     * @return bool
     */
    public function isLogin() {
        //获取session
        $user = session(config('admin.session_user'), '', config('admin.session_user_scope'));    
        if($user && $user['id']) {
            return true;
        }
        return false;
    }

    /**
     * 获取左侧导航
     * @return array
     */
    public function getLeftMenu() {
        // 左侧导航
        $list = Db::name('admin_menu')->where('status=1')->cache(true)->order('listorder asc')->select();
        $data = array();
        foreach ($list as $key => $val) {
            $data[$val['id']] = $val;
        }  
        $this->Menu=$list;
        // 获取菜单          
        $all_menu_list = array();  
        $tree = new Tree();
        $menu_lists = $tree->list_to_tree($this->Menu,'id','parentid'); // 所有系统菜单    
        foreach($menu_lists as $key => $val){
            $all_menu_list[$val['id']] = $val;
        }

        $act_list =  session(config('admin.session_act_list'),'',config('admin.session_user_scope')); 
        $menu_list=getMenuList($all_menu_list,$act_list);
        $current_menu = $this->getCurrentMenu(); // 获取当前菜单 
        $this->assign('current_menu', $current_menu); // 当前菜单
        $this->assign('admin_menu',$menu_list); // 所有菜单        
    }

    /**
     * 获取分页page size 内容
     */
    public function getPageAndSize($data) {
        $this->page = !empty($data['page']) ? $data['page'] : 1;
        $this->size = !empty($data['size']) ? $data['size'] : config('paginate.list_rows');
        $this->from = ($this->page - 1) * $this->size;
    }

    /**
     * 删除逻辑
     */
    public function delete($id = 0) {
        if(!intval($id)) {
            return $this->result('', 0, 'ID不合法');
        }

        // 通过id 去库中查询下记录是否存在

        // 如果你的表和我们控制器文件名 一样。 news news
        // 但是我们 不一样。

        $model = $this->model ? $this->model : request()->controller();
        // 如果php php7  $model = $this->model ?? request()->controller();

        try {
            $res = model($model)->save(['status' => -1], ['id' => $id]);
        }catch(\Exception $e) {
            return $this->result('', 0, $e->getMessage());
        }

        if($res) {
            return $this->result(['url' => $_SERVER['HTTP_REFERER']], 1, 'OK');
        }
        return $this->result('', 0, '删除失败');

    }

    /**
     * 通用化修改状态
     */
    public function status($id='id') {
        $data  = input('param.');
        // tp5  validate 机制 校验   id status

        // 通过id 去库中查询下记录是否存在
        //model('News')->get($data['id']);
        if ($data['batchFlag']) {
            return $this->batchStatus($data,$id);           
        }  
        $model = $this->model ? $this->model : request()->controller();

        try {
            $res = model($model)->allowField(true)->save(['status' => $data['status']], ['id'=> $data['id']]);//过滤掉不更新的数据
        }catch(\Exception $e) {
            return $this->result('', 0, $e->getMessage());
        }

        if($res) {
            return $this->result(['url' => $_SERVER['HTTP_REFERER']], 1, 'OK');
        }
        return $this->result('', 0, '修改失败');
    }
    /**
     * 通用化全部修改状态
     */
    public function batchStatus($data,$id) {
        $data  = input('param.');
        $idArr = $data['ids'];  

        if (!is_array($idArr)) {
              return $this->result('', 0, '请选择要操作的项');
        }  
        if(in_array('1',$idArr)&&$data['rolestatus']==1 ){
            unset($idArr[array_search(1,$idArr)]);// 利用unset删除为1的管理员
        }      
        $where = array();
        $model = $this->model ? $this->model : request()->controller();

        try {
            $res = model($model)->allowField(true)->save(['status' => $data['status']], [$id => ['in', $idArr]]);
        }catch(\Exception $e) {
            return $this->result('', 0, $e->getMessage());
        }
        if($res) {
            return $this->result(['url' => $_SERVER['HTTP_REFERER']], 1, '操作成功');
        }
        return $this->result('', 0, '操作失败');
    }
    /**
     * 通用化删除
     */
    public function nomaldelete($id='id') {
        $data  = input('param.');
        // tp5  validate 机制 校验   id status

        // 通过id 去库中查询下记录是否存在
        //model('News')->get($data['id']);
        if ($data['batchFlag']) {
            return $this->batchdelete($data,$id);           
        }  
        $model = $this->model ? $this->model : request()->controller();

        try {
            $res = model($model)->where([$id=> $data[$id]])->delete();//过滤掉不更新的数据
        }catch(\Exception $e) {
            return $this->result('', 0, $e->getMessage());
        }

        if($res) {
            return $this->result(['url' => $_SERVER['HTTP_REFERER']], 1, '操作成功');
        }
        return $this->result('', 0, '操作失败');
    }
    /**
     * 通用化全部删除
     */
    public function batchdelete($data,$id) {
        $data  = input('param.');
        $idArr = $data['ids'];  

        if (!is_array($idArr)) {
              return $this->result('', 0, '请选择要删除的项');
        }  
        if(in_array('1',$idArr)&&$data['rolestatus']==1 ){
            unset($idArr[array_search(1,$idArr)]);// 利用unset删除为1的管理员
        }      
        $where = array();
        $model = $this->model ? $this->model : request()->controller();

        try {
            $res = model($model)->where([$id => ['in', $idArr]])->delete();//过滤掉不更新的数据            
        }catch(\Exception $e) {
            return $this->result('', 0, $e->getMessage());
        }
        if($res) {
            return $this->result(['url' => $_SERVER['HTTP_REFERER']], 1, '操作成功');
        }
        return $this->result('', 0, '操作失败');
    }
    /**
     * 通用json返回
     */
    public function ajaxReturn($data,$type = 'json'){                        
        exit(json_encode($data));
    }  
    public function getTopMenu(){
        $topmenu = array();    
            //获取顶部菜单
        foreach ($this->Menu as $key=>$module) {
            if($module['parentid'] != 0 || $module['status']==0) {
                continue;
            }
            if (empty($module['action'])){
                $module['action']='index';
            }
            $topmenu[$key] = $module;
        }    
        return $topmenu;
    } 
    /**
     * 获取当前菜单
     * @author 洪少
     */
    public function getCurrentMenu(){
        $request = Request::instance();
        $map['status'] = array('eq', 1);
        $map['group'] = $request->module();      
        $map['model'] =  $this->model ? $this->model : $request->controller();
        $map['action'] = $request->action();
        $result = Db::name('admin_menu')->where($map)->order('parentid desc')->find();        
        return $result;
    }
    /**
     * 检查权限
     * @author 洪少
     */
    public function check_priv(){
        $request = Request::instance();
        $ctl =$request->controller();
        $act = $request->action();
        $act_list =  session(config('admin.session_act_list'),'',config('admin.session_user_scope')); 
        //无需验证的操作
        $uneed_check = array('login','logout','imageUp','upload','videoUp','delupload','login_task');
        if($ctl == 'Index' || $act_list == 'all'){
            //后台首页控制器无需验证,超级管理员无需验证
            return true;
        }elseif(request()->isAjax() || strpos($act,'ajax')!== false || in_array($act,$uneed_check)){
            //所有ajax请求不需要验证权限
            return true;
        }else{
            $right = Db::name('system_menu')->where("id", "in", $act_list)->cache(true)->column('right');
            $role_right = '';
            foreach ($right as $val){
                $role_right .= $val.',';
            }
            $role_right = explode(',', $role_right);
          
            //检查是否拥有此操作权限
            if(!in_array($ctl.'@'.$act, $role_right)){
                $this->error('您没有操作权限['.($ctl.'@'.$act).'],请联系超级管理员分配权限',url('Admin/Index/welcome'));
            }    
        }
    }

}
