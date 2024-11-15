<?php

use JWT\JWT;

include_once 'jwt/JWT.php';



$payload = [
	'id' => 1,
	'username' => 'aynoncse'
];

$secretKey = 'bzopodtf';

// Generate a token
$token = JWT::generateToken($payload, $secretKey, 60 * 5);

// Validate the generated token
$payload = JWT::validateToken($token, $secretKey);

print_r($payload);
