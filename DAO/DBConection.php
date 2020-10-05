<?php
namespace DAO;

class DBConection
{
    public static function getDBConnection()
    {
        return mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    }
}