<?php

require('model/UtilisateurManager.php');

function getFormConnexion()
{
    require('view/loginView.php');
}

function autoLogin(){
    $utilisateurManager = new UtilisateurManager();
    $utilisateur = $utilisateurManager->autoLogin(json_decode($_COOKIE["secretCookie"],true)['user_id'], json_decode($_COOKIE["secretCookie"],true)['token']);

    $_SESSION['courriel'] = $utilisateur->get_courriel();
    $_SESSION['role'] = $utilisateur->get_role_utilisateur();
}

function authentifier($courriel, $motPasse, $rememberWhoYouAre){
    $utilisateurManager = new UtilisateurManager();
    $utilisateur = $utilisateurManager->verifAuthentification($courriel, $motPasse);
    if ($utilisateur != null) {
        $_SESSION['courriel'] = $utilisateur->get_courriel();
        $_SESSION['role'] = $utilisateur->get_role_utilisateur();

        if($rememberWhoYouAre == true) {
            require('inc/Util.php');

            $token = new Util();
            //$utilisateur->set_token($token->getToken(17));
            $cookieValues = array(
                            'user_id' => $utilisateur->get_id_utilisateur(), // Le courriel est aussi acceptable
                            'token'   => $token->getToken(17),
                            );
            setcookie("secretCookie", json_encode($cookieValues), time()+2592000);

            $utilisateurManager->setAutoLogin($cookieValues['user_id'], $cookieValues['token']);
        }

        $_REQUEST['action'] = "";

        require('controller/controllerAccueil.php');
        listProduits();
    }
    else {
        getFormConnexion();
        echo "Mauvais utilisateur/mot de passe";
    }
}

function deconnexion(){
    $_SESSION = array();
    session_destroy();
    
    if(isset($_COOKIE["secretCookie"])){
        setcookie("secretCookie", "", time()-3600);
        $utilisateurManager = new UtilisateurManager();
        $utilisateurManager->deleteAutoLogin(json_decode($_COOKIE["secretCookie"],true)['user_id'], json_decode($_COOKIE["secretCookie"],true)['token']);
    }

    require('controller/controllerAccueil.php');
    listProduits();
}