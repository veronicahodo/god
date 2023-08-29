<?php

// index.php

// Where all the magic happens in the god api


require_once('vcrud.php');
require_once('node.php');
require_once('link.php');
require_once('config.php');


$crud = new VCRUD($DB_USER,$DB_PASS,$DB_HOST,$DB_NAME);

$output = [
	'status'=>'error',
	'message'=>'Undefined error'
];

$command = htmlspecialchars($_REQUEST['command'] ?? '');

switch (strtolower($command)) {
	case 'node.read':
		$node = new NODE();
		$output = $node->processRead($crud);
		break;
	case 'test':
		$output = [
			'status'=>'ok',
			'message'=>'test command complete'
		];
		break;
	default:
		$output['message'] = 'Invalid command specified:'.$command;

}


header('Content-type: application/json');
print(json_encode($output));


