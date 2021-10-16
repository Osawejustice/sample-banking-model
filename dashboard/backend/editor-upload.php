<?php 
// +------------------------------------------------------------------------+
// | @author        : Michael Arawole (Logad Networks)
// | @author_url    : https://logad.net
// | @author_email  : logadscripts@gmail.com
// | @date          : 07 Oct, 2021 04:07PM
// +------------------------------------------------------------------------+
// | Copyright (c) 2021 Logad Networks. All rights reserved.
// +------------------------------------------------------------------------+

// +----------------------------+
// | Editor actions Handler
// +----------------------------+

$post = new stdClass();
foreach ($_POST as $key => $value) {
	$post->$key = $app->clean($value);
}

if (empty($_FILES['file']['name'])) {
	$errors .= "No file was uploaded";
}

if (empty($errors)) {
	$file = $_FILES['file'];
	$request = $app->upload_image($file);
	if($request['status'] === true){
		$response['error'] = false;
		$response['url'] = $siteurl."/".$request['path'];
		$response['msg'] = $request['msg'];
	}
	else{
		$response['msg'] = $request['msg'];
	}
}