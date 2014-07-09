<?php

if( !defined('DS') ) define( 'DS' , DIRECTORY_SEPARATOR );

define( 'CROOT' , WROOT . 'core' . DS  );

// define 
error_reporting(E_ALL^E_NOTICE);
ini_set( 'display_errors' , true );

include_once( WROOT . 'config' . DS . 'db.config.php' );
include_once( CROOT . 'medoo.php' );

//lib Class include
$lib_path = WROOT . 'lib' . DS . 'class' . DS . '*.class.php';
$lib_class = glob($lib_path);
foreach ( $lib_class as $file_name ) {
  @include_once( $file_name );
}

//lib function include
@include_once( WROOT . 'lib' . DS . 'function' . DS . 'app.php' );

//
function transcribe($aList, $aIsTopLevel = true) 
{
   $gpcList = array();
   $isMagic = get_magic_quotes_gpc();
  
   foreach ($aList as $key => $value) {
       if (is_array($value)) {
           $decodedKey = ($isMagic && !$aIsTopLevel)?stripslashes($key):$key;
           $decodedValue = transcribe($value, false);
       } else {
           $decodedKey = stripslashes($key);
           $decodedValue = ($isMagic)?stripslashes($value):$value;
       }
       $gpcList[$decodedKey] = $decodedValue;
   }
   return $gpcList;
}
//
function get( $str )
{
	$_GET = transcribe( $_GET );
	return isset( $_GET[$str] ) ? $_GET[$str] : false;
}

$c = get('c') ? get('c') : 'index'; //$GLOBALS['c'] = v('c') ? v('c') : c('default_controller');
$a = get('a') ? get('a') : 'index'; //$GLOBALS['a'] = v('a') ? v('a') : c('default_action');

$c = basename(strtolower( $c ));
$a =  basename(strtolower( $a ));

$post_fix = '.class.php';

$cont_file = WROOT . 'controller'  . DS . $c . $post_fix;
$class_name = $c .'Controller' ; 

//include model
$model_file = WROOT . 'model'  . DS . $c . '.model.php';
@include_once( $model_file );

//include controller
if( !file_exists( $cont_file ) )
{
	$cont_file = CROOT . 'controller' . DS . $c . $post_fix;
	if( !file_exists( $cont_file ) ) die('Can\'t find controller file - ' . $c . $post_fix );
}


require_once( $cont_file );
if( !class_exists( $class_name ) ) die('Can\'t find class - '   .  $class_name );

$o = new $class_name;
if( !method_exists( $o , $a ) ) die('Can\'t find method - '   . $a . ' ');


//if(strpos('gzip',$_SERVER['HTTP_ACCEPT_ENCODING']) !== FALSE)  ob_start("ob_gzhandler");
call_user_func( array( $o , $a ) );

