<?php

namespace DAO;

use PDOException;

class DiscountDAO
{
    public static function GetDiscountAndMinTicketsFromToday()
    {
        $query = "
        select percentage, minTickets 
        from discountpolicy 
        where dayOfTheWeek = (select dayname(cast(current_timestamp as date)));
        ";

        try {
            $conection = Connection::GetInstance();
            $response = $conection->Execute($query, []);
        } catch (PDOException $th) {
            throw $th;
        }

        if ($response != null && isset($response[0]))
            return $response[0];
    }

    public static function GetDiscountIdForNoDiscount()
    {
        $query = "
        select id
        from discountpolicy 
        where dayOfTheWeek = :none;
        ";

        try {
            $conection = Connection::GetInstance();
            $response = $conection->Execute($query, array('none' => 'None'));
        } catch (PDOException $th) {
            throw $th;
        }

        if ($response != null && isset($response[0]))
            return $response[0]['id'];
    }

    public static function GetDiscountIdForToday()
    {
        $query = "
        select id
        from discountpolicy 
        where dayOfTheWeek = (select dayname(cast(current_timestamp as date)));
        ";

        try {
            $conection = Connection::GetInstance();
            $response = $conection->Execute($query, []);
        } catch (PDOException $th) {
            throw $th;
        }

        if ($response != null && isset($response[0]))
            return $response[0]['id'];
    }

    public static function GetDiscountAndMinTicketsFromId(int $id)
    {
        $query = "
        select percentage, minTickets 
        from discountpolicy 
        where id = :id;
        ";

        try {
            $conection = Connection::GetInstance();
            $response = $conection->Execute($query, array('id' => $id));
        } catch (PDOException $th) {
            throw $th;
        }

        if ($response != null && isset($response[0]))
            return $response[0];
    }
}
