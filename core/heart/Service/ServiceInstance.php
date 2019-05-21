<?php
namespace heart\Service;

/**
 * 一次性消耗品，坏了整个程序就直接抛出
 * Class ServiceInstance
 * @package heart\Service
 */
class ServiceInstance{
    public $res;
    public $data;

    private $data_type  = 'json';
    private $class_name = '';
    private $service    = null;

    public function __construct($data_type,$class_name){
        $this->res = getSuccsess('操作成功');
        $this->data_type  = $data_type != 'json'?'jsonp':$data_type;
        $this->class_name = $class_name;

        if(class_exists($class_name)) $this->service == null && $this->service = new $class_name();
    }

    /**
     * 核心方法，代理service方法
     * @param $name
     * @param $arguments
     * @return $this
     */
    public function __call($name,$arguments){
        //action
        startTrans();
        try{
            $res = $this->service->$name(...$arguments);
            if($res === null || $res === true || (isset($res['code']) && $res['code'])){
                $msg  = isset($res['msg'])?$res['msg']:'操作成功';
                $data = isset($res['data'])?$res['data']:$res;
                $this->data = $data;
                $this->res  = getSuccsess($msg,$data);
                commit();
                return $this;
            }
            rollback();
            $this->res['code'] = false;
            $this->res['msg']  = (isset($res['code']) && $res['msg'])?$res['msg']:'操作失败';
            $this->inputInfo($this->res);
        }catch (\Exception $e){
            rollback();
            $this->res['msg'] = '操作失败';
            $this->inputInfo($this->res);
        }
    }

    public function __toString(){
        return json($this->res);
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