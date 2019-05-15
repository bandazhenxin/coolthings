<?php
namespace App\Service\Api\Front;

use App\Model\User;

class UserService{
    private $model = null;

    public function __construct(){
        $this->model == null && $this->model = new User();
    }

    public function login($account = '',$password = ''){
        //init
        $res = getInit('登录失败');

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
                $token = token();
                $user  = $user[0];
                $user['token'] = $token;
                session('user',$user);
                $res = getSuccsess('登录成功',$user);
            }
        }catch (\Exception $e){
            return $res;
        }

        return $res;
    }
}