# PHP JWT Authentication

This project demonstrates how to create and validate JSON Web Tokens (JWT) using PHP. It includes a simple implementation of JWT generation and validation with an example payload.

## Features

- Generate JWT tokens with custom payloads.
- Validate JWT tokens and check for expiration.
- Secure token signing using HMAC-SHA256.

## Requirements

- PHP 7.0 or higher

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/aynoncse/jwt-php.git
   cd php_jwt
   ```

## Usage

To generate and validate a JWT token, you can modify the `index.php` file located in the root directory.

### Example

The following code generates a JWT token and validates it:

```php
<?php
use JWT\JWT;

// Include the JWT class file manually if it's not autoloaded
include_once  'jwt/JWT.php';

// Define the payload with user information
$payload  = [
	'id'  =>  1,
	'username'  =>  'aynoncse'
];

// Secret key for signing the token
$secretKey  =  'bzopodtf';

// Generate a token with a 5-minute expiration time
$token  =  JWT::generateToken($payload, $secretKey, 60  *  5);

// Print the decoded payload if the token is valid
print_r($payload);
```

### Token Structure

A JWT consists of three parts:

1.  **Header**: Contains metadata about the token, including the type and signing algorithm.
2.  **Payload**: Contains the claims (the data you want to store).
3.  **Signature**: Used to verify the authenticity of the token.

The final token format looks like this: `header.payload.signature`.

## Security

- Always use a strong secret key for signing tokens.
- Ensure the secret key is kept confidential and not hardcoded in your codebase.
- Use HTTPS to secure communication between the client and server.
- Implement token expiration and refresh mechanisms to enhance security.

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request. For major changes, please open an issue first to discuss what you would like to change.
