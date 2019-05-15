<?php
namespace App\Controller\Api\Front;

use App\Lib\Common\Auth;

/**
 * Class Index
 * @package App\Controller\Api\Front
 */
class Index extends Auth{
    //无需验证的接口
    private $noNeedTesting = ['thingsList'];
    private $noNeedLogin   = [];//一般填上面的数组就行

    public function __construct(){
        $this->intercept($this->noNeedTesting,$this->noNeedLogi);
    }

    /**
     * 获取首页
     */
    public function thingsList(){
        $this->yes(getHeader());
    }
}