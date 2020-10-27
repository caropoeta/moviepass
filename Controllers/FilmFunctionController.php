<?php
namespace Controllers;

use DAO\FunctionDBDAO as FunctionDBDAO;
use Models\FilmFunction as FilmFunction;
use Models\PopupAlert;
use DAO\Session;

class FilmFunctionController
{
    private $FunctionDBDAO;
    public function __construct()
    {
        Session::ValidateSession();
        $this->FunctionDBDAO = new FunctionDBDAO();


    }

    public function Index()
    {

        require_once(VIEWS_PATH . 'functionList.php');
    }

    public function List($roomId, $msg = ""){

        $lista = $this->FunctionDBDAO->readAllByRoom($roomId);
        if($lista==false){
            $message = "There aren't loaded function in this room";
        }
        include_once(VIEWS_PATH."functionList.php");
    }


    public function AddFunction($daysOfWeek,$startFunction,$assistance,$idRoom)
    { 
        require_once(VIEWS_PATH . 'navbaradmin.php');

        $functionList = $this->FunctionDBDAO->readAllByRoom($idRoom);

        $idMax=1;
        if($functionList!=false){
            foreach ($functionList as $oneFunction) {

                if($oneFunction->getidMovieFunction()>$idMax){
                    $idMax=$oneFunction->getidMovieFunction();
                }
            }
        }
        $newId=$idMax+1;
        $errorMessage="";
        $hasError=false;
        if($assistance<=0){
            $hasError=true;
            $errorMessage= $errorMessage . "The assistance cannot be zero" . '\n';
        }
        $daysSelected="";
        $count=0;
        foreach ($daysOfWeek as $day) {
            if($count==0){
                $daysSelected= $day;
            }else{
                $daysSelected=$daysSelected . "," . $day;
            }
            $count++;
        }
            //agregar validacion de hora

        if($hasError == false){
            $filmFunction = new FilmFunction();
            $filmFunction->setIdRoom($idRoom);
            $filmFunction->setIdMovie("1");
            $filmFunction->setStartFunction($startFunction);
            $filmFunction->setAssistance($assistance);
            $filmFunction->setDeleteFunction(0);
            $filmFunction->setDaysOfWeek($daysSelected);

            $this->FunctionDBDAO->AddFunction($filmFunction);
            $functionList =  $this->FunctionDBDAO->readAllByRoom($idRoom);
            $idMax=1; }
            else {
                $popupAlert=new PopupAlert(["Error:", $errorMessage]);
                $popupAlert->Show();
            }

            //$this->List($idRoom);
        }

    }