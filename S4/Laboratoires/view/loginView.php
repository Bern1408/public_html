<?php $title = 'Login'?>
<?php ob_start(); ?>

<h1>Se connecter</h1>

<form action=".">
    <label for="courriel">Courriel</label>
    <br>
    <input type="text" class="text" name="courriel" required>
    <br>
    <label for="mdp">Mot de passe</label>
    <br>
    <input type="password" class="text" name="motPasse" required>
    <br>
    <input type="checkbox" name="rememberWhoYouAre"> Se souvenir de moi
    <br>
    <button type="submit">Se connecter</button>
    <input type="hidden" name="action" value="authentifier">
</form>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>