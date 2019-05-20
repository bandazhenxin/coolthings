<?php
namespace heart\Service;

use ArrayAccess;

/**
 * service代理工厂
 * Class Service
 * @package heart
 */
class ServiceBasic implements ArrayAccess{
    private $data_type    = 'json';
    private $called_space = '';
    private $default_name = '';
    private $server_name  = [];

    public function __construct($data_type,$called_class){
        $this->data_type = $data_type != 'json'?'jsonp':$data_type;

        //name_spase
        $called_class = str_replace('Controller','Service',$called_class);
        $space_arr = explode('\\',$called_class);
        $this->default_name = end($space_arr);
        array_pop($space_arr);
        $this->called_space = implode('\\',$space_arr);
    }

    public function offsetExists( $offset ) {
        if(!is_string($offset)) return false;
        return $this->isService($offset);
    }

    public function offsetGet( $offset ) {
        if(!is_string($offset)) $this->inputInfo(getInit('service传值不规范'));
        if($this->isService($offset)){
            $offset = ucfirst($offset);
            return $this->server_name[$offset];
        }
        $this->inputInfo(getInit('service不存在'));
    }

    public function offsetSet( $offset, $value ) {
        return false;//不允许设置
    }

    public function offsetUnset($offset) {
        return false;//不允许删除
    }

    /**
     * 判断service是否存在
     * @param $name
     * @return bool
     */
    private function isService($name){
        $name      = ucfirst($name);
        $class_name = $this->called_space.'\\'.$name;
        if(isset($this->server_name[$name])) return true;
        if(class_exists($class_name)){
            $this->server_name[$name] = new ServiceInstance($this->data_type,$class_name);
            return true;
        }

        return false;
    }

    /**
     * 输出
     * @param array $result
     */
    private function inputInfo($result = []){
        $data = json($result);
        switch ($this->data_type){
            case 'json':
                break;
            case 'jsonp':
                if(isset($_GET['callback'])){
                    $data = $_GET['callback'].'('.$data.')';
                }else{
                    throwError("请传递callback参数");
                }
                break;
        }
        exit($data);
    }
}