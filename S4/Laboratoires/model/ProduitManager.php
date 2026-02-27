<?php

// Ce fichier sert à communiquer avec la BD et construire les objets pour les retourner au controleur.
// Ces fonctions sont généralement appelé par le routeur (index.php) ou d'autres contrôleurs.

require_once("model/Manager.php");
require_once("model/Produit.php");

class ProduitManager extends Manager
{
    public function getProduits()
    {
        $db = $this->db_connect();
        $req = $db->query('SELECT * FROM tbl_produit ORDER BY id_produit');

        $produits = array();

        while($data = $req->fetch()){
            array_push($produits, new Produit($data));
        }

        $req->closeCursor();
        return $produits;
    }

    public function getProduit($produitId)
    {
        $db = $this->db_connect();
        $req = $db->prepare('SELECT p.*, categorie FROM tbl_produit AS p INNER JOIN tbl_categorie AS c ON p.id_categorie = c.id_categorie WHERE id_produit = ?');
        $req->execute(array($produitId));
        $results = $req->fetch();

        if ($results)
            return new Produit($results);

        return null;
    }

    public function getProduitsCategorie($categorieId)
    {
        $db = $this->db_connect();
        $req = $db->prepare('SELECT p.*, categorie FROM tbl_produit AS p INNER JOIN tbl_categorie AS c ON p.id_categorie = c.id_categorie WHERE c.id_categorie = ?');
        $req->execute(array($categorieId));
        $produits = array();

        while($data = $req->fetch()){
            array_push($produits, new Produit($data));
        }

        return $produits;
    }

    public function setProduit($produit)
    {
        $db = $this->db_connect();
        $req = $db->prepare("INSERT INTO tbl_produit (id_categorie, produit, description) 
            VALUES (:cat, :nom, :descrip)");
        $req->bindParam(':cat', $produit['id_categorie']);
        $req->bindParam(':nom', $produit['produit']);
        $req->bindParam(':descrip', $produit['description']);
        $req->execute();
    }

    public function edProduit($id, $nom, $idCategorie, $description){
        $db = $this->db_connect();
        $req = $db->prepare("UPDATE tbl_produit
            SET id_categorie = :cat, produit = :nom, description = :descrip
            WHERE id_produit = :id");
        $req->bindParam(':id', $id);
        $req->bindParam(':cat', $idCategorie);
        $req->bindParam(':nom', $nom);
        $req->bindParam(':descrip', $description);
        $req->execute();
    }

    public function delProduit($produitId)
    {
        $db = $this->db_connect();
        $req = $db->prepare('DELETE FROM tbl_produit WHERE id_produit = ?');
        $req->execute(array($produitId));
    }
}