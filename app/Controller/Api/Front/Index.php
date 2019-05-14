<?php
namespace App\Controller\Api\Front;

use heart\Api;

/**
 * Class Index
 * @package App\Controller\Api\Front
 */
class Index extends Api{
    //无需验证的接口
    private $noNeedTesting = ['thingsList'];

    public function __construct(){
        $this->intercept($this->noNeedTesting);
    }

    /**
     * 获取首页
     */
    public function thingsList(){
        $this->yes(getHeader());
    }
}