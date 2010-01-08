<?php

include("config.php");
include("functions.php");

$erreurs = array();

set_error_handler("gestion_erreurs");

verifier_droits();

$fichiers = get_fichiers();


if(isset($_FILES['file']))
{
	
	if ($_FILES['file']['error'] === UPLOAD_ERR_OK)
	{

		$sha1sum = sha1_file($_FILES['file']['tmp_name']);
		$lol = explode(".",$_FILES['file']['name']); # PHP, c'est magique !
		$extension = "." . end($lol);
		$name = basename($_FILES['file']['name'], $extension);
		$fullname = $name . $extension;
		$mimetype = get_mime_type($_FILES['file']['tmp_name']);
		if (!$mimetype) $mimetype = $_FILES['file']['type'];

		if(in_array($extension, $dangerous_exts))
			$extension = ".txt";

		if(!move_uploaded_file($_FILES['file']['tmp_name'], $stockage . $sha1sum . $extension))
		{
			trigger_error("Le fichier " . $fullname . " n'a PAS été uploadé, veuillez réessayer");
		}

		array_unshift($fichiers, array(
			"nom"		=> $name,
			"chemin"	=> $sha1sum . $extension,
			"type"		=> $mimetype,
			"timestamp"	=> time(),
			"message"	=> htmlspecialchars(substr($_POST['message'], 0, 100),ENT_QUOTES, 'UTF-8'),
			"taille"	=> $_FILES['file']['size']
		));

		file_put_contents('liste.json', json_encode($fichiers));
	} else {
		$erreur = $_FILES['file']['error'];

		if ($erreur === UPLOAD_ERR_INI_SIZE || $erreur === UPLOAD_ERR_FORM_SIZE)
		{
			trigger_error("Ah bah si on envoi un fichier trop gros, il passe pas.");
		} elseif ($erreur === UPLOAD_ERR_PARTIAL)
		{
			trigger_error("Le fichier a été envoyé, mais pas totalement.");
		} elseif ($erreur === UPLOAD_ERR_NO_FILE)
		{
			trigger_error("Aucun fichier n'a été envoyé… …non rien.");
		} else 
		{
			trigger_error("Il y a une erreur, mais laquelle…, tenez le code: $erreur, regardez dans la doc php si vous voulez :-)");
		}
	}


	if (is_empty($erreurs))
	{
		// Pour ne pas reposter le fichier en actualisant la page
		header("Location: .");
		exit();
	}

}

# Fonction trop bien reprise de jyraphe
$taille_max_upload = jyraphe_get_max_upload_size();

$page = 0;

# Gestion de la page
if (isset($_GET["page"]))
{
	$page = (int) $_GET["page"] - 1;

	if ($page < 0)
	{
		$page = 0;
	}
}

$pagination = mon_pager(count($fichiers), $page, $nb_elements_par_page, 3);
$fichiers_vus = array_slice($fichiers, $nb_elements_par_page * $page, $nb_elements_par_page);

include("template.php");

?>
