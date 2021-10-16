<?php 
// +------------------------------------------------------------------------+
// | @author        : Michael Arawole (Logad Networks)
// | @author_url    : https://logad.net
// | @author_email  : logadscripts@gmail.com
// | @date          : 11 Oct, 2021 05:02PM
// +------------------------------------------------------------------------+
// | Copyright (c) 2021 Logad Networks. All rights reserved.
// +------------------------------------------------------------------------+

// +----------------------------+
// | Function Class
// +----------------------------+

class Logad {
	protected $pdo;
	public function __construct() {
		require 'config.php';
		try {
			$pdo = new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
		} catch (PDOException $exception) {
			exit('Failed to connect to database!');
		}
		$this->pdo = $pdo;
		$this->naira = $naira;
		$this->siteurl = $siteurl;
	}

	## Site Settings ##
	public function settings($s = null) {
		$stmt = $this->pdo->prepare("SELECT * FROM site_settings");
		$stmt->execute();
		$results = $stmt->fetchAll(PDO::FETCH_OBJ);
		foreach ($results as $obj) {
		    $columns[] = $obj;
		}
		$obj = new stdClass();
		foreach ($columns as $column) {
			$obj->{$column->name} = $column->value;
		}
		if (!empty($s)) {
			$obj->columns = $columns;
		}
		$obj->siteurl = $this->siteurl;
		$obj->site_logo = $this->siteurl."/".$obj->site_logo;
		$obj->site_icon = $this->siteurl."/".$obj->site_icon;
		return $obj;
	}

	## Upload Document Handler ##
	protected function upload_document($file, $customFormat = null){
		$response['status'] = false;
		$response['msg'] = "Some error occurred while uploading the document";

		$file = (array) $file;
		// Check upload status
		if (empty($file['name']) || $file['error'] != UPLOAD_ERR_OK){
			$response['msg'] = "File upload failed. Please check the file";
			return $response;
		}

		// Upload Folder
		$folder = dirname(__FILE__,2)."/uploads/documents/".date("Y")."/".date("m")."/";
		if (!is_dir($folder)) mkdir($folder, 0777, true);

		// Check file size
		if ($file["size"] > 5000000) {
			$response['msg'] = "Sorry, your file is too large.";
			return $response;
		}

		$temporaryName = $file['tmp_name'];
		$original_name = basename($file['name']);

		// Check File mime
		$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
		if (empty($customFormat)) {
			$mime_type = $file['type'];
			$allowed_types = array('application/pdf','application/msword','application/csv','text/plain','image/png','image/jpeg','image/jpg');
			if (!in_array($mime_type, $allowed_types)) {
				$response['msg'] = "File type is not allowed";
				return $response;
			}
			
			// Check Extension
			if ($extension != "pdf" && $extension != "doc" && $extension != "docx" && $extension != "png" && $extension != "jpg" && $extension != "jpeg" && $extension != "txt" && $extension != "csv") {
				$response['msg'] = "Only pdf, doc, docx, png, jpg, jpeg, txt files are allowed!";
				return $response;
			}
		} elseif ($extension != $customFormat) {
			$response['msg'] = "File type not suppoted. Upload a $customFormat file";
			return $response;
		}

		$file_name = 'file_'.date('Y-m-d').'_'.time().'_'.uniqid().".".$extension;
		if (move_uploaded_file($temporaryName, $folder.$file_name) === true){
			$path = str_replace(dirname(__FILE__,2)."/", null, $folder.$file_name);
			$response['status'] = true;
			$response['msg'] = "File Uploaded";
			$response['path'] = $path;
			$response['fullPath'] = $folder.$file_name;
		}

		return $response;
	}

	## Allow only XHR ##
	public function onlyxhr(){
		if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
			if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
				http_response_code(404);
				exit;
			}
		} 
		else {
			http_response_code(404);
			exit;
		}
	}

    private function reArrayFiles(&$file_post) {
	    $file_ary = array();
	    $file_count = count($file_post['name']);
	    $file_keys = array_keys($file_post);
	    for ($i=0; $i<$file_count; $i++) {
	        foreach ($file_keys as $key) {
	            $file_ary[$i][$key] = $file_post[$key][$i];
	        }
	    }
	    return $file_ary;
	}

	## Clean string ##
	public function clean($string){
		$string = htmlentities($string);
		return $string;
	}

	## Encrypt string ##
	public function encrypt($string){
		$simple_string = $string;
		$ciphering = "AES-128-CTR";
		$iv_length = openssl_cipher_iv_length($ciphering); 
		$options = 0;
		$encryption_iv = 'logadnetworkskey';
		$encryption_key = "5OZHVomiqK4e62RT1zaFWur0jAY3cEkf";
		$encryption = openssl_encrypt($simple_string, $ciphering, 
					$encryption_key, $options, $encryption_iv); 
		return $encryption;
	}

	## Decrypt string ##
	public function decrypt($string){
		$encryption = $string;
		$ciphering = "AES-128-CTR";
		$iv_length = openssl_cipher_iv_length($ciphering); 
		$options = 0; 
		$decryption_iv = 'logadnetworkskey';
		$decryption_key = "5OZHVomiqK4e62RT1zaFWur0jAY3cEkf";
		$decryption = openssl_decrypt ($encryption, $ciphering, 
				$decryption_key, $options, $decryption_iv);
		return $decryption;
	}

	## Generate random string ##
	public function GenerateKey($minlength = 20, $maxlength = 20, $uselower = true, $useupper = true, $usenumbers = true, $usespecial = false, $useZero = true) {
		$charset = '';
		if ($uselower) {
			$charset .= "abcdefghijklmnopqrstuvwxyz";
		}
		if ($useupper) {
			$charset .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		}
		if ($usenumbers) {
			if ($useZero) {
				$charset.= "0";
			}
			$charset .= "123456789";
		}
		if ($usespecial) {
			$charset .= "~@#$%^*()_+-={}|][";
		}
		if ($minlength > $maxlength) {
			$length = mt_rand($maxlength, $minlength);
		} else {
			$length = mt_rand($minlength, $maxlength);
		}
		$key = '';
		for ($i = 0; $i < $length; $i++) {
			$key .= $charset[(mt_rand(0, strlen($charset) - 1))];
		}
		return $key;
	}

	## Format amounts ##
	public function format($amount) {
		if (is_float($amount)) {
			return number_format($amount, 2);
		}
		return number_format($amount);
	}

	// +----------------------------+
	// | User functions
	// +----------------------------+

	## Allow only logged in users ##
	public function onlyauth($redirect = false) {
		if ($this->user_logged_in() === false) {
			if ($redirect === true) {
				// $_SESSION['return_url'] = $_SERVER['REQUEST_URI'];
				header("Location: $this->siteurl/dashboard/login");
				exit;
			}
			else {
				http_response_code(403);
				exit;
			}
		}
	}

	## Single User ##
	public function user($user_id, $selector = "id", $raw = false) {
		if (!empty($selector)) {
			$stmt = $this->pdo->prepare("SELECT * FROM users WHERE $selector = ? LIMIT 1");
			$stmt->execute([$user_id]);
		}
		$obj = $stmt->fetch(PDO::FETCH_OBJ);
		if (!$obj) {
			return false;
		}

		$obj->name = $obj->fname.' '.$obj->lname;
		if (empty($obj->profilepic)) {
			$obj->profilepic = "avatar.png";
		}
		$obj->profilepic = $this->siteurl."/uploads/".$obj->profilepic;
		if (empty($raw)) {
			unset($obj->password);
			// $obj->data = $this->user_data($obj->id);
			// $obj->permissions = $this->user_permissions($obj->permission_id);
			$obj->uid = strtoupper($obj->uid);
			$obj->date_formatted = date("F j, Y", $obj->date);
		}
		return $obj;
	}

	## Add user ##
	public function userActions ($data, $action) {
		$response['msg'] = "An error occurred";
		$response['status'] = false;

		if ($action == "addUser") {
			$password = password_hash($data->password, PASSWORD_DEFAULT);
			$params = [$data->fname, $data->lname, $data->email, $data->phone, $password];
			$stmt = $this->pdo->prepare("INSERT INTO users (fname, lname, email, phone, password) VALUES (?, ?, ?, ?, ?)");
			if ($stmt->execute($params)) {
				$lastId = $this->pdo->lastInsertId();
				// Generate account number
				if ($this->generateAccNo($lastId)) {
					$response['status'] = true;
					$response['msg'] = "Account created";
				}
			}
		}
		return $response;
	}

	## Login ##
	public function user_login ($data) {
		$response['msg'] = "An error occurred";
		$response['status'] = false;

		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		$stmt = $this->pdo->prepare("SELECT id, password, auth_code FROM users WHERE account_number = ?");
		$stmt->execute([$data->account_number]);
		if($stmt->rowCount() == 0) {
			$response['msg'] = "Invalid login credentials";
			return $response;
		}

		$result = $stmt->fetch(PDO::FETCH_OBJ);

		// verify password
		if (!password_verify($data->password, $result->password)) {
			$response['msg'] = "Invalid login credentials";
			return $response;
		}

		// if deactivated
		/*if ($result->active == 0) {
			$response['msg'] = "Your account has been deactivated. Contact support for assistance";
			return $response;
		}*/

		if (empty($result->auth_code)) {
			$token = $this->setUserToken($result->id);
		}
		else {
			$token = $result->auth_code;
		}

		session_regenerate_id();
	    $_SESSION['user_auth_token'] = $token;

	    $response['status'] = true;
	    $response['msg'] = "Login successful";
	    $response['token'] = $token;

	    return $response;
	}

	## Set Login token ##
	private function setUserToken ($user_id) {
		$token = bin2hex(random_bytes(12));
		// If you get an error concerning the above, 
		// comment the above line and uncomment the next line.
		// $token = bin2hex(openssl_random_pseudo_bytes(12));
		$stmt = $this->pdo->prepare("UPDATE users SET auth_code = ? WHERE id = ?");
		;
		$stmt->execute([$token,$user_id]);
		if ($stmt->rowCount() == 1) {
			return $token;
		}
		return false;
	}

	## Is user logged in ##
	public function user_logged_in() {
		return $this->user_session(false, false);
	}

	## User session ##
	public function user_session($admin = false, $returnId = true) {
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
			session_write_close();
		}
		
		if (!empty($admin)) {
			if (!empty($_SESSION['admin_auth_token'])) {
				$token = $this->clean($_SESSION['admin_auth_token']);
				$id = $this->get_user_id($token);
				if (is_numeric($id) && !empty($id)) {
					return ($returnId) ? $id : true;
				}
			}
		} 
		else {
			if (!empty($_SESSION['user_auth_token'])) {
				$token = $this->clean($_SESSION['user_auth_token']);
				$id = $this->get_user_id($token);
				if (is_numeric($id) && !empty($id)) {
					return ($returnId) ? $id : true;
				}
			}
		}
		return false;
	}

	## Get user id ##
	private function get_user_id ($token) {
		$stmt = $this->pdo->prepare("SELECT id FROM users WHERE auth_code = ?");
		$stmt->execute([$token]);
		$result = $stmt->fetch(PDO::FETCH_OBJ);
		if (!empty($result)) {
			return $result->id;
		}
		return false;
	}

	private function generateAccNo ($user_id) {
		$lastNumber = 0100000000;
		$accountNumber = $lastNumber + $user_id;
		// if (strlen($accountNumber) > 10)

		// check if account number already exists
		$stmt = $this->query("SELECT id FROM users WHERE account_number = '$accountNumber'");
		$result = $stmt->fetch(PDO::FETCH_OBJ);
		if (!empty($result)) {
			$this->generateAccNo();
		} else {
			$stmt = $this->pdo->prepare("UPDATE users SET account_number = ? WHERE id = ?");
			$stmt->execute([$accountNumber, $user_id]);
			if ($stmt->rowCount() == 1) {
				return true;
			}
		}
		return false;
	}

	## User transactions ##
	public function userTransactions ($user_id) {
		return array();
		$stmt = $this->pdo->prepare("SELECT * FROM transactions ORDER BY id DESC");
		$stmt->execute();
		$data = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $data;
	}


	// +----------------------------+
	// | Admin Panel
	// +----------------------------+

	## Is admin logged in? ##	
	public function admin_logged_in() {
		return $this->user_session(true, false);
	}

	## Allow only admin ##
	public function onlyadmin ($redirect = false) {
		if ($this->admin_logged_in() === false) {
			if ($redirect === true) {
				header("Location: $this->siteurl/dashboard/login");
				exit;
			}
			else {
				http_response_code(403);
				exit;
			}
		}
	}

	## Tickets ##
	public function user_tickets($user_id) {
		return $this->all_tickets($user_id, "user_id");
	}

	## Support Departments ##
	public function support_departments($id = null) {
		$data = array();
		if (!empty($id)) {
			$stmt = $this->con->prepare("SELECT * FROM support_departments WHERE id = ? ORDER BY id DESC");
			$stmt->execute([$id]);
		} else {
			$stmt = $this->pdo->prepare("SELECT * FROM support_departments ORDER BY name DESC");
			$stmt->execute();
		}
		if (!empty($id)) {
			$data = $stmt->fetch(PDO::FETCH_OBJ);
		} else {
			$data = $stmt->fetchAll(PDO::FETCH_OBJ);
		}
		return $data;
	}

	## All Tickets ##
	public function all_tickets($id = null, $selector = "id") {
		$data = array();
		if (!empty($id)) {
			$stmt = $this->pdo->prepare("SELECT * FROM tickets WHERE $selector = ? ORDER BY id DESC");
			$stmt->execute([$id]);
		} else {
			$stmt = $this->pdo->prepare("SELECT * FROM tickets ORDER BY id DESC");
		}
		$stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_OBJ);
		if (!$result) return $data;

		foreach ($result as $obj) {
			// comments
			$obj->comments = $this->ticket_comments($obj->id);
		    $data[] = $obj;
		}

		return $data;
	}

	## Ticket comments ##
	public function ticket_comments($ticket_id) {
		$data = array();
		$stmt = $this->pdo->prepare("SELECT * FROM tickets_comments WHERE ticket_id = ?");
		$stmt->execute([$ticket_id]);
		$result = $stmt->fetchAll(PDO::FETCH_OBJ);
		if (!$result) return $data;
		return $result;
	}

	public function ticket_actions($post, $action) {
		$response['status'] = false;
		$response['msg'] = "An error occurred";

		if ($action == "create") {
			$ticketID = $this->GenerateKey(6,6, false, false, true, false, false);
			$stmt = $this->pdo->prepare("INSERT INTO tickets (ticket_id, user_id, title, msg, department) VALUES (?,?,?,?,?)");
			$stmt->bind_param("iisss", $ticketID, $post->user_id, $post->title, $post->msg, $post->department);
			$stmt->execute();
			if ($stmt->affected_rows == 1) {
				$response['ticket_id'] = $ticketID;
				$response['status'] = true;
				$response['msg'] = "Ticket created successfully";
			}
		}

		if ($action == "reply") {
			$ticketID = $this->decrypt($post->ticket_id);
			$ticket = $this->all_tickets($ticketID);
			if ($ticket->status == 'closed' || $ticket->status == 'resolved') {
				$response['msg'] = "Ticket has been {$ticket->status}";
				return $response;
			}

			$stmt = $this->con->prepare("INSERT INTO tickets_comments (ticket_id, user_id, msg) VALUES (?,?,?)");
			$stmt->bind_param("iis", $ticketID, $post->user_id, $post->msg);
			$stmt->execute();
			if ($stmt->affected_rows == 1) {
				$response['status'] = true;
				$response['msg'] = "Reply sent";
			}
		}

		if (in_array($action, array('close', 'resolve'))) {
			$ticketID = $this->decrypt($post->ticket_id);
			$ticket = $this->all_tickets($ticketID);
			$status = ($action == "close") ? "closed" : "resolved";
			$stmt = $this->con->prepare("UPDATE tickets SET status = '$status' WHERE id = ?");
			$stmt->bind_param("i", $ticketID);
			$stmt->execute();
			if ($stmt->affected_rows == 1) {
				// register activity
				$this->register_activity([
					'user_id' => $post->user_id,
					"type" => "support",
					"activity" => ucfirst($status)." ticket #$ticket->ticket_id",
					"ref_id" => $ticketID
				]);
				$response['status'] = true;
				$response['msg'] = "Ticket $status";
			}
		}
		if ($action == "escalate") {
			$ticketID = $this->decrypt($post->ticket_id);
			$ticket = $this->all_tickets($ticketID);
			$stmt = $this->con->prepare("UPDATE tickets SET escalated = 1 AND department = ? WHERE id = ?");
			$stmt->bind_param("ii", $post->department, $ticketID);
			$stmt->execute();
			if ($stmt->affected_rows == 1) {
				// register activity
				$this->register_activity([
					'user_id' => $post->user_id,
					"type" => "support",
					"activity" => "Escalated ticket #$ticket->ticket_id",
					"ref_id" => $ticketID
				]);
				$response['status'] = true;
				$response['msg'] = "Ticket escalated to $post->escalate_to";
			}
		}

		if ($action == "add-department") {
			$stmt = $this->con->prepare("INSERT INTO support_departments (name) VALUES (?)");
			$stmt->bind_param("s", $post->name);
			$stmt->execute();
			if ($stmt->affected_rows == 1) {
				$response['status'] = true;
				$response['msg'] = "Department added successfully";
			}
		}
		if ($action == "edit-department") {
			$stmt = $this->pdo->prepare("UPDATE support_departments SET name = ? WHERE id = ?");
			$stmt->bind_param("si", $post->name, $post->item_id);
			$stmt->execute();
			if ($stmt->affected_rows == 1) {
				$response['status'] = true;
				$response['msg'] = "Changes saved";
			}
		}

		return $response;
	}
}

$app = new Logad();
$site = $app->settings();
$sitename = $site->site_name;
$siteurl = $site->siteurl;
$naira = "₦";
