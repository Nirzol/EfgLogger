<?php
return array(
    'doctrine' => array(
        'connection' => array(
            // default connection name
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host'     => 'ultrafixe.dsi.univ-paris5.fr',
                    'port'     => '3306',                   
                    'charset' => 'utf8',
                ),
            ),
        ),
//        'sql_logger_collector' => array(
//            'orm_default' => array(
//                'sql_logger' => 'my_sql_logger',
//            ),
//        ),
    ),
);