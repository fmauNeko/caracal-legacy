<?php

$titre_site = "Caracal, un uploader de fichiers trop bien";
$titre_site_court = "Caracal";

$url_site = 'http://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['REQUEST_URI'] . 'x'), '/') . '/';
//$url_site = "http://localhost/caracal/";

$stockage = "files/";

$fichier_liste = 'liste.json';

# Secondes avant qu'un fichier ne soit plus marqué comme nouveau
$delai_nouveaute = 1200;

# Nombre d'éléments dans le flux rss
$nb_elements_rss = 20;

# Nombre d'éléments par page
$nb_elements_par_page = 12;

# Format de la date (stfrtime)
$date_format = "%A %d %B %Y, %T";

# Liste des extensions à modifier pour éviter de compromettre le serveur
$dangerous_exts = array(".php", ".cgi", ".fcgi", ".rb", ".py", ".pl", ".sh", ".php3", ".php4", ".pht", ".phtml", ".csh");
?>
