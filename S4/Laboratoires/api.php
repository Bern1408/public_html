<?php
    header('Content-Type: application/json'); // Le contenu est au format JSON
    
    if (isset($_REQUEST['objet'])){
        switch ($_REQUEST['objet']) {
            case 'produit':

            require('controller/controllerProduit.php');

                switch ($_SERVER["REQUEST_METHOD"]) {
                    case 'GET':// Cas pour sélectionner en BD un ou des produit(s)
                        if (isset($_REQUEST['id'])){
                            $produit = produit($_REQUEST['id'], true);
                            echo json_encode($produit, JSON_PRETTY_PRINT);
                            exit;
                        }
                        else{
                            $produits = listProduits(true);   
                            echo $produits;
                            exit;
                        }

                        http_response_code(400);
                        echo '{"ÉCHEC" : "Aucun produit ne correspond à votre requête."}';

                        break;
                    
                    case 'POST':// Cas pour insérer en BD un nouveau produit
                        $infosNouveauProduit = json_decode(file_get_contents('php://input'), true);
                        if (!isset($infosNouveauProduit['produit'])){
                            http_response_code(400);
                            echo '{"ÉCHEC" : "L\'ajout du produit a échoué. Le nom du produit est manquant."}';
                        }
                        elseif (!isset($infosNouveauProduit['id_categorie'])){
                            http_response_code(400);
                            echo '{"ÉCHEC" : "L\'ajout du produit a échoué. L\'ID de la catégorie est manquant."}';
                        }
                        elseif (!isset($infosNouveauProduit['description'])){
                            http_response_code(400);
                            echo '{"ÉCHEC" : "L\'ajout du produit a échoué. La description du produit est manquante."}';
                        }
                        else{
                            if(!is_numeric($infosNouveauProduit['id_categorie'])){
                                http_response_code(400);
                                echo '{"ÉCHEC" : "L\'ajout du produit a échoué. L\'ID de la catégorie n\'est pas un int."}'; 
                            }
                            elseif($infosNouveauProduit['id_categorie'] > 2 || $infosNouveauProduit['id_categorie'] < 1){
                                http_response_code(400);
                                echo '{"ÉCHEC" : "L\'ajout du produit a échoué. L\'ID de la catégorie est erroné."}'; 
                            }

                            addProduit($infosNouveauProduit);

                            http_response_code(200);
                            echo '{"SUCCÈS" : "L\'ajout du produit a fonctionné."}';
                        }

                        break; 
                
                    case 'PUT':// Cas pour mettre à jour un ou des renseignement(s) en BD sur un produit spécifique
                        $infosProduitExistant = json_decode(file_get_contents('php://input'), true);
                        if (!isset($infosProduitExistant['id_produit'])){
                            http_response_code(400);
                            echo '{"ÉCHEC" : "La modification du produit a échoué. L\'ID du produit est manquant."}';
                        }
                        elseif (!isset($infosProduitExistant['produit'])){
                            http_response_code(400);
                            echo '{"ÉCHEC" : "La modification du produit a échoué. Le nom du produit est manquant."}';
                        }
                        elseif (!isset($infosProduitExistant['id_categorie'])){
                            http_response_code(400);
                            echo '{"ÉCHEC" : "La modification du produit a échoué. L\'ID de la catégorie est manquant."}';
                        }
                        elseif (!isset($infosProduitExistant['description'])){
                            http_response_code(400);
                            echo '{"ÉCHEC" : "La modification du produit a échoué. La description du produit est manquante."}';
                        }
                        else{
                            if(!is_numeric($infosProduitExistant['id_categorie'])){
                                http_response_code(400);
                                echo '{"ÉCHEC" : "La modification du produit a échoué. L\'ID de la catégorie n\'est pas un int."}'; 
                            }
                            elseif($infosProduitExistant['id_categorie'] > 2 || $infosProduitExistant['id_categorie'] < 1){
                                http_response_code(400);
                                echo '{"ÉCHEC" : "La modification du produit a échoué. L\'ID de la catégorie est erroné."}'; 
                            }
                            elseif (produit($infosProduitExistant['id_produit'], true) == null){
                                http_response_code(400);    
                                echo '{"ÉCHEC" : "La modification du produit a échoué. L\'ID du produit est erroné."}';
                            }
                            else{
                                editProduit($infosProduitExistant['id_produit'], $infosProduitExistant['produit'], $infosProduitExistant['id_categorie'], $infosProduitExistant['description']);

                                http_response_code(200);
                                echo '{"SUCCÈS" : "La modification du produit a fonctionné."}';
                            }
                        }
                        break;
                
                    case 'DELETE':// Cas pour supprimer en BD un produit spécifique
                        if (isset($_REQUEST['id'])){
                            if (produit($_REQUEST['id'], true) == null){
                                http_response_code(400);
                                echo '{"ÉCHEC" : "La suppression du produit a échoué. L\'ID du produit est erroné."}';
                            }
                            else{
                                deleteProduit($_REQUEST["id"]);
                                http_response_code(200);
                                echo '{"SUCCÈS" : "La suppression du produit a fonctionné."}';
                            }
                        }
                        else{
                            http_response_code(400);
                            echo '{"ÉCHEC" : "La suppression du produit a échoué. L\'ID du produit n\'a pas été reçu."}';
                        }
                        break;
                    
                    default:
                        http_response_code(400);
                        echo '{"ÉCHEC" : "Seules les requêtes GET, POST, PUT ou DELETE sont permises."}';
                }

                break;
            case 'testajax': 
                $_REQUEST['objet'] = json_decode(file_get_contents('php://input'), true);
                print_r($_REQUEST);
                break;

            default:
                http_response_code(400);
                echo '{"ÉCHEC" : "Seules les requêtes concernant des produits peuvent être traitées."}';
        }
    }
?>