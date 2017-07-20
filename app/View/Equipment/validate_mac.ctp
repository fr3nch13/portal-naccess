<?php 

$message = (isset($message)?$message:__('This Mac is valid and allowed.'));

if(is_array($message))
{
	$message = Set::flatten($message);
	$message = implode("\n", $message);
}

$result = array(
	'success' => $success,
	'message' => $message,
	'mac_address' => $mac_address,
);

header("Content-Type: application/json", true);
echo json_encode($result);