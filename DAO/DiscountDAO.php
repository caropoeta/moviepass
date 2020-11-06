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
}
