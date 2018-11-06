<?php
/**
 * Created by PhpStorm.
 * User: hongshao
 * Date: 18/11/1
 * Time: 下午5:25
 */
namespace app\common\logic;
class ModuleLogic
{
    /**
     * 所有模块
     * @var array
     */
    public $modules = [];

    /**
     * 可见模块
     * @var array
     */
    public $showModules = [];

    public function getModules($onlyShow = true)
    {
        if ($this->modules) {
            return $onlyShow ? $this->showModules : $this->modules;
        }      
        $isShow = 1;
        $modules = [
            [
                'name'  => 'admin', 'title' => 'webapp', 'show' => 1,
                'privilege' => [
                    'system'=>'系统设置'
                ],
            ],
            [
                'name'  => 'api', 'title' => 'api接口', 'show' => $isShow,
                'privilege' => [
                    'buy' => '购物流程', 'user' => '用户中心', 'article' => '文章功能', 'activity' => '活动优惠'
                ],
            ],
        ];

        $this->modules = $modules;
        foreach ($modules as $key => $module) {
            if (!$module['show']) {
                unset($modules[$key]);
            }
        }
        $this->showModules = $modules;
        return $onlyShow ? $this->showModules : $this->modules;
    }

    public function getModule($moduleIdx, $onlyShow = true)
    {
        if (!self::isModuleExist($moduleIdx, $onlyShow)) {
            return [];
        }

        $modules = $this->getModules($onlyShow);
        return $modules[$moduleIdx];
    }

    public function isModuleExist($moduleIdx, $onlyShow = true)
    {
        return key_exists($moduleIdx, $this->getModules($onlyShow));
    }

    public function getPrivilege($moduleIdx, $onlyShow = true)
    {
        $modules = $this->getModules($onlyShow);
        return $modules[$moduleIdx]['privilege'];
    }
}