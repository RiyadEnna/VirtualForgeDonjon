<?php 
$connexion = getConnexionBD(); 
$message = "";

// recupération des Cartes
$requete = "SELECT DISTINCT nomCarte FROM Carte";
$carte = mysqli_query($connexion, $requete);
if($carte == FALSE) {
	$message .= "Aucune carte n'a été trouvée dans la base de données !";
}


// recupération des paramètres
$requete = "SELECT Id_PARAMÈTRES,nomParametre,valeurParamètre FROM PARAMÈTRES";
$param = mysqli_query($connexion, $requete);
if($param == FALSE) {
	$message .= "Aucune paramètre n'a été trouvée dans la base de données !";
}

// recupération des êtres 
$requete = "SELECT Id_Etre,nom,categorie,pieces,pt_attaque,pt_vie,taille
FROM Etre";
if($etre == FALSE) {
	$message .= "Aucun ếtre n'a été trouvée dans la base de données !";
}

// recupération des contributrice 
$requete = "SELECT Id_Contributrice,nom,prenom,date_inscription 
FROM CONTRIBUER";
if($etre == FALSE) {
	$message .= "Aucune contributrice n'a été trouvée dans la base de données !";
}


// recupération des pièges 
$requete = "SELECT  Id_Elements_fixes,Categorie,nb_case_zone_effet,difficulte_detect,difficulte_esquive,difficulte_desamorsage
FROM Piège";
if($element == FALSE) {
	$message .= "Aucun piège n'a été trouvée dans la base de données !";
}


// recupération des mobiliers 
$requete = "SELECT  Id_Elements_fixes,deplacable,dimensions
FROM Mobilier";
if($element == FALSE) {
	$message .= "Aucun mobilier n'a été trouvée dans la base de données !";
}



?>
