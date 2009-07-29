<?php

/**
 * transforms a php.ini string representing a value in an integer
 * @param $value the value from php.ini
 * @returns an integer for this value
 */
function jyraphe_ini_to_bytes($value) {
  $modifier = substr($value, -1);
  $bytes = substr($value, 0, -1);
  switch(strtoupper($modifier)) {
  case 'P':
    $bytes *= 1024;
  case 'T':
    $bytes *= 1024;
  case 'G':
    $bytes *= 1024;
  case 'M':
    $bytes *= 1024;
  case 'K':
    $bytes *= 1024;
  default:
    break;
  }
  return $bytes;
}

/**
 * gets the maximum upload size according to php.ini
 * @returns the maximum upload size
 */
function jyraphe_get_max_upload_size() {
  return min(jyraphe_ini_to_bytes(ini_get('post_max_size')), jyraphe_ini_to_bytes(ini_get('upload_max_filesize')));
}

# Fonction pour enregistrer la liste

function get_fichiers() {

	global $fichier_liste;

	if (!file_exists($fichier_liste))
	{
		if (!file_put_contents($fichier_liste, '[]'))
		{
			echo "Impossible de créer la liste";
			exit();
		}
	}

	# Récupération la liste
	$liste = file_get_contents($fichier_liste);

	if (!$liste)
	{
		echo "Une erreur";
		exit();
	}

	$fichiers = json_decode($liste, true); 

	return $fichiers;
}

?>
