<?php
namespace App\Controller\Api;

use App\Lib\Common\Auth;
use Datto\JsonRpc\Client;

class Test extends Auth{
    //无需验证的接口
    private $noNeedTesting = ['index'];
    private $noNeedLogin   = [];

    //验证登录时自动执行 一定要是protected function autoUpdate() 一般用于更新用session数据等等
    protected function autoUpdate(){

    }

    public function __construct(){
        $this->intercept($this->noNeedTesting,$this->noNeedLogin);
    }

    public function index(){
//        $this->yes('yes',getRoute()::$action);
        $client = new Client();
        $client->query(1, 'add', array(1, 2));
        $message = $client->encode();
        dd($message);
    }
}