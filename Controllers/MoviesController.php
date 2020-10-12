<?php

namespace Controllers;

class MoviesController
{
    public function Index()
    {
        HomeController::MainPage();
    }
    
    public function List()
    {

    }

    public function Delete(int $id)
    {

    }

    public function Add(int $id)
    {
        var_dump($id);
    }
}
