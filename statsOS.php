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
                echo"<fieldset>";
                echo"<font color='black' size=4><b>Articles OS</b></font><br/><br/>";
                
                //connexion base
                require_once 'database_projet.php';

                //Combien d'auteurs ?
                $query_auteurs = "SELECT count(id) FROM auteurs";
                $resultat = mysqli_query($mabase, $query_auteurs);
                while ($ligne = mysqli_fetch_array($resultat, MYSQLI_ASSOC)) {
                    $nbr_auteurs = $ligne['count(id)'];
                }
                //Création de la table publications
                for ($i = 0; $i <= $nbr_auteurs; $i++) {
                    $nb_publications[] = 0;
                }

                
                $queryOS = "SELECT * FROM articles WHERE categorie = 'OS'";
                $resultatOS = mysqli_query($mabase, $queryOS);
                if (mysqli_num_rows($resultatOS) == 0) {
                    echo "Il n'y a aucun article dans la catégorie Ouvrages Scientifiques <br/> <br/>";
                    echo "<a href='statistiques.php'>Retour</a>";
                } else {
                    $i = 0;

                    //a chaque fois que un auteur a écris un OS, on incrémente la valeur dont la clé correspond à l'id
                    while ($ligneOS = mysqli_fetch_array($resultatOS, MYSQLI_ASSOC)) {
                        $query_publicationsOS = "SELECT article_id, auteur_id FROM publications WHERE article_id =" . $ligneOS['id'] . ";";
                        $resultat_publicationsOS = mysqli_query($mabase, $query_publicationsOS);
                        $compteur = 0;
                        while ($ligne_publicationsOS = mysqli_fetch_array($resultat_publicationsOS, MYSQLI_ASSOC)) {
                            for ($compteur = 0; $compteur <= $nbr_auteurs; $compteur++) {
                                if ($ligne_publicationsOS['auteur_id'] == $compteur) {
                                    $nb_publications[$compteur] = $nb_publications[$compteur] + 1;
                                }
                            }
                        }
                    }
                    
                    //Valeurs de références
                    $maxvalue[] = $nb_publications[0];
                    $maxid[] = 0;

                    //Les id max et la valeur max ?
                    foreach ($nb_publications as $key => $value) {
                        if ($value > $maxvalue[0]) {
                            $maxvalue[0] = $value;
                            $maxid[0] = $key;
                        }
                        if ($value == $maxvalue[0] AND $value != 0) {
                            $maxvalue[] = $value;
                            $maxid[] = $key;
                        }
                    }

                    //on supprime les valeurs de références
                    unset($maxid[0]);
                    unset($maxvalue[0]);


                    //On récupère la valeur max
                    $max = $maxvalue[1];

                    echo "Le(s) auteur(s) ayant écrit le plus d'Ouvrages Scientifiques (".$max.") sont : <br/><br/>";
                    echo "<ul>";
                    $numero = 0;
                    foreach ($maxid as $ele) {
                        $numero = $numero + 1;
                        echo("<li><b>Auteur n°$numero :</b></li>");
                        $query_final = "SELECT nom, prenom, organisation, equipe FROM auteurs WHERE id=" . $ele;
                        $resultat_final = mysqli_query($mabase, $query_final);
                        while ($ligne_final = mysqli_fetch_array($resultat_final, MYSQLI_ASSOC)) {
                            echo("Nom : " . $ligne_final['nom'] . "<br/>");
                            echo("Prenom : " . $ligne_final['prenom'] . "<br/>");
                            echo("Organisation : " . $ligne_final['organisation'] . "<br/>");
                            echo("Equipe : " . $ligne_final['equipe'] . "<br/><br/>");
                        }
                    }
                    echo "</ul>";
                    
                    echo "<a href='statistiques.php'>Retour</a>";
                    echo"</fieldset>";
                    
                }
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