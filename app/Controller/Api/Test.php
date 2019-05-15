<?php
namespace App\Controller\Api;

use App\Lib\Common\Auth;

class Test extends Auth{
    //无需验证的接口
    private $noNeedTesting = [];
    private $noNeedLogin   = [];

    //验证登录时自动执行 一定要是protected function autoUpdate() 一般用于更新用session数据等等
    protected function autoUpdate(){

    }

    public function __construct(){
        $this->intercept($this->noNeedTesting,$this->noNeedLogin);
    }

    public function index(){
        $this->yes('yes',getRoute()::$action);
    }
}