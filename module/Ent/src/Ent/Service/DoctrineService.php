<?php

namespace Ent\Service;

/**
 * Description of DoctrineService
 *
 * @author egrondin
 */
class DoctrineService
{

    public function addFormMessageToErrorLog($messages)
    {
        foreach ($messages as $messagesKey => $message) {
            foreach ($message as $key => $value) {
                error_log($messagesKey . ' -- ' .$key. ' : ' .$value);
            }
        }
    }

}
