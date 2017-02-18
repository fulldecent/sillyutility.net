<?php
namespace SillyUtility;
require 'sources/autoload.php';
require 'vendor/autoload.php';

//https://allseeing-i.com/how-to-setup-your-php-site-to-use-utf8
//setup php for working with Unicode data
mb_internal_encoding('UTF-8');
mb_http_output('UTF-8');
mb_http_input('UTF-8');
mb_language('uni');
mb_regex_encoding('UTF-8');
ob_start('mb_output_handler');

$database = new \ThinPdo\Db('mysql:host=127.0.0.1;dbname=sillyuti_main', 'sillyuti_main', '2hu2u9h9*H#98h');
function dbError($errorObject){
	header('Content-type: application/json');
	header('HTTP/1.0 500 Internal Server Error', true, 500);
  echo json_encode(array("status"=>"error", "info"=>$errorObject));
  die();
}
$database->setErrorCallbackFunction("\SillyUtility\dbError", "text");

function fatalUserError($msg) {
  $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');  
	header('Content-type: application/json');
  header($protocol . ' 400 Bad Request', true, 400);
  echo json_encode(array("status"=>"error", "info"=>$msg));
  die();
}

// https://stackoverflow.com/questions/2040240/php-function-to-generate-v4-uuid
function gen_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

        // 16 bits for "time_mid"
        mt_rand( 0, 0xffff ),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand( 0, 0x0fff ) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand( 0, 0x3fff ) | 0x8000,

        // 48 bits for "node"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
}