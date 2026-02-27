<?php $title = 'Login'?>
<?php ob_start(); ?>

<h1>Se connecter</h1>

<form action="." class="flexform">
    <label for="courriel">Courriel</label>
    <input type="text" class="field" name="courriel" required>

    <label for="mdp">Mot de passe</label>
    <input type="password" class="field" name="motPasse" required>

    <label for="rememberWhoYouAre">Se souvenir de moi</label>
    <input type="checkbox" name="rememberWhoYouAre" class="field">

    <button type="submit">Se connecter</button>
    <input type="hidden" name="action" value="authentifier">
</form>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>