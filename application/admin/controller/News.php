<?php
namespace app\admin\controller;

use think\Controller;

class News extends Base
{
    public function index() {
        $data = input('param.');
        $query = http_build_query($data);
        //halt($data);

        $whereData = [];
        // 转换查询条件
        if(!empty($data['start_time']) && !empty($data['end_time']) && $data['end_time'] > $data['start_time']) {
            $whereData['create_time'] = [
                ['gt', strtotime($data['start_time'])],
                ['lt', strtotime($data['end_time'])],
            ];          
        }        
        if(!empty($data['catid'])) {
            $whereData['catid'] = intval($data['catid']);
        }
        if(!empty($data['title'])) {
            $whereData['title'] = ['like', '%'.$data['title'].'%'];
        }
        // 获取数据 然后数据 填充到模板
        $this->getPageAndSize($data);        
        // 获取表里面的数据
        $news = model('News')->getNewsByCondition($whereData,$this->size);


        // 获取满足条件的数据总数 =》 有多少页
        $total = model('News')->getNewsCountByCondition($whereData);
        /// 结合总数+size  =》 有多少页
        $pageTotal = ceil($total/$this->size);//1.1 =>2

        return $this->fetch('', [
            'cats' => config('cat.lists'),
            'news' => $news, 
            'total' => $total?$total:0,         
            'start_time' => empty($data['start_time']) ? '' : $data['start_time'],
            'end_time' => empty($data['end_time']) ? '' : $data['end_time'],
            'catid' => empty($data['catid']) ? '' : $data['catid'],
            'title' => empty($data['title']) ? '' : $data['title'],            
            'page'=>$news->render()
        ]);
    }
    public function handle() {

        if(request()->isPost()) {         
            $this->saveNews();
        }else {
            $id = input('id/d');      
            if($id){
                $info = model('News')->get(['id' => $id]);
                $this->assign('info',$info);               
            } 
            return $this->fetch('', [
                'cats' => config('cat.lists')
            ]);
        }
    }
    public function saveNews(){
        $data = input('post.');
        // 数据需要做检验 validate机制
        $validate = validate('News');
        if(!$validate->check($data)) {
            $this->result('', 0,$validate->getError());                      
        }   
        if(empty($data['id'])){
            $news= model('News')->get(['title' => $data['title']]);     
            if($news){
                $this->error("已存在相同的新闻名称!");
            }else{
                try {
                    model('News')->add($data);
                }catch (\Exception $e) {
                    return $this->result('', 0, '新增失败');
                }         
            }
        }else{
            $news= model('News')->get(['title' => $data['title'],'id'=>['neq',$data['id']]]);     
            if($news){
                $this->error("已存在相同的新闻名称!");
            }else{
                try {
                     model('News')->where('id', $data['id'])->update($data);
                }catch (\Exception $e) {
                    return $this->result('', 0, '保存失败');
                }         
            }            
        } 
        return $this->result(['jump_url' => url('news/index')], 1, 'OK');
    }
    public function delete(){
        $this->model='News';
        $this->nomaldelete('id');
       
    }


}
