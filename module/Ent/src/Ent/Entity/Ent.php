<?php

namespace Ent\Entity;

use DateTime;
use Doctrine\ORM\PersistentCollection;

class Ent
{

    public function toArray($hydrator, $owner = null)
    {
        $resultArray = $hydrator->extract($this); //Aray = Entity
        foreach ($resultArray as $key => $value) { //Array as string => object ?
            if (\is_object($value) && !($value instanceof DateTime) && \is_a($value, 'Doctrine\ORM\PersistentCollection')) {
                /* @var $value PersistentCollection */
//                var_dump($value);
                if (!$value->isEmpty() && ($owner === null || !($this instanceof $owner))) {
                    if ($owner == null) {
                        $owner = $this;
                    }
                    $resultArray[$key] = $this->subExctract($value, $hydrator, $owner);
                }
            } 
//            else if (\is_object($value) && !($value instanceof DateTime) && $value instanceof \Doctrine\ORM\Proxy\Proxy) {
//                //TODO
//                if ($proxy) {
//                    $resultArray[$key] = $value->toArray($hydrator, null, false);
//                }
//            } 
            else if (is_object($value) && !($value instanceof DateTime)) {
//                var_dump(get_class($value));
                $resultArray[$key] = $value->toArray($hydrator);
            }
        }
        return $resultArray;
    }

    private function subExctract($value, $hydrator, $owner)
    {
        $valueToArray = $value->toArray(); //Array = Collection
        if (!$value->isEmpty()) {
            foreach ($valueToArray as $subKey => $subValue) {
                if (is_object($subValue) && !($subValue instanceof DateTime)) {
                    if (\get_class($this) != \get_class($subValue)) {
                        $owner = $subValue;
                    }
                    $valueToArray[$subKey] = $subValue->toArray($hydrator, $owner);
                }
            }
        }
        return $valueToArray;
    }

//    public function toArray($hydrator)
//    {
//        $resultArray = $hydrator->extract($this);
//        foreach ($resultArray as $key => $value) {
//            if (is_object($value) && !($value instanceof \DateTime)) {
////                var_dump($value);
//                /* @var $value \DateTime */
//                $resultArray[$key] = $value->toArray($hydrator);
//            }
//        }
//
//        return $resultArray;
//    }

    public function toString()
    {

        $result = '';

        if (($this->getLogDatetime()) && ($this->getLogDatetime() != NULL)) {
            $result = $result . ' ' . $this->getLogDatetime()->format('Y-m-d H:i:s');
        }
        if (($this->getLogLogin()) && ($this->getLogLogin() != NULL)) {
            $result = $result . ' ' . $this->getLogLogin();
        }
        if (($this->getLogSession()) && ($this->getLogSession() != NULL)) {
            $result = $result . ' ' . $this->getLogSession();
        }
        if (($this->getLogIp()) && ($this->getLogIp() != NULL)) {
            $result = $result . ' ' . $this->getLogIp();
        }
        if (($this->getLogOnline()) && ($this->getLogOnline() != NULL)) {
            $result = $result . ' ' . $this->getLogOnline()->format('Y-m-d H:i:s');
        }
        if (($this->getLogUseragent()) && ($this->getLogUseragent() != NULL)) {
            $result = $result . ' ' . $this->getLogUseragent();
        }
        if (($this->getFkLogModule()) && ($this->getFkLogModule() != NULL)) {
            $result = $result . ' ' . $this->getFkLogModule()->getModuleName();
        }
        if (($this->getFkLogAction()) && ($this->getFkLogAction() != NULL)) {
            $result = $result . ' ' . $this->getFkLogAction()->getActionName();
        }
        if ($this->getVersion()) {
            return $this->getVersion() . " de " . $this->getVersionDate()->format('Y-m-d H:i:s');
        }

        return $result;
    }

}
