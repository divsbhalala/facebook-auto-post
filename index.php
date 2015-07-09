<?php
session_start();
ini_set("display_errors", "1");
error_reporting(E_ALL);
require_once('facebookapi/facebook.php');

// configuration

 $appid = 'app-id';
 $appsecret = 'spp-seceret';
 $pageId = '418234554858781';
 $msg = 'Automatically post to Facebook from Your Website';
 $title = 'Automatically post to Facebook from Your Website';
 $uri = 'http://magicwallpost.com';
 $desc = 'Thsting auto post by divyesh';
 $pic = 'http://blog.phpinfinite.com/wp-content/uploads/2012/11/post_to_facebook_from_php.jpg';
 $action_name = 'Go to MagicWallPost';
 $action_link = 'http://magicwallpost.com';

$facebook = new Facebook(array(
 'appId' => $appid,
 'secret' => $appsecret,
 'cookie' => false,
 ));

$user = $facebook->getUser();
print_r($user);//;exit;
// Contact Facebook and get token
 if ($user) {
 // you're logged in, and we'll get user acces token for posting on the wall
 try {
 $page_info = $facebook->api("/$pageId?fields=access_token");
 print_r($page_info);//exit;
 if (!empty($page_info['access_token'])) {
 $attachment = array(
 'access_token' => $page_info['access_token'],
 'message' => $msg,
 'name' => $title,
 'link' => $uri,
 'description' => $desc,
 'picture'=>$pic,
 'actions' => json_encode(array('name' => $action_name,'link' => $action_link))
 );

$status = $facebook->api("/$pageId/feed", "post", $attachment);
 } else {
 $status = 'No access token recieved';
 }
 } catch (FacebookApiException $e) {
 error_log($e);
 $user = null;
 }
 } else {
 // you're not logged in, the application will try to log in to get a access token
 header("Location:{$facebook->getLoginUrl(array('scope' => 'publish_actions,user_status,user_photos,manage_pages'))}");
 }

echo $status;
 ?>
