<?php

namespace Controllers;

use DAO\CinemaDBDAO as CinemaDBDAO;
use DAO\FunctionsDAO;
use Models\Room as Room;
use DAO\RoomDBDAO as RoomDBDAO;
use Models\Functions;
use Models\PopupAlert;


    class RoomController
    {
        private $RoomDBDAO;
        private $CinemaDBDAO;

        public function __construct()
        {
            $this->RoomDBDAO = new RoomDBDAO();
            $this->CinemaDBDAO = new CinemaDBDAO();
            //$this->movieFunctionDBDAO = new MovieFunction();
        }


        public function List($cinemaId, $msg = ""){
            $lista = $this->RoomDBDAO->readAllByCinema($cinemaId);
            if($lista==false){
                $message = "There aren't loaded rooms in this cinema";
            }
            include_once(VIEWS_PATH."roomList.php");
        }

        public function Add($name,$capacity,$price,$cinemaId)
        {
            $room = new Room();
            $room->setName($name);
            $room->setCapacity($capacity);
            $room->setPrice($price);
            $cinema = $this->CinemaDBDAO->read($cinemaId);
            $room->setCinema($cinema);
            if(!$this->RoomDBDAO->existsByName($room)){   
                $result=$this->RoomDBDAO->Add($room); 
                $this->List($cinemaId,"Room added successfully");
            }else{
                $this->List($cinemaId,"Room's name already exists in this cinema");
            }               
        }

        public function Remove($id,$cinemaId)
        {
            if(!empty(FunctionsDAO::getAllFromRoom($id))){
                $ppu = [];
                array_push($ppu, "The room cannot be deleted because it has loaded functions");
                $alert = new PopupAlert($ppu);
                $alert->Show();
            }else
                $this->RoomDBDAO->Remove($id);
            
            $this->List($cinemaId);
        }

        public function ShowUpdateRoom($id){
            $room = $this->RoomDBDAO->read($id);
            include_once(VIEWS_PATH."roomUpdate.php");
        }

        public function Update($name,$capacity,$price,$roomId,$cinemaId)
        {
            $room = new Room();
            $room->setName($name);
            $room->setCapacity($capacity);
            $room->setPrice($price);
            $room->setId($roomId);
            $room->setCinema($cinemaId);
            $this->RoomDBDAO->Update($room);
            $this->List($cinemaId,"The room was successfully updated");
        }
    } 
?>