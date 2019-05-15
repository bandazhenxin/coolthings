<?php
namespace heart;

class Model{
    public function __construct(){
        $children      = get_class($this);
        $children_arr  = explode('\\',$children);
        $children_name = strtolower(end($children_arr));
        if(!isset($this->table)) $this->table = $children_name;
    }

    /**
     * 代理DB方法
     */

    public function table(){
        throwError('model层禁止调用'.__FUNCTION__.'方法');
        return false;
    }

    public function query(){
        throwError('model层禁止调用'.__FUNCTION__.'方法');
        return false;
    }

    public function update($fields = [], $id=null){
        $res = db()->update($this->table,$fields,$id);
        return $res;
    }

    public function insert($fields = []){
        $res = db()->insert($this->table,$fields);
        return $res;
    }

    public function delete($id=null){
        $res = db()->delete($id);
        return $res;
    }

    /**
     * 同步调用db类
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name,$arguments){
        db()->table($this->table);
        $res = false;

        $res = db()->$name(...$arguments);
        return $res;
    }
}