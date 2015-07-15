<?php

/**
 * Description of RequestConfig
 * 
 * L'ensemble des requetes NXQL a executer
 * 
 * @author sebbar
 */

namespace Nuxeo\Controller;

class NXQLRequestConfig {
    private $nxqlGeneric = "SELECT * FROM Document WHERE ecm:mixinType != 'HiddenInNavigation' AND ecm:isProxy = 0 AND ecm:isCheckedInVersion = 0 AND ecm:currentLifeCycleState != 'deleted'";
    
    private $nxqlClause = array(
        "contributor"           => " AND dc:contributors = ?",
        'descartes_file_note'   => " AND ecm:primaryType IN ('DescartesFile', 'DescartesNote')",
        'folder'                => " AND ecm:primaryType = 'Folder'",
        'file_note'             => " AND ecm:primaryType IN ('File', 'Note')",
        "ancestor"              => " AND ecm:ancestorId = ?",
        "path"                  => " AND ecm:path STARTSWITH '?'",
        "metatag"               => " AND ecm:tag/* = ?",
        'permission'            => " AND ecm:acl/*/permission"
    );
    
    private $nxqlOrder = array(
        "modified"      => " ORDER BY dc:modified",
        'title'         => " ORDER BY dc:title",
    );
    
    /**
     * 
     * @param type $author
     * @return string : les documents de l' $author avec les droits d'ecriture
     */
    public function requestForDocumentsOfAutor($author, $path=NULL) {

        $request = null;
        if( isset($author)) {
            
            // generic request
            $request = $this->nxqlGeneric;

            // File an Note
//            $request = $request . $this->nxqlClause['descartes_file_note'];
            $request = $request . $this->nxqlClause['file_note'];

            // Path
            if ( $path !== NULL) {
                $request = $request . str_replace("?", $path, $this->nxqlClause['path']);
            }
            
            // Author
            $request = $request . str_replace("?", "'" . $author . "'", $this->nxqlClause['contributor']);
            
            // Order 
            $request = $request . $this->nxqlOrder["modified"];

        }

        return $request;
    }
    
      /**
     * 
     * @param type $author
     * @return string : les documents de l' $author avec les droits d'ecriture
     */
    public function requestForDocumentsInPath($path) {

        $request = null;
        if( isset($path)) {
            
            // generic request
            $request = $this->nxqlGeneric;

            // File an Note
            $request = $request . $this->nxqlClause['descartes_file_note'];

            // Path
            $request = $request . str_replace("?", $path, $this->nxqlClause['contributor']);
            
            // Order 
            $request = $request . $this->nxqlOrder["modified"];

        }

        return $request;
    }
    
    
    
    
}
