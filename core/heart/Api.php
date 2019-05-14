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
    public function intercept(array $noNeedTesting,$data_type = 'json'){
        $this->init($data_type);

        //拦截检测
        if(!in_array($this->action,$noNeedTesting)){
            $token = $this->getRequestToken();
            if(empty($this->token)) $this->no('token异常,请检查登录');
            if($this->token != $token) $this->no('Signature failed');
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
    public function setToken(){
        $this->token = $this->token();
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
        $data = json_encode($result,JSON_UNESCAPED_UNICODE);
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