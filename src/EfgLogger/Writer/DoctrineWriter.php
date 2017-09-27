<?php

namespace EfgLogger\Writer;

use Zend\Log\Formatter\Db as DbFormatter;
use Zend\Log\Writer\AbstractWriter;
use EfgLogger\Entity\TableLog;
use Doctrine\ORM\EntityManager;

/**
 * Description of Doctrine
 *
 */
class DoctrineWriter extends AbstractWriter
{

    /**
     * @var null|array
     */
    private $columnMap = null;

    /**
     * @var string
     */
    private $modelClass = null;

    /**
     *
     * @var TableLog
     */
    private $logEntity;

    /**
     *
     * @var EntityManager
     */
    private $em;

    /**
     * Constructor
     *
     * @param string $modelClass
     * @param array $columnMap
     * @return void
     */
    public function __construct($modelClass, EntityManager $entityManager, $columnMap = null)
    {
        if (!$modelClass || !class_exists($modelClass)) {
            throw new \RuntimeException(__METHOD__ . " you need use entity name as param");
        }
        $this->em = $entityManager;
        $this->columnMap = $columnMap;
        $this->modelClass = $modelClass;
        if (!$this->hasFormatter()) {
            $this->setFormatter(new DbFormatter());
        }
    }

    protected function doWrite(array $event)
    {
        // Transform the event array into fields
        if (null === $this->columnMap) {
            $dataToInsert = $this->eventIntoColumn($event);
        } else {
            $dataToInsert = $this->mapEventIntoColumn($event, $this->columnMap);
        }
//        var_dump($event, $dataToInsert);

        $this->logEntity = new $this->modelClass();
        $this->logEntity->exchangeArray($dataToInsert);
        if ($event['extra']) {
            $this->logEntity->exchangeArray($event['extra']);
        }
        try {
            $this->checkEMConnection();
            $this->em->persist($this->logEntity);
            $this->em->flush();
        } catch (\Exception $e) {
            //reconnect on exeption
            $this->checkEMConnection();
        }
    }

    /**
     * reconnect
     */
    protected function checkEMConnection()
    {
        if (!$this->em->isOpen()) {
            $connection = $this->em->getConnection();
            $config = $this->em->getConfiguration();
            $this->em = $this->em->create(
                $connection,
                $config
            );
        }
    }

    /**
     * Map event into column using the $columnMap array
     *
     * @param  array $event
     * @param  array $columnMap
     * @return array
     */
    protected function mapEventIntoColumn(array $event, array $columnMap = null)
    {
        if (empty($event)) {
            return [];
        }

        $data = [];
        foreach ($event as $name => $value) {
            if (is_array($value)) {
                foreach ($value as $key => $subvalue) {
                    if (isset($columnMap[$name][$key])) {
                        if (is_scalar($subvalue)) {
                            $data[$columnMap[$name][$key]] = $subvalue;
                            continue;
                        }

                        $data[$columnMap[$name][$key]] = var_export($subvalue, true);
                    }
                }
            } elseif (isset($columnMap[$name])) {
                $data[$columnMap[$name]] = $value;
            }
        }
        return $data;
    }

    /**
     * Transform event into column for the db table
     *
     * @param  array $event
     * @return array
     */
    protected function eventIntoColumn(array $event)
    {
        if (empty($event)) {
            return [];
        }

        $data = [];
        foreach ($event as $name => $value) {
            if (is_array($value)) {
                foreach ($value as $key => $subvalue) {
                    if (is_scalar($subvalue)) {
                        $data[$name . $this->separator . $key] = $subvalue;
                        continue;
                    }

                    $data[$name . $this->separator . $key] = var_export($subvalue, true);
                }
            } else {
                $data[$name] = $value;
            }
        }
        return $data;
    }
}
