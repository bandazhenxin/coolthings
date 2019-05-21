<?php
namespace App\Controller\Api\Front;

use App\Lib\Common\Auth;
use Inhere\Validate\Validation;

/**
 * Class Index
 * @package App\Controller\Api\Front
 */
class User extends Auth{
    private $server = null;

    public function __construct(){
        $this->init();
        $this->server == null && $this->server = $this->service['UserService'];
    }

    /**
     * 业务登录
     */
    public function login(){
        //getdata
        $data['account']  = $this->request('account');
        $data['password'] = $this->request('password');

        //validate
        $rule = [['account,password','required']];
        $v    = Validation::check($data,$rule);
        if($v->fail()) $this->no($v->firstError());

        //login
        $this->yes('获取成功',$this->server->login(...toIndexArr($data))->data);
    }

    /**
     * 用户注册  这里设计的是不判断是否登录都可以注册
     */
    public function register(){
        //getdata
        $data['account']  = $this->request('account');
        $data['password'] = $this->request('password');
        $data['code']     = $this->request('code');

        //validate
        $rule = [['account,password,code','required']];
        $v    = Validation::check($data,$rule);
        if($v->fail()) $this->no($v->firstError());

        //register
        $this->yes('获取成功',$this->server->register(...toIndexArr($data))->data);
    }
}