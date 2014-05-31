<?php
	session_start(); 
	if(empty($_SESSION)){ 
		header('location:Accueil.php'); 
	}

	$repInclude = './include/';
	 include ('include/top.php');
    $vis_matri_session = $_SESSION['id'];
    $nom_session = $_SESSION['nom']; 
?>
<html>
	<head>
		<title>formulaire RAPPORT_VISITE</title>
		<link href="boostrap.css" rel="stylesheet" type="text/css" />
		<meta charset="utf-8" />
		
	</head>


	<body>
		<?php 
			$vist = $_SESSION['id']; 
			include('include/connexionBase.php');
		?>
		<div class="container">
			<div class="row">
				<div class="col-md-3">
			<?php 
				include('include/menuVertical.php');
			?>
			</div>
				<div class="col-md-9" class="form col-md-12 center-block" >
					<div class="well bs-component">
						<div class="thumbnail">
							<h2>Rapport de visite</h2>
						</div>
						<form name="formRAPPORT_VISITE" method="post" action="formRAPPORT_VISITE.php">
							<legend>Rapport &agrave; s&eacute;lectionner :</legend>
							<div>
								
								<select name="lstmnt"  class="form-control" style="max-width:300px;float:left;" >
									<option>Choisir la date du rendez-vous</option>
									<?php 
										$req3 = $bdd->query("SELECT RAP_NUM as numRapport, SUBSTRING(RAP_DATE,1,10) as dateRapport  
												FROM rapport_visite WHERE VIS_MATRICULE = '".$vist."'");
												while ($donnees3 = $req3-> fetch()){?>
									<option value="<?php echo $donnees3['numRapport']; ?>"
											<?php if ((isset($_POST['lstmnt'])) && ($donnees3['dateRapport']==$_POST['lstmnt'])) { ?> selected='selected'<?php } ?> >
											<?php 	if ($donnees3['numRapport']>=10){
														echo $donnees3['numRapport']."  &nbsp; &nbsp; : &nbsp;&nbsp;   ".$donnees3['dateRapport'];
													}else{
														echo $donnees3['numRapport']."  &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp; ".$donnees3['dateRapport'];
													}
												}?>
									</option> 
								</select>
								<input type='submit' value='Valider' style="margin-top:8px;"></td>
							</div>
							<br/><br/>
						<?php 
						if(isset($_POST['lstmnt'])) {
							$rapport =$_POST['lstmnt'];
							$req = $bdd->query("SELECT * FROM rapport_visite WHERE RAP_NUM='".$rapport."'");
							$donnees = $req-> fetch();
							$praticien = $donnees['PRA_NUM'];
									
							$req2 = $bdd->query("SELECT * FROM praticien WHERE PRA_NUM = '".$praticien."'");
							$donnees2 = $req2-> fetch();
							$nomPraticien = $donnees2['PRA_NOM']." ".$donnees2['PRA_PRENOM'];			
						?>
							<div class="corpsForm">
									<legend>Informations</legend>
									<label>NUMERO :</label>
										<input type="text" size="10" name="RAP_NUM" 
										value="<?php echo $rapport; ?>" class="form-control" style="max-width:80px;"  readonly/><br/>
									<label>PRATICIEN :</label>
										<input type="text" size="25" name="RAP_NUM" class="form-control" style="max-width:300px;"  
										readonly value="<?php echo $nomPraticien; ?>" />
									<br/>
									<label>BILAN :</label><br/>
										<textarea rows="5" cols="50" name="MED_EFFETS" class="form-control" style="max-width:600px;" 
										readonly ><?php echo $donnees['RAP_BILAN']; ?></textarea>
									<br/>
									<label>MOTIF :</label><br/>
										<textarea rows="5" cols="50" name="MED_EFFETS" class="form-control" style="max-width:600px;" 
										readonly ><?php echo $donnees['RAP_MOTIF']; ?></textarea>
								
									<legend>Echantillons Ouvert</legend>
									<?php 
										$req4 = $bdd->query("SELECT * FROM offrir WHERE VIS_MATRICULE = '".$vist."' AND RAP_NUM= '".$rapport."'");
										while ($donnees4 = $req4-> fetch()){
										$medicament = $donnees4['MED_DEPOTLEGAL'];
										$quantite = $donnees4['OFF_QTE'];
									?>
									<label class="titre" >PRODUIT : </label><br/>
										<input type="text" size="10" name="RAP_NUM" style="max-width:150px;float:left" 
										value="<?php echo $medicament; ?>" class="form-control" readonly />
										<input type="text" size="5" name="RAP_NUM" style="max-width:150px;" 
										value="<?php echo $quantite; ?>" class="form-control" readonly />
									<br/><br/>
									<?php 
										}
									?>
								
							</div>
							<?php
							}
							?>
						</form>
					</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>