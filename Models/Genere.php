<?php
    namespace Models;
    class Genere{
        private $id;
        private $description;

        public function __construct(){
            
        }
        public function getId(){
            return $this->id;
        }
        public function setId($id){
            $this->id=$id;
        }
        public function getDescription(){
            return $this->description;
        }
        public function setDescription($description){
            $this->description=$description;
        }
    }
?>