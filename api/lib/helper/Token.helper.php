<?php

/**
    @desc: Token helper
 */

class TokenHelper {

    /**
        @desc: generates token
    */
    static function generateToken(){
        //Generate a random string.
        $token = openssl_random_pseudo_bytes(16);

        //Convert the binary data into hexadecimal representation.
        $token = bin2hex($token);
        
        return $token;
    }
}
