<?php

require_once 'Request.php';
require_once 'View.php';

class Router {

    private $request;

    //routing of a request
    public function RouterRequest() {
        try {
            //merge parametres from both GET and POST
            $request = new Request(array_merge($_GET, $_POST));
            $this->request = $request;
            $controller = $this->createController($request);
            $action = $this->createAction($request);
            $controller->doAction($action);
        } catch (Exception $ex) {
            $this->showError($ex);
        }
    }

    //create appropriate controller depending of the request
    private function createController(Request $request) {
        //default controller
        $controller = "Accueil";
        if ($request->parameterExists('controleur')) {
            $controller = $request->getParameter('controleur');
            //upercase first letter
            $controller = ucfirst(strtolower($controller));
        }
        //creating the name of the file
        $controllerClass = "Controller" . $controller;
        $controllerFile = "Controllers/" . $controllerClass . ".php";
        if (file_exists($controllerFile)) {
            require($controllerFile);
            $controller = new $controllerClass();
            $controller->setRequest($request);
            return $controller;
        } else {
            throw new Exception("Fichier '$controllerFile' introuvable");
        }
    }

    //create appropriate action according to request
    private function createAction(Request $request) {
        //default action
        $action = "index";
        if ($request->parameterExists('action')) {
            $action = $request->getParameter('action');
        }
        return $action;
    }

    //show an error
    private function showError(Exception $exception) {
        $view = new View($this->request, "erreur");
        $view->generate(array('errorMsg' => $exception->getMessage()));
    }

}
