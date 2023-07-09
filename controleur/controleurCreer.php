<?php
$connexion = getConnexionBD();
$NomE=mysqli_query($connexion,"SELECT nom FROM Environnement ");

function randomizator($longueur_x, $longueur_y,$nb_items,$tab,$typ,$id){
    $connexion = getConnexionBD();
    if($nb_items <=0){
        return $tab;
    }else{
        while($nb_items>0){
            $randx = rand(0,$longueur_x-1);
            $randy = rand(0,$longueur_y-1);
            if($tab[$randx][$randy] == 0){
                if($typ === "creature"){
                    $tab[$randx][$randy] = "c";
                    $requete0 = "SELECT Id_Etre FROM Monstre ORDER BY rand() LIMIT $nb_items";
                    $result = mysqli_query($connexion, $requete0);
                    while ($row = mysqli_fetch_assoc($result))   {
                          $ID = $row["Id_Etre"];
                    }
                    $Ajouter = mysqli_query($connexion, "INSERT INTO p1702710.position(position_x,position_y,id_elem,id_zone,type)
                             VALUES ($randx,$randy,$ID,$id,'creature')");
                    $nb_items--;
                }
                else if($typ === "piege"){
                    $tab[$randx][$randy] = "p";
                    $requete1 = "SELECT Id_Elements_fixes FROM Piege ORDER BY rand() LIMIT $nb_items ";
                    $result = mysqli_query($connexion, $requete1);
                    while ($row = mysqli_fetch_assoc($result))   {
                         $ID = $row["Id_Elements_fixes"]; 
                    }
                    $Ajouter = mysqli_query($connexion, "INSERT INTO p1702710.position(position_x,position_y,id_elem,id_zone,type)
                             VALUES ($randx,$randy,$ID,$id,'piege')");
                    $nb_items--;
                }
                else if($typ === "mobilier"){
                    $tab[$randx][$randy] = "m";
                    $requete2 = "SELECT Id_Elements_fixes FROM Mobilier ORDER BY rand() LIMIT $nb_items";
                    $result = mysqli_query($connexion, $requete2);
                    while ($row = mysqli_fetch_assoc($result))   {
                         $ID = $row["Id_Elements_fixes"]; 
                    }
                    $Ajouter = mysqli_query($connexion, "INSERT INTO p1702710.position(position_x,position_y,id_elem,id_zone,type)
                             VALUES ($randx,$randy,$ID,$id,'mobilier')");
                    $nb_items--;
                }
                else if($typ === "pnj"){
                    $tab[$randx][$randy] = "j";
                    $requete3 = "SELECT Id_Etre FROM PNJ ORDER BY rand() LIMIT $nb_items";
                    $result = mysqli_query($connexion, $requete3);
                    while ($row = mysqli_fetch_assoc($result))   {
                         $ID = $row["Id_Etre"]; 
                    }
                    $Ajouter = mysqli_query($connexion, "INSERT INTO p1702710.position(position_x,position_y,id_elem,id_zone,type)
                             VALUES ($randx,$randy,$ID,$id,'pnj')");
                    $nb_items--;
                }
                else if($typ === "equipement"){
                    $tab[$randx][$randy] = "e";
                    $requete4 = "SELECT Id_Elements_fixes FROM Elements_fixes WHERE type='Equipement' ORDER BY rand() LIMIT $nb_items ";
                    $result = mysqli_query($connexion, $requete4);
                    while ($row = mysqli_fetch_assoc($result))   {
                          $ID = $row["Id_Elements_fixes"];
                    }
                    $Ajouter = mysqli_query($connexion, "INSERT INTO p1702710.position(position_x,position_y,id_elem,id_zone,type)
                             VALUES ($randx,$randy,$ID,$id,'equipement')");
                    $nb_items--;
                }
                else{

                }
            }
            else{

            }
        }
    }
    return $tab;
}


if(isset($_POST["VALIDER"])){
    $NomCarte=$_POST['nomCarte'];
    $resultCarte = mysqli_query($connexion,"SELECT nomCarte,Creation_date FROM Carte WHERE nomCarte=\"$NomCarte\"");
    while($row=mysqli_fetch_assoc($resultCarte)){

        $Creation_date=$row['Creation_date'];
    }
    $description = $_POST['description'];
    $LongueurX= $_POST['longueur_x'];
    $LongueurY= $_POST['longueur_y'];
    $IdE=$_POST["Environnement"];

    $MobiMin= $_POST['mobilier_min'];
    $MobiMax= $_POST['mobilier_max'];
    $CreaMin= $_POST['creature_min'];
    $CreaMax= $_POST['creature_max'];
    $PiegeMin= $_POST['trap_min'];
    $PiegeMax= $_POST['trap_max'];
    $PnjMin= $_POST['PNJ_min'];
    $PnjMax= $_POST['PNJ_max'];
    $EquipementMin=$_POST['equipement_min'];
    $EquipementMax=$_POST['equipement_max'];
    if(($MobiMin>$MobiMax  ||$CreaMin>$CreaMax|| $PiegeMin>$PiegeMax||$PnjMin>$PnjMax || $EquipementMin>$EquipementMax)){
        $MessageError="Une valeur minimum ne peut être superieur à la valeur maximal ";
        $MessageSucce="";

    }
    else{
        $MobilierRand=rand($MobiMin, $MobiMax);
        $CreaRand=rand($CreaMin, $CreaMax);
        $PiegeRand=rand($PiegeMin,$PiegeMax);
        $PnjRand=rand($PnjMin,$PnjMax);
        $EquipementRand=rand($EquipementMin,$EquipementMax);
        $Taille_Zone=($LongueurX*$LongueurY);
        if(($MobilierRand + $CreaRand + $PiegeRand + $PnjRand + $EquipementRand) > $Taille_Zone){
            $MessageError = "Zone pas assez grande pour contenir tout les elements";
        }
        else{

            $tab;
            for($i=0;$i<$LongueurX;$i++){
                for($y=0;$y<$LongueurY;$y++){
                    $tab[$i][$y] = 0;
                }
            }
            $Ajouter = mysqli_query($connexion, "INSERT INTO p1702710.Zones(descri,nbCasesLargeur,nbCasesLongueur,Id_Environnement,nomCarte,Creation_date)
                                VALUES (\"$description\",$LongueurX,$LongueurY,$IdE,\"$NomCarte\",\"$Creation_date\")");
            $id = mysqli_insert_id($connexion);
            echo $id;
            $tab = randomizator($LongueurX, $LongueurY, $MobilierRand, $tab, 'mobilier',$id);
            $tab = randomizator($LongueurX, $LongueurY, $CreaRand, $tab, 'creature',$id);
            $tab = randomizator($LongueurX, $LongueurY, $PiegeRand, $tab, 'piege',$id);
            $tab = randomizator($LongueurX, $LongueurY, $PnjRand, $tab, 'pnj',$id);
            $tab = randomizator($LongueurX, $LongueurY, $EquipementRand, $tab, 'equipement',$id);
            for($i=0;$i<$LongueurX;$i++){
                for($y=0;$y<$LongueurY;$y++){
                   // echo $tab[$i][$y];
                }
               // echo "<br>";
            }

            
            //echo $tab;
            
            $MessageError="";
            $MessageSucce="Création réussi, bravo !";
                                
            
        }

        



    }            

}
                            

?>