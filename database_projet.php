<?php
define ('projet_DB_USER','root');
define ('projet_DB_PASSEWORD','');
define ('projet_DB_HOST','localhost');
define ('projet_DB_NAME','projet');

$mabase = mysqli_connect(projet_DB_HOST, projet_DB_USER, projet_DB_PASSEWORD, projet_DB_NAME) or
        die('Impossible de se connecter à MySQL :' + mysql_error());

?>