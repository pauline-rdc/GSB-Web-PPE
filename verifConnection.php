<?php 
	session_start();
	
    $vis_matri_session = $_SESSION['id'];
    $nom_session = $_SESSION['nom']; 

include('include/connexionBase.php');

echo $login = $_POST['nom'];
$mdp = $_POST['mdp'];


// Vérification des identifiants
$req = $bdd->query("SELECT * FROM visiteur WHERE VIS_NOM='$login'");
$donnees = $req->fetch();
$req2 = $bdd->query("SELECT substring(VIS_DATEEMBAUCHE,1,10) AS DATEEMBAUCHE FROM visiteur WHERE VIS_NOM='$login'");
$donnees2 = $req2->fetch();
$mdp2 = $donnees2['DATEEMBAUCHE'];

//on fait un tableau en décomposant par rapport à -
$date=explode("-",$mdp2);
$jour = $date[2];
$mois = $date[1];
$annee = $date[0];

if ($mois == '01')	$mois = 'jan';
if ($mois == '02')	$mois = 'feb';
if ($mois == '03')	$mois = 'mar';
if ($mois == '04')	$mois = 'apr';
if ($mois == '05')	$mois = 'may';
if ($mois == '06')	$mois = 'jun';
if ($mois == '07')	$mois = 'jul';
if ($mois == '08')	$mois = 'aug';
if ($mois == '09')	$mois = 'sep';
if ($mois == '10')	$mois = 'oct';
if ($mois == '11')	$mois = 'nov';
if ($mois == '12')	$mois = 'dec';
//on met au format voulu
echo $date_emb= $jour."-".$mois."-".$annee;



if ($mdp == $date_emb && $login != "" )
{ 
	session_start();
    $_SESSION['id'] = $donnees['VIS_MATRICULE'];
    $_SESSION['nom'] = $login; 
 	header('location:menuCR.php');
}
else
{
	header('location:Accueil.php');
}
?>