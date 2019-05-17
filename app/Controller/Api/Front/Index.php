<?php
namespace App\Controller\Api\Front;

use App\Lib\Common\Auth;
use App\Service\Api\Front\TingsService;

/**
 * Class Index
 * @package App\Controller\Api\Front
 */
class Index extends Auth{
    //无需验证的接口
    private $noNeedTesting = ['thingsList','thingsDetail'];
    private $noNeedLogin   = [];//一般填上面的数组就行

    private $server = null;

    //验证登录时自动执行  更新用户数据
    protected function autoUpdate(){
        $this->server == null && $this->server = new TingsService();
        $this->server->update();
    }

    public function __construct(){
        $this->server == null && $this->server = new TingsService();
        $this->intercept($this->noNeedTesting,$this->noNeedLogin);
    }

    /**
     * 获取首页
     */
    public function thingsList(){
        //getdata
        $page   = $this->request('page');
        $length = $this->request('length',10);

        //validata
        if(empty($page)) $this->no('分页数不能为空');
        if(!is_numeric($page)) $this->no('分页数应为数字');
        if(!is_numeric($length)) $this->no('分页长度应为数字');

        //query
        $things_res = $this->server->thingsList($page,$length);
        if(empty($things_res['code'])) $this->no($things_res['msg']);
        $this->yes($things_res['msg'],$things_res['data']);
    }

    /**
     * 获取酷事详情
     */
    public function thingsDetail(){
        //init
        $things_id = $this->request('things_id');
        if(empty($things_id)) $this->no('酷事id不能为空');
        if(!is_numeric($things_id)) $this->no('酷事id应为数字');

        //query
        $things_res = $this->server->thingsDetail($things_id);
        if(empty($things_res['code'])) $this->no($things_res['msg']);
        $this->yes($things_res['msg'],$things_res['data']);
    }
}