<?php
namespace App\Controller\Api\Mini;

use App\Lib\Common\Auth;
use Inhere\Validate\Validation;

class User extends Auth{
    private $noNeedTesting = ['miniInit'];
    private $noNeedLogin   = [];
    private $server = null;

    public function __construct(){
        $this->intercept($this->noNeedTesting,$this->noNeedLogin);
        $this->server == null && $this->server = $this->service['UserService'];
    }

    //小程序初始化
    public function miniInit(){
        //getdata
        $data['code']  = $this->request('code');

        //validate
        $rule = [['code','required']];
        $v    = Validation::check($data,$rule);
        if($v->fail()) $this->no($v->firstError());

        $this->yes('获取成功',$this->server->getCode2Session(...toIndexArr($data))->data);
    }
}