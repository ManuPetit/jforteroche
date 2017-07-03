<?php

class Session {

    //starts a session
    public function __construct() {
        session_start();
    }

    //end a session
    public function endSession() {
        session_destroy();
    }

    //adds a parameter to a session
    public function addParameter($name, $value) {
        $_SESSION[$name] = $value;
    }

    //check if parameter exists in session
    public function parameterExists($name) {
        return (isset($_SESSION[$name]) && $_SESSION != "");
    }

    //gets the value of a parameter
    public function getParameter($name) {
        if ($this->parameterExists($name)) {
            return $_SESSION[$name];
        } else {
            throw new Exception("Paramètre '$name' absent de la session");
        }
    }

}
