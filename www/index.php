<?php

include("config.php");
include("bordel.php");

# Récupération la liste
$liste = file_get_contents('liste.json');

if (!$liste)
{
	echo "Une erreur";
	exit();
}

$fichiers = json_decode($liste, true); 

# file_put_contents('liste.json', json_encode($fichiers));

# Fonction trop bien reprise de jyraphe
$taille_max_upload = jyraphe_get_max_upload_size();

include("template.php");

?>
