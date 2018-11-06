<?php
/**
 * Created by PhpStorm.
 * User: hongshao
 * Date: 18/11/2
 * Time: 下午4:35
 */
namespace app\common\model;
use think\Model;
use think\Db;
use think\Paginator;
class AdminUser extends Base {
	/**
     * 通用化获取参数的数据字段
     */
    private function _getListField() {
        return [
            'id',
            'username',  
            'email',
            'role_id',       
            'create_time',
            'status'         
        ];
    }
	/**
     * 根据来获取列表的数据
     * @param array $param
     */
    public function getUserByCondition($condition = [], $from=0, $size = 5) {
        if(!isset($condition['status'])) {
            $condition['status'] = [
                'neq', config('code.status_delete')
            ];
        }
        $order = ['id' => 'desc'];
        $result = array();
        $list = array();
        $res = $this->where($condition)
        	->field($this->_getListField())
             ->order($order)
             ->paginate($size,false,[        
            // 使用函数助手传入参数
            'query' => request()->param(),
            ]);                  
        $page = $res->render();
        $role = Db::name('admin_role')->column('role_id,role_name');       
        if($res && $role){
            foreach ($res as $val){
                $val['role'] =  $role[$val['role_id']];                
                $list[] = $val;
            }
        }
        $result['list']=$list;
        $result['page']=$page;        
        return $result;
    }

    /**
     * 根据条件来获取列表的数据的总数
     * @param array $param
     */
    public function getUserCountByCondition($condition = []) {
        if(!isset($condition['status'])) {
            $condition['status'] = [
                'neq', config('code.status_delete')
            ];
        }
        return $this->where($condition)->count();     
    }

}