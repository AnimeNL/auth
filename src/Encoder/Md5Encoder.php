<?php

namespace App\Encoder;

use Symfony\Component\Mime\Encoder\EncoderInterface;
use Symfony\Component\Security\Core\Encoder\BasePasswordEncoder;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;

class Md5Encoder extends BasePasswordEncoder implements EncoderInterface
{

    /**
     * Encode a given string to produce an encoded string.
     *
     * @param int $firstLineOffset if first line needs to be shorter
     * @param int $maxLineLength - 0 indicates the default length for this encoding
     *
     * @return string
     */
    public function encodeString(
        string $string,
        ?string $charset = 'utf-8',
        int $firstLineOffset = 0,
        int $maxLineLength = 0
    ): string {
        return md5($string);
    }

    /**
     * Encodes the raw password.
     *
     * @param string      $raw The password to encode
     * @param string|null $salt The salt
     *
     * @return string The encoded password
     *
     * @throws BadCredentialsException   If the raw password is invalid, e.g. excessively long
     * @throws \InvalidArgumentException If the salt is invalid
     */
    public function encodePassword($raw, $salt)
    {
        return md5($raw);
    }

    /**
     * Checks a raw password against an encoded password.
     *
     * @param string      $encoded An encoded password
     * @param string      $raw A raw password
     * @param string|null $salt The salt
     *
     * @return bool true if the password is valid, false otherwise
     *
     * @throws \InvalidArgumentException If the salt is invalid
     */
    public function isPasswordValid($encoded, $raw, $salt)
    {
        return md5($raw) === $encoded;
    }
}
