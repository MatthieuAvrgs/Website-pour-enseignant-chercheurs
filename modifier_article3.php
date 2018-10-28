<?php
session_start();
?>
<html>
    <head>
        <title>Modifier</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css2.css"/>
        <script type="text/javascript">
            function cache(i) {
		var divLieu = document.getElementById('divLieu');
		switch(i) {
			case 1 : divLieu.style.display = ''; break;
			case 3 : divLieu.style.display = ''; break;
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
                        <li><a href="soumettre_article.php">Soumettre</a></li>
                        <li class="actuel"><a>Modifier</a></li>
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
            echo("Vous devez être connecté en tant que chercheur de l'UTT pour pouvoir modifier un article de la base.<br/>");
            echo("<font size='1' class='connexion2'><a href='connexion.php'>Connectez-vous.</a></font>");
        } else {
            if (isset($_POST['bouton1']) OR isset($_POST['bouton2'])) {
                affichage_article_selectionne();
            } else {
                if (empty($_POST['titre']) && !verif_auteurs() && empty($_POST['categorie']) && empty($_POST['annee']) && verif_lieu()) {
                    affichage_article_selectionne();
                } else {
                    if (empty($_POST['titre']) OR ! verif_auteurs() OR ! unique_auteurs() OR empty($_POST['categorie']) OR empty($_POST['annee']) OR !verif_lieu()) {
                        affichage_article_selectionne();
                        probleme_champs();
                    } else {
                        echo "<fieldset>";
                        require_once 'database_projet.php';
                        if (meme_article($mabase)) {
                            echo("Les informations rentrées sont les mêmes qu'auparavant.");
                        } else {
                            //fonction enregistrement
                            enregistrement_article($mabase);
                            enregistrement_publication($mabase);
                        }
                        echo("<br/><font size='1'>Modifier un autre <a href='modifier_article.php'>article.</a></font></fieldset>");
                    }
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

function affichage_article_selectionne() {
    require_once 'database_projet.php';
    $article_id = $_POST['article_id'];
    $query = "SELECT nom, prenom, article_id, auteur_id, ordre FROM publications p, auteurs a WHERE (a.id=p.auteur_id) AND article_id=$article_id ORDER BY ordre";
    $resultat = mysqli_query($mabase, $query);
    echo("<ul>");
    echo("<fieldset>");
    echo("<b>Voici l'article que vous avez sélectionné :</b><br/><br/>");
    echo("<b>Auteurs dans l'ordre :</b>");
    while ($ligne = mysqli_fetch_array($resultat, MYSQLI_ASSOC)) {
        $nom = $ligne['nom'];
        $prenom = $ligne['prenom'];
        echo(" $nom $prenom, ");
    }

    //Lecture des articles_id que l'auteur a ecrit
    $query = "SELECT categorie, titre, annee, lieu, nbr_auteurs FROM articles WHERE id=$article_id";
    $resultat = mysqli_query($mabase, $query);
    echo("<form method='POST' action='modifier_article3.php'>");
    while ($ligne = mysqli_fetch_array($resultat, MYSQLI_ASSOC)) {
        $titre = $ligne['titre'];
        $categorie = $ligne['categorie'];
        $annee = $ligne['annee'];
        $lieu = $ligne['lieu'];
        $nbr_auteurs = $ligne['nbr_auteurs'];

        echo("<li><label><b>Titre : </b></label>" . $titre . "</li>");
        echo("<li><label><b>Catégorie : </b></label>" . $categorie . "</li>");
        echo("<li><label><b>Année : </b></label>" . $annee . "</li>");
        echo("<li><label><b>Lieu : </b></label>" . $lieu . "</li>");
        echo("<li><label><b>Nombre d'auteur(s) : </b></label>" . $nbr_auteurs . "</li>");
        echo("<br/><font size='1'>Modifier un autre <a href='modifier_article.php'>article.</a></font>");
        echo("</fieldset><br/>");

        echo("<fieldset>");
        echo("<b>Modifier l'article :</b><br/>");

        affichage_auteurs($mabase, $article_id);
        echo("<br/><br/>");

        echo("<label>Titre :</label><br/>");
        echo("<input type='text' name='titre' size='15' maxlength='150' value='$titre'/>");
        echo("<br/><br/>");
        echo("<label>Année :</label><br/>");
        echo("<input type='number' name='annee' min='1977' max='2016' value='$annee'/>");
        echo("<br/><br/>");
        echo("<label>Catégorie :</label><br/>");
        echo("<select name='categorie' id='categorie' value='$categorie' onChange='cache(this.selectedIndex);'>");
        echo("<option value='RI'>RI : Article dans des Revues Internationales</option>");
        echo("<option value='CI'>CI : Article dans des Conférences Internationales</option>");
        echo("<option value='RF'>RF : Article dans des Revues Françaises</option>");
        echo("<option value='CF'>CF : Article dans des Conférences Françaises</option>  ");
        echo("<option value='OS'>OS : Ouvrage Scientifique</option>  ");
        echo("<option value='TD'>TD : Thèse de Doctorat</option> ");
        echo("<option value='BV'>BV : Brevet</option>");
        echo("<option value='AP'>AP : Autre Production</option>  ");
        echo("</select>");
        echo("<br/><br/>");
        echo("<div style='display:none;' id='divLieu'>");
        echo("<label>Lieu :</label><br/>");
        echo("<input type='text' name='lieu' size='15' maxlength='25' value='$lieu'/>");
        echo("<br/><br/>");
        echo("</div>");
    }
    echo("<input type='submit' name='bouton3' value='Valider'/>");
    echo("<input type='reset' value='Annuler'/>");
    echo("</form>");
    echo("</fieldset>");
    echo("</ul>");
}

function affichage_auteurs($mabase, $article_id) {

    if (isset($_POST['bouton1'])) {

        $_POST['nbr_auteurs'] = $_POST['nbr_auteurs'] + 1;
        $nbr_auteurs = $_POST['nbr_auteurs'];
    }
    if ($_POST['nbr_auteurs'] > 1) {
        if (isset($_POST['bouton2'])) {
            $_POST['nbr_auteurs'] = $_POST['nbr_auteurs'] - 1;
            $nbr_auteurs = $_POST['nbr_auteurs'];
        }
    }
    $nbr_auteurs = $_POST['nbr_auteurs'];

    $query2 = "SELECT article_id, auteur_id, ordre FROM publications WHERE article_id=$article_id ORDER BY ordre";
    $resultat2 = mysqli_query($mabase, $query2);
    //compteur pour avoir le numero des auteurs et leur ordre
    for ($compteur = 1; $compteur < $nbr_auteurs + 1; $compteur++) {
        echo("<li>");
        echo("Auteur numéro " . $compteur . " :");
        echo('<br/>');

        $query3 = "SELECT nom, prenom, id FROM auteurs order by nom";
        $resultat3 = mysqli_query($mabase, $query3);
//creation menu deroulant

        echo("<select name = 'categorie$compteur' value=''>");
        echo("<option value=''></option>");
        echo($auteur_id);
        while ($ligne3 = mysqli_fetch_array($resultat3, MYSQLI_ASSOC)) {
            $id = $ligne3['id'];
            $nom = $ligne3['nom'];
            $prenom = $ligne3['prenom'];
            //Obligé de faire ça car après plusieurs diagnostic, lorsque la value etait egale a 0, cela ne marchait pas
            if ($id == 0) {
                echo("<option value='zero'>$nom $prenom</option>");
            } else {
                echo("<option value='$id'>$nom $prenom</option>");
            }
        }
        echo "</select>";
        echo('<br/>');
        echo('<br/>');
        echo("</li>");
    }
    echo("<input type='hidden' name='nbr_auteurs' value='$nbr_auteurs'/>");
    echo("<input type='hidden' name='article_id' value='$article_id'/>");
    echo("<input type='submit' name='bouton1' value='Ajouter_auteur'/>");
    echo("<input type='submit' name='bouton2' value='Supprimer_auteur'/>");
}

function verif_auteurs() {
    $champs_rempli = TRUE;
    for ($compteur = 1; $compteur < $_POST['nbr_auteurs'] + 1; $compteur++) {
        $verif_auteur = $_POST["categorie$compteur"];
        if (empty($verif_auteur)) {
            $champs_rempli = FALSE;
        }
    }
    return $champs_rempli;
}
function verif_lieu() {
    $champs_rempli = TRUE;
    if ($_POST['categorie']=='CF' OR $_POST['categorie']=='CI'){
        if (empty($_POST['lieu'])){
            $champs_rempli=FALSE;
        }
    }
    return $champs_rempli;
}

function unique_auteurs() {
    $unique = TRUE;
    for ($compteur1 = 1; $compteur1 < $_POST['nbr_auteurs'] + 1; $compteur1++) {
        $id_auteur1 = $_POST["categorie$compteur1"];
        for ($compteur2 = $compteur1 + 1; $compteur2 < $_POST['nbr_auteurs'] + 1; $compteur2++) {
            $id_auteur2 = $_POST["categorie$compteur2"];
            if ($id_auteur1 == $id_auteur2) {
                $unique = FALSE;
            }
        }
    }
    return $unique;
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
    if (!verif_lieu()) {
        echo("<li>Vous n'avez pas saisi de lieu.</li>");
    }
    echo('</ul>');
}

function enregistrement_article($mabase) {
    $new_categorie = $_POST['categorie'];
    $new_titre = $_POST['titre'];
    $new_annee = $_POST['annee'];
    if ($new_categorie == 'CI' OR $new_categorie == 'CF'){
        $new_lieu = $_POST['lieu'];
    }
    else {
        $new_lieu = '';
    }
    $new_nbr_auteurs = $_POST['nbr_auteurs'];
    $article_id = $_POST['article_id'];
    $query1 = "UPDATE articles SET categorie='$new_categorie', titre = '$new_titre', annee='$new_annee', lieu='$new_lieu', nbr_auteurs='$new_nbr_auteurs' WHERE id = $article_id";
    $resultat1 = mysqli_query($mabase, $query1);
    if ($resultat1) {
        echo("<br/>La mise à jour de l'article a bien été effectuée.");
    } else {
        echo(mysqli_error($mabase));
    }
}

function meme_article($mabase) {
    $meme_article = FALSE;
    $meme_publication = FALSE;
    $query1 = "SELECT categorie, titre, annee, lieu, nbr_auteurs FROM articles ";
    $resultat1 = mysqli_query($mabase, $query1);
    while ($ligne1 = mysqli_fetch_array($resultat1, MYSQLI_ASSOC)) {
        $categorie = strtolower($ligne1['categorie']);
        $titre = strtolower($ligne1['titre']);
        $annee = $ligne1['annee'];
        $lieu = strtolower($ligne1['lieu']);
        $nbr_auteurs = $ligne1['nbr_auteurs'];
        if ($categorie == strtolower($_POST['categorie']) && $titre == strtolower($_POST['titre']) && $annee == $_POST['annee'] && $lieu == strtolower($_POST['lieu']) && $nbr_auteurs == $_POST['nbr_auteurs']) {
            $meme_article = TRUE;
        }
    }
    if ($meme_article == TRUE) {
        //Si l'article existe deja mais est ce que les auteurs ont changé (ordre ou nom)
        if (meme_auteurs($mabase)) {
            $meme_publication = TRUE;
        }
    }

    return $meme_publication;
}

function meme_auteurs($mabase) {
    //verifier que ce sont pas les memes auteurds qu'avant
    $nbr_auteurs = $_POST['nbr_auteurs'];
    $article_id = $_POST['article_id'];
    $query2 = "SELECT auteur_id, article_id, ordre FROM publications WHERE article_id=$article_id ORDER BY ordre";
    $resultat2 = mysqli_query($mabase, $query2);
    $compteur = 0;
    $meme_auteurs = TRUE;
    while ($ligne2 = mysqli_fetch_array($resultat2, MYSQLI_ASSOC)) {
        $compteur = $compteur + 1;
        if ($_POST["categorie$compteur"] == 'zero') {
            $auteur_id2 = '0';
        } else {
            $auteur_id2 = $_POST["categorie$compteur"];
        }
        $auteur_id1 = $ligne2['auteur_id'];
        if ($auteur_id1 !== $auteur_id2) {
            $meme_auteurs = FALSE;
        }
    }
    return $meme_auteurs;
}

function enregistrement_publication($mabase) {
    $nbr_auteurs = $_POST['nbr_auteurs'];
    $article_id = $_POST['article_id'];
    $query1 = "DELETE FROM publications WHERE article_id=$article_id";
    $resultat1 = mysqli_query($mabase, $query1);
    if ($resultat1) {
        for ($compteur = 1; $compteur < $nbr_auteurs + 1; $compteur++) {
            //Reconversion de zero en 0 (voir dans la fonction formulaire_deroulant() sinon probleme)
            if ($_POST["categorie$compteur"] == 'zero') {
                $auteur_id = '0';
            } else {
                $auteur_id = $_POST["categorie$compteur"];
            }
            $query = "INSERT INTO publications values ($article_id, $auteur_id, $compteur)";
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
    } else {
        echo("Impossible<br/>");
        echo(mysqli_error($mabase));
    }
}
?>