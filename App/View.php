<?php

require_once 'Configuration.php';

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
        $file = "View/";
        if ($controller != "") {
            $file = $file . $controller . "/";
        }
        $this->file = $file . $action . ".php";
        $this->controller = strtolower($controller);
        $this->request = $request;
        $this->createMainMenu();
    }

    //genrates et shows the view
    public function generate($data) {
        //specific part of the view
        $content = $this->generateFile($this->file, $data);
        //get the web root of the site
        $webRoot = Configuration::getSetting("webRoot", "/");
        $mainMenu = $this->createMainMenu();
        //generates the template with the specific part of the view
        $view = $this->generateFile('View/template.php', array('title' => $this->title, 'content_for_layout' => $content,
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

    //create the menu according to name of the controller
    private function createMainMenu() {
        //array of the possible main menus
        $menus = array(
            array(
                'name' => 'accueil',
                'link' => 'accueil',
                'text' => 'Accueil',
                'admin' => false
            ),
            array(
                'name' => 'chapitre',
                'link' => 'chapitre/index/1',
                'text' => 'Le livre',
                'admin' => false
            ),
            array(
                'name' => 'bio',
                'link' => 'bio',
                'text' => 'Bio',
                'admin' => false
            ),
            array(
                'name' => 'admin',
                'link' => 'admin',
                'text' => 'Admin',
                'admin' => true
            ),
            array(
                'name' => 'connexion',
                'link' => 'connexion',
                'text' => 'Connexion',
                'admin' => false
            )
        );
        //create the main menu
        $main_menu = "";
        for ($row = 0; $row < count($menus); $row++) {
            //chamgement du menu connexion
            if (($menus[$row]['name'] == 'connexion') && ($this->request->getSession()->parameterExists("idUser"))) {
                $menus[$row]['link'] = 'connexion/deconnecter';
                $menus[$row]['text'] = "Déconnexion";
            } elseif (($menus[$row]['name'] == 'connexion')) {
                $menus[$row]['link'] = 'connexion';
                $menus[$row]['text'] = "Connexion";
            }
            if ($this->request->getSession()->parameterExists("idUser") == $menus[$row]['admin']) {
                $main_menu .= '<li';
                if ($this->controller == $menus[$row]['name']) {
                    $main_menu .= ' class="current"';
                }
                $main_menu .= '><a href="' . $menus[$row]['link'] . '">' . $menus[$row]['text'] . '</a></li>' . PHP_EOL;
            } else if ($menus[$row]['admin'] == false) {
                $main_menu .= '<li';
                if ($this->controller == $menus[$row]['name']) {
                    $main_menu .= ' class="current"';
                }
                $main_menu .= '><a href="' . $menus[$row]['link'] . '">' . $menus[$row]['text'] . '</a></li>' . PHP_EOL;
            }
        }
        return $main_menu;
    }

    //cleans up html input
    private function sanitizeHtml($value) {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
    }

}
