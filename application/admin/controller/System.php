<?php
namespace app\admin\controller;
use think\Db;
use think\Controller;
use think\Cache;
class System extends Base
{
    /**
     * 清空系统缓存
     */
    public function update_Cache(){          
        del_File(RUNTIME_PATH);
        Cache::clear();   
        return $this->result('', 1, '更新缓存成功！'); 
    }
}

