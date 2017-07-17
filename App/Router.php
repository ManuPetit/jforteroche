<?php

require_once 'Request.php';
require_once 'View.php';

class Router {

    private $request;

    //routing of a request
    public function RouterRequest() {
        try {
            //merge parametres from both GET and POST
            if (isset($_GET['params']) && $_GET['params'] != '') {
                $params = array();
                $params = $this->parseParameters($_GET['params']);
                $request = new Request(array_merge($_GET, $params));
            } else {
                $request = new Request(array_merge($_GET, $_POST));
            }
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

    //show an error or just a message depending if the site is live or not
    private function showError(Exception $exception) {
        $view = new View($this->request, "erreur");
        if (Configuration::getSetting('live')) {
            date_default_timezone_set('Europe/Paris');
            $msg = "*******************" . "\n" . "** " . date('Y-m-d H:i:s') . "\n";
            $msg .= "*******************" . "\n";
            $msg .= "** Error in the script '" . $exception->getFile() . "' on line " . $exception->getLine() . " :" . "\n";
            $msg .= $exception->getMessage() . "\n";
            $msg .= "\n" . "----------------------------------------------------------------------------" . "\n";
            error_log($msg, 3, "logs/jforterr.log");
            $view->generate(array('errorMsg' => 'Si celle-ci se reproduit, veuillez contacter l\'administrateur du site.'));
        } else {
            $msg = "An error has occured in the script <span class=\"error\">" . $exception->getFile() . "</span> on";
            $msg .= " line " . $exception->getLine() . " :<br /><pre>";
            $msg .= $exception->getMessage() . "</pre>";
            $view->generate(array('errorMsg' => $msg));
        }
    }

    //Parse parameters
    private function parseParameters($params) {
        try {
            $allParams = array();
            $allParams = explode('/', filter_var(rtrim($params, '/')), FILTER_SANITIZE_URL);
            $endParams = array();
            for ($i = 0; $i < count($allParams); $i += 2) {
                $endParams[$allParams[$i]] = $allParams[$i + 1];
            }
            return $endParams;
        } catch (Exception $ex) {
            throw new Exception($ex);
        }
    }

}
