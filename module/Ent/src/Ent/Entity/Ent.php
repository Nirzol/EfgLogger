<?php

namespace Ent\Entity;

class Ent
{
    public function toArray($hydrator)
    {
        $resultArray = $hydrator->extract($this);
        foreach ($resultArray as $key => $value) {
            if (is_object($value) && !($value instanceof \DateTime)) {
//                var_dump($value);
                /* @var $value \DateTime */
                $resultArray[$key] = $value->toArray($hydrator);
            }
        }

        return $resultArray;
    }
}
