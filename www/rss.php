<?php

include("config.php");
include("functions.php");

$fichiers = get_fichiers();

?>
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0">
	<channel>
		<title><?php echo $titre_site_court; ?></title>
		<description><?php echo $titre_site; ?></description>
		<link><?php echo $url_site; ?></link>

<?php
$it = min(count($fichiers), $nb_elements_rss);

for ($i = 0; $i < $it; $i++)
{

	$fichier = $fichiers[$i];

	$url_lien	= 	$url_site . $stockage . $fichier["chemin"];
	$url_icons	= 	$url_site . "icons/" . get_icone($fichier["type"]) . ".png";
?>
		<item>
			<title><?php echo $fichier["nom"]; ?></title>
			<pubDate><?php echo date(DATE_RSS, $fichier["timestamp"]); ?></pubDate>
			<description>
			<?php echo $fichier["message"]; ?>	
			&lt;br/&gt;
			&lt;a href="<?php echo $url_lien;?>"&gt;
				&lt;img src="<?php echo $url_icons;?>" alt="<?php echo $fichier["chemin"];?>" /&gt;
				<?php echo $fichier["nom"]; ?>
			&lt;/a&gt;
			</description>
			<link><?php echo $url; ?></link>
			<guid><?php echo $url; ?></guid>
		</item>
<?php } ?>
	</channel>
</rss>
