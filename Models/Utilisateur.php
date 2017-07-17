<?php

require_once 'App/Model.php';
require_once 'App/phpmail/class.phpmailer.php';

/**
 *      Class representing a Utilisateur object
 */
class Utilisateur extends Model {

    //          private properties of the 'Utilisateur' model
    private $id;
    private $login;
    private $email;
    private $name;
    private $surname;
    private $password;
    private $salt;  //internal use. never shown. no getter or setter
    private $date_last_login;

    //          Getters and setters
    //  read only property
    public function getId() {
        return $this->id;
    }

    public function getLogin() {
        return $this->login;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function setSurname($surname) {
        $this->surname = $surname;
    }

    //  read only property
    public function getFullName() {
        return ucfirst($this->name) . ' ' . ucfirst($this->surname);
    }

    //  This is the hashed password as it is in the DB
    public function getPassword() {
        return $this->password;
    }

    //  read only property
    //  The output date is formatted to french system
    public function getDateLastLogin() {
        $timeZone = "Europe/Paris";
        date_default_timezone_set($timeZone);
        $date = date_create($this->date_last_login);
        return date_format($date, 'd/m/Y à H:i');
    }

    //          Methods
    /**
     * This setters takes a password entered by the user.
     * It check to see if a salt exist (if not, it creates it)
     * It then creates the hashed password
     * 
     * @param string $password  The password typed by the user.
     */
    public function setPassword($password) {
        if (isset($this->salt) && $this->salt != '') {
            $this->password = $this->makePassword($password, $this->salt);
        } else {
            $this->salt = $this->generateSalt();
            $this->password = $this->makePassword($password, $this->salt);
        }
    }

    /**
     * Check if a user can login with a given password
     * 
     * @param string $name      The login name of the user
     * @param string $password  The password of the user
     * @return boolean          True if we have a match otherwise false
     */
    public function canLogin($name, $password) {
        //get the salt for this user
        $salt = $this->getUserSalt($name);
        if (isset($salt) && ($salt != '')) {
            $hash = $this->makePassword($password, $salt);
            //check pseudo against hash
            $sql = "SELECT id, email FROM users WHERE login = :name AND password = :hash";
            $params = array(
                ':name' => $name,
                ':hash' => $hash
            );
            $login = $this->getRow($sql, $params);
            if (isset($login) && $login != '') {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * This get all the details from a user. They are stored
     * in the revelant properties
     * 
     * @param string $name
     * @param string $password
     * @throws Exception
     */
    public function getUserDetails($name, $password) {
        $salt = $this->getUserSalt($name);
        $hash = $this->makePassword($password, $salt);
        $sql = "SELECT id, login, email, name, surname, date_last_login "
                . "FROM users WHERE login = :name AND password = :hash";
        $params = array(
            ':name' => $name,
            ':hash' => $hash
        );
        $row = $this->getRow($sql, $params);
        if (!empty($row)) {
            $this->id = $row['id'];
            $this->login = $row['login'];
            $this->email = $row['email'];
            $this->name = $row['name'];
            $this->surname = $row['surname'];
            $this->password = $hash;
            $this->salt = $salt;
            $this->date_last_login = $row['date_last_login'];
        } else {
            throw new Exception("Erreur de données");
        }
    }

    public function getUser($idUser) {
        $sql = "SELECT login, email, name, surname , password, salt, date_last_login "
                . "FROM users WHERE id = :id";
        $params = array(':id' => $idUser);
        $row = $this->getRow($sql, $params);
        if (!empty($row)) {
            $this->id = $idUser;
            $this->login = $row['login'];
            $this->email = $row['email'];
            $this->name = $row['name'];
            $this->surname = $row['surname'];
            $this->password = $row['password'];
            $this->salt = $row['salt'];
            $this->date_last_login = $row['date_last_login'];
        } else {
            throw new Exception('Utilisateur inconnu');
        }
    }

    /**
     * Update the login time of a user
     * 
     * @param int $idUser
     */
    public function updateLastLogin($idUser) {
        $sql = "UPDATE users SET date_last_login = NOW()"
                . " WHERE id = :idUser";
        $params = array(':idUser' => $idUser);
        $this->execute($sql, $params);
    }

    /**
     * gets the user salt to generate a password
     * 
     * @param string $name  The login name of the user
     * @return string       The salt
     */
    private function getUserSalt($name) {
        $sql = "SELECT salt FROM users WHERE login = :name";
        $params = array(':name' => $name);
        $salt = $this->GetOne($sql, $params);
        return $salt;
    }

    /**
     * generate a new salt when creating a user
     * 
     * @param int $max  Maximum number of characters in the salt
     * @return string   The salt generated
     */
    private function generateSalt($max = null) {
        if (is_null($max) || $max > 64) {
            $max = 64;
        }
        $characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*?";
        $i = 0;
        $salt = "";
        while ($i < $max) {
            $salt .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
            $i++;
        }
        return $salt;
    }

    /**
     * Create a new password for a given email
     * 
     * @param string $email
     * @return string
     * @throws Exception
     */
    public function generateNewPassword($email) {
        try {
            //check if email exist
            if ($this->isEmailExists($email)) {
                // we create the new password
                $pass = $this->createPassword();
                // we make a new salt as well as new password
                $salt = $this->generateSalt();
                //create the new password hash
                $hash = $this->makePassword($pass, $salt);
                //we save the password
                $this->saveNewPassword($hash, $salt, $email);
                if ($this->sendPasswordMail($pass, $email)) {
                    $msg = "<p>Un email vous a été envoyé avec votre nouveau mot de passe.</p>";
                    $msg .= "<p>Connectez-vous à l'interface administrative avec ce nouveau "
                            . "mot de passe, afin de le changer pour un qui vous convient mieux.";
                } else {
                    $msg = "<p>Nous n'avons pas été en mesure de vous envoyer votre nouveau mot de passe";
                    $msg .= "<br />Veuillez contacter votre service technique...</p>";
                }
            } else {
                $msg = "<p>L'email communiqué est absente de notre système.</p>";
            }
            return $msg;
        } catch (Exception $ex) {
            throw new Exception($ex);
        }
    }

    /**
     * 
     * @param string $password  The password of the user
     * @param string $salt      The salt of the user
     * @return string           The hashed password to be stocked in the DB
     */
    private function makePassword($password, $salt) {
        $combo = $salt . $password;
        $hash = hash('sha512', $combo);
        return $hash;
    }

    /**
     * Method to change the user email
     * 
     * @param string $email The email to change
     */
    public function updateEmail($email) {
        $sql = "UPDATE users SET email = :email WHERE id = :id";
        $params = array(
            ':email' => $email,
            ':id' => $this->id
        );
        $this->execute($sql, $params);
    }

    /**
     * Method to check if an email is in the users table in the DB
     * 
     * @param string $email The email to verify
     * @return boolean      
     */
    private function isEmailExists($email) {
        $sql = "SELECT id FROM users WHERE email = :email";
        $params = array(':email' => $email);
        if ($this->GetOne($sql, $params) >= 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Method to update a password
     * 
     * @param string $password  The password to be updated
     */
    public function updatePassword($password) {
        $pass = $this->makePassword($password, $this->salt);
        $sql = "UPDATE users SET password = :pass WHERE ID = :id";
        $params = array(
            ':pass' => $pass,
            ':id' => $this->id
        );
        $this->execute($sql, $params);
    }

    /**
     * method to create a new password of 20 characters
     * 
     * @return string   The generated password
     */
    private function createPassword() {
        $characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $i = 0;
        $pass = "";
        while ($i < 20) {
            $pass .= $characterList{mt_rand(0, (strlen($characterList) - 1))};
            $i++;
        }
        return $pass;
    }

    /**
     * Method to save a newly generated password when a user forgot his
     * 
     * @param string $hash  the password combo
     * @param string $salt  The salt of the user
     * @param string $email The email of the user
     */
    private function saveNewPassword($hash, $salt, $email) {
        try {
            $sql = "UPDATE users SET password = :password, salt = :salt"
                    . " WHERE email = :email";
            $params = array(
                ':password' => $hash,
                ':salt' => $salt,
                ':email' => $email
            );
            $this->execute($sql, $params);
        } catch (Exception $ex) {
            throw new Exception($ex);
        }
    }

    /**
     * Method to send an email with the new user password
     * 
     * @param string $password  The newly created password
     * @param string $email     The user email
     * @return boolean
     */
    private function sendPasswordMail($password, $email) {
        $message = '<p>Un nouveau mot de passe à été généré :<br />';
        $message .= $password . '</p>';
        $message .= '<p>Veuillez vous connecter à <a href="http://jforteroche.iiidees.com/connexion">l\'interface administrative</a> avec ce nouveau mot de passe.<br />';
        $message .= 'Vous pourrez ensuite changer ce mot de passe.</p>';
        try {
            $mail = new PHPMailer();
            $mail->CharSet = 'utf-8';
            $mail->Host = "iiidees.com";
            $body = $message;
            $mail->SetFrom("administration@iiidees.com");
            $mail->AddAddress($email);
            $mail->Subject = "Votre nouveau mot de passe";
            $mail->MsgHTML($message);

            if ($mail->Send()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            throw new Exception($ex);
        }
    }

}
