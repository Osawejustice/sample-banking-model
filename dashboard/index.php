<?php 
// +------------------------------------------------------------------------+
// | @author        : Michael Arawole (Logad Networks)
// | @author_url    : https://logad.net
// | @author_email  : logadscripts@gmail.com
// | @date          : 11 Oct, 2021 06:27PM
// +------------------------------------------------------------------------+
// | Copyright (c) 2021 Logad Networks. All rights reserved.
// +------------------------------------------------------------------------+

// Require core php file
require dirname(__FILE__,2).'/core/functions.php';

// Check login session
$app->onlyauth(true);
$baseurl = $siteurl."/dashboard";
$user_id = $app->user_session(false);
$user = $app->user($user_id);

function redirect($path = null) {
	header("Location: $baseurl/$path");
	exit;
}
// $dStats = $app->dashboardStats(); 

if(!empty($_GET['page'])) {
	$pager = strtolower($app->clean($_GET['page']));
	switch ($pager) {
		case "transfer":
			$page = "Transfer";
			$file = "transfer";
			$sub = $app->clean($_GET['subpage']);
			if (!in_array($sub, array('same', 'local', 'intl'))) {
				redirect();
			}
			break;
		case "statement":
			$page = "Account Statement";
			$file = "statement";
			break;
		case "loans":
			$page = "Loan History";
			$file = "loans";
			if (!empty($_GET['subpage'])) {
				if ($_GET['subpage'] == "apply") {
					$page = "Apply for loan";
					$file = "apply-loan";
				}
			}
			break;
		case "deposit":
			$page = "Deposit";
			$file = "deposit";
			break;
			
		case "all_activities":
			$page = "All Activities";
			$file = "activities";
			break;
		case "transactions":
			$page = "All Transactions";
			$file = "transactions";
			if (!empty($_GET['subpage'])) {
				$sub = $app->clean($_GET['subpage']);
				$page = ucfirst($sub)." Transactions";
			}
			break;
		case "settings":
			$page = "Site Settings";
			$file = "settings";
			$sub = null;
			if (!empty($_GET['subpage'])) {
				$sub = $app->clean($_GET['subpage']);
			}
			break;
		case "profile":
			$page = "My Profile";
			$file = "profile";
			$sub = null;
			if (!empty($_GET['subpage'])) {
				$sub = $app->clean($_GET['subpage']);
			}
			break;
		case "agents":
			$page = "All Agents";
			$file = "staff";
			$user_type = "agent";
			if (!empty($_GET['subpage'])) {
				if ($_GET['subpage'] == "add") {
					$page = "Add Agent";
					$file = "add-staff";
				} else {
					$luser = $app->user($app->clean($_GET['subpage']));
					if (empty($luser)) {
						header("Location: $baseurl/agents");
						exit;
					}
					$page = "View Agent - $luser->name";
					$file = "view-staff";
					$edit = (!empty($_GET['edit'])) ? true : false;
					if ($edit) {
						$page = "Edit Agent : $luser->name";
						$file = "add-staff";
					}
				}
			}
			break;
		case "aggregators":
			$page = "All Aggregators";
			$file = "staff";
			$user_type = "aggregator";
			if (!empty($_GET['subpage'])) {
				if ($_GET['subpage'] == "add") {
					$page = "Add Aggregator";
					$file = "add-staff";
				} else {
					$luser = $app->user($app->clean($_GET['subpage']), "uid");
					if (empty($luser)) {
						header("Location: $baseurl/aggregators");
						exit;
					}
					$page = "View Aggregator - $luser->name";
					$file = "view-staff";
					$edit = (!empty($_GET['edit'])) ? true : false;
					if ($edit) {
						$page = "Edit Aggregator : $luser->name";
						$file = "add-staff";
					}
				}
			}
			break;
		case "all_pos":
			$page = "All POS";
			$file = "all-pos";
			if (!empty($_GET['subpage'])) {
				if ($_GET['subpage'] == "add") {
					$page = "Add POS";
					$file = "add-pos";
				} else {
					$pos = $app->all_pos($app->clean($_GET['subpage']));
					if (empty($pos)) {
						header("Location: $baseurl/all_pos");
						exit;
					}
					$page = "View POS";
					$file = "view-pos";
					$edit = (!empty($_GET['edit'])) ? true : false;
					if ($edit) {
						$page = "Edit POS";
						$file = "add-pos";
					}
				}
			}
			break;
		case "pos_types":
			$page = "POS Types";
			$file = "pos-types";
			if (!empty($_GET['subpage'])) {
				$file = "add-pos-type";
				if ($_GET['subpage'] == "add") {
					$page = "Add POS Type";
				} else {
					$pType = $app->posTypes($app->clean($_GET['subpage']));
					if (empty($pType)) {
						header("Location: $baseurl/pos_types");
						exit;
					}
					$page = "Edit POS Type : $pType->name";
				}
			}
			break;
		case "request_pos":
			$page = "Request POS";
			$file = "request-pos";
			break;
		case "request_bulk_pos":
			$page = "Request Bulk POS";
			$file = "request-pos-bulk";
			break;
		case "pos_requests":
			$page = "POS Requests";
			$file = "pos-requests";
			break;

		// Mobile //
		case "plugins":
			$page = "Added Plugins";
			$file = "plugins";
			break;
		case "all_staff":
			$page = "All Staff";
			$file = "users";
			if (!empty($_GET['subpage'])) {
				if (empty($_GET['byType'])) {
					$luser = $app->user($app->clean($_GET['subpage']), "uid");
					if (empty($luser) || $luser->type != "admin") {
						header("Location: $baseurl/all_staff");
						exit;
					}
					$page = $luser->name." [$luser->uid]";
					$file = "add-staff";
					$edit = (!empty($_GET['edit'])) ? true : false;
					if (!empty($_GET['edit'])) {
						$page = "Edit Staff : $luser->name";
					}
				}
				else {
					$user_cat = $app->staff_types(str_replace("CA0", null, $app->clean($_GET['subpage'])));
					if (empty($user_cat)) {
						header("Location: $baseurl/staff_types");
						exit;
					}
					$page = $user_cat->name;
				}
			}
			break;
		case "add_staff":
			$page = "Add Staff";
			$file = "add-staff";
			break;
		case "staff_types":
			$page = "Staff Types";
			$file = "staff-types";
			if (!empty($_GET['subpage'])) {
				$item = $app->staff_types($app->clean($_GET['subpage']));
				if (empty($item)) {
					header("Location: $baseurl/");
					exit;
				}
				$file = "add-staff-type";
			}
			break;
		case "add_staff_type":
			$page = "Add Staff Type";
			$file = "add-staff-type";
			break;

		case "all_users":
			$page = "All Users";
			$file = "users";
			// category
			$category = null;
			if (!empty($_GET['category'])) {
				$category = $app->clean($_GET['category']);
			}
			if (!empty($_GET['subpage'])) {
				$luser = $app->user($app->clean($_GET['subpage']), "uid");
				if (empty($luser) || $luser->type != "user") {
					header("Location: $baseurl/all_users");
					exit;
				}
				$page = $luser->name." [$luser->uid]";
				$edit = (!empty($_GET['edit'])) ? true : false;
				if (!empty($_GET['edit'])) {
					$file = "add-user";
					$page = "Edit User : $luser->name";
				}
				else {
					$file = "viewAsUser";
				}
			}
			break;
		case "add_user":
			$page = "Add User";
			$file = "add-user";
			break;

		case "services":
			$page = "Services";
			$file = "services";

			if (!empty($_GET['subpage'])) {
				$sub = $app->clean($_GET['subpage']);
				$service = $app->allServices($sub);
				if (empty($service)) redirect();

				$edit = (empty($_GET['edit'])) ? true : false;
				$page = "Service - $service->name";
				$file = "single-service";
			}
			break;
		case "transaction":
			$file = "single-transaction";
			if (empty($_GET['subpage'])) redirect();
			$trans_id = $app->clean($_GET['subpage']);
			$transaction = $app->transactions($trans_id, "trans_id");
			if (empty($transaction)) redirect();
			$luser = $app->user($transaction->user_id);

			if (!empty($transaction->trxRef)) {
				$reference = $app->reference_details($transaction->trxRef);
			}
			$page = "Transaction #$trans_id";
			break;
		case "payment_reference":
			$page = "Payment Reference";
			$file = "payment-reference";
			break;

		case "my_agents":
			$page = "My Agents";
			$file = "my-agents";
			if (!empty($_GET['subpage'])) {
				$sub = $app->clean($_GET['subpage']);
				$luser = $app->user($sub, "uid");
				if (empty($luser)) redirect();
				$page = "Agent - $luser->name";
			}
			break;

		case "support":
			$page = "Support";
			$file = "support";
			if (!empty($_GET['subpage'])) {
				$sub = $app->clean($_GET['subpage']);
				$ticket = $app->all_tickets($sub, "ticket_id");
				if (empty($ticket[0])) redirect();
				$ticket = $ticket[0];
				if ($ticket->user_id != $user->id) redirect();
				$page = "Ticket #$ticket->ticket_id";
			}
			break;

		case "tickets":
			$page = "Tickets";
			$file = "tickets";
			if (!empty($_GET['subpage'])) {
				$file = "support";
				$sub = $app->clean($_GET['subpage']);
				$ticket = $app->all_tickets($sub, "ticket_id");
				if (empty($ticket[0])) redirect();
				$ticket = $ticket[0];
				$page = "Ticket #$ticket->ticket_id";
			}
			break;
		case "support_departments":
			$page = "Support Departments";
			$file = "support-departments";
			if (!empty($_GET['subpage'])) {
				$sub = $app->clean($_GET['subpage']);
				$file = "add-department";
				if ($sub == "add") {
					$page = "Add Support Department";
				} else {
					$page = "Edit Support Department";
					$item = $app->support_departments($sub);
				}
			}
			break;
	}
}
else {
	$page = "Home";
	$file = "index";
}
if(empty($page) || empty($file) || !file_exists("layout/$file.php")){
	$page = "404 - Page not found";
	$file = "404";
}

$req_headers = apache_request_headers();
if (!empty($req_headers['X-PJAX'])) {
	if ($file == "404") {
		http_response_code(404);
		exit;
	}
	?>
	<title><?=$page?> - <?=$sitename?></title>
	<?php
	include 'layout/'.$file.".php";
}
else {
	include 'layout/header.phtml';
	include 'layout/top.phtml';
	include 'layout/navbar.phtml';
	include 'layout/'.$file.".php";
	include 'layout/footer.phtml';
}