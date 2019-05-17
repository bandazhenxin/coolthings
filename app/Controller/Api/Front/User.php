<?php
namespace App\Controller\Api\Front;

use App\Lib\Common\Auth;
use App\Service\Api\Front\UserService;

/**
 * Class Index
 * @package App\Controller\Api\Front
 */
class User extends Auth{
    private $server = null;

    public function __construct(){
        $this->init();
        $this->server == null && $this->server = new UserService();
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
        $user_res = $this->server->login($account,$password);
        if(empty($user_res['code'])) $this->no($user_res['msg']);
        $this->setToken($user_res['data']['token']);//可以不用设置的
        $this->yes($user_res['msg'],$user_res['data']);
    }

    /**
     * 用户注册  这里设置的是不判断是否登录都可以注册
     */
    public function register(){
        //getdata
        $account  = $this->request('account');
        $password = $this->request('password');
        $code     = $this->request('code');

        //validate
        if(empty($account)) $this->no('请填写账户信息');
        if(empty($password)) $this->no('请填写密码信息');
        if(empty($code)) $this->no('请填写激活码');

        //register
        $user_res = $this->server->register($account,$password,$code);
        if(empty($user_res['code'])) $this->no($user_res['msg']);
        $this->yes($user_res['msg'],$user_res['data']);
    }

    /**
     * 自助登录
     * @param $account
     * @param $password
     * @return string
     */
    public function privateLogin($account,$password){
        //init
        $res = getInit('登录失败');

        //validate
        if(empty($account) || !is_string($account.'')) return $res;
        if(empty($password) || !is_string($password.'')) return $res;

        //login
        $user_res = $this->server->login($account,$password);
        if(empty($user_res['code'])) return $res;
        $this->setToken($user_res['data']['token']);//可以不用设置的
        $res = getSuccsess('登录成功',$user_res['data']);
        return $res;
    }
}