<?php

$baseurl = 'http://a.tile.cloudmade.com/b9b01715d8d0466d844e5ac97e2d4c60/997/256/';

$url = $_SERVER['REQUEST_URI'];

if ( preg_match("#^/tile/19#", $url))
	exit();

$url = preg_replace("#^/tile/#", $baseurl, $url);

error_log($url);

$dest = $_SERVER['DOCUMENT_ROOT'].$_SERVER['REQUEST_URI'];

error_log($dest);
error_log(dirname($dest));

@mkdir(dirname($dest));

file_put_contents($dest, file_get_contents($url));


header('Content-Type: image/png');

readfile($dest);

exit();



?>