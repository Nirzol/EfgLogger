<?php

namespace Ent\Service;

use Zend\Form\Form;

interface HelpRequestServiceInterface 
{
    public function send($message, $filePath, $fileName, $senderMail, $senderName, $recipientMail, $recipientName, $subject);
}
