<?php

require_once 'Configuration.php';
require_once 'Menus.php';

/**
 * 
 *                                                  Main MENU dans generate
 * 
 */
class View {

    //name of the file associated to a view
    private $file;
    //title of the view (as defined in the view file)
    private $title;
    //the name of the controller for preping up the menus
    private $controller;
    //the request object
    private $request;

    //defines the name of the view depending of the action
    public function __construct($request, $action, $controller = "") {
        $file = "Views/";
        if ($controller != "") {
            $file = $file . $controller . "/";
        }
        $this->file = $file . $action . ".php";
        $this->controller = strtolower($controller);
        $this->request = $request;
    }

    //genrates et shows the view
    public function generate($data) {
        //specific part of the view
        $content = $this->generateFile($this->file, $data);
        //get the web root of the site
        $webRoot = Configuration::getSetting("webRoot", "/");
        $mainMenu = Menus::createMainMenu($this->controller, $this->request);
        //generates the template with the specific part of the view
        $view = $this->generateFile('Views/template.php', array('title' => $this->title, 'content_for_layout' => $content,
            'webRoot' => $webRoot, 'mainMenu' => $mainMenu));
        //send view to browser
        echo $view;
    }

    //generate a view file et send back its content
    private function generateFile($file, $data) {
        if (file_exists($file)) {
            //gets the data ready for the view
            extract($data);
            ob_start();
            require $file;
            return ob_get_clean();
        } else {
            throw new Exception("Fichier '$file' introuvable");
        }
    }

    //cleans up html input
    private function sanitizeHtml($value) {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
    }
    
}
