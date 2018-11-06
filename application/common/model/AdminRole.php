<?php
/**
 * Created by PhpStorm.
 * User: hongshao
 * Date: 18/11/2
 * Time: 下午4:35
 */
namespace app\common\model;
use think\Model;
use app\common\model\Base;

class AdminRole extends Base {
	/**
     * 通用化获取参数的数据字段
     */
    private function _getListField() {
        return [
            'role_id',
            'role_name',
            'act_list',
            'role_desc',
            'status'     
        ];
    }
	/**
     * 后台自动化分页
     * @param array $data
     */
    public function getRole($data = []) {
        $data['status'] = [
            'neq', config('code.status_delete')
        ];

        $order = ['role_id' => 'desc'];
        // 查询

        $result = $this->where($data)
            ->order($order)
            ->paginate();
        // 调试
        echo $this->getLastSql();

        return $result;
    }

    /**
     * 根据来获取列表的数据
     * @param array $param
     */
    public function getRoleByCondition($condition = [],$size = 5) {
          if(!isset($condition['status'])) {
            $condition['status'] = [
                'neq', config('code.status_delete')
            ];
        }
        $order = ['role_id' => 'desc'];       
        $result = $this->where($condition)
        	->field($this->_getListField())
             ->order($order)
             ->paginate($size,false,[        
            // 使用函数助手传入参数
            'query' => request()->param(),
            ]); 
        return $result;  
    }

    /**
     * 根据条件来获取列表的数据的总数
     * @param array $param
     */
    public function getRoleCountByCondition($condition = []) {
        if(!isset($condition['status'])) {
            $condition['status'] = [
                'neq', config('code.status_delete')
            ];
        }

        return $this->where($condition)
            ->count();
        //echo $this->getLastSql();
    }
    
}