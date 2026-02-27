<?php $title = 'Produits';
$titreH1 = 'Les produits';
if(isset($categorie)){
    $titreH1 = 'Les produits de catégorie ' . $categorie;
}
require('model/CategorieManager.php');
$catM = new CategorieManager();
$categories = $catM->getCategories();
?>

<?php ob_start(); ?>
<h1><?php echo $titreH1 ?>
    <input class="modifBtn" id="add" type="image" src="./inc/img/add-icon.png" alt="Ajouter un produit">
</h1>

<?php foreach($produits as $produit) { ?>
    <div>
        <h3>Produit: <?= htmlspecialchars($produit->get_produit()) ?> 
            <input class="modifBtn" type="image" src="./inc/img/edit-icon.png" alt="Modifier un produit" value="<?= htmlspecialchars($produit->get_id_produit()) ?>">
            <input class="modifBtn" type="image" src="./inc/img/delete-icon.png" alt="Supprimer un produit" value="<?= htmlspecialchars($produit->get_id_produit()) ?>">
        </h3>
        <p>Description: <?= htmlspecialchars($produit->get_description()) ?> </p>        
        <hr>
    </div>
<?php } ?>

<form action="" class="hide" id="addForm">
    <fieldset class="flexform">
        <legend>Gestion d'un produit</legend>

        <label for="produit">Produit :</label>
        <input type="text" name="produit" class="field">

        <label for="categorie">Catégorie :</label>
        <select name="categorie" class="field">
            <?php foreach($categories as $c) { ?>
                <option value="<?= $c->get_id_categorie() ?>"><?= $c->get_categorie() ?></option>
            <?php } ?>
        </select>

        <label for="description">Description :</label>
        <input type="text" name="description" class="field">
 
        <button type="submit">Envoyer</button>
    </fieldset>
</form>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>