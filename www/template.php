<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
	"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" version="-//W3C//DTD XHTML 1.1//EN" xml:lang="fr_FR" xsi:schemaLocation="http://www.w3.org/MarkUp/SCHEMA/xhtml11.xsd">
<head>
	<link href="style.css" media="screen" rel="Stylesheet" type="text/css" />
	<title><?php echo $titre_site; ?></title>
</head>
<body>
	<h1><?php echo $titre_site; ?></h1>

	<form action="#" method="post" enctype="multipart/form-data">
	<div>
		<label for="file">Fichier à envoyer:</label><br />
		<input type="file" name="file" /><br />
		<input type="submit" value="Envoyer"/>
	</div>
	</form>
	<h2>Liste des fichiers envoyés</h2>
	<ul id="liste_fichiers">
<?php foreach($fichiers as $id => $fichier) { ?>
		<li class="<?php if ($id % 2 == 0) echo 'rouge'; else echo 'noir';?>" >
			Fichier au nom de <?php echo $fichier["nom"]; ?>

		</li>
<?php } ?>
	</ul>
</body>
</html>

