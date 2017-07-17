<?php

require_once 'App/Controller.php';

/**
 *          Class representing a controller for 'Bio'
 */
class ControllerBio extends Controller {
    /*
     * Create a new ControllerBio
     */

    public function __construct() {
        
    }

    /**
     * Default action of the controller
     * Nothing is done as it is a static page
     */
    public function index() {
        $this->generateView();
    }

}
