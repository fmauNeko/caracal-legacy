<?php
# Toutes les fonctions en bordel.
# Ce n'est pas que l'on n'aime pas la programmation orienté objet, on adore ruby et C++, mais la programmation orienté objet pour un petit site est selon nous une perte de temps.

# Pageur fait maison car celui de pear est vilain (très vilain)
function mon_pager($liste = array(), $page = 0, $nb_par_page = 12, $sauts = 5)
{
	# On part du principe qu'en php, tout est référence. Même si c'est faux.
	$objets = array_slice($liste, $nb_par_page * $page, $nb_par_page);

	$nb_elements = count($liste);

	$liens = array();

	# PHP ne compile pas en optimisant, c'est beau <3
	$it = min($sauts, $nb_elements);

	for ($i = 0; $i < $it; $i++)
	{
		$liens[] = 	$i;
	}

	$dernier = end($liens) + 1;
	
	$sautes = true;

	$st = max($dernier, $nb_elements - $sauts);

	if ($st < $nb_elements)
	{
		$liens[] = 	$st;

		if ($st === $dernier)
		{
			$sautes = true;
		}

		for ($i = $st + 1; $i < $nb_elements; $i++)
		{
			$liens[] = 	$i;
		}
	}

	return array("liste"	=> $liste,
				 "sautes"	=> $sautes,
				 "liens"	=> $liens
				);
}

# Récupération de l'icône en fonction de type MIME
function get_icone($mime)
{
	$file = str_replace('/', '-', $mime);

	if (file_exists("icons/$file.png"))
	{
		return $file;
	}

	$generics = array("image", "audio", "text", "video", "package");

	foreach($generics as $id => $generic)
	{
		if (strpos($mime, $generic) !== FALSE)
		{
			return "$generic-x-generic";
		}
	}

	return "unknown";
}

# Wrapper pour la récupération du type MIME
function get_mime_type($filename)
{
	if(in_array('fileinfo', get_loaded_extensions()))
	{
		$finfo = finfo_open(FILEINFO_MIME, "magic.mime");
		$mimetype = finfo_file($finfo, $filename);
		finfo_close($finfo);
	} else {
		$mimetype = mime_content_type($filename);
	}

	return $mimetype;
}

# Gestion manuelle des erreurs, mais on s'en sert aussi pour les messages systèmes :-)
function gestion_erreurs($errno, $errstr, $errfile, $errline)
{
	global $erreurs;

	$erreurs[] = "$errstr ; fichier $errfile, ligne $errline";

}

# Coder ses propres fonctions…
function is_empty($tableau)
{
	return count($tableau) == 0;
}

function verifier_droits()
{
	if (!is_writable('.'))
	{
		trigger_error("Impossible d'écrire dans le dossier de base");
	}

	if (!is_writable('files/'))
	{
		trigger_error("Impossible d'écrire dans le dossier des fichiers");
	}
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
?>
