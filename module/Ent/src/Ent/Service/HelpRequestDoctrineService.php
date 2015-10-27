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

    public function sendWithImage($message, $filePath, $fileName, $senderMail, $senderName, $recipientMail, $recipientName, $subject) {
        $text = new Mime\Part($message);
        $text->type = Mime\Mime::TYPE_TEXT;
        $text->charset = 'utf-8';
        
        $html = new Mime\Part($message);
        $html->type = Mime\Mime::TYPE_HTML;
        
        $fileContent = fopen($filePath, 'r');

        $attachment = new Mime\Part($fileContent);
        $attachment->type = 'image/jpg';
        $attachment->disposition = Mime\Mime::DISPOSITION_ATTACHMENT;
        $attachment->filename = $fileName;

        // Setting the encoding is recommended for binary data
        $attachment->encoding = Mime\Mime::ENCODING_BASE64;

        // then add them to a MIME message
        $mimeMessage = new Mime\Message();
        $mimeMessage->setParts(array($text, $html, $attachment));

        // and finally we create the actual email
        $mail = new Mail\Message();
        $mail->setEncoding('UTF-8');
        $mail->setBody($mimeMessage);

        $mail->setFrom($senderMail, $senderName);
        $mail->addTo($recipientMail, $recipientName);
        $mail->setSubject($subject);

        $transport = new Mail\Transport\Sendmail();
        $transport->send($mail);

        return $transport;
    }

    public function sendWithoutImage($subject, $message, $senderMail, $senderName, $recipientMail, $recipientName) {
        $text = new Mime\Part($message);
        $text->type = Mime\Mime::TYPE_TEXT;
        $text->charset = 'utf-8';
        
        $html = new Mime\Part($message);
        $html->type = Mime\Mime::TYPE_HTML;
        
        $mimeMessage = new Mime\Message();
        $mimeMessage->setParts(array($text, $html));
        
        $mail = new Mail\Message();
        $mail->setEncoding("UTF-8");
        $mail->setBody($mimeMessage);
        $mail->setFrom($senderMail, $senderName);
        $mail->addTo($recipientMail, $recipientName);
        $mail->setSubject($subject);
        
        $transport = new Mail\Transport\Sendmail();
        $transport->send($mail);
        
        return $transport;
    }

}
