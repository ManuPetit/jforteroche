<?php

require_once 'App/Controller.php';
require_once 'App/Forms.php';
require_once 'Models/Utilisateur.php';

class ControllerConnexion extends Controller {

    private $user;

    public function __construct() {
        $this->user = new Utilisateur();
    }

    /**
     * Default action
     * It shows the login form
     */
    public function index() {
        $forms = new Forms();
        $this->generateView(array(
            'forms' => $forms,
            'value' => null,
            'errors' => null
        ));
    }

    /**
     * Check if a user can connect to the admin, then if he can
     * sets the user credential in the session and show the admin page
     * 
     * @throws Exception
     */
    public function connecter() {
        try {
            if ($this->request->parameterExists('login') && $this->request->parameterExists('password')) {
                $login = $this->request->getParameter('login');
                $mdp = $this->request->getParameter('password');
                if ($this->user->canLogin($login, $mdp)) {
                    $this->user->getUserDetails($login, $mdp);
                    $this->request->getSession()->addParameter('idUser', $this->user->getId());
                    $this->request->getSession()->addParameter('login', $this->user->getLogin());
                    $this->request->getSession()->addParameter('userName', $this->user->getFullName());
                    $this->request->getSession()->addParameter('lastLogin', $this->user->getDateLastLogin());
                    $this->user->updateLastLogin($this->user->getId());
                    $this->redirect("admin");
                } else {
                    $forms = new Forms();
                    $value['login'] = $login;
                    $errors['err_login'] = "nom de login ou mot de passe incorrect";
                    $this->generateView(array(
                        'forms' => $forms,
                        'value' => $value,
                        'errors' => $errors
                            ), "index");
                }
            } else {
                throw new Exception("Action impossible : login ou mot de passe non défini");
            }
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }

    /**
     * Logout user and redirect to welcome page
     */
    public function deconnecter() {
        $this->request->getSession()->endSession();
        $this->redirect("accueil");
    }

}
