<?php

require_once 'Request.php';
require_once 'View.php';

abstract class Controller {

    //action
    private $action;
    //request to process
    protected $request;

    //set the entry request
    public function setRequest(Request $request) {
        $this->request = $request;
    }

    //execute the action to do
    public function doAction($action) {
        if (method_exists($this, $action)) {
            $this->action = $action;
            $this->{$this->action}();
        } else {
            $controllerClass = get_class($this);
            throw new Exception("Action '$action' non définie dans la classe $controllerClass");
        }
    }

    //abstract method which is the default action. Force derivated class to implements it
    public abstract function index();

    //prepare the associated view to the current controller
    protected function generateView($viewData = array(), $action = null) {
        $viewAction = $this->action;
        if ($action != null) {
            $viewAction = $action;
        }
        //gets the name of the view from the controller
        $controllerClass = get_class($this);
        $controller = str_replace("Controller", "", $controllerClass);
        $view = new View($this->request, $viewAction, $controller);
        $view->generate($viewData);
    }

    //redirect function can take an id parameter as 
    protected function redirect($controller, $action = null, $id = null) {
        $webRoot = Configuration::getSetting("webRoot", "/");
        if (isset($id) && $id != '') {
            //redirects to the URL webRoot/controller/action/id
            header("Location:" . $webRoot . $controller . "/" . $action . "/" . $id);
        } else {
            //redirects to the URL webRoot/controller/action
            header("Location:" . $webRoot . $controller . "/" . $action);
        }
    }

}
