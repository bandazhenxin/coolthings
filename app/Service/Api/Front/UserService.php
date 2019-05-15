<?php
namespace App\Service\Api\Front;

use App\Model\User;
use App\Model\Code;

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
                ['password',md5($password)],
                ['status',1]
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

    public function register($account = '',$password = '',$code = ''){
        //init
        $res = getInit('注册失败');
        $code = new Code();

        //validata
        if(empty($account) || !is_string($account)){
            $res['msg'] = '请传入有效账户';
            return $res;
        }
        if(empty($password) || !is_string($password)){
            $res['msg'] = '请传入有效密码';
            return $res;
        }
        if(empty($code) || !is_string($code)){
            $res['msg'] = '请传入有效激活码';
            return $res;
        }

        try{
            $is_code = $code->where([['status',1],['code',$code]])->limit(1)->get();
            if(empty($is_code)){
                $res['msg'] = '激活码不存在';
                return $res;
            }

//            $add = $this->model->  继续
        }catch (\Exception $e){
            return $res;
        }
    }
}