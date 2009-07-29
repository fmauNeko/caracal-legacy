<?php

include("config.php");
include("bordel.php");

$fichiers = get_fichiers();

?>
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0">
	<channel>
		<title><?php echo $titre_site_court; ?></title>
		<description><?php echo $titre_site; ?></description>
		<link><?php echo $url_site; ?></link>

<?php foreach($fichiers as $id => $fichier) {
$url = 	$url_site . $stockage . $fichier["chemin"];
?>
		<item>
			<title><?php echo $fichier["nom"]; ?></title>
			<pubDate><?php echo date(DATE_RSS, $fichier["timestamp"]); ?></pubDate>
			<description>Fichier &lt;a href="<?php echo $url;?>"&gt;<?php echo $fichier["nom"]; ?>&lt;/a&gt;</description>
			<link><?php echo $url; ?></link>
			<guid><?php echo $url; ?></guid>
		</item>
<?php } ?>
	</channel>
</rss>
