<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" version="-//W3C//DTD XHTML 1.1//EN" xml:lang="fr_FR" xsi:schemaLocation="http://www.w3.org/MarkUp/SCHEMA/xhtml11.xsd">
<head>
	<link href="design/style.css" media="screen" rel="Stylesheet" type="text/css" />
	<link rel="alternate" title="Flux rss" type="application/rss+xml" href="rss.php" />
	<title><?php echo $titre_site; ?></title>
</head>
<body>
	<h1><?php echo $titre_site; ?></h1>

	<form action="#" method="post" enctype="multipart/form-data">
	<div>
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $taille_max_upload; ?>" />
		<p>
			<label for="file">Fichier à envoyer (taille maximale <?php echo	$taille_max_upload/1048576; ?> Mio):</label><br />
			<input type="file" name="file" /><br />
		</p>
		<p>
			<label for="message">Message:</label><br />
			<textarea name="message" ></textarea>
			<input type="submit" value="Envoyer"/>
		</p>
	</div>
	</form>
<?php if (!is_empty($erreurs))
{
?>
	<h2>Erreurs</h2>
<?php foreach($erreurs as $id => $erreur)
{
?>
	<p class="erreur"><?php echo $erreur; ?></p>
<?php } } ?>
	<h2>Liste des fichiers envoyés</h2>
	<ul id="liste_fichiers">
<?php foreach($fichiers as $id => $fichier)
{
$nouveau = $fichier["timestamp"] + $delai_nouveaute > time();	
?>
		<li class="<?php if($nouveau) echo 'nouveau'; elseif ($id % 2 == 0) echo 'rouge'; else echo 'noir';?>" >
			<a href="<?php echo $stockage , $fichier["chemin"]; ?>"><img src="icons/<?php $type = preg_replace("/\//", "-", $fichier["type"]); if (file_exists("icons/$type")) echo $type; else echo "unknown";?>.png" alt="" /><?php echo $fichier["nom"]; ?>	<?php echo $fichier["message"]; ?></a><span class="date"><?php echo date(DATE_RSS, $fichier["timestamp"]); ?></span><span class="mimetype"><?php echo $fichier["type"]; ?></span>
	</li>
<?php } ?>
	</ul>
</body>
</html>

