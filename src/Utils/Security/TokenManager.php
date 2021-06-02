<?php

namespace App\Utils\Security;

/**
 * Class TokenManager
 *
 * @author CONTE Alexandre <pro.alexandre.conte@gmail.com>
 */
class TokenManager
{
    /**
     * @param int $bytes
     *
     * @return string
     *
     * @throws \Exception
     */
    public static function getToken($bytes = 32): string
    {
        return random_bytes($bytes);
    }

    /**
     * @param string $token
     *
     * @return string
     */
    public static function hashToken(string $token): string
    {
        return hash('sha256', $token);
    }

    /**
     * @param string $token
     *
     * @return string
     */
    public static function getValidator(string $token): string
    {
        return bin2hex($token);
    }

    /**
     * @param int $bytes
     *
     * @return string
     *
     * @throws \Exception
     */
    public static function getSelector($bytes = 8): string
    {
        return bin2hex(static::getToken($bytes));
    }

    /**
     * @param string $validator
     * @param string $hash
     *
     * @return bool
     */
    public static function isTokenValid(string $validator, string $hash): bool
    {
        try {
            $calc = hash('sha256', hex2bin($validator));

            return hash_equals($calc, $hash);
        } catch (\Exception $exception) {
            return false;
        }
    }
}