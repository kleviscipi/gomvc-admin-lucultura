<?php
namespace Go;

class Password
{


    public static function make($password, $algo = PASSWORD_DEFAULT, array $options = array())
    {
        return password_hash($password, $algo, $options);
    }

    public static function getInfos($hash)
    {
        return password_get_info($hash);
    }


    public static function needsRehash($hash, $algo = PASSWORD_DEFAULT, array $options = array())
    {
        return password_needs_rehash($hash, $algo, $options);
    }


    public static function verify($password, $hash)
    {
        return password_verify($password, $hash);
    }
}
