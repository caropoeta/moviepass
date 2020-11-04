<?php

namespace DAO;


class GoogleQRDAO
{
    public static function GetQrImgUrl(String $var)
    {
        return "https://chart.googleapis.com/chart?chs=300x300&cht=" . urlencode($var) . "&choe=UTF-8";
    }
}
