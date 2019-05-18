<?php
namespace App\Service\Api\Front;

use App\Model\Things;

class TingsService{
    private $model = null;

    public function __construct(){
        $this->model == null && $this->model = new Things();
    }

    /**
     * 数据更新
     * @return array
     */
    public function update(){
        $user_service = new UserService();
        $res = $user_service->update();
        return $res;
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

        //validata
        if(empty($page)){
            $res['msg'] = '分页数不能为空';
            return $res;
        };
        if(!is_numeric($page)){
            $res['msg'] = '分页数应为数字';
            return $res;
        }
        if(!is_numeric($length)){
            $res['msg'] = '分页长度应为数字';
            return $res;
        }

        //query
        try{
            $start = ($page - 1) * $length;
            $list  = $this->model->where([['status',1]])->limit($length,$start)->get()->toArray();

            $res = getSuccsess('获取成功',$list);
        }catch (\Exception $e){
            return $res;
        }

        return $res;
    }

    public function thingsDetail(){
        //init
        $res = getInit('获取失败');
    }
}