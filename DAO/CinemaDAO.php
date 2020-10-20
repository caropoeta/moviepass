<?php

namespace DAO;

use Models\Cinema as Cinema;

class CinemaDAO
{
    private $cinemaList = array();
    private $fileName;

    public function __construct()
    {
        $this->fileName =  ROOT . DATA_PATH . "cinemas.json";
    }

    public function GetAll()
    {

        $this->RetrieveData();
        return $this->cinemaList;
    }


    public function Add($cinemaToAdd){
        $this->RetrieveData();
        array_push($this->cinemaList,$cinemaToAdd);
        $this->SaveData();
    }

    private function RetrieveData()
    {
        $this->cinemaList = array();

        if (file_exists($this->fileName)) {
            $jsonContent = file_get_contents($this->fileName);
            $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach ($arrayToDecode as $oneCinema) {
                $cinema = new Cinema();
                $cinema->setName($oneCinema["name"]);
                $cinema->setAdress($oneCinema["adress"]);
                $cinema->setOpeningTime($oneCinema["openingTime"]);
                $cinema->setClosingTime($oneCinema["closingTime"]);
                $cinema->setTicketValue($oneCinema["ticketValue"]);
                $cinema->setCapacity($oneCinema["capacity"]);
                $cinema->setId($oneCinema["id"]);
                $cinema->setDelete($oneCinema["delete"]);

                array_push($this->cinemaList, $cinema);
            }
        }
    }

    public function Remove($cinemaId)
    {//Borrado logico
       $this->RetrieveData();
       $removed=false;

       foreach ($this->cinemaList as $cinema) {
        if($cinema->getId()==$cinemaId){
            $cinema->setDelete(true);
            $removed=true;
        }
    }
    $this->SaveData();
    return $removed;
}
        //Borrado Fisico
        /*
        $this->RetrieveData();
        $cinemaListResult= array();
        $removed=false;
        foreach ($this->cinemaList as $cinema) {
            if(strcmp($cinema->getName(),$cinemaRemove)!==0){
                array_push($cinemaListResult,$cinema);
            }else{

                $removed=true;
            }
        }
    
        $this->cinemaList=$cinemaListResult;
        $this->SaveData();

    
        return $removed;
        
    }
    */
    public function Update(Cinema $cinemaToUpdate)
    {

        $cinemaList = $this->RetrieveData();

        foreach ($this->cinemaList as $cinema) {
            if($cinemaToUpdate->getId()==$cinema->getId()){
                $cinema->setName($cinemaToUpdate->getName());
                $cinema->setAdress($cinemaToUpdate->getAdress());
                $cinema->setOpeningTime($cinemaToUpdate->getOpeningTime());
                $cinema->setClosingTime($cinemaToUpdate->getClosingTime());
                $cinema->setTicketValue($cinemaToUpdate->getTicketValue());
                $cinema->setCapacity($cinemaToUpdate->getCapacity());


            }
        }
        $this->SaveData($cinemaList);
    }

    public function SaveData()
    {
        $arrayToEncode = array();

        foreach ($this->cinemaList as $cinema) {
            $valuesArray = array();
            $valuesArray["name"] = $cinema->getName();
            $valuesArray["adress"] = $cinema->getAdress();
            $valuesArray["openingTime"] = $cinema->getOpeningTime();
            $valuesArray["closingTime"] = $cinema->getClosingTime();
            $valuesArray["ticketValue"] = $cinema->getTicketValue();
            $valuesArray["capacity"]=$cinema->getCapacity();
            $valuesArray["id"] = $cinema->getId();
            $valuesArray["delete"]=$cinema->getDelete();
            array_push($arrayToEncode, $valuesArray);
        }

        $fileContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

        if (file_exists($this->fileName))
            file_put_contents($this->fileName, $fileContent);
    }


    public function AddAll($cinemas)
    {
        $this->RetrieveData();
        $this->cinemaList = array_replace($this->cinemaList, $cinemas);
        $this->saveData();
    }

}



