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
//        $testCas = new \EfgCasAuth\Controller\AuthController($sm->get('Zend\Authentication\AuthenticationService'), $config['cas']);
//
//        $pass = $testCas->getPublicTicket();
//        $pass = $testCas->authenticate2();
//        var_dump($pass)   ;  
//        $testCas->simple();
        // Test de la version : fait par le test unitaire CheckVersionTest
//        $this->checkVersion();
//        
//        
//        $this->mySockConnect();
//        $this->getQuotaroot($pass);
//         $aze = split("-", $pass);
        //$passnew = $aze[0] .'-'. $aze[1] .'-'. $aze[2];
        //var_dump($passnew);
//        $pass = $_SESSION['cas_pt'][php_uname('n')];
        /** @var \Zend\Mail\Message $mail */
//      connecting with Imap
//        $userName = 'egrondin' . '\0' . loginUserName;
//        $mail = new \Zend\Mail\Storage\Imap(array(
//            'host' => 'imap-i.infr.univ-paris5.fr',
////            'host' => 'imap.parisdescartes.fr',
////            'host' => 'owa.parisdescartes.fr',
////            'port' => '143',
//            'user' => 'egrondin',
//            'password' => $pass,
//            'ssl' => 'TLS',
//        ));
//        var_dump($mail);
//        var_dump($mail->countMessages());
//        $folder = $mail->getFolders()->Journal;
//        $mail->selectFolder($folder);
//        var_dump($mail->selectFolder('INBOX'));
//        $list = \imap_getmailboxes($mail, "owa.parisdescartes.fr", "*");        
//        var_dump($mail->getFolders());
//        var_dump($_SESSION);
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

    private function getQuotaroot($pass)
    {
//        if(!$socket = @fsockopen("imap-i.infr.univ-paris5.fr", 143);
//        return false;
        if (!($socket = fsockopen('imap-i.infr.univ-paris5.fr', 143, $errno, $errstr))) {
            die("Could not connect to host");
        }
        fgets($socket, 1024);

//        fputs($socket, "a001 STARTTLS\r\n");
//        var_dump(fgets($socket, 1024));// 
//        $username = 'egrondin';
//        fputs($socket, "a001 LOGIN " . $username . "\r\n");
//        var_dump(fgets($socket, 1024));       
//        
//        fputs($socket, "a001 AUTHENTICATE PLAIN\r\n");
//        var_dump(fgets($socket, 1024));

        $password = $_SESSION['cas_pt'][php_uname('n')];
//        fputs($socket, "a001 " . $password . "\r\n");
//        var_dump(fgets($socket, 1024));
//        $user = 'egrondin';
//        $authc = 'https://onepiece.dsi.univ-paris5.fr/api/';
//        $pass = $password;
//        $reply = base64_encode($user . chr(0) . $authc . chr(0) . $pass);
//        
//        fputs($socket, "a001 AUTHENTICATE PLAIN " . $reply . "\r\n");
//        var_dump(fgets($socket, 1024));
//
//
//        $this->execute("AUTHENTICATE PLAIN", array($reply), 
//                self::COMMAND_LASTLINE | self::COMMAND_CAPABILITY | self::COMMAND_ANONYMIZED);
        // Send data to server
//        echo "Writing data...";
//        fwrite($socket, "a001 CAPABILITY\r\n");
//        echo " Done\r\n";
//
//        // Keep fetching lines until response code is correct
//        while ($line = fgets($socket, 1024)) {
//            echo $line . '<br />';
//            $line = preg_split('/\s+/', $line, 0, PREG_SPLIT_NO_EMPTY);
//            $code = $line[0];
//            if (strtoupper($code) == 'a001') {
//                break;
//            }
//        }
//
//        echo "I've finished!<br />";



        $username = 'egrondin';
        $password = $pass;
//        $username = 'eric-grondin@parisdescartes.fr';
//        $password = '753descartes159!';
        fputs($socket, "a001 LOGIN " . $username . " " . $password . "\r\n");
        var_dump(fgets($socket, 1024));
//        fputs($socket, "a002 GETQUOTAROOT INBOX\n");
//        fgets($socket, 1024);
//        $result = fgets($socket, 1024);
//        fputs($socket, "a003 LOGOUT\n");
//        fgets($socket, 1024);
//        sscanf($result, '* QUOTA "ROOT" (STORAGE %d %d MESSAGE %d %d', $usedSize, $maxSize, $usedNum, $maxNum);
//        
//        return array("usedSize" => $usedSize, "maxSize" => $maxSize, "usedNum" => $usedNum, "maxNum" => $maxNum);
    }

    public function mySockConnect()
    {

//        $okImap = new Plugin\entImap();
//        $okImap->connect('imap-i.infr.univ-paris5.fr', 143);
//        $okImap->login('egrondin', $_SESSION['cas_pt'][php_uname('n')]);
//        
//        var_dump($okImap->countMessages());
//  // Open a socket
//  if (!($fp = fsockopen('imap-i.infr.univ-paris5.fr', 143, $errno, $errstr, 15))) {
//      die("Could not connect to host");
//  }
//
//  // Set timout to 1 second
//  if (!stream_set_timeout($fp, 1)) die("Could not set timeout");
//
//  // Fetch first line of response and echo it
//  echo fgets($fp);
//
//  // Send data to server
//  echo "Writing data...";
//  fwrite($fp, "C01 CAPABILITY\r\n");
//  echo " Done\r\n";
//
//  // Keep fetching lines until response code is correct
//  while ($line = fgets($fp)) {
//    echo $line . '<br />';
//    $line = preg_split('/\s+/', $line, 0, PREG_SPLIT_NO_EMPTY);
//    $code = $line[0];
//    if (strtoupper($code) == 'C01') {
//      break;
//    }
//  }
//
//  echo "I've finished!<br />";
//  var_dump($_SESSION['cas_pt'][php_uname('n')]);
//  $request = fwrite($fp, "A000 LOGIN egrondin ".$_SESSION['cas_pt'][php_uname('n')]."\r\n");
//  
//  
//    // Keep fetching lines until response code is correct
//  while ($line1 = fgets($request)) {
//    echo $line1 . '<br />';
//    $line1 = preg_split('/\s+/', $line1, 0, PREG_SPLIT_NO_EMPTY);
//    $code2 = $line1[0];
//    if (strtoupper($code2) == 'A000') {
//      break;
//    }
//  }
////  $request = fputs($fp,"a1 LOGIN egrondin ".$_SESSION['cas_pt'][php_uname('n')]."\r\n");
////$receive = fgets($fp, 4096);
//echo fgets($fp);
//echo 'request: '.$request.'<br/>'; 
////echo 'login: '.$receive.'<br/>'; 
    }
}
