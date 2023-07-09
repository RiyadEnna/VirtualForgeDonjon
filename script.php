<?php

	function connect_bdd($db){
		$connexion = mysqli_connect('localhost', 'p1702710', 'easing', $db);
		if (mysqli_connect_errno()) {
			printf("Échec de la connexion : %s\n", mysqli_connect_error());
			exit();
		}
		return $connexion;
	}

	function close_bdd($db){
		close_bdd($db);
	}

	$dataset = connect_bdd('dataset');
	$bdd = connect_bdd('p1702710');

	$result = mysqli_query($dataset,'SELECT * FROM dataset.DonneesFournies');
	if($result==FALSE) {
		printf("<p>ERROR.</p>");
	}
	else{
		while($row=mysqli_fetch_assoc($result)){
			$type = $row['type'];
			$type = utf8_encode($type);
			if($type == "créature"){
				$id = $row['id'];
				$nom = $row['nom'];
				$nom=str_replace("'","\'",$nom);
				
				$attribut = $row['attributs'];
				$attribut = str_replace(", ","&",$attribut);
				$attribut = utf8_encode($attribut);
				parse_str($attribut);
		
				$catégorie=utf8_decode($catégorie);

				$insert_etre = mysqli_query($bdd, "INSERT INTO p1702710.Etre(nom,categorie,pieces,pt_attaque,pt_vie) VALUES ('". "$nom" . "','". $catégorie . "','" . $pieces . "','" . $attaque . "','" . $vie . "')");
			
				$resultEtre= mysqli_query($bdd, "SELECT Id_Etre,nom FROM p1702710.Etre WHERE nom='".$nom . "'");	
				$resultEnviro= mysqli_query($bdd, "SELECT Id_Environnement,nom FROM p1702710.Environnement WHERE nom='".$environnement ."'");
			
				
				$InsertEnvironnement=mysqli_query($bdd, "INSERT INTO p1702710.Environnement(nom) VALUES (\"$environnement\") WHERE NOT EXISTS (SELECT 1 FROM p1702710.Environnement WHERE nom = \"$environnement\")");
				$resultE = mysqli_query($bdd, "SELECT 1 FROM p1702710.Environnement  WHERE nom = \"$environnement\" ");
				if ($resultE==NULL)
					echo mysqli_error($bdd);
				if ($resultE != NULL && mysqli_num_rows($resultE) == 0){
					 mysqli_query($bdd, "INSERT INTO p1702710.Environnement(nom) VALUES (\"$environnement\")");
					echo $environnement."<br>";
				}
				


				while($row=mysqli_fetch_assoc($resultEtre)){
					$Id_Environnement;
					while($enviro=mysqli_fetch_assoc($resultEnviro)){
						$Id_Environnement=$enviro['Id_Environnement'];	
					}
				$id_Etre=$row['Id_Etre'];
			
				$insert_Créature= mysqli_query($bdd, "INSERT INTO p1702710.Creature(Id_Etre,climat,difficulte,Id_Environnement)VALUES('" . $id_Etre . "','" . $climat . "','" . $difficulté . "','" . $Id_Environnement . "')");						
				
				} 
			$nom=str_replace("\'","'",$nom);
			$nom=utf8_encode($nom);
			}


			if($type == "piège" || $type=='mobilier'){
				$nom = $row['nom'];
				$nom=str_replace("'","\'",$nom);
			
				$attribut = $row['attributs'];
				$attribut = str_replace(", ","&",$attribut);
				$attribut = utf8_encode($attribut);
				parse_str($attribut);
		
				
				//$requeteDimension=mysqli_query($bdd,"SELECT dimension_X FROM p1702710.Mobilier")
				//$result="SELECT dimension_X FROM p1702710.Piege WHILE $row=mysqli_fetch_array($requeteDimension)")
				
				
					$insert_Elements= mysqli_query($bdd, "INSERT INTO p1702710.Elements_fixes(nom,type,image) VALUES ('" . $nom . "','" . $type . "','" . $image .  "')");	  
					$resultElement_Fixe= mysqli_query($bdd, "SELECT Id_Elements_fixes,type,nom FROM p1702710.Elements_fixes WHERE nom='".$nom . "'");
					
					while($row=mysqli_fetch_assoc($resultElement_Fixe)){
						$id=$row['Id_Elements_fixes'];
					  	if($row['type'] == "piège"){
						//	echo $zone."<br>";
							$dimPiege= explode('x',$zone);
							$dim_X=$dimPiege[0];
						
							$dimP=explode('\ ',$dim_X);
							$dim_Y=$dimP[0];
							
							$insert_Piege= mysqli_query($bdd, "INSERT INTO p1702710.Piege(Id_Elements_fixes,categorie,detecter,esquiver,desamorcer,zone_effet_X,zone_effet_Y)
											VALUES('" . $id . "','" . $catégorie . "','" . $detecter . "','" . $esquiver . "','" . $desamorcer . "','" . $dim_X . "','".$dim_Y."')");	
						
					}
						else if($row['type'] == "mobilier"){
							parse_str($attribut);
							$dimension= explode('x',$dimensions);
							$dimension_X=$dimension[0];
							$dimension_Y=$dimension[1];
				
							$insert_Mobilier= mysqli_query($bdd, "INSERT INTO p1702710.Mobilier(Id_Elements_fixes,deplacable,dimension_X,dimension_Y) VALUES ('" .$id. "','" . $deplacable . "','" . $dimension_X . "','".$dimension_Y."')");
						}
					}
				}
		}
	}
	


	close_bdd('dataset');
	close_bdd($bdd);

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>



</body>
</html>