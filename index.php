<?php
session_start(); 
require('inc/constantes.php'); // vous pouvez inclure directement ce fichier de constantes (sans le if ... else précédent)
require('inc/includes.php'); // inclut le fichier avec fonctions (notamment celles du modele)
require('inc/routes.php'); // fichiers de routes

if(isset($_GET['page'])) {
	$nomPage = $_GET['page'];
	
	if(isset($routes[$nomPage])) {
		$controleur = $routes[$nomPage]['controleur'];
		$vue = $routes[$nomPage]['vue'];
		include('controleur/' . $controleur . '.php');
		include('vues/' . $vue . '.php');
	}
	else {
		include('static/accueil.php');
	}
}
else {
	include('static/accueil.php');
}

?>
