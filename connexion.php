<?php
session_start();
?>
<html>
    <head>
        <title>Connexion</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css2.css"/>
    </head>

    <body>
        <div id="topPan">
            <div id="ImgPan"><a href="accueil.html"><img src="images.jpg" title="UTT" alt="UTT" width="400" height="100"/></a> </div>
            <ul id="menu">

                <li><a href="accueil.html">Accueil</a></li> 
                <li class="actuel">Compte
                    <ul class="niveau2A">
                        <li class="actuel"><a>Connexion</a></li>
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
                echo($_SESSION['prenom'] . " " . $_SESSION['nom'] . ", vous êtes déjà connecté.<br/>");
                echo("<font size='1'><a href='deconnexion.php'>Déconnectez-vous.</a></font>");
            } else {
                if (isset($_SESSION['nom'])) {
                    echo($_SESSION['prenom'] . "" . $_SESSION['nom'] . ", vous êtes déjà connecté.<br/>");
                    echo("<font size='1'><a href='deconnexion.php'>Déconnectez-vous.</a></font>");
                } else {
                    if (empty($_POST['login']) && empty($_POST['mdp'])) {
                        formulaire();
                    } else {
                        if (!empty($_POST['login']) && !empty($_POST['mdp'])) {
                            if ($_POST['login'] == 'administrateur' && $_POST['mdp'] == 'admin1234') {
                                $_SESSION['id'] = '';
                                $_SESSION['login'] = 'administrateur';
                                $_SESSION['mdp'] = 'admin1234';
                                $_SESSION['nom'] = '';
                                $_SESSION['prenom'] = 'Administrateur';
                                echo("Bonjour l'administrateur.<br/>Allez dans l'onglet admin pour avoir accès à vos fonctionnalités.<br/>");
                                echo("<font size='1'><a href='deconnexion.php'>Déconnectez-vous.</a></font>");
                            } else {
                                verification();
                            }
                        } else {
                            echo "Le login ou le mot de passe n'a pas été entré, ";
                            echo("<font size='1'><a href='connexion.php'>retour.</a></font>");
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
                <li><a href="#">Connexion</a> | </li>
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

function formulaire() {
    print <<<end
    
        <font color='black'><b>Connectez-vous</b></font><br/><br/>
            <form method='POST' action='#'>
                <label>Login :</label><br/>
                <input type='text' name='login' size='15' maxlength='15' value=""/>
                <br/><br/>
                <label>Mot de passe :</label><br/>
                <input type='password' name='mdp' size='15' maxlength='15' value=""/>
                <br/><br/>
                <input type='submit' name="bouton"/>
                <input type='reset' value='Annuler'/>
            </form>
        <font size='1'>Si vous n'avez pas de compte, <a href="inscription.php">inscrivez-vous</a></font>
        <br/>
    
end;
}

function verification() {
    $login = $_POST['login'];
    $mdp = $_POST['mdp'];

//verification du login et mot de passe
//On se connecte à la base
    require_once 'database_projet.php';
//On questionne la base pour savoir si le login existe
    $query = "SELECT id,nom,prenom,login,mdp
            FROM auteurs
            WHERE login='$login'";
    $resultat = mysqli_query($mabase, $query);
//Si le login existe dans la base
    while ($ligne = mysqli_fetch_array($resultat, MYSQLI_ASSOC)) {

        if ($resultat) {
//Si le login entré correspond a un login de la base
            if ($_POST['login'] == $ligne['login']) {
//Si le mot de passe entré correspond au login
                if ($ligne['mdp'] == $_POST['mdp']) {
                    echo('Vous êtes connecté(e).');
                    echo('<p/>');
//Creation de session
                    $_SESSION['id'] = $ligne['id'];
                    $_SESSION['login'] = $ligne['login'];
                    $_SESSION['mdp'] = $ligne['mdp'];
                    $_SESSION['nom'] = $ligne['nom'];
                    $_SESSION['prenom'] = $ligne['prenom'];
                    $_SESSION['connecte'] = TRUE;
                    echo("Bienvenu(e) " . $_SESSION['prenom'] . " " . $_SESSION['nom'] . ".");
                } else {
                    echo('Le mot de passe ne correspond pas au login, ');
                    echo("<font size='1'><a href='connexion.php'>retour.</a></font>");
                }
            }
        }
    }
//Si le login n'existe pas dans la base
    if (mysqli_num_rows($resultat) == 0) {
        echo('Le login est inconnu dans la base, ');
        echo("<font size='1'><a href='connexion.php'>retour.</a></font>");
    }
}
?>