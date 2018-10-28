<?php
session_start();
?>
<html>
    <head>
        <title>Accueil</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css2.css"/>
    </head>

    <body>
        <div id="topPan">
            <div id="ImgPan"><a href="index.html"><img src="images.jpg" title="UTT" alt="UTT" width="400" height="100"/></a> </div>
            <ul id="menu">
                <li class="actuel">Accueil</li> 
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
                unset($_SESSION['login']);
                unset($_SESSION['mdp']);
                unset($_SESSION['nom']);
                unset($_SESSION['prenom']);
                unset($_SESSION['id']);
                echo("A bientôt");
            } else {
                unset($_SESSION['login']);
                unset($_SESSION['mdp']);
                unset($_SESSION['nom']);
                unset($_SESSION['prenom']);
                unset($_SESSION['connecte']);
                unset($_SESSION['id']);
                echo("A bientôt");
            }
            ?>
            <div id="bodyMiddlePan">
                <img src="banniere.jpg" width="688" height="217"/><br/><br/>
                <br/>
                <div class="titre">Institut Charles Delaunay</div><p/>
                <div class="umr">UMR CNRS 6281</div>
                <br/><br/>
                <div class="mise_en_page"><span class="tab"/>L’Institut Charles Delaunay (ICD) a été créé le 1er janvier 2006 et avait jusqu’au 31 décembre 2009 le statut de FRE (2848) obtenu en 2006 et renouvelé dans le même statut dans le cadre du contrat quadriennal 2008-2011. En parallèle l’ICD a été reconnu comme laboratoire unique de l’UTT et classé « A » dans sa globalité par le Ministère. Au 1er janvier 2010 l’ensemble des activités de l’ICD affiliées à la thématique transverse « Sciences et Technologies pour la Maitrise des Risques » (STMR) a accédé au statut d’UMR CNRS (6279). Au 1er janvier 2014, l'UMR est élargie à l'ensemble de l'ICD et porte dorénavant le numéro 6281. L’UMR ICD est rattachée à l'Institut d'Ingénierie et des Systèmes <a href="http://www.cnrs.fr/insis/">(INSIS)</a> du CNRS 
                    <br/><br/>
                    <span class="tab"/>Les recherches menées à l’ICD sont emblématiques d’un modèle d’activité scientifique particulier, que l’on rencontre dans le contexte spécifique des Universités de Technologie ; elles articulent en effet recherche fondamentale disciplinaire de haut niveau et recherche technologique finalisée par des objectifs de conception valorisables sociétalement et économiquement.
                    <br/><br/>
                    <span class="tab"/>Ces recherches peuvent être rattachées à plusieurs des défis socio-économiques (santé, qualité de vie des citoyens, ressources naturelles ; risques, aléas, sécurité des personnes, des biens et des communications) et de connaissance pluridisciplinaires (sciences et technologies innovantes autour de la matière et des matériaux ; numérique, calcul intensif et mathématiques ; sciences humaines et sociales face aux changements globaux) identifiés dans la Stratégie Nationale de Recherche et d’Innovation (SNRI) du Ministère de l’Enseignement Supérieur et de la Recherche.
                </div><br/>
            </div>
        </div>
        <br/>
        <br/>
        <div id="footermainPan">
            <div id="footerPan">
                <ul>
                    <li><a href="#">Accueil</a>| </li>
                    <li><a href="#">Connexion</a> | </li>
                    <li><a href="#">Publications</a>| </li>
                    <li><a href="#">Recherche</a> | </li>
                    <li><a href="#">Ajout</a></li>
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


