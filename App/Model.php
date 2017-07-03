<?php

require_once 'Configuration.php';

/**
 * Classe Modele permet l'accès à la base de données
 */
abstract class Model {

    // Objet PDO accès à la base de données
    private static $db;

    /**
     * Retourne l'objet de connexion tout en l'initialisant
     * @return PDO objet connexion à la base de donnée
     */
    private function getDB() {
        if (self::$db === null) {
            //on récupère les paramètres configuration de la base
            $dsn = Configuration::getSetting("dsn");
            $login = Configuration::getSetting("login");
            $mdp = Configuration::getSetting("mdp");
            //création de la connexion
            try {
                self::$db = new PDO($dsn, $login, $mdp, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            } catch (PDOException $ex) {
                self::close();
                throw new Exception($ex->getMessage());
            }
        }
        return self::$db;
    }

    /**
     * Fin de la classe PDO
     */
    protected function close() {
        self::$db = NULL;
    }

    /**
     * Permet l'éxécution d'une requête ou d'une procédure stockée
     * @param string $sql : la requête
     * @param array $params : les paramètres de la requête
     */
    protected function execute($query, $params = null) {
        try {
            $handler = self::getDB();
            $statement = $handler->prepare($query);
            return $statement->execute($params);
        } catch (PDOException $ex) {
            throw new Exception($ex->getMessage());
        }
    }

    /**
     * Permet l'éxécution d'une requête ou d'une procédure stockée pour retrouver une liste 
     * d'élément
     * @param string $query : la requête
     * @param array $params : les paramètres de la requête
     * @return array : un tableau contenant le result de la requête
     */
    protected function getAll($query, $params = null) {
        $result = null;
        try {
            $handler = self::getDB();
            $statement = $handler->prepare($query);
            $statement->execute($params);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            throw new Exception($ex->getMessage());
        }
        return $result;
    }

    /**
     * Permet l'éxécution d'une requête ou d'une procédure stockée pour retrouver un élément
     * @param string $query : la requête
     * @param array $params : les paramètres de la requête
     * @return array : un tableau contenant le result de la requête
     */
    protected function getRow($query, $params = null) {
        $result = null;
        try {
            $handler = self::getDB();
            $statement = $handler->prepare($query);
            $statement->execute($params);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            throw new Exception($ex->getMessage());
        }
        return $result;
    }

    /**
     * Permet l'éxécution d'une requête ou d'une procédure stockée pour retrouver une unique valeur
     * @param string $query : la requête
     * @param array $params : les paramètres de la requête
     * @return array : un tableau contenant le result de la requête
     */
    protected function GetOne($query, $params = NULL) {
        $result = NULL;
        try {
            $handler = self::getDB();
            $statement = $handler->prepare($query);
            $statement->execute($params);
            $result = $statement->fetch(PDO::FETCH_NUM);
            //Get the first value
            $result = $result[0];
        } catch (PDOException $ex) {
            throw new Exception($ex->getMessage());
        }
        //retourne le resultat
        return $result;
    }

}
