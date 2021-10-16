<?php 
// +------------------------------------------------------------------------+
// | @author        : Michael Arawole (Logad Networks)
// | @author_url    : https://logad.net
// | @author_email  : logadscripts@gmail.com
// | @date          : 09 Sep, 2021 07:24PM
// +------------------------------------------------------------------------+
// | Copyright (c) 2021 Logad Networks. All rights reserved.
// +------------------------------------------------------------------------+

// +----------------------------+
// | update profile module
// +----------------------------+

$post = new stdClass();
foreach ($_POST as $key => $value) {
	$post->$key = $app->clean($value);
}

if (empty($post->save_type)) {
	$errors .= "Save Type not specified\n";
}

if (empty($errors)) {
	$post->files = $_FILES;
	$post->user_id = $user_id;
	$request = $app->staffActions($post, "profile");
	if($request['status'] === true) {
		$response['error'] = false;
		$response['msg'] = $request['msg'];
	}
	else{
		$response['msg'] = $request['msg'];
	}
}