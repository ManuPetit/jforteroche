<?php

/* 
 *              Class to create Menus (admin and main menu)
 */

class Menus {
    
    /**
     * Method to create the main menu for the web site
     * 
     * @param string $controller    The controller the page generated is from
     * @param string $request       The request object
     * @return string               The menu in html
     */
    public static function createMainMenu($controller, $request) {
        //array of main menu
        $mainMenu = array(
            array(
                'name' => 'accueil',
                'link' => 'accueil',
                'title' => 'Page d\'accueil',
                'text' => 'Accueil',
                'admin' => false
            ),
            array(
                'name' => 'chapitre',
                'link' => 'chapitre',
                'title' => 'Découvrez mon livre',
                'text' => 'Le livre',
                'admin' => false
            ),
            array(
                'name' => 'bio',
                'link' => 'bio',
                'title' => 'Mes autres romans',
                'text' => 'Bio',
                'admin' => false
            ),
            array(
                'name' => 'admin',
                'link' => 'admin',
                'title' => 'Administration',
                'text' => 'Admin',
                'admin' => true
            ),
            array(
                'name' => 'connexion',
                'link' => 'connexion',
                'text' => 'Connexion',
                'admin' => false
            )
        );
        $main_menu = "";
        for ($row = 0; $row < count($mainMenu); $row++) {
            //chamgement du menu connexion
            if (($mainMenu[$row]['name'] == 'connexion') && ($request->getSession()->parameterExists("idUser"))) {
                $mainMenu[$row]['link'] = 'connexion/deconnecter';
                $mainMenu[$row]['title'] = "Cliquez ici pour vous déconnecter";
                $mainMenu[$row]['text'] = "Déconnexion";
            } elseif (($mainMenu[$row]['name'] == 'connexion')) {
                $mainMenu[$row]['link'] = 'connexion';
                $mainMenu[$row]['title'] = "Cliquez ici pour vous connecter";
                $mainMenu[$row]['text'] = "Connexion";
            }
            if ($request->getSession()->parameterExists("idUser") == $mainMenu[$row]['admin']) {
                $main_menu .= '<li';
                if ($controller == $mainMenu[$row]['name']) {
                    $main_menu .= ' class="current"';
                }
                $main_menu .= '><a href="' . $mainMenu[$row]['link'] . '" title="' . $mainMenu[$row]['title'] .'">' . $mainMenu[$row]['text'] . '</a></li>' . PHP_EOL;
            } else if ($mainMenu[$row]['admin'] == false) {
                $main_menu .= '<li';
                if ($controller == $mainMenu[$row]['name']) {
                    $main_menu .= ' class="current"';
                }
                $main_menu .= '><a href="' . $mainMenu[$row]['link'] . '" title="' . $mainMenu[$row]['title'] .'">' . $mainMenu[$row]['text'] . '</a></li>' . PHP_EOL;
            }
        }
        return $main_menu;
    }
    
    /**
     * This method returns the admin menu with the current menu highlighted
     * 
     * @param string $action        The name of the action (null is for index)
     * @return string               The admin menu in html
     */
    public static function createAdminMenu($action){
        //create the admin menu
        $adminMenu = array(
            array(
                'name' => 'index',
                'level' => 0,
                'link' => 'admin',
                'title' => 'Administration : vue d\'ensemble',
                'text' => 'Vue d\'ensemble'
            ),
            array(
                'name' => 'episode',
                'level' => 0,
                'link' => 'admin/episodes',
                'title' => 'Les chapitres du livre',
                'text' => 'Episodes'                
            ),
            array(
                'name' => 'creer',
                'level' => 1,
                'link' => 'admin/creer',
                'title' => 'Créer un nouvel épisode',
                'text' => 'Créer'                
            ),
            array(
                'name' => 'modifier',
                'level' => 1,
                'link' => 'admin/modifier',
                'title' => 'Modifier un épisode existant',
                'text' => 'Modifier'                
            ),
            array(
                'name' => 'message',
                'level' => 0,
                'link' => 'admin/messages',
                'title' => 'Les messages des lecteurs',
                'text' => 'Messages'                
            ),
            array(
                'name' => 'profil',
                'level' => 0,
                'link' => 'admin/profil',
                'title' => 'Mon profil',
                'text' => 'Profil'                
            ),
            array(
                'name' => 'changer',
                'level' => 1,
                'link' => 'admin/changer',
                'title' => 'Modifier mon profil',
                'text' => 'Modifier'                
            )            
        );
        $admin_menu = "";
        //create menu
        for ($row = 0; $row < count($adminMenu); $row++){
            $admin_menu .= '<li class="ad-menu-level' . $adminMenu[$row]['level'] . '';
            if ($action == $adminMenu[$row]['name']) {
                $admin_menu .= ' current';
            }
            $admin_menu .= "\">\n";
            $admin_menu .= '<a href="' . $adminMenu[$row]['link'] . '" title="' . $adminMenu[$row]['title'] . '">';
            $admin_menu .= $adminMenu[$row]['text'] . "</a>\n</li>\n";
        }
        return $admin_menu;
    }
}