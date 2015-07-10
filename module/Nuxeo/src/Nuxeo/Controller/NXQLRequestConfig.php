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
    
    public function requestForDocumentsOfAutor($author) {

        $request = null;
        if( isset($author)) {
            
            // generic request
            $request = $this->nxqlGeneric;

            // File an Note
            $request = $request . $this->nxqlClause['descartes_file_note'];

            // Author
            $request = $request . str_replace($this->nxqlClause['contributor'], "?", $author);
            
            // Order 
            $request = $request . $this->nxqlOrder["modified"];

        }

        return $request;
    }
}
