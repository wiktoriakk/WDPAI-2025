<?php

require_once 'AppController.php';

class SecurityController extends AppController {

    public function login() {
        //TODO get data from login form
        // check if user is in Database
        // redner dashboard after succesfull authentication


        return $this->render("login", ["message" => "Hasło błedne"]);
    }

    public function register() {
        return $this->render("register");
    }
}