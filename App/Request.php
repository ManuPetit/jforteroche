<?php

require_once 'Session.php';

class Request {

    //parameters of the request
    private $parameters;
    //session of the request
    private $session;


    public function __construct($parameters) {
        $this->parameters = $parameters;
        $this->session = new Session();
    }
    
    //return true if the parameter exist in request
    public function parameterExists($name){
        return (isset($this->parameters[$name]) && $this->parameters[$name] != '');
    }
    
    //send back the value of the parameter or throw an error
    public function getParameter($name){
        if ($this->parameterExists($name)) {
            return $this->parameters[$name];
        }else {
            throw new Exception("Paramètre '$nom' absent de la requête");
        }
    }
    
    //returns the session object associated to the request
    public function getSession() {
        return $this->session;
    }
}

