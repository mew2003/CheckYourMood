<?php
namespace controllers;

use yasmf\View;

class HomeController {

    public function index() {
        session_start();
        $view = new View("CheckYourMood/codeCYM/views/index");
        return $view;
    }

}