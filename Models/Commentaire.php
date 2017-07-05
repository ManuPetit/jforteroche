<?php

require_once 'App/Model.php';

/**
 *      Class representing a Commentaire object
 */
class Commentaire extends Model {

    //          private properties of the 'Commentaire' object
    private $id;
    private $id_chapter;
    private $id_parent;
    private $user_name;
    private $comment;
    private $id_approval;
    private $date_written;
    //  used for recursiveComments
    private $recursiveComments = [];
    private $level; //level of Comment used in $recursiveComments

    //          Getters and setters
    //  Read only property
    public function getId() {
        return $this->id;
    }

    public function getIdChapter() {
        return $this->id_chapter;
    }

    public function setIdChapter($idChapter) {
        $this->id_chapter = $idChapter;
    }

    public function getIdParent() {
        return $this->id_parent;
    }

    public function setIdParent($idParent) {
        $this->id_parent = $idParent;
    }

    public function getUserName() {
        return $this->user_name;
    }

    public function setUserName($userName) {
        $this->user_name = $userName;
    }
    
    public function getComment(){
        return $this->comment;
    }
    
    public function setComment($comment){
        $this->comment = $comment;
    }
    
    public function getIdApproval(){
        return $this->id_approval;
    }
    
    public function setIdApproval($idApproval){
        $this->id_approval = $idApproval;
    }
    
    //  Read only property
    //  The output date is formatted to french system
    public function getDateWritten(){
        $date = date_create($this->date_written);
        return date_format($date, 'd/m/Y à H:i');
    }
    //  Read only property used for tabbed comments
    public function getLevel(){
        return $this->level;
    }
    
    //          Methods
    /**
     * Methods to retrieve all approved comments for a given chapter
     * 
     * 
     * @param int $idChapter    The ID of chapter 
     * @return array            This is an array of 'Commentaire' object
     *         null             if no comments were found for this chapter 
     */
    public function getApprovedCommentsChapter($idChapter){
        $sql = "SELECT id, id_chapter, id_parent, user_name, comment, id_approval, date_written FROM comments "
                . "WHERE id_chapter = :idChapter AND id_approval = 2 ORDER BY date_written";
        $params = array(':idChapter' => $idChapter);
        $rows = $this->getAll($sql, $params); 
        if (!empty($rows)) {
            //we call a recursive method to order the comment from parents to child
            unset($this->recursiveComments);
            $this->getRecursiveComments($rows, 0);
            return $this->recursiveComments;
        } else {
            return null;
        }
    }
    
    /**
     * This is a recursive method to classify the comments from parent 
     * to child. We had to the array a level which is used in the view
     * to tab the comment.
     * The array updates the $recursiveComments private property.
     * 
     * @param array $array  The array of comment to be classified
     * @param int $parent   The id of the parent
     * @param int $level    The level of the child
     */
    private function getRecursiveComments($array, $parent, $level = 0) {
        foreach ($array as $key => $value){
            if ($value['id_parent'] == $parent){
                $comment = new Commentaire();
                $comment->id = $value['id'];
                $comment->id_chapter = $value['id_chapter'];
                $comment->id_parent = $value['id_parent'];
                $comment->user_name = $value['user_name'];
                $comment->comment = $value['comment'];
                $comment->id_approval = $value['id_approval'];
                $comment->date_written = $value['date_written'];
                $comment->level = $level;
                $this->recursiveComments[] = $comment;
                $this->getRecursiveComments($array, $value['id'], $level+1);
            }
        }
    }
    
    /**
     * Add a new comment in the DB
     * id_approval is set to 1 as a comment needs to be approved by administrator
     * 
     * @param int $idChapter    The ID of the chapter the comment is related to
     * @param string $userName  The name of the person posting the comment
     * @param string $comment   The text of the comment
     * @param int $idParent     The parent id (if a comment is an answer to another one) or
     *                          0 if it is just a comment of the chapter
     */
    public function addComment($idChapter, $userName, $comment, $idParent = 0){
        $sql = "INSERT INTO comments (id_chapter, id_parent, user_name, comment, id_approval, date_written)"
                . " VALUES (:idChapter, :idParent, :userName, :comment, 1, NOW())";
        $params = array(
            ':idChapter' => $idChapter,
            ':idParent' => $idParent,
            'userName' => $userName,
            ':comment' => $comment
        );
        $this->execute($sql, $params);
    }

}
