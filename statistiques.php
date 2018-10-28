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
            echo "<fieldset>";
            echo("Seul l'administrateur à accès à cette page<br/>");
            echo("<font size='1'>Si vous êtes administrateur <a href='connexion.php'>connectez-vous.</a></font>");
            echo "</fieldset>";
        } else {
            if (isset($_SESSION['nom'])) {
                echo "<fieldset>";
                echo"<font color='black' size=4><b>Que voulez vous voir ?</b></font><br/><br/>";
                echo"<a href='stats_plus.php'>L'auteur qui a écrit le plus d'article</a><br/><br/>";
                echo"<a href='stats_plus_ordre.php'>L'auteur qui a écrit le plus d'article en tant qu'auteur n°1</a><br/><br/>";
                echo"<a href='stats_moins.php'>L'auteur qui a écrit le moins d'article</a><br/><br/>";
                echo"<a href='statsRI.php'>L'auteur qui a écrit le plus d'article de Revue Internationale (RI)</a><br/><br/>";
                echo"<a href='statsCI.php'>L'auteur qui a écrit le plus d'article de Conférence Internationale (CI)</a><br/><br/>";
                echo"<a href='statsRF.php'>L'auteur qui a écrit le plus d'article de Revue Française (RF)</a><br/><br/>";
                echo"<a href='statsCF.php'>L'auteur qui a écrit le plus d'article de Conférence Française (CF)</a><br/><br/>";
                echo"<a href='statsOS.php'>L'auteur qui a écrit le plus d'Ouvrage Scientifique (OS)</a><br/><br/>";
                echo"<a href='statsTD.php'>L'auteur qui a écrit le plus de Thèse de Doctorat (TD)</a><br/><br/>";
                echo"<a href='statsBV.php'>L'auteur qui a écrit le plus de Brevet (BV)</a><br/><br/>";
                echo"<a href='statsAP.php'>L'auteur qui a écrit le plus d'Autre Production (AP)</a><br/><br/>";
                echo "</fieldset>";
               
            } else {
                echo "<fieldset>";
                echo("Seul l'administrateur à accès à cette page<br/>");
                echo("<font size='1'>Si vous êtes administrateur <a href='connexion.php'>connectez-vous.</a></font>");
                echo "</fieldset>";
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