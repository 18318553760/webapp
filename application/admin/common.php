<?php
use think\Log;
use think\Db;

error_reporting(E_ERROR | E_PARSE );// 不需要那么严谨
/**
 * 根据角色权限过滤菜单
 */
function getMenuList($all_menu_list,$act_list){	
	$menu_list = $all_menu_list;
	if($act_list != 'all'){
		$right = Db::name('system_menu')->where("id", "in", $act_list)->cache(true)->column('right');		
        $role_right = '';
		foreach ($right as $val){
			$role_right .= $val.',';
		}		
		$role_right = explode(',', strtolower($role_right));
		foreach($menu_list as $k=>$mrr){
			if(is_array($mrr['_child'])){
				foreach ($mrr['_child'] as $kk => $mrrr) {			
					if(is_array($mrrr['_child'])){
						foreach ($mrrr['_child'] as $j=>$v){
							// print_r($v['model'].'@'.$v['action']);
							if(!in_array(strtolower($v['model'].'@'.$v['action']), $role_right)){
								unset($menu_list[$k]['_child'][$kk]['_child'][$j]);//过滤菜单
								//unset($menu_list[k]$[$kk]);
							}							
						}
					}else{
						if(!in_array(strtolower($mrrr['model'].'@'.$mrrr['action']), $role_right)){
							unset($menu_list[$k]['_child'][$kk]);//过滤菜单
							//unset($menu_list[k]$[$kk]);
						}	
					}					
				}
			}
			
		}
	}
	// print_r($menu_list[2][_child][1][_child][2]);die;	
	return $menu_list;
}
/**
 * 递归删除文件夹
 */
function del_File($path,$delDir = FALSE) {
    if(!is_dir($path))
                return FALSE;		
	$handle = @opendir($path);
	if ($handle) {
		while (false !== ( $item = readdir($handle) )) {
			if ($item != "." && $item != "..")
				is_dir("$path/$item") ? del_File("$path/$item", $delDir) : unlink("$path/$item");
		}
		closedir($handle);
		if ($delDir) return rmdir($path);
	}else {
		if (file_exists($path)) {
			return unlink($path);
		} else {
			return FALSE;
		}
	}
}
?>