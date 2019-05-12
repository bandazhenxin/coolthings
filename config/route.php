<?php
return [
    /**静态路由**/
    //前台首页
    [
        'type'   => 'static',
        'url'    => '/',
        'action' => '/cool/page/front/index.html'
    ],

    /**接口**/
    //首页获取接口
    [
        'type'   => 'get',
        'url'    => '/test',
        'action' => 'Api/test/index'
    ]
];