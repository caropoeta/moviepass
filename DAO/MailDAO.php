<?php

namespace DAO;

class MailDAO
{
    public static function sendMail(String $to, String $subject, String $htmlBody)
    {
        $headers = "From:" . APP_MAIL . " \r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html\r\n";

        if (mail($to, $subject, $htmlBody, $headers))
            return true;
        else
            return false;
    }
}
