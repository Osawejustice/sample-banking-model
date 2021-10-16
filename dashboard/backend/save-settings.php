<?php 
// +------------------------------------------------------------------------+
// | @author        : Michael Arawole (Logad Networks)
// | @author_url    : https://logad.net
// | @author_email  : logadscripts@gmail.com
// | @date          : 03 Jul, 2021 08:08PM
// +------------------------------------------------------------------------+
// | Copyright (c) 2021 Logad Networks. All rights reserved.
// +------------------------------------------------------------------------+

// +----------------------------+
// | Site settings module
// +----------------------------+

$post = new stdClass();
foreach ($_POST as $key => $value) {
	if (is_array($value)) {
		$post->$key = $value;
	}
	else {
		$post->$key = $app->clean($value);
	}
}

if (empty($post->save_type)) {
	$errors .= "Save Type not specified\n";
}

if (empty($errors)) {
	$post->files = $_FILES;
	$request = $app->save_site_settings($post);
	if($request['status'] === true) {
		$response['error'] = false;
		$response['msg'] = $request['msg'];
	}
	else {
		$response['msg'] = $request['msg'];
	}
}