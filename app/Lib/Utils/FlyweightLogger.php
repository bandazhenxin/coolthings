<?php
namespace App\Lib\Utils;

use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

class FlyweightLogger{
    public static $instance = null;

    public static $CHANNEL_MAP = [
        'baidumap' => '/log/map/',
        'default' => '/log/normal/'
    ];

    private static $channel = [];

    final private function __construct(){}

    final private function __clone(){}

    /**
     * @return QueueAggregate
     */
    final public static function getInstance(){
        if(null === self::$instance){
            self::$instance = new FlyweightLogger();
        }
        return self::$instance;
    }

    /**
     * @param null $service_name
     * @return Application|null
     */
    static function getChannel($channel_name){
        $return = false;
        isset(self::$channel[$channel_name]) && $return = self::$channel[$channel_name];
        return $return;
    }

    static function setChannel($channel_name,$priority){
        if(!isset(self::$channel[$channel_name])){
            self::$channel[$channel_name] = new Logger($channel_name);
            $log_path = isset(self::$CHANNEL_MAP[$channel_name])?RUNTIME_PATH . self::$CHANNEL_MAP[$channel_name] . DS:RUNTIME_PATH . self::$CHANNEL_MAP['default'];
            self::$channel[$channel_name]->pushHandler(new RotatingFileHandler($log_path .$channel_name.".log", $priority));
        }
        return self::$channel[$channel_name];
    }
}