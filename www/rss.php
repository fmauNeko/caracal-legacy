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
			<title><?php
if ($fichier["message"] !== "")
{
	echo $fichier["message"], ' | ';
}

echo $fichier["nom"], ' | ', $fichier["type"]
?></title>
			<pubDate><?php echo date(DATE_RSS, $fichier["timestamp"]); ?></pubDate>
			<description>
			&lt;a href="<?php echo $url_lien;?>"&gt;
				&lt;img src="<?php echo $url_icons;?>" alt="<?php echo $fichier["chemin"];?>" /&gt;
<?php
if ($fichier["message"] !== "")
{
	echo $fichier["message"], ' | ';
}

echo $fichier["nom"], ' | ', $fichier["type"];
?>
&lt;br/&gt;
<?php if (strpos($fichier["type"], "image") !== FALSE)
{ 
	list($sha1sum,$ext) = explode(".", $fichier["chemin"]);
?>
				&lt;br/&gt;
				&lt;img src="<?php echo $url_site, getThumbLink($sha1sum,$ext,800,600); ?>" alt="Aperçu" /&gt;
<?php } ?>
			&lt;/a&gt;
			</description>
			<link><?php echo $url; ?></link>
			<guid><?php echo $url; ?></guid>
		</item>
<?php } ?>
	</channel>
</rss>
