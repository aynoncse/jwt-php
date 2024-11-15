<?php

namespace JWT;

class JWT {

	/**
	 * Sign the payload with a secret key to generate a JWT token.
	 *
	 * @param array $payload The data to include in the payload.
	 * @param string $key The secret key used to sign the token.
	 * @param int|null $expire The expiration time in seconds (optional).
	 * @return string The generated JWT token.
	 */
	public static function generateToken($payload, $key, $expire = null) {
		// Add expiration time if provided
		if ($expire) {
			$payload['expire'] = time() + $expire;
		}
		// Generate a random salt to ensure uniqueness
		$salt = bin2hex(random_bytes(16));
		$payload['salt'] = $salt;

		// JWT header containing algorithm and type
		$header = [
			'type' => 'JWT',
			'algo' => 'HS256',
		];

		// Encode the header and payload into a URL-safe base64 string
		$encodedHeader = self::base64Encode(json_encode($header));
		$encodedPayload = self::base64Encode(json_encode($payload));

		// Create the signature using HMAC-SHA256
		$signature = hash_hmac('SHA256', $encodedHeader . $encodedPayload, $key);
		$encodedSignature = self::base64Encode($signature);

		// Return the final JWT token (header.payload.signature)
		return $encodedHeader . '.' . $encodedPayload . '.' . $encodedSignature;
	}

	/**
	 * Verify the validity of a JWT token.
	 *
	 * @param string $token The JWT token to verify.
	 * @param string $key The secret key used to verify the token.
	 * @return mixed The decoded payload if the token is valid, or false if invalid.
	 */
	static function validateToken($token, $key) {
		// Split the token into its parts (header, payload, signature)
		$parts = explode('.', $token);
		if (count($parts) != 3) {
			return false; // Invalid token format
		}

		// Recreate the signature from the header and payload
		$signature = self::base64Encode(hash_hmac('SHA256', $parts[0] . $parts[1], $key));

		// Check if the signature matches
		if ($signature != $parts[2]) {
			return false; // Invalid signature
		}

		// Decode the payload to check expiration and other claims
		$payload = json_decode(self::base64Decode($parts[1]), true);

		// Check if the token is expired
		if (isset($payload['expire']) && $payload['expire'] < time()) {
			return false;
		}

		// Return the decoded payload if the token is valid
		return $payload;
	}

	/**
	 * Encode data to a URL-safe Base64 string.
	 *
	 * @param string $data The data to encode.
	 * @return string The URL-safe Base64 encoded string.
	 */
	private static function base64Encode($data) {
		return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
	}

	/**
	 * Decode a URL-safe Base64 string.
	 *
	 * @param string $data The URL-safe Base64 string to decode.
	 * @return string The decoded data.
	 */
	private static function base64Decode($data) {
		return base64_decode(strtr($data, '-_', '+/'));
	}
}
