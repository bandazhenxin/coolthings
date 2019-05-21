<?php
namespace App\Controller\Api\Front;

use App\Lib\Common\Auth;
use Inhere\Validate\Validation;

/**
 * Class Index
 * @package App\Controller\Api\Front
 */
class Index extends Auth{
    //无需验证的接口
    private $noNeedTesting = ['thingsList'];
    private $noNeedLogin   = [];//一般填上面的数组就行
    private $server        = null;

    //验证登录时自动执行  更新用户数据 这个方法不能使用本类里面的api初始化之后（也就是$this->intercept()之后）定义的成员
    protected function autoUpdate(){
        $this->service['UserService']->update();
    }

    public function __construct(){
        $this->intercept($this->noNeedTesting,$this->noNeedLogin);
        $this->server == null && $this->server = $this->service['TingsService'];
    }

    /**
     * 获取首页
     */
    public function thingsList(){
        //getdata
        $data['page']   = $this->request('page');
        $data['length'] = $this->request('length',10);

        //validata
        $rule = [
            ['page,length','required'],
            ['page,length','number']
        ];
        $v    = Validation::check($data,$rule);
        if($v->fail()) $this->no($v->firstError());

        //query
        $this->yes('获取成功',$this->server->thingsList(...toIndexArr($data))->data);
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
        $this->yes('获取成功',$this->server->thingsDetail($things_id)->data);
    }
}