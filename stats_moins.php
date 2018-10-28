<?php
session_start();
?>
<html>
    <head>
        <title>Statistiques</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css2.css"/>
    </head>

    <body>
        <div id="topPan">
            <div id="ImgPan"><a href="accueil.html"><img src="images.jpg" title="UTT" alt="UTT" width="400" height="100"/></a> </div>
            <ul id="menu">
                <?php
                if (!empty($_SESSION['prenom'])) {
                    echo("<font size='1' class='deconnexion1'>" . "Vous êtes connecté en tant que " . $_SESSION['prenom'] . " " . $_SESSION['nom'] . ", " . "</font>");
                    echo("<font size='1' class='deconnexion2'><a href='deconnexion.php'>déconnectez-vous.</a></font>");
                } else {
                    echo("<font size='1' class='connexion1'>Visiteur? Pour avoir accès à plus de pages, </font>");
                    echo("<font size='1' class='connexion2'><a href='connexion.php'>connectez-vous.</a></font>");
                }
                ?>
                <li><a href="accueil.html">Accueil</a></li> 
                <li><a>Compte</a>
                    <ul class="niveau2A">
                        <li><a href="connexion.php">Connexion</a></li>
                        <li><a href="inscription.php.php">Inscription</a></li>
                        <li><a href="enregistrer_chercheur.php">Hors UTT</a></li>
                    </ul>
                </li>
                <li><a>Article</a>
                    <ul class="niveau2B">
                        <li><a href="soumettre_article.php">Soumettre</a></li>
                        <li><a href="modifier_article.php">Modifier</a></li>
                    </ul>
                </li>
                <li><a href="recherche.php">Recherche</a></li>
                <li class="actuel">Admin
                    <ul class="niveau2C">
                        <li><a href="visualisation.php">Visualisation</a></li>
                        <li><a href="anomalies.php">Anomalies </a></li>
                        <li class="actuel"><a>Statistiques</a></li>
                    </ul>
                </li>
            </ul>	
        </div>
    <br/>
    <br/>


    <div id="bodyPan">

    </div>

    <div id="bodyMiddlePan">
        <?php
        if (!empty($_SESSION['connecte'])) {
            echo("Seul l'administrateur à accès à cette page<br/>");
            echo("<font size='1'>Si vous êtes administrateur <a href='connexion.php'>connectez-vous.</a></font>");
        } else {
            if (isset($_SESSION['nom'])) {
                require_once 'database_projet.php';
                echo"<fieldset>";
                echo"<font color='black' size=4><b>Auteur avec le moins d'articles</b></font><br/><br/>";
                plus_petit_contributeur($mabase);
                echo "<a href='statistiques.php'>Retour</a>";
                echo"</fieldset>";
                
            } else {
                echo("Seul l'administrateur à accès à cette page<br/>");
                echo("<font size='1'>Si vous êtes administrateur <a href='connexion.php'>connectez-vous.</a></font>");
            }
        }
        ?>

    </div>
    <br/>
    <br/>
    <div id="footermainPan">
        <div id="footerPan">
            <ul>
                <li><a href="accueil.html">Accueil</a>| </li>
                <li><a href="connexion.php">Connexion</a> | </li>
                <li><a href="soumettre_article.php">Publications</a>| </li>
                <li><a href="recherche.php">Recherche</a> | </li>
                <li><a href="#">Admin</a></li>
            </ul>
            <p class="nom">AVARGUES Matthieu & VYAS Kévin</p>


            <ul class="templateworld">
                <li>Design by:</li>
                <li><a href="http://www.templateworld.com" target="_blank">Template World</a></li>
            </ul>
        </div>
    </div>
</body>
</html>

<?php
function plus_petit_contributeur($mabase) {
    //compteur d'auteurs
    $query = "SELECT count(id) FROM auteurs";
    $resultat = mysqli_query($mabase, $query);
    while ($ligne = mysqli_fetch_array($resultat, MYSQLI_ASSOC)) {
        $nbr_auteurs = $ligne['count(id)'];
    }
    $plus_grand_contributeur = 0;
    $nombre_publications_ancien_auteur = 10;
    $compteur_auteur_similaire = 1;
    $auteur = 'auteur';
    for ($compteur = 0; $compteur < $nbr_auteurs; $compteur++) {
        $query = "SELECT count(auteur_id) as nbr FROM publications WHERE auteur_id=$compteur";
        $resultat = mysqli_query($mabase, $query);
        while ($ligne = mysqli_fetch_array($resultat, MYSQLI_ASSOC)) {
            $nombre_publications_nouvel_auteur = $ligne['nbr'];
        }
        if ($nombre_publications_nouvel_auteur < $nombre_publications_ancien_auteur) {
            $compteur_auteur_similaire = 0;
            $plus_grand_contributeur = $compteur;
            $nombre_publications_ancien_auteur = $nombre_publications_nouvel_auteur;
        }
        if ($nombre_publications_nouvel_auteur == $nombre_publications_ancien_auteur) {
            $auteur[$compteur_auteur_similaire] = $compteur;
            $compteur_auteur_similaire = $compteur_auteur_similaire + 1;
        }
        
    }
    echo("Le(s) auteur(s) ayant écrit le moins d'articles ($nombre_publications_ancien_auteur) sont :<br/><br/>");
    echo("<ul>");
    echo("<li><b>Auteur n°1 :</b></li>");
    $query = "SELECT nom, prenom, organisation, equipe FROM auteurs WHERE id=$plus_grand_contributeur";
    $resultat = mysqli_query($mabase, $query);
    while ($ligne = mysqli_fetch_array($resultat, MYSQLI_ASSOC)) {
        echo("Nom : " . $ligne['nom'] . "<br/>");
        echo("Prenom : " . $ligne['prenom'] . "<br/>");
        echo("Organisation : " . $ligne['organisation'] . "<br/>");
        echo("Equipe : " . $ligne['equipe'] . "<br/><br/>");
    }
    for ($compteur = 1; $compteur < $compteur_auteur_similaire; $compteur++) {
        $numero = $compteur + 1;
        echo("<li><b>Auteur n°$numero :</b></li>");
        $id = $auteur[$compteur];
        $query = "SELECT nom, prenom, organisation, equipe FROM auteurs WHERE id=$id";
        $resultat = mysqli_query($mabase, $query);
        while ($ligne = mysqli_fetch_array($resultat, MYSQLI_ASSOC)) {
            echo("Nom : " . $ligne['nom'] . "<br/>");
            echo("Prenom : " . $ligne['prenom'] . "<br/>");
            echo("Organisation : " . $ligne['organisation'] . "<br/>");
            echo("Equipe : " . $ligne['equipe'] . "<br/><br/>");
        }
    }
    echo("</ul>");
}


