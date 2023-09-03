<?php

// index.php

// Where all the magic happens in the god api


require_once('vcrud.php');
require_once('vuser.php');
require_once('node.php');
require_once('link.php');
require_once('config.php');


$crud = new VCRUD($DB_USER, $DB_PASS, $DB_HOST, $DB_NAME);

$output = [
	'status' => 'error',
	'message' => 'Undefined error'
];

function processAuthLogin(VCRUD $c)
{
	$username = htmlspecialchars($_REQUEST['username'] ?? '');
	$password = htmlspecialchars($_REQUEST['password'] ?? '');
	$token = new VTOKEN();
	$user = new VUSER();
	if ($userId = $user->validatePassword($username, $password, $c)) {
		$token = $token->generateToken($userId, $c);
		return [
			'status' => 'ok',
			'userId' => $userId,
			'token' => $token
		];
	} else {
		return [
			'status' => 'error',
			'message' => '[auth.login] username and password do not match'
		];
	}
}


$command = htmlspecialchars($_REQUEST['command'] ?? '');




switch (strtolower($command)) {
	case 'node.read':
		$node = new NODE();
		$output = $node->processRead($crud);
		break;
	case 'auth.login':
		$output = processAuthLogin($crud);
		break;
	case 'test':
		$output = [
			'status' => 'ok',
			'message' => 'test command complete'
		];
		break;
	default:
		$output['message'] = 'Invalid command specified:' . $command;
}


header('Content-type: application/json');
print(json_encode($output));
