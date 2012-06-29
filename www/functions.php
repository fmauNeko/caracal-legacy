<?php
# Toutes les fonctions en bordel.
# Ce n'est pas que l'on n'aime pas la programmation orienté objet, on adore ruby et C++, mais la programmation orienté objet pour un petit site est selon nous une perte de temps.
# Et la syntaxe PHP pour l'OO est particulièrement horrible.

# Pageur fait maison car celui de pear est vilain (très vilain)
function mon_pager($nb_elements = 0, $page = 0, $nb_par_page = 12, $sauts = 2)
{
	$directions = array();
	
	$nb_pages = ceil($nb_elements / $nb_par_page);

	if ($nb_pages <= 1)
	{
		return false;
	}

	if ($page >= $nb_pages)
	{
		$page = 0;
	}

	if ($page === 0)
	{
		$directions['precedent'] = false;
	} else {
		$directions['precedent'] = $page - 1 ;
	}

	if ($page < $nb_pages-1)
	{
		$directions['suivant'] = $page + 1;
	} else {
		$directions['suivant'] = false;
	}

	$pages	= array();

	$fin	= min($sauts, $page - $sauts + 1);
	$fin	= ($fin < 0) ? 0 : $fin;		
	for ($i = 0; $i < $fin; $i++) {
		$pages[] = $i;	
	}

	$debut	= max($fin,	$page - $sauts + 1);
	$fin	= min($nb_pages,	$page + $sauts);

	for ($i = $debut; $i < $fin; $i++) {
		$pages[] = $i;	
	}


	$debut = max($fin + 1,	$nb_pages - $sauts + 1);
	 
	for ($i = $debut; $i < $nb_pages; $i++) {
		$pages[] = $i;	
	}
	
	return array("pages"		=> $pages,
				 "directions"	=> $directions
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
		list($mimetype, $encoding) = explode("; charset=", finfo_file($finfo, $filename));
		finfo_close($finfo);
	} else if (function_exists('mime_content_type'))
	{
		$mimetype = mime_content_type($filename);
	} else {
		$mimetype = false;
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

	if (!is_writable('files/thumbs/'))
	{
		trigger_error("Impossible d'écrire dans le dossier des miniatures");
	}

	if (file_exists('liste.json') && !is_writable('liste.json'))
	{
		trigger_error("Impossible d'écrire dans la liste des fichiers");
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
 * Calcule les nouvelles dimensions de l'image selon les contraintes
 */
function scaleImage($x,$y,$cx,$cy)
{
	list($nx,$ny)=array($x,$y);

	if ($x>=$cx || $y>=$cx) 
	{

		if ($x>0) $rx=$cx/$x;
		if ($y>0) $ry=$cy/$y;

		if ($rx < $ry) $r = $rx;
		else $r = $ry;

		$nx=intval($x*$r);
		$ny=intval($y*$r);
	}

	return array($nx,$ny);
}

/**
 * Redimensionne l'image
 */
function resizeImage($sha1sum,$ext,$maxX,$maxY)
{
	if (!function_exists('Imagick'))
		return false;

	try {
		global $stockage;

		$thumb = new Imagick($stockage.$sha1sum.".".$ext);
	
		list($newX,$newY)=scaleImage(
			$thumb->getImageWidth(),
			$thumb->getImageHeight(),
			$maxX,
			$maxY);
	
		$thumb->thumbnailImage($newX,$newY);
		$thumb->writeImage($stockage."thumbs/".$sha1sum."_".$maxX."_".$maxY.".".$ext);
		
		return true;
	} catch (Exception $e){
		echo strip_tags($e);
		return false;
	}
		
}

/**
 * Retourne le lien vers une miniature, et la génère si besoin
 */
function getThumbLink($sha1sum,$ext,$x,$y)
{
	global $stockage;

	if(!file_exists($stockage."thumbs/".$sha1sum."_".$x."_".$y.".".$ext))
	{
		if (!resizeImage($sha1sum,$ext,$x,$y)){
			return false;
		}
	}
	
	return ($stockage."thumbs/".$sha1sum."_".$x."_".$y.".".$ext);
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

/* Fonction qui converti en unités standarts la taille d'un fichier */
function nb_bites_aux_kibis($nb_bites)
{
	static $unites = array (
		'o',
		'Kio',
		'Mio',
		'Gio',
		'Tio',
		'Pio',
		'Eio',
		'Zio',
		'Yio'
	); // On a le temps de voir venir comme ça

	// On regarde quelle unité correspond
	$u = (int)log((double)$nb_bites, 1024);

	// Si l'unité est inconnue, tout en bits
	if (isset($unites[$u]) === false)
		$u = 0;

	// Conversion en valeur à virgule
	$nb_kibis = $nb_bites/pow(1024, $u);

	return array($nb_kibis, $unites[$u], $u);

}

function detect_locale() {
	$locale = getenv('LANG');

	if ( isset( $_SERVER["HTTP_ACCEPT_LANGUAGE"] ) )
	{
	        $languages = strtolower( $_SERVER["HTTP_ACCEPT_LANGUAGE"] );
	        $language = preg_replace( "/^([^,;]*?)[,;].*$/","$1", $languages );

	        if ( $language != "" )
	        {
	                $locale = $language;
	                $locale .= "_";
	                $locale .= strtoupper($language);
	                $locale .= "UTF-8";
	        }
	}

	setlocale(LC_ALL, $locale);
}
?>
