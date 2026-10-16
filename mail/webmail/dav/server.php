<?php

/*
 * Copyright 2004-2017, AfterLogic Corp.
 * Licensed under AGPLv3 license or AfterLogic license
 * if commercial version of the product was purchased.
 * See the LICENSE file for a full license statement.
 */

$sCurrentFile = \basename(__FILE__);
$sRequestUri = empty($_SERVER['REQUEST_URI']) ? '' : \trim($_SERVER['REQUEST_URI']);


require_once \dirname(__FILE__).'/../libraries/afterlogic/api.php';

\set_time_limit(3000);
\set_error_handler(function ($errno, $errstr, $errfile, $errline) {
	throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
});

// CApi::$bUseDbLog = false;

$sBaseUri = false === \strpos($sRequestUri, 'dav/'.$sCurrentFile) ? '/' :
	\substr($sRequestUri, 0, \strpos($sRequestUri,'/'.$sCurrentFile)).'/'.$sCurrentFile.'/';

$server = \afterlogic\DAV\Server::NewInstance($sBaseUri);
$server->exec();
