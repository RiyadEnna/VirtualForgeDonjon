<? $connexion=getConnexionBD();

?>

<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8" />
        <title> Virtual Forge </title>
        <link href="static/CSS/style.css" rel="stylesheet" media="all" type="text/css">
        <link rel="shortcut icon"  href="static/img/logofinal.png" />
</head>
<body>
    <?php include('static/header.php'); ?>
		<?php include('static/menu.php'); ?>
		<main class="container">
		<br><br><br><br>
		<div id=créazone>
			<h2> Forgée vos zones</h2>  

			<legend>Zone</legend>
			<div id=blockzparam >
			<form method="POST"> 

				<label for="description">Saisissez une Carte</label>
			<br>
			<?php
					$connexion = getConnexionBD();
					$reqC = "SELECT nomCarte FROM Carte";
					$result_Carte = mysqli_query($connexion, $reqC);
					// Construction de la chaîne de caractères qui fait la // liste
					
					$SelecteurCarte = "<SELECT NAME='nomCarte'>";
					
					while ( $row=mysqli_fetch_assoc($result_Carte)) {
    						$nomC = $row["nomCarte"];
							$SelecteurCarte .= "<OPTION VALUE='$nomC'>$nomC</OPTION>"; //remplacer $idE par $nomZone pour avooir le nom dans le echo	
											//$Nom=$nomZone;
						}
					$SelecteurCarte .= "</SELECT>";
					?>
					<?php
						print $SelecteurCarte;
					?>
				<br>
	
				<label for="description">Saisissez une description de votre zone :</label>
					<br>
       				<textarea name="description" id="boxdescrip">une zone pleine de mystères et de trésor</textarea>
					<br>

					<label for="longueur_x">Saisir taille pour x</label> | <label for="longueur_y"> taille pour y</label>
					<br>
					<input  type="number" name="longueur_x" size="5" value="5" min="5"  max="100" pattern="[1-9]{2}" required=""> 
					x
					<input  type="number" name="longueur_y" size="5" value="5" min="5" max="100" pattern="[1-9]{2}"  required="">		
					<br>
					
					<label for="Environnement" >Saisir un Environnement</label>
					<br>
					
					<?php
					$connexion = getConnexionBD();
					$req = "SELECT Id_Environnement,nom FROM Environnement";
					$result_Zone = mysqli_query($connexion, $req);
					// Construction de la chaîne de caractères qui fait la // liste
					
					$SelecteurZone = "<SELECT NAME='Environnement'>";
				//	$SelecteurZone .= "<OPTION VALUE=1>Choisissez</OPTION>";
					while ( $row=mysqli_fetch_assoc($result_Zone)) {
							$IdE = $row["Id_Environnement"];
    						$nomZone = $row["nom"];
							$SelecteurZone .= "<OPTION VALUE='$IdE'>$nomZone</OPTION>"; //remplacer $idE par $nomZone pour avooir le nom dans le echo	
						
						}
					$SelecteurZone .= "</SELECT>";
					?>
					<?php
						print $SelecteurZone;
					?>

					<br>
					
					<label for="mobilier_min">Nombre de mobilier minimum </label> <label for="obilier_max">| maximum </label>
					<br>
					<input  type="number" size="5" name="mobilier_min" value="0" min="0" max="99"   required="">
					;
					<input  type="number" size="5" name="mobilier_max" value="1" min="1" max="100"  required="">
					
					<br>

					<label for="trap_min">Nombre de pièges minimun</label><label for="trap_max"> | maximum</label>
					<br>
					<input  type="number" name="trap_min" size="5" value="0" min="0" max="99" pattern="[1-9]{2}"  required="">
					;
					<input  type="number" name="trap_max" size="5" value="1" min="1" max="100" pattern="[1-9]{2}"  required="">
					
					<br>
					<label for="creature_min">Nombre de créature minimum</label><label for="creature_max"> | maximum</label>
					<br>
					<input  type="number" name="creature_min" size="5" value="0" min="0" max="99" pattern="[1-9]{2}"  required="">
					;
					<input  type="number" name="creature_max" size="5" value="1" min="1" max="100" pattern="[1-9]{2}"  required="">
					

					<br>
					<label for="PNJ_min">Nombre de PNJ minimum </label><label for="PNJ_max"> | maximum</label>
					<br>
					<input  type="number" name="PNJ_min" size="5" value="0" min="0" max="99" pattern="[1-9]{2}"  required="">
					;
					<input  type="number" name="PNJ_max" size="5" value="1" min="1" max="100" pattern="[1-9]{2}"  required="">
					
					<br>
					<label for="equipement_min">Nombre d'equipement minimum </label><label for="equipement_max"> | maximum</label>
					<br>
					<input  type="number" name="equipement_min" size="5" value="0" min="0" max="99" pattern="[1-9]{2}"  required="">
					;
					<input  type="number" name="equipement_max" size="5" value="1" min="1" max="100" pattern="[1-9]{2}"  required="">
					<br>
					<p><input type="submit" name="VALIDER" value="Faire chauffer la forge "></p>


			</form>	
			<?php	if(isset($_POST["VALIDER"])){
						if(isset($MessageError)){
							echo $MessageError;
						}
						if(isset($MessageError)){
							echo $MessageSucce;
						}
						$nomCarte = $_POST['nomCarte'];
						
						$res = mysqli_query($connexion,"SELECT id_Zones,nbCasesLargeur,nbCasesLongueur FROM Zones WHERE nomCarte=\"$nomCarte\"");
						while($row=mysqli_fetch_assoc($res)){
							$id_zone = $row['id_Zones'];
							$req = mysqli_query($connexion,"SELECT * FROM position WHERE id_zone=\"$id_zone\"");
							$tab;
							$LongueurX = $row['nbCasesLongueur'];
							$LongueurY = $row['nbCasesLargeur'];
				            for($i=0;$i<$LongueurX;$i++){
				                for($y=0;$y<$LongueurY;$y++){
				                    $tab[$i][$y] = [0,0];
				                }
				            }


				            while($row2=mysqli_fetch_assoc($req)){
				            	$x = $row2['position_x'];
				            	$y = $row2['position_y'];
				            	$id_elem = $row2['id_elem'];
				            	$type = $row2['type'];
				            	$tab[$x][$y] = [$type,$id_elem];

				            }
				            echo "<table class='map'>";
				            for($i=0;$i<$LongueurX;$i++){
				            	echo "<tr>";
				                for($y=0;$y<$LongueurY;$y++){
				                	echo "<td>";
				                    if($tab[$i][$y][0] === "creature"){
				                    	echo "<div class='tooltip'>";
				                    	$id_elem = $tab[$i][$y][1];
				                    	$request = "SELECT nom,categorie,pieces,pt_attaque,pt_vie,climat,difficulte FROM Etre NATURAL JOIN Monstre WHERE Id_Etre = $id_elem";
				                    	$request = mysqli_query($connexion, $request);
				                    	if($request == TRUE){
				                    		$climat;
				                    		$difficulte;
				                    		$nom;
				                    		$pieces;
				                    		$attaque;
				                    		$vie;
					                    	while($row3=mysqli_fetch_assoc($request)){
					                    		$nom = utf8_encode($row3['nom']);
					                    		$pieces	= $row3['pieces'];
					                    		$attaque = $row3['pt_attaque'];
					                    		$vie = $row3['pt_vie'];
					                    		$climat = $row3['climat'];
					                    		$difficulte = $row3['difficulte'];
					                    	}
					                    	echo "<span class='tooltiptext'><div>nom :$nom</div><div>pieces : $pieces</div><div>points d'attaque : $attaque</div><div>points de vie : $vie</div><div>climat : $climat</div><div>difficulte : $difficulte</div></span>";
				                    	}
				                    	echo "<img class='map_img' src='static/img/index.png' >";
				                   		echo "</div>";
				                    }
				                    else if($tab[$i][$y][0] === "mobilier"){
				                    	echo "<div class='tooltip'>";
				                    	$id_elem = $tab[$i][$y][1];
				                    	$request = "SELECT nom,image,deplacable FROM Elements_fixes NATURAL JOIN Mobilier WHERE Id_Elements_fixes = $id_elem";
				                    	$request = mysqli_query($connexion, $request);
				                    	$image;
				                    	if($request == TRUE){
				                    		$nom;
				                    		$deplacable;
					                    	while($row3=mysqli_fetch_assoc($request)){
					                    		$nom = utf8_encode($row3['nom']);
					                    		$image = $row3['image'];
					                    		$deplacable = $row3['deplacable'];
					                    	}
					                    	echo "<span class='tooltiptext'><div>nom : $nom</div><div>deplacable : $deplacable</div></span>";

				                    	}

				                    	if($image==NULL OR $image=="" OR $image==" "){
					                    	echo "<img class='map_img' src='static/img/mobilier.png' >";
					                    }else{
					                    	echo "<img class='map_img' src='static/img/$image'";
					                    }
					                    echo "</div>";
				                    	
				                    }
				                    else if($tab[$i][$y][0] === "piege"){
				                    	echo "<div class='tooltip'>";
				                    	$id_elem = $tab[$i][$y][1];
				                    	$request = "SELECT nom,image,categorie,detecter,esquiver,desamorcer,zone_effet_X,zone_effet_Y FROM Elements_fixes NATURAL JOIN Piege WHERE Id_Elements_fixes = $id_elem";
				                    	$request = mysqli_query($connexion, $request);
				                    	$image;
				                    	if($request == TRUE){
				                    		$nom;
				                    		$categorie;
				                    		$detecter;
				                    		$esquiver;
				                    		$desamorcer;
				                    		$zone_effet_X;
				                    		$zone_effet_Y;
				                    		while($row3=mysqli_fetch_assoc($request)){
				                    			$nom = utf8_encode($row3['nom']);
				                    			$image = $row3['image'];
				                    			$detecter = utf8_encode($row3['detecter']);
				                    			$esquiver =  utf8_encode($row3['esquiver']);
				                    			$desamorcer =  utf8_encode($row3['desamorcer']);
				                    			$zone_effet_X = $row3['zone_effet_X'];
				                    			$zone_effet_Y = $row3['zone_effet_Y'];
				                    		}
				                    		echo "<span class='tooltiptext'><div>nom : $nom</div><div>difficulte de detection : $detecter</div><div>difficulte d'esquive : $esquiver</div><div>difficulte de desamorcage : $desamorcer</div><div>zone d'effet : $zone_effet_Y x $zone_effet_Y</div></span>";
				                    	}
				                    	if($image==NULL OR $image=="" OR $image==" "){
					                    	echo "<img class='map_img' src='static/img/piege.png' >";
					                    }
					                    else{
					                    	echo "<img class='map_img' src='static/img/$image'";
					                    }
					                    echo "</div>";
				                    }
				                    else if($tab[$i][$y][0] === "pnj"){
				                    	echo "<div class='tooltip'>";
				                    	$id_elem = $tab[$i][$y][1];
				                    	$request = "SELECT nom,categorie,pieces,pt_attaque,pt_vie,metier,caractere,phrase FROM Etre NATURAL JOIN PNJ WHERE Id_Etre = $id_elem";
				                    	$request = mysqli_query($connexion, $request);
				                    	if($request == TRUE){
				                    		$nom;
				                    		$categorie;
				                    		$pieces;
				                    		$pt_attaque;
				                    		$pt_vie;
				                    		$metier;
				                    		$caractere;
				                    		$phrase;
				                    		while($row3=mysqli_fetch_assoc($request)){
				                    			$nom = utf8_encode($row3['nom']);
				                    			$categorie = utf8_encode($row3['categorie']);
				                    			$pieces = $row3['pieces'];
				                    			$pt_attaque = $row3['pt_attaque'];
				                    			$pt_vie = $row3['pt_vie'];
				                    			$metier = utf8_encode($row3['metier']);
				                    			$caractere = utf8_encode($row3['caractere']);
				                    			$phrase = utf8_encode($row3['phrase']);
				                    		}
				                    		echo "<span class='tooltiptext'><div>nom : $nom</div><div>categorie : $categorie</div><div>pieces : $pieces</div><div>points d'attaque : $pt_attaque</div><div>points de vie : $pt_vie</div><div>metier : $metier</div><div>caractere : $caractere</div><div>phrase : $phrase</div></span>";
				                    	}
				                    	echo "<img class='map_img' src='static/img/pnj.jpg' >";
				                    	echo "</div>";
				                    }
				                    else if($tab[$i][$y][0] === "equipement"){
				                    	echo "<div class='tooltip'>";
				                    	$id_elem = $tab[$i][$y][1];
				                    	$request = "SELECT nom,image,prix FROM Elements_fixes NATURAL JOIN Equipement WHERE Id_Elements_fixes = $id_elem";
				                    	$request = mysqli_query($connexion, $request);
				                    	$image;
				                    	if($request == TRUE){
				                    		$nom;
				                    		$prix;
				                    		while($row3=mysqli_fetch_assoc($request)){
				                    			$nom = $row3['nom'];
				                    			$prix = $row3['prix'];
				                    			$image = $row3['image'];
				                    		}
				                    		echo "<span class='tooltiptext'><div>nom : $nom</div><div>prix : $prix</div></span>";

				                    	}
				                    	if($image==NULL OR $image=="" OR $image==" "){
					                    	echo "<img class='map_img' src='static/img/equipement.png' >";
					                    }
					                    else{
					                    	echo "<img class='map_img' src='static/img/$image'";
					                    }
					                    echo "</div>";
				                    }
				                    else{
				                    	echo "<img class='map_img' src='static/img/grass.jpg' >";
				                    }
				                    echo "</td>";
				                }
				                echo "</tr>";
				            }
				            echo "</table>";
						}
					}
			?>
				</div>
		<br>
		<div id=blockzAjout/forgée >
			<form method="post"> 
				<label for="créezone?">ajouter une autre zone ?</label>
				<br>
				<select name="menuajoutz">
					<option  value="ajouter">OUI</option>
					<option value="nouvelleZone">NON</option>
				</select>
				<p><input type="submit" value="Forger encore une Zone !"></p>
		</div>
            
		</main>
</body>
<?php  include('static/footer.php'); ?>
</html>