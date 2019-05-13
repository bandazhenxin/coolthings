<?php
namespace App\Controller\Api;

class Test1{
    public function index(){
        dd(getRoute()::$action);
    }
}