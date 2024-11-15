<?php

use JWT\JWT;

// Include the JWT class file manually if it's not autoloaded
include_once 'jwt/JWT.php';

// Define the payload with user information
$payload = [
	'id' => 1,
	'username' => 'aynoncse'
];

$secretKey = 'bzopodtf';  // Secret key for signing the token

// Generate a token with a 5-minute expiration time
$token = JWT::generateToken($payload, $secretKey, 60 * 5);

// Print the decoded payload if the token is valid
print_r($payload);
