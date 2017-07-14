<?php

require_once 'App/Controller.php';

abstract class ControllerSecurity extends Controller {
    
    /**
     * Method to check if user is present in session so the action can be done
     * otherwise redirect user to login
     * 
     * @param string $action    Action to be realised
     */
    public function doAction(string $action){
        if ($this->request->getSession()->parameterExists("idUser")){
            parent::doAction($action);
        }else{
            $this->redirect("connexion");
        }
    }
}
