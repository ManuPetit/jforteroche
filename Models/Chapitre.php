<?php

require_once 'App/Model.php';

/**
 *      Class representing a Chapter object
 */
class Chapitre extends Model {

    //          private properties of the 'Chapitre' model
    private $id;
    private $title;
    private $content;
    private $id_user;
    private $user_name;
    private $id_state;
    private $date_last_modif;

    //          Getters and setters
    //  Read only property
    public function getId() {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function getIdUser() {
        return $this->id_user;
    }

    public function setIdUser($idUser) {
        $this->id_user = $idUser;
    }

    //  Read only property
    public function getUserName() {
        return $this->user_name;
    }

    public function getIdState() {
        return $this->id_state;
    }

    public function setIdState($idState) {
        $this->id_state = $idState;
    }

    //  Read only property
    //  The output date is formatted to french system
    public function getDateLastModif() {
        $date = date_create($this->date_last_modif);
        return date_format($date, 'd/m/Y');
    }

    //          Methods
    /**
     * Method to set a chapter depending of the id of that chapter
     * 
     * @param int $idChapter    the ID of the chapter
     * @throws Exception
     */
    public function getChapter($idChapter) {
        $sql = "SELECT chapters.id as id, title, content, chapters.id_user as id_user, CONCAT(name, ' ', surname) as user_name,"
                . "  id_state, date_last_modif "
                . "FROM chapters INNER JOIN users ON chapters.id_user = users.id"
                . " WHERE chapters.id = :id AND id_state = 2";
        $params = array(':id' => $idChapter);
        $row = array();
        $row = $this->getRow($sql, $params);
        if (!empty($row)) {
            $this->id = $row['id'];
            $this->title = $row['title'];
            $this->content = $row['content'];
            $this->id_user = $row['id_user'];
            $this->user_name = $row['user_name'];
            $this->id_state = $row['id_state'];
            $this->date_last_modif = $row['date_last_modif'];
        } else {
            throw new Exception("Chapitre invalide...");
        }
    }

    /**
     * Method to retrieve the last chapters published (3 max)
     * 
     * @return array    this is an array of 'Chapitre' object.
     *         null     if no chapters have been published
     */
    public function getLastPublishedChapters() {
        $sql = "SELECT chapters.id, title, CONCAT(SUBSTRING_INDEX(content, '.',4),'...') as content, "
                . " chapters.id_user as id_user, CONCAT(name, ' ', surname) as user_name, id_state, date_last_modif FROM chapters "
                . "INNER JOIN users ON chapters.id_user = users.id INNER JOIN states ON chapters.id_state=states.id "
                . "WHERE id_state = 2 ORDER BY date_last_modif DESC LIMIT 3 ";
        $rows = $this->getAll($sql);
        if (!empty($rows)) {
            $chapters = array();
            foreach ($rows as $row) {
                $chapter = new Chapitre();
                $chapter->id = $row['id'];
                $chapter->title = $row['title'];
                $chapter->content = $row['content'];
                $chapter->id_user = $row['id_user'];
                $chapter->user_name = $row['user_name'];
                $chapter->id_state = $row['id_state'];
                $chapter->date_last_modif = $row['date_last_modif'];
                $chapters[] = $chapter;
            }
            return $chapters;
        } else {
            return null;
        }
    }

    /**
     * Method to retrieve the index of published chapters
     * 
     * @return array    This is an array containing an ID and a title
     * @throws Exception
     */
    public function getChapterList() {
        $sql = "SELECT id, title FROM chapters WHERE id_state = 2 ORDER BY id";
        $rows = $this->getAll($sql);
        if (!empty($rows)) {
            return $rows;
        } else {
            throw new Exception('Aucun chapitre créé...');
        }
    }

}
