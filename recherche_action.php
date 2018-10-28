<html>
    <head>
        <title>Recherche</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css2.css"/>
    </head>

    <body>
        <div id="topPan">
            <div id="ImgPan"><a href="accueil.html"><img src="images.jpg" title="UTT" alt="UTT" width="400" height="100"/></a> </div>

            <ul id="menu">
                <font size='1' class='connexion1'>Visiteur? Pour avoir accès à plus de pages, </font>
                <font size='1' class="connexion2"><a href="connexion.php">connectez-vous.</a></font>
                <li class="actuel">Accueil</li> 
                <li><a>Compte</a>
                    <ul class="niveau2A">
                        <li><a href="connexion.php">Connexion</a></li>
                        <li><a href="inscription.php">Inscription</a></li>
                        <li><a href="enregistrer_chercheur.php">Hors UTT</a></li>
                    </ul>
                </li>
                <li><a href="#">Article</a>
                    <ul class="niveau2B">
                        <li><a href="soumettre_article.php">Soumettre</a></li>
                        <li><a href="modifier_article.php">Modifier</a></li>
                    </ul>
                </li>
                <li class="actuel"><a>Recherche</a></li>
                <li><a href="#">Admin</a>
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
            $recherche_titre = $_POST['recherche_titre'];
            $recherche_equipe = $_POST['recherche_equipe'];
            $recherche_categorie = $_POST['recherche_categorie'];
            $recherche_auteur_nom = $_POST['recherche_auteur_nom'];
            $recherche_auteur_prenom = $_POST['recherche_auteur_prenom'];
            $recherche_annee = $_POST['recherche_annee'];


//--------------------------
            if (empty($_POST['recherche_titre'])) {
                $titre = "";
            } else {
                $titre = "AND titre LIKE '%$recherche_titre%' ";
            }
//--------------------------
            if (empty($_POST['recherche_equipe'])) {
                $equipe = "";
            } else {
                $equipe = "AND equipe = '$recherche_equipe' ";
            }
//--------------------------
            if (empty($_POST['recherche_annee'])) {
                $annee = "";
            } else {
                $annee = "AND annee = '$recherche_annee' ";
            }
//--------------------------
            if (empty($_POST['recherche_categorie'])) {
                $categorie = "";
            } else {
                $categorie = "AND categorie = '$recherche_categorie' ";
            }
//--------------------------
            if (empty($_POST['recherche_auteur_nom'])) {
                $auteur_nom = "";
            } else {
                $auteur_nom = "AND nom LIKE '%$recherche_auteur_nom%' ";
            }
//--------------------------
            if (empty($_POST['recherche_auteur_prenom'])) {
                $auteur_prenom = "";
            } else {
                $auteur_prenom = "AND prenom LIKE '%$recherche_auteur_prenom%' ";
            }
            //connexion base 
            require_once 'database_projet.php';
            //definition de la requete
            $query = "SELECT article_id , annee, categorie, equipe, ordre, nom, prenom, titre FROM articles a, auteurs at, publications p WHERE (a.id=p.article_id) and (at.id=p.auteur_id) " . $annee . $auteur_nom . $auteur_prenom . $categorie . $equipe . $titre . "GROUP BY titre ORDER BY annee ";

            $resultat = mysqli_query($mabase, $query);
            $compteur_auteur = 0;
            $compteur_article = 0;
            if (mysqli_num_rows($resultat) == 0) {
                echo "Il n'y a aucun article qui correspond à vos critères de recherche. <br/> <br/>";
            } else {
                while ($ligne = mysqli_fetch_array($resultat, MYSQLI_ASSOC)) {
                    $compteur_article = $compteur_article + 1;
                    echo "<font color='black' size='3'><b>Article n°" . $compteur_article . "</b></font><br/><br/>";
                    $query2 = "SELECT article_id , auteur_id, ordre, nom, prenom, equipe FROM articles a, auteurs at, publications p WHERE (a.id=p.article_id) and (at.id=p.auteur_id) AND article_id =" . $ligne['article_id'] . " ORDER BY ordre ;";
                    $resultat2 = mysqli_query($mabase, $query2);
                    while ($ligne2 = mysqli_fetch_array($resultat2, MYSQLI_ASSOC)) {
                        $compteur_auteur = $compteur_auteur + 1;
                        echo "<b>Nom auteur n°" . $compteur_auteur . " : </b>" . $ligne2['nom'] . "<br/>";
                        echo "<b>Prénom auteur n°" . $compteur_auteur . " : </b>" . $ligne2['prenom'] . "<br/>";
                        echo "<b>Équipe auteur n°" . $compteur_auteur . " : </b>" . $ligne2['equipe'] . "<br/>";
                    }


                    echo "<b>Titre : </b>" . $ligne['titre'] . "<br/>";
                    echo "<b>Année : </b>" . $ligne['annee'] . "<br/>";
                    echo "<b>Catégorie : </b>" . $ligne['categorie'] . "<br/><br/><br/>";
                    $compteur_auteur = 0;
                }
            }
            echo "<a href='recherche.php'>Retour</a>";
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
                <li><a href="#">Recherche</a> | </li>
                <li><a href="visualisation.php">Admin</a></li>
            </ul>
            <p class="nom">Créé par : AVARGUES Matthieu & Kévin VYAS</p>


            <ul class="templateworld">
                <li>Design by : </li>
                <li><a href="http://www.templateworld.com" target="_blank">Template World</a></li>
            </ul>
        </div>
    </div>
</body>
</html>
