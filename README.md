EfgLogger
===============

This module implements Doctrine log writer with Zend\log component.
This is my first module so help to improve it ! :-)
http://gamers.re/technologie/zend-framework-2/zend-framework-2-zendlog-et-doctrine/

Installation and Use:
---------------------
Copy efglogger.global.php.dist into your config\autoload.
Copy Entity\TableLog.php into you Entity Folder and launch your doctrine comand to create table  with the required columns.
They are 'extra' columns used in this module like: 'log_login', 'log_session', 'log_url', 'log_ip', 'log_useragent', 'log_action', 'log_action_name',

 - Note that in this module, the url, ip, useragent and session ID fields are injected in the onBootstrap event in Module.php. 
The others fields are added in your controller (i.e. when you use it).

