<?php
//fix for Opera XMLHttpRequests
if(!count($_POST) && $HTTP_RAW_POST_DATA){
  parse_str($HTTP_RAW_POST_DATA, $_POST);
}

if(!defined('DOKU_INC')) define('DOKU_INC',dirname(__FILE__).'/../../../');
require_once(DOKU_INC.'inc/init.php');
require_once(DOKU_INC.'inc/common.php');
require_once(DOKU_INC.'inc/pageutils.php');
require_once(DOKU_INC.'inc/auth.php');
//close sesseion
session_write_close();
header('Content-Type: text/plain; charset=utf-8');

$text = $_POST['text'];
$id   = $_POST['id'];
$user = $_SERVER['REMOTE_USER'];

$sig = md5($id.$user.trim($text).auth_cookiesalt());

echo '{{',$text,' $$',$sig,'--',$user,'$$}}';
