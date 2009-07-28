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
		<label for="file">Fichier :</label><input type="file" name="file" /><br />
		<label for="viewpasswd">Mot de passe (consultation) :</label><input type="password" value="" name="viewpasswd" /><br />
		<label for="delpasswd">Mot de passe (suppression):</label><input type="password" value="" name="delpasswd" /><br />
		<label foir="counter">Auto-suppression après <input type="text" name="counter" size="3" /> vues</label><br />
	</form>
</body>
</html>

