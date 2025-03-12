<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* # En- and decryption ------------------------------------------------------------------------------- */

/* ## SMTP
------------------------------------------------------------------ */

// Encrypt password
function wpw_encrypt_password($password) {

    $encryption_key = '99JBpGp7tT6jQwhu2ZcZTggcawnUFeJD';

    // Create a initial vector (IV)
    $iv_length = openssl_cipher_iv_length('aes-256-cbc');
    $iv = openssl_random_pseudo_bytes($iv_length);

    // PKCS7 Padding to fill to length for correct aes-256-encryption
    $block_size = openssl_cipher_iv_length('aes-256-cbc');
    $padding = $block_size - (strlen($password) % $block_size);
    $password .= str_repeat(chr($padding), $padding);

    // Encrypt password
    $encrypted_password = openssl_encrypt($password, 'aes-256-cbc', $encryption_key, 0, $iv);

    // Base64-Coding of the encrypted password
    return base64_encode($iv . $encrypted_password);

}

// Decrypt password
function wpw_decrypt_password($encrypted_password) {

    $encryption_key = '99JBpGp7tT6jQwhu2ZcZTggcawnUFeJD';

    // Decode the Base64-String
    $encrypted = base64_decode($encrypted_password);

    if ($encrypted === false) {
        echo "Error during Base64-Decoding.";
        return false;
    }

    // Extract the initial vector (IV)
    $iv_length = openssl_cipher_iv_length('aes-256-cbc');
    
    if (strlen($encrypted) < $iv_length) {
        echo "Wrong length of the encoded text.";
        return false;
    }

    $iv = substr($encrypted, 0, $iv_length);
    $encrypted = substr($encrypted, $iv_length);

    // Decode the password
    $decrypted_password = openssl_decrypt($encrypted, 'aes-256-cbc', $encryption_key, 0, $iv);


    // Remove PKCS7 Padding original password length
    $padding = ord($decrypted_password[strlen($decrypted_password) - 1]);
    $decrypted_password = substr($decrypted_password, 0, -$padding);


    if ($decrypted_password === false) {
        echo "Error during decryption: " . openssl_error_string();
    }

    return $decrypted_password;
    
}