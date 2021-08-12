<?php

namespace App\Controllers;


class MainController extends CoreController
{
    /**
     * 
     * @return void
     * 
     */
    public function home()
    {
        $this->show('main/home');
    }
}
