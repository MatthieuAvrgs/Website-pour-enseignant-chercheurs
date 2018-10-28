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
                    echo ("<fieldset>");
                    require_once 'database_projet.php';
                    $query = "SELECT nbr_auteurs, id FROM articles order by id";
                    $resultat = mysqli_query($mabase, $query);
                    $nbr_problemes = 1;
                    $auteur = 'auteur';
                    while ($ligne = mysqli_fetch_array($resultat, MYSQLI_ASSOC)) {
                        $article_id = $ligne['id'];
                        $nbr_auteurs = $ligne['nbr_auteurs'];
                        $query2 = "SELECT count(auteur_id) as nbr FROM publications WHERE article_id=$article_id";
                        $resultat2 = mysqli_query($mabase, $query2);
                        while ($ligne2 = mysqli_fetch_array($resultat2, MYSQLI_ASSOC)) {
                            $nbr_auteurs_article = $ligne2['nbr'];
                            if ($nbr_auteurs_article != $nbr_auteurs) {
                                $table[$nbr_problemes] = $article_id;
                                $nbr_problemes = $nbr_problemes + 1;
                            }
                        }
                    }
//si il y a un probleme
                    if (isset($table[1])) {
                        //affichage des articles
                        for ($compteur = 1; $compteur < $nbr_problemes; $compteur++) {
                            echo ("<fieldset>");
                            echo ("<font color='black' size=4><b>Problème au niveau du nombre d'auteurs sur les articles suivants :</b></font><br/><br/>");
                            echo("<b>Article n°$compteur :</b><br/>");
                            echo"<br/>";
                            $query = "SELECT nom, prenom, article_id, auteur_id, ordre FROM publications p, auteurs a WHERE (a.id=p.auteur_id) AND article_id=$table[$compteur] ORDER BY ordre";
                            $resultat = mysqli_query($mabase, $query);
                            if (mysqli_num_rows($resultat)) {
                                echo("<b>Auteurs associés à cet article :</b>");
                                while ($ligne = mysqli_fetch_array($resultat, MYSQLI_ASSOC)) {
                                    $nom = $ligne['nom'];
                                    $prenom = $ligne['prenom'];
                                    echo(" $nom $prenom, ");
                                }
                            } else {
                                echo("<b>Aucun auteur est associé à l'article.</b>");
                            }
//Lecture des articles_id que l'auteur a ecrit
                            $query = "SELECT categorie, titre, annee, lieu, nbr_auteurs FROM articles WHERE id=$table[$compteur]";
                            $resultat = mysqli_query($mabase, $query);
                            echo("<ul>");
//Pour avoir tous les noms des auteurs
//lecture de chaque champ
                            while ($ligne = mysqli_fetch_array($resultat, MYSQLI_ASSOC)) {
                                echo("<li><label><b>Le nombre d'auteurs est censé être : </b></label>" . $ligne['nbr_auteurs'] . " d'après les informations rempli sur l'article.</li>");
                                echo("<li><label><b>Titre : </b></label>" . $ligne['titre'] . "</li>");
                                echo("<li><label><b>Catégorie : </b></label>" . $ligne['categorie'] . "</li>");
                                echo("<li><label><b>Année : </b></label>" . $ligne['annee'] . "</li>");
                                echo("<li><label><b>Lieu : </b></label>" . $ligne['lieu'] . "</li><br/>");
                            }
                            echo "<a href='anomalies.php'>Retour</a>";
                        }
                    } else {
                        echo('<b>Aucune anomalie de ce genre.</b>');
                    }
                    echo "<br/><br/><a href='anomalies.php'>Retour</a>";
                    echo ("</fieldset>");
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




