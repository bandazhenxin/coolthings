<?php
namespace App\Service\Api\Front;

use App\Model\User;

class AuthService{
    private $model = null;

    public function __construct(){
        $this->model == null && $this->model = new User();
    }

    public function login($account = '',$password = ''){
        //init
        $res = [
            'code' => false,
            'msg'  => '操作失败',
            'data' => []
        ];

        //validata
        if(empty($account) || !is_string($account)){
            $res['msg'] = '请传入有效账户';
            return $res;
        }
        if(empty($password) || !is_string($password)){
            $res['msg'] = '请传入有效密码';
            return $res;
        }

        //query
        try{
            $condition = [
                ['account',$account],
                ['password',md5($password)]
            ];
            $user = $this->model->select('id,account,username,addtime,code')->where($condition)->limit(1)->get()->toArray();
            if(!empty($user)){

            }
        }catch (\Exception $e){
            return $res;
        }

        return $res;
    }
}