<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <link href="./inc/css/style.css" rel="stylesheet" /> 
    </head>
        
    <body>
        <?php if(isset($_SESSION["courriel"])) {
                echo "<p> Bienvenue " . $_SESSION["courriel"] . "</p>";
            } 
        ?>
        <nav>
            <ul>
                <li><a href=".">Accueil</a></li>
                <li><a href="./produits">Les produits</a></li>
                <li><a href="./categories">Les catégories</a></li>
                <li>
                <?php if(isset($_SESSION["courriel"])) {
                        echo '<a href="./deconnexion">Se déconnecter</a>';
                    }
                    else{
                        echo '<a href="./connexion">Se connecter</a>';
                    }
                ?>
                </a></li>
            </ul>
        </nav>
        <?= $content ?>
    </body>
</html>