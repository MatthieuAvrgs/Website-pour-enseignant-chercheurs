<?php
session_start();
?>

<html>
    <head>
        <title>Soumettre</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css2.css"/>
        <script type="text/javascript">
            function cache(i) {
		var divLieu = document.getElementById('divLieu');
		switch(i) {
			case 2 : divLieu.style.display = ''; break;
			case 4 : divLieu.style.display = ''; break;
			default: divLieu.style.display = 'none'; break;
		}
	}
        </script>
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
                        <li class="actuel"><a>Soumettre</a></li>
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

        <?php
        if (empty($_SESSION['connecte'])) {
            echo("Vous devez être connecté en tant que chercheur de l'UTT pour pouvoir soumettre un article..<br/>");
            echo("<font size='1' class='connexion2'><a href='connexion.php'>Connectez-vous.</a></font>");
        } else {
            if (empty($_POST['titre']) && !verif_auteurs() && empty($_POST['categorie']) && empty($_POST['annee']) && empty($_POST['lieu'])) {
                formulaire_auteurs();
            } else {
                if (empty($_POST['titre']) OR ! verif_auteurs() OR ! unique_auteurs() OR empty($_POST['categorie']) OR empty($_POST['annee']) ) {
                    formulaire_auteurs();
                    probleme_champs();
                } else {
                    require_once 'database_projet.php';
                    $nouveau_article_id = 0;
                    $query = "SELECT id
            FROM articles
            WHERE id=(
            SELECT max(id)
            FROM articles)";
                    $resultat = mysqli_query($mabase, $query);
                    while ($ligne = mysqli_fetch_array($resultat, MYSQLI_ASSOC)) {
                        $nouveau_article_id = $ligne['id'] + 1;
                    }
                    enregistrement_article($mabase, $nouveau_article_id);
                }
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
                <li><a href="#">Publications</a>| </li>
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

function generation_auteurs($nombre_auteurs) {
    echo("<label><font size='1' color ='black'><i><b>Veuillez rentrer les auteurs dans l'ordre</b></i></label></font><br/>");
    for ($compteur = 1; $compteur < $nombre_auteurs + 1; $compteur++) {
        echo("Auteur numéro " . $compteur . " :");
        echo('<br/>');
        require_once 'database_projet.php';
        formulaire_deroulant($mabase, $compteur);

        echo("<input type='hidden' name='ordre_auteur_" . $compteur . "' value='" . $compteur . "'/>");
        echo('<br/>');
    }
}

function formulaire_deroulant($mabase, $compteur) {
    $query = "SELECT nom, prenom, id FROM auteurs order by nom";
    $resultat = mysqli_query($mabase, $query);
//creation menu deroulant
    echo("<select name='categorie$compteur'>");
    echo("<option value=''></option>");
    while ($ligne = mysqli_fetch_array($resultat, MYSQLI_ASSOC)) {
        $id = $ligne['id'];
        $nom = $ligne['nom'];
        $prenom = $ligne['prenom'];
        //Obligé de faire ça car après plusieurs diagnostic, lorsque la value etait egale a 0, cela ne marchait pas (voir reconversion de zero en 0 dans fonction enregistrement_publication())
        if ($id == 0) {
            echo("<option value='zero'>$nom $prenom</option>");
        } else {
            echo("<option value='$id'>$nom $prenom</option>");
        }
    }
    echo "</select>";
}

function formulaire_auteurs() {
    print <<<END
    <fieldset>
            <font color='black'><b>Ajouter un article (publication) :</b></font><br/><br/>
            <form method='POST'>
END;
    $nombre_auteurs = $_SESSION['nombre_auteurs'];
    generation_auteurs($nombre_auteurs);
    print <<<END
                <font size='1'>Si vous voulez rentrer un chercheur qui n'est pas dans la base, <a href="enregistrer_chercheur.php">cliquez ici.</a></font>
                <font size='1'>Changer le nombre <a href="soumettre_article.php">d'auteurs.</a></font>
                <br/><br/>
                <label>Titre :</label><br/>
                <input type='text' name='titre' size='15' maxlength='150' value=""/>
                <br/><br/>
                <label>Année :</label><br/>
                <input type='number' name='annee' min='1977' max='2016' value=''/>
                <br/><br/>
                <label>Catégorie :</label><br/>
                <select name="categorie" id="categorie" onChange="cache(this.selectedIndex);">
                    <option value=""></option>
                    <option value="RI">RI : Article dans des Revues Internationales</option>
                    <option value="CI">CI : Article dans des Conférences Internationales</option>
                    <option value="RF">RF : Article dans des Revues Françaises</option>
                    <option value="CF">CF : Article dans des Conférences Françaises</option>  
                    <option value="OS">OS : Ouvrage Scientifique</option>  
                    <option value="TD">TD : Thèse de Doctorat</option>  
                    <option value="BV">BV : Brevet</option>  
                    <option value="AP">AP : Autre Production</option>  
                </select>
                <br/><br/>
                <div style="display:none;" id="divLieu">
                <label>Lieu :</label><br/>
                <input type='text' name='lieu' size='15' maxlength='25' value=""/>
                <br/><br/>
                </div>
                <input type='submit' name='bouton' />
                <input type='reset' value='Annuler'/>
        </fieldset>
END;
}

function verif_auteurs() {
    $champs_rempli = TRUE;
    for ($compteur = 1; $compteur < $_SESSION['nombre_auteurs'] + 1; $compteur++) {
        $verif_auteur = $_POST["categorie$compteur"];
        if (empty($verif_auteur)) {
            $champs_rempli = FALSE;
        }
    }
    return $champs_rempli;
}

function probleme_champs() {
    echo('<ul>');
    if (!verif_auteurs()) {
        echo("<li>Veuillez remplir tous les champs des auteurs.</li>");
    }
    if (!unique_auteurs()) {
        echo("<li>Vous avez choisi plusieurs fois le même auteur !</li>");
    }

    if (empty($_POST['titre'])) {
        echo("<li>Vous n'avez pas saisi de titre.</li>");
    }
    if (empty($_POST['categorie'])) {
        echo("<li>Vous n'avez pas choisi de catégorie.</li>");
    }
    if (empty($_POST['annee'])) {
        echo("<li>Vous n'avez pas saisi d'année.</li>");
    }
    if ($_POST['categorie']=="CI" OR $_POST['categorie']=="CF"){
    if (empty($_POST['lieu'])) {
        echo("<li>Vous n'avez pas saisi de lieu.</li>");
        }
    }
    echo('</ul>');
}

function unique_auteurs() {
    $unique = TRUE;
    for ($compteur1 = 1; $compteur1 < $_SESSION['nombre_auteurs'] + 1; $compteur1++) {
        $id_auteur1 = $_POST["categorie$compteur1"];
        for ($compteur2 = $compteur1 + 1; $compteur2 < $_SESSION['nombre_auteurs'] + 1; $compteur2++) {
            $id_auteur2 = $_POST["categorie$compteur2"];
            if ($id_auteur1 == $id_auteur2) {
                $unique = FALSE;
            }
        }
    }
    return $unique;
}

function enregistrement_article($mabase, $nouveau_article_id) {
    //verification qu'il n'existe pas dans la base
    $titre = $_POST['titre'];
    $categorie = $_POST['categorie'];
    $annee = $_POST['annee'];
    $lieu = $_POST['lieu'];
    $nombre_auteurs = $_SESSION['nombre_auteurs'];

    $query = "select titre, categorie, annee, lieu from articles";
    $resultat = mysqli_query($mabase, $query);
    if ($resultat) {
        $existance = FALSE;
        //Pour lire toutes les lignes du tableau
        while ($ligne = mysqli_fetch_array($resultat, MYSQLI_ASSOC)) {
            //renvoie la rep du formulaire en minuscule
            $titre1 = strtolower($_POST["titre"]);
            $categorie1 = strtolower($_POST["categorie"]);
            $annee1 = $_POST["annee"];
            $lieu1 = strtolower($_POST["lieu"]);
            $titre2 = strtolower($ligne['titre']);
            $categorie2 = strtolower($ligne['categorie']);
            $annee2 = $ligne['annee'];
            $lieu2 = strtolower($ligne['lieu']);

            //SI le titre, cat, annee... existent dans la base
            if ($titre1 == $titre2 && $categorie1 == $categorie2 && $annee1 == $annee2 && $lieu1 == $lieu2) {
                $existance = TRUE;
            }
        }
        //S'il n'existe pas dans la base
        if ($existance == FALSE) {
            global $mabase;
            $query = "INSERT INTO articles VALUES ($nouveau_article_id, '$categorie', '$titre', $annee, '$lieu', $nombre_auteurs);";
            $resultat = mysqli_query($mabase, $query);
            //si tout marche, enregistrer publication
            if ($resultat) {
                echo('Article bien enregistré dans la base');
                echo("<br/><font size='1'>Enregistrer un autre <a href='soumettre_article.php'>article.</a></font>");
                enregistrement_publication($mabase, $nouveau_article_id);
            } else {
                echo(mysqli_error($mabase));
            }
        } else {
            echo("L'article est deja dans la base. (même titre, catégorie, année, lieu)<br/>Vous ne pouvez pas l'enregistrer deux fois");
            echo("<br/><font size='1'>Enregistrer un autre <a href='soumettre_article.php'>article.</a></font>");
        }
    } else {
        echo("<li><br/>La requete est incorrecte car : <br/>");
        echo(mysqli_error($mabase));
        echo('</li>');
        echo('<ul>');
    }
}

function enregistrement_publication($mabase, $nouveau_article_id) {
//sauvegarde publication si elle n'existe pas deja dans la table
    for ($compteur = 1; $compteur < $_SESSION['nombre_auteurs'] + 1; $compteur++) {
        //Reconversion de zero en 0 (voir dans la fonction formulaire_deroulant() sinon probleme)
        if ($_POST["categorie$compteur"] == 'zero') {
            $auteur_id = '0';
        } else {
            $auteur_id = $_POST["categorie$compteur"];
        }
        $query = "INSERT INTO publications values ($nouveau_article_id, $auteur_id, $compteur)";
        $resultat = mysqli_query($mabase, $query);
        if ($resultat) {
            echo("<br/>Chercheur $compteur associé à l'article");
        } else {
            echo("<li><br/>La requete est incorrecte car : <br/>");
            echo(mysqli_error($mabase));
            echo('</li>');
            echo('<ul>');
        }
    }
}
?>