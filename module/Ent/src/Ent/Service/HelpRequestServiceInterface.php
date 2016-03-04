<?php

namespace Ent\Service;

use Zend\Form\Form;

interface HelpRequestServiceInterface
{

    public function sendWithImage($message, $filePaths, $fileNames, $senderMail, $senderName, $recipientMail, $recipientName, $subject);

    public function sendWithoutImage($subject, $message, $senderMail, $senderName, $recipientMail, $recipientName);
}
