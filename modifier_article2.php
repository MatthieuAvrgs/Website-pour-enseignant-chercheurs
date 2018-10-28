<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0//EN" "http://www.w3.org/TR/REC-html40/strict.dtd">
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
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
            affichage_article_selectionne();
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

    //Lecture de l'article_id que l'auteur a ecrit
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
        echo("<option value='BV'>BV : Brevet</option>  ");
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
    echo('<br/>');
}

function affichage_auteurs($mabase, $article_id) {
    $query = "SELECT nbr_auteurs FROM articles WHERE id=$article_id";
    $resultat1 = mysqli_query($mabase, $query);
    while ($ligne = mysqli_fetch_array($resultat1, MYSQLI_ASSOC)) {
        $nbr_auteurs = $ligne['nbr_auteurs'];
    }
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
    echo("<font size='1'>Si vous voulez rentrer un chercheur qui n'est pas dans la base, <a href=\"enregistrer_chercheur.php\">cliquez ici.</a></font><br/>");
    echo("<input type='submit' name='bouton1' value='Ajouter_auteur'/>");
    echo("<input type='submit' name='bouton2' value='Supprimer_auteur'/>");
}
?>