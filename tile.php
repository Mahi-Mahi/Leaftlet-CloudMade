<?php

$host = preg_replace("(.proxy.web-staging.com|.proxy.localhost)", '', $_SERVER['HTTP_HOST']);

$url = 'http://'.$host.$_SERVER['REQUEST_URI'];

error_log($url . ' ( ' . $_SERVER['REMOTE_ADDR'] . ' ) '); 

$ch = curl_init( $url );
  
if ( strtolower($_SERVER['REQUEST_METHOD']) == 'post' ) {
	curl_setopt( $ch, CURLOPT_POST, true );
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $_POST );
}
  
if ( $_GET['send_cookies'] ) {
	$cookie = array();
  foreach ( $_COOKIE as $key => $value ) {
		$cookie[] = $key . '=' . $value;
	}
  if ( $_GET['send_session'] ) {
    $cookie[] = SID;
  }
  $cookie = implode( '; ', $cookie );
    
  curl_setopt( $ch, CURLOPT_COOKIE, $cookie );
}
  
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
curl_setopt( $ch, CURLOPT_HEADER, true );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
  
curl_setopt( $ch, CURLOPT_USERAGENT, $_GET['user_agent'] ? $_GET['user_agent'] : $_SERVER['HTTP_USER_AGENT'] );
  
list( $header, $contents ) = preg_split( '/([\r\n][\r\n])\\1/', curl_exec( $ch ), 2 );
  
$status = curl_getinfo( $ch );
  
curl_close( $ch );

// Propagate headers to response.
foreach ( $header_text as $header ) {
  if ( preg_match( '/^(?:Content-Type|Content-Language|Set-Cookie):/i', $header ) ) {
    header( $header );
  }
}

print $contents;

?>