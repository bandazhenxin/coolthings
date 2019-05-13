<?php
namespace heart;

class Session{
    protected static $init = null;

    //初始化
    public static function init(){
        //init
        $config    = config("session");
        $isDoStart = false;

        //set
        if (isset($config['use_trans_sid'])) ini_set('session. ', $config['use_trans_sid'] ? 1 : 0);

        // 启动session
        if (!empty($config['auto_start']) && PHP_SESSION_ACTIVE != session_status()) {
            ini_set('session.auto_start', 0);
            $isDoStart = true;
        }

        //set continue
        if (isset($config['var_session_id']) && isset($_REQUEST[$config['var_session_id']])) {
            session_id($_REQUEST[$config['var_session_id']]);
        } elseif (isset($config['id']) && !empty($config['id'])) {
            session_id($config['id']);
        }
        if (isset($config['name'])) session_name($config['name']);
        if (isset($config['path'])) session_save_path($config['path']);
        if (isset($config['domain'])) ini_set('session.cookie_domain', $config['domain']);
        if (isset($config['expire'])) {
            ini_set('session.gc_maxlifetime', $config['expire']);
            ini_set('session.cookie_lifetime', $config['expire']);
        }
        if (isset($config['secure'])) ini_set('session.cookie_secure', $config['secure']);
        if (isset($config['httponly'])) ini_set('session.cookie_httponly', $config['httponly']);
        if (isset($config['use_cookies'])) ini_set('session.use_cookies', $config['use_cookies'] ? 1 : 0);
        if (isset($config['cache_limiter'])) session_cache_limiter($config['cache_limiter']);
        if (isset($config['cache_expire'])) session_cache_expire($config['cache_expire']);

        //start
        if ($isDoStart) {
            session_start();
            self::$init = true;
        } else {
            self::$init = false;
        }
    }

    /**
     * session自动启动或者初始化
     * @return void
     */
    public static function boot()
    {
        if (is_null(self::$init)) {
            self::init();
        } elseif (false === self::$init) {
            if (PHP_SESSION_ACTIVE != session_status()) session_start();
            self::$init = true;
        }
    }

    /**
     * 主动启动session
     * @return void
     */
    public static function start()
    {
        session_start();
        self::$init = true;
    }

    /**
     * 设置session
     * @param String $name   session name
     * @param Mixed  $data   session data
     * @param Int    $expire 超时时间(秒)
     */
    public static function set($name, $data, $expire=600){
        empty(self::$init) && self::boot();
        if(!is_string($name)) return false;

        $session_data = [
            'data'   => $data,
            'expire' => time()+$expire
        ];
        $_SESSION[$name] = $session_data;
    }

    /**
     * 读取session
     * @param  String $name  session name
     * @return Mixed
     */
    public static function get($name){
        empty(self::$init) && self::boot();
        if(!is_string($name)) return false;

        if(isset($_SESSION[$name])){
            if($_SESSION[$name]['expire']>time()){
                return $_SESSION[$name]['data'];
            }else{
                self::clear($name);
            }
        }
        return false;
    }

    /**
     * 判断session数据
     * @param string        $name session名称
     * @param string|null   $prefix
     * @return bool
     */
    public static function has($name)
    {
        empty(self::$init) && self::boot();
        if(!is_string($name)) return false;
        return isset($_SESSION[$name]);
    }

    /**
     * 清除session
     * @param  String  $name  session name
     */
    private static function clear($name){
        if(!is_string($name)) return false;
        unset($_SESSION[$name]);
    }

    /**
     * 销毁session
     * @return void
     */
    public static function destroy()
    {
        if (!empty($_SESSION)) {
            $_SESSION = [];
        }
        session_unset();
        session_destroy();
        self::$init = null;
    }
}