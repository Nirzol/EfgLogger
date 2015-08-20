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
                if (!$value->isEmpty() && ($owner === null || !($this instanceof $owner))) {
                    if ($owner == null) {
                        $owner = $this;
                    }
                    $resultArray[$key] = $this->subExctract($value, $hydrator, $owner);
                }
            } else if (is_object($value) && !($value instanceof DateTime)) {
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
}
