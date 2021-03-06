<?php
return [
    /**
     * 静态路由
     */
    //前台首页
    [
        'type'   => 'static',
        'url'    => '/',
        'action' => '/cool/page/index/index.html'
    ],
    //后台首页
    [
        'type'   => 'static',
        'url'    => '/admin',
        'action' => '/cool/page/admin/index.html'
    ],

    /**
     * 接口
     */
    //用户登录 complete
    [
        'type'   => 'post',
        'url'    => '/put/login',
        'action' => 'api/front/user/login'
    ],
    //用户注册 complete
    [
        'type'   => 'post',
        'url'    => '/post/register',
        'action' => 'api/front/user/register'
    ],
    //判断是否登录 complete
    [
        'type'   => 'get',
        'url'    => '/get/isLogin',
        'action' => 'api/front/user/loginJudge'
    ],

    //获取酷事列表 complete
    [
        'type'   => 'get',
        'url'    => '/get/thingsList',
        'action' => 'api/front/index/thingsList'
    ],
    //获取酷事标签
    [
        'type'   => 'get',
        'url'    => '/get/tagList',
        'action' => 'api/front/index/tagList'
    ],
    //获取酷事详情
    [
        'type'   => 'post',
        'url'    => '/get/thingsDetail',
        'action' => 'api/front/index/thingsDetail'
    ],
    //关注酷事
    [
        'type'   => 'post',
        'url'    => '/put/followThings',
        'action' => 'api/front/index/followThings'
    ],
    //获取酷事评论
    [
        'type'   => 'post',
        'url'    => '/get/commentList',
        'action' => 'api/index/index/commentList'
    ],
    //发表评论
    [
        'type'   => 'post',
        'url'    => '/post/addComment',
        'action' => 'api/front/index/addComment'
    ],
    //增加酷事
    [
        'type'   => 'post',
        'url'    => '/get/addThings',
        'action' => 'api/front/index/addThings'
    ],

    //增加实例
    [
        'type'   => 'post',
        'url'    => '/get/addInstance',
        'action' => 'api/front/instance/addInstance'
    ],
    //获取实例列表
    [
        'type'   => 'post',
        'url'    => '/get/instanceList',
        'action' => 'api/front/instance/instanceList'
    ],
    //获取实例详情
    [
        'type'   => 'post',
        'url'    => '/get/instanceDetail',
        'action' => 'api/front/instance/instanceDetail'
    ],
    //点赞
    //获取实例评论
    //增加实例评论

    /**
     * 小程序接口
     */
    [
        'type'   => 'get',
        'url'    => '/get/miniInit',
        'action' => 'api/mini/user/miniInit'
    ],

    //测试接口
    [
        'type'   => 'put',
        'url'    => '/put/test',
        'action' => 'api/test/index'
    ]
];