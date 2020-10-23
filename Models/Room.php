<?php
    namespace Models;
    class Room{
        private $id;
        private $name;
        private $capacity; 
        private $cinema;
        
        
        public function setId($id){
            $this->id=$id;
        }

        public function getId(){
            return $this->id;
        }
        
        public function setName($name){
            $this->name=$name;
        }

        public function getName(){
            return $this->name;
        }

        public function setCapacity($capacity){
            $this->capacity=$capacity;
        }

        public function getCapacity(){
            return $this->capacity;
        }

        public function setCinema($cinema){
            $this->cinema=$cinema;
        }

        public function getCinema(){
            return $this->cinema;
        }

        

    }