<?php

namespace Owa\Controller\Plugin;

use Owa\Model\Owa;
use PhpEws\EwsConnection;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

/**
 * Description of OwaPlugin
 *
 * @author fandria
 */
class OwaPlugin extends AbstractPlugin {
    public function getNotifMail(EwsConnection $ews, $mail)
    {
        $owa = new Owa($ews);
        
        $owa->setImpersonation($mail);
        $mails = $owa->getUnreadMails();

        if (!is_null($mails)) {
            $number = $owa->getNumberOfUnread($mails);
            
            return $number;
        }
        return null;
    }
}
