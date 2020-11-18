<?php

namespace DAO;

use PDOException;

class PurchaseDAO
{
    public static function addPurchase(int $numberOfTickets, int $functionId, int $idDiscount, int $usid)
    {
        try {
            $conection = Connection::GetInstance();
            $query = "
                    INSERT INTO purchase(amount, numberOfTickets, discountId) 
                    VALUES (:amount,:numberOfTickets,:discountId);
                ";
            $data = TicketDAO::getFunctionRoomAndCinemaDataFromFunctionId($functionId);
            $datDisArray = DiscountDAO::GetDiscountAndMinTicketsFromId($idDiscount);

            $discountMinTickets = $datDisArray['minTickets'];
            $discountPercentaje = $datDisArray['percentage'];
            $price = $data['price'];

            if ($discountMinTickets <= $numberOfTickets)
                $price *= (1 - $discountPercentaje);

            $totalPrice = $price * $numberOfTickets;

            $params = [];
            $params['amount'] = $totalPrice;
            $params['numberOfTickets'] = $numberOfTickets;
            $params['discountId'] = $idDiscount;

            $conection->ExecuteNonQuery(
                $query,
                $params
            );

            $query = "SELECT LAST_INSERT_ID();";
            $result = $conection->Execute($query, []);
        } catch (PDOException $ex) {
            throw $ex;
        }

        if ($result != null && isset($result[0]))
            return $result[0]['LAST_INSERT_ID()'];
    }
}
