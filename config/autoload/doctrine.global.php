<?php
return array(
    'doctrine' => array(
        'connection' => array(
            // default connection name
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host'     => '',
                    'port'     => '',
                    'dbname'   => '',
                    'charset' => 'utf8',
                )
            )
        )
    ),
);