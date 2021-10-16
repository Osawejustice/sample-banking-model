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
// | Live notifications
// +----------------------------+

$post = new stdClass();
foreach ($_POST as $key => $value) {
	$post->$key = $app->clean($value);
}

if (empty($errors)) {
	$post->user_id = $user_id;
	$notifications = array();
	foreach ($app->pos_notifications("not-displayed") as $notification) {
		$notificationMsg = "New POS transaction\nTerminal ID : $notification->terminal_id\nAmount : {$coin}".$app->format($notification->amount);
		$notifications[] = nl2br($notificationMsg);
		// set the notification as displayed
		$app->mark_notification($notification->id, "pos_notifications");
	}
	
	$response['error'] = false;
	$response['notifications'] = $notifications;
	$response['msg'] = "Success";
}