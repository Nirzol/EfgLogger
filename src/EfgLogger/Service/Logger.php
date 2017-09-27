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
     *
     * @param array $extra
     * @param \Zend\Log\LoggerInterface|null $externalLogger
     * @throws \RuntimeException
     */
    public function __construct(array $extra = [])
    {
        $this->extra = $extra;
        parent::__construct();
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
}
