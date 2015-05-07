ENT Personnels Paris Descartes
==============================

Introduction
------------

Nouvel ENT pour les perosnnels.

Installation
------------

TODO

Web Server Setup
----------------

### Hosts Setup

sudo vim /etc/hosts  > 127.0.0.1       entpersonnels.zf2

### Apache Setup

To setup apache, setup a virtual host to point to the public/ directory of the
project and you should be ready to go! It should look something like below:

<VirtualHost *:80>
    DocumentRoot "/Users/egrondin/workspace/EntPersonnels/public"
    ServerAdmin eric.grondin@parisdescartes.fr
    ServerName entpersonnels.zf2
    SetEnv APPLICATION_ENV "development"
    ErrorLog "/usr/local/var/log/apache2/entpersonnels.zf2-error_log"
    CustomLog "/usr/local/var/log/apache2/entpersonnels.zf2-access_log" common

    <Directory "/Users/egrondin/workspace/EntPersonnels/public">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted

        RewriteEngine On
        # The following rule tells Apache that if the requested filename
        # exists, simply serve it.
        RewriteCond %{REQUEST_FILENAME} -s [OR]
        RewriteCond %{REQUEST_FILENAME} -l [OR]
        RewriteCond %{REQUEST_FILENAME} -d
        RewriteRule ^.*$ - [NC,L]
        # The following rewrites all other queries to index.php. The 
        # condition ensures that if you are using Apache aliases to do
        # mass virtual hosting, the base path will be prepended to 
        # allow proper resolution of the index.php file; it will work
        # in non-aliased environments as well, providing a safe, one-size 
        # fits all solution.
        RewriteCond %{REQUEST_URI}::$1 ^(/.+)(.+)::\2$
        RewriteRule ^(.*) - [E=BASE:%1]
        RewriteRule ^(.*)$ %{ENV:BASE}index.php [NC,L]
    </Directory>
</VirtualHost>

### PHP CLI Server

NOTE GOOD way.....

The simplest way to get started if you are using PHP 5.4 or above is to start the internal PHP cli-server in the root directory:

    php -S 0.0.0.0:8080 -t public/ public/index.php

This will start the cli-server on port 8080, and bind it to all network
interfaces.

**Note: ** The built-in CLI server is *for development only*.


