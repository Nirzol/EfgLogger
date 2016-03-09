<?php

namespace EfgLogger\Service;

//use Zend\Log\Logger as ZendLogger;
//use Zend\Log\LoggerInterface as ZendLoggerInterface;
//use EfgLogger\Service\LoggerInterface;
//use Psr\Log\LogLevel;

class Logger extends \Zend\Log\Logger
{

    /**
     * Extra column values
     * @var array
     */
    private $extra = [];

    /**
     * Zend logger implementation
     * @var ZendLoggerInterface
     */
//    private $externalLogger;

    /**
     * map from psr log levels
     * to zend log priorities for compability
     * @var type
     */
//    private $psrToZendPriorityMap = [
//        LogLevel::ALERT => ZendLogger::ALERT,
//        LogLevel::CRITICAL => ZendLogger::CRIT,
//        LogLevel::DEBUG => ZendLogger::DEBUG,
//        LogLevel::EMERGENCY => ZendLogger::EMERG,
//        LogLevel::ERROR => ZendLogger::ERR,
//        LogLevel::INFO => ZendLogger::INFO,
//        LogLevel::NOTICE => ZendLogger::NOTICE,
//        LogLevel::WARNING => ZendLogger::WARN,
//    ];

    /**
     *
     * @param array $extra
     * @param \Zend\Log\LoggerInterface|null $externalLogger
     * @throws \RuntimeException
     */
    
//    public function __construct(array $extra = [], $externalLogger = null)
    public function __construct(array $extra = [])
    {
        $this->extra = $extra;
        parent::__construct();
//        if (!$externalLogger) {
//            $this->externalLogger = new ZendLogger();
//        } else if ($externalLogger instanceof ZendLoggerInterface) {
//            $this->externalLogger = $externalLogger;
//        } else {
//            throw new \RuntimeException(__METHOD__ . " you must set log class "
//            . "that implement Zend\Log\LoggerInterface");
//        }
    }

    /**
     * Get setted extra
     * @return array
     */
    public function getExtra()
    {
        return $this->extra;
    }

    /**
     * Set extra values
     * usage: addExtra(['extraName' => 'extraValue']);
     * @param array $extra
     */
    public function addExtra(array $extra = array())
    {
        if (count($this->getExtra()) > 0) {
            $this->extra = array_merge($this->getExtra(), $extra);
        } else {
            $this->extra = $extra;
        }
    }

    /**
     * AddExtra alias
     * @param array $extra
     */
    public function setExtra(array $extra = array())
    {
        $this->addExtra($extra);
    }

    /**
     * Main log function
     * @param type $priority
     * @param type $message
     * @param array $extra
     */
    public function log($priority, $message, $extra = [])
    {
//        parent::log($priority, $message, $this->getExtra());
//        
//        if (isset($this->psrToZendPriorityMap[$level])) {
//            $level = $this->psrToZendPriorityMap[$level];
//        }
//        $this->log($priority, $message, $this->getExtraWithContextMerged($context));
//        $this->log($priority, $message, $this->getExtra());
        parent::log($priority, $message, $this->getExtraWithContextMerged($extra));
    }

    /**
     * Merge extra with current context
     * @param array $context
     * @return type
     */
    private function getExtraWithContextMerged(array $context = array())
    {
        $extra = $this->getExtra();
        if (!empty($context)) {
            $extra = array_merge($extra, $context);
        }
        return $extra;
    }

//    public function alert($message, array $context = array())
//    {
//        $this->externalLogger->alert($message, $this->getExtraWithContextMerged($context));
//    }
//
//    public function critical($message, array $context = array())
//    {
//        $this->externalLogger->crit($message, $this->getExtraWithContextMerged($context));
//    }
//
//    public function emergency($message, array $context = array())
//    {
//        $this->externalLogger->emerg($message, $this->getExtraWithContextMerged($context));
//    }
//
//    public function error($message, array $context = array())
//    {
//        $this->externalLogger->err($message, $this->getExtraWithContextMerged($context));
//    }
//
//    public function warning($message, array $context = array())
//    {
//        $this->externalLogger->warn($message, $this->getExtraWithContextMerged($context));
//    }
//
//    public function debug($message, array $context = array())
//    {
//        $this->externalLogger->debug($message, $this->getExtraWithContextMerged($context));
//    }
//
//    public function info($message, array $context = array())
//    {
//        $this->externalLogger->info($message, $this->getExtraWithContextMerged($context));
//    }
//
//    public function notice($message, array $context = array())
//    {
//        $this->externalLogger->notice($message, $this->getExtraWithContextMerged($context));
//    }

//    public function addWriter($writer)
//    {
//        $this->externalLogger->addWriter($writer);
//    }

    /**
     * Call for other methods
     * @param type $name
     * @param type $arguments
     * @throws \BadMethodCallException
     */
//    public function __call($name, $arguments)
//    {
//        if (method_exists($this->externalLogger, $name)) {
//            \call_user_func_array(array($this->externalLogger, $name), $arguments);
//        } else {
//            throw new \BadMethodCallException(__METHOD__ . " method " .
//            $name . " does not exists");
//        }
//    }
}
