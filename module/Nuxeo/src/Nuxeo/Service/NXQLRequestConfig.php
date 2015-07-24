<?php

/**
 * Description of RequestConfig
 * 
 * L'ensemble des requetes NXQL a executer
 * 
 * @author sebbar
 */

namespace Nuxeo\Service;

class NXQLRequestConfig {
    private $nxqlGeneric = "SELECT * FROM Document WHERE ecm:mixinType != 'HiddenInNavigation' AND ecm:isProxy = 0 AND ecm:isCheckedInVersion = 0 AND ecm:currentLifeCycleState != 'deleted'";
    
//    private $authorizedKeys = array( "type", "contributor", "ancestor", "path", "tag", 'permission');
    
    private $nxqlClause = array(
        'descartes_file_note'   => " AND ecm:primaryType IN ('DescartesFile', 'DescartesNote')",
        'folder'                => " AND ecm:primaryType = 'Folder'",
        'file_note'             => " AND ecm:primaryType IN ('File', 'Note')",
        "contributor"           => " AND dc:contributors = ?",
        "path"                  => " AND ecm:path STARTSWITH '?'",
        "ancestor"              => " AND ecm:ancestorId = ?",
        "tag"                   => " AND ecm:tag/* = ?",
        'permission'            => " AND ecm:acl/*/permission"
    );
    
    private $nxqlOrder = array(
        "modified"      => " ORDER BY dc:modified",
        'title'         => " ORDER BY dc:title",
    );
    
    public function getRequest($paramArray) {
        
        $nxqlQuery = NULL;
        
        if ( !is_null($paramArray) && (count($paramArray) > 0)) {
            
            // Requete generique
            $nxqlQuery = $this->nxqlGeneric;
            
            foreach ($paramArray as $key => $value) {
                
                switch ($key) {
                    case  "type":
                        // $keys["type"] = "file_note", "decarte_file_note" or "folder"
                        $nxqlQuery = $nxqlQuery . $this->nxqlClause[$value];
                        break;
                    
                    case "author":
                    case "path":
                    case "ancestor":
                    case "tag":
                        $nxqlQuery = $nxqlQuery . str_replace("?", "'" . $value . "'", $this->nxqlClause[key]);
                        break;
                    
                    default:
                        break;
                }
            }
            // Order by date modified
            $nxqlQuery = $nxqlQuery . $this->nxqlOrder["modified"];

        }
    }
    
    /**
     * 
     * @param type $author
     * @param type $path
     * @param type $tag
     * @param type $ancestor
     * @return string : 
     *          la requete NXQL des documents pour :
     *                  $author, $path exclusive $ancestor, meta tag $tag
     */
    public function getDocumentsRequest($author, $path=NULL, $tag=NULL, $ancestor=NULL) {

        $paramArray = array();
        
        if( isset($author)) {
            $paramArray["contributor"] = $author;
        }
        
        // "path" est exclusive a "ancestor" (soit l'un soit l'autre)
        if ( isset($path) && ($path !== NULL)) {
            $paramArray["path"] = $path;
        } elseif (isset ($ancestor)) {
            $paramArray["ancestor"] = $ancestor;
        }
        
        if( isset($tag)) {
            $paramArray["tag"] = $tag;
        }

        return $this->getRequest($paramArray);
    }

    /**
     * 
     * @param type $path
     * @param type $ancestor
     * @return type String :
     *      La requete pour les Foldes dans un pere ou-exclusive un ancetre 
     */
    public function getFoldersRequest($path, $ancestor=NULL) {

        $paramArray = array();

        if( isset($path) && $path !== NULL) {
            $paramArray["path"] = $path;
        } elseif (isset($ancestor) && $ancestor !== NULL) {
            $paramArray["path"] = $path;
        }
        
        return $this->getRequest($paramArray);
    }
    
    
}
