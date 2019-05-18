<?php
namespace heart;

class Api{
    public $data_type = 'json';
    public $action    = '';
    public $classname = '';
    public $token     = '';

    /**
     * 初始化
     * @param string $data_type
     */
    public function init($data_type = 'json'){
        $action    = '$action';
        $classname = '$classname';
        $this->action    = getRoute()::$action;
        $this->classname = getRoute()::$classname;
        $this->data_type = $data_type != 'json'?'jsonp':$data_type;
        $this->token     = session('token');
    }

    /**
     * token检测
     * @param array $noNeedTesting
     * @param string $data_type
     */
    public function intercept(array $noNeedTesting = [],array $noNeedLogin = [],$data_type = 'json'){
        $this->init($data_type);

        //拦截检测
        if(!in_array($this->action,$noNeedTesting)){
            //token validata
            $token = $this->getRequestToken();
            if(empty($this->token)) $this->no('token异常,请检查登录');
            if($this->token != $token) $this->no('Signature failed');

            //login validata
            if(!in_array($this->action,$noNeedLogin) && method_exists($this,'interceptLogin')){
                $is_login = $this->interceptLogin();
                if(!$is_login) $this->no('Not logged in');

                //updata
                if(method_exists($this,'autoUpdate')) $this->autoUpdate();
            }
        }
    }

    /**
     * 获取请求token
     * @return bool
     */
    public function getRequestToken(){
        //body取值
        $token = isset($_GET['token'])?$_GET['token']:'';
        getRequestType() == 'POST' && isset($_POST['token']) && $token = $_POST['token'];

        //header取值
        if(empty($token)){
            $header = getHeader();
            $token  = isset($header['token'])?$header['token']:$token;
        }

        return $token;
    }

    /**
     * 获取body值
     * @param $name
     * @param bool $value
     * @return bool
     */
    public function request($name,$value = null){
        if(!is_string($name)) return null;
        $_REQ = array_merge($_GET, $_POST);
        $res = isset($_REQ[$name])?$_REQ[$name]:$value;
        return $res;
    }

    /**
     * 执行服务方法
     * @param $obj
     * @param $action
     * @return mixed
     */
    public function serviceAction($obj,$action,array $params = []){
        if('object' != gettype($obj)) $this->no('service操作:参数类型错误');
        if(!is_string($action.'')) $this->no('service操作:参数类型错误');
        if(!method_exists($obj,$action)) $this->no('service操作:方法不存在');

        $res = $obj->$action(...$params);
        $this->isRestful($res);
        if(empty($res['code'])) $this->no($res['msg']);
        $this->yes($res['msg'],$res['data']);
    }

    /**
     * resful风格检测
     * @param array $res
     */
    public function isRestful($res){
        if(!is_array($res)) $this->no('resful风格错误');
        if(!isset($res['code']) || !is_bool($res['code'])) $this->no('resful风格错误参数:code');
        if(!isset($res['msg']) || !is_string($res['msg'])) $this->no('resful风格错误参数:msg');
        if(!isset($res['data']) || !is_array($res['data'])) $this->no('resful风格错误参数:data');
    }

    /**
     * 生成请求令牌
     * @access public
     * @param string $name 令牌名称
     * @return string
     */
    public function token($name = 'token'){
        $token = md5($_SERVER['REQUEST_TIME_FLOAT']);
        if (isAjax()) header($name . ': ' . $token);
        Session::set($name,$token);
        return $token;
    }

    /**
     * 设置token并返回token
     * @return string
     */
    public function setToken($token = ''){
        $this->token = (empty($token) || !is_string($token))?$this->token():$token;
        return $this->token;
    }

    /**
     * 输出成功
     * @param string $msg
     * @param array $data
     * @param array $header
     */
    public function yes($msg = 'yes',$data = []){
        $result = [
            'code' => 1,
            'msg' => $msg,
            'data' => $data
        ];

        $this->inputInfo($result);
    }

    /**
     * 输出失败
     * @param string $msg
     * @param array $data
     * @param array $header
     */
    public function no($msg = 'no',$data = []){
        $result = [
            'code' => 0,
            'msg' => $msg,
            'data' => $data
        ];

        $this->inputInfo($result);
    }

    private function inputInfo($result = []){
        $data = json($result);
        switch ($this->data_type){
            case 'json':
                break;
            case 'jsonp':
                if(isset($_GET['callback'])){
                    $data = $_GET['callback'].'('.$data.')';
                }else{
                    throwError("请传递callback参数",2);
                }
                break;
        }
        exit($data);
    }
}