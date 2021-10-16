<?php 
// +------------------------------------------------------------------------+
// | @author        : Michael Arawole (Logad Networks)
// | @author_url    : https://logad.net
// | @author_email  : logadscripts@gmail.com
// | @date          : 04 Sep, 2021 02:46PM
// +------------------------------------------------------------------------+
// | Copyright (c) 2021 Logad Networks. All rights reserved.
// +------------------------------------------------------------------------+

// +----------------------------+
// | Rights actions Handler
// +----------------------------+

$post = new stdClass();
foreach ($_POST as $key => $value) {
	// $post->$key = $app->clean($value);
	$post->$key = $value;
}

$action = $app->clean($_GET['action']);
if ($action == "edit" || $action == "delete") {
	if (empty($post->item_id)) {
		$errors .= "Role ID is not defined";
	}
}
if ($action == "add") {
	if (empty($post->title) || empty($post->description)) {
		$errors .= "Title and description are required";
	}
}

if (empty($errors)) {
	if ($action == "fetch") {
		$html = '<div class="form-group"><label>Select Role</label><select id="RL_ID" class="form-control"><option value="">Select</option>';
	    foreach ($app->site_roles() as $right) {
	        $html .= '<option value="'.$app->encrypt($right->id).'">'.$right->title.'</option>';
	    }
	    $html .= "</select></div>";
	    $response['error'] = false;
	    $response['html'] = $html;
	    $response['msg'] = "Success";
	}
	else {
		$request = $app->rights_actions($action,$post);
		if($request['status'] === true){
			$response['error'] = false;
			$response['msg'] = $request['msg'];
		}
		else{
			$response['msg'] = $request['msg'];
		}
	}
}