<?php

namespace Models;

class PopupAlert
{
    private $alerts;
    private $usesKey;

    public function __construct(array $alerts_ = [], bool $usesKey = false)
    {
        $this->alerts = $alerts_;
    }

    public function Show()
    {
        echo '<script>alert("';

        if (!$this->usesKey) {
            foreach ($this->alerts as $key => $value) {
                echo $value . '\n';
            }
        } 
        
        else {
            foreach ($this->alerts as $key => $value) {
                echo $key . ' ' . $value . '\n';
            }
        }

        echo '")</script>';
    }
}
