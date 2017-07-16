<?php

/**
 * class to retrieve settings for the project
 */
class Configuration {

    private static $settings;

    public static function getSetting($name, $defaultValue = null) {
        if (isset(self::getSettings()[$name])) {
            $value = self::getSettings()[$name];
        } else {
            $value = $defaultValue;
        }
        return $value;
    }

    private static function getSettings() {
        if (self::$settings == null) {
            $pathFile = "Config/prod.ini";
            if (!file_exists($pathFile)) {
                $pathFile = "Config/dev.ini";
            }
            if (!file_exists($pathFile)) {
                throw new Exception("Aucun fichier de configuration");
            } else {
                self::$settings = parse_ini_file($pathFile);
            }
        }
        return self::$settings;
    }

}
