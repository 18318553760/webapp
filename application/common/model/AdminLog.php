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

class AdminLog extends Base {
	/**
     * 通用化获取参数的数据字段
     */
    private function _getListField() {
        return [
            'log_id',
            'admin_id',
            'log_info',
            'log_ip',
            'log_time'     
        ];
    }
	/**
     * 后台自动化分页
     * @param array $data
     */
    public function getLog($data = []) {
      
        $order = ['log_id' => 'desc'];
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
    public function getLogByCondition($condition = [],$size = 5) {       
        $order = ['log_id' => 'desc'];     
        $result = $this->alias('l')
            ->join('__ADMIN_USER__ a','a.id =l.admin_id')
            ->where($condition)
            ->order($order)
            ->paginate($size,false,[        
                //使用函数助手传入参数
                'query' => request()->param(),
                ]);  
        // $result = $this->where($condition)
        // 	->field($this->_getListField())
        //      ->order($order)
        //      ->paginate($size,false,[        
        //     // 使用函数助手传入参数
        //     'query' => request()->param(),
        //     ]); 
        return $result;  
    }

    /**
     * 根据条件来获取列表的数据的总数
     * @param array $param
     */
    public function getLogCountByCondition($condition = []) {
        return $this->where($condition)
            ->count();
        //echo $this->getLastSql();
    }
    
}