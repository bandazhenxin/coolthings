<?php
namespace App\Controller\Api\Front;

use heart\Api;

/**
 * Class Index
 * @package App\Controller\Api\Front
 */
class Auth extends Api{
    public function __construct(){
        $this->init();
    }

    /**
     * 登录
     */
    public function login(){
        //getdata
        $account  = $this->request('account');
        $password = $this->request('password');

        //validate
        if(empty($account)) $this->no('请填写账户信息');
        if(empty($password)) $this->no('请填写密码信息');

        //login
        $condition = [
            ['account',$account],
            ['password',md5($password)]
        ];
        $user  = db()->table('cool_user')->select('id,account,username,addtime,code')->where($condition)->limit(1)->get()->toArray();
        if(empty($user)) $this->yes('登录失败');
        $user  = $user[0];
        $token = $this->setToken();
        $user['token'] = $token;
        session('user',$user);
        $this->yes('登录成功',$user);
    }

    public function isLogin(){

    }
}