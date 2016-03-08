<?php

return array(
    'efglogger' => array(
        'Logger' => array(
            'entityClassName' => '\Ent\Entity\TableLog', //EfgLogger\Entity\TableLog::
            'columnMap' => array(
                'timestamp' => 'log_datetime',
                'priority' => 'log_priority',
                'priorityName' => 'log_priorityName',
                'message' => 'log_message',
                'extra' => array(
                    'log_login' => 'log_login',
                    'log_session' => 'log_session',
                    'log_url' => 'log_url',
                    'log_ip' => 'log_ip',
                    'log_useragent' => 'log_useragent',
                    'log_action' => 'log_action',
                    'log_action_name' => 'log_action_name',
                ),
            ),
        ),
    ),
);
