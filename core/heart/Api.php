<?php
namespace heart;

class Api{
    public function init(){}

    public function intercept(array $noNeedLogin){
        $this->init();
        $action = getRoute()::$action;

    }

    /**
     * 生成请求令牌
     * @access public
     * @param string $name 令牌名称
     * @return string
     */
    public function token($name = 'token'){
        $token = md5($_SERVER['REQUEST_TIME_FLOAT']);
        if (isAjax()) header($name . ': ' . $token);
        Session::set($name,$token);
        return $token;
    }
}