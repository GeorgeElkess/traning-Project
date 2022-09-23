<?php 
class Encryption{
    public static function Encrypt($String) {
        /**                  First Method                                                */
        // $key = 140;
        // $encryption_key = base64_decode($key);
        // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        // $encrypted = openssl_encrypt($String, 'aes-256-cbc', $encryption_key, 0, $iv);
        // return base64_encode($encrypted . '::' . $iv);
        /**                  Second Method                                               */
        $ciphering = "AES-128-CTR";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options   = 0;
        $encryption_iv = '1234567891011121';
        $encryption_key = "W3docs";
        $encryption = openssl_encrypt($String, $ciphering, $encryption_key, $options, $encryption_iv);
        return $encryption;
    }
    public static function Decrypt($String) {
        /**                  First Method                                                */
        // $key = 140;
        // $encryption_key = base64_decode($key);
        // list($encrypted_data, $iv) = array_pad(explode('::', base64_decode($String), 2), 2, null);
        // return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
        /**                  Second Method                                               */
        $ciphering = "AES-128-CTR";
        $decryption_iv = '1234567891011121';
        $decryption_key = "W3docs";
        $options   = 0;
        $decryption = openssl_decrypt($String, $ciphering, $decryption_key, $options, $decryption_iv);
        return $decryption;
    }
}