<?php

namespace Ent\Service;

use Doctrine\ORM\EntityManager;
use Zend\Mail;
use Zend\Mime;

/**
 * Description of HelpRequestDoctrineService
 *
 * @author mdjimbi
 */
class HelpRequestDoctrineService implements HelpRequestServiceInterface {

    /**
     *
     * @var EntityManager
     */
    protected $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function send($message, $filePath, $fileName, $senderMail, $senderName, $recipientMail, $recipientName, $subject) {
        $text = new Mime\Part($message);
        $text->type = Mime\Mime::TYPE_TEXT;
        $text->charset = 'utf-8';

        $fileContent = fopen($filePath, 'r');

        $attachment = new Mime\Part($fileContent);
        $attachment->type = 'image/jpg';
        $attachment->disposition = Mime\Mime::DISPOSITION_ATTACHMENT;
        $attachment->filename = $fileName;

        // Setting the encoding is recommended for binary data
        $attachment->encoding = Mime\Mime::ENCODING_BASE64;

        // then add them to a MIME message
        $mimeMessage = new Mime\Message();
        $mimeMessage->setParts(array($text, $attachment));

        // and finally we create the actual email
        $mail = new Mail\Message();
        $mail->setBody($mimeMessage);

        $mail->setFrom($senderMail, $senderName);
        $mail->addTo($recipientMail, $recipientName);
        $mail->setSubject($subject);

        $transport = new Mail\Transport\Sendmail();
        $transport->send($mail);
        
        return $transport;
    }

}
