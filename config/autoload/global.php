<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    
    // Version de l'ENT
    'versions' => array(
        'version' => '0.0.1-alpha1',
        // Dependances de versions : base de donnees et application Angular
        'dependencies' => array (
            'data-base-version' =>'0.0.1-dev',
            'app-angular-version' => '0.0.1-alpha1', 
        ),
    ),
    
    'user-add-base' => array(
        'role_default_id' => 3,
        'status_default_id' => 1,
        'profile_default_id' => 7,
        'student_redirect_url' => 'http://ent-ng.parisdescartes.fr',
    ),
    
    'preference_config' => array(
        'default_status' => 1,
    ),
    
//    'service_manager' => array(
//        'factories' => array(
//            'my_sql_logger' => function($sm) {
//                $log = new \Zend\Log\Logger();
//                $writer = new \Zend\Log\Writer\Stream('./data/logs/sql.log');
//                $log->addWriter($writer);
//
//                $sqllog = new \Ent\Log\SqlLogger($log);
//                return $sqllog;
//            },
//        )
//    ),
    
);
