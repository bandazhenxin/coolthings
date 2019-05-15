<?php
namespace App\Lib\Utils;

use Monolog\Logger;

/**
 * Class LoggerTrait
 * @package Libraries\Utils
 * @author Bardeen
 */
trait LoggerTrait
{
    /**
     * @param $channel
     * @param $message
     * @param $priority
     * @return $this
     */
    public function log($channel,$message,$context,$priority){
        //init
        $logger_flyweight = FlyweightLogger::getInstance();
        $logger = $logger_flyweight::setChannel($channel,$priority);

        //action
        $context = is_array($context)?$context:[$context];
        $logger->addRecord($priority, $message, $context);
        return $this;
    }

    /**
     * @param $channel
     * @param $message
     * @return $this
     */
    public function errorLog($channel,$message,$context){
        $priority = Logger::ERROR;
        return $this->log($channel,$message,$context,$priority);
    }

    /**
     * @param $channel
     * @param $message
     * @return $this
     */
    public function warningLog($channel,$message,$context){
        $priority = Logger::WARNING;
        return $this->log($channel,$message,$context,$priority);
    }

    /**
     * @param $channel
     * @param $message
     * @return $this
     */
    public function infoLog($channel,$message,$context){
        $priority = Logger::INFO;
        return $this->log($channel,$message,$context,$priority);
    }

    /**
     * @param $channel
     * @param $message
     * @return $this
     */
    public function noticeLog($channel,$message,$context){
        $priority = Logger::NOTICE;
        return $this->log($channel,$message,$context,$priority);
    }

    /**
     * @param $channel
     * @param $message
     * @return $this
     */
    public function criticalLog($channel,$message,$context){
        $priority = Logger::CRITICAL;
        return $this->log($channel,$message,$context,$priority);
    }

    /**
     * @param $channel
     * @param $message
     * @return $this
     */
    public function alertLog($channel,$message,$context){
        $priority = Logger::CRITICAL;
        return $this->log($channel,$message,$context,$priority);
    }

    /**
     * @param $channel
     * @param $message
     * @return $this
     */
    public function emergancyLog($channel,$message,$context){
        $priority = Logger::EMERGENCY;
        return $this->log($channel,$message,$context,$priority);
    }
}