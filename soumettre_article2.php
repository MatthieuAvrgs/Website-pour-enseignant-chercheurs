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
<fieldset>
        <?php
        if (empty($_SESSION['connecte'])) {
            echo("Vous devez être connecté en tant que chercheur de l'UTT pour pouvoir soumettre un article..<br/>");
            echo("<font size='1' class='connexion2'><a href='connexion.php'>Connectez-vous.</a></font>");
        } else {
            if (empty($_POST['nombre'])) {
                echo("Veuillez indiquer le nombre d'auteurs.<br/>");
                echo("<font size='1'>Retour soumettre <a href='soumettre_article.php'> article.</a></font>");
            } else {
                formulaire_auteurs();
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

        echo("<input type = 'hidden' name = 'ordre_auteur_" . $compteur . "' value = '" . $compteur . "'/>");
        echo('<br/>');
    }
}

function formulaire_deroulant($mabase, $compteur) {
    $query = "SELECT nom, prenom, id FROM auteurs order by nom";
    $resultat = mysqli_query($mabase, $query);
//creation menu deroulant
    echo("<select name = 'categorie$compteur'>");
    echo("<option value = ''></option>");
    while ($ligne = mysqli_fetch_array($resultat, MYSQLI_ASSOC)) {
        $id = $ligne['id'];
        $nom = $ligne['nom'];
        $prenom = $ligne['prenom'];
        //Obligé de faire ça car après plusieurs diagnostic, lorsque la value etait egale a 0, cela ne marchait pas
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
    
            <font color='black'><b>Ajouter un article (publication) :</b></font><br/><br/>
            <form method='POST' action='soumettre_article3.php'>
END;
    $nombre_auteurs = $_POST['nombre'];
    $_SESSION['nombre_auteurs'] = $_POST['nombre'];
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
       
END;
}
?>