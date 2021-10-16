<?php 
// +------------------------------------------------------------------------+
// | @author        : Michael Arawole (Logad Networks)
// | @author_url    : https://logad.net
// | @author_email  : logadscripts@gmail.com
// | @date          : 07 Aug, 2021 02:28PM
// +------------------------------------------------------------------------+
// | Copyright (c) 2021 Logad Networks. All rights reserved.
// +------------------------------------------------------------------------+

// +----------------------------+
// | POS actions handler
// +----------------------------+

$post = new stdClass();
foreach ($_POST as $key => $value) {
	if (empty($value)) {
		$errors .= "$key is empty";
	} else {
		$post->$key = $app->clean($value);
	}
}
$action = $app->clean($_GET['action']);

if (empty($errors)) {

	if ($action == "demo_hook") {
		// send demo webhook notification
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => "$siteurl/webhook/",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>'{
		    "MTI": "0200",
		    "amount": "'.$post->amount.'",
		    "terminalId": "'.$post->terminal_id.'",
		    "responseCode": "00",
		    "responseDescription": "Approved",
		    "PAN": "437762XXXXXX8090",
		    "STAN": "070246",
		    "authCode": "447098",
		    "transactionTime": "'.date('c').'",
		    "reversal": false,
		    "merchantId": "FBP579036356841",
		    "merchantName": "ITEX INTEGRATED SERVICES",
		    "merchantAddress": "LA  LANG",
		    "rrn": "'.$app->GenerateKey(12,12,false, false).'"
		}',
		CURLOPT_SSL_VERIFYHOST => false,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_HTTPHEADER => array(
		    'Authorization: DEl0NA6/ihvQdeu+LRCVyh48DUYx'
		  ),
		));
		$request = json_decode(curl_exec($curl), true);
		curl_close($curl);
		if (!empty($request['status']) && $request['status'] == true) {
			$response['error'] = false;
			$response['msg'] = "Notification sent successfully";
		} else {
			$response['msg'] = (!empty($request['msg'])) ? $request['msg'] : "An error occurred";
		}
	}
	
	elseif ($action == "request-details") {
		if (empty($post->req_id)) {
			$response['msg'] = "Request ID not defined";
			breakResponse();
		}
		$request = $app->pos_requests($app->decrypt($post->req_id));
		if (empty($request)) {
			$response['msg'] = "Invalid request ID";
			breakResponse();
		}

		$luser = $app->user($request->user_id);
		$pos_type = (!empty($app->posTypes($request->pos_type))) ? $app->posTypes($request->pos_type)->name : null;
		if($request->status == 2) {
			$status = '<span class="badge badge-warning">Pending</span>';
		} elseif($request->status == 0) {
			$status = '<span class="badge badge-danger">Declined</span>';
		} elseif($request->status == 1) {
			$status = '<span class="badge badge-success">Approved</span>';
		}

		// shop picutres
		$shop_pictures = "";
		$pics = explode(";", $request->shop_pictures);
		foreach ($pics as $pic) {
			$shop_pictures .= "<img src='$siteurl/$pic' class='modal-img'/><hr>";
		}
		$reason = null;
		if ($request->status == 0) {
			$reason = <<< HEREDOC
			<dt>Decline Reason</dt>
			<dd>{$request->decline_reason}</dd>
			HEREDOC;
		}

		$html = <<< HEREDOC
		<dt>Requested by</dt>
		<dd>{$luser->name} ({$luser->email})</dd>
		<dt>Aggregator Code</dt>
		<dd>{$request->agg_code}</dd>
		<dt>Name</dt>
		<dd>{$request->name}</dd>
		<dt>Phone</dt>
		<dd>{$request->phone}</dd>
		<dt>Delivery Address</dt>
		<dd>{$request->delivery_address}</dd>
		<dt>POS Type</dt>
		<dd>{$pos_type}</dd>
		<dt>Status</dt>
		<dd>{$status}</dd>
		{$reason}
		<dt>Account Statement</dt>
		<dd><a href="{$siteurl}/{$request->account_statement}" target="_blank">Open File</a></dd>
		<dt>Shop Pictures</dt>
		<dd>{$shop_pictures}</dd>
		HEREDOC;

		$response['msg'] = "success";
		$response['error'] = false;
		$response['title'] = "POS Request RQ".sprintf("%'03d", $request->id)." details";
		$response['html'] = $html;

	} else {
		$post->files = $_FILES;
		$post->user_id = $user_id;
		$request = $app->pos_actions($post, $action);
		if ($request['status'] == true) {
			$response['error'] = false;
			$response['msg'] = $request['msg'];
			if (!empty($request['log'])) {
				$response['log'] = $request['log'];
			}
		} else {
			$response['msg'] = $request['msg'];
		}
	}
}