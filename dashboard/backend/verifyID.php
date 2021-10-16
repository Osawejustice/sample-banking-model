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
// | Indentity Verification
// +----------------------------+

$post = new stdClass();
foreach ($_POST as $key => $value) {
	$post->$key = $app->clean($value);
}

if (empty($post->identity_document)) {
	$errors .= "Identity document type not defined";
}
else {
	// NIN
	if ($post->identity_document == "national_id") {
		if (empty($post->ninNumber)) {
			$errors .= "NIN Number is required";
		} else {
			$post->vType = "nin";
			$post->vNum = $post->ninNumber;
		}
	}
	// Dirvers license
	if ($post->identity_document == "drivers_license") {
		if (empty($post->driversLicenseNumber)) {
			$errors .= "Drivers License Number is required";
		} else {
   		$post->vType = "driversLicense";
			$post->vNum = $post->driversLicenseNumber;
		}
	}
	// Voters card
	if ($post->identity_document == "voters_card") {
		if (empty($post->votersCardNumber)) {
			$errors .= "Voters Card Number is required";
		} else {
   		$post->vType = "votersCard";
			$post->vNum = $post->votersCardNumber;
		}
	}
}

$post->thirdparty = false;
if (!empty($_GET['thirdparty'])) {
	$post->thirdparty = true;
}

if (empty($errors)) {
	$post->files = $_FILES;
	if (!$post->thirdparty) {
		$post->user_id = $user_id;
	} else {
		$post->staff_id = $user_id;
	}
	$request = $app->verifyUserIdentity($post);
	if($request['status'] === true) {
		$response['error'] = false;
		$response['msg'] = $request['msg'];
	}
	else{
		$response['msg'] = nl2br($request['msg']);
	}
}