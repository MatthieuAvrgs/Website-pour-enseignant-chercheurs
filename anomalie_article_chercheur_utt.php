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
            <?php
            if (!empty($_SESSION['connecte'])) {
                echo("Seul l'administrateur à accès à cette page<br/>");
                echo("<font size='1'>Si vous êtes administrateur <a href='connexion.php'>connectez-vous.</a></font>");
            } else {
                if (isset($_SESSION['nom'])) {
                    require_once 'database_projet.php';
                    $au_moins_un_probleme = FALSE;
                    echo("<fieldset>");
                    $query = "SELECT id, titre, categorie, annee, lieu, nbr_auteurs FROM articles ORDER BY id";
                    $resultat = mysqli_query($mabase, $query);
                    while ($ligne = mysqli_fetch_array($resultat, MYSQLI_ASSOC)) {
                        $article_id = $ligne['id'];
                        $query2 = "SELECT article_id, auteur_id FROM publications WHERE article_id=$article_id";
                        $resultat2 = mysqli_query($mabase, $query2);
                        $auteur_utt = FALSE;
                        while ($ligne2 = mysqli_fetch_array($resultat2, MYSQLI_ASSOC)) {
                            $auteur_id = $ligne2['auteur_id'];
                            $query3 = "SELECT id, organisation FROM auteurs WHERE id=$auteur_id";
                            $resultat3 = mysqli_query($mabase, $query3);
                            while ($ligne3 = mysqli_fetch_array($resultat3, MYSQLI_ASSOC)) {
                                $organisation = strtolower($ligne3['organisation']);
                                if ($organisation == 'utt') {
                                    $auteur_utt = TRUE;
                                }
                            }
                        }
                        if ($auteur_utt == FALSE) {
                            $au_moins_un_probleme = TRUE;
                            $query5 = "SELECT auteur_id FROM publications WHERE article_id=$article_id";
                            $resultat5 = mysqli_query($mabase, $query5);
                            echo("Probleme à l'article :<br/>");
                            echo("<b>Auteurs :</b>");
                            while ($ligne5 = mysqli_fetch_array($resultat5, MYSQLI_ASSOC)) {
                                $auteur_id = $ligne5['auteur_id'];
                                $query4 = "SELECT nom, prenom FROM auteurs WHERE id=$auteur_id";
                                $resultat4 = mysqli_query($mabase, $query4);
                                while ($ligne4 = mysqli_fetch_array($resultat4, MYSQLI_ASSOC)) {
                                    $nom = $ligne4['nom'];
                                    $prenom = $ligne4['prenom'];
                                    echo(" $nom $prenom, ");
                                }
                            }
                            echo("<br/><label><b>Titre : </b></label>" . $ligne['titre'] . "<br/>");
                            echo("<label><b>Catégorie : </b></label>" . $ligne['categorie'] . "<br/>");
                            echo("<label><b>Année : </b></label>" . $ligne['annee'] . "<br/>");
                            echo("<label><b>Lieu : </b></label>" . $ligne['lieu'] . "<br/>");
                            echo("<label><b>Nombre d'auteur(s) : </b></label>" . $ligne['nbr_auteurs'] . "<br/><br/>");
                        }
                    }
                    if ($au_moins_un_probleme == FALSE) {
                        echo("<b>Il n'y a aucun problème de ce genre.</b>");
                    }
                    echo "<br/> <br/><a href='anomalies.php'>Retour</a>";
                    echo("</fieldset>");
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




