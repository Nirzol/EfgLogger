<?php

namespace Ent\Controller;

use CAS_ProxiedService_Imap;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Controller\ControllerManager;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

    public function indexAction()
    {
//        $sm = $this->getServiceLocator();
//        $config = $sm->get('Config');
//
//        $testCas = new AuthController($sm->get('Zend\Authentication\AuthenticationService'), $config['cas']);
//
//        $testCas->getPublicTicket();
        // Test de la version : fait par le test unitaire CheckVersionTest
//        $this->checkVersion();
//        
//        
       
       /** @var \Zend\Mail\Message $mail */

        
        
        // connecting with Imap
//        $mail = new \Zend\Mail\Storage\Imap(array('host' => 'owa.parisdescartes.fr',
//            'user' => 'svc-ent',
//            'password' => 'Olive4Ever!'));
//        $folder = $mail->getFolders()->Journal;
//        $mail->selectFolder($folder);
////        var_dump($mail->selectFolder('INBOX'));
//        
////        $list = \imap_getmailboxes($mail, "owa.parisdescartes.fr", "*");        
//        
////        var_dump($mail->getFolders());
////        var_dump($_SESSION);
//        \phpCAS::proxy();
//        $test = new CAS_ProxiedService_Imap('egrondin');
//        $test->setMailbox('INBOX');
//        $test->open();
        
   // find unread messages
//echo "Unread mails:\n";
//var_dump($mail->countMessages());
//foreach ($mail as $message) {
//    if ($message->hasFlag(\Zend\Mail\Storage::FLAG_SEEN)) {
//        continue;
//    }
//    // mark recent/new mails
//    if ($message->hasFlag(\Zend\Mail\Storage::FLAG_RECENT)) {
//        echo '! ' . \Zend\Mail\Storage::FLAG_RECENT;
//    } else {
//        echo '  ';
//    }
//    echo $message->subject . "<br /><br />";
//}
//
//// check for known flags
//$flags = $message->getFlags();
//echo "Message is flagged as: ";
//foreach ($flags as $flag) {
//    switch ($flag) {
//        case \Zend\Mail\Storage::FLAG_ANSWERED:
//            echo 'Answered ';
//            break;
//        case \Zend\Mail\Storage::FLAG_FLAGGED:
//            echo 'Flagged ';
//            break;
//
//        // ...
//        // check for other flags
//        // ...
//
//        default:
//            echo $flag . '(unknown flag) ';
//    }
//}     
        
//        for ($i = 1; $i <= $mail->countMessages(); $i++) {
//            var_dump($mail->getMessage($i)->subject);
//        }


        return new ViewModel();
    }

    public function addAction()
    {
        /*
         * @TODO
         */
        return new ViewModel();
    }

    public function checkVersion()
    {
        /* @var $serviceLocator ControllerManager */
        $sm = $this->getServiceLocator();

        // recupere toute la config avec toutes les cles
        $config = $sm->get('config');

        // Recuperation version ENT Zend et compatibilite avec Angular et BD ENT
        $versions = $config['versions'];
        $bdVersionRequired = $versions['dependencies']['data-base-version'];

        // Recuperation version BD
        $serviceEo = $sm->get('Ent\Service\Version');
        $bdVersionEo = $serviceEo->getLastInserted();

        $bdVersionCurrent = "";
        if (isset($bdVersionEo) && ($bdVersionEo != null)) {
            $bdVersionCurrent = $bdVersionEo->getVersion();
        }

        $isMatchBdVersion = $bdVersionRequired === $bdVersionCurrent;

        if ($isMatchBdVersion) {
            error_log("INFO: ENT Zend App version = " . $versions['version'] . " matches database version " . $bdVersionCurrent);
        } else {
            error_log("===== Error : ENT Zend App version = " . $versions['version'] . " needs database version " . $versions['dependencies']['data-base-version']);
            error_log("===== Your database version is " . $bdVersionCurrent);
        }
        return $isMatchBdVersion;
//        return array( $versions, $bdVersionEo);
    }

}
