<?php
session_start();
?>

<html>
    <head>
        <title>Inscription</title>
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
                        <li class="actuel"><a>Inscription</a></li>
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
        <fieldset>
        <?php
        if (!empty($_SESSION['connecte'])) {
            echo($_SESSION['prenom'] . " " . $_SESSION['nom'] . ", vous êtes déjà inscrit.<br/>");
            echo("<font size='1'><a href='deconnexion.php'>Déconnectez-vous.</a></font>");
        } else {
            if (isset($_SESSION['nom'])) {
                echo($_SESSION['prenom'] . "" . $_SESSION['nom'] . ", vous êtes déjà inscrit.<br/>");
                echo("<font size='1'><a href='deconnexion.php'>Déconnectez-vous.</a></font>");
            } else {
                //Si rien est saisi
                if (empty($_POST['nom']) && empty($_POST['prenom']) && empty($_POST['organisation']) && empty($_POST['login']) && empty($_POST['mdp1']) && empty($_POST['mdp2'])) {
                    formulaire_inscription();
                } else {
//On verifie si le nom, prenom, orga... a été bien saisi
                    if (verif_nom($_POST['nom']) && !empty($_POST['equipe']) && verif_nom($_POST['prenom']) && verif_login($_POST['login']) && verification_mdp($_POST['mdp1'], $_POST['mdp2'])) {
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
                        if (!verif_nom($_POST['prenom'])) {
                            echo("<li>Vous n'avez pas saisi aucun prenom ou votre prenom n'est pas correct (caractères spéciaux)</li>");
                        }
                        if (empty($_POST['equipe'])) {
                            echo("<li>Veuillez choisir une équipe</li>");
                        }
                        if (!verif_login($_POST['login'])) {
                            echo("<li>Vous n'avez pas saisi aucun login ou votre login n'est pas correct (caractères spéciaux)</li>");
                        }
                        if (!verification_mdp($_POST['mdp1'], $_POST['mdp2'])) {
                            echo("<li>Vous n'avez pas saisi les 2 mots de passe ou vos mots de passe ne sont pas identiques</li>");
                        }
                        echo('</ul>');
                    }
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

function formulaire_inscription() {
    print <<<END

            <font color='black'><b>Inscrivez-vous (UTT seulement) :</b></font><br/><br/>
            <form method='POST'>
                <label>Nom :</label><br/>
                <input type='text' name='nom' size='15' maxlength='45' value=""/>
                <br/><br/>
                <label>Prenom :</label><br/>
                <input type='text' name='prenom' size='15' maxlength='45' value=""/>
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
                    <option value="Tech-CICO">Tech-CICO : Technologies pour la Coopération, l'Interaction et les Connaissances dans les collectifs</option>  
                </select>
                <br/><br/>
                <label>Login :</label><br/>
                <input type='text' name='login' size='15' maxlength='15' value=""/>
                <br/><br/>
                <label>Mot de passe :</label><br/>
                <input type='password' name='mdp1' size='15' maxlength='25' value=""/>
                <br/><br/>
                <label>Confirmation mot de passe :</label><br/>
                <input type='password' name='mdp2' size='15' maxlength='25' value=""/>
                <br/><br/>
                <input type='submit' name='bouton' />
                <input type='reset' value='Annuler'/>
            </form>
            <font size='1'>Si vous avez déjà un compte, <a href="connexion.php">connectez-vous</a></font>
            <br/>

END;
}

//fonction pour verifier si une chaine est composé uniquement de lettre de l'alphabet et chiffres(0-9)
function verif_login($chaine) {
    if (empty($chaine)) {
        return false;
    } else {
        if (preg_match('/^[a-zA-Z\d]+[\w.-]*[a-zA-Z\d]$/', $chaine)) {
            return true;
        } else {
            return false;
        }
    }
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


function verification_mdp($mdp1, $mdp2) {
    if (empty($mdp1)OR empty($mdp2)) {
        return false;
    } else {
        if ($mdp1 !== $mdp2) {
            return false;
        } else {
            return true;
        }
    }
}

function enregistrement_base($mabase, $nouveau_id) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $organisation = 'UTT';
    $equipe = $_POST['equipe'];
    $login = $_POST['login'];
    $mdp = $_POST['mdp1'];
//On va verifier qu'il n'existe pas dans la base
//On se connecte à la base
    $query = "select id, nom, prenom, equipe from auteurs";
    $resultat = mysqli_query($mabase, $query);
    if ($resultat) {
        $existence_chercheur = FALSE;
        //Pour lire toutes les lignes du tableau
        while ($ligne = mysqli_fetch_array($resultat, MYSQLI_ASSOC)) {
            //renvoie la rep du formulaire en minuscule (plus facile pour tester l'egalité
            $prenom1 = strtolower($_POST["prenom"]);
            $nom1 = strtolower($_POST["nom"]);
            $equipe1 = strtolower($_POST["equipe"]);
            $prenom2 = strtolower($ligne['prenom']);
            $nom2 = strtolower($ligne['nom']);
            $equipe2 = strtolower($ligne['equipe']);
            //SI le nom et prenom existent dans la base
            if ($prenom1 == $prenom2 && $nom1 == $nom2 && $equipe1 == $equipe2) {
                //Important de connaitre la position du doublon pour la suite
                $position = $ligne["id"];
                $existence_chercheur = TRUE;
            }
        }
        //Si le nom et prenom n'existent pas ds la base on insere les nouvelles valeurs

        if ($existence_chercheur == FALSE) {
//mais avant on doit tester si le login n'est pas deja utilisé par un autre utilisateur
            $existence_login = FALSE;
            $query = "select login from auteurs";
            $resultat = mysqli_query($mabase, $query);
            while ($ligne = mysqli_fetch_array($resultat, MYSQLI_ASSOC)) {
                $login1 = $_POST["login"];
                $login2 = $ligne["login"];
                //SI le login existe dans la base
                if ($login1 == $login2) {
                    $existence_login = TRUE;
                }
            }
            if ($existence_login == TRUE) {
                echo("Désolé le login est deja utilisé pas un autre utilisateur");
                echo("<br/><font size='1'>Retour :<a href='inscription.php'>Insciption</a></font>");
            } else {
                $query = "insert into auteurs values ($nouveau_id, '$nom','$prenom', '$organisation', '$equipe', '$login', '$mdp');";
                $resultat = mysqli_query($mabase, $query);
                if ($resultat) {
                    echo('Vous êtes connecté(e)');
                    echo('<p/>');
//Creation de session

                    $_SESSION['id'] = $nouveau_id;
                    $_SESSION['login'] = $_POST['login'];
                    $_SESSION['mdp'] = $_POST['mdp1'];
                    $_SESSION['nom'] = $_POST['nom'];
                    $_SESSION['prenom'] = $_POST['prenom'];
                    $_SESSION['connecte'] = TRUE;
                    echo("Bienvenu(e) " . $_SESSION['prenom'] . " " . $_SESSION['nom'] . ".");
                } else {
                    echo(mysqli_error($mabase));
                }
            }
        }
        //Si le chercheur est deja dans la base 
        else {
            //On demande le login et le mdp du doublon deja enregistré dans la base
            $query = "Select id, login, mdp from auteurs where id=$position";
            $resultat = mysqli_query($mabase, $query);
            if ($resultat) {
                $ligne = mysqli_fetch_array($resultat, MYSQLI_ASSOC);
                //Si le chercheur a été enregistré auparavant mais n'a pas de login et mdp
                if ($ligne["login"] == "" && $ligne["mdp"] == "") {
                    $query = "update auteurs set login='$login', mdp='$mdp' where id=$position";
                    $resultat = mysqli_query($mabase, $query);
                    if ($resultat) {
                        echo("Vous etes deja enregistré dans la base en tant que chercheur mais aucun login et mdp n'etait connus, on a donc fusionné vos comptes pour n'en faire qu'un seul.");
                        echo('<br/>');
                        echo('<br/>');
                        echo('Vous etes maintenant inscrit :');
                        echo('<br/>');
//Creation de session
                        $_SESSION['id'] = $ligne['id'];
                        $_SESSION['login'] = $_POST['login'];
                        $_SESSION['mdp'] = $_POST['mdp1'];
                        $_SESSION['nom'] = $_POST['nom'];
                        $_SESSION['prenom'] = $_POST['prenom'];
                        $_SESSION['connecte'] = TRUE;
                        echo("Bienvenu(e) " . $_SESSION['prenom'] . " " . $_SESSION['nom'] . ".");
                    } else {
                        echo(mysqli_error($mabase));
                    }
                }
                //Si le chercheurs existe deja dans la base et qu'il a deja un mdp et login
                else {
                    echo("Vous etes déja inscrit, vous possedez deja un login et mot de passe.");
                    echo("<br/>");
                    echo("<font size='1'>Vous avez déjà un compte, <a href='connexion.php'>connectez-vous</a></font>");
                }
            } else {
                echo(mysqli_error($mabase));
            }
        }
    } else {
        echo("<li><br/>La requete est incorrecte car : <br/>");
        echo(mysqli_error($mabase));
        echo('</li>');
        echo('<ul>');
    }
}
?>

