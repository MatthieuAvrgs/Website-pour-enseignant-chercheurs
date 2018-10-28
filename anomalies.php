<?php
session_start();
?>

<html>
    <head>
        <title>Anomalies</title>
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
                        <li  class="actuel"><a>Anomalies </a></li>
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
                    
                    echo"<font color='black' size=4><b>Quelles anomalies voulez-vous vérifier ?</b></font><br/><br/>";
                    echo"<a href='anomalie_nbr_auteurs.php'>Verifier si le nombre d'auteurs de l'article correspond bien aux nombre d'auteurs associés à la publication.</a><br/><br/>";
                    //article avec deux fois le même auteur
                    echo"<a href='anomalie_meme_auteur.php'>Verifier qu'un auteur n'est pas associé deux fois au même article.</a><br/><br/>";
                    //article présent deux fois dans la base
                    echo"<a href='anomalie_article_distinct.php'>Verifier qu'un article n'est pas présent deux fois dans la base.</a><br/><br/>";
                    //article dont aucun auteur n'est un chercheur de l'UTT
                    echo"<a href='anomalie_article_chercheur_utt.php'>Verifier que tous les articles ont été écrit par au moins un chercheur de l'UTT.</a><br/><br/>";
                    
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

