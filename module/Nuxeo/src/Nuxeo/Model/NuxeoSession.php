<?php

namespace Nuxeo\Model;

use Nuxeo\Model\NuxeoRequest;

/**
 * Session class
 *
 * Class which stocks username,password, and open requests
 *
 * @author     Arthur GALLOUIN for NUXEO agallouin@nuxeo.com
 */
class NuxeoSession
{

    private $url;
    private $username;
    private $password;
    private $userSession;
    private $urlLoggedIn;
    private $headers;

    public function __construct($url = "http://localhost:8080/nuxeo/site/automation", $username = "Administrator", $password = "Administrator", $headers = "Content-Type: application/json+nxrequest")
    {

        $this->url = $url;
        $this->username = $username;
        $this->password = $password;
        $this->userSession = $this->username . ":" . $this->password;

        $this->urlLoggedIn = str_replace("http://", "", $url);
        if (strpos($url, 'https') !== false) {
            $this->urlLoggedIn = "https://" . $this->userSession . "@" . $this->urlLoggedIn;
        } elseif (strpos($url, 'http') !== false) {
            $this->urlLoggedIn = "http://" . $this->userSession . "@" . $this->urlLoggedIn;
        } else {
            throw Exception;
        }

        $this->headers = $headers;
    }

    /**
     * newRequest function
     *
     * Create a request from a session
     *
     * @var        $requestType : type of request you want to execute (such as Document.Create
     *               for exemple)
     * @author     Arthur GALLOUIN for NUXEO agallouin@nuxeo.com
     */
    public function newRequest($requestType)
    {
        $newRequest = new NuxeoRequest($this->urlLoggedIn, $requestType, $this->headers);
        return $newRequest;
    }
}
