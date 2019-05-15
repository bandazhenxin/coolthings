<?php
namespace App\Controller\Api\Front;

use heart\Api;
use App\Model\User;
use App\Service\Api\Front\AuthService;

/**
 * Class Index
 * @package App\Controller\Api\Front
 */
class Auth extends Api{
    public function __construct(){
        $this->init();
    }

    /**
     * 业务登录
     */
    public function login(){
        //getdata
        $account  = $this->request('account');
        $password = $this->request('password');

        //validate
        if(empty($account)) $this->no('请填写账户信息');
        if(empty($password)) $this->no('请填写密码信息');

        //login
        $userModel = new User();
        $condition = [
            ['account',$account],
            ['password',md5($password)]
        ];
        $user  = $userModel->select('id,account,username,addtime,code')->where($condition)->limit(1)->get()->toArray();
        if(empty($user)) $this->yes('登录失败');
        $user  = $user[0];
        $token = $this->setToken();
        $user['token'] = $token;
        session('user',$user);
        $this->yes('登录成功',$user);
    }

    /**
     * 主动登录
     */
    public function privateLogin($account,$password){
        //init
        $res = [
            'code' => 0,
            'info' => '登录失败',
            'data' => []
        ];

        //validate
        if(empty($account) || !is_string($account)) return json($res);
        if(empty($password) || !is_string($password)) return json($res);

        //login
    }

    public function isLogin(){

    }
}