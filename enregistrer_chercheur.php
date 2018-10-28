<?php
session_start();
?>

<html>
    <head>
        <title>Enregistrement</title>
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
                <li class="actuel">Compte
                    <ul class="niveau2A">
                        <li><a href="connexion.php">Connexion</a></li>
                        <li><a href="inscription.php">Inscription</a></li>
                        <li class="actuel"><a>Hors UTT</a></li>
                    </ul>
                </li>
                <li><a>Article</a>
                    <ul class="niveau2B">
                        <li><a href="soumettre_article.php">Soumettre</a></li>
                        <li><a href="modifier_article.php">Modifier</a></li>
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
            <fieldset>
                <?php
                if (empty($_SESSION['connecte'])) {

                    echo("Vous devez être connecté en tant que chercheur de l'UTT pour  pouvoir enregistrer un nouveau chercheur dans la base.<br/>");
                    echo("<font size='1' class='connexion2'><a href='connexion.php'>Connectez-vous.</a></font>");
                } else {
//Si rien est saisi
                    if (empty($_POST['nom']) && empty($_POST['prenom']) && empty($_POST['organisation'])) {
                        formulaire_inscription();
                    } else {
//On verifie si le nom, prenom, orga... a été bien saisi
                        if (verif_nom($_POST['nom']) && !empty($_POST['equipe']) && verif_nom($_POST['prenom']) && verification_organisation($_POST['organisation'])) {
//Ok ça a été bien saisi on enregistre dans la base
//Compteur id pour savoir à quelle place on enregistre le nouvel utilisateur
                            require_once 'database_projet.php';
                            $nouveau_id = 0;
                            $query = "SELECT id
            FROM auteurs
            WHERE id=(
            SELECT max(id)
            FROM auteurs)";
                            $resultat = mysqli_query($mabase, $query);
                            while ($ligne = mysqli_fetch_array($resultat, MYSQLI_ASSOC)) {
                                $nouveau_id = $ligne['id'] + 1;
                            }
                            enregistrement_base($mabase, $nouveau_id);
                        } else {
//Pas bien saisi, on affiche l'erreur à l'utilisateur
                            formulaire_inscription();
                            echo('<ul>');
                            if (!verif_nom($_POST['nom'])) {
                                echo("<li>Vous n'avez pas saisi aucun nom ou votre nom n'est pas correct (caractères spéciaux)</li>");
                            }
                            if (empty($_POST['equipe'])) {
                                echo("<li>Veuillez choisir une équipe</li>");
                            }
                            if (!verif_nom($_POST['prenom'])) {
                                echo("<li>Vous n'avez pas saisi aucun prenom ou votre prenom n'est pas correct (caractères spéciaux)</li>");
                            }
                            if (!verification_organisation($_POST['organisation'])) {
                                echo("<li>Vous n'avez pas saisi aucune organisation ou votre organisation n'est pas correct (caractères spéciaux)</li>");
                            }
                            echo('</ul>');
                        }
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
                    <li><a href="visualisation.php">Admin</a></li>
                </ul>
                <p class="nom">AVARGUES Matthieu & Kévin VYAS</p>


                <ul class="templateworld">
                    <li>Design by:</li>
                    <li><a href="http://www.templateworld.com" target="_blank">Template World</a></li>
                </ul>
            </div>
        </div>
    </body>
</html>


<?php

function formulaire_inscription() {
    print <<<END

    <font color='black'><b>Enregistrer un chercheur Hors UTT</b></font><br/><br/>
    <form method='POST'>
        <label>Nom :</label><br/>
        <input type='text' name='nom' size='15' maxlength='45' value=""/>
        <br/><br/>
        <label>Prenom :</label><br/>
        <input type='text' name='prenom' size='15' maxlength='45' value=""/>
        <br/><br/>
        <div>Organisation :</div>
        <input type='text' name='organisation' size='15' maxlength='45' value=""/>
        <br/><br/>
        <label>Équipe :</label><br/>
        <select name="equipe">
            <option value=""></option>
            <option value="CREIDD">CREIDD : Centre de Recherches et d'Etudes Interdisciplinaires sur le Développement Durable</option>
            <option value="ERA">ERA : Environnement de Réseaux Autonomes</option>
            <option value="GAMMA3">GAMMA3 : Génération Automatique de Maillage et Méthodes Avancées</option>
            <option value="LASMIS">LASMIS : Systèmes Mécaniques et Ingénierie Simultanée</option>  
            <option value="LM2S">LM2S : Modélisation et Sûreté des Systèmes</option>  
            <option value="LNIO">LNIO : Nanotechnologie et Instrumentation Optique</option>  
            <option value="LOSI">LOSI : Optimisation des Systèmes Industriels</option>  
            <option value="Tech-CICO">Tech-CICO : Technologies pour la Coopération, l'Interaction et les COnnaissances dans les collectifs</option>  
        </select>
        <br/><br/>
        <input type='submit' name='bouton' />
        <input type='reset' value='Annuler'/>
    </form>


END;
}

//fonction pour verifier si le nom est conforme (lettres, accents, espaces, apostrophes, tirets)
function verif_nom($chaine) {
    if (empty($chaine)) {
        return false;
    } else {
        if (preg_match('^([a-zA-Zéèêëïöôùç](([\ \-\']{1})?[a-zA-Z])+){1,30}$^', $chaine)) {
            return true;
        } else {
            return false;
        }
    }
}

function verification_organisation($chaine) {
    if (empty($chaine)) {
        return false;
    } else {
        if (preg_match('^([a-zA-Z0-9éèêëïöôùç](([\ \-\']{1})?[a-zA-Z0-9])+){1,30}$^', $chaine)) {
            return true;
        } else {
            return false;
        }
    }
}

function enregistrement_base($mabase, $nouveau_id) {
    global $nouveau_id;
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $organisation = $_POST['organisation'];
    $equipe = $_POST['equipe'];
//On va verifier qu'il n'existe pas dans la base
//On se connecte à la base
    $query = "select nom, prenom, equipe, organisation from auteurs";
    $resultat = mysqli_query($mabase, $query);
    if ($resultat) {
        $existance = FALSE;
        //Pour lire toutes les lignes du tableau
        while ($ligne = mysqli_fetch_array($resultat, MYSQLI_ASSOC)) {
            //renvoie la rep du formulaire en minuscule
            $prenom1 = strtolower($_POST["prenom"]);
            $nom1 = strtolower($_POST["nom"]);
            $organisation1 = strtolower($_POST["organisation"]);
            $equipe1 = strtolower($_POST["equipe"]);
            $prenom2 = strtolower($ligne['prenom']);
            $nom2 = strtolower($ligne['nom']);
            $organisation2 = strtolower($ligne['organisation']);
            $equipe2 = strtolower($ligne['equipe']);

            //SI le nom et prenom existent dans la base
            if ($prenom1 == $prenom2 && $nom1 == $nom2 && $organisation1 == $organisation2 && $equipe1 == $equipe2) {
                $existance = TRUE;
            }
        }
        //Si le nom et prenom n'existent pas ds la base on insere les nouvelles valeurs
        if ($existance == FALSE) {
            global $mabase;
            $query = "INSERT INTO auteurs (id, nom, prenom, organisation, equipe, login, mdp) VALUES ($nouveau_id, '$nom', '$prenom', '$organisation', '$equipe', '', '');";
            $resultat = mysqli_query($mabase, $query);
            if ($resultat) {
                echo('Chercheur bien enregistré dans la base');
                echo("<br/><font size='1'>Enregistrer un autre <a href='enregistrer_chercheur.php'>chercheur.</a></font>");
                echo("<br/><font size='1'>Enregistrer un <a href='soumettre_article.php'>article.</a></font>");
            } else {
                echo(mysqli_error($mabase));
            }
        } else {
            echo("Le chercheur est déjà dans la base. (même nom, prenom, organisation, equipe)<br/>Vous ne pouvez pas l'enregistrer deux fois");
            echo("<br/><font size='1'>Enregistrer un autre <a href='enregistrer_chercheur.php'>chercheur.</a></font>");
        }
    } else {
        echo("<li><br/>La requete est incorrecte car : <br/>");
        echo(mysqli_error($mabase));
        echo('</li>');
        echo('<ul>');
    }
}
?>
