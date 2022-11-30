<?php
namespace controllers;

use yasmf\View;

class HomeController {

    public function index() {
        $view = new View("CheckYourMood/codeCYM/views/index");
        return $view;
    }

}