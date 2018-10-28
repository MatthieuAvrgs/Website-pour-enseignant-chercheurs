<?php
session_start();
?>

<script type='text/javascript'>
    function verif_annee(nombre) {
                var year = parseInt(nombre.value);
                if (year<1977 || year>2016) {
                    alert('Il n\'y a aucun article publié avant 1977 ou après 2016');
                }
            }

</script>
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
                <li class="actuel">Recherche</a></li>
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
            <font color='black' size=4><b>Rechercher un article</b></font><br/><br/>
            <form name="recherche" method="post" action="recherche_action.php">
                <label>Mot clé :</label><br/>
                <input type='text' name='recherche_titre' size='25'"/>
                <br/><br/>
                <label>Équipe :</label><br/>
                <select name="recherche_equipe">
                    <option value=""></option>
                    <option value="CREIDD">CREIDD : Centre de Recherches et d'Etudes Interdisciplinaires sur le Développement Durable</option>
                    <option value="ERA">ERA : Environnement de Réseaux Autonomes</option>
                    <option value="GAMMA3">GAMMA3 : Génération Automatique de Maillage et Méthodes Avancées</option>
                    <option value="LASMIS">LASMIS : Systèmes Mécaniques et Ingénierie Simultanée</option>  
                    <option value="LM2S">LM2S : Modélisation et Sûreté des Systèmes</option>  
                    <option value="LNIO">LNIO : Nanotechnologie et Instrumentation Optique</option>  
                    <option value="LOSI">LOSI : Optimisation des Systèmes Industriels</option>  
                    <option value="Tech-CICO">Tech-CICO : Technologies pour la Coopération, l'Interaction et les Connaissances dans les collectifs</option>  
                </select><br/><br/>
                <label>Nom auteur :</label><br/>
                <input type='text' name='recherche_auteur_nom' size='25' maxlength='20'"/><br/><br/>
                <label>Prenom auteur :</label><br/>
                <input type='text' name='recherche_auteur_prenom' size='25' maxlength='20'/><br/><br/>
                <label>Année de publication : </label><br/>
                <input type='number' name="recherche_annee" onblur="verif_annee(this)"/><br/><br/>

                <label>Catégorie publication :</label><br/>
                <select name="recherche_categorie">
                    <option value=""></option>
                    <option value="RI">RI : Revue Internationale</option>
                    <option value="CI">CI : Conférence Internationale</option>
                    <option value="RF">RF : Revue Française</option>
                    <option value="CF">CF : Conférence Française</option>  
                    <option value="OS">OS : Ouvrage Scientifique</option>  
                    <option value="TD">TD : Thèse de Doctorat</option>  
                    <option value="BV">BV : Brevet</option>  
                    <option value="AP">AP : Autre Production</option>  
                </select><br/><br/>

                <input type='submit' name="bouton"/>
                <input type='reset' value='Annuler'/>
            </form>
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
            <p class="nom">Créé par : AVARGUES Matthieu & VYAS Kévin</p>


            <ul class="templateworld">
                <li>Design by : </li>
                <li><a href="http://www.templateworld.com" target="_blank">Template World</a></li>
            </ul>
        </div>
    </div>
</body>
</html>