<?php

require_once 'App/Controller.php';
require_once 'Models/Chapitre.php';

/**
 *          Class representing a controller for 'Accueil'
 */
class ControllerAccueil extends Controller {

    //          Private properties of the 'ControllerChapitre' class
    private $chapter;

    /**
     * Create a new ControllerAccueil
     */
    public function __construct() {
        $this->chapter = new Chapitre();
    }

    /**
     * Default action of the controller
     * Show the home page with the last 3 published chapters
     */
    public function index() {
        $lastChapters = array();
        $lastChapters = $this->chapter->getLastPublishedChapters();
        $this->generateView(array('lastChapters' => $lastChapters));
    }

}
