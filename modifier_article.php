<?php
session_start();
?>
<html>
    <head>
        <title>Modifier</title>
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
                        <li><a href="inscription.php">Inscription</a></li>
                        <li><a href="enregistrer_chercheur.php">Hors UTT</a></li>
                    </ul>
                </li>
                <li class="actuel">Article
                    <ul class="niveau2B">
                        <li><a href="soumettre_article.php">Soumettre</a></li>
                        <li class="actuel"><a>Modifier</a></li>
                    </ul>
                </li>
                <li><a href="recherche.php">Recherche</a></li>
                <li><a>Admin</a>
                    <ul class="niveau2C">
                        <li><a href="visualisation.php">Visualisation</a></li>
                        <li><a href="anomalies.php">Anomalies </a></li>
                        <li><a href="statistiques.php">Statistiques</a></li>
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
        if (empty($_SESSION['connecte'])) {
            echo "<fieldset>";
            echo("Vous devez être connecté en tant que chercheur de l'UTT pour pouvoir modifier un article de la base.<br/>");
            echo("<font size='1' class='connexion2'><a href='connexion.php'>Connectez-vous.</a></font>");
            echo "</fieldset>";
        } else {
            generateur_articles_base();
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
                <li><a href="visualisation.php">Admin</a></li>
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

function generateur_articles_base() {
    require_once 'database_projet.php';
    //Lecture des articles_id que l'auteur a ecrit
    $id_chercheur = $_SESSION['id'];
    $query = "SELECT article_id FROM publications WHERE auteur_id=$id_chercheur";
    $resultat = mysqli_query($mabase, $query);
    $compteur = 1;
    echo("<b>Voici la liste des articles dont vous êtes auteur, vous pouvez les modifier.</b><br/>");
    while ($ligne = mysqli_fetch_array($resultat, MYSQLI_ASSOC)) {
        echo("<br/>");
        echo("<ul>");
        echo("<fieldset>");
        echo("<form method='POST' action='modifier_article2.php'>");
        echo("<b>Article numéro " . $compteur . " :</b><br/>");
        echo('<br/>');
        $article_id = $ligne['article_id'];
        lecture_article_base($mabase, $article_id, $compteur);
        $compteur = $compteur + 1;
        echo("<input type='hidden' name='article_id' value='$article_id'/>");
        echo("<input type='submit' name='bouton' value='Modifier cet article'/>");
        echo("</form>");
        echo("</fieldset>");
        echo("</ul>");
    }
    echo('<br/>');
}

function lecture_article_base($mabase, $article_id, $compteur) {
    $query = "SELECT nom, prenom, article_id, auteur_id, ordre FROM publications p, auteurs a WHERE (a.id=p.auteur_id) AND article_id=$article_id ORDER BY ordre";
    $resultat = mysqli_query($mabase, $query);
    echo("<b>Auteurs dans l'ordre :</b>");

    while ($ligne = mysqli_fetch_array($resultat, MYSQLI_ASSOC)) {
        $nom = $ligne['nom'];
        $prenom = $ligne['prenom'];
        echo(" $nom $prenom, ");
    }

//Lecture des articles_id que l'auteur a ecrit
    $query = "SELECT categorie, titre, annee, lieu, nbr_auteurs FROM articles WHERE id=$article_id";
    $resultat = mysqli_query($mabase, $query);
    echo("<ul>");
//Pour avoir tous les noms des auteurs
//lecture de chaque champ
    while ($ligne = mysqli_fetch_array($resultat, MYSQLI_ASSOC)) {
        echo("<li><label><b>Titre : </b></label>" . $ligne['titre'] . "</li>");
        echo("<li><label><b>Catégorie : </b></label>" . $ligne['categorie'] . "</li>");
        echo("<li><label><b>Année : </b></label>" . $ligne['annee'] . "</li>");
        if ($ligne['lieu'] !== '') {
        echo("<li><label><b>Lieu : </b></label>" . $ligne['lieu'] . "</li>");
        }
        echo("<li><label><b>Nombre d'auteur(s) : </b></label>" . $ligne['nbr_auteurs'] . "</li>");
    }
}
?>