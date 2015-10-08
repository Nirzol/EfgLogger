<?php

namespace Ent\Service;

use Zend\Form\Form;

interface HelpRequestServiceInterface 
{
    public function sendWithImage($message, $filePath, $fileName, $senderMail, $senderName, $recipientMail, $recipientName, $subject);
    
    public function sendWithoutImage($subject, $message, $senderMail, $senderName, $recipientMail, $recipientName);
}
