<?php
use heart\Session;

if(!function_exists('config')){
    /**
     * 获取配置信息
     * @param string $chanal
     * @return array|mixed
     */
    function config($chanal = ''){
        if(!is_string($chanal)) return [];
        $dir    = dirname(dirname(__FILE__));
        $path   = $dir . '/config/' . $chanal . '.php';
        if(!file_exists($path)) return [];
        $config = require($path);
        return $config;
    }
}

if(!function_exists('session')){
    /**
     * 获取配置session信息
     * @param string $chanal
     * @return array|mixed
     */
    function session($name,$data = '',$time = 86400){
        if(!is_string($name)) return false;
        if($data === ''){
            return Session::get($name);
        }else{
            Session::set($name,$data,$time);
        }
    }
}

if (! function_exists('db')) {
    /**
     * 获取数据库实例
     * @return DB|null
     */
    function db(){
        return DB::getInstance();
    }
}

if(!function_exists('getRoute')){
    /**
     * 获取路由操作实例
     * @return null|route
     */
    function getRoute(){
        $route = \heart\route::routeStart();
        return $route;
    }
}

if (! function_exists('getRequestMethod')) {
    /**
     * 获取访问方式
     * @return string
     */
    function getRequestMethod(){
        return $_SERVER['REQUEST_METHOD'];
    }
}

if (! function_exists('getRequestType')) {
    /**
     * 获取数据方式
     * @return string
     */
    function getRequestType(){
        if(!empty($_POST)) return 'POST';
        else return 'GET';
    }
}

if(!function_exists('getHeader')){
    /**
     * 获取header头信息
     * @return array
     */
    function getHeader(){
        $ignore  = ['host','accept','content-length','content-type'];
        $headers = [];

        foreach($_SERVER as $key=>$value){
            if(substr($key, 0, 5)==='HTTP_') {
                $key = substr($key, 5);
                $key = str_replace('_', ' ', $key);
                $key = str_replace(' ', '-', $key);
                $key = strtolower($key);

                if (!in_array($key, $ignore)) {
                    $headers[$key] = $value;
                }
            }
        }

        return $headers;
    }
}

if(!function_exists('json')){
    /**
     * json编码
     * @param $pre
     * @return string
     */
    function json($pre){
        return json_encode( $pre,JSON_UNESCAPED_UNICODE );
    }
}

if(!function_exists('getInit')){
    function getInit($error,$data = []){
        $error = is_string($error)?$error:'操作失败';
        return [
            'code' => false,
            'msg'  => $error,
            'data' => $data
        ];
    }
}

if(!function_exists('getSuccsess')){
    function getSuccsess($msg,$data = []){
        $error = is_string($msg)?$msg:'操作成功';
        return [
            'code' => true,
            'msg'  => $msg,
            'data' => $data
        ];
    }
}

if(!function_exists('throwError')){
    function throwError($info='',$type=1){
        $info = (string)$info;
        $type = (int)$type;
        switch ($type){
            case 1:
                $info_arr = ['code'=>0,'message'=>$info,'data'=>[]];
                exit(json_encode($info_arr,JSON_UNESCAPED_UNICODE));
                break;
            default:
                throw new Exception($info);
        }
    }
}

if (! function_exists('getUrlSuffis')) {
    /**
     * 获取路由后缀
     * @return mixed|string
     */
    function getUrlSuffis(){
        $url = isset($_SERVER['PATH_INFO'])?$_SERVER['PATH_INFO']:urldecode($_SERVER['REQUEST_URI']);
        $url = parse_url(str_replace("index.php","",$url));

        $url['path']  = preg_replace("/\/+/","/",$url['path']);
        $url['query'] = trim(preg_replace("/&+/","&",isset($url['query'])?$url['query']:''),'&');
        return $url;
    }
}

if (! function_exists('isAjax')) {
    /**
     * 判断是否是ajax
     * @return bool
     */
    function isAjax(){
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') return true;
        return false;
    }
}

if (! function_exists('env')) {
    /**
     * Gets the value of an environment variable. Supports boolean, empty and null.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return value($default);
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return;
        }

        if (strlen($value) > 1 && Str::startsWith($value, '"') && Str::endsWith($value, '"')) {
            return substr($value, 1, -1);
        }

        return $value;
    }
}

if (! function_exists('value')) {
    /**
     * Return the default value of the given value.
     *
     * @param  mixed  $value
     * @return mixed
     */
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}

if(! function_exists('token')){
    /**
     * 生成请求令牌
     * @access public
     * @param string $name 令牌名称
     * @return string
     */
    function token($name = 'token'){
        $token = md5($_SERVER['REQUEST_TIME_FLOAT']);
        session($name,$token);
        return $token;
    }
}