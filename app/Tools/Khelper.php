<?php
/**
 * Created by PhpStorm.
 * User: kmasteryc
 * Date: 6/28/16
 * Time: 9:32 PM
 */
namespace Tools;
class Khelper{
    static function readbleLyric($lyric)
    {
        $res = preg_replace('/\[.*\]/','',$lyric);
        $res = nl2br($res);
        return $res;
    }
}