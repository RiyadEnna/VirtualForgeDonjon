<?php 
$connexion = getConnexionBD();  // CONNEXION A LA BDD 


$requeteCarte = "SELECT COUNT(nomCarte) AS nbS FROM Carte";
$resultat_Carte = mysqli_query($connexion, $requeteCarte);
if($resultat_Carte == FALSE) {
	$message = "Aucune Carte n'a été trouvée !";
}
else {
	$row = mysqli_fetch_assoc($resultat_Carte);
	$message = $row['nbS'];
}


$requete_Crea = "SELECT COUNT(Id_Etre) AS nbC FROM Monstre";
$resultat_Crea = mysqli_query($connexion, $requete_Crea);

if($resultat_Crea == FALSE) {
	$message2 = "Aucune Créature n'a été trouvée !";
}
else {
	$row = mysqli_fetch_assoc($resultat_Crea);
	$message2 = $row['nbC'];
}


$requete_PNJ = "SELECT COUNT(Id_Etre) AS nbP FROM PNJ";
$resuluta_PNJ= mysqli_query($connexion, $requete_PNJ);
if($resuluta_PNJ == FALSE) {
	$message3 = "Aucun PNJ n'a été trouvée !";
}
else {
	$row = mysqli_fetch_assoc($resuluta_PNJ);
	$message3 = $row['nbP'];
}

$requete_Piege = "SELECT COUNT(Id_Elements_fixes ) AS nbPi FROM Piege";
$resulta_Piege = mysqli_query($connexion, $requete_Piege);
if($resulta_Piege == FALSE) {
	$message4 = "aucun pièges trouvé mais faites attention quand même un accident est si vite arrivé!";
}
else {
	$row = mysqli_fetch_assoc($resulta_Piege);
	$message4 = $row['nbPi'];
}
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
			<div id=stat>
			<h2>Liste des contributrices et leur cartes :</h2>
            <ul>   
            <?php
                //nombre de cartes générées par contributrice
				
				$requete_Contributrice = "SELECT COUNT(*) AS NB, Id_Contributrice, nom,prenom FROM Carte GROUP BY nom,prenom, Id_Contributrice";
				$resultat_Contributrice = mysqli_query($connexion, $requete_Contributrice);
				$message1=" ";

				if($resultat_Contributrice == FALSE) {
					$message1 = " Quoi rien n'a été forgé ! Au travail !!! ";
				}
				else {
						foreach($resultat_Contributrice as $resultat_Contributrice ) {
							 $nom=$resultat_Contributrice['nom'];
								echo $nom." ";
								$prenom=$resultat_Contributrice['prenom'];
								echo $prenom." ";
								$id=$resultat_Contributrice['Id_Contributrice']; ?>
								, Identifiant : <?=$id ?> <?php
								$Nb=$resultat_Contributrice['NB']; ?>
								, Nombre carte forgée: <?=$Nb ?> <br> <?php
							} 
				}
            ?>
			</ul>
			
			<div><?= $message1 ?></div>
			</div>	

			<div class="container-text">Actuelement <span class="orange"><?= $message ?></span> cartes ont été forgés. <br>Avec  <span class="orange"><?= $message2 ?></span> creatures au total, ainsi que <span class="orange"><?= $message3 ?></span> PNJ,<br> et pour finir <span class="orange"><?= $message4 ?></span> Piéges alors faites attention ! <br> Tout ce monde est disponible dans differents environements présent dans cette liste :</div>
				
            <ul>   
            <?php
                //liste des environement
            
				$requete_Enviro = "SELECT nom FROM Environnement";
				$resulta_Enviro = mysqli_query($connexion, $requete_Enviro);
				
				if($resulta_Enviro== FALSE) {
					$message5 = " Aucun environement trouvé !!! ";
				}
				else {	
					while($row=mysqli_fetch_assoc($resulta_Enviro)){
						$message5= '<li>'.$row['nom'].'</li>';
						echo $message5;
					}

				}
            ?>
            </ul>

            <form method="post"> 
            	
				<label for="option">Afficher le detail de :</label>
				<select name="option" id="option">
					<option value="creature">Créatures</option>
				  	<option value="piege">Piège</option>
				  	<option value="mobilier">Mobilier</option>
				</select>
				<input type="submit" name="submit" value="afficher">

            </form>
            <?php
            	if(isset($_POST['option'])){
					$option = htmlspecialchars($_POST['option']);
					echo $option;
			?>
            <table>
            	<?php 
            		if($option == "creature"){

            			?>
            	<tr>
				    <th>ID</th>
				    <th>Climat</th>
				    <th>Difficulté</th>
				    <th>Environement</th>
				</tr>

            			<?php
						$requete_Crea = "SELECT * FROM Monstre";
						$resultat_Crea = mysqli_query($connexion, $requete_Crea);		
						while($row=mysqli_fetch_assoc($resultat_Crea)){
            	?>
            	<tr><?php foreach ($row as $var) {
            		?>
            		<td>
            			<?php echo $var; ?>
            		</td>
            		<?php
            		}
            		?>
            	</tr>
            	<?php
            		}
            	}
            	?>


            	<?php 
            		if($option == "piege"){

            			?>
            	<tr>
				    <th>ID</th>
				    <th>Categorie</th>
				    <th>Detecter</th>
				    <th>Esquiver</th>
				    <th>Desamorcer</th>
				    <th>Zone Effet</th>
				</tr>

            			<?php
						$requete_Crea = "SELECT * FROM Piege";
						$resultat_Crea = mysqli_query($connexion, $requete_Crea);		
						while($row=mysqli_fetch_assoc($resultat_Crea)){
            	?>
            	<tr><?php foreach ($row as $var) {
            		?>
            		<td>
            			<?php echo $var; ?>
            		</td>
            		<?php
            		}
            		?>
            	</tr>
            	<?php
            		}
            	}
            	?>


            	<?php 
            		if($option == "mobilier"){

            			?>
            	<tr>
				    <th>ID</th>
				    <th>Deplacable</th>
				    <th>Dimensions</th>
				</tr>

            			<?php
						$requete_Crea = "SELECT * FROM Mobilier";
						$resultat_Crea = mysqli_query($connexion, $requete_Crea);		
						while($row=mysqli_fetch_assoc($resultat_Crea)){
            	?>
            	<tr><?php foreach ($row as $var) {
            		?>
            		<td>
            			<?php echo $var; ?>
            		</td>
            		<?php
            		}
            		?>
            	</tr>
            	<?php
            		}
            	}
            	?>
            </table>
            <?php
        	}
            ?>
		</main>
</body>
<?php  include('static/footer.php'); ?>
</html>