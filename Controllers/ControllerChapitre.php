<?php

require_once 'App/Controller.php';
require_once 'App/Forms.php';
require_once 'App/Validation.php';
require_once 'Models/Chapitre.php';
require_once 'Models/Commentaire.php';

/**
 *          Class representing a controller for 'Chapitre'
 */
class ControllerChapitre extends Controller {

    //          Private properties of the 'ControllerChapitre' class
    private $chapter;
    private $comment;

    /**
     * Create a new ControllerChapitre
     */
    public function __construct() {
        $this->chapter = new Chapitre();
        $this->comment = new Commentaire();
    }

    /**
     * Default action of the controller
     * List the chosen chapter and its comments if any
     */
    public function index() {
        $forms = new Forms();
        //check if we have at least one chapter published
        $idChapter = $this->chapter->getFirstPublishedChapterId();
        //check if we have an idea passed by the request
        //and override idChapter
        if ($this->request->parameterExists('id')) {
            $idChapter = $this->request->getParameter('id');
        }
        if (isset($idChapter) && $idChapter != '') {
            $this->chapter->getPublishedChapter($idChapter);
            $menu = $this->chapter->getChapterList();
            $comments = $this->comment->getApprovedCommentsChapter($idChapter);
            $this->generateView(array(
                'menu' => $menu,
                'chapter' => $this->chapter,
                'comments' => $comments,
                'forms' => $forms,
                'value' => null,
                'errors' => null
            ));
        } else {
            $this->generateView(array(
                'menu' => null,
                'chapter' => null,
                'comments' => null,
                'forms' => null,
                'value' => null,
                'errors' => null
            ));
        }
    }

    /**
     * This function adds a main comment and validates it
     */
    public function commenter() {
        $forms = new Forms();
        $idChapter = $this->request->getParameter("id");
        $author = $this->request->getParameter("author");
        $comment = $this->request->getParameter("comment");
        //first we validate the author input
        $validation = new Validation();
        $validation->isRequired('author', $author);
        $validation->isAlphaNumInputOk('author', $author, 3, 80);
        //then we validate the comment and clean it up
        $validation->isRequired('comment', $comment);
        $comment = $validation->cleanUpTextBlock($comment);
        //retrieve errors
        $errors = $validation->getErrors();
        //get the data to either refresh the page or show the page with errors
        $this->chapter->getPublishedChapter($idChapter);
        $menu = $this->chapter->getChapterList();
        $comments = $this->comment->getApprovedCommentsChapter($idChapter);
        if (isset($errors) && $errors != null) {
            //show the index page again with errors
            $value['author'] = $author;
            $value['comment'] = $comment;
            $this->generateView(array(
                'menu' => $menu,
                'chapter' => $this->chapter,
                'comments' => $comments,
                'forms' => $forms,
                'value' => $value,
                'errors' => $errors), 'index');
        } else {
            $this->comment->addComment($idChapter, $author, $comment);
            //$info ="<script>window.alert(\"Votre message a bien été enregistré. Il est en attente de validation.\nMerci.\")</script>";
            $info = "Votre message a bien été enregistré. Il est en attente de validation. Merci.";
            //default action
            $this->generateView(array(
                'menu' => $menu,
                'chapter' => $this->chapter,
                'comments' => $comments,
                'forms' => $forms,
                'value' => null,
                'errors' => null,
                'message' => $info), 'index');
        }
    }

    /**
     * This function signals a comment and hides it (as well as the comments which
     * may be linked to it)
     */
    public function signaler() {
        $idComment = $this->request->getParameter("id");
        $idChapter = $this->comment->signalComment($idComment);
        $this->redirect("chapitre", "index", $idChapter);
    }

}
