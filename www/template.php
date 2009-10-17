<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" version="-//W3C//DTD XHTML 1.1//EN" xml:lang="fr_FR" xsi:schemaLocation="http://www.w3.org/MarkUp/SCHEMA/xhtml11.xsd">
<head>
	<link href="design/style.css" media="screen" rel="Stylesheet" type="text/css" />
	<link href="highslide/highslide.css" media="screen" rel="Stylesheet" type="text/css" />
	<script type="text/javascript" src="highslide/highslide.js"></script>
	<script type="text/javascript" src="highslide/highslide.cfg.js"></script>
	<link rel="alternate" title="Flux rss" type="application/rss+xml" href="rss.php" />
	<title><?php echo $titre_site; ?></title>
</head>
<body>
	<h1><?php echo $titre_site; ?></h1>

	<form action="#" method="post" enctype="multipart/form-data">
	<div>
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $taille_max_upload; ?>" />
		<p>
			<label for="file_input">Fichier à envoyer (taille maximale <?php echo $taille_max_upload/1048576; ?> Mio):</label><br />
			<input type="file" name="file" id="file_input" /><br />
		</p>
		<p>
			<label for="message_input">Message:</label><br />
			<textarea name="message" id="message_input" rows="3" cols="10"></textarea>
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
<?php foreach($fichiers_vus as $id => $fichier)
{
$nouveau = $fichier["timestamp"] + $delai_nouveaute > time();	
?>
		<li class="<?php if($nouveau) echo 'nouveau'; elseif ($id % 2 == 0) echo 'rouge'; else echo 'noir';?>" >
			<a href="<?php echo $stockage , $fichier["chemin"]; ?>">
				<img src="icons/<?php echo get_icone($fichier["type"]); ?>.png" alt="" />
				<span style="font-weight: bold;"><?php echo $fichier["nom"]; ?></span><?php if (!empty($fichier["message"])) echo " - " . $fichier["message"]; ?>
			</a>
			
			<span class="date"><?php echo strftime($date_format, $fichier["timestamp"]); ?></span>
			<span class="mimetype"><?php echo $fichier["type"]; ?></span>
<?php if (strpos($fichier["type"], "image") !== FALSE)
{ 
	list($sha1sum,$ext) = explode(".", $fichier["chemin"]);
?>
			<span class="thumbnail"><a href="<?php echo getThumbLink($sha1sum,$ext,800,600); ?>" class="highslide" rel="highslide">Aperçu</a></span>
<?php } ?>
	</li>
<?php } ?>
	</ul>

	
<?php

if ($pagination)
{
	function afficherPage($num_page, $texte)
	{
		echo "<a href=\"?page=$num_page#liste_fichiers\">$texte</a> ";
	}
	
	echo '<p id="pagination">Pages:<br/>';

	$direction = $pagination['directions']['precedent'];
	if ($direction !== false)
	{
		++$direction;
		afficherPage($direction, 'Précedent');
	}

	$koin = -1;
	++$page;

	foreach ($pagination['pages'] as $id => $pagin)
	{
		if ($koin !== $pagin - 1)
		{
			echo '…';
		}

		++$pagin;

		if ($pagin === $page)
		{
			echo "<strong>";
			afficherPage($pagin, $pagin);
			echo "</strong>";
		} else {
			afficherPage($pagin, $pagin);
		}
		
		--$pagin;

		$koin = $pagin;
	}

	$direction = $pagination['directions']['suivant'];
	if ($direction !== false)
	{
		++$direction;
		afficherPage($direction, 'Suivant');
	}
	
	echo '</p>';

	}
?>

<p id="footer">
<?php echo $disclamer; ?>
</p>

</body>
</html>
