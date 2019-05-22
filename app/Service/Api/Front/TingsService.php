<?php
namespace App\Service\Api\Front;

use App\Model\Things;
use App\Model\Tag;

class TingsService{
    private $model = null;

    public function __construct(){
        $this->model == null && $this->model = new Things();
    }

    /**
     * 酷事列表
     * @param $page
     * @param int $length
     * @return array
     */
    public function thingsList($page,$length = 10){
        //init
        $res = getInit('获取失败');

        //query
        $start = ($page - 1) * $length;
        $list  = $this->model->where([['status',1]])->limit($length,$start)->get()->toArray();
        $res = getSuccsess('获取成功',$list);
        return $res;
    }

    /**
     * 获取酷事标签
     * @return array
     */
    public function tagList(){
        //init
        $res = getInit('获取失败');

        //query
        $tag  = new Tag();
        $list = $tag->select('id,name')->where([['status',1],['key','things']])->orderBy('sort','DESC')->get()->toArray();
        $res  = getSuccsess('获取成功',$list);
        return $res;
    }

    public function thingsDetail($x){
        dd($x);
        //init
        $res = getInit('获取失败');
    }
}