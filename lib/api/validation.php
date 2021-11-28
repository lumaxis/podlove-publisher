<?php

namespace Podlove\Api;

use Podlove\NormalPlayTime;


class Validation
{
    public static function timestamp( $param, $request, $key )
    {
        $npt = NormalPlayTime\Parser::parse($param, 'ms');
        if (is_bool($npt) === true && $npt === false)
            return false;
        return true;
    }

    public static function url( $param, $request, $key )
    {
        if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$param)) {
            return true;
        }

        return false;
    }

    public static function chapters( $param, $request, $key )
    {
        if (isset($param) && is_array($param)) {
            for ($i = 0; $i < count($param); ++$i ) {
                $timestamp = '';
                if (isset($param[$i]['timestamp'])) {
                    $timestamp = $param[$i]['timestamp'];
                    if (!Validation::timestamp($timestamp, $request, $key))
                        return false;
                }
                $title = '';
                if (isset($param[$i]['title'])) {
                    $title = $param[$i]['title'];
                }
                else 
                    return false;
                $url = '';
                if (isset($param[$i]['url'])) {
                    $url = $param[$i]['url'];
                    if (!Validation::url($url, $request, $key))
                        return false;
                }
            }
        }
        return true;
    }
}