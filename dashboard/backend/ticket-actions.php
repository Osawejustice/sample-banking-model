<?php 
// +------------------------------------------------------------------------+
// | @author        : Michael Arawole (Logad Networks)
// | @author_url    : https://logad.net
// | @author_email  : logadscripts@gmail.com
// | @date          : 04 Sep, 2021 02:48PM
// +------------------------------------------------------------------------+
// | Copyright (c) 2021 Logad Networks. All rights reserved.
// +------------------------------------------------------------------------+

// +----------------------------+
// | Ticket actions handler
// +----------------------------+

$post = new stdClass();
foreach ($_POST as $key => $value) {
	if (empty($value)) {
		$errors .= "$key is empty";
	}
	else {
		$post->$key = $app->clean($value);
	}
}

$action = $app->clean($_GET['action']);
if (empty($errors)) {
	$post->user_id = $user_id;
	$request = $app->ticket_actions($post, $action);
	if($request['status'] === true) {
		$response['error'] = false;
		$response['msg'] = $request['msg'];
		if (!empty($request['ticket_id'])) {
			$response['ticket_id'] = $request['ticket_id'];
		}
	}
	else{
		$response['msg'] = $request['msg'];
	}
}