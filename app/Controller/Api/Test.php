<?php
namespace App\Controller\Api;

class Test{
    public function index(){
        dd(getRoute()::$action);
    }
}