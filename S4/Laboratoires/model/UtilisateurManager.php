<?php

require_once("model/Manager.php");
require_once("model/Utilisateur.php");

class UtilisateurManager extends Manager
{
    public function verifAuthentification($courriel, $motPasse) {
        $utilisateur = $this->getUtilisateurParCourriel($courriel);
        if ($utilisateur != null) {
            if(password_verify($motPasse, $utilisateur->get_mdp()) == true) {
                return $utilisateur;
            }
        }
        return null;
    }
    public function getUtilisateurParCourriel($courriel)
    {
        $db = $this->db_connect();
        $req = $db->prepare('SELECT * FROM tbl_utilisateur WHERE courriel = ?');
        $req->execute(array($courriel));
        $utilisateur = new Utilisateur($req->fetch());

        return $utilisateur;
    }

    public function deleteAutoLogin($userID, $token){
        $db = $this->db_connect();
        //$req = $db->query("INSERT INTO tbl_autologin (est_valide) VALUES (0);");
        $req = $db->prepare("DELETE FROM tbl_autologin WHERE id_utilisateur = :id AND token_hash = :token");
        $req->bindParam(':id', $userID);        
        $req->bindParam(':token', $token);
        $req->execute();
    }

    public function setAutoLogin($userID, $token){
        $db = $this->db_connect();
        $dateExpiration = date('Y-m-d', time()+2592000);
        $req = $db->prepare("INSERT INTO tbl_autologin (id_utilisateur, token_hash, est_valide, date_expiration) 
        VALUES (:id, :token, 1, :exp)");
        $req->bindParam(':id', $userID);
        $req->bindParam(':token', $token);
        $req->bindParam(':exp', $dateExpiration);
        $req->execute();
    }

    public function autoLogin($userID, $token):Utilisateur{
        $db = $this->db_connect();
        $req = $db->prepare("SELECT id_utilisateur, token_hash, est_valide FROM tbl_autologin WHERE id_utilisateur = :id AND token_hash = :token");
        $req->bindParam(':id', $userID);
        $req->bindParam(':token', $token);
        $req->execute();
        $autoLog = $req->fetch();

        if($userID == $autoLog['id_utilisateur'] && $token == $autoLog['token_hash'] && $autoLog['est_valide'] = 1){
            $req = $db->prepare('SELECT * FROM tbl_utilisateur WHERE id_utilisateur = ?');
            $req->execute(array($userID));
            $utilisateur = new Utilisateur($req->fetch());
        } else {
            $utilisateur = new Utilisateur();
        }
        return $utilisateur;
    }
}