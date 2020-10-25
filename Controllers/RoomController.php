<?php

namespace Controllers;

use Models\Room as Room;
use Models\Cinema as Cinema;
use DAO\RoomDAO as RoomDAO;
use Models\PopupAlert;


    class RoomController
    {
        private $roomDBDAO;

        public function __construct()
        {
            $this->roomDBDAO = new Room();
            $this->cinemaDBDAO = new Cinema();
            //$this->movieFunctionDBDAO = new MovieFunction();
        }

        public function ShowAddView($cinemaId)
        {   
            require_once(VIEWS_PATH."roomAdd.php");
        }


        public function List($cinemaId,$message = ""){
            $lista = false; //$this->roomDAO->readAllByCinema($cinemaId);   FUNNCION DE VICKI
            if($lista==false){
                $message = "No hay salas cargadas en este cine";
            }
            //$cineId = $cinemaId;
            include_once(VIEWS_PATH."roomList.php");
        }

        public function Add($name,$capacity,$price,$cinemaId)
        {
            $room = new Room();
            $room->setName($name);
            $room->setCapacity($capacity);
            $room->setPrice($price);
            $cinema = $this->cinemaDAO->read($cinemaId);
            $room->setCinema($cinema);
            if(!$this->roomDAO->existsByName($room)){   
                $result=$this->roomDAO->Add($room); 
                $this->List($cinemaId,"Se añadió la sala correctamente");
            }else{
                $this->List($cinemaId,"El nombre de la sala ya existe en este cine");
            }               
        }

        public function Remove($id,$cinemaId)
        {
            
            $response = $this->movieFunctionDAO->functionsExistsInRoom($id);
            
            if($response !=false){
                $this->List($cinemaId,"No se puede eliminar la sala porque tiene funciones cargadas");

            }else{
                $this->roomDAO->Remove($id);

                $this->List($cinemaId,"La sala fue eliminada con exito");
            }
            
        }

        public function ShowUpdateRoom($id){
            $room = $this->roomDAO->read($id);
            include_once(VIEWS_PATH."roomUpdate.php");
        }

        public function Update($name,$capacity,$price,$roomId,$cinemaId)
        {
            $room = new Room();
            $room->setName($name);
            $room->setCapacity($capacity);
            $room->setPrice($price);
            $room->setId($roomId);
            $this->roomDAO->Update($room);
            $this->List($cinemaId,"La sala se actualizó correctamente");
        }
    } 
?>