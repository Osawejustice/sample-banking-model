<?php 
// +------------------------------------------------------------------------+
// | @author        : Michael Arawole (Logad Networks)
// | @author_url    : https://logad.net
// | @author_email  : logadscripts@gmail.com
// | @date          : 27 Jul, 2021 10:04AM
// +------------------------------------------------------------------------+
// | Copyright (c) 2021 Logad Networks. All rights reserved.
// +------------------------------------------------------------------------+

// +----------------------------+
// | Backend Handler
// +----------------------------+

// Require core php file
require dirname(__FILE__,3).'/core/functions.php';

$app->onlyxhr();

// Check if handler is present
if(empty($_GET['handler'])){
    http_response_code(400);
	exit;
}

// Check which file to load
$handler = $app->clean($_GET['handler']);

// User session
if($handler != "login"){
	$app->onlyadmin();
	$user_id = $app->user_session(true);
}

$response['error'] = true;
$response['msg'] = "An error occurred";
$errors = "";

// Force response
function breakResponse() {
	global $response;
	echo json_encode($response);
	exit;
}

// Load the handler file
if(file_exists("./$handler.php")){
	require "./$handler.php";
} else {
	$response['msg'] = "Backend handler not found";
}

if (!empty($errors)) {
	$response['msg'] = $errors;
}

echo json_encode($response);
exit;
