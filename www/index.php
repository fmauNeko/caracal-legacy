<?php

include("config.php");
include("bordel.php");

$fichiers = array(array("nom" => "Salut", "nouveau" => true, "type" => "image"),
				  array("nom" => "Coucou"),
				  array("nom" => "Héhé"),
				  array("nom" => "Koinkoin", "type" => "image"),
				  array("nom" => "Ou pas", "type" => "image"),
				  array("nom" => "Test")
			);

# Fonction trop bien reprise de jyraphe
$taille_max_upload = jyraphe_get_max_upload_size();

include("template.php");

?>
