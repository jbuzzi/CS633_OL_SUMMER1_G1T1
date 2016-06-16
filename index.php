<?php

// Kickstart the framework
$f3 = require('lib/base.php');

$f3->set('DEBUG',1);
if ((float)PCRE_VERSION<7.9)
    trigger_error('PCRE version is out of date');

// Load routes
$f3->config('routes.ini');
// Load configuration
$f3->config('config.ini');

new Session();

$f3->run();
