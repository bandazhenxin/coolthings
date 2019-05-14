<?php
namespace App\Controller\Api;

use heart\Api;

class Test extends Api{
    //无需验证的接口
    private $noNeedTesting = [];

    public function __construct(){
        session('token','cddddxssxs');
        $this->intercept($this->noNeedTesting);
    }

    public function index(){
        $this->yes(getRoute()::$action);
    }
}