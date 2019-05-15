<?php
namespace App\Lib\Common;

use heart\Api;

class Auth extends Api{
    /**
     * 登录拦截
     * @return mixed
     */
    protected function interceptLogin(){
        $res = $this->isLogin();
        return $res['code'];
    }

    /**
     * 是否登录
     * @return string
     */
    public function isLogin(){
        $res = getInit('未登录');
        !empty(session('user')) && $res = getSuccsess('已登录',session('user'));
        return $res;
    }

    /**
     * 获取用户信息
     * @return bool
     */
    public function getInfo(){
        $res = $this->isLogin();
        if($res['code']) return $res['data'];
        return false;
    }
}