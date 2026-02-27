<?php

require('model/ProduitManager.php');

function listProduits($estApi = false)
{
    $produitManager = new ProduitManager();
    $produits = $produitManager->getProduits();

    if(!$estApi) {
    require('view/produitsView.php');
    }
    else{
        return json_encode($produits, JSON_PRETTY_PRINT);
    }
}

function produit($idProduit, $estApi = false)
{
    $produitManager = new ProduitManager();
    $produit = $produitManager->getProduit($idProduit);    

    if(!$estApi) {
        require('view/produitView.php');
    }
    else{
        return $produit;
    }
}

function listProduitsCategorie($idCategorie)
{
    $produitManager = new ProduitManager();
    $produits = $produitManager->getProduitsCategorie($idCategorie);
    $categorie = $produits[0]->get_categorie();

    require('view/produitsView.php');
}

function addProduit($produit){
    $produitManager = new ProduitManager();
    $produitManager->setProduit($produit);
}
function editProduit($id, $nom, $idCategorie, $description){
    $produitManager = new ProduitManager();
    $produitManager->edProduit($id, $nom, $idCategorie, $description);
}
function deleteProduit($id){
    $produitManager = new ProduitManager();
    $produitManager->delProduit($id); 
}