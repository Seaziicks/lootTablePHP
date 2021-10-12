<?php
declare(strict_types=1);

use Firebase\JWT\JWT;
require_once('../vendor/autoload.php');

function getJwtAlgorithm()
{
    return 'HS512';
}

function getJwtSecret()
{
    $secretKey = 'bGS6lzFqvvSQ8ALbOxatm7/Vk7mLQyzqaS34Q4oR1ew=';
    return $secretKey;
}

function getJwtFromHeaders(): string
{
    $headers = getallheaders();
    $authorizationHeader = $headers['Authorization'];

    if ($authorizationHeader) {
        // print_r(getallheaders()['Authorization']);
        if (!preg_match('/Bearer\s(\S+)/', getallheaders()['Authorization'], $matches)) {
            header('HTTP/1.0 401 - Missing Bearer in Authorization header');
            echo 'Token not found in request';
            exit;
        }

        $jwt = $matches[1];
        if (!$jwt) {
            // No token was able to be extracted from the authorization header
            header('HTTP/1.0 403 Forbidden - Fake JWT');
            exit;
        }
    } else {
        header('HTTP/1.0 401 Unauthorized - Missing Authorization header');
        exit;
    }

    return $jwt;
}

function decodeJwt(string $jwt)
{
    $decoded = JWT::decode($jwt, getJwtSecret(), array(getJwtAlgorithm()));
    return $decoded;
}