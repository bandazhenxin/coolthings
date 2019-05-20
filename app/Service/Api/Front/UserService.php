<?php
namespace App\Service\Api\Front;

use App\Model\User;
use App\Model\Code;

class UserService{
    private $model = null;

    public function __construct(){
        $this->model == null && $this->model = new User();
    }

    /**
     * 登录操作
     * @param string $account
     * @param string $password
     * @return array
     */
    public function login($account = '',$password = ''){
        //init
        $res = getInit('登录失败');

        //query
        $condition = [
            ['account',$account],
            ['password',md5($password)],
            ['status',1]
        ];
        $user = $this->model->select('id,account,username,addtime,code')->where($condition)->limit(1)->get()->toArray();
        if(!empty($user)){
            $token = token();
            $user  = $user[0];
            $user['token'] = $token;
            session('user',$user);
            $res = getSuccsess('登录成功',$user);
        }

        return $res;
    }

    /**
     * 更新，用于中间件每次调用
     * @return array
     */
    public function update(){
        //init
        $res = getInit('更新失败');

        //judge
        if(empty(session('user'))){
            $res['msg'] = '用户未登录';
            return $res;
        }else{
            //update
            $pre = session('user');
            $token     = $pre['token'];
            $condition = [['id',$pre['id']]];
            $up_res    = $this->model->select('id,account,username,addtime,code')->where($condition)->limit(1)->get()->toArray();
            if(!empty($up_res)){
                $user = $up_res[0];
                $user['token'] = $token;
                session('user',$user);
                $res = getSuccsess('更新成功',$user);
            }
        }

        return $res;
    }

    /**
     * 用户注册
     * @param string $account
     * @param string $password
     * @param string $codeNum
     * @return array
     */
    public function register($account = '',$password = '',$codeNum = ''){
        //init
        $res = getInit('注册失败');
        $code = new Code();

        //validate
        $is_code = $code->where([['status',1],['code',$codeNum],['number >',0]])->limit(1)->get()->toArray();
        $is_old  = $this->model->where([['account',$account]])->limit(1)->get()->toArray();
        if(empty($is_code)){
            $res['msg'] = '激活码不存在';
            return $res;
        }
        if(!empty($is_old)){
            $res['msg'] = '账号名已被占用';
            return $res;
        }

        //register
        $insert  = [
            'account'  => $account,
            'password' => md5($password),
            'addtime'  => time(),
            'code'     => $codeNum
        ];
        $add_res = $this->model->insert($insert);
        $add_res && $res = getSuccsess('更新成功',$add_res);

        return $res;
    }
}