<?php 
// +------------------------------------------------------------------------+
// | @author        : Michael Arawole (Logad Networks)
// | @author_url    : https://logad.net
// | @author_email  : logadscripts@gmail.com
// | @date          : 15 Oct, 2021 08:50PM
// +------------------------------------------------------------------------+
// | Copyright (c) 2021 Logad Networks. All rights reserved.
// +------------------------------------------------------------------------+

// +----------------------------+
// | Login Handler
// +----------------------------+

$post = new stdClass();
foreach ($_POST as $key => $value) {
	$post->$key = $app->clean($value);
}

## Account Number ##
if (empty($post->account_number) || !is_numeric($post->account_number)) {
	$errors .= "Account number is required and must be digits";
}

## Password ##
if (empty($post->password)) {
	$errors .= "Password is required\n";
}

if (empty($errors)) {
	$request = $app->user_login($post);
	if ($request['status'] === true) {
		$response['error'] = false;
		$response['url'] = "./";
		$response['msg'] = $request['msg'];
	}
	else {
		$response['msg'] = $request['msg'];
	}
}