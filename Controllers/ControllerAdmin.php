<?php

require_once 'ControllerSecurity.php';
require_once 'App/Forms.php';
require_once 'App/Menus.php';
require_once 'App/Validation.php';
require_once 'Models/Chapitre.php';
require_once 'Models/Commentaire.php';
require_once 'Models/Utilisateur.php';

/**
 *          Class representing a controller for 'Admin'
 */
class ControllerAdmin extends ControllerSecurity {

    //          Private properties of the 'ControllerChapitre' class
    private $chapter;
    private $comment;
    private $user;

    /**
     *  Create a new ControllerAdmin
     */
    public function __construct() {
        $this->chapter = new Chapitre();
        $this->comment = new Commentaire();
        $this->user = new Utilisateur();
    }

    /**
     * default action
     * Shows basic info about the web site
     */
    public function index() {
        $forms = new Forms();
        $adminMenu = Menus::createAdminMenu('index');
        $chapDetails = array();
        $chapDetails = $this->chapter->getTotalChapterDetail();
        $comDetails = $this->comment->getTotalCommentDetail();
        $userName = $this->request->getSession()->getParameter('userName');
        $lastLogin = $this->request->getSession()->getParameter('lastLogin');
        $this->generateView(array(
            'adminMenu' => $adminMenu,
            'userName' => $userName,
            'lastLogin' => $lastLogin,
            'forms' => $forms,
            'chapDetails' => $chapDetails,
            'comDetails' => $comDetails
        ));
    }

    /**
     * This shows a table of all not deleted chapters
     * and provide quick direct actions to them
     */
    public function episodes() {
        $forms = new Forms();
        $adminMenu = Menus::createAdminMenu('episode');
        //retrieve the selected option
        $option = ($this->request->parameterExists('types')) ? $this->request->getParameter('types') : 0;
        $allChapters = array();
        $allChapters = $this->chapter->getAllChapters($option);
        $total = $this->chapter->getTotalChapter();
        $this->generateView(array(
            'adminMenu' => $adminMenu,
            'forms' => $forms,
            'option' => $option,
            'allChapters' => $allChapters,
            'totalChapter' => $total
        ));
    }

    /**
     * This shows a table of all messages on the system (not deleted)
     * it provides quick action access and a filter
     */
    public function messages() {
        $forms = new Forms();
        //number of comment shown a one time
        $display = 10;
        $adminMenu = Menus::createAdminMenu('message');
        //retrieve the selected item from the list
        $option = ($this->request->parameterExists('approval')) ? $this->request->getParameter('approval') : 0;
        //retrieve the previous option selected
        $prevoption = ($this->request->parameterExists('prevoption')) ? $this->request->getParameter('prevoption') : 0;
        //check if we know how many pages there are (for pagination)
        $pages = ($this->request->parameterExists('pages')) ? $this->request->getParameter('pages') : 0;
        //check to see at what page we start
        $start = ($this->request->parameterExists('start')) ? $this->request->getParameter('start') : 0;
        //we check that the option choosen is different from the previous one to restart the count of pages and 
        //start page, as well as the prevoption
        if ($option != $prevoption) {
            $pages = 0;
            $start = 0;
            $prevoption = $option;
        }
        $allComments = array();
        $total = $this->comment->getTotalComments($option);
        if ($pages == 0) {
            if ($total > $display) {
                $pages = ceil($total / $display);
            } else {
                $pages = 1;
            }
        }
        //retrieve the start of the query
        $allComments = $this->comment->getAllComments($option, $start, $display);
        $this->generateView(array(
            'adminMenu' => $adminMenu,
            'forms' => $forms,
            'option' => $option,
            'start' => $start,
            'pages' => $pages,
            'display' => $display,
            'allComments' => $allComments,
            'totalComment' => $total,
            'prevoption' => $prevoption
        ));
    }

    /**
     * This shows the page to enter a new chapter
     */
    public function creer() {
        $forms = new Forms();
        $adminMenu = Menus::createAdminMenu('creer');
        $this->generateView(array(
            'adminMenu' => $adminMenu,
            'forms' => $forms,
            'option' => null,
            'value' => null,
            'errors' => null,
            'message' => null
        ));
    }

    public function enregistrer() {
        $forms = new Forms();
        $title = ($this->request->parameterExists('title')) ? $this->request->getParameter('title') : '';
        $episode = ($this->request->parameterExists('episode')) ? $this->request->getParameter('episode') : '';
        $option = ($this->request->parameterExists('state')) ? $this->request->getParameter('state') : 1;
        $adminMenu = Menus::createAdminMenu('creer');
        //validation of the data
        $validation = new Validation();
        //validate the title
        $validation->isRequired('title', $title);
        $title = $validation->cleanUpText('title', $title, 3, 255);
        //validate the content
        $validation->isRequired('episode', $episode);
        $content = $validation->cleanUpTinyMce($episode);
        //retrieve the errors
        $errors = $validation->getErrors();
        if (isset($errors) && $errors != null) {
            $value['title'] = $title;
            $value['episode'] = $content;
            $this->generateView(array(
                'adminMenu' => $adminMenu,
                'forms' => $forms,
                'option' => $option,
                'value' => $value,
                'errors' => $errors,
                'message' => null
                    ), 'creer');
        } else {
            //save the new chapter
            $this->chapter->saveNewChapter($title, $content, $option, $this->request->getSession()->getParameter('idUser'));
            $message = 'Cet épisode a bien été enregistrer.';
            $this->generateView(array(
                'adminMenu' => $adminMenu,
                'forms' => $forms,
                'option' => null,
                'value' => null,
                'errors' => null,
                'message' => $message
                    ), 'creer');
        }
    }

    /**
     * Method to update a chapter
     */
    public function miseajour() {
        $forms = new Forms();
        $title = ($this->request->parameterExists('title')) ? $this->request->getParameter('title') : '';
        $episode = ($this->request->parameterExists('episode')) ? $this->request->getParameter('episode') : '';
        $option = ($this->request->parameterExists('state')) ? $this->request->getParameter('state') : 1;
        $id = $this->request->getParameter('id');
        //validation of the data
        $validation = new Validation();
        //validate the title
        $validation->isRequired('title', $title);
        $title = $validation->cleanUpText('title', $title, 3, 255);
        //validate the content
        $validation->isRequired('episode', $episode);
        $content = $validation->cleanUpTinyMce($episode);
        //retrieve the errors
        $errors = $validation->getErrors();
        if (isset($errors) && $errors != null) {
            $adminMenu = Menus::createAdminMenu('modifier');
            $value['title'] = $title;
            $value['episode'] = $content;
            $value['id'] = $id;
            $this->generateView(array(
                'adminMenu' => $adminMenu,
                'forms' => $forms,
                'option' => $option,
                'value' => $value,
                'errors' => $errors,
                'message' => null
                    ), 'modifier');
        } else {
            //update the chapter
            $this->chapter->updateChapter($id, $title, $content, $option);
            $message = 'Cet épisode a bien été mis à jour';
            $adminMenu = Menus::createAdminMenu('episode');
            $option = ($this->request->parameterExists('types')) ? $this->request->getParameter('types') : 0;
            $allChapters = array();
            $allChapters = $this->chapter->getAllChapters($option);
            $total = $this->chapter->getTotalChapter();
            $this->generateView(array(
                'adminMenu' => $adminMenu,
                'forms' => $forms,
                'option' => $option,
                'allChapters' => $allChapters,
                'totalChapter' => $total,
                'message' => $message
                    ), 'episodes');
        }
    }

    /**
     * Method to change a chapter to edit mode
     */
    public function editer() {
        $idChapter = $this->request->getParameter('id');
        $this->chapter->updateState($idChapter, 1);
        $this->redirect('admin', 'episodes');
    }

    /**
     * method to publish a chapter
     */
    public function publier() {
        $idChapter = $this->request->getParameter('id');
        $this->chapter->updateState($idChapter, 2);
        $this->redirect('admin', 'episodes');
    }

    /**
     * Method to delete a chapter
     */
    public function effacer() {
        $idChapter = $this->request->getParameter('id');
        $this->chapter->updateState($idChapter, 3);
        $this->redirect('admin', 'episodes');
    }

    /**
     * method to modify a chapter
     */
    public function modifier() {
        $forms = new Forms();
        $adminMenu = Menus::createAdminMenu('modifier');
        //verifier que l'on a un id a modifier
        if ($this->request->parameterExists('id')) {
            $idChapter = $this->request->getParameter('id');
            $this->chapter->getChapter($idChapter);
            $option = $this->chapter->getIdState();
            $value['title'] = $this->chapter->getTitle();
            $value['episode'] = $this->chapter->getContent();
            $value['id'] = $this->chapter->getId();
            $this->generateView(array(
                'adminMenu' => $adminMenu,
                'forms' => $forms,
                'option' => $option,
                'value' => $value,
                'errors' => null,
                'message' => null
            ));
        } else {
            $chapters = array();
            $chapters = $this->chapter->getAllChapters(0);
            $this->generateView(array(
                'adminMenu' => $adminMenu,
                'chapters' => $chapters
                    ), 'modifierchoix');
        }
    }

    /**
     * Method to validate a comment
     */
    public function valider() {
        $idComment = $this->request->getParameter('id');
        $this->comment->validateComment($idComment);
        $this->redirect('admin', 'messages');
    }

    /**
     * method to hide a comment
     */
    public function masquer() {
        $idComment = $this->request->getParameter('id');
        $this->comment->hideComment($idComment);
        $this->redirect('admin', 'messages');
    }

    /*
     * method to delete a comment
     */

    public function supprimer() {
        $idComment = $this->request->getParameter('id');
        $this->comment->deleteComment($idComment);
        $this->redirect('admin', 'messages');
    }

    /**
     * shows the profil of the current user
     */
    public function profil() {
        //retrieve the user details with session User ID
        $this->user->getUser($this->request->getSession()->getParameter('idUser'));
        $adminMenu = Menus::createAdminMenu('profil');
        $this->generateView(array(
            'adminMenu' => $adminMenu,
            'user' => $this->user
        ));
    }

    /**
     * shows the page to modify user profil (email and password)
     */
    public function changer() {
        $forms = new Forms();
        //retrieve the user details with session User ID
        $this->user->getUser($this->request->getSession()->getParameter('idUser'));
        $adminMenu = Menus::createAdminMenu('changer');
        $value['email'] = $this->user->getEmail();
        $this->generateView(array(
            'adminMenu' => $adminMenu,
            'forms' => $forms,
            'user' => $this->user,
            'value' => $value,
            'errors' => null
        ));
    }

    /**
     * Method to change email
     */
    public function email() {
        $email = ($this->request->parameterExists('email')) ? $this->request->getParameter('email') : '';
        $this->user->getUser($this->request->getSession()->getParameter('idUser'));
        //verification of the input
        $validation = new Validation();
        $validation->isRequired('email', $email);
        $validation->isValidEmail('email', $email);
        //retrieve the errors
        $errors = $validation->getErrors();
        if (isset($errors) && $errors != null) {
            $adminMenu = Menus::createAdminMenu('changer');
            $value['email'] = $email;
            $forms = new Forms();
            $this->generateView(array(
                'adminMenu' => $adminMenu,
                'forms' => $forms,
                'user' => $this->user,
                'value' => $value,
                'errors' => $errors
                    ), 'changer');
        } else {
            $this->user->updateEmail($email);
            $this->user->getUser($this->request->getSession()->getParameter('idUser'));
            $message = 'Votre email a bien été mis à jour.';
            $adminMenu = Menus::createAdminMenu('profil');
            $this->generateView(array(
                'adminMenu' => $adminMenu,
                'user' => $this->user,
                'message' => $message
                    ), 'profil');
        }
    }

    /**
     * method to update password
     */
    public function motdepasse() {
        $passOne = ($this->request->parameterExists('passone')) ? $this->request->getParameter('passone') : '';
        $passTwo = ($this->request->parameterExists('passtwo')) ? $this->request->getParameter('passtwo') : '';
        $this->user->getUser($this->request->getSession()->getParameter('idUser'));
        //validation of the input
        $validation = new Validation();
        $validation->isPasswordChecked('passone', $passOne);
        $validation->isPasswordMatched('passtwo', $passOne, $passTwo);
        //retrieve the errors
        $errors = $validation->getErrors();
        if (isset($errors) && $errors != null) {
            $value['email'] = $this->user->getEmail();
            $value['passone'] = $passOne;
            $value['passtwo'] = $passTwo;
            $adminMenu = Menus::createAdminMenu('changer');
            $forms = new Forms();
            $this->generateView(array(
                'adminMenu' => $adminMenu,
                'forms' => $forms,
                'user' => $this->user,
                'value' => $value,
                'errors' => $errors
                    ), 'changer');
        } else {
            $this->user->updatePassword($passOne);
            $message = 'Votre mot de passe a bien été mis à jour.';
            $adminMenu = Menus::createAdminMenu('profil');
            $this->generateView(array(
                'adminMenu' => $adminMenu,
                'user' => $this->user,
                'message' => $message
                    ), 'profil');
        }
    }

}
