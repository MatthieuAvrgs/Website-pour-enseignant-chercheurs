<?php
session_start();
?>

<html>
    <head>
        <title>Visualisation</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css2.css"/>
    </head>

    <body>
        <div id="topPan">
            <div id="ImgPan"><a href="index.html"><img src="images.jpg" title="UTT" alt="UTT" width="400" height="100"/></a> </div>
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
                        <li class="actuel"><a>Visualisation</a></li>
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
        <fieldset>
        <?php
        if (!empty($_SESSION['connecte'])) {
            echo("Seul l'administrateur à accès à cette page<br/>");
            echo("<font size='1'>Si vous êtes administrateur <a href='connexion.php'>connectez-vous.</a></font>");
        } else {
            if (isset($_SESSION['nom'])) {
                visualisation_utilisateurs();
            } else {
                echo("Seul l'administrateur à accès à cette page<br/>");
                echo("<font size='1'>Si vous êtes administrateur <a href='connexion.php'>connectez-vous.</a></font>");
            }
        }
        ?>
        </fieldset>
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

function visualisation_utilisateurs() {
    require_once 'database_projet.php';
    //Lecture des articles_id que l'auteur a ecrit

    echo("<b>Voici la liste des utilisateurs ayant un compte :</b><br/><br/>");
    $query = "SELECT * FROM auteurs WHERE login!='' ORDER BY nom, prenom";
    $resultat = mysqli_query($mabase, $query);
    echo("<table border='1'>");
    echo("<tr>");
    echo("<th>Nom</th>");
    echo("<th>Prénom</th>");
    echo("<th>Organisation</th>");
    echo("<th>Equipe</th>");
    echo("<th>Login</th>");
    echo("<th>Mot de passe</th>");
    echo("</tr>");
    while ($ligne = mysqli_fetch_array($resultat, MYSQLI_ASSOC)) {
        $nom = $ligne['nom'];
        $prenom = $ligne['prenom'];
        $organisation = $ligne['organisation'];
        $equipe = $ligne['equipe'];
        $login = $ligne['login'];
        $mdp = $ligne['mdp'];
        echo("<tr>");
        echo("<th>$nom</th>");
        echo("<th>$prenom</th>");
        echo("<th>$organisation</th>");
        echo("<th>$equipe</th>");
        echo("<th>$login</th>");
        echo("<th>$mdp</th>");
        echo("</tr>");
    }
    echo("</table>");
    echo("<br/><br/>");

    echo("<b>Voici la liste des chercheurs enregistrés qui n'ont pas de compte :</b><br/><br/>");
    $query = "SELECT * FROM auteurs WHERE login='' ORDER BY nom, prenom ";
    $resultat = mysqli_query($mabase, $query);
    echo("<table border='1'>");
    echo("<tr>");
    echo("<th>Nom</th>");
    echo("<th>Prénom</th>");
    echo("<th>Organisation</th>");
    echo("<th>Equipe</th>");
    echo("</tr>");
    while ($ligne = mysqli_fetch_array($resultat, MYSQLI_ASSOC)) {
        $nom = $ligne['nom'];
        $prenom = $ligne['prenom'];
        $organisation = $ligne['organisation'];
        $equipe = $ligne['equipe'];
        echo("<tr>");
        echo("<th>$nom</th>");
        echo("<th>$prenom</th>");
        echo("<th>$organisation</th>");
        echo("<th>$equipe</th>");
        echo("</tr>");
    }
    echo("</table>");
}

?>