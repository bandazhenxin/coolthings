<?php
return [
    'id' => '',
    // SESSION_ID的提交变量,解决flash上传跨域
    'var_session_id' => '',
    // 驱动方式 支持redis memcache memcached
    'type' => '',
    // 是否自动开启 SESSION
    'auto_start' => true

    //还有很多可设置值，具体的看heart 下的session类的init方法
];