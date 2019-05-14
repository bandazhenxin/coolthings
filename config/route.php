<?php
return [
    /**
     * 静态路由
     */
    //前台首页
    [
        'type'   => 'static',
        'url'    => '/',
        'action' => '/cool/page/front/index.html'
    ],

    /**
     * 接口
     */
    //获取酷事列表
    [
        'type'   => 'post',
        'url'    => '/get/thinsList',
        'action' => 'api/front/index/thinsList'
    ],
    //测试接口
    [
        'type'   => 'get',
        'url'    => '/test',
        'action' => 'api/test/index'
    ]
];