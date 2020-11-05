<?php

namespace Models;

use Exception;

class Statistics
{

    private $ticketsSold;

    private $unsoldTickets;

    private $revenue;

    private $cinemaName;
    
    private $startDate;
    
    private $finishDate;
    
    public function getTicketsSold()
    {
        return $this->ticketsSold;
    }

    public function setTicketsSold($ticketsSold)
    {
        $this->ticketsSold = $ticketsSold;
    }

    public function getUnsoldTickets()
    {
        return $this->unsoldTickets;
    }

    public function setUnsoldTickets($unsoldTickets)
    {
        $this->unsoldTickets = $unsoldTickets;
    }

    public function getRevenue()
    {
        return $this->revenue;
    }

    public function setRevenue($revenue)
    {
        $this->revenue = $revenue;
    }

    public function getCinemaName()
    {
        return $this->cinemaName;
    }

    public function setCinemaName($cinemaName)
    {
        $this->cinemaName = $cinemaName;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

 
    public function getFinishDate()
    {
        return $this->finishDate;
    }

   
    public function setStartDate($starDate)
    {
        $this->startDate = $starDate;
    }

    public function setFinishDate($finishDate)
    {
        $this->finishDate = $finishDate;
    }
 

}
