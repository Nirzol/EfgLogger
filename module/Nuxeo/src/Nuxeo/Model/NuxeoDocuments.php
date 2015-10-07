<?php

namespace Nuxeo\Model;

use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Documents class
 *
 * hold an Array of Document
 *
 * @author     Arthur GALLOUIN for NUXEO agallouin@nuxeo.com
 */
class NuxeoDocuments {

    private $documentsList;

    public function __construct($newDocList) {
        $this->documentsList = null;
        $test = true;
        if (!empty($newDocList['entries'])) {
            while (false !== $test) {
            	if (is_array(current($newDocList['entries']))) {
                    $this->documentsList[] = new NuxeoDocument(current($newDocList['entries']));
            	}
                $test = each($newDocList['entries']);
            }
            $test = sizeof($this->documentsList);
            unset($this->documentsList[$test]);
        } elseif (!empty($newDocList['uid'])) {
            $this->documentsList[] = new NuxeoDocument($newDocList);
        } elseif (is_array($newDocList)) {
            echo 'file not found';
        } else {
            return $newDocList;
        }
    }

    public function output() {
        $value = sizeof($this->documentsList);
        echo '<table>';
        echo '<tr><TH>Entity-type</TH><TH>Repository</TH><TH>uid</TH><TH>Path</TH>
			<TH>Type</TH><TH>State</TH><TH>Title</TH><TH>Download as PDF</TH>';
        for ($test = 0; $test < $value; $test++) {
            echo '<tr>';
            current($this->documentsList)->output();
            echo '<td><form id="test" action="../tests/B5bis.php" method="post" >';
            echo '<input type="hidden" name="a_recup" value="' .
                 current($this->documentsList)->getPath() . '"/>';
            echo '<input type="submit" value="download"/>';
            echo '</form></td></tr>';
            next($this->documentsList);
        }
        echo '</table>';
    }

    public function getDocument($number) {
        $value = sizeof($this->documentsList);
        if ($number < $value AND $number >= 0)
            return $this->documentsList[$number];
        else
            return null;
    }

    public function getDocumentList() {
        return $this->documentsList;
    }
    
    public function objectsToArray () {
        
        $objetcsArray = $this->documentsList;
        $resultArray = array();
        
        $value = sizeof($objetcsArray);
        for ($test = 0; $test < $value; $test++) {
            
            /**
             * @var NuxeoDocument 
             */
            $nuxeoDocument = current($objetcsArray);
            $tmpArray = array();
            
            $hydrator = new ClassMethods(); 
            
            $tmpArray = $hydrator->extract($nuxeoDocument);
            
            $resultArray[] = $tmpArray;
            next($objetcsArray);
        }

        return $resultArray;

    }
}
