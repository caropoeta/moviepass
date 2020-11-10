<?php

namespace DAO;

use Models\CreditCard;
use Models\Exceptions\ArrayException;
use PDOException;

class UserXCreditCardDAO
{
    public static function getCreditCardIdFromNumber(int $number, int $usId)
    {
        try {
            $conection = Connection::GetInstance();
            $query = "select usersxcreditcardinfo.id from creditcardinfo 
            inner join usersxcreditcardinfo on creditcardinfo.id = usersxcreditcardinfo.creditCardId
            where number = :number
            and usersxcreditcardinfo.userid = :usId";
            $response = $conection->Execute($query, array('number' => $number, 'usId' => $usId));
        } catch (PDOException $ex) {
            throw $ex;
        }

        if ($response != null)
            return $response[0]['id'];

        return null;
    }

    public static function getCreditCardsFromUser(int $id)
    {
        $query = "
        select creditcardinfo.*
        from usersXcreditCardInfo 
        inner join creditcardinfo
        on creditcardinfo.id = usersXcreditCardInfo.creditCardId
        where userid = :user_id
        and usersXcreditCardInfo.deleted = 0
        group by creditcardinfo.number
        ";

        $params = [];
        $params['user_id'] = $id;

        try {
            $conection = Connection::GetInstance();
            $response = $conection->Execute($query, $params);
        } catch (PDOException $th) {
            throw $th;
        }

        $creditCardArray = array_map(function (array $obj) {
            return CreditCard::fromArray($obj);
        }, $response);

        return $creditCardArray;
    }

    public static function addCreditCardToUser(int $userId, int $creditCardNumber, String $monthAndYear)
    {
        $params = [];
        $query = "";

        if (!CreditCardDAO::existsCreditCardNumber($creditCardNumber))
            CreditCardDAO::addCreditCardTo($creditCardNumber, $monthAndYear);

        if (UserXCreditCardDAO::existsCreditCardNumberOnUser($creditCardNumber, $userId)) {
            $query = "update usersXcreditCardInfo set deleted = 0
                where creditCardId = (select id from creditcardinfo where number = :number)
                and userid = :user_id";

            $params['number'] = $creditCardNumber;
            $params['user_id'] = $userId;
        } else {
            $query = "insert into usersXcreditCardInfo(creditCardId, userid, deleted) 
                select id, :user_id, 0 from creditcardinfo where number = :number";

            $params['number'] = $creditCardNumber;
            $params['user_id'] = $userId;
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

    public static function existsCreditCardNumberOnUser(int $number, int $userId)
    {
        try {
            $conection = Connection::GetInstance();
            $query = "
            select true
            from usersXcreditCardInfo 
            where creditCardId = (select id from creditcardinfo where number = :number)
            and userid = :userId
            ;";
            $response = $conection->Execute($query, array('number' => $number, 'userId' => $userId));
        } catch (PDOException $ex) {
            throw $ex;
        }

        if ($response != null)
            return (sizeof($response) > 0) ? true : false;

        return false;
    }

    public static function delete(int $creditCardNumber, int $userId)
    {
        $query = "update usersXcreditCardInfo set deleted = 1 
        where creditCardId = (select id from creditcardinfo where number = :creditCardNumber) and userid = :userId";
        $params['creditCardNumber'] = $creditCardNumber;
        $params['userId'] = $userId;

        try {
            $conection = Connection::GetInstance();
            $conection->ExecuteNonQuery($query, $params);
        } catch (PDOException $th) {
            throw $th;
        }
    }
}
