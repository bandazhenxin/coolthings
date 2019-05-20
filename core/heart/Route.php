<?php
namespace heart;

use CutePHP\Route\Router;

class Route{
    private $suffis = [];
    private $config = [];
    private $type   = [];

    private $router = null;

    private static $instance = null;

    public static $classname = null;
    public static $action    = null;

    final private function __construct(){
        $this->suffis = getUrlSuffis();
        $this->config = config('route');
        $this->type   = ['get','post','delete','head','patch'];
        $this->router == null && $this->router = new Router;
        $this->init();
    }

    private function init(){
        foreach($this->config as $k => $v){
            $type = strtolower($v['type']);
            if(!$this->validate($type)) continue;
            $this->router->$type($v['url'],$v['action']);
        }
    }

    public static function routeStart(){
        self::$instance == null && self::$instance = new self();
        return self::$instance;
    }

    /**
     * 获取action路径
     * @param $name
     * @param $type
     * @return bool
     */
    public function getAction($name,$type){
        if(!is_string($name)) return false;
        $route  = $this->router->match($name,$type);
        if(!$route) return false;
        return $route->getStorage();
    }

    public function jump(){
        $this->setGetData($this->suffis['query']);
        $type = strtolower(getRequestMethod());
        $action = $this->getAction($this->suffis['path'],$type);
        if(false !== $action){
            $space     = preg_replace("/\/+/","\\",$action);
            $space_arr = explode('\\',$space);

            //获取类信息
            $action     = end($space_arr);
            array_pop($space_arr);
            foreach($space_arr as &$v) $v = ucfirst($v);
            $class_name = 'App\\Controller\\'.implode("\\",$space_arr);
            if(!class_exists($class_name)){
                $class_name = $class_name.'\\'.ucfirst($action);
                $action = 'index';
                if(!class_exists($class_name)){
                    $class_name = $class_name.'\\'.ucfirst($action);
                    $action = 'index';
                    if(!class_exists($class_name)) throwError('Class undefined!!');
                }
            }

            //反射信息
            $class = new \ReflectionClass($class_name);
            if (!$class->hasMethod($action)) throwError("Method $action does not existed!");
            $tmp   = $class->getMethod($action);
            if(!$tmp->ispublic()) throwError("Function is not public");
            self::$classname = $class_name;
            self::$action    = $action;
            $tmp->invoke($class->newInstance());
        }else{
            $this->statiJump($this->suffis['path']);
            throwError('Routing undefined!!');
        }
    }

    private function statiJump($name){
        $name = (string)$name;
        foreach($this->config as $k => $v){
            if('static' != $v['type'] || $name != $v['url']) continue;
            header('location:'.$v['action']);
            break;
        }
    }

    /**
     * 设置get数据
     * @param $str
     * @return mixed
     */
    public function setGetData($str){
        $data_arr = explode('&',$str);
        foreach($data_arr as $k => $v){
            $data = explode('=',$v);
            $_GET[$data[0]] = isset($data[1])?$data[1]:null;
        }
        return $_GET;
    }

    private function validate($type){
        $res  = false;
        $type = strtolower($type);
        in_array($type,$this->type) && $res = true;
        return $res;
    }
}