<?php

namespace DAO;

use Models\Exceptions\ArrayException;
use PDOException;

class CreditCardDAO
{
    public static function addCreditCardTo(int $creditCardNumber, String $monthAndYear)
    {
        $params = [];
        $query = "";

        if (!CreditCardDAO::existsCreditCardNumber($creditCardNumber)) {
            $query = "insert into creditcardinfo(company, expirationDate, number) 
            values(:company, :expirationDate, :number)";

            $sixFirstcreditCardNumber = (int)($creditCardNumber / 10000000000);

            if ($sixFirstcreditCardNumber < 500000 && $sixFirstcreditCardNumber >= 400000)
                $company = 'Visa';

            else if ($sixFirstcreditCardNumber < 550000 && $sixFirstcreditCardNumber >= 510000)
                $company = 'Mastercard';

            else
                throw new ArrayException('Error processing request', array('Unsupported card issuer'));

            $monthAndYear = date('Y-m-d', strtotime($monthAndYear));

            $params['company'] = $company;
            $params['expirationDate'] = $monthAndYear;
            $params['number'] = $creditCardNumber;
        }

        try {
            $conection = Connection::GetInstance();
            $response = $conection->ExecuteNonQuery($query, $params);
        } catch (PDOException $th) {
            throw $th;
        }

        if ($response != null && isset($response[0]))
            return $response[0];
    }

    public static function existsCreditCardNumber(int $number)
    {
        try {
            $conection = Connection::GetInstance();
            $query = "select true from creditcardinfo where number = :number";
            $response = $conection->Execute($query, array('number' => $number));
        } catch (PDOException $ex) {
            throw $ex;
        }

        if ($response != null)
            return (sizeof($response) > 0) ? true : false;

        return false;
    }
}
